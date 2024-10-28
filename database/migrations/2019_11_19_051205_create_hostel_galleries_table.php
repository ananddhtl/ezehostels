<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHostelGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hostel_galleries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('hostel_id')->unsigned();
            $table->string('image');
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
        Schema::dropIfExists('hostel_galleries');
    }
}
