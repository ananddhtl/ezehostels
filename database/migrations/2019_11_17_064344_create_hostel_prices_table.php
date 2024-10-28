<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHostelPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hostel_prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('hostel_id')->unsigned();
            $table->string('room_type');
            $table->integer('available_room')->nullable();
            $table->string('pricing');
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
        Schema::dropIfExists('hostel_prices');
    }
}
