<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'brand',
        'price',
        'description',
        'image'
    ];

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }

    public function comment()
    {
        return $this->belongsToMany(User::class, 'comments')->withPivot('comment');
    }

    public function like()
    {
        return $this->belongsToMany(User::class, 'likes');
    }

    public function purchase()
    {
        return $this->belongsToMany(User::class, 'purchases')->withPivot('postal_code', 'address', 'building', 'condition');
    }
}

