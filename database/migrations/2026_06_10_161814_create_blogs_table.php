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
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->string('thumbnail')->nullable();
            $table->foreignId('category_id')->nullable();
            $table->json('product_ids')->nullable();
            $table->integer('views')->default(0);
            $table->boolean('featured')->default(false);
            $table->string('affiliate_url')->nullable();
            $table->string('affiliate_source')->nullable();
            $table->boolean('status')->default(true);

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('canonical_url')->nullable();

            $table->text('search_keywords')->nullable();
            $table->fullText('search_keywords');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
