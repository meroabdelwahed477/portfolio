<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $theme = Setting::get('theme', 'light');
        $primaryColor = Setting::get('primary_color', '#6366f1');
        $secondaryColor = Setting::get('secondary_color', '#ec4899');
        
        return view('admin.settings.index', compact('theme', 'primaryColor', 'secondaryColor'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'required|in:light,dark,blue,green,purple',
            'primary_color' => 'required',
            'secondary_color' => 'required',
        ]);

        Setting::set('theme', $validated['theme']);
        Setting::set('primary_color', $validated['primary_color']);
        Setting::set('secondary_color', $validated['secondary_color']);

        return redirect()->route('admin.settings.index')
            ->with('success', 'تم تحديث الإعدادات بنجاح');
    }
}
