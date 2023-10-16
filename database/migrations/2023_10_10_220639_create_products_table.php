<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('code')->index();
            $table->enum('status', ['draft', 'trash', 'published'])->nullable();
            $table->date('imported_t');
            $table->text('url')->nullable();
            $table->string('creator')->nullable();
            $table->timestamp('created_t')->useCurrent()->nullable();
            $table->timestamp('last_modified_t')->useCurrentOnUpdate()->nullable();
            $table->string('product_name')->index()->nullable();
            $table->string('quantity')->nullable();
            $table->string('brands')->nullable();
            $table->text('categories')->nullable();
            $table->string('labels')->nullable();
            $table->string('cities')->nullable()->nullable();
            $table->string('purchase_places')->nullable();
            $table->string('stores')->nullable();
            $table->text('ingredients_text')->nullable();
            $table->string('traces')->nullable();
            $table->string('serving_size')->nullable();
            $table->double('serving_quantity')->nullable();
            $table->integer('nutriscore_score')->nullable();
            $table->char('nutriscore_grade', 1)->nullable();
            $table->string('main_category')->nullable();
            $table->text('image_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
