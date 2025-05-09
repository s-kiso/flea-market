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
}
