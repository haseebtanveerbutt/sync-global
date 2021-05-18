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
            $table->string('shopify_shop_id')->nullable();
            $table->string('status')->nullable();
            $table->string('title')->nullable();
            $table->string('variant_sku')->nullable();
            $table->float('price')->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('vendor')->nullable();
            $table->text('description')->nullable();
            $table->string('collection')->nullable();
            $table->string('handle')->nullable();
            $table->string('tags')->nullable();
            $table->string('image')->nullable();
            $table->string('multiple_images')->nullable();
            $table->string('metafield')->nullable();
            $table->string('option_name_1')->nullable();
            $table->string('option_name_2')->nullable();
            $table->string('option_name_3')->nullable();
            $table->string('product_type')->nullable();
            $table->string('published_scope')->nullable();
            $table->string('published')->nullable();
            $table->string('variant_barcode')->nullable();
            $table->string('variant_compare_at_price')->nullable();
            $table->string('variant_fulfillment_service')->nullable();
            $table->string('variant_inventory_management')->nullable();
            $table->string('variant_inventory_policy')->nullable();
            $table->string('variant_inventory_quantity')->nullable();
            $table->string('variant_cost_per_item')->nullable();
            $table->string('variant_option1_value')->nullable();
            $table->string('variant_option2_value')->nullable();
            $table->string('variant_option3_value')->nullable();
            $table->string('variant_postion')->nullable();
            $table->string('variant_price')->nullable();
            $table->string('variant_requires_shipping')->nullable();
            $table->string('variant_taxable')->nullable();
            $table->string('variant_title')->nullable();
            $table->string('variant_weight')->nullable();
            $table->string('variant_weight_unit')->nullable();

            $table->string('template_suffix')->nullable();
            $table->text('metafields_global_title_tag')->nullable();
            $table->text('metafields_global_description_tag')->nullable();
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
