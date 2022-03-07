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
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('subcategory_id')->nullable();
            $table->string('category_name', 255)->nullable();
            $table->string('subcategory_name', 255)->nullable();

            $table->string('product_sku')->unique()->nullable()->comment('product_unique_id');
            $table->string('product_unit')->nullable();
            $table->text('product_name')->nullable();
            $table->text('product_description')->nullable();
            $table->text('product_specification')->nullable();
            $table->text('product_thumbnail_image')->nullable();
            
            $table->float('product_unit_price', 10, 3)->default(0);
            $table->float('product_wholesale_price', 10, 3)->default(0); // paikari mullo
            $table->unsignedBigInteger('product_qty')->default(0);
            $table->unsignedBigInteger('product_discount')->default(0);

            $table->text('product_video_link')->nullable();

            $table->boolean('is_active')->default(1);
            $table->boolean('allowed_review')->default(1);
            $table->boolean('allowed_offer')->default(0);
            $table->boolean('is_best_sale')->default(0);

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('products');
    }
}
