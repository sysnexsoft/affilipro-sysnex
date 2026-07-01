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
        Schema::create('seo_management', function (Blueprint $table) {
            $table->id();
            $table->string('page_name'); // e.g., 'Home Page', 'Contact Us'
            $table->string('page_slug')->unique()->nullable(); // স্ট্যাটিক পেজের জন্য
            $table->string('model_type')->nullable(); // ডাইনামিক মডেল (যেমন: App\Models\Service)
            $table->unsignedBigInteger('model_id')->nullable();

            // Meta Content
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->string('meta_image')->nullable();

            // Advanced SEO
            $table->string('canonical_url')->nullable();
            $table->enum('meta_robots', ['index, follow', 'noindex, nofollow', 'index, nofollow'])->default('index, follow');
            $table->longText('schema_script')->nullable();
            $table->longText('datalayer_json')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_management');
    }
};
