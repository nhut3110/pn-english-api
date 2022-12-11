<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;
    protected $table = 'evaluation';
    protected $fillable = ['name', 'title', 'gender', 'rating', 'description', 'created_at', 'updated_at'];
}
