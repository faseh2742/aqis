<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('user_id')->unsigned();
            $table->integer('wc_id')->unique();
            $table->string('immigrationStatus')->nullable();
            $table->date('dob')->nullable();
            $table->date('doa')->nullable();
            $table->string('gender')->nullable();
            $table->string('streetAddress')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postalCode')->nullable();
            $table->string('phonePrimary')->nullable();
            $table->string('phoneSecondary')->nullable();
            $table->string('motherTongue')->nullable();
            $table->string('countryOrigin')->nullable();
            $table->string('engProficiency')->nullable();
            $table->boolean('interpreterNeeded')->default(0)->nullable();
            $table->string('interpreterLanguage')->nullable();
            $table->boolean('childcareNeeded')->default(0)->nullable();
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
        Schema::dropIfExists('clients');
    }
}
