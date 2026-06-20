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
        Schema::create('click_logs', function (Blueprint $table) {
            $table->id();
            $table->string('url'); // কোন ইউআরএল-এ ক্লিক পড়েছে
            $table->string('ip_address')->nullable(); // ভিজিটরের আইপি
            $table->string('country')->nullable()->default('Unknown'); // ভিজিটরের দেশ
            $table->string('device')->nullable(); // Mobile, Desktop, Tablet
            $table->string('browser')->nullable(); // Chrome, Firefox, Safari
            $table->string('referrer')->nullable(); // কোন সোর্স থেকে এসেছে (যেমন: Google, Facebook)
            $table->timestamps(); // এটিই আমাদের ক্লিকের সময় (Real-time time)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('click_logs');
    }
};
