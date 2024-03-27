<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartment extends Model
{   
    protected $fillable = [
        'name',
        'type_of_accomodation',
        'number_of_guests',
        'n_rooms',
        'n_beds',
        'n_bath',
        'price',
        'availability',
        'latitude',
        'longitude',
        'slug', 
        'address',
        'deleted_at',
        'img_cover_path'
    ];
    use HasFactory;

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }
    public function views()
    {
        return $this->hasMany(View::class);
    }
    public function services()
    {
        return $this->belongsToMany(Service::class);
    }
    public function sponsorships()
    {
        return $this->belongsToMany(Sponsorship::class);
    }
}
