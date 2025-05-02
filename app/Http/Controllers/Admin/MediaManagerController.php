<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MediaManagerController extends Controller
{
    public function index(Request $request)
    {
        $path = $request->get('path', '');
        $fullPath = storage_path('app/public/' . $path);
        
        $items = [];
        
        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }
        
        $files = File::files($fullPath);
        $directories = File::directories($fullPath);
        
        foreach ($directories as $directory) {
            $items[] = [
                'type' => 'directory',
                'name' => basename($directory),
                'path' => $path . '/' . basename($directory),
                'url' => route('media-manager.index', ['path' => $path . '/' . basename($directory)])
            ];
        }
        
        foreach ($files as $file) {
            $items[] = [
                'type' => 'file',
                'name' => $file->getFilename(),
                'path' => $path . '/' . $file->getFilename(),
                'url' => Storage::url($path . '/' . $file->getFilename()),
                'size' => $this->formatBytes($file->getSize()),
                'extension' => $file->getExtension()
            ];
        }
        
        return view('admin.media-manager.index', compact('items', 'path'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'path' => 'nullable|string'
        ]);

        try {
            $file = $request->file('file');
            $path = $request->input('path', '');
            
            $fullPath = storage_path('app/public/' . $path);
            if (!File::exists($fullPath)) {
                File::makeDirectory($fullPath, 0755, true);
            }
            
            $file->storeAs($path, $file->getClientOriginalName(), 'public');
            
            return response()->json(['message' => 'فایل با موفقیت آپلود شد']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function createFolder(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'path' => 'nullable|string'
        ]);

        try {
            $name = $request->input('name');
            $path = $request->input('path', '');
            
            $parentPath = storage_path('app/public/' . $path);
            if (!File::exists($parentPath)) {
                File::makeDirectory($parentPath, 0755, true);
            }
            
            $newPath = $parentPath . '/' . $name;
            if (!File::exists($newPath)) {
                File::makeDirectory($newPath, 0755, true);
                return response()->json(['message' => 'پوشه با موفقیت ایجاد شد']);
            } else {
                return response()->json(['error' => 'پوشه از قبل وجود دارد'], 400);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
} 