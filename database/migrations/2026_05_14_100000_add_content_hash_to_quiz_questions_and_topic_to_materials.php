<?php

use App\Models\QuizQuestion;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->string('content_hash', 64)->nullable()->after('answer_index');
            $table->index('content_hash');
        });

        foreach (DB::table('quiz_questions')->orderBy('id')->cursor() as $row) {
            $options = json_decode($row->options, true);
            if (! is_array($options)) {
                $options = [];
            }
            $hash = QuizQuestion::contentHashFrom((string) $row->question, $options, (int) $row->answer_index);
            DB::table('quiz_questions')->where('id', $row->id)->update(['content_hash' => $hash]);
        }

        Schema::table('materials', function (Blueprint $table) {
            $table->foreignId('topic_id')->nullable()->after('id')->constrained('quiz_topics')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropForeign(['topic_id']);
            $table->dropColumn('topic_id');
        });

        Schema::table('quiz_questions', function (Blueprint $table) {
            $table->dropIndex(['content_hash']);
            $table->dropColumn('content_hash');
        });
    }
};
