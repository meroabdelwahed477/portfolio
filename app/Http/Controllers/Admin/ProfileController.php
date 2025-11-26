<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        return view('admin.profile.index', compact('profile'));
    }

    public function create()
    {
        return view('admin.profile.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'nullable|string',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'location_ar' => 'nullable|string|max:255',
            'location_en' => 'nullable|string|max:255',
            'experience_ar' => 'nullable|string|max:255',
            'experience_en' => 'nullable|string|max:255',
            'availability_ar' => 'nullable|string|max:255',
            'availability_en' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cv_file' => 'nullable|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('profiles', 'public');
        }

        if ($request->hasFile('cv_file')) {
            $validated['cv_file'] = $request->file('cv_file')->store('cv', 'public');
        }

        Profile::create($validated);

        return redirect()->route('admin.profile.index')
            ->with('success', 'تم إنشاء الملف الشخصي بنجاح');
    }

    public function edit(Profile $profile)
    {
        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request, Profile $profile)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'nullable|string',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
            'location_ar' => 'nullable|string|max:255',
            'location_en' => 'nullable|string|max:255',
            'experience_ar' => 'nullable|string|max:255',
            'experience_en' => 'nullable|string|max:255',
            'availability_ar' => 'nullable|string|max:255',
            'availability_en' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cv_file' => 'nullable|mimes:pdf|max:5120',
        ]);

        if ($request->hasFile('photo')) {
            if ($profile->photo) {
                Storage::disk('public')->delete($profile->photo);
            }
            $validated['photo'] = $request->file('photo')->store('profiles', 'public');
        }

        if ($request->hasFile('cv_file')) {
            if ($profile->cv_file) {
                Storage::disk('public')->delete($profile->cv_file);
            }
            $validated['cv_file'] = $request->file('cv_file')->store('cv', 'public');
        }

        $profile->update($validated);

        return redirect()->route('admin.profile.index')
            ->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }
}
