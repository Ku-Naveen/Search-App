<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

class Faqs extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['question', 'answer'];

    public function toSearchableArray(): array
    {
        return [
            'type' => 'faqs',
            'title' => $this->question,
            'snippet' => Str::limit($this->answer, 150),
            'link' => url("/faqs/{$this->id}")
        ];
    }
}
