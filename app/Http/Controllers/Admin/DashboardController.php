<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Material;
use App\Models\QuizQuestion;
use App\Models\SiteSetting;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'questions' => QuizQuestion::count(),
            'courses'   => Course::count(),
            'materials' => Material::count(),
            'settings'  => SiteSetting::count(),
        ];

        $recentQuestions = QuizQuestion::latest()->limit(5)->get();

        return view('admin.dashboard', compact('stats', 'recentQuestions'));
    }
}
