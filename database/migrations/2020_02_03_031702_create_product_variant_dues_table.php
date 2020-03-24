<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariantDuesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_variant_dues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_variant_user_rates_id')->index();
            $table->decimal('amount');
            $table->string('currency');
            $table->string('period');
            $table->timestamps();

            $table
                ->foreign('product_variant_user_rates_id')
                ->references('id')
                ->on('product_variant_user_rates')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('product_variant_dues');
    }
}
