<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use Cartalyst\Sentinel\Activations\EloquentActivation as Activation;
use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthLoginController extends Controller
{
    public function index() {
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
        Sentinel::logout();
        return redirect(url('/backend'));
    }

    public function registerNewAdmin(Request $request) {
        $credentials = [
            'email'    => 'admin@gmail.com',
            'password' => 'admin',
            'first_name'     => 'Super',
            'last_name' => "Admin"
        ];

        DB::beginTransaction();
        $AdminUsers = new AdminUser();
        $AdminUsers->email = $credentials['email'];
        $AdminUsers->password = Hash::make("admin");
        $AdminUsers->first_name = $credentials['first_name'];
        $AdminUsers->last_name = $credentials['last_name'];
        $AdminUsers->save();

        $activate = new Activation();
        $activate->user_id      = $AdminUsers['id'];
        $activate->code         = md5(date("Y-m-d H:i:s"));
        $activate->completed    = 1;
        $activate->completed_at = date("Y-m-d H:i:s");
        $activate->save();

        DB::commit();
    }
}
