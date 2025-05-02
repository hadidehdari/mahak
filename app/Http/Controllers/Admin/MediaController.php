<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MediaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
                'url' => route('admin.media.index', ['path' => $path . '/' . basename($directory)])
            ];
        }
        
        foreach ($files as $file) {
            $items[] = [
                'type' => 'file',
                'name' => $file->getFilename(),
                'path' => $path . '/' . $file->getFilename(),
                'url' => $file->getFilename(),
                'size' => $this->formatBytes($file->getSize()),
                'extension' => $file->getExtension()
            ];
        }
        
        return view('admin.media.index', compact('items', 'path'));
    }

    public function getFiles(Request $request)
    {
        $path = $request->input('path', '');
        $fullPath = 'public/' . $path;
        
        $files = [];
        $directories = [];
        
        if (Storage::exists($fullPath)) {
            $items = Storage::files($fullPath);
            $dirs = Storage::directories($fullPath);
            
            foreach ($items as $item) {
                $files[] = [
                    'name' => basename($item),
                    'path' => str_replace('public/', '', $item),
                    'type' => 'file',
                    'size' => Storage::size($item),
                    'mime' => Storage::mimeType($item),
                    'url' => Storage::url($item),
                    'icon' => $this->getFileIcon(Storage::mimeType($item))
                ];
            }
            
            foreach ($dirs as $dir) {
                $directories[] = [
                    'name' => basename($dir),
                    'path' => str_replace('public/', '', $dir),
                    'type' => 'directory',
                    'icon' => 'fas fa-folder'
                ];
            }
        }
        
        return response()->json([
            'files' => $files,
            'directories' => $directories,
            'current_path' => $path
        ]);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'path' => 'nullable|string'
        ]);

        try {
            $file = $request->file('file');
            $path = $request->input('path', '');
            
            // اطمینان از وجود پوشه
            $fullPath = storage_path('app/public/' . $path);
            if (!File::exists($fullPath)) {
                File::makeDirectory($fullPath, 0755, true);
            }
            
            // آپلود فایل
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move($fullPath, $fileName);
            
            return response()->json(['message' => 'فایل با موفقیت آپلود شد']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function delete(Request $request)
    {
        $request->validate([
            'path' => 'required|string'
        ]);

        $path = 'public/' . $request->path;
        
        if (Storage::exists($path)) {
            Storage::delete($path);
            return response()->json(['success' => true]);
        }
        
        return response()->json(['success' => false, 'message' => 'فایل یافت نشد'], 404);
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
            
            // اطمینان از وجود پوشه والد
            $parentPath = storage_path('app/public/' . $path);
            if (!File::exists($parentPath)) {
                File::makeDirectory($parentPath, 0755, true);
            }
            
            // ایجاد پوشه جدید
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

    public function picker()
    {
        $path = request()->get('path', '');
        $fullPath = storage_path('app/public/' . $path);
            console.log($fullPath);
        // اطمینان از وجود پوشه
        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0755, true);
        }
        
        $files = [];
        $folders = [];
        
        // دریافت فایل‌ها
        $fileItems = File::files($fullPath);
        foreach ($fileItems as $file) {
            if (in_array(strtolower($file->getExtension()), ['jpg', 'jpeg', 'png', 'gif'])) {
                $files[] = [
                    'name' => $file->getFilename(),
                    'path' => $path . '/' . $file->getFilename(),
                    'url' => asset('storage/' . $path . '/' . $file->getFilename())
                ];
            }
        }
        
        // دریافت پوشه‌ها
        $folderItems = File::directories($fullPath);
        foreach ($folderItems as $folder) {
            $folders[] = [
                'name' => basename($folder),
                'path' => $path . '/' . basename($folder)
            ];
        }
        
        return view('admin.media.picker', compact('files', 'folders', 'path'));
    }

    private function getFileIcon($mimeType)
    {
        $icons = [
            'image' => 'fas fa-image',
            'video' => 'fas fa-video',
            'audio' => 'fas fa-music',
            'application/pdf' => 'fas fa-file-pdf',
            'application/msword' => 'fas fa-file-word',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => 'fas fa-file-word',
            'application/vnd.ms-excel' => 'fas fa-file-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => 'fas fa-file-excel',
            'application/vnd.ms-powerpoint' => 'fas fa-file-powerpoint',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation' => 'fas fa-file-powerpoint',
            'text/plain' => 'fas fa-file-alt',
            'text/html' => 'fas fa-file-code',
            'application/json' => 'fas fa-file-code',
            'application/zip' => 'fas fa-file-archive',
            'application/x-rar-compressed' => 'fas fa-file-archive',
            'application/x-7z-compressed' => 'fas fa-file-archive'
        ];

        foreach ($icons as $type => $icon) {
            if (strpos($mimeType, $type) === 0) {
                return $icon;
            }
        }

        return 'fas fa-file';
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