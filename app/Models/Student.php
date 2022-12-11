<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'student';
    protected $fillable = ['full_name', 'student_phone', 'student_email', 'parent_phone', 'age', 'address', 'description', 'current_class_id', 'is_paid', 'start_date', 'end_date', 'created_at', 'updated_at'];
}
