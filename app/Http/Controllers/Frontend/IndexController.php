<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Schedule;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function home() {
        $events = Event::take(6)->inRandomOrder()->get();
        return view('frontend.pages.home', compact('events'));
    }

    public function profile() {
        return view('frontend.pages.profile');
    }

    public function eventList(Request $request) {
        $keyword = $request->get("q");
        $events = Event::query();
        if($keyword) {
            $events->where("event_type", "LIKE", "%$keyword%")
                ->orWhereHas("eventLabelLists", function($q) use ($keyword) {
                    $q->where("name", "LIKE", "%$keyword%");
                })
                ->orWhereHas("company", function($q) use($keyword) {
                    $q->where("name", "LIKE", "%$keyword%");
                })
                ->orWhereHas("eventDetail", function($q) use($keyword) {
                    $q->where("title", "LIKE", "%$keyword%");
                });
        }

        $events = $events->paginate(6);
        return view('frontend.pages.events' , compact('events'));
    }

    public function seeMoreAjaxEventList(Request $request) {
        $events = Event::with(["eventDetail"])->paginate(6);
        return response()->json($events);
    }

    public function eventDetail($id) {
        $event = Event::findOrFail($id);
        return view('frontend.pages.events-detail', compact('event'));
    }

    public function paymentEvents(Request $request) {
        return view('frontend.pages.payments');
    }
}
