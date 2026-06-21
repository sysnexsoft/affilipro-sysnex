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
            $table->id();
            $table->json('category_ids')->nullable();
            $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('sku')->nullable();
            $table->longText('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->longText('pros')->nullable();
            $table->longText('cons')->nullable();
            $table->string('featured_image')->nullable();
            $table->string('gallery')->nullable();
            // Pricing
            $table->decimal('regular_price',12,2)->nullable();
            $table->decimal('sale_price',12,2)->nullable();
            $table->string('coupon')->nullable();
            $table->decimal('rating',3,2)->default(0);
            $table->integer('review_count')->default(0);
            $table->integer('view_count')->default(0);
            $table->integer('click_count')->default(0);
            // Affiliate

            $table->string('affiliate_url')->nullable();
            $table->string('affiliate_network')->nullable();
            $table->decimal('commission_rate',8,2)->nullable();
            // Comparison

            $table->boolean('allow_compare')->default(true);
            // Featured
            $table->boolean('featured')->default(false);
            $table->boolean('trending')->default(false);
            $table->boolean('best_seller')->default(false);
            $table->boolean('editors_choice')->default(false);
            $table->boolean('status')->default(true);
            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();
            $table->timestamps();
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
