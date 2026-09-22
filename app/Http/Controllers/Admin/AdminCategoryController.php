<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class AdminCategoryController extends Controller
{
    const ICONS = ['chip', 'box', 'shield', 'grid', 'filter', 'plus', 'truck', 'star', 'chevron-right'];

    public function index()
    {
        $categories = Category::withCount('products')->orderBy('name')->get();
        return view('admin.categories', ['categories' => $categories, 'icons' => self::ICONS]);
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'blurb' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:50',
        ])->validate();

        Category::create([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'icon' => $request->input('icon') ?: 'box',
            'blurb' => $request->input('blurb'),
        ]);

        return redirect()->route('admin.categories.index')->withsuccess('Category added.');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'blurb' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:50',
        ])->validate();

        $category->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
            'icon' => $request->input('icon') ?: 'box',
            'blurb' => $request->input('blurb'),
        ]);

        return redirect()->route('admin.categories.index')->withsuccess('Category updated.');
    }

    public function destroy($id)
    {
        $category = Category::withCount('products')->findOrFail($id);

        if ($category->products_count > 0) {
            return redirect()->route('admin.categories.index')
                ->withErrors(['category' => 'Cannot delete "'.$category->name.'" — it still has '.$category->products_count.' product(s) assigned.']);
        }

        $category->delete();
        return redirect()->route('admin.categories.index')->withsuccess('Category deleted.');
    }
}
