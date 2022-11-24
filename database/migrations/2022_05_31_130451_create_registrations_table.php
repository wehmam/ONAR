<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("user_id");
            $table->unsignedInteger("event_id");
            $table->string("invoice")->unique();
            $table->decimal("total_price", 15, 2);
            $table->string("status_paid")->default("PENDING");
            $table->timestamp("paid_at")->nullable();
            $table->timestamp("check_in")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
}
