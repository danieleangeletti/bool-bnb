<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
// Helpers
use Illuminate\Support\Str;

//Models
use App\Models\Apartment;
use GrahamCampbell\ResultType\Success;

class ApartmentController extends Controller
{
    public function index()
    {
        $apartment = Apartment::all();
         return response()->json([
             'success'=>true,
             'result'=>$apartment
         ]);
    }

    public function show(string $slug)
    {
        $apartment = Apartment::all()->where("slug", $slug)->firstOrFail();
        return response()->json([
            'success'=>true,
            'result'=>$apartment
        ]);
    }
    public function getApartments(Request $request)
    {
        $allNames = $request->input('allName');

        // Eseguire la logica necessaria per ottenere gli appartamenti
        $apartments = Apartment::whereIn('name', $allNames)->get();

        return response()->json(['result' => $apartments]);
    }
    public function advancedResearch(Request $request)
    {   
        $allName = $request->input('allName');
        $nBeds = $request->input('nBeds');
        $nRooms = $request->input('nRooms');
        $services = $request->input('services');

        if ($nBeds == null) {
            $nBeds = 0;
        }

        if ($nRooms == null) {
            $nRooms = 0;
        }

        $query = Apartment::query();
        
        if ($allName !== null) {
            $query->whereIn('name', $allName);
        }

        $apartments = $query
            ->where('n_beds', '>=', $nBeds)
            ->where('n_rooms', '>=', $nRooms)
            ->whereHas('services', function (Builder $q) use ($services) {
                if ($services !== null) {
                    $q = $q->whereIn('type_of_service', $services);
                }

                return $q;
            })->get();

        return response()->json(['result' => $apartments]);
    }
}