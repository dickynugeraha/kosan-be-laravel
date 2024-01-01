<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use App\Http\Requests\StoreOrdersRequest;
use App\Http\Requests\UpdateOrdersRequest;
use App\Http\Controllers\BaseController as BaseController;
use App\Models\Rooms;
use Illuminate\Support\Facades\Request;

class OrdersController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function userOrderByWaitingPayment(String $userId)
    {
        try {
            $order = Orders::where("user_id", "=", $userId)->where("status", "=", "waiting_payment")->with("room")->first();
            return $this->sendResponse($order, "Succesfully get user order");
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), "Failed get user order");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreOrdersRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrdersRequest $request)
    {
        $input = $request->all();

        try {
            $newOrder = Orders::create($input);

            $room = Rooms::where("id", "=", $input["room_id"])->first();
            $room->status = "need_payment";
            $room->save();

            return $this->sendResponse($newOrder, "Successfully added order");
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), "Failed added order");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function show(Orders $orders)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function edit(Orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateOrdersRequest  $request
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateOrdersRequest $request, Orders $orders)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function destroy(Orders $orders)
    {
        //
    }
}
