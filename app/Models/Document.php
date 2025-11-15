<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'type', 'path', 'original_name', 'mime', 'size'
    ];

    protected $appends = ['file_url'];

    public function getFileUrlAttribute()
    {
        return \Storage::disk('public')->url($this->path);
    }
}
