<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Models\Message;
use App\Http\Controllers\Controller;
use App\Models\Reply;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMessageRequest $request)
    {
        // Validazione dei dati del messaggio
        $request->validate([
            'content' => 'required|string',
            // Aggiungi eventuali altre regole di validazione necessarie
        ]);

        // Salvataggio del nuovo messaggio nel database
        Message::create([
            'content' => $request->content,
            'user_id' => auth()->id(), // Assumendo che l'utente sia autenticato
            'apartment_id' => $request->apartment_id,
            // Aggiungi eventuali altri campi necessari per il messaggio
        ]);

        return redirect()->back()->with('success', 'Messaggio inviato con successo!');
        // Metodo per salvare una risposta a un messaggio esistente


    }
    public function reply(StoreMessageRequest $request)
    {
        // Validazione dei dati della risposta
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

        return redirect()->back()->with('success', 'Risposta inviata con successo!');
    }
    /**
     * Display the specified resource.
     */
    public function isRead(Message $message)
    {
        $message->update([
            'is_read' => true, // Contrassegna il messaggio come letto
        ]);

        return redirect()->back()->with('success', 'Messaggio contrassegnato come letto');
    }
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
