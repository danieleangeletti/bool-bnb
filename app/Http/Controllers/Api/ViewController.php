<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreViewRequest;
use App\Http\Requests\UpdateViewRequest;
use App\Models\View;
use App\Models\Apartment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
class ViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request, string $slug)
    // {
    //     $apartment = Apartment::where("slug", $slug)->firstOrFail();
    //     $oldView = View::where('apartment_id',$apartment->id)->first();
    //     if($oldView != null && $oldView->ip_address == $request->input('ipAddress') && $oldView->created_at->addHours(6) <=  Carbon::now()){

    //         $view = new View;
    //         $view->ip_address = $request->input('ipAddress'); 
    //         $view->apartment_id = $apartment->id;
    //         $view->save();
    //          return response()->json([
    //             'success'=>true,
    //             'result'=>$apartment,
    //             'old view'=> $oldView,
    //             'message'=> 'ciao1'
    //         ]);
    //     }
    //     else if($oldView != null && $oldView->ip_address == $request->input('ipAddress') && $oldView->created_at->addHours(6) >  Carbon::now())
    //     {
    //         return response()->json([
    //             'success'=>true,
    //             'result'=>$apartment,
    //             'old view'=> $oldView,
    //             'message'=> 'ciao2'
    //         ]);
    //     }else if( $oldView != null && $oldView->ip_address !== $request->input('ipAddress')){
    //         $view = new View;
    //         $view->ip_address = $request->input('ipAddress'); 
    //         $view->apartment_id = $apartment->id;
    //         $view->save();
    //          return response()->json([
    //             'success'=>true,
    //             'result'=>$apartment,
    //             'old view'=> $oldView,
    //             'message'=> 'ciao3'
    //         ]);
    //     }


        
        
    // }
        public function store(Request $request, string $slug)
{
    $apartment = Apartment::where("slug", $slug)->firstOrFail();
    $oldView = View::where('apartment_id', $apartment->id)->first();

    if ($oldView != null && $oldView->ip_address == $request->input('ipAddress')) {
        if ($oldView->created_at->addHours(6) <= Carbon::now()) {
            // Se sono passate almeno 6 ore
            $message = 'ciao1';
        } else {
            // Se non sono passate 6 ore
            $message = 'ciao2';
        }
    } else {
        // Se $oldView non esiste o l'indirizzo IP non corrisponde
        $message = 'ciao3';
        $view = new View;
        $view->ip_address = $request->input('ipAddress'); 
        $view->apartment_id = $apartment->id;
        $view->save();
    }

    return response()->json([
        'success' => true,
        'result' => $apartment,
        'old view' => $oldView,
        'message' => $message
    ]);
}

    /**
     * Display the specified resource.
     */
    public function show(View $view)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(View $view)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateViewRequest $request, View $view)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(View $view)
    {
        //
    }
}
