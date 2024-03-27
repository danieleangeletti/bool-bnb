<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sponsorship extends Model
{
    protected $fillable = [
        'title',
        'description',
        'cost',
        'hour_duration'
    ];
    use HasFactory;

    // Relationships
    public function apartments()
    {
        return $this->belongsToMany(Apartment::class);
    }
}
