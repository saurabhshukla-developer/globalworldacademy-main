<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizSubject;
use App\Models\QuizTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuizTopicController extends Controller
{
    public function index(Request $request)
    {
        $query = QuizTopic::with('subject')->withCount('questions');
        if ($request->filled('subject_id')) {
            $query->where('subject_id', $request->subject_id);
        }
        $topics = $query->orderBy('subject_id')->orderBy('sort_order')->paginate(25);
        $subjects = QuizSubject::orderBy('sort_order')->get();

        return view('admin.quiz-topics.index', compact('topics', 'subjects'));
    }

    public function create()
    {
        $subjects = QuizSubject::active()->get();

        return view('admin.quiz-topics.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'subject_id' => ['required', 'exists:quiz_subjects,id'],
            'name' => ['required', 'string', 'max:150'],
            'name_hi' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'icon' => ['required', 'string', 'max:10'],
            'sort_order' => ['integer', 'min:0'],
        ]);
        $data['slug'] = Str::slug($data['name'].'-'.uniqid());
        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] = $request->input('sort_order', 0);

        QuizTopic::create($data);

        return redirect()->route('admin.quiz-topics.index')->with('success', 'Topic created!');
    }

    public function edit(QuizTopic $quizTopic)
    {
        $subjects = QuizSubject::orderBy('sort_order')->get();

        return view('admin.quiz-topics.edit', compact('quizTopic', 'subjects'));
    }

    public function update(Request $request, QuizTopic $quizTopic)
    {
        $data = $request->validate([
            'subject_id' => ['required', 'exists:quiz_subjects,id'],
            'name' => ['required', 'string', 'max:150'],
            'name_hi' => ['nullable', 'string', 'max:150'],
            'description' => ['nullable', 'string'],
            'icon' => ['required', 'string', 'max:10'],
            'sort_order' => ['integer', 'min:0'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $request->input('sort_order', 0);

        $quizTopic->update($data);

        return redirect()->route('admin.quiz-topics.index')->with('success', 'Topic updated!');
    }

    public function destroy(QuizTopic $quizTopic)
    {
        $quizTopic->delete();

        return back()->with('success', 'Topic deleted.');
    }

    public function toggleActive(QuizTopic $quizTopic)
    {
        $quizTopic->update(['is_active' => ! $quizTopic->is_active]);

        return back()->with('success', 'Status updated.');
    }
}
