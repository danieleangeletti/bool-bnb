<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;


// Models
use App\Models\Apartment;
use App\Models\Sponsorship;
use App\Models\Service;
use App\Models\Message;
use App\Models\View;

// Helpers
use Illuminate\Support\Str;

class ApartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $userIP = $request->ips();
        $apartments = Apartment::where('user_id', $user->id)->withTrashed()->get();;
        $sponsorhips = Sponsorship::all();
        $services = Service::all();

        $messages = Message::all();
        $messagesReaded = [];
        for ($i=0; $i < count($messages) ; $i++) { 
           if ($messages[$i]->is_read) {
            $messagesReaded[] = $messages[$i];
           }
        }
        // dd($messagesReaded);
        return view("admin.apartments.index", compact("apartments"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $apartments = Apartment::all();
        $accomodation = config('db.allTypeOfAccomodation');
        $sponsorships = Sponsorship::all();
        
        $services = Service::all();
        return view("admin.apartments.create", compact('apartments', 'sponsorships', 'services', 'accomodation'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreApartmentRequest $request)
    {

        $validated_data = $request->validated();

        $img_cover_path = null;
        if (isset($validated_data['img_cover_path'])) {
            $img_cover_path = Storage::disk('public')->put('img', $validated_data['img_cover_path']);
        }

        $user = Auth::user();

        $apartment = new Apartment($validated_data);
        $client = new Client([
            'verify' => false, // Impostare a true per abilitare la verifica del certificato SSL
            // Specificare il percorso del certificato CA
        ]);
        $response = $client->get('https://api.tomtom.com/search/2/geocode/query=' . $apartment['address'] . ' ' . $apartment['city'] . '.json?key=03zxGHB5yWE9tQEW9M7m9s46vREYKHct');
        $data = json_decode($response->getBody(), true);
        $apartment->name = $validated_data['name'];
        $apartment->user_id = $user->id;
        $apartment->type_of_accomodation = $validated_data['type_of_accomodation'];
        $apartment->mq = $validated_data['mq'];
        $apartment->n_guests = $validated_data['n_guests'];
        $apartment->n_rooms = $validated_data['n_rooms'];
        $apartment->n_beds = $validated_data['n_beds'];
        $apartment->n_baths = $validated_data['n_baths'];
        $apartment->price = $validated_data['price'];
        $apartment->availability = $validated_data['availability'];
        $apartment->latitude = $data['results'][0]['position']['lat'];
        $apartment->longitude = $data['results'][0]['position']['lon'];
        $apartment->address = $data['results'][0]['address']['freeformAddress'];
        $apartment->slug = Str::slug($validated_data['name']);
        // $apartment->address = $validated_data['address'];
        // $apartment->city = $validated_data['city'];
        $apartment->img_cover_path = $img_cover_path;

        $apartment->save();

        if (isset($validated_data['services'])) {
            foreach ($validated_data['services'] as $singleServiceId) {
                // attach this technology_id to this project
                $apartment->services()->attach($singleServiceId);
            }
        }

        return redirect()->route('admin.apartments.show', ['apartment' => $apartment->slug]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug, Request $request)
    {
        $apartment = Apartment::where('slug', $slug)->firstOrFail();
        $sponsorships = Sponsorship::all();
        $messages = Message::where('apartment_id', $apartment->id)->get();
        $myView = View::where('apartment_id', $apartment->id)->where('ip_address', $request->ip())->get()->last();


        // dd($myView->last());
        $now = Carbon::now();
        // $formattedDate = $now->format('Y-m-d');
        if ($myView && $now->diffInHours($myView->created_at) >= 12) {
            $view = new View;
            $view->ip_address = $request->ip();
            $view->apartment_id = $apartment->id;
            $view->save();
        }

        // Verifica se l'appartamento appartiene all'utente loggato
        if ($apartment->user_id != auth()->id()) {
            // Gestisci il caso in cui l'appartamento non appartenga all'utente loggato
            return back()->withErrors('error', 'Something went wrong!');
        }
        return view("admin.apartments.show", compact("apartment", "sponsorships","messages"));
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {

        $user = Auth::user();

        $apartment = Apartment::where('slug', $slug)->firstOrFail();
        $accomodation = config('db.allTypeOfAccomodation');
        $services = Service::all();
        if ($apartment->user_id != auth()->id()) {
            // Gestisci il caso in cui l'appartamento non appartenga all'utente loggato

            return redirect()->route('admin.apartments.index')->with('error', 'You are not authorized to access this apartment.');
        } else {

            return view("admin.apartments.edit", compact("apartment", "accomodation", "services"));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateApartmentRequest $request, string $slug)
    {
        $validated_data = $request->validated();

        $apartment = Apartment::where("slug", $slug)->firstOrFail();
        $client = new Client([
            'verify' => false, // Impostare a true per abilitare la verifica del certificato SSL
            // Specificare il percorso del certificato CA
        ]);
        $response = $client->get('https://api.tomtom.com/search/2/geocode/query=' . $apartment['address'] . '.json?key=03zxGHB5yWE9tQEW9M7m9s46vREYKHct');
        $data = json_decode($response->getBody(), true);

        $apartment->name = $validated_data['name'];
        $apartment->type_of_accomodation = $validated_data['type_of_accomodation'];
        $apartment->n_guests = $validated_data['n_guests'];
        $apartment->n_rooms = $validated_data['n_rooms'];
        $apartment->n_beds = $validated_data['n_beds'];
        $apartment->n_baths = $validated_data['n_baths'];
        $apartment->price = $validated_data['price'];
        $apartment->availability = $validated_data['availability'];
        if (isset($data['results'][0]['position']['lat']) && isset($data['results'][0]['position']['lon']) != null) {

            $apartment->latitude = $data['results'][0]['position']['lat'];
            $apartment->longitude = $data['results'][0]['position']['lon'];
        }
        $apartment->slug = Str::slug($validated_data['name']);
        // $apartment->address = $validated_data['address'];
        // $apartment->city = $validated_data['city'];
        $apartment->address = $data['results'][0]['address']['freeformAddress'];

        if ($request->has('delete_img_cover_path') && $request->delete_img_cover_path == true) {
            // Elimina l'immagine corrente
            if ($apartment->img_cover_path) {
                Storage::disk('public')->delete($apartment->img_cover_path);
                $apartment->img_cover_path = null;
            }
        }

        // Aggiorna l'immagine se è stata fornita una nuova immagine
        if (isset($validated_data['img_cover_path'])) {
            $img_cover_path = Storage::disk('public')->put('img', $validated_data['img_cover_path']);
            // Elimina la vecchia immagine se presente
            if ($apartment->img_cover_path) {
                Storage::disk('public')->delete($apartment->img_cover_path);
            }
            
        }

        if (isset($img_cover_path)) {
            $apartment->img_cover_path = $img_cover_path;
        }
        // $apartment->img_cover_path = $validated_data['img_cover_path'];

        $apartment->save();

        if (isset($validated_data['services'])) {
            $apartment->services()->sync($validated_data['services']);
        } else {
            $apartment->services()->detach();
        }

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

        $apartment = Apartment::onlyTrashed()->where('slug',  $slug);

        $apartment->restore();

        // Restituzione della risposta appropriata (ad esempio, reindirizzamento, conferma, ecc.)
        return redirect()->route('admin.apartments.index');
    }
}
