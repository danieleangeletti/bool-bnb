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
    $oldView = View::where('apartment_id', $apartment->id)->orderByDesc('created_at')->first();
              

    if ($oldView != null && $oldView->ip_address == $request->input('ipAddress')) {
        if ($oldView->created_at->addHours(6) < Carbon::now()) {
            
            $view = new View;
            $view->ip_address = $request->input('ipAddress');
            $view->apartment_id = $apartment->id;
            $view->save();
    } else {
      
        $message = 'ciao2';
    }
             
} else {
  
   
    $view = new View;
    $view->ip_address = $request->input('ipAddress'); 
    $view->apartment_id = $apartment->id;
    $view->save();
}
            

    return response()->json([
        'success' => true,
        'result' => $apartment,
        'old view' => $oldView
    ]);
}

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $apartment = Apartment::findOrFail($id);
        $messagesCount = $apartment->messages()->count();
        $viewsCount = $apartment->views_count;

        return view('apartments.show', compact('apartment', 'messagesCount', 'viewsCount'));
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
