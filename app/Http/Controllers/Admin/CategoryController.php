<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'poster' => 'nullable|string',
            'content_type' => 'required|in:video,audio_book',
            'background_color' => 'required|string|max:7',
            'text_color' => 'required|string|max:7',
        ]);

        Category::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'دسته‌بندی با موفقیت ایجاد شد.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'poster' => 'nullable|string',
            'content_type' => 'required|in:video,audio_book',
            'background_color' => 'required|string|max:7',
            'text_color' => 'required|string|max:7',
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'دسته‌بندی با موفقیت بروزرسانی شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->poster) {
            Storage::disk('public')->delete($category->poster);
        }
        
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'دسته‌بندی با موفقیت حذف شد.');
    }
}
