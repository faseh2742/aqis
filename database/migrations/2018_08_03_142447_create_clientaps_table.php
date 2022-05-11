<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientaps', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->integer('client_id')->unsigned();
            $table->integer('clientmeeting_id')->unsigned();   
            $table->string('staff_id');
            $table->string('noc');
            $table->text('credAssessment')->nullable();
            $table->text('certLicense')->nullable();
            $table->text('docTranslation')->nullable();
            $table->text('training')->nullable();
            $table->text('localExperience')->nullable();
            $table->text('altCareers')->nullable();
            $table->text('mentoring')->nullable();
            $table->text('portfolioWorkshop')->nullable();
            $table->text('otherResources')->nullable();
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
        Schema::dropIfExists('clientaps');
    }
}
