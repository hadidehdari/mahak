<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Category;
use App\Models\Creator;
use App\Models\AgeGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $videos = Video::with(['category', 'creator', 'ageGroup'])->latest()->paginate(10);
        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        $categories = Category::all();
        $creators = Creator::all();
        $ageGroups = AgeGroup::all();
        return view('admin.videos.create', compact('categories', 'creators', 'ageGroups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'required|string',
            'video_url' => 'required|string',
            'duration' => 'required|integer',
            'file_size' => 'nullable|string',
            'background_color' => 'nullable|string|max:7',
            'category_id' => 'required|exists:categories,id',
            'creator_id' => 'required|exists:creators,id',
            'age_group_id' => 'required|exists:age_groups,id',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'rating' => 'nullable|numeric|min:0|max:5',
            'rating_count' => 'nullable|integer|min:0'
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['views_count'] = 0;

        Video::create($validated);

        return redirect()->route('admin.videos.index')
            ->with('success', 'ویدیو با موفقیت ایجاد شد.');
    }

    public function edit(Video $video)
    {
        $categories = Category::all();
        $creators = Creator::all();
        $ageGroups = AgeGroup::all();
        return view('admin.videos.edit', compact('video', 'categories', 'creators', 'ageGroups'));
    }

    public function update(Request $request, Video $video)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'required|string',
            'video_url' => 'required|string',
            'duration' => 'required|integer',
            'file_size' => 'nullable|string',
            'background_color' => 'nullable|string|max:7',
            'category_id' => 'required|exists:categories,id',
            'creator_id' => 'required|exists:creators,id',
            'age_group_id' => 'required|exists:age_groups,id',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'rating' => 'nullable|numeric|min:0|max:5',
            'rating_count' => 'nullable|integer|min:0'
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');

        $video->update($validated);

        return redirect()->route('admin.videos.index')
            ->with('success', 'ویدیو با موفقیت به‌روزرسانی شد.');
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return redirect()->route('admin.videos.index')
            ->with('success', 'ویدیو با موفقیت حذف شد.');
    }
} 