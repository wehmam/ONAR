<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("schedule_type_id");
            $table->string("title");
            $table->string("city");
            $table->boolean("event_online")->default(0);
            $table->boolean("event_status")->default(1);
            $table->decimal('price', 15, 2);
            $table->date("event_date");
            $table->time("start_hour");
            $table->time("end_hour");
            $table->string("image")->default("");
            $table->text("description")->nullable();
            $table->string("google_calendar_id")->default("");
            $table->integer("max_capacity");
            $table->integer("current_capacity");
            $table->string("event_link")->nullable();
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
        Schema::dropIfExists('schedules');
    }
}
