<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;


class Blog extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['title', 'body'];

     public function toSearchableArray(): array
    {
        return [
            'type' => 'blog',
            'title' => $this->title,
            'snippet' => Str::limit($this->body, 150),
            'link' => url("/blog/{$this->id}")
        ];
    }

}
