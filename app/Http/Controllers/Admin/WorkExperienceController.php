<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WorkExperienceController extends Controller
{
    public function index()
    {
        $workExperiences = WorkExperience::orderBy('order')->latest()->get();
        return view('admin.work-experiences.index', compact('workExperiences'));
    }

    public function create()
    {
        return view('admin.work-experiences.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name_ar' => 'required|string|max:255',
            'company_name_en' => 'nullable|string|max:255',
            'position_ar' => 'required|string|max:255',
            'position_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'type' => 'required|in:job,internship',
            'experience_letter' => 'nullable|file|mimes:pdf|max:10240', // 10MB max
            'is_current' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Handle is_current checkbox
        $validated['is_current'] = $request->has('is_current') && ($request->input('is_current') == '1' || $request->input('is_current') === 'on');
        
        // If current job, set end_date to null
        if ($validated['is_current']) {
            $validated['end_date'] = null;
        }

        // Handle is_active checkbox
        $validated['is_active'] = $request->has('is_active') && ($request->input('is_active') == '1' || $request->input('is_active') === 'on');

        // Handle experience letter upload (only for job type)
        if ($request->hasFile('experience_letter') && $validated['type'] === 'job') {
            $validated['experience_letter'] = $request->file('experience_letter')->store('work-experiences', 'public');
        } else {
            unset($validated['experience_letter']);
        }

        WorkExperience::create($validated);

        return redirect()->route('admin.work-experiences.index')
            ->with('success', 'تم إضافة الخبرة العملية بنجاح');
    }

    public function show(WorkExperience $workExperience)
    {
        return view('admin.work-experiences.show', compact('workExperience'));
    }

    public function edit(WorkExperience $workExperience)
    {
        return view('admin.work-experiences.edit', compact('workExperience'));
    }

    public function update(Request $request, WorkExperience $workExperience)
    {
        $validated = $request->validate([
            'company_name_ar' => 'required|string|max:255',
            'company_name_en' => 'nullable|string|max:255',
            'position_ar' => 'required|string|max:255',
            'position_en' => 'nullable|string|max:255',
            'description_ar' => 'nullable|string',
            'description_en' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'type' => 'required|in:job,internship',
            'experience_letter' => 'nullable|file|mimes:pdf|max:10240', // 10MB max
            'is_current' => 'boolean',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        // Handle is_current checkbox
        $validated['is_current'] = $request->has('is_current') && ($request->input('is_current') == '1' || $request->input('is_current') === 'on');
        
        // If current job, set end_date to null
        if ($validated['is_current']) {
            $validated['end_date'] = null;
        }

        // Handle is_active checkbox
        $validated['is_active'] = $request->has('is_active') && ($request->input('is_active') == '1' || $request->input('is_active') === 'on');

        // Handle experience letter upload/delete
        if ($validated['type'] === 'job' && $request->hasFile('experience_letter')) {
            // Delete old file if exists
            if ($workExperience->experience_letter) {
                Storage::disk('public')->delete($workExperience->experience_letter);
            }
            // Upload new file
            $validated['experience_letter'] = $request->file('experience_letter')->store('work-experiences', 'public');
        } elseif ($validated['type'] !== 'job') {
            // If type changed from job to internship, delete the file
            if ($workExperience->experience_letter) {
                Storage::disk('public')->delete($workExperience->experience_letter);
            }
            $validated['experience_letter'] = null;
        } else {
            // Keep existing file if no new file uploaded and type is still job
            unset($validated['experience_letter']);
        }

        $workExperience->update($validated);

        return redirect()->route('admin.work-experiences.index')
            ->with('success', 'تم تحديث الخبرة العملية بنجاح');
    }

    public function destroy(WorkExperience $workExperience)
    {
        // Delete experience letter file if exists
        if ($workExperience->experience_letter) {
            Storage::disk('public')->delete($workExperience->experience_letter);
        }

        $workExperience->delete();

        return redirect()->route('admin.work-experiences.index')
            ->with('success', 'تم حذف الخبرة العملية بنجاح');
    }
}
