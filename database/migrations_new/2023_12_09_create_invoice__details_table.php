<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->string('title')->nullable();
            $table->double('amount');
            $table->tinyInteger('status')->default(1)->comment('0=>inactive,1=>active');
            $table->timestamps();
            $table->tinyInteger('is_deleted')->default(0);
            $table->unsignedBigInteger('product_id')->nullable();
            $table->time('treatment_time_from')->nullable();
            $table->time('treatment_time_to')->nullable();
            $table->string('room')->nullable();
            $table->unsignedBigInteger('therapist_id')->nullable();

            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('product_id')->references('id')->on('products');
            $table->foreign('therapist_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice__details');
    }
}
