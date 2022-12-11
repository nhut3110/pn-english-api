<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailCandidate extends Model
{
    use HasFactory;
    protected $table = 'email_candidate';
    protected $fillable = ['name', 'email', 'created_at', 'updated_at'];
}
