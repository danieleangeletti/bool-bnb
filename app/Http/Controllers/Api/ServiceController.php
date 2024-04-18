<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

// Models
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::all();
         return response()->json([
             'success'=>true,
             'result'=>$services
         ]);
    }
}
