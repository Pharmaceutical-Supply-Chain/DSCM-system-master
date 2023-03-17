<?php

namespace App\Http\Controllers\DashboardControllers;

use Carbon\Carbon;
use App\Models\Order;
use App\Models\Stock;
use App\Models\BuyerSeller;
use App\Models\OrderDetails;
use App\Models\StockDetails;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;
use App\Http\Requests\StoreOrderRequest;

class OrderController extends Controller
{
    use HttpResponses;
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        $orderDate = Carbon::now();
        $orderDate->toDateTimeString();

        $request->validated($request->all());

        $order = Order::create([
            'order_description' => $request->order_description,
            'order_date' => $orderDate,
            'buyer_stock_number' => $request->buyer_stock_number
        ]);

        $buyerSeller = BuyerSeller::create([
            'order_id' => $order->id,
            'buyer_id' => Auth::user()->id,
            'seller_id' => $request->seller_id
        ]);

        return new OrderResource($order);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $buyerSellerOrder = BuyerSeller::where('order_id', $order->id)->first();
        
        if (Auth::user()->id === $buyerSellerOrder->buyer_id || Auth::user()->id === $buyerSellerOrder->seller_id)
        {
            return new OrderResource($order);
        }

        return $this->error('', 'You are not authorized to make this request', 403);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        $buyerSellerOrder = BuyerSeller::where('order_id', $order->id)->first();
        
        if (Auth::user()->id === $buyerSellerOrder->buyer_id)
        {
            $order->update($request->all());

            return response()->json($order);
        }

        return $this->error('', 'You are not authorized to make this request', 403);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $buyerSellerOrder = BuyerSeller::where('order_id', $order->id)->first();
        
        if (Auth::user()->id === $buyerSellerOrder->buyer_id)
        {
            $order->delete();

            return response()->json('Order Deleted');
        }

        return $this->error('', 'You are not authorized to make this request', 403);
    }

    public function getBuyerOrders ()
    {
        $buyerSellerOrder = BuyerSeller::where('buyer_id', Auth::user()->id)->pluck('order_id')->all();

        return OrderResource::collection(
            Order::where('id', $buyerSellerOrder)->get()
        );
    }

    public function getSellerOrders ()
    {
        $buyerSellerOrder = BuyerSeller::where('seller_id', Auth::user()->id)->pluck('order_id')->all();

        return OrderResource::collection(
            Order::where('id', $buyerSellerOrder)->get()
        );
    }

    public function performOrder(Order $order)
    {
        $entryDate = Carbon::now();
        $entryDate->toDateTimeString();

        $totalCost = 0.0;
        
        $orderDetails = OrderDetails::where('order_id', $order->id)->get();
        $buyerStock = Stock::where('stock_number', $order->buyer_stock_number)->first();
        
        
        foreach ($orderDetails as $od) {
            # code...
            $orderedAmount = $od->drug_amount;
            $stockDetails = StockDetails::where('id', $od->stock_details_id)->first();
            $stockAmount = $stockDetails->drug_amount;
            $newAmount = $stockAmount - $orderedAmount;

            $totalCost = $totalCost + $od->drug_total_cost;

            $buyerStockDetails = StockDetails::create([
                'drug_amount' => $od->drug_amount,
                'drug_entry_date' => $entryDate,
                'drug_residual' => $stockDetails->drug_residual,
                'production_date' => $stockDetails->production_date,
                'expiration_date' => $stockDetails->expiration_date,
                'drug_unit_price' => $stockDetails->drug_unit_price,
                'stock_id' => $buyerStock->id,
                'drug_id' => $stockDetails->drug_id
            ]);

            $stockDetails->drug_amount = $newAmount;
            $stockDetails->save();
        }

        $order->status = "Performed";
        $order->order_total_cost = $totalCost;
        $order->save();
        return new OrderResource($order);
    }
}
