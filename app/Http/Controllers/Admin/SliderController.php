<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Models\Category;
use App\Models\Video;
use App\Models\AudioBook;
use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::orderBy('order')->get();
        return view('admin.sliders.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $videos = Video::all();
        $audiobooks = AudioBook::all();
        $campaigns = Campaign::all();
        
        return view('admin.sliders.create', compact('categories', 'videos', 'audiobooks', 'campaigns'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|string',
            'type' => 'required|in:category,video,audiobook,campaign,external',
            'target_id' => 'required_if:type,!=,external|nullable|integer',
            'link' => 'required_if:type,external|nullable|url',
            'order' => 'required|integer',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->boolean('is_active');
        
        if ($request->type === 'external') {
            $data['target_id'] = null;
        } else {
            $data['link'] = null;
        }

        Slider::create($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'اسلایدر با موفقیت ایجاد شد.');
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
    public function edit(Slider $slider)
    {
        $categories = Category::all();
        $videos = Video::all();
        $audiobooks = AudioBook::all();
        $campaigns = Campaign::all();
        
        return view('admin.sliders.edit', compact('slider', 'categories', 'videos', 'audiobooks', 'campaigns'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Slider $slider)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|string',
            'type' => 'required|in:category,video,audiobook,campaign,external',
            'target_id' => 'required_if:type,!=,external|nullable|integer',
            'link' => 'required_if:type,external|nullable|url',
            'order' => 'required|integer',
            'is_active' => 'boolean'
        ]);

        $data = $request->all();
        $data['is_active'] = $request->boolean('is_active');
        
        if ($request->type === 'external') {
            $data['target_id'] = null;
        } else {
            $data['link'] = null;
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')
            ->with('success', 'اسلایدر با موفقیت به‌روزرسانی شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slider $slider)
    {
        $slider->delete();
        return redirect()->route('admin.sliders.index')
            ->with('success', 'اسلایدر با موفقیت حذف شد.');
    }
}
