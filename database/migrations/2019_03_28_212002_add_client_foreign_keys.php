<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddClientForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        // Schema::table('clientgoals', function ($table) {
        //     $table->foreign('client_id')->references('id')->on('clients')
        //         ->onDelete('cascade');
        // });

        // Schema::table('clientmeetings', function ($table) {
        //     $table->foreign('client_id')->references('id')->on('clients')
        //         ->onDelete('cascade');
        // });
        // Schema::table('clientmeetings', function ($table) {
        //     $table->foreign('clientaps')->references('id')->on('clientaps')
        //         ->onDelete('cascade');
        // });

        // Schema::table('clienttrainings', function ($table) {
        //     $table->foreign('client_id')->references('id')->on('clients')
        //         ->onDelete('cascade');
        // });

        // Schema::table('clientworkshops', function ($table) {
        //     $table->foreign('client_id')->references('id')->on('clients')
        //         ->onDelete('cascade');
        // });

        // Schema::table('clienteducations', function ($table) {
        //     $table->foreign('client_id')->references('id')->on('clients')
        //         ->onDelete('cascade');
        // });

        // Schema::table('clientemployments', function ($table) {
        //     $table->foreign('client_id')->references('id')->on('clients')
        //         ->onDelete('cascade');
        // });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
