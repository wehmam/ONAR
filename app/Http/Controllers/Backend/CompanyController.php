<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Repository\CompanyRepository;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view("backend.pages.company.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("backend.pages.company.form");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = (new CompanyRepository())->createOrUpdateCompany($request->all());
        return redirect(url("/backend/companies"));
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
    public function edit(Company $company)
    {
        return view("backend.pages.company.form", compact("company"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $response = (new CompanyRepository())->createOrUpdateCompany($request->all(), $company->id);
        return redirect(url("/backend/companies"));
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
     * Get Data Company for datatables.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function companyAjaxData(Request $request) {
        $companies = Company::paginate(25);
        $arrayData = collect([]);

        $companies->each(function($q) use($arrayData) {
            $arrayData->push([
                $q->name,
                $q->events->count() ?? 0,
                '<a href="'.url('/backend/companies/' . $q->id . '/edit').'" class="btn btn-sm btn-warning" target="_blank"><i class="fa fa-edit"></i> Edit</a>'
            ]);
        });
        return response()->json([
            "draw"              => $request->get("draw"),
            "recordsTotal"      => $companies->total(),
            "recordsFiltered"   => $companies->total(),
            "data"              => $arrayData->toArray()
        ]);
    }
}
