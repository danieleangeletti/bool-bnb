<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Apartment;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store(Request $request, string $slug)
    {
        $request->validate([
            'text' => ['required','string'],
            'name' => ['string', 'max:100'],
            'last_name' => ['string', 'max:100'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:100'],
        ]);
        $apartment = Apartment::where('slug', $slug)->firstOrFail();
        $message = new Message;
        $validated_data = $request->all();

        $message->text = $validated_data['text'];
        $message->email = $validated_data['email'];
        $message->name = $validated_data['name'] ?? null;
        $message->last_name = $validated_data['last_name'] ?? null;
        $apartment->messages()->save($message);
        
        return response()->json([
            'success'=>true,
            'result'=>'Messaggio inviato correttamente.'
        ]);
    }
}
           
           
