<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOwnerUniqueNamesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('owner_unique_names', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('value')->unique();
            $table->morphs('owner');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('owner_unique_names');
    }
}
