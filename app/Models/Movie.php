<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    public function movie_type() {
        return $this->belongsTo(MovieType::class, 'movie_type_id', 'id');
    }
}
