<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Sponsorship;

class Apartment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'mq',
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
    use HasFactory,SoftDeletes;

    //full_cover_img
    public function getFullCoverImgAttribute()
    {
        // Se c'è una cover_img
        if ($this->img_cover_path) {
            // Allora mi restituisci il percorso completo
            return asset('storage/' . $this->img_cover_path);
        } else {
            return null;
        }
    }
    public function unreadMessagesCount()
    {
        return $this->messages()->where('is_read', false)->count();
    }
   

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
        return $this->belongsToMany(Sponsorship::class)
                    ->withPivot('end_date') // Aggiungi il campo 'end_date' della tabella pivot
                    ->withTimestamps(); // Aggiungi i timestamp created_at e updated_at alla tabella pivot
    }
}
