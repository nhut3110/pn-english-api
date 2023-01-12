<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OldToken extends Model
{
    use HasFactory;
    protected $table = 'old_token';
    protected $fillable = ['token'];
}
