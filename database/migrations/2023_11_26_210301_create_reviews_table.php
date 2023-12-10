<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedTinyInteger('rating');
            $table->text('comment')->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('therapist_id')->nullable();
            $table->unsignedBigInteger('invoice_detail_id')->nullable();

            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('therapist_id')->references('id')->on('users');
            $table->foreign('invoice_detail_id')->references('id')->on('invoice_details');

        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
