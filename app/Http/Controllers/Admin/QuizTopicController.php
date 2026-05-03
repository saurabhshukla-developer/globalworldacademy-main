<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizCategory;
use App\Models\QuizTopic;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuizTopicController extends Controller
{
    public function index(Request $request)
    {
        $query = QuizTopic::with('category')->withCount('questions');
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        $topics = $query->orderBy('category_id')->orderBy('sort_order')->paginate(25);
        $categories = QuizCategory::orderBy('sort_order')->get();

        return view('admin.quiz-topics.index', compact('topics', 'categories'));
    }

    public function create()
    {
        $categories = QuizCategory::active()->get();

        return view('admin.quiz-topics.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:quiz_categories,id'],
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
        $categories = QuizCategory::orderBy('sort_order')->get();

        return view('admin.quiz-topics.edit', compact('quizTopic', 'categories'));
    }

    public function update(Request $request, QuizTopic $quizTopic)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:quiz_categories,id'],
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
