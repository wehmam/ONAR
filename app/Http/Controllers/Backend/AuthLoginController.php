<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\Company;
use Cartalyst\Sentinel\Activations\EloquentActivation as Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;


class AuthLoginController extends Controller
{
    public function index() {
        if(\Sentinel::check()) {
            return redirect(url("backend"));
        }
        return view("backend.pages.login");
    }

    public function loginPost(Request $request) {
        $auth = [
            'email'     => $request->get('email'),
            'password'  => $request->get('password')
        ];

        $user = Sentinel::authenticate($auth);
        if(!$user) {
            return redirect(url('backend/login'));
        }
        return redirect(url('/backend'));
    }

    public function logout(){
        if(\Sentinel::check()) {
            Sentinel::logout();
        }
        return redirect(url('/backend'));
    }

    public function registerNewAdmin(Request $request) {
        $validator = \Validator::make($request->all(), [
            "name"                  => ["required"],
            "email"                 => ["required","unique:admin_users"],
            "company_name"          => ["required", "unique:companies,name"],
            "password"              => ["required", "confirmed", Rules\Password::defaults()],
            "password_confirmation" => "required_with:password|same:password"
        ]);

        if($validator->fails()) {
            return redirect()->back()
                ->withInput()
                ->withErrors($validator);
        }

        $credentials = [
            'email'      => $request->get("email"),
            'password'   => Hash::make($request->get("password")),
            'first_name' => $request->get("name"),
        ];

        DB::beginTransaction();

        $company       = new Company();
        $company->name = $request->get("company_name");
        $company->save();

        $AdminUsers             = new AdminUser();
        $AdminUsers->company_id = $company->id;
        $AdminUsers->email      = $credentials['email'];
        $AdminUsers->password   = $credentials["password"];
        $AdminUsers->first_name = $credentials['first_name'];
        $AdminUsers->last_name  = "- " . $company->name;
        $AdminUsers->save();

        $activate               = new Activation();
        $activate->user_id      = $AdminUsers['id'];
        $activate->code         = md5(date("Y-m-d H:i:s"));
        $activate->completed    = 1;
        // $activate->completed_at = date("Y-m-d H:i:s");
        $activate->save();


        DB::commit();

        alertNotify(true, "Berhasil Register sebagai creator, silakan login");
        return redirect(url('backend/login'));
    }
}
