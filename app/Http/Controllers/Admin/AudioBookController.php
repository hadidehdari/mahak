<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AudioBook;
use App\Models\Category;
use App\Models\Creator;
use App\Models\AgeGroup;
use App\Models\AudioBookSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AudioBookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a paginated list of audio books
     */
    public function index()
    {
        $audioBooks = AudioBook::with(['category', 'creator', 'ageGroup'])
            ->latest()
            ->paginate(10);
        
        return view('admin.audiobooks.index', compact('audioBooks'));
    }

    /**
     * Show the form for creating a new audio book
     */
    public function create()
    {
        $categories = Category::where('content_type', 'audio_book')->get();
        $creators = Creator::all();
        $ageGroups = AgeGroup::all();
        
        return view('admin.audiobooks.create', compact('categories', 'creators', 'ageGroups'));
    }

    /**
     * Store a newly created audio book
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'cover_image_url' => 'nullable|url',
            'category_id' => 'required|exists:categories,id',
            'creator_id' => 'required|exists:creators,id',
            'age_group_id' => 'required|exists:age_groups,id',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured', false);
        $validated['is_active'] = $request->boolean('is_active', false);

        if ($request->hasFile('cover_image')) {
            $validated['cover_image'] = $request->file('cover_image')->store('audio-book-covers', 'public');
        } elseif (!empty($validated['cover_image_url'])) {
            $validated['cover_image'] = $validated['cover_image_url'];
        }
       ютьunset($validated['cover_image_url']);

        AudioBook::create($validated);

        return redirect()->route('admin.audiobooks.index')
            ->with('success', 'کتاب صوتی با موفقیت ایجاد شد.');
    }

    /**
     * Show the form for editing an audio book
     */
    public function edit(AudioBook $audioBook)
    {
        $categories = Category::where('content_type', 'audio_book')->get();
        $creators = Creator::all();
        $ageGroups = AgeGroup::all();
        $slides = $audioBook->slides()->orderBy('order')->get();
        
        return view('admin.audiobooks.edit', compact('audioBook', 'categories', 'creators', 'ageGroups', 'slides'));
    }

    /**
     * Update an existing audio book
     */
    public function update(Request $request, AudioBook $audioBook)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|max:2048',
            'cover_image_url' => 'nullable|url',
            'category_id' => 'required|exists:categories,id',
            'creator_id' => 'required|exists:creators,id',
            'age_group_id' => 'required|exists:age_groups,id',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_featured'] = $request->boolean('is_featured', false);
        $validated['is_active'] = $request->boolean('is_active', false);

        if ($request->hasFile('cover_image')) {
            if ($audioBook->cover_image) {
                Storage::disk('public')->delete($audioBook->cover_image);
            }
            $validated['cover_image'] = $request->file('cover_image')->store('audio-book-covers', 'public');
        } elseif (!empty($validated['cover_image_url'])) {
            $validated['cover_image'] = $validated['cover_image_url'];
        }

        $audioBook->update($validated);

        return redirect()->route('admin.audiobooks.index')
            ->with('success', 'کتاب صوتی با موفقیت به‌روزرسانی شد.');
    }

    /**
     * Delete an audio book
     */
    public function destroy(AudioBook $audioBook)
    {
        if ($audioBook->cover_image) {
            Storage::disk('public')->delete($audioBook->cover_image);
        }
        
        $audioBook->delete();
        
        return redirect()->route('admin.audiobooks.index')
            ->with('success', 'کتاب صوتی با موفقیت حذف شد.');
    }

    /**
     * نمایش اسلایدهای کتاب صوتی
     */
    public function slides(int $audiobookId)
    {
        $audioBook = AudioBook::findOrFail($audiobookId);
        $slides = $audioBook->slides()->orderBy('order')->get();
        return view('admin.audiobooks.slides.index', compact('audioBook', 'slides'));
    }
    

    /**
     * نمایش فرم ایجاد اسلاید جدید
     */
    public function createSlide(int $audiobookId)
    {
        $audioBook = AudioBook::findOrFail($audiobookId);
        return view('admin.audiobooks.slides.create', compact('audioBook'));
    }
    
    /**
     * ذخیره اسلاید جدید
     */
    public function storeSlide(Request $request, int $audiobookId)
    {
        $audioBook = AudioBook::findOrFail($audiobookId);
    
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'audio_url' => 'required|url',
            'duration' => 'required|integer|min:0',
            'order' => 'required|integer|min:0',
        ]);
    
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('audio-book-slides', 'public');
        }
    
        $audioBook->slides()->create($validated);
    
        return redirect()->route('admin.audiobooks.slides.index', $audiobookId)
            ->with('success', 'اسلاید با موفقیت اضافه شد.');
    }
    

    /**
     * نمایش فرم ویرایش اسلاید
     */
    public function editSlide(int $audiobookId, AudioBookSlide $slide)
    {
        $audioBook = AudioBook::findOrFail($audiobookId);
        return view('admin.audiobooks.slides.edit', compact('audioBook', 'slide'));
    }
    

    /**
     * به‌روزرسانی اسلاید
     */
    public function updateSlide(Request $request, int $audiobookId, AudioBookSlide $slide)
    {
        $audioBook = AudioBook::findOrFail($audiobookId);
    
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'audio_url' => 'required|url',
            'duration' => 'required|integer|min:0',
            'order' => 'required|integer|min:0',
        ]);
    
        if ($request->hasFile('image')) {
            if ($slide->image) {
                Storage::disk('public')->delete($slide->image);
            }
            $validated['image'] = $request->file('image')->store('audio-book-slides', 'public');
        }
    
        $slide->update($validated);
    
        return redirect()->route('admin.audiobooks.slides.index', $audiobookId)
            ->with('success', 'اسلاید با موفقیت به‌روزرسانی شد.');
    }
    
    /**
     * حذف اسلاید
     */
    public function deleteSlide(int $audiobookId, AudioBookSlide $slide)
    {
        $audioBook = AudioBook::findOrFail($audiobookId);
    
        if ($slide->image) {
            Storage::disk('public')->delete($slide->image);
        }
    
        $slide->delete();
    
        return redirect()->route('admin.audiobooks.slides.index', $audiobookId)
            ->with('success', 'اسلاید با موفقیت حذف شد.');
    }
    

    /**
     * تغییر ترتیب اسلایدها
     */
    public function reorderSlides(Request $request, AudioBook $audioBook)
    {
        $request->validate([
            'slides' => 'required|array',
            'slides.*' => 'required|integer|exists:audio_book_slides,id',
        ]);

        foreach ($request->slides as $index => $slideId) {
            AudioBookSlide::where('id', $slideId)->update(['order' => $index]);
        }

        return response()->json(['message' => 'ترتیب اسلایدها با موفقیت به‌روزرسانی شد.']);
    }
}