<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function store()
    {
        return response()->json([
            'success'=>true,
            'result'=>'Messaggio ricevuto correttamente.'
        ]);
    }
}
