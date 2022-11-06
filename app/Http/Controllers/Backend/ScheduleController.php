<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class ScheduleController extends Controller
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
        return view("backend.pages.schedules.form");
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
            "title" => "required",
            "city" => "required",
            "event_online" => "required",
            "event_status" => "required",
            "price" => "required",
            "event_date" => "required",
            "start" => "required",
            "end" => "required",
            "description" => "required",
            "max_capacity" => "required",
            "event_link" => "required_if:event_type,==,online",
            "upload_image" => "image|mimes:jpeg,png,jpg,gif,svg|max:2048"
        ]);

        if($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        $schedules = new Schedule();
        $schedules->title = $request->get("title");
        $schedules->city  = $request->get("city");
        $schedules->event_online = $request->get("event_online");
        $schedules->event_status = $request->get("event_status");
        $schedules->price = $request->get("price");
        $schedules->event_date = $request->get("event_date");
        $schedules->start_hour = $request->get("start");
        $schedules->end_hour = $request->get("end");
        $schedules->description = $request->get("description");
        $schedules->max_capacity = $request->get("max_capacity");
        $schedules->event_link = $request->get("event_link");
        $schedules->image =  Storage::putFile("public/images/schedules", $request->file("upload_image"));
        $schedules->current_capacity = 0;
        $schedules->save();

        return redirect(url("/backend/schedules"));
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
    public function edit(Schedule $schedule)
    {
        return view("backend.pages.schedules.form", compact('schedule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        $validator = \Validator::make($request->all(), [
            "title" => "required",
            "city" => "required",
            "event_online" => "required",
            "event_status" => "required",
            "price" => "required",
            "event_date" => "required",
            "start" => "required",
            "end" => "required",
            "description" => "required",
            "max_capacity" => "required",
            "event_link" => "required_if:event_type,==,online",
        ]);

        if($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        // dd($request->all(), $request->hasFile('upload_image'));
        // dd($request->file("upload_image"));
        if($request->hasFile("upload_image")) {
            $validator = \Validator::make($request->all(), [
                "upload_image" => "image|mimes:jpeg,png,jpg,gif,svg|max:2048"
            ]);

            if($validator->fails()) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors($validator);
            }

            Storage::delete($schedule->image);
            $schedule->image =  Storage::putFile("public/images/schedules", $request->file("upload_image"));
        }

        $schedule->title = $request->get("title");
        $schedule->city  = $request->get("city");
        $schedule->event_online = $request->get("event_online");
        $schedule->event_status = $request->get("event_status");
        $schedule->price = $request->get("price");
        $schedule->event_date = $request->get("event_date");
        $schedule->start_hour = $request->get("start");
        $schedule->end_hour = $request->get("end");
        $schedule->description = $request->get("description");
        $schedule->max_capacity = $request->get("max_capacity");
        $schedule->event_link = $request->get("event_link");
        $schedule->save();

        return redirect(url("/backend/schedules"));
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
     * Get Data Schedules for datatables.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function schedulesAjaxData(Request $request) {
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
