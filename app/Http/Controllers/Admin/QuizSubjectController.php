<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuizSubjectController extends Controller
{
    public function index()
    {
        $subjects = QuizSubject::withCount(['topics', 'topics as questions_count' => fn ($q) => $q->has('questions')])->orderBy('sort_order')->paginate(20);

        return view('admin.quiz-subjects.index', compact('subjects'));
    }

    public function create()
    {
        return view('admin.quiz-subjects.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'name_hi' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'description_hi' => ['nullable', 'string'],
            'icon' => ['required', 'string', 'max:10'],
            'color' => ['required', 'string', 'max:20'],
            'sort_order' => ['integer', 'min:0'],
        ]);
        $data['slug'] = Str::slug($data['name'].'-'.uniqid());
        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] = $request->input('sort_order', 0);

        QuizSubject::create($data);

        return redirect()->route('admin.quiz-subjects.index')->with('success', 'Subject created!');
    }

    public function edit(QuizSubject $quizSubject)
    {
        return view('admin.quiz-subjects.edit', compact('quizSubject'));
    }

    public function update(Request $request, QuizSubject $quizSubject)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'name_hi' => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'description_hi' => ['nullable', 'string'],
            'icon' => ['required', 'string', 'max:10'],
            'color' => ['required', 'string', 'max:20'],
            'sort_order' => ['integer', 'min:0'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $request->input('sort_order', 0);

        $quizSubject->update($data);

        return redirect()->route('admin.quiz-subjects.index')->with('success', 'Subject updated!');
    }

    public function destroy(QuizSubject $quizSubject)
    {
        $quizSubject->delete();

        return back()->with('success', 'Subject deleted.');
    }

    public function toggleActive(QuizSubject $quizSubject)
    {
        $quizSubject->update(['is_active' => ! $quizSubject->is_active]);

        return back()->with('success', 'Status updated.');
    }
}
