<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Event;
use App\Repository\EventRepository;
use Illuminate\Http\Request;

class EventController extends Controller
{
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
        return view("backend.pages.schedules.form", compact("companies"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = (new EventRepository())->createOrUpdateEvent($request->all());
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
        return view("backend.pages.schedules.form", compact('event', 'companies'));
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
        $response = (new EventRepository())->createOrUpdateEvent($request->all(), $event->id);
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
        $schedules = Event::paginate(25);
        $arrayData = collect([]);

        $schedules->each(function($q) use($arrayData) {
            $arrayData->push([
                $q->eventDetail->title ?? "",
                $q->eventDetail->event_location ?? "",
                $q["event_type"] == "online" ? "Online" : "Offline",
                'Rp. '.number_format($q->eventDetail->price,0,'.','.') ?? "Free",
                '<a href="'.url('/backend/events/' . $q['id'] . '/edit').'" class="btn btn-sm btn-warning" target="_blank"><i class="fa fa-edit"></i> Edit</a>'
            ]);
        });
        return response()->json([
            "draw"              => $request->get("draw"),
            "recordsTotal"      => $schedules->total(),
            "recordsFiltered"   => $schedules->total(),
            "data"              => $arrayData->toArray()
        ]);
    }
}
