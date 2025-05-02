<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Option;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $settings = [
                'app_name' => Option::get('app_name', config('app.name', 'ماهک')),
                'app_version' => Option::get('app_version', config('app.version', '1.0.0')),
                'splash_image' => Option::get('splash_image', '')
            ];
            
            return view('admin.settings.index', compact('settings'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'خطا در بارگذاری تنظیمات: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        try {
            $validated = $request->validate([
                'app_name' => 'required|string|max:255',
                'app_version' => 'required|string|max:255',
                'splash_image' => 'nullable|string'
            ]);

            // ذخیره تنظیمات در دیتابیس
            foreach ($validated as $key => $value) {
                Option::set($key, $value);
            }

            return redirect()->route('admin.settings.index')
                ->with('success', 'تنظیمات با موفقیت بروزرسانی شد.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'خطا در ذخیره تنظیمات: ' . $e->getMessage())
                ->withInput();
        }
    }
} 