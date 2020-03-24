<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTenantsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->id('id');
            $table->foreignId('account_id')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->unique(['email', 'user_id']);
            $table->unique(['phone_number', 'user_id']);
            $table->bigInteger('total_dues')->default(0);
            $table->unsignedBigInteger('current_product_variant_id')->nullable();

            $table
                ->foreignId('user_id')
                ->nullable()
                ->onDelete('set null');

            $table
                ->foreign('current_product_variant_id')
                ->references('id')
                ->on('product_variants')
                ->onDelete('set null');

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tenants');
    }
}
