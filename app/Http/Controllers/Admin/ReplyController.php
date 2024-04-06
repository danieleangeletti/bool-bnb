<?php

namespace App\Http\Controllers;
use App\Models\Reply;

use Illuminate\Http\Request;

class ReplyController extends Controller
{    public function reply(Request $request)
    {
    $request->validate([
        'reply_content' => 'required|string',
        'message_id' => 'required|exists:messages,id',
        // Aggiungi eventuali altre regole di validazione necessarie
    ]);

    // Salvataggio della risposta nel database
    Reply::create([
        'content' => $request->reply_content,
        'user_id' => auth()->id(), // Assumendo che l'utente sia autenticato
        'message_id' => $request->message_id,
        // Aggiungi eventuali altri campi necessari per la risposta
    ]);

    // Redirect alla pagina precedente con un messaggio di successo
    return redirect()->back()->with('success', 'Risposta inviata con successo!');
}
}

