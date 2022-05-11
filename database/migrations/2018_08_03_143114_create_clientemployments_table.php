<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientemploymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientemployments', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('client_id')->unsigned();
            $table->integer('noc')->nullable();
            $table->string('job_title')->nullable();
            $table->string('field')->nullable();
            $table->integer('experience_years')->nullable();
            $table->string('country')->nullable();
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('clientemployments');
    }
}
