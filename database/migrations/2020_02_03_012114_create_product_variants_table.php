<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index();
            $table->string('identifier'); // eg number plate for cars
            $table->json('details')->nullable();
            $table->string('image_path')->nullable();
            $table->unsignedBigInteger('current_user_id')->nullable();
            $table->unique(['identifier', 'product_id']);
            $table->timestamps();

            $table
                ->foreign('current_user_id')
                ->references('id')
                ->on('users')
                ->onDelete('set null');

            $table
                ->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
}
