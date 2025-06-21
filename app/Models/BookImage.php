<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookImage extends Model
{
    use HasFactory;

    protected $fillable = ['image_path'];

    protected $hidden = [
        'book_id',
        'created_at',
        'updated_at'
    ];

    public function book() {
        return $this->belongsTo(Book::class);
    }
}
