<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Momo extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'momos';
    protected $fillable = ['fullname', 'bank', 'total', 'status', 'options'];
}
