<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string("event_number")->default("");
            $table->unsignedInteger("company_id");
            $table->string("event_type");
            $table->boolean("has_active");
            $table->timestamp("publish_at")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

    Schema::create('event_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger("event_id");
            $table->string("title");
            $table->string("link_event")->nullable();
            $table->decimal('price', 15, 2)->default(0);
            $table->date("event_date");
            $table->time("start_hour");
            $table->time("end_hour");
            $table->integer("max_capacity");
            $table->string("google_calendar_id")->default("");
            $table->string("banner")->nullable();
            $table->string("event_location")->nullable();
            $table->text("description")->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("event_list_labels", function(Blueprint $table) {
            $table->id();
            $table->unsignedInteger("event_id");
            $table->string("name");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("event_labels", function(Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create("event_categories", function(Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("slug");
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
        Schema::dropIfExists('events');
        Schema::dropIfExists('event_details');
        Schema::dropIfExists('event_list_labels');
        Schema::dropIfExists('event_labels');
        Schema::dropIfExists('event_categories');
    }
}
