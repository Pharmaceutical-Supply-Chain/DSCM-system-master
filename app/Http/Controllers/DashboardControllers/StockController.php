<?php

namespace App\Http\Controllers\DashboardControllers;

use App\Models\Stock;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\StockResource;
use App\Http\Requests\AddStockRequest;

class StockController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return StockResource::collection(
            Stock::where('user_id', Auth::user()->id)->get()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddStockRequest $request)
    {
        $request->validated($request->all());

        $stock = Stock::create([
            'user_id' => Auth::user()->id,
            'stock_number' => $request->stock_number,
            'stock_location' => $request->stock_location,
            'stock_supervisor' => $request->stock_supervisor
        ]);

        return new StockResource($stock);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        return $this->isNotAuthorized($stock) ? $this->isNotAuthorized($stock) : new StockResource($stock);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        if ( $this->isNotAuthorized($stock) ){
            return $this->isNotAuthorized($stock);
        }
        
        $stock->update($request->all());

        return new StockResource($stock);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        return $this->isNotAuthorized($stock) ? $this->isNotAuthorized($stock) : $stock->delete();
    }

    private function isNotAuthorized ($stock) 
    {
        if (Auth::user()->id !== $stock->user_id) {
            return $this->error('', 'You are not authorized to make this request', 403);
        }
    }
}
