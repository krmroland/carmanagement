<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_variant_rates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_variant_id')->index();
            $table->string('type')->index();
            $table->string('currency');
            $table->decimal('current_amount');
            $table->decimal('next_amount')->nullable();
            $table->timestamp('next_amount_starts_at')->nullable(); // use this to reference future amounts
            $table->string('interval')->index(); // daily weekly monthly and annually
            $table
                ->foreign('product_variant_id')
                ->references('id')
                ->on('product_variants')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variant_rates');
    }
}
