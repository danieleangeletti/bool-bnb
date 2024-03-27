<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    protected $fillable = [
        'photo', 
    ];
    use HasFactory;

    // Relationships
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
