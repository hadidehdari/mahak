<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function show($path)
    {
        $fullPath = storage_path('app/public/' . $path);
        
        if (!file_exists($fullPath) || !is_readable($fullPath)) {
            abort(404);
        }
        
        return response()->file($fullPath);
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file'
        ]);

        $file = $request->file('file');
        $path = $file->store('public/files');

        return response()->json([
            'path' => str_replace('public/', '', $path),
            'url' => Storage::url($path)
        ]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'path' => 'required|string'
        ]);

        $path = 'public/' . $request->path;
        
        if (Storage::exists($path)) {
            Storage::delete($path);
            return response()->json(['message' => 'فایل با موفقیت حذف شد']);
        }

        return response()->json(['message' => 'فایل یافت نشد'], 404);
    }
} 