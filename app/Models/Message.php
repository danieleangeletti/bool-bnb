<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // Relationships
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
