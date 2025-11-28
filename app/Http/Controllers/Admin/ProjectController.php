<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('order')->latest()->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'company_name_ar' => 'nullable|string|max:255',
            'company_name_en' => 'nullable|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'nullable|string',
            'category' => 'required|in:web,api-web,api-mobile',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url|max:255',
            'features_ar' => 'nullable|array',
            'features_ar.*' => 'string|max:500',
            'features_en' => 'nullable|array',
            'features_en.*' => 'string|max:500',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('projects/thumbnails', 'public');
        }

        // Handle is_active - checkbox sends '1' when checked (value="1"), nothing when unchecked
        $validated['is_active'] = $request->has('is_active') && ($request->input('is_active') == '1' || $request->input('is_active') === 'on');

        // Process features from text
        if ($request->has('features_ar_text')) {
            $featuresAr = array_filter(array_map('trim', explode("\n", $request->features_ar_text)));
            $validated['features_ar'] = !empty($featuresAr) ? $featuresAr : null;
        }
        if ($request->has('features_en_text')) {
            $featuresEn = array_filter(array_map('trim', explode("\n", $request->features_en_text)));
            $validated['features_en'] = !empty($featuresEn) ? $featuresEn : null;
    }

        // Process technologies from text
        if ($request->has('technologies_text')) {
            $technologies = array_filter(array_map('trim', explode(',', $request->technologies_text)));
            $validated['technologies'] = !empty($technologies) ? $technologies : null;
        }

        $project = Project::create($validated);

        // Handle project images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('projects/images', 'public');
                ProjectImage::create([
                    'project_id' => $project->id,
                    'image_path' => $imagePath,
                    'order' => $index,
                ]);
            }
        }

        return redirect()->route('admin.projects.index')
            ->with('success', 'تم إنشاء المشروع بنجاح');
    }

    public function show(Project $project)
    {
        $project->load('images');
        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $project->load('images');
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'company_name_ar' => 'nullable|string|max:255',
            'company_name_en' => 'nullable|string|max:255',
            'description_ar' => 'required|string',
            'description_en' => 'nullable|string',
            'category' => 'required|in:web,api-web,api-mobile',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'link' => 'nullable|url|max:255',
            'features_ar' => 'nullable|array',
            'features_ar.*' => 'string|max:500',
            'features_en' => 'nullable|array',
            'features_en.*' => 'string|max:500',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:100',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('projects/thumbnails', 'public');
        }

        // Handle is_active - checkbox sends '1' when checked (value="1"), nothing when unchecked
        $validated['is_active'] = $request->has('is_active') && ($request->input('is_active') == '1' || $request->input('is_active') === 'on');

        // Process features from text
        if ($request->has('features_ar_text')) {
            $featuresAr = array_filter(array_map('trim', explode("\n", $request->features_ar_text)));
            $validated['features_ar'] = !empty($featuresAr) ? $featuresAr : null;
        }
        if ($request->has('features_en_text')) {
            $featuresEn = array_filter(array_map('trim', explode("\n", $request->features_en_text)));
            $validated['features_en'] = !empty($featuresEn) ? $featuresEn : null;
    }

        // Process technologies from text
        if ($request->has('technologies_text')) {
            $technologies = array_filter(array_map('trim', explode(',', $request->technologies_text)));
            $validated['technologies'] = !empty($technologies) ? $technologies : null;
        }

        $project->update($validated);

        // Handle new images
        if ($request->hasFile('images')) {
            $maxOrder = $project->images()->max('order') ?? -1;
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('projects/images', 'public');
                ProjectImage::create([
                    'project_id' => $project->id,
                    'image_path' => $imagePath,
                    'order' => $maxOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.projects.index')
            ->with('success', 'تم تحديث المشروع بنجاح');
    }

    public function destroy(Project $project)
    {
        // Delete thumbnail
        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        // Delete project images
        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image_path);
            $image->delete();
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'تم حذف المشروع بنجاح');
    }

    public function deleteImage(ProjectImage $image)
    {
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        return back()->with('success', 'تم حذف الصورة بنجاح');
    }
}
