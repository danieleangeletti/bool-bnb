<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Http\Controllers\Controller;

// Models
use App\Models\Apartment;
use App\Models\Sponsorship;
use App\Models\Service;
use App\Models\Message;

// Helpers
use Illuminate\Support\Str;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $apartments = Apartment::all();
        $sponsorhips = Sponsorship::all();
        $services = Service::all();
        $messages = Message::all();
        return view("admin.apartments.index", compact("apartments"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $apartments = Apartment::all();
        $accomodation = config('db.allTypeOfAccomodation');
        $sponsorhips = Sponsorship::all();
        $services = Service::all();
        return view("admin.apartments.create",compact('apartments','sponsorhips', 'services','accomodation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    {
        $validated_data = $request->validated();

        $apartment = new Apartment($validated_data);

        $apartment->name = $validated_data['name'];
        $apartment->type_of_accomodation = $validated_data['type_of_accomodation'];
        $apartment->n_guests = $validated_data['n_guests'];
        $apartment->n_rooms = $validated_data['n_rooms'];
        $apartment->n_beds = $validated_data['n_beds'];
        $apartment->n_baths = $validated_data['n_baths'];
        $apartment->price = $validated_data['price'];
        // $apartment->availability = $validated_data['availability'];
        $apartment->latitude = $validated_data['latitude'];
        $apartment->longitude = $validated_data['longitude'];
        $apartment->slug = Str::slug($validated_data['name']);
        $apartment->address = $validated_data['address'];
        $apartment->img_cover_path = $validated_data['img_cover_path'];

        $apartment->save();

        return redirect()->route('admin.apartments.show', ['apartment' => $apartment->slug]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $apartment = Apartment::where('slug', $slug)->firstOrFail();
        return view("admin.apartments.show", compact("apartment"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        $apartment = Apartment::where("slug", $slug)->firstOrFail();
        $accomodation = config('db.allTypeOfAccomodation');
        $services = Service::all();
 
        return view("admin.apartments.edit", compact("apartment","accomodation","services"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, string $slug)
    {   
        $validated_data = $request->validated();
       
        $apartment = Apartment::where("slug", $slug)->firstOrFail();

         $apartment->name = $validated_data['name'];
        $apartment->type_of_accomodation = $validated_data['type_of_accomodation'];
        $apartment->n_guests = $validated_data['n_guests'];
        $apartment->n_rooms = $validated_data['n_rooms'];
        $apartment->n_beds = $validated_data['n_beds'];
        $apartment->n_baths = $validated_data['n_baths'];
        $apartment->price = $validated_data['price'];
        // $apartment->availability = $validated_data['availability'];
        // $apartment->latitude = $validated_data['latitude'];
        // $apartment->longitude = $validated_data['longitude'];
        $apartment->slug = Str::slug($validated_data['name']);
        $apartment->address = $validated_data['address'];
        // $apartment->img_cover_path = $validated_data['img_cover_path'];

        $apartment->save();

        return redirect()->route('admin.apartments.show', ['apartment' => $apartment->slug]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug)
    {
        $apartment = Apartment::where('slug', $slug)->firstOrFail();

        $apartment->delete();

        return redirect()->route('admin.apartments.index');
    }
    public function restore(string $slug)
    {
        $appartamento = Apartment::withTrashed()->findOrFail( $slug);
        $appartamento->restore();

        // Restituzione della risposta appropriata (ad esempio, reindirizzamento, conferma, ecc.)
        return redirect()->route('admin.apartments.show',compact("apartment"));
    }
}
