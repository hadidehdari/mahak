<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Creator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CreatorController extends Controller
{
    public function index()
    {
        $creators = Creator::latest()->paginate(10);
        return view('admin.creators.index', compact('creators'));
    }

    public function create()
    {
        return view('admin.creators.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|string',
            'description' => 'nullable|string'
        ]);

        Creator::create($validated);

        return redirect()->route('admin.creators.index')
            ->with('success', 'سازنده/کارگردان با موفقیت ایجاد شد.');
    }

    public function edit(Creator $creator)
    {
        return view('admin.creators.edit', compact('creator'));
    }

    public function update(Request $request, Creator $creator)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'photo' => 'nullable|string',
            'description' => 'nullable|string'
        ]);

        $creator->update($validated);

        return redirect()->route('admin.creators.index')
            ->with('success', 'سازنده/کارگردان با موفقیت بروزرسانی شد.');
    }

    public function destroy(Creator $creator)
    {
        if ($creator->photo) {
            Storage::disk('public')->delete($creator->photo);
        }
        
        $creator->delete();

        return redirect()->route('admin.creators.index')
            ->with('success', 'سازنده/کارگردان با موفقیت حذف شد.');
    }
} 