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
        Schema::table('promos', function (Blueprint $table) {
            $table->integer('start_number')->nullable()->after('is_reuse_voucher');
            $table->integer('voucher_total')->nullable()->after('start_number');
            $table->string('voucher_prefix', 25)->nullable()->after('voucher_total');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('promos', function (Blueprint $table) {
            $table->dropColumn(['start_number', 'voucher_total', 'voucher_prefix']);
        });
    }
};
