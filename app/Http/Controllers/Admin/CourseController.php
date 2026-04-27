<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $data = $this->validateData($request);
        $data['image_path'] = $this->handleImageUpload($request);
        Course::create($data);
        return redirect()->route('admin.courses.index')->with('success', 'Course added!');
    }

    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('image')) {
            $course->deleteImage(); // Remove old image
            $data['image_path'] = $this->handleImageUpload($request);
        }

        if ($request->boolean('remove_image')) {
            $course->deleteImage();
            $data['image_path'] = null;
        }

        $course->update($data);
        return redirect()->route('admin.courses.index')->with('success', 'Course updated!');
    }

    public function destroy(Course $course)
    {
        $course->deleteImage();
        $course->delete();
        return back()->with('success', 'Course deleted.');
    }

    public function toggleActive(Course $course)
    {
        $course->update(['is_active' => !$course->is_active]);
        return back()->with('success', 'Status updated.');
    }

    private function handleImageUpload(Request $request): ?string
    {
        if ($request->hasFile('image')) {
            return $request->file('image')->store('courses', 'public');
        }
        return null;
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'exam_tag'    => ['required', 'string', 'max:100'],
            'description' => ['required', 'string'],
            'thumb_class' => ['required', 'string', 'max:20'],
            'thumb_icon'  => ['required', 'string', 'max:10'],
            'image'       => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
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
        $data['features']   = array_values(array_filter(array_map('trim', explode("\n", $data['features']))));
        unset($data['image']); // handled separately

        return $data;
    }
}
