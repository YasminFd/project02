<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'comment',
        'rating',
        'meal_id'
    ];
    public function meal()
    {
        return $this->belongsTo(meal::class);
    }
}