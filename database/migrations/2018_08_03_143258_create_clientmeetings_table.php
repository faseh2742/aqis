<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientmeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientmeetings', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('client_id')->unsigned();
            $table->string('programName')->nullable();
            $table->string('serviceProvided')->nullable();
            $table->string('type')->nullable();
            $table->date('date')->nullable();
            $table->string('status')->nullable();
            $table->string('serviceDelivery')->nullable();
            $table->string('location')->nullable();
            $table->string('funder')->nullable();
            $table->integer('staff_id')->unsigned();
            $table->text('notes')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('clientmeetings');
    }
}
