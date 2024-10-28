<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHostelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hostels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->bigInteger('vendor_id')->nullable();
            $table->string('image')->nullable();
            $table->text('description');
            $table->string('slug');
            $table->enum('type',['boys','girls']);
            $table->text('policies');
            $table->string('city');
            $table->string('place');
            $table->bigInteger('price')->nullable();
            $table->enum('featured',['yes','no'])->default('no');
            $table->text('iframe');
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
        Schema::dropIfExists('hostels');
    }
}
