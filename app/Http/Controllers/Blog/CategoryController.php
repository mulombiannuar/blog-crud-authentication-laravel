<?php

declare(strict_types=1);

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('blog.category.create', ['title' => 'Create Category']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::create($request->all());
        return redirect(route('dashboard'))->with('success', 'Category data saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $category = Category::findOrFail($id);
        //dd($category->posts());
        return view('blog.category.show', ['title' => $category->name, 'category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $category = Category::findOrFail($id);
        return view('blog.category.edit', ['title' => $category->name, 'category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id): RedirectResponse
    {
        $category = Category::find($id);
        if (!$category)
            return back()->with('warning', 'Category data could not be updated');
        $category->update($request->all());
        return redirect(route('dashboard'))->with('success', 'Category data updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        //$category->posts()->delete(); would delete all of the posts associated with that category.
        Post::where('category_id', $id)->update(['category_id' => null]);
        Category::find($id)->delete();
        return redirect(route('dashboard'))->with('success', 'Category data deleted successfully');
    }
}
