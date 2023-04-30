<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    protected $table = 'pages';
    protected $fillable = ['name', 'photo1', 'photo2', 'photo3', 'photo4', 'slogan', 'slug', 'type', 'status', 'desc', 'content', 'options'];
}
