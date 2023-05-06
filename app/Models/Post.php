<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'posts';
    protected $fillable = ['name', 'parent_id1', 'parent_id2', 'parent_id3', 'parent_id4', 'office', 'number', 'address', 'photo', 'photo1', 'photo2', 'slug', 'slogan', 'status', 'state', 'type', 'desc', 'content', 'options', 'view'];
}
