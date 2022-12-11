<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    protected $table = 'message';
    protected $fillable = ['customer_name', 'customer_phone', 'customer_email', 'description', 'created_at', 'updated_at'];
}
