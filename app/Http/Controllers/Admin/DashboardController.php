<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Certificate;
use App\Models\Contact;
use App\Models\Skill;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'projects' => Project::count(),
            'active_projects' => Project::where('is_active', true)->count(),
            'certificates' => Certificate::count(),
            'active_certificates' => Certificate::where('is_active', true)->count(),
            'skills' => Skill::count(),
            'unread_contacts' => Contact::where('is_read', false)->count(),
            'total_contacts' => Contact::count(),
        ];

        $recent_contacts = Contact::latest()->take(5)->get();
        $recent_projects = Project::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recent_contacts', 'recent_projects'));
    }
}
