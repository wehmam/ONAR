<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\EventLabel;
use App\Models\EventLabelList;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware("checkActivatedAdmin");
        $this->middleware("exceptionSuperAdmin", ["except"    => ["index", "labelsAjaxData"]]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("backend.pages.category.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.pages.category.form");
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
            "name"  => "required|unique:event_labels"
        ]);


        if($validator->fails()) {
            alertNotify(false, collect($validator->messages()->first())->implode(", "));
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        $category = new EventLabel();
        $category->name = $request->name;
        $category->save();

        alertNotify(true, "Category success to save!");
        return redirect(url("/backend/categories"));
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
    public function edit(EventLabel $category)
    {
        return view("backend.pages.category.form", compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EventLabel $category)
    {
        $validator = \Validator::make($request->all(), [
            "name"  => [
                "required",
                Rule::unique('event_labels')->ignore($category->id)
            ]
        ]);


        if($validator->fails()) {
            alertNotify(false, collect($validator->messages()->first())->implode(", "));
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        $category->name = $request->name;
        $category->save();

        alertNotify(true, "Success to update event category!");
        return redirect(url("backend/categories"));
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
    public function labelsAjaxData(Request $request) {
        $labels     = EventLabel::paginate(10);
        $arrayData  = collect([]);
        $admin      = \Sentinel::check();


        $labels->each(function($q) use($arrayData, $admin) {
            $arrayData->push([
                $q->name ?? "",
                is_null($admin->company_id) ? '<a href="'.url('/backend/categories/' . $q['id'] . '/edit').'" class="btn btn-sm btn-warning" target="_blank"><i class="fa fa-edit"></i> Edit</a>' : ""
            ]);
        });
        return response()->json([
            "draw"              => $request->get("draw"),
            "recordsTotal"      => $labels->total(),
            "recordsFiltered"   => $labels->total(),
            "data"              => $arrayData->toArray()
        ]);
    }
}
