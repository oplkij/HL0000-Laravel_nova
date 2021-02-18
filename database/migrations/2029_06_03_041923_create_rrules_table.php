<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRrulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rrules', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('event_schedule_id');
            $table->foreign('event_schedule_id')->references('id')->on('event_schedules')->unsigned();
            $table->char('freg')->nullable();
            $table->integer('repeat_time')->nullable();
            $table->integer('count')->nullable();
            $table->char('byweekday')->nullable();
            $table->timestamp('dtstart')->nullable();
            $table->timestamp('until')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rrules');
    }
}
