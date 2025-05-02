<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $query = Video::with(['category', 'creator', 'ageGroup']);
        
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('age_group_id')) {
            $query->where('age_group_id', $request->age_group_id);
        }

        if ($request->has('creator_id')) {
            $query->where('creator_id', $request->creator_id);
        }

        $videos = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return response()->json($videos);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'required|image|max:2048',
            'video_url' => 'required|string',
            'duration' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'creator_id' => 'nullable|exists:creators,id',
            'age_group_id' => 'required|exists:age_groups,id',
            'is_featured' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $video = new Video();
        $video->title = $request->title;
        $video->slug = Str::slug($request->title);
        $video->description = $request->description;
        $video->video_url = $request->video_url;
        $video->duration = $request->duration;
        $video->category_id = $request->category_id;
        $video->creator_id = $request->creator_id;
        $video->age_group_id = $request->age_group_id;
        $video->is_featured = $request->is_featured ?? false;

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('videos/thumbnails', 'public');
            $video->thumbnail = $path;
        }

        $video->save();

        return response()->json($video->load(['category', 'creator', 'ageGroup']), 201);
    }

    public function show(Video $video)
    {
        return response()->json($video->load(['category', 'creator', 'ageGroup']));
    }

    public function update(Request $request, Video $video)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|max:2048',
            'video_url' => 'required|string',
            'duration' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'creator_id' => 'nullable|exists:creators,id',
            'age_group_id' => 'required|exists:age_groups,id',
            'is_featured' => 'boolean',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $video->title = $request->title;
        $video->slug = Str::slug($request->title);
        $video->description = $request->description;
        $video->video_url = $request->video_url;
        $video->duration = $request->duration;
        $video->category_id = $request->category_id;
        $video->creator_id = $request->creator_id;
        $video->age_group_id = $request->age_group_id;
        $video->is_featured = $request->is_featured ?? $video->is_featured;

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('videos/thumbnails', 'public');
            $video->thumbnail = $path;
        }

        $video->save();

        return response()->json($video->load(['category', 'creator', 'ageGroup']));
    }

    public function destroy(Video $video)
    {
        $video->delete();
        return response()->json(null, 204);
    }

    public function incrementViews(Video $video)
    {
        $video->increment('views_count');
        return response()->json(['views_count' => $video->views_count]);
    }

    public function featured()
    {
        $videos = Video::with(['category', 'creator', 'ageGroup'])
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->get();
            
        return response()->json($videos);
    }

    public function popular()
    {
        $videos = Video::with(['category', 'creator', 'ageGroup'])
            ->orderBy('views_count', 'desc')
            ->limit(10)
            ->get();
            
        return response()->json($videos);
    }
} 