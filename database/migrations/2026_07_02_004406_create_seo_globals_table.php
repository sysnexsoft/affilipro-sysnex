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
        Schema::create('seo_globals', function (Blueprint $table) {
            $table->id();
            $table->longText('robots_txt')->nullable();
            $table->longText('header_scripts')->nullable(); // Google Analytics / Pixel Code
            $table->longText('footer_scripts')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_globals');
    }
};
