<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\InvoiceSettings;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_setting', function (Blueprint $table) {
            $table->id();
            $table->char('invoice_type', 3);
            $table->timestamps();
        });

        InvoiceSettings::create([
            "invoice_type" => "ALL",
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_setting');
    }
};
