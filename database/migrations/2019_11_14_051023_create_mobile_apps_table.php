<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMobileAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mobile_apps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('android_image')->nullable();
            $table->string('ios_image')->nullable();
            $table->string('android_url');
            $table->string('ios_url');
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
        Schema::dropIfExists('mobile_apps');
    }
}
