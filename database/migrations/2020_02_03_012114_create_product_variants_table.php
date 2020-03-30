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
            $table->id();
            $table->string('identifier'); // eg number plate for cars
            $table->json('details')->nullable();
            $table->string('image_path')->nullable();
            $table->unsignedBigInteger('current_tenant_id')->nullable();
            $table->unique(['identifier', 'product_id']);
            $table->json('stats')->nullable();

            $table
                ->foreignId('product_id')
                ->index()
                ->onDelete('cascade');

            $table->timestamps();
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
