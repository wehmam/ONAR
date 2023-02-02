<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailSuccessPayment;
use App\Models\Event;
use App\Models\EventLabel;
use App\Models\Registration;
use App\Repository\EventRepository;
use App\Repository\PaymentRepository;
use App\Services\ActivityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IndexController extends Controller
{
    public function home() {
        $events = Event::whereNotNull("publish_at")->take(6)
            ->inRandomOrder()
            ->get();
        return view('frontend.pages.home', compact('events'));
    }

    public function profile() {
        $registers = Registration::where("user_id", \Auth::user()->id)->get();

        return view('frontend.pages.profile', compact('registers'));
    }

    public function eventList(Request $request) {
        $keyword    = $request->get("q");
        $type       = $request->get("type");
        $categories = $request->get("category");
        $price      = $request->get("p");

        $events     = Event::query();

        if($keyword) {
            $events->orWhereHas("company", function($q) use($keyword) {
                    $q->where("name", "LIKE", "%$keyword%");
                })
                ->orWhereHas("eventDetail", function($q) use($keyword) {
                    $q->where("title", "LIKE", "%$keyword%");
                });

            ActivityService::activity(null, $keyword);
        }

        if($categories) {
            $events->orWhereHas("eventLabelLists", function($q) use ($categories) {
                $q->whereIn("name", $categories);
            });
        }

        if($type) {
            if($type != "all") {
                if($type == "online") {
                    $events = $events->where("event_type", "online");
                } else {
                    $events = $events->where("event_type", "offline");
                }
            }
        }

        if($price) {
            if($price != "all") {
                if($price == "free") {
                    $events = $events->whereHas("eventDetail", function($q) {
                        $q->where("price", "=" , "0");
                    });
                } else {
                    $events = $events->whereHas("eventDetail", function($q) {
                        $q->where("price", ">" , "0");
                    });
                }
            }
        }

        $events = $events->whereNotNull("publish_at")->paginate(6);
        $categories = EventLabel::get();

        return view('frontend.pages.event-v2' , compact('events', 'categories'));
    }

    public function seeMoreAjaxEventList(Request $request) {
        $events = Event::whereNotNull("publish_at")->with(["eventDetail"])->paginate(6);
        return response()->json($events);
    }

    public function eventDetail($slug) {
        $event = Event::whereNotNull("publish_at")
            ->where("event_slug", $slug)
            ->first();

        $recomendations = ActivityService::getRecomendation($event->id, $event->event_slug);

        if(!$event) {
            alertNotify(false, "Event not exist!");
            return redirect(url("events"));
        }

        ActivityService::activity($event->event_slug);

        return view('frontend.pages.events-detail', compact('event', 'recomendations'));
    }

    public function registEvent(Request $request) {
        $event = Event::whereNotNull("publish_at")
            ->where("event_slug", $request->get("event_slug"))
            ->first();

        if(!$event) {
            alertNotify(false, "The event is no exist!");
            return redirect()
                ->back()
                ->withInput();
        }

        if(!$event->has_active) {
            alertNotify(false, "This event is not active anymore");
            return redirect()
                ->back()
                ->withInput();
        }

        $register = (new EventRepository())->registerEvent($request->all());
        if(!$register["status"]) {
            alertNotify($register["status"], $register["data"]);
            return redirect()->back();
        }

        return redirect(url("events/pay/" . $register["data"]));
    }

    public function paymentEvents($invoice) {
        $registration = Registration::where("invoice", $invoice)
            ->first();

        if(!$registration) {
            alertNotify(false, "Your Invoice doesn't exists , Please register another events!");
            return redirect(url("events"));
        }

        if($registration->user_id != Auth::user()->id) {
            alertNotify(false, "Your Invoice doesn't exists , Please register another events!");
            return redirect(url("events"));
        }
        return view('frontend.pages.payments', compact("registration"));
    }

    public function doToken(Request $request) {
        $requestToken = (new PaymentRepository())->requestSnapToken($request->all());
        if(!$requestToken["status"]) {
            return response()->json([
                "status"    => false,
                "data"      => $requestToken["data"]
            ]);
        }

        return response()->json([
            "status"    => true,
            "data"      => $requestToken["data"]
        ]);
    }

    public function doPayment($invoice , Request $request) {
        $registration = Registration::where("invoice", $invoice)
            ->first();

        if($registration) {
            $registration->dump_payment = json_encode($request->all());
            $registration->save();
        }

        return response()->json([
            "status"    => $registration ? true : false,
            "data"      => []
        ]);
    }

    public function paymentCallback(Request $request) {
        $callback = (new PaymentRepository())->paymentCallback($request);
        return response()->json($callback);
    }

    public function testEmail() {
        $register = Registration::where("invoice", "ONR2301290001")->first();

        dispatch(new SendEmailSuccessPayment("wehmam88@gmail.com",$register));

        return true;
    }
}
