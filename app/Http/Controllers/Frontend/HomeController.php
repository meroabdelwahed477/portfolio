<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Certificate;
use App\Models\WorkExperience;
use App\Models\SocialLink;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $profile = Profile::first();
        $skills = Skill::orderBy('category')->orderBy('order', 'asc')->get();
        $projects = Project::where('is_active', true)->orderBy('order', 'asc')->with('images')->get();
        $certificates = Certificate::where('is_active', true)->orderBy('order', 'asc')->get();
        $workExperiences = WorkExperience::where('is_active', true)->orderBy('order', 'asc')->orderBy('start_date', 'desc')->get();
        $socialLinks = SocialLink::where('is_active', true)
            ->whereNotNull('url')
            ->where('url', '!=', '')
            ->orderBy('order', 'asc')
            ->get();
        
        // Get theme settings
        $theme = Setting::get('theme', 'light');
        $primaryColor = Setting::get('primary_color', '#6366f1');
        $secondaryColor = Setting::get('secondary_color', '#ec4899');

        return view('frontend.index', compact('profile', 'skills', 'projects', 'certificates', 'workExperiences', 'socialLinks', 'theme', 'primaryColor', 'secondaryColor'));
    }

    public function contact(Request $request)
    {
        // Get language from request header or default to Arabic
        $lang = $request->header('X-Language', $request->input('lang', 'ar'));
        if (!in_array($lang, ['ar', 'en'])) {
            $lang = 'ar';
        }
        
        // Set locale for validation messages
        app()->setLocale($lang);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        \App\Models\Contact::create($validated);

        $successMessage = $lang === 'ar' ? 'تم إرسال رسالتك بنجاح!' : 'Your message has been sent successfully!';
        
        return back()->with('success', $successMessage);
    }
}
