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
        $apartment = Apartment::with('services','sponsorships')->get();
         return response()->json([
             'success'=>true,
             'result'=>$apartment
         ]);
    }

    public function show(string $slug)
    {
        $apartment = Apartment::with('services')->where("slug", $slug)->firstOrFail();
        return response()->json([
            'success'=>true,
            'result'=>$apartment
        ]);
    }
    public function getApartments(Request $request)
    {   
        $lat_center = $request->lat;
        $lon_center = $request->lon;
        
        $apartments = Apartment::all();

        $apartments_in_radius = filterApartmentsByDistance($apartments, $lat_center, $lon_center, 20);

        return response()->json(['result' => $apartments_in_radius]);
    }
    public function advancedResearch(Request $request)
    {   
        $lat_center = $request->input('lat');
        $lon_center = $request->input('lon');
        $nRooms = $request->input('nRooms');
        $nBeds = $request->input('nBeds');
        $distance = $request->input('distance');
        $services = $request->input('services');

        if ($nBeds == null) {
            $nBeds = 0;
        }

        if ($nRooms == null) {
            $nRooms = 0;
        }

        $query = Apartment::query();

        $apartments = $query
            ->where('n_rooms', '>=', $nRooms)
            ->where('n_beds', '>=', $nBeds)
            ->whereHas('services', function (Builder $q) use ($services) {
                if ($services !== null) {
                    $q = $q->whereIn('type_of_service', $services);
                }

                return $q;
            })->get();
            
        $apartments_in_radius = filterApartmentsByDistance($apartments, $lat_center, $lon_center, $distance);

        return response()->json(['result' => $apartments_in_radius]);
    }
}

function filterApartmentsByDistance($apartments, $lat_center, $lon_center, $distance) {
    $apartments_in_radius = [];

    $distances = [];

    for ($i = 0; $i < count($apartments); $i++) {
        $distanceM = haversineGreatCircleDistance(
            $apartments[$i]->latitude,
            $apartments[$i]->longitude,
            $lat_center,
            $lon_center,
        );

        $distanceKm = $distanceM / 1000;

        if ($distanceKm <= $distance) {
            $apartments[$i]['distance'] = $distanceKm;
            $apartments_in_radius[] = $apartments[$i];
            $distances[] = $distanceKm;
        }
    }

    usort($apartments_in_radius, function ($a, $b) {
        // Questa funziona ritorna 0 se A = B, ritorna 1 se A > B, e ritorna -1 se A < B
        if ($a['distance'] == $b['distance']){
            return 0;
        }
        return ($a['distance'] < $b['distance']) ? -1 : 1;
    });

    return $apartments_in_radius;
}

function haversineGreatCircleDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo) {
    $earthRadius = 6371000;

    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);
  
    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;
  
    $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));

    return $angle * $earthRadius;
}
