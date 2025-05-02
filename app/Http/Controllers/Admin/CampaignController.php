<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\CampaignSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CampaignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $campaigns = Campaign::latest()->paginate(10);
        return view('admin.campaigns.index', compact('campaigns'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.campaigns.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'banner_image' => 'required|image|max:2048',
            'secondary_image' => 'nullable|image|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('campaigns', 'public');
        }

        if ($request->hasFile('secondary_image')) {
            $validated['secondary_image'] = $request->file('secondary_image')->store('campaigns', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        Campaign::create($validated);

        return redirect()->route('campaigns.index')
            ->with('success', 'پویش با موفقیت ایجاد شد.');
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
    public function edit(Campaign $campaign)
    {
        return view('admin.campaigns.edit', compact('campaign'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'banner_image' => 'nullable|image|max:2048',
            'secondary_image' => 'nullable|image|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
        ]);

        if ($request->hasFile('banner_image')) {
            if ($campaign->banner_image) {
                Storage::disk('public')->delete($campaign->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('campaigns', 'public');
        }

        if ($request->hasFile('secondary_image')) {
            if ($campaign->secondary_image) {
                Storage::disk('public')->delete($campaign->secondary_image);
            }
            $validated['secondary_image'] = $request->file('secondary_image')->store('campaigns', 'public');
        }

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->boolean('is_active');
        $validated['is_featured'] = $request->boolean('is_featured');

        $campaign->update($validated);

        return redirect()->route('campaigns.index')
            ->with('success', 'پویش با موفقیت بروزرسانی شد.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Campaign $campaign)
    {
        if ($campaign->banner_image) {
            Storage::disk('public')->delete($campaign->banner_image);
        }
        if ($campaign->secondary_image) {
            Storage::disk('public')->delete($campaign->secondary_image);
        }

        $campaign->delete();

        return redirect()->route('campaigns.index')
            ->with('success', 'پویش با موفقیت حذف شد.');
    }

    public function submissions(Campaign $campaign)
    {
        $submissions = $campaign->submissions()->with(['child.user'])->latest()->paginate(10);
        return view('admin.campaigns.submissions', compact('campaign', 'submissions'));
    }

    public function setWinners(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'winners' => 'required|array|size:3',
            'winners.*' => 'required|exists:campaign_submissions,id'
        ]);

        // Reset all winners
        $campaign->submissions()->update(['is_winner' => false]);

        // Set new winners
        foreach ($validated['winners'] as $index => $submissionId) {
            CampaignSubmission::where('id', $submissionId)->update([
                'is_winner' => true,
                'rank' => $index + 1
            ]);
        }

        return redirect()->route('campaigns.submissions', $campaign)
            ->with('success', 'برندگان پویش با موفقیت تعیین شدند.');
    }
}
