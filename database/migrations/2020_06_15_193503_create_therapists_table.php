<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTherapistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('therapists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('ktp', 16)->nullable();;
            $table->enum('gender', ['Male', 'Female']);
            $table->string('place_of_birth', 50)->nullable();
            $table->date('birth_date')->nullable();
            $table->text('address')->nullable();
            $table->string('rekening_number', 20)->nullable();
            $table->string('emergency_contact', 20)->nullable();
            $table->string('emergency_name', 100)->nullable();
            $table->integer('slot_time')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=>inactive,1=>active');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->tinyInteger('is_deleted')->default(0);
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('therapists');
    }
}
