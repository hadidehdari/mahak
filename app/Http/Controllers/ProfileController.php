<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        return view('profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users,email,' . auth()->id()],
            'phone' => ['required', 'string', 'max:255', 'unique:users,phone,' . auth()->id()],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'profile_photo' => ['nullable', 'string']
        ]);

        $user = auth()->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        if ($request->profile_photo) {
            $photoPath = str_replace(asset('storage/'), '', $request->profile_photo);
            $user->profile_photo = $photoPath;
        }

        $user->save();

        return redirect()->route('profile.edit')->with('status', 'پروفایل با موفقیت بروزرسانی شد.');
    }
}

