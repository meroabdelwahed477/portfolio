<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLink;
use Illuminate\Http\Request;

class SocialLinkController extends Controller
{
    public function index()
    {
        $socialLinks = SocialLink::orderBy('order', 'asc')->get();
        $allowedPlatforms = $this->getAllowedPlatforms();
        return view('admin.social-links.index', compact('socialLinks', 'allowedPlatforms'));
    }

    // Allowed platforms with their default icons
    private function getAllowedPlatforms()
    {
        return [
            'linkedin' => [
                'name' => 'LinkedIn',
                'icon' => 'fab fa-linkedin-in'
            ],
            'facebook' => [
                'name' => 'Facebook',
                'icon' => 'fab fa-facebook-f'
            ],
            'gmail' => [
                'name' => 'Gmail',
                'icon' => 'fas fa-envelope'
            ],
            'github' => [
                'name' => 'GitHub',
                'icon' => 'fab fa-github'
            ]
        ];
    }

    public function store(Request $request)
    {
        $allowedPlatforms = array_keys($this->getAllowedPlatforms());
        $platform = $request->input('platform');
        
        // Validation rules based on platform
        $rules = [
            'platform' => 'required|string|in:' . implode(',', $allowedPlatforms),
            'order' => 'nullable|integer|min:0',
        ];
        
        // For Gmail, allow email format, for others require URL
        if ($platform === 'gmail') {
            $rules['url'] = 'required|email|max:255';
        } else {
            $rules['url'] = 'required|url|max:255';
        }
        
        $validated = $request->validate($rules);
        
        // Handle is_active - checkbox sends '1' when checked (value="1"), nothing when unchecked
        // If checkbox is checked, it will be in request with value '1', otherwise it won't be in request at all
        $validated['is_active'] = $request->has('is_active') && ($request->input('is_active') == '1' || $request->input('is_active') === 'on');
        
        // For Gmail, add mailto: prefix if not present
        if ($platform === 'gmail') {
            $email = $validated['url'];
            // Remove mailto: if exists for processing
            $email = str_replace('mailto:', '', $email);
            // Add mailto: prefix
            $validated['url'] = 'mailto:' . $email;
        }
        
        // Set default icon based on platform
        $platforms = $this->getAllowedPlatforms();
        if (isset($platforms[$validated['platform']])) {
            $validated['icon'] = $platforms[$validated['platform']]['icon'];
        }

        SocialLink::create($validated);

        return redirect()->route('admin.social-links.index')
            ->with('success', 'تم إضافة الرابط بنجاح');
    }

    public function update(Request $request, SocialLink $socialLink)
    {
        $allowedPlatforms = array_keys($this->getAllowedPlatforms());
        $platform = $request->input('platform');
        
        // Validation rules based on platform
        $rules = [
            'platform' => 'required|string|in:' . implode(',', $allowedPlatforms),
            'order' => 'nullable|integer|min:0',
        ];
        
        // For Gmail, allow email format, for others require URL
        if ($platform === 'gmail') {
            $rules['url'] = 'required|email|max:255';
        } else {
            $rules['url'] = 'required|url|max:255';
        }
        
        $validated = $request->validate($rules);
        
        // Handle is_active - checkbox sends '1' when checked (value="1"), nothing when unchecked
        // If checkbox is checked, it will be in request with value '1', otherwise it won't be in request at all
        $validated['is_active'] = $request->has('is_active') && ($request->input('is_active') == '1' || $request->input('is_active') === 'on');
        
        // For Gmail, add mailto: prefix if not present
        if ($platform === 'gmail') {
            $email = $validated['url'];
            // Remove mailto: if exists for processing
            $email = str_replace('mailto:', '', $email);
            // Add mailto: prefix
            $validated['url'] = 'mailto:' . $email;
        }

        // Set default icon based on platform
        $platforms = $this->getAllowedPlatforms();
        if (isset($platforms[$validated['platform']])) {
            $validated['icon'] = $platforms[$validated['platform']]['icon'];
        }

        $socialLink->update($validated);

        return redirect()->route('admin.social-links.index')
            ->with('success', 'تم تحديث الرابط بنجاح');
    }

    public function destroy(SocialLink $socialLink)
    {
        $socialLink->delete();

        return redirect()->route('admin.social-links.index')
            ->with('success', 'تم حذف الرابط بنجاح');
    }
}
