<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Repository\CompanyRepository;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware("checkActivatedAdmin", ["except"    => ["edit", "update"]]);
        $this->middleware("checkSuperAdmin", ["except"    => ["index", "edit", "update", "companyAjaxData"]]);
    }
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
        $validator = \Validator::make($request->all(), [
            "name"  => "required|unique:companies",
            "description"   => "required",
            "address"       => "required",
            "phone_number"  => "required",
            "upload_image"  => "required"
        ]);

        if($validator->fails()) {
            alertNotify(false, collect($validator->messages()->first())->implode(", "));
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        $response = (new CompanyRepository())->createOrUpdateCompany($request->all());
        alertNotify($response["status"], $response["data"]);

        if(!$response["status"]) {
            return redirect()->back()
                ->withInput();
        }

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
        $validator = \Validator::make($request->all(), [
            "name"  => ["required", Rule::unique("companies")->ignore($company->id)],
            "description"   => "required",
            "address"       => "required",
            "phone_number"  => "required",
        ]);

        if($validator->fails()) {
            alertNotify(false, collect($validator->messages()->first())->implode(", "));
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        $response = (new CompanyRepository())->createOrUpdateCompany($request->all(), $company->id);
        alertNotify($response["status"], $response["data"]);

        if(!$response["status"]) {
            return redirect()->back()
                ->withInput();
        }
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
        $admin     = \Sentinel::check();

        $companies->each(function($q) use($arrayData, $admin) {

            $text = "";
            if(is_null($admin["company_id"])) {
                $text = '<a href="'.url('/backend/companies/' . $q->id . '/edit').'" class="btn btn-sm btn-warning" target="_blank"><i class="fa fa-edit"></i> Edit</a>';
            }

            if($admin["company_id"] == $q->id) {
                $text = '<a href="'.url('/backend/companies/' . $q->id . '/edit').'" class="btn btn-sm btn-warning" target="_blank"><i class="fa fa-edit"></i> Edit</a>' ;
            }

            $arrayData->push([
                $q->name,
                $q->events->count() ?? 0,
                $text
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
