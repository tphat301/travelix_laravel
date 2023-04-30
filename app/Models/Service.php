<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'services';
    protected $fillable = ['parent_id', 'name', 'brand', 'photo', 'photo1', 'photo2', 'slug', 'code', 'type', 'status', 'state', 'desc', 'content', 'options', 'price', 'price_old', 'discount', 'qty'];
}
