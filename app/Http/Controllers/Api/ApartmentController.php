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
        $request->validate([
            'nRooms' => 'nullable|integer|min:1|max:6',
            'nBeds' => 'nullable|integer|min:1|max:9',
            'services' => 'nullable|array',
        ]);
        
        // $query = Apartment::query();

        // if ($request->has('nRooms')) {
        //     $query->where('n_rooms', '>=', $request->nRooms);
        // };
        // if ($request->has('nBeds')) {
        //     $query->where('n_beds', '>=', $request->nBeds);
        // };
        // if ($request->has('services')) {
        //     $query->whereHas('services', function ($q) use ($request) {
        //         $q->whereIn('id', $request->services);
        //     });
        // };
        // $apartments = $query->get();

        // return response()->json($apartments);

        $apartments = Apartment::where('n_rooms', '>=', $request->nRooms)
                                ->where('n_beds', '>=', $request->nBeds)
                                ->whereHas('services', function (Builder $q) use ($request) {
                                    $q->whereIn('type_of_service', $request->services);
                                });

        return response()->json($apartments);
    }
}