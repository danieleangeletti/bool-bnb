<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'type_of_service',
        'icon'
    ];
    use HasFactory;

    // Relationships
    public function apartments()
    {
        return $this->belongsToMany(Apartment::class);
    }
}
