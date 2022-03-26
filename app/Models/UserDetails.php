<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'address',
        'profile_image_path',
        'dob',
        'mobile',
        'alternate_mobile',
        'linkedin_link',
        'github_link'
    ];
}
