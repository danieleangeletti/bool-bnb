<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = [
        'date',
        'ip_address'
    ];
    use HasFactory;

    // Relationships
    public function apartment()
    {
        return $this->belongsTo(Apartment::class);
    }
}
