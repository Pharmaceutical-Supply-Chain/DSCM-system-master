<?php

namespace App\Http\Controllers\DashboardControllers;

use App\Models\Drug;
use App\Models\User;
use App\Models\Stock;
use App\Models\BuyerSeller;
use App\Models\StockDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\StockDetailsResource;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function displayClients ()
    {
        $clients = BuyerSeller::where('seller_id', Auth::user()->id)->pluck('buyer_id')->all();
        
        return UserResource::collection(
            User::whereIn('id', $clients)->get()
        );
    }

    public function drugShortageAlert ()
    {
        $stocks = Stock::where('user_id', Auth::user()->id)->pluck('id')->all();
        
        return StockDetailsResource::collection(
            StockDetails::whereIn('stock_id', $stocks)->where('drug_amount', '<', 50)->get()
        );
    }

    public function sellers ()
    {
        if (Auth::user()->role_id === "2")
        {
            return UserResource::collection(
                User::where('role_id', '1')->get()
            );
        }
        
        return UserResource::collection(
            User::where('role_id', '2')->get()
        );
    }

    public function search($name)
    {
        $drugs = Drug::query()->where('trade_name', 'LIKE', $name)->orWhere('scientific_name', 'LIKE', $name)
            ->get();

        
        return response()->json($drugs);
    }

    // public function autocomplete(Request $request)
    // {        
    //     $data = Drug::select("id")
    //             ->where("trade_name","LIKE","%{$request->str}%")
    //             ->orWhere("scientific_name","LIKE","%{$request->str}%")
    //             ->get('query');   
    //     return response()->json($data);
    // }
}
