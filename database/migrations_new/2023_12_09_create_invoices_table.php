<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_code', 20)->nullable();
            $table->char('invoice_type', 2)->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('therapist_name')->nullable();
            $table->string('room')->nullable();
            $table->string('payment_mode');
            $table->string('payment_status');
            $table->date('treatment_date');
            $table->time('treatment_time_from')->nullable();
            $table->time('treatment_time_to')->nullable();
            $table->string('note')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0=>inactive,1=>active');
            $table->timestamps();
            $table->tinyInteger('is_deleted')->default(0);
            $table->char('old_data', 1)->default('N')->comment('Y=>Yes, N=>No');
            $table->tinyInteger('is_member')->nullable();
            $table->tinyInteger('use_member')->nullable();
            $table->string('member_plan')->nullable();
            $table->string('voucher_code')->nullable();
            $table->double('total_price')->nullable();
            $table->double('discount')->nullable();
            $table->double('grand_total')->nullable();

            $table->primary('id');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('customer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
