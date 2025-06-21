<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'publisher_id'];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function authors() {
        return $this->belongsToMany(Author::class);
    }

    public function publisher() {
        return $this->belongsTo(Publisher::class);
    }

    public function image() {
        return $this->hasOne(BookImage::class);
    }

    public function file() {
        return $this->hasOne(BookFile::class);
    }

    public function categories() {
        return $this->belongsToMany(Category::class);
    }

    public function favoredByUsers()
    {
        return $this->belongsToMany(User::class, 'book_user_favorite')->withTimestamps();
    }

    public function wishedByUsers() 
    {
        return $this->belongsToMany(User::class, 'book_user_wishlist')->withTimestamps();
    }
}
