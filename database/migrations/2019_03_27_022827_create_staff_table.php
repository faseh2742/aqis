<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->string('phonePrimary')->nullable();
            $table->string('phoneEmerg')->nullable();
            $table->string('position')->nullable();
            $table->string('gender')->nullable();
            $table->string('streetAddress')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postalCode')->nullable();
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
        Schema::dropIfExists('staff');
    }
}
