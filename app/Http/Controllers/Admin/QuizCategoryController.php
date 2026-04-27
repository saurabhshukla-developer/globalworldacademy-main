<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuizCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class QuizCategoryController extends Controller
{
    public function index()
    {
        $categories = QuizCategory::withCount(['topics', 'topics as questions_count' => fn($q) => $q->has('questions')])->orderBy('sort_order')->paginate(20);
        return view('admin.quiz-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.quiz-categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'name_hi'     => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'description_hi' => ['nullable', 'string'],
            'icon'        => ['required', 'string', 'max:10'],
            'color'       => ['required', 'string', 'max:20'],
            'sort_order'  => ['integer', 'min:0'],
        ]);
        $data['slug']      = Str::slug($data['name'] . '-' . uniqid());
        $data['is_active'] = $request->boolean('is_active', true);
        $data['sort_order']= $request->input('sort_order', 0);

        QuizCategory::create($data);
        return redirect()->route('admin.quiz-categories.index')->with('success', 'Category created!');
    }

    public function edit(QuizCategory $quizCategory)
    {
        return view('admin.quiz-categories.edit', compact('quizCategory'));
    }

    public function update(Request $request, QuizCategory $quizCategory)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:100'],
            'name_hi'     => ['nullable', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'description_hi' => ['nullable', 'string'],
            'icon'        => ['required', 'string', 'max:10'],
            'color'       => ['required', 'string', 'max:20'],
            'sort_order'  => ['integer', 'min:0'],
        ]);
        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $request->input('sort_order', 0);

        $quizCategory->update($data);
        return redirect()->route('admin.quiz-categories.index')->with('success', 'Category updated!');
    }

    public function destroy(QuizCategory $quizCategory)
    {
        $quizCategory->delete();
        return back()->with('success', 'Category deleted.');
    }

    public function toggleActive(QuizCategory $quizCategory)
    {
        $quizCategory->update(['is_active' => !$quizCategory->is_active]);
        return back()->with('success', 'Status updated.');
    }
}
