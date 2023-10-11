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
            $table->enum('status', ['draft', 'trash', 'published']);
            $table->dateTime('imported_t');
            $table->text('url');
            $table->string('creator');
            $table->timestamp('created_t')->useCurrent();
            $table->timestamp('last_modified_t')->useCurrentOnUpdate();
            $table->string('product_name')->index();
            $table->string('quantity');
            $table->string('brands');
            $table->string('categories');
            $table->string('labels');
            $table->string('cities')->nullable();
            $table->string('purchase_places');
            $table->string('stores');
            $table->text('ingredients_text');
            $table->string('traces');
            $table->string('serving_size');
            $table->float('serving_quantity');
            $table->integer('nutriscore_score');
            $table->char('nutriscore_grade', 1);
            $table->string('main_category');
            $table->text('image_url');
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
