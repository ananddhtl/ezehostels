<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHostelServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hostel_services', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('hostel_id')->unsigned();
            $table->string('service');
            $table->foreign('hostel_id')->references('id')->on('hostels')->onDelete('cascade');
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
        Schema::dropIfExists('hostel_services');
    }
}
