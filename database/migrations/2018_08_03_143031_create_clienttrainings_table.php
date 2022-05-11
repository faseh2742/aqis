<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienttrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clienttrainings', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('client_id')->unsigned();
            $table->string('subject')->nullable();
            $table->string('association')->nullable();
            $table->integer('training_year')->nullable();
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
        Schema::dropIfExists('clienttrainings');
    }
}
