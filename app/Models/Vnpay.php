<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vnpay extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'vnpays';
    protected $fillable = ['fullname', 'bank', 'code', 'total', 'status', 'options'];
}
