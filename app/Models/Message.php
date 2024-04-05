<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'text',
        'description',
        'name',
        'last_name',
        'email',
    ];
    use HasFactory;

    // Relationships
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
