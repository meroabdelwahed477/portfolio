<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    // قائمة بأيقونات البرامج واللغات البرمجية الشائعة
    private function getSkillIcons()
    {
        return [
            // Backend Languages
            'php' => 'fab fa-php',
            'python' => 'fab fa-python',
            'java' => 'fab fa-java',
            'javascript' => 'fab fa-js',
            'typescript' => 'fab fa-js-square',
            'nodejs' => 'fab fa-node-js',
            'go' => 'fab fa-golang',
            'ruby' => 'fab fa-ruby',
            'csharp' => 'fab fa-microsoft',
            'c++' => 'fas fa-code',
            'c' => 'fas fa-code',
            
            // Frameworks & Libraries
            'laravel' => 'fab fa-laravel',
            'symfony' => 'fab fa-symfony',
            'yii' => 'fas fa-code',
            'yii2' => 'fas fa-code',
            'django' => 'fab fa-python',
            'flask' => 'fab fa-python',
            'express' => 'fab fa-node-js',
            'react' => 'fab fa-react',
            'vue' => 'fab fa-vuejs',
            'angular' => 'fab fa-angular',
            'nextjs' => 'fab fa-react',
            'nuxt' => 'fab fa-vuejs',
            'svelte' => 'fas fa-code',
            
            // Databases
            'mysql' => 'fas fa-database',
            'postgresql' => 'fas fa-database',
            'mongodb' => 'fas fa-database',
            'redis' => 'fas fa-database',
            'sqlite' => 'fas fa-database',
            'oracle' => 'fas fa-database',
            'mariadb' => 'fas fa-database',
            
            // Tools & Services
            'git' => 'fab fa-git-alt',
            'github' => 'fab fa-github',
            'gitlab' => 'fab fa-gitlab',
            'docker' => 'fab fa-docker',
            'kubernetes' => 'fab fa-kubernetes',
            'aws' => 'fab fa-aws',
            'azure' => 'fab fa-microsoft',
            'gcp' => 'fab fa-google',
            'nginx' => 'fas fa-server',
            'apache' => 'fas fa-server',
            'linux' => 'fab fa-linux',
            'ubuntu' => 'fab fa-ubuntu',
            'debian' => 'fab fa-linux',
            
            // Frontend
            'html' => 'fab fa-html5',
            'css' => 'fab fa-css3-alt',
            'sass' => 'fab fa-sass',
            'less' => 'fab fa-less',
            'bootstrap' => 'fab fa-bootstrap',
            'tailwind' => 'fas fa-code',
            'jquery' => 'fab fa-js',
            
            // APIs
            'rest' => 'fas fa-code',
            'graphql' => 'fab fa-graphql',
            'api' => 'fas fa-code',
            
            // Other
            'json' => 'fas fa-code',
            'xml' => 'fas fa-code',
            'yaml' => 'fas fa-code',
        ];
    }
    
    // الحصول على الأيقونة المناسبة للمهارة
    private function getIconForSkill($skillName)
    {
        $icons = $this->getSkillIcons();
        $skillLower = strtolower(trim($skillName));
        
        // البحث المباشر
        if (isset($icons[$skillLower])) {
            return $icons[$skillLower];
        }
        
        // البحث الجزئي
        foreach ($icons as $key => $icon) {
            if (strpos($skillLower, $key) !== false || strpos($key, $skillLower) !== false) {
                return $icon;
            }
        }
        
        return null; // لا توجد أيقونة مناسبة
    }
    
    public function index()
    {
        $skills = Skill::orderBy('category')->orderBy('order', 'asc')->get();
        $skillIcons = $this->getSkillIcons();
        return view('admin.skills.index', compact('skills', 'skillIcons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'percentage' => 'required|integer|min:0|max:100',
            'category' => 'required|in:backend,frameworks,other',
            'order' => 'nullable|integer|min:0',
        ]);

        // إذا لم يتم تحديد أيقونة وكانت الفئة backend أو frameworks، جرب إيجاد أيقونة تلقائياً
        if (empty($validated['icon']) && in_array($validated['category'], ['backend', 'frameworks'])) {
            $autoIcon = $this->getIconForSkill($validated['name_ar']);
            if ($autoIcon) {
                $validated['icon'] = $autoIcon;
            }
        }

        Skill::create($validated);

        return redirect()->route('admin.skills.index')
            ->with('success', 'تم إضافة المهارة بنجاح');
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name_ar' => 'required|string|max:255',
            'name_en' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:255',
            'percentage' => 'required|integer|min:0|max:100',
            'category' => 'required|in:backend,frameworks,other',
            'order' => 'nullable|integer|min:0',
        ]);

        // إذا لم يتم تحديد أيقونة وكانت الفئة backend أو frameworks، جرب إيجاد أيقونة تلقائياً
        if (empty($validated['icon']) && in_array($validated['category'], ['backend', 'frameworks'])) {
            $autoIcon = $this->getIconForSkill($validated['name_ar']);
            if ($autoIcon) {
                $validated['icon'] = $autoIcon;
            }
        }

        $skill->update($validated);

        return redirect()->route('admin.skills.index')
            ->with('success', 'تم تحديث المهارة بنجاح');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()->route('admin.skills.index')
            ->with('success', 'تم حذف المهارة بنجاح');
    }
}
