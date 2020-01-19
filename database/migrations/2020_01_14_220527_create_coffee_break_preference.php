<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoffeeBreakPreference extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coffee_break_preference', function (Blueprint $table) {
            $table->increments('id');
            $table->string('type', 255);
            $table->string('sub_type', 255);
            $table->integer('requested_by');
            $table->dateTime('requested_date');
            $table->json('details');
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
        Schema::dropIfExists('coffee_break_preference');
    }
}
