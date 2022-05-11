<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('groupactivities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('staff_id');
            $table->string('programName');
            $table->string('type');
            $table->string('description');
            $table->string('location');
            $table->string('funder');
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
        Schema::dropIfExists('groupactivities');
    }
}
