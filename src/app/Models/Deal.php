<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    use HasFactory;
    protected $fillable = [
        'item_id',
        'user_type',
        'message',
        'image',
        'check'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
