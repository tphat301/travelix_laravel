<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Photo extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'photos';
    protected $fillable = ['name', 'photo', 'link', 'type', 'status', 'desc', 'content', 'options'];
}
