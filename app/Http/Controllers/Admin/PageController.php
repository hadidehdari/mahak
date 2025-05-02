<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pages = Page::latest()->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'route_name' => 'required|string|max:255|unique:pages',
            'route_path' => 'required|string|max:255|unique:pages',
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active', true);

        Page::create($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'صفحه با موفقیت ایجاد شد.');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'route_name' => 'required|string|max:255|unique:pages,route_name,' . $page->id,
            'route_path' => 'required|string|max:255|unique:pages,route_path,' . $page->id,
            'is_active' => 'boolean'
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active', true);

        $page->update($validated);

        return redirect()->route('admin.pages.index')
            ->with('success', 'صفحه با موفقیت بروزرسانی شد.');
    }

    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'صفحه با موفقیت حذف شد.');
    }

    public function show($route_path)
    {
        $page = Page::where('route_path', $route_path)
                    ->where('is_active', true)
                    ->firstOrFail();

        return view('pages.show', compact('page'));
    }
} 