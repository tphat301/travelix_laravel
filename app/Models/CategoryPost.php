<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryPost extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'category_posts';
    protected $fillable = ['parent_id', 'level', 'name', 'photo', 'photo1', 'photo2', 'slug', 'slogan', 'type', 'status', 'state', 'desc', 'content', 'options'];
}
