<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("admin_users")->insert([
            [
                "email"         => "admin@gmail.com",
                "password"      => '$2y$10$V.E2.gEMCMMDvcBvc8uvUuvGJS1IPoPOHOFfZnCvgeugToEVZ2QRG',
                "last_login"    => "2022-01-10 04:00:24",
                "first_name"    => "Super",
                "last_name"     => "Admin",
            ]
        ]);
        DB::table("activations")->insert([
            [
                "user_id"       => 1,
                "code"          => md5(date("Y-m-d H:i:s")),
                "completed"     => 1,
                "completed_at"  => date("Y-m-d H:i:s")
            ]
        ]);
    }
}
