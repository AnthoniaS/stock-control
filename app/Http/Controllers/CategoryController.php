<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function index()
    {
        $Categories = Category::all();
        return view('categories.index', compact('Categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(StoreCategoryRequest $Request)
    {
        Category::create($Request->validated());
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Category $Category)
    {
        return view('categories.edit', compact('Category'));
    }

    public function update(StoreCategoryRequest $Request, Category $Category)
    {
        $Category->update($Request->validated());
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $Category)
    {
        $Category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
