<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Child;
use App\Models\ChildActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::where('role', 'parent')
            ->with('children')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('children.activities');
        return view('admin.users.show', compact('user'));
    }

    public function toggleStatus(User $user)
    {
        $user->update([
            'is_active' => !$user->is_active
        ]);

        return redirect()->back()->with('success', 'وضعیت کاربر با موفقیت تغییر کرد.');
    }

    public function children(User $user)
    {
        $children = $user->children()->with('activities')->paginate(10);
        return view('admin.users.children', compact('user', 'children'));
    }

    public function createChild(User $user)
    {
        return view('admin.users.children.create', compact('user'));
    }

    public function storeChild(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'age_group' => 'required|in:6_and_below,7_to_9,10_to_12',
            'city' => 'required|string|max:255',
            'profile_photo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')->store('children/photos', 'public');
        }

        $user->children()->create($validated);

        return redirect()->route('users.children', $user)
            ->with('success', 'پروفایل کودک با موفقیت ایجاد شد.');
    }

    public function editChild(User $user, Child $child)
    {
        return view('admin.users.children.edit', compact('user', 'child'));
    }

    public function updateChild(Request $request, User $user, Child $child)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
            'age_group' => 'required|in:6_and_below,7_to_9,10_to_12',
            'city' => 'required|string|max:255',
            'profile_photo' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('profile_photo')) {
            $validated['profile_photo'] = $request->file('profile_photo')->store('children/photos', 'public');
        }

        $child->update($validated);

        return redirect()->route('users.children', $user)
            ->with('success', 'پروفایل کودک با موفقیت بروزرسانی شد.');
    }

    public function destroyChild(User $user, Child $child)
    {
        $child->delete();
        return redirect()->route('users.children', $user)
            ->with('success', 'پروفایل کودک با موفقیت حذف شد.');
    }

    public function activities(Child $child)
    {
        $activities = $child->activities()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.activities', compact('child', 'activities'));
    }
}
