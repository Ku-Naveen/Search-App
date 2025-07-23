<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use Illuminate\Support\Str;

class Products extends Model
{
    use HasFactory;
     use Searchable;
     protected $fillable = ['name', 'description', 'category', 'price'];

    public function toSearchableArray(): array
    {
        return [
            'type' => 'products',
            'title' => $this->name,
            'snippet' => Str::limit($this->description, 150),
            'link' => url("/products/{$this->id}")
        ];
    }

}
