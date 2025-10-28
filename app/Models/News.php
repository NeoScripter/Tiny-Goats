<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'categories' => 'array',
    ];

    public function getContentHtmlAttribute(): string
    {
        return Str::of($this->content)->markdown([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
            'max_nesting_level' => 5,
        ]);
    }
}
