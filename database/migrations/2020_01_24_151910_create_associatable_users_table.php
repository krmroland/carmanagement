<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssociatableUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('associatable_users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->index();
            $table->morphs('associatable');
            $table->string('role')->nullable();
            $table->json('abilities')->nullable();
            $table->timestamps();

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->unique(
                ['user_id', 'associatable_id', 'associatable_type'],
                'user_association_unique_index'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('associatable_users');
    }
}
