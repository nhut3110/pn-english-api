<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;
    protected $table = 'class';
    protected $fillable = ['class_name', 'total_student', 'course_id', 'is_open',  'start_date', 'end_date', 'created_at', 'updated_at'];
}
