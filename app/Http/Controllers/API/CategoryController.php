<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::query();
        
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }

        $categories = $query->orderBy('order')->get();
        
        return response()->json($categories);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:video,audiobook,pdf',
            'image' => 'nullable|image|max:2048',
            'order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        $category->type = $request->type;
        $category->order = $request->order ?? 0;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $category->image = $path;
        }

        $category->save();

        return response()->json($category, 201);
    }

    public function show(Category $category)
    {
        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:video,audiobook,pdf',
            'image' => 'nullable|image|max:2048',
            'order' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $category->description = $request->description;
        $category->type = $request->type;
        $category->order = $request->order ?? $category->order;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $category->image = $path;
        }

        $category->save();

        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(null, 204);
    }

    public function updateOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categories' => 'required|array',
            'admin.categories.*.id' => 'required|exists:categories,id',
            'admin.categories.*.order' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        foreach ($request->categories as $item) {
            Category::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['message' => 'Order updated successfully']);
    }
} 