<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantUserRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_user_rates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_variants_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('rate_id')->index();
            $table->unsignedBigInteger('current_rate_discount')->nullable();
            $table->unique(['product_variants_id', 'user_id', 'rate_id'])->index();
            $table->timestamps();
            $table
                ->foreign('product_variants_id')
                ->references('id')
                ->on('product_variantss')
                ->onDelete('cascade');

            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table
                ->foreign('rate_id')
                ->references('id')
                ->on('product_variants_rates')
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
        Schema::dropIfExists('product_user_rates');
    }
}
