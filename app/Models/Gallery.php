<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;
    protected $table = 'galleries';
    protected $fillable = [
        'name',
        'photo',
        'file_attach',
        'links_video',
        'type',
        'status',
        'options'
    ];
}
