<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->foreignId('topic_id')->after('id')
                ->constrained('quiz_topics')->cascadeOnDelete();
            $table->text('question_hi')->nullable()->after('question');
            $table->text('explanation_hi')->nullable()->after('explanation');
        });
    }

    public function down(): void
    {
        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->dropForeign(['topic_id']);
            $table->dropColumn(['topic_id', 'question_hi', 'explanation_hi']);
        });
    }
};
