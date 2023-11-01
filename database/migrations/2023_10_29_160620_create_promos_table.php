<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description')->nullable();
            $table->integer('discount_type')->default(0)->comment('0=>fix,1=>percentage');
            $table->double('discount_value')->default(0);
            $table->double('discount_max_value')->default(0)->comment('fix rate')->nullable();
            $table->date('active_period_start')->default(now());
            $table->date('active_period_end')->default(now());
            $table->tinyInteger('status')->default(0)->comment('0=>inactive,1=>active');
            $table->tinyInteger('is_reuse_voucher')->comment('0=>no,1=>yes');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->tinyInteger('is_deleted')->default(0);
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
        Schema::dropIfExists('promos');
    }
};
