<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClienteducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clienteducations', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('client_id')->unsigned();
            $table->string('education_level');
            $table->string('major')->nullable();
            $table->date('graduation_date')->nullable();
            $table->string('education_country')->nullable();
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
        Schema::dropIfExists('clienteducations');
    }
}
