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
        $allNames = $request->input('allName');

        if ($request->has('nRooms') == null) {
            $apartments = Apartment::whereIn('name', $allNames)->get()
                                ->where('n_beds', '>=', $request->nBeds)
                                ->whereHas('services', function (Builder $q) use ($request) {
                                    $q->whereIn('type_of_service', $request->services);
                                });
        } else if ($request->has('nBeds') == null ) {
            $apartments = Apartment::whereIn('name', $allNames)->get()
                                ->where('n_rooms', '>=', $request->nRooms)
                                ->whereHas('services', function (Builder $q) use ($request) {
                                    $q->whereIn('type_of_service', $request->services);
                                });
        } else if ($request->has('services') == null){
            $apartments = Apartment::whereIn('name', $allNames)->get()
                                ->where('n_rooms', '>=', $request->nRooms)
                                ->where('n_beds', '>=', $request->nBeds);
        } else if ($request->has('nRooms') == null && $request->has('nBeds') == null){
            $apartments = Apartment::whereIn('name', $allNames)->get()
                                ->whereHas('services', function (Builder $q) use ($request) {
                                    $q->whereIn('type_of_service', $request->services);
                                });
        } else if ($request->has('nRooms') == null && $request->has('services') == null) {
            $apartments = Apartment::whereIn('name', $allNames)->get()
                                ->where('n_beds', '>=', $request->nBeds);
        } else if ($request->has('nBeds') == null && $request->has('services') == null) {
            $apartments = Apartment::whereIn('name', $allNames)->get()
                                ->where('n_rooms', '>=', $request->nRooms);
        } else if ($request->has('nRooms') == null && $request->has('nBeds') == null && $request->has('services') == null) {
            $apartments = Apartment::whereIn('name', $allNames)->get();
        } else if ($request->has('nRooms') !== null && $request->has('nBeds') !== null && $request->has('services') !== null) {
            $apartments = Apartment::whereIn('name', $allNames)->get()
                                ->where('n_rooms', '>=', $request->nRooms)
                                ->where('n_beds', '>=', $request->nBeds)
                                ->whereHas('services', function (Builder $q) use ($request) {
                                    $q->whereIn('type_of_service', $request->services);
                                });
        }
        

        return response()->json(['result' => $apartments]);
    }
}