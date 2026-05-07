<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('featured_post_categories', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->integer('position')->default(0);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('featured_post_categories');
    }
};
