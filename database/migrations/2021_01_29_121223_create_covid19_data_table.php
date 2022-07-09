<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCovid19DataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covid19_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("employee_name");
            $table->string("employee_id");
            $table->string("fever");
            $table->string("cough");
            $table->string("shortness_of_breath");
            $table->string("trouble_in_swallowing");
            $table->string("stuffy_nose");
            $table->string("loss_of_taste");
            $table->string("nausea_etc");
            $table->string("tiredness");
            $table->string("ppe");
            $table->string("travelled_outside");

            $table->unsignedBigInteger('user_id');
            
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onDelete('cascade');

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
        Schema::dropIfExists('covid19_data');
    }
}
