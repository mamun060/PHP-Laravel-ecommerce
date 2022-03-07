<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    
    public function up()
    {
        Schema::create('product_variant', function (Blueprint $table) {
            $table->bigInteger('product_id')->unsigned();
            $table->bigInteger('variant_id')->unsigned();
            $table->enum('variant_type',['color','size']);
            $table->primary(['product_id', 'variant_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variant');
    }
}
