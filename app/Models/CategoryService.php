<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryService extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'category_services';
    protected $fillable = ['parent_id', 'level', 'name', 'brand', 'photo', 'photo1', 'photo2', 'slug', 'type', 'status', 'state', 'desc', 'content', 'options'];
}
