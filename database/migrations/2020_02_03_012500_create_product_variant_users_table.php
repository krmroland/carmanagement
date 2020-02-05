<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductVariantUsersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('product_variant_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_variant_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamp('accepted_at')->nullable();
            $table->decimal('due_amount')->nullable();
            $table->decimal('paid_amount')->nullable();

            $table->unique(['product_variant_id', 'user_id']);

            $table
                ->foreign('product_variant_id')
                ->references('id')
                ->on('product_variants')
                ->onDelete('cascade');
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('product_variant_users');
    }
}
