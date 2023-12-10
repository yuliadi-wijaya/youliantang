<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTherapistAvailableSlotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('therapist_available_slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('therapist_id');
            $table->unsignedBigInteger('therapist_available_time_id');
            $table->time('from');
            $table->time('to');
            $table->tinyInteger('status')->default(0)->comment('0=>inactive,1=>active');
            $table->foreign('therapist_id')->references('id')->on('users');
            $table->foreign('therapist_available_time_id')->references('id')->on('therapist_available_times');
            $table->timestamps();
            $table->tinyInteger('is_deleted')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('therapist_available_slots');
    }
}
