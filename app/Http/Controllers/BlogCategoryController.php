<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::orderBy('id', 'desc')->paginate(10);
        return view('admin.blog_category.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'strCategoryName' => 'required|string|max:50|unique:blog_categories,strCategoryName'
        ]);

        $validated['strSlug'] = \Str::slug($request->strCategoryName);
        $validated['iStatus'] = 1;
        $validated['isDelete'] = 0;
        $validated['strIP'] = $request->ip();

        BlogCategory::create($validated);

        return back()->with('success', 'Category created successfully!');
    }

    public function edit($id)
    {
        $category = BlogCategory::findOrFail($id);

        return view('admin.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = BlogCategory::findOrFail($id);

        $validated = $request->validate([
            'strCategoryName' => 'required|string|max:50|unique:blog_categories,strCategoryName,' . $id . ',id'
        ]);

        $validated['strSlug'] = \Str::slug($request->strCategoryName);
        $validated['strIP'] = $request->ip();

        $category->update($validated);

        return back()->with('success', 'Category updated successfully!');
    }

    public function delete($id)
    {

        $category = BlogCategory::findOrFail($id);
        $category->delete();

        return back()->with('success', 'Category deleted successfully!');
    }
    public function show($id)
    {
        $categories = BlogCategory::where('id', $id)
            ->where('isDelete', 0)
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('admin.category.index', [
            'categories' => $categories,
            'id' => $id
        ]);
    }
}
