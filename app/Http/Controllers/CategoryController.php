<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\HTTP\Requests\StoreCategoryRequest;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        if ($request->filled('search')) {
            $categories = Category::where('name', 'like', '%'.$request->search.'%')->get();
        } else {
            $categories = Category::all();
        }

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $request)
    {
        Category::create($request->validated());
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }


    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(StoreCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
