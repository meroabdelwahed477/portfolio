<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar', 'name_en', 'icon', 'percentage', 'category', 'order'
    ];

    protected $casts = [
        'percentage' => 'integer',
        'order' => 'integer',
    ];
}
