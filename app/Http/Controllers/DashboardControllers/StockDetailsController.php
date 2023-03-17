<?php

namespace App\Http\Controllers\DashboardControllers;

use App\Models\User;
use App\Models\Stock;
use App\Models\StockDetails;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\StockDetailsResource;
use App\Http\Requests\AddStockDetailsRequest;

class StockDetailsController extends Controller
{
    use HttpResponses;
    
    public function index ()
    {
        $stocks = Stock::where('user_id', Auth::user()->id)->pluck('id')->all();
        
        return StockDetailsResource::collection(
            StockDetails::whereIn('stock_id', $stocks)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddStockDetailsRequest $request)
    {
        $request->validated($request->all());

        $stock = Stock::where('id', $request->stock_id)->first();
        //return response()->json($stock);
        if ( $this->isNotAuthorized($stock) ){
            return $this->isNotAuthorized($stock);
        }
        
        $stockDetails = StockDetails::create([
            'drug_amount' => $request->drug_amount,
            'drug_entry_date' => $request->drug_entry_date,
            'drug_residual' => $request->drug_residual,
            'production_date' => $request->production_date,
            'expiration_date' => $request->expiration_date,
            'drug_unit_price' => $request->drug_unit_price,
            'stock_id' => $request->stock_id,
            'drug_id' => $request->drug_id
        ]);

        return new StockDetailsResource($stockDetails);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\StockDetails  $stockDetails
     * @return \Illuminate\Http\Response
     */
    public function show(StockDetails $stockDetails)
    {
        // if ($stockDetails === null)
        // {
        //     return response()->json("Not Found");
        // }
        $stock = Stock::where('id', $stockDetails->stock_id)->first();
        
        if ( $this->isNotAuthorized($stock) ){
            return $this->isNotAuthorized($stock);
        }
        
        return new StockDetailsResource($stockDetails);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\StockDetails  $stockDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, StockDetails $stockDetails)
    {
        $stock = Stock::where('id', $stockDetails->stock_id)->first();
        
        if ( $this->isNotAuthorized($stock) ){
            return $this->isNotAuthorized($stock);
        }
        
        $stockDetails->update($request->all());

        return new StockDetailsResource($stockDetails);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StockDetails  $stockDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(StockDetails $stockDetails)
    {
        $stock = Stock::where('id', $stockDetails->stock_id)->first();
        
        if ( $this->isNotAuthorized($stock) ){
            return $this->isNotAuthorized($stock);
        }
        
        return $stockDetails->delete();
    }

    public function getStockDetails(Stock $stock)
    {
        if ( $this->isNotAuthorized($stock) ){
            return $this->isNotAuthorized($stock);
        }

        return StockDetailsResource::collection(
            StockDetails::where('stock_id', $stock->id)->get()
        );
    }

    public function getStockDetailsOfUser (User $user)
    {
        $stocks = Stock::where('user_id', $user->id)->pluck('id')->all();
        
        return StockDetailsResource::collection(
            StockDetails::whereIn('stock_id', $stocks)->get()
        );
    }

    private function isNotAuthorized ($stock) 
    {
        if (Auth::user()->id !== $stock->user_id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        }
    }


}
