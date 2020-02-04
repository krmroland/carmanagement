<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->index();
            $table->morphs('owner'); //could be organization or user
            $table->string('currency');
            $table->json('details')->nullable();
            $table->string('image_path')->nullable();
            $table->string('identifier')->nullable(); // eg number plate for cars
            $table->unsignedBigInteger('current_user_id')->nullable();

            $table->unique(['identifier', 'owner_type', 'owner_id']);

            $table
                ->decimal('total_cost')
                ->unsigned()
                ->nullable();

            $table->string('type');
            $table->timestamps();

            $table
                ->foreign('current_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
