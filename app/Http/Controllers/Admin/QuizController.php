<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizCategory;
use App\Models\QuizQuestion;
use App\Models\QuizTopic;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $query = QuizQuestion::with('quizTopic.category');
        if ($request->filled('topic_id')) {
            $query->where('topic_id', $request->topic_id);
        } elseif ($request->filled('category_id')) {
            $query->whereHas('topic', fn ($q) => $q->where('category_id', $request->category_id));
        }
        $questions = $query->orderBy('topic_id')->orderBy('sort_order')->paginate(20);
        $categories = QuizCategory::with('topics')->orderBy('sort_order')->get();
        $topics = QuizTopic::orderBy('sort_order')->get();

        return view('admin.quiz.index', compact('questions', 'categories', 'topics'));
    }

    public function create()
    {
        $categories = QuizCategory::with('topics')->orderBy('sort_order')->get();

        return view('admin.quiz.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'topic_id' => ['required', 'exists:quiz_topics,id'],
            'question' => ['required', 'string'],
            'question_hi' => ['nullable', 'string'],
            'options' => ['required', 'array', 'size:4'],
            'options.*' => ['required', 'string', 'max:255'],
            'answer_index' => ['required', 'integer', 'between:0,3'],
            'explanation' => ['nullable', 'string'],
            'explanation_hi' => ['nullable', 'string'],
            'sort_order' => ['integer', 'min:0'],
        ]);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order'] = $request->input('sort_order', 0);
        // Keep legacy topic string for backward compat
        $topic = QuizTopic::find($data['topic_id']);
        $data['topic'] = $topic?->slug ?? 'general';

        QuizQuestion::create($data);

        return redirect()->route('admin.quiz.index')->with('success', 'Question added!');
    }

    public function edit(QuizQuestion $quiz)
    {
        $categories = QuizCategory::with('topics')->orderBy('sort_order')->get();

        return view('admin.quiz.edit', compact('quiz', 'categories'));
    }

    public function update(Request $request, QuizQuestion $quiz)
    {
        $data = $request->validate([
            'topic_id' => ['required', 'exists:quiz_topics,id'],
            'question' => ['required', 'string'],
            'question_hi' => ['nullable', 'string'],
            'options' => ['required', 'array', 'size:4'],
            'options.*' => ['required', 'string', 'max:255'],
            'answer_index' => ['required', 'integer', 'between:0,3'],
            'explanation' => ['nullable', 'string'],
            'explanation_hi' => ['nullable', 'string'],
            'sort_order' => ['integer', 'min:0'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        $topic = QuizTopic::find($data['topic_id']);
        $data['topic'] = $topic?->slug ?? 'general';
        $quiz->update($data);

        return redirect()->route('admin.quiz.index')->with('success', 'Question updated!');
    }

    public function destroy(QuizQuestion $quiz)
    {
        $quiz->delete();

        return back()->with('success', 'Question deleted.');
    }

    public function toggleActive(QuizQuestion $quiz)
    {
        $quiz->update(['is_active' => ! $quiz->is_active]);

        return back()->with('success', 'Status updated.');
    }
}
