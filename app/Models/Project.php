<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title_ar', 'title_en', 'company_name_ar', 'company_name_en',
        'description_ar', 'description_en', 'category', 'thumbnail', 'link',
        'features_ar', 'features_en', 'technologies', 'order', 'is_active'
    ];

    protected $casts = [
        'features_ar' => 'array',
        'features_en' => 'array',
        'technologies' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    // Ensure features are always arrays, never null
    public function getFeaturesArAttribute($value)
    {
        if ($value === null || $value === '') {
            return [];
        }
        if (is_array($value)) {
            return $value;
        }
        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : [];
    }

    public function getFeaturesEnAttribute($value)
    {
        if ($value === null || $value === '') {
            return [];
        }
        if (is_array($value)) {
            return $value;
        }
        $decoded = json_decode($value, true);
        return is_array($decoded) ? $decoded : [];
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('order');
    }
}
