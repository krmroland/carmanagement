<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('account_id')->onDelete('cascade');
            $table->string('name')->index();
            $table->string('currency');
            $table->json('details')->nullable();
            $table->unsignedBigInteger('total_cost')->default(0);
            $table->decimal('total_dues')->default(0);
            $table->decimal('total_collections')->default(0);
            $table->string('type');

            $table
                ->foreignId('user_id')
                ->nullable()
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
