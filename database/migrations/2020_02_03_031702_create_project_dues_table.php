<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectDuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_dues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_user_rates_id')->index();
            $table->decimal('amount');
            $table->string('currency');
            $table->string('period');
            $table->timestamps();

            $table
                ->foreign('project_user_rates_id')
                ->references('id')
                ->on('project_user_rates')
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
        Schema::dropIfExists('project_dues');
    }
}
