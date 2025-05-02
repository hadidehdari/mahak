<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function show($route_path)
    {
        $page = Page::where('route_path', $route_path)
            ->where('is_active', true)
            ->firstOrFail();

        return view('pages.show', compact('page'));
    }
} 