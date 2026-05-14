<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('name');           // English name
            $table->string('name_hi')->nullable();  // Hindi name
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('description_hi')->nullable();
            $table->string('icon')->default('📝');
            $table->string('color')->default('#1155cc'); // hex color for UI
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_subjects');
    }
};
