<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Material;
use App\Models\QuizQuestion;
use App\Models\SiteSetting;

class HomeController extends Controller
{
    public function index()
    {
        $courses   = Course::active()->get();
        $materials = Material::active()->get();
        $settings  = SiteSetting::pluck('value', 'key');

        // Build quiz data for JS (grouped by topic, active questions only)
        $quizData = QuizQuestion::active()
            ->get()
            ->groupBy('topic')
            ->map(fn($qs, $topic) => [
                'name'      => QuizQuestion::topicLabel($topic),
                'icon'      => str_contains(QuizQuestion::topicLabel($topic), '🔬') ? '🔬'
                             : (str_contains(QuizQuestion::topicLabel($topic), '👶') ? '👶'
                             : (str_contains(QuizQuestion::topicLabel($topic), '🌍') ? '🌍' : '🗺️')),
                'questions' => $qs->map(fn($q) => [
                    'q'       => $q->question,
                    'opts'    => $q->options,
                    'ans'     => $q->answer_index,
                    'explain' => $q->explanation,
                ])->values(),
            ]);

        return view('welcome', compact('courses', 'materials', 'settings', 'quizData'));
    }

    public function quiz()
    {
        $settings = SiteSetting::pluck('value', 'key');

        $quizData = QuizQuestion::active()
            ->get()
            ->groupBy('topic')
            ->map(fn($qs, $topic) => [
                'name'      => QuizQuestion::topicLabel($topic),
                'icon'      => str_contains(QuizQuestion::topicLabel($topic), '🔬') ? '🔬'
                             : (str_contains(QuizQuestion::topicLabel($topic), '👶') ? '👶'
                             : (str_contains(QuizQuestion::topicLabel($topic), '🌍') ? '🌍' : '🗺️')),
                'questions' => $qs->map(fn($q) => [
                    'q'       => $q->question,
                    'opts'    => $q->options,
                    'ans'     => $q->answer_index,
                    'explain' => $q->explanation,
                ])->values(),
            ]);

        return view('quiz', compact('settings', 'quizData'));
    }
}
