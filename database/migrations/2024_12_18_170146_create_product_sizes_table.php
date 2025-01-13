<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('product_sizes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
        $table->string('size');
        $table->integer('stock')->default(0); // Stock for each size
        $table->timestamps();
    });
}

public function down()
{
    Schema::dropIfExists('product_sizes');
}
};