<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::orderBy('order')->latest()->get();
        return view('admin.certificates.index', compact('certificates'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:5120',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['image'] = $request->file('image')->store('certificates', 'public');

        if ($request->hasFile('pdf_file')) {
            $validated['pdf_file'] = $request->file('pdf_file')->store('certificates/pdf', 'public');
        }

        // Handle is_active - checkbox sends '1' when checked (value="1"), nothing when unchecked
        $validated['is_active'] = $request->has('is_active') && ($request->input('is_active') == '1' || $request->input('is_active') === 'on');

        Certificate::create($validated);

        return redirect()->route('admin.certificates.index')
            ->with('success', 'تم إضافة الشهادة بنجاح');
    }

    public function update(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'title_ar' => 'required|string|max:255',
            'title_en' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'pdf_file' => 'nullable|mimes:pdf|max:5120',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            if ($certificate->image) {
                Storage::disk('public')->delete($certificate->image);
            }
            $validated['image'] = $request->file('image')->store('certificates', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            if ($certificate->pdf_file) {
                Storage::disk('public')->delete($certificate->pdf_file);
            }
            $validated['pdf_file'] = $request->file('pdf_file')->store('certificates/pdf', 'public');
        }

        // Handle is_active - checkbox sends '1' when checked (value="1"), nothing when unchecked
        $validated['is_active'] = $request->has('is_active') && ($request->input('is_active') == '1' || $request->input('is_active') === 'on');

        $certificate->update($validated);

        return redirect()->route('admin.certificates.index')
            ->with('success', 'تم تحديث الشهادة بنجاح');
    }

    public function destroy(Certificate $certificate)
    {
        if ($certificate->image) {
            Storage::disk('public')->delete($certificate->image);
        }
        if ($certificate->pdf_file) {
            Storage::disk('public')->delete($certificate->pdf_file);
        }

        $certificate->delete();

        return redirect()->route('admin.certificates.index')
            ->with('success', 'تم حذف الشهادة بنجاح');
    }
}
