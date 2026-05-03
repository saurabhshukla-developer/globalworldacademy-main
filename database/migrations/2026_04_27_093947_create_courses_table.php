<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('exam_tag');           // e.g. "MPTET Varg 2"
            $table->text('description');
            $table->string('thumb_class')->default('ct1');  // CSS gradient class
            $table->string('thumb_icon')->default('📚');
            $table->string('badge')->nullable();             // e.g. "🔥 Bestseller"
            $table->string('badge_style')->default('badge-hot'); // CSS class
            $table->json('features');                        // ["Feature 1","Feature 2"...]
            $table->decimal('price', 8, 2);
            $table->decimal('old_price', 8, 2)->nullable();
            $table->string('buy_url');
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
