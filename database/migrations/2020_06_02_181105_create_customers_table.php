<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('age');
            $table->string('place_of_birth', 50)->nullable();
            $table->date('birth_date')->nullable();
            $table->enum('gender', ['Male', 'Female']);
            $table->text('address')->nullable();
            $table->string('emergency_contact', 20)->nullable();
            $table->string('emergency_name', 100)->nullable();
            $table->tinyInteger('status')->default(0)->comment('0=>active,1=>inactive');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('customers');
    }
}
