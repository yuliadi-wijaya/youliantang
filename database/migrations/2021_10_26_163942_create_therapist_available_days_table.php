<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTherapistAvailableDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('therapist_available_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('therapist_id');
            $table->tinyInteger('sun')->default(0)->comment('0=>not available,1=>available');
            $table->tinyInteger('mon')->default(0)->comment('0=>not available,1=>available');
            $table->tinyInteger('tue')->default(0)->comment('0=>not available,1=>available');
            $table->tinyInteger('wen')->default(0)->comment('0=>not available,1=>available');
            $table->tinyInteger('thu')->default(0)->comment('0=>not available,1=>available');
            $table->tinyInteger('fri')->default(0)->comment('0=>not available,1=>available');
            $table->tinyInteger('sat')->default(0)->comment('0=>not available,1=>available');
            $table->foreign('therapist_id')->references('id')->on('users');
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
        Schema::dropIfExists('therapist_available_days');
    }
}
