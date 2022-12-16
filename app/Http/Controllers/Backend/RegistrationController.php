<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $company      = \Sentinel::check()->company_id;
        $status       = $request->get("status_paid");

        $participants = Registration::query();
        if(!is_null($company)) {
            $participants = $participants->whereHas("event", function($q) use($company) {
                $q->where("company_id", $company);
            });
        }

        if(!is_null($status) && $status == "paid") {
            $participants = $participants->whereNotNull("paid_at");
        }

        $participants = $participants->paginate(10);

        return view('backend.pages.registration.index', compact('participants'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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

    public function registrationAjaxData(Request $request) {
        $schedules = Registration::paginate(25);
        $arrayData = collect([]);

        $schedules->each(function($q) use($arrayData) {
            $arrayData->push([
                $q["title"],
                $q["city"],
                $q["event_online"] ? "Online" : "Offline",
                'Rp. '.number_format($q['price'],0,'.','.'),
                '<a href="'.url('/backend/events/' . $q['id'] . '/edit').'" class="btn btn-md btn-warning" target="_blank"><i class="fa fa-edit"></i> Edit</a>'
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
