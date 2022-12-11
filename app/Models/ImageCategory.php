<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageCategory extends Model
{
    use HasFactory;
    protected $table = 'image_category';
    protected $fillable = ['category_name', 'created_at', 'updated_at'];
}
