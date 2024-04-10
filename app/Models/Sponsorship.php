<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Sponsorship extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cost',
        'hour_duration'
    ];

    public function apartments()
    {
        return $this->belongsToMany(Apartment::class);
    }

    // Metodo per calcolare la data di inizio della nuova sponsorizzazione
    public static function calculateStartDate($apartmentId)
    {
        // Trova l'ultima sponsorizzazione attiva per l'appartamento
        $lastSponsorship = static::whereHas('apartments', function ($query) use ($apartmentId) {
            $query->where('apartment_id', $apartmentId);
        })
            ->where('end_date', '>', now())
            ->latest()
            ->first();
    
        // Calcola la data di inizio della nuova sponsorizzazione
        $newStartDate = $lastSponsorship ? $lastSponsorship->end_date->addHours(1) : now();
    
        return $newStartDate;
    }
    
}
