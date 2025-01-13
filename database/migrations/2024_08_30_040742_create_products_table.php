<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name'); // The name of the product
            $table->text('description'); // Detailed information about the product
            $table->decimal('price', 8, 2); // The product's price with precision 8 and scale 2
            $table->integer('stock'); // The quantity available in stock
            $table->timestamps(); // Adds created_at and updated_at columns for record-keeping
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
