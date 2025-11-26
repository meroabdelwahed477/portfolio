<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar', 'name_en', 'title_ar', 'title_en',
        'description_ar', 'description_en', 'email', 'phone',
        'location_ar', 'location_en', 'experience_ar', 'experience_en',
        'availability_ar', 'availability_en', 'photo', 'cv_file'
    ];
}
