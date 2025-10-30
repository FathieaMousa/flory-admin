<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('parent')->orderBy('id', 'desc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {

        $categories = Category::orderBy('name')->get();
        return view('admin.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'      => ['required','string','max:255'],
            'parent_id' => ['nullable','exists:categories,id'],
        ]);

        Category::create($data);
        return redirect()->route('categories.index')->with('success', 'Category added.');
    }

    public function edit(Category $category)
    {
        
        $categories = Category::where('id', '!=', $category->id)->orderBy('name')->get();
        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'      => ['required','string','max:255'],
            'parent_id' => [
                'nullable',
                'exists:categories,id',
                Rule::notIn([$category->id]),
            ],
        ]);

        $category->update($data);
        return redirect()->route('categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Category deleted.');
    }
}
