<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizQuestion;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $query = QuizQuestion::query();
        if ($request->filled('topic')) {
            $query->where('topic', $request->topic);
        }
        $questions = $query->orderBy('topic')->orderBy('sort_order')->paginate(20);
        return view('admin.quiz.index', compact('questions'));
    }

    public function create()
    {
        return view('admin.quiz.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'topic'        => ['required', 'in:science,child_dev,gk,mp'],
            'question'     => ['required', 'string'],
            'options'      => ['required', 'array', 'size:4'],
            'options.*'    => ['required', 'string', 'max:255'],
            'answer_index' => ['required', 'integer', 'between:0,3'],
            'explanation'  => ['nullable', 'string'],
            'sort_order'   => ['integer', 'min:0'],
            'is_active'    => ['boolean'],
        ]);

        $data['is_active']  = $request->boolean('is_active', true);
        $data['sort_order'] = $request->input('sort_order', 0);

        QuizQuestion::create($data);

        return redirect()->route('admin.quiz.index')
            ->with('success', 'Question added successfully!');
    }

    public function edit(QuizQuestion $quiz)
    {
        return view('admin.quiz.edit', compact('quiz'));
    }

    public function update(Request $request, QuizQuestion $quiz)
    {
        $data = $request->validate([
            'topic'        => ['required', 'in:science,child_dev,gk,mp'],
            'question'     => ['required', 'string'],
            'options'      => ['required', 'array', 'size:4'],
            'options.*'    => ['required', 'string', 'max:255'],
            'answer_index' => ['required', 'integer', 'between:0,3'],
            'explanation'  => ['nullable', 'string'],
            'sort_order'   => ['integer', 'min:0'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $quiz->update($data);

        return redirect()->route('admin.quiz.index')
            ->with('success', 'Question updated successfully!');
    }

    public function destroy(QuizQuestion $quiz)
    {
        $quiz->delete();
        return back()->with('success', 'Question deleted.');
    }

    public function toggleActive(QuizQuestion $quiz)
    {
        $quiz->update(['is_active' => !$quiz->is_active]);
        return back()->with('success', 'Status updated.');
    }
}
