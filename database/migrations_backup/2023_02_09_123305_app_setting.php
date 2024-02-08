<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\AppSettings;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_setting', function (Blueprint $table) {
            $table->id();
            $table->string('title', 250);
            $table->string('logo_lg', 250);
            $table->string('logo_sm', 250);
            $table->string('logo_dark_sm', 250);
            $table->string('logo_dark_lg', 250);
            $table->string('favicon', 250);
            $table->string('footer_left', 250);
            $table->string('footer_right', 250);
            $table->timestamps();
        });

        AppSettings::create([
            "title" => "You Lian tAng",
            "logo_sm" => "logo-light.png",
            "logo_lg" => "logo-light1.png",
            "logo_dark_sm" => "logo-dark.png",
            "logo_dark_lg" => "logo-dark1.png",
            "favicon" => "favicon.ico",
            "footer_left" => "You Lian tAng",
            "footer_right" => "Reflexology & Massage Therapy",
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_setting');
    }
};
