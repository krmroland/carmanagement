<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariantRateHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_variant_rate_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_variant_rate_id')->index();
            $table->string('currency');
            $table->decimal('before');
            $table->decimal('current');
            $table->timestamp('starts_on');
            $table->timestamps();
            $table
                ->foreign('product_variant_rate_id')
                ->references('id')
                ->on('product_variant_rates')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('product_variant_rate_histories');
    }
}
