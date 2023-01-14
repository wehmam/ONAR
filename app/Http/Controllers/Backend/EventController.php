<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Event;
use App\Models\EventLabel;
use App\Repository\EventRepository;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware("checkActivatedAdmin");
        $this->middleware("exceptionSuperAdmin", ["except"    => ["index", "eventsAjaxData", "eventsPublish"]]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("backend.pages.schedules.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::get();
        $labels    = EventLabel::get();
        return view("backend.pages.schedules.form", compact("companies", "labels"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            // "company_id"    => "required",
            "event_type"    => "required",
            "has_active"    => "required|boolean",
            "title"         => "required",
            "price"         => "required",
            "event_date"    => "required",
            "start_hour"    => "required",
            "end_hour"      => "required",
            "upload_image"  => "image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            "event_link"    => "required_if:event_type,==,online",
            "event_location" => "required",
            "description" => "required",
            "max_capacity" => "required",
            "event_link" => "required_if:event_type,==,online",
            "upload_image" => "image|mimes:jpeg,png,jpg,gif,svg|max:2048"
        ]);

        if($validator->fails()) {
            alertNotify(false, collect($validator->messages()->first())->implode(", "));
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        $response = (new EventRepository())->createOrUpdateEvent($request->all());
        if(!$response["status"]) {
            alertNotify(false, $response["data"]);
            return redirect()->back()
                ->withInput();
        }

        alertNotify(true, $response["data"]);
        return redirect(url("/backend/events"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        $companies = Company::get();
        $labels    = EventLabel::get();
        return view("backend.pages.schedules.form", compact('event', 'companies', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $validator = \Validator::make($request->all(), [
            "company_id"    => "required",
            "event_type"    => "required",
            "has_active"    => "required|boolean",
            "title"         => "required",
            "price"         => "required",
            "event_date"    => "required",
            "start_hour"    => "required",
            "end_hour"      => "required",
            "upload_image"  => "image|mimes:jpeg,png,jpg,gif,svg|max:2048",
            "event_link"    => "required_if:event_type,==,online",
            "event_location" => "required",
            "description" => "required",
            "max_capacity" => "required",
            "event_link" => "required_if:event_type,==,online",
            "event_label"   => "required|array"
        ]);

        if($validator->fails()) {
            alertNotify(false, collect($validator->messages()->first())->implode(", "));
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        if($request->hasFile("upload_image")) {
            $validator = \Validator::make($request->all(), [
                "upload_image" => "image|mimes:jpeg,png,jpg,gif,svg|max:2048"
            ]);

            alertNotify(false, collect($validator->messages()->first())->implode(", "));
            if($validator->fails()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors($validator);
            }
        }

        $response = (new EventRepository())->createOrUpdateEvent($request->all(), $event->id);
        alertNotify($response["status"], $response["data"]);
        if(!$response["status"]) {
            return redirect()->back()
                ->withInput();
        }
        return redirect(url("/backend/events"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Get Data Event for datatables.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eventsAjaxData(Request $request) {
        $superAdmin = true ;
        if(!is_null(\Sentinel::check()->company_id)) {
            $superAdmin = false;
        }

        $schedules = Event::query();
        if(!$superAdmin) {
            $schedules = Event::where("company_id", \Sentinel::check()->company_id);
        }
        $schedules = $schedules
            ->orderByDesc("id")
            ->paginate(25);

        $arrayData = collect([]);

        $schedules->each(function($q) use($arrayData) {
            $arrayData->push([
                $q->eventDetail->title ?? "",
                $q->company->name ?? "",
                $q->eventDetail->event_location ?? "",
                $q["event_type"] == "online" ? "Online" : "Offline",
                'Rp. '.number_format($q->eventDetail->price,0,'.','.') ?? "Free",
                is_null(\Sentinel::check()->company_id) && is_null($q["publish_at"]) ? '<a href="'.url('/backend/events/' . $q['id'] . '/publish').'" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> Publish Events</a>' : (!is_null($q->publish_at) ? '<span class="badge badge-pill badge-info">Publish</span>' : '<span class="badge badge-pill badge-info">Pending</span>')
            ]);
        });
        return response()->json([
            "draw"              => $request->get("draw"),
            "recordsTotal"      => $schedules->total(),
            "recordsFiltered"   => $schedules->total(),
            "data"              => $arrayData->toArray()
        ]);
    }

    public function eventsPublish($id) {
        $event = Event::findOrFail($id);
        $event->publish_at = now();
        $event->save();

        alertNotify(true, "Sukses publish event " . $event->eventDetail->title);
        return redirect()->back();
    }
}
