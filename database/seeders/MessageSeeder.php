<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

// Models
use App\Models\Message;
use App\Models\Apartment;


class MessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::withoutForeignKeyConstraints(function () {

            Message::truncate();
        });

        for ($i = 0; $i < 100; $i++){

            $message = new Message();
            
            $apartment = Apartment::inRandomOrder()->first();
            $message->apartment_id = $apartment->id;

            $message->text = fake()->sentence();
            $message->name = fake()->firstName();
            $message->last_name = fake()->lastName();
            $message->email = fake()->email();
            $message->save();
        }
    }
}
