<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class AdminCategoryController extends Controller
{
    const ICONS = [
        'board', 'cpu', 'chip', 'ic', 'wifi', 'antenna', 'radar', 'robot', 'drone',
        'monitor', 'desktop', 'resistor', 'gauge', 'kit', 'printer', 'home', 'wrench',
        'cable', 'grid', 'box', 'shield', 'filter', 'truck', 'star', 'plus',
    ];

    public function index()
    {
        $sections = Category::with(['children' => function ($q) {
                $q->withCount('products');
            }])
            ->withCount('products')
            ->roots()
            ->get();

        return view('admin.categories', [
            'sections' => $sections,
            'roots' => $sections,
            'icons' => self::ICONS,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        Category::create([
            'parent_id' => $data['parent_id'],
            'name' => $data['name'],
            'slug' => $this->uniqueSlug($data['name'], $data['parent_id']),
            'icon' => $data['icon'],
            'blurb' => $data['blurb'],
            'sort_order' => $data['sort_order'],
        ]);

        return redirect()->route('admin.categories.index')->withsuccess('Category added.');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $data = $this->validated($request, $category);

        $category->update([
            'parent_id' => $data['parent_id'],
            'name' => $data['name'],
            'icon' => $data['icon'],
            'blurb' => $data['blurb'],
            'sort_order' => $data['sort_order'],
        ]);

        return redirect()->route('admin.categories.index')->withsuccess('Category updated.');
    }

    public function destroy($id)
    {
        $category = Category::withCount(['products', 'children'])->findOrFail($id);

        if ($category->products_count > 0) {
            return redirect()->route('admin.categories.index')
                ->withErrors(['category' => 'Cannot delete "'.$category->name.'" — it still has '.$category->products_count.' product(s) assigned.']);
        }

        if ($category->children_count > 0) {
            return redirect()->route('admin.categories.index')
                ->withErrors(['category' => 'Cannot delete "'.$category->name.'" — remove its '.$category->children_count.' subcategor(ies) first.']);
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->withsuccess('Category deleted.');
    }

    private function validated(Request $request, Category $category = null)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'blurb' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
            'parent_id' => 'nullable|exists:categories,id',
        ];
        Validator::make($request->all(), $rules)->validate();

        $parentId = $request->input('parent_id') ?: null;

        // A category cannot be its own parent, and the taxonomy stays two levels
        // deep — so a section that already has children cannot be nested.
        if ($category) {
            if ((int) $parentId === (int) $category->id) {
                $parentId = $category->parent_id;
            } elseif ($parentId && $category->children()->exists()) {
                $parentId = null;
            }
        }

        return [
            'parent_id' => $parentId,
            'name' => $request->input('name'),
            'blurb' => $request->input('blurb'),
            'icon' => $request->input('icon') ?: 'box',
            'sort_order' => (int) $request->input('sort_order', 0),
        ];
    }

    private function uniqueSlug($name, $parentId)
    {
        $parent = $parentId ? Category::find($parentId) : null;
        $base = Str::slug($parent ? $parent->name.' '.$name : $name);
        $slug = $base;
        $i = 2;
        while (Category::where('slug', $slug)->exists()) {
            $slug = $base.'-'.$i++;
        }

        return $slug;
    }
}
