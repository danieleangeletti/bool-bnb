<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Controller\Admin\ApartmentController;
use Illuminate\Support\Str;
use App\Models\Apartment;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allNameApartments = [
            'Villa Serenità',
            'Casa Aurora',
            'Appartamento Dolce Vita',
            'La Dimora dei Sogni',
            'Casa del Bosco',
            'Villa Paradiso',
            'Appartamento Luna Blu',
            'Casa Fiorita',
            'Villa Incanto',
            'Appartamento Luminoso',
            'Casa delle Farfalle',
            'Villa Marittima',
            'Appartamento Arcobaleno',
            'Casa dei Ricordi',
            'Villa Primavera',
            'Appartamento Sole Splendente',
            'Casa del Vento',
            'Villa Eterna',
            'Appartamento Vista Mare',
            'Casa degli Angeli',
            'Villa Verde',
            'Appartamento Felicità',
            'Casa dei Fiori',
            'Villa degli Ulivi',
            'Appartamento Charme',
            'Casa del Sole',
            'Villa Panoramica',
            'Appartamento Bella Vista',
            'Casa Luna Crescente',
            'Villa Amore',
            'Appartamento Cozy Corner',
            'Casa dei Coralli',
            'Villa Rustica',
            'Appartamento Cielo Stellato',
            'Casa della Luna',
            'Villa Oceano',
            'Appartamento Dei Sogni ',
            'Casa dei Pini',
            'Villa Tranquilla',
            'Appartamento Paradiso Terrestre',
            'Casa della Cascata',
            'Villa Fiorente',
            'Appartamento Sole di Mezzogiorno',
            'Casa Blu Profondo',
            'Villa delle Meraviglie',
            'Appartamento Arcadia',
            'Casa dei Desideri',
            'Villa Nascosta',
            'Appartamento Vista Montagne',
            'Casa Armoniosa',
        ];
        $allTypeOfAccomodation = [
            'Chalet',
            'Casale',
            'Cottage',
            'Loft',
            'Suite',
            'Penthouse',
            'Villetta',
            'Casetta',
            'Residenza',
            'Baita'
        ];
        for ($i = 0; $i < count($allNameApartments); $i++) {

            $apartment = new Apartment();
            $apartment->name = $allNameApartments[$i];
            $apartment->type_of_accomodation = $allTypeOfAccomodation(Rand(0, count($allTypeOfAccomodation)));
            $apartment->n_guests = fake()->randomDigitNotNull(2,9);
            $apartment->n_rooms = fake()->randomDigitNotNull();
            $apartment->n_beds = fake()->randomDigitNotNull();
            $apartment->n_baths = fake()->randomDigit(1,3);
            $apartment->price = fake()->randomFloat(2);
            $apartment->availability = fake()->randomDigit(0,1);
            $apartment->latitude = fake()->latitude();
            $apartment->longitude= fake()->longitude();
            // da rivedere amche latitudine e longitudine
            $apartment->slug = Str::slug($apartment->name);
            $apartment->address = fake()->address();
            $apartment->img_cover_path = fake()->imageUrl(640, 480, 'houses', true);

        }
    }
}
