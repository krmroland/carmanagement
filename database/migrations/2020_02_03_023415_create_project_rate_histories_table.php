<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectRateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_rate_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_rate_id')->index();
            $table->string('currency');
            $table->decimal('before');
            $table->decimal('current');
            $table->timestamp('starts_on');
            $table->timestamps();
            $table
                ->foreign('project_rate_id')
                ->references('id')
                ->on('project_rates')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_rate_histories');
    }
}
