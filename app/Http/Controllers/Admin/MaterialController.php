<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::orderBy('sort_order')->orderBy('id')->paginate(20);

        return view('admin.materials.index', compact('materials'));
    }

    public function create()
    {
        return view('admin.materials.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        Material::create($data);

        return redirect()->route('admin.materials.index')->with('success', 'Material added!');
    }

    public function edit(Material $material)
    {
        return view('admin.materials.edit', compact('material'));
    }

    public function update(Request $request, Material $material)
    {
        $data = $this->validated($request);
        $material->update($data);

        return redirect()->route('admin.materials.index')->with('success', 'Material updated!');
    }

    public function destroy(Material $material)
    {
        $material->delete();

        return back()->with('success', 'Material deleted.');
    }

    public function toggleActive(Material $material)
    {
        $material->update(['is_active' => ! $material->is_active]);

        return back()->with('success', 'Status updated.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon' => ['required', 'string', 'max:10'],
            'icon_bg_class' => ['required', 'string', 'max:20'],
            'tags' => ['required', 'string'],
            'external_url' => ['nullable', 'url'],
            'sort_order' => ['integer', 'min:0'],
        ]);

        $data['is_active'] = $request->boolean('is_active');
        $data['sort_order'] = $request->input('sort_order', 0);
        $data['tags'] = array_filter(array_map('trim', explode(',', $data['tags'])));

        return $data;
    }
}
