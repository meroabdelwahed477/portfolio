<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name_ar', 'company_name_en', 'position_ar', 'position_en',
        'description_ar', 'description_en', 'start_date', 'end_date',
        'type', 'experience_letter', 'is_current', 'order', 'is_active'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];
}
