<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Videos extends Model
{
    protected $table = 'videos';
    protected $fillable = [
        'title', 'time', 'preview_image', 'video_path', 'categories'
    ];
}
