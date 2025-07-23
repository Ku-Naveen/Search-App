<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

class Pages extends Model
{
    use HasFactory;

    use Searchable;

    protected $fillable = ['title', 'content'];

    public function toSearchableArray(): array
    {
        return [
            'type' => 'pages',
            'title' => $this->title,
            'snippet' => Str::limit($this->content, 150),
            'link' => url("/pages/{$this->id}")
        ];
    }
}
