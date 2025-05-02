<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\AudioBook;
use App\Models\Campaign;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'videos_count' => Video::count(),
            'audio_books_count' => AudioBook::count(),
            'campaigns_count' => Campaign::count(),
            'users_count' => User::count(),
        ];

        $latestVideos = Video::latest()->take(5)->get();
        $latestAudioBooks = AudioBook::latest()->take(5)->get();
        $latestCampaigns = Campaign::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestVideos', 'latestAudioBooks', 'latestCampaigns'));
    }
}
