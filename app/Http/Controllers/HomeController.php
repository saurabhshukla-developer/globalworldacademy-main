<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Material;
use App\Models\QuizCategory;
use App\Models\SiteSetting;

class HomeController extends Controller
{
    public function index()
    {
        $courses    = Course::active()->get();
        $materials  = Material::active()->get();
        $settings   = SiteSetting::pluck('value', 'key');
        $categories = QuizCategory::with(['activeTopics.activeQuestions'])->active()->get();
        $quizData   = $this->buildQuizData($categories);

        return view('welcome', compact('courses', 'materials', 'settings', 'quizData', 'categories'));
    }

    public function quiz()
    {
        $settings   = SiteSetting::pluck('value', 'key');
        $categories = QuizCategory::with(['activeTopics.activeQuestions'])->active()->get();
        $quizData   = $this->buildQuizData($categories);

        return view('quiz', compact('settings', 'quizData', 'categories'));
    }

    /** Build JS-ready quiz data from DB categories/topics */
    private function buildQuizData($categories): array
    {
        $out = [];
        foreach ($categories as $cat) {
            foreach ($cat->activeTopics as $topic) {
                $questions = $topic->activeQuestions;
                if ($questions->isEmpty()) continue;

                $out[$topic->slug] = [
                    'name'        => $topic->name,
                    'name_hi'     => $topic->name_hi ?? $topic->name,
                    'icon'        => $topic->icon,
                    'category'    => $cat->name,
                    'category_hi' => $cat->name_hi ?? $cat->name,
                    'color'       => $cat->color,
                    'questions'   => $questions->map(fn($q) => [
                        'q'          => $q->question,
                        'q_hi'       => $q->question_hi ?? $q->question,
                        'opts'       => $q->options,
                        'ans'        => $q->answer_index,
                        'explain'    => $q->explanation ?? '',
                        'explain_hi' => $q->explanation_hi ?? $q->explanation ?? '',
                    ])->values()->toArray(),
                ];
            }
        }
        return $out;
    }
}
