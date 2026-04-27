<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::orderBy('sort_order')->orderBy('id')->paginate(20);
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        Course::create($data);
        return redirect()->route('admin.courses.index')->with('success', 'Course added!');
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $this->validated($request);
        $course->update($data);
        return redirect()->route('admin.courses.index')->with('success', 'Course updated!');
    }

    public function destroy(Course $course)
    {
        $course->delete();
        return back()->with('success', 'Course deleted.');
    }

    public function toggleActive(Course $course)
    {
        $course->update(['is_active' => !$course->is_active]);
        return back()->with('success', 'Status updated.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'exam_tag'    => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'thumb_class' => ['required', 'string', 'max:20'],
            'thumb_icon'  => ['required', 'string', 'max:10'],
            'badge'       => ['nullable', 'string', 'max:50'],
            'badge_style' => ['required', 'string', 'max:30'],
            'features'    => ['required', 'string'],
            'price'       => ['required', 'numeric', 'min:0'],
            'old_price'   => ['nullable', 'numeric', 'min:0'],
            'buy_url'     => ['required', 'url'],
            'sort_order'  => ['integer', 'min:0'],
        ]);

        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = $request->input('sort_order', 0);
        // features come in as newline-separated text, convert to array
        $data['features'] = array_filter(array_map('trim', explode("\n", $data['features'])));

        return $data;
    }
}
