<?php

namespace App\Http\Controllers;

use App\Models\Rooms;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\StoreRoomsRequest;
use App\Http\Requests\UpdateRoomsRequest;

class RoomsController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Rooms::all();

        return $this->sendResponse($rooms, "Successfully get all rooms");
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
     * @param  \App\Http\Requests\StoreRoomsRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoomsRequest $request)
    {
        $input = $request->all();
        try {
            $imageNames = "";

            $photos = $request->file('file');

            foreach ($photos as $photo) {
                $photoName = trim($photo->getClientOriginalName());
                $photo_name = $photoName . "_" . time() . "." . $photo->getClientOriginalExtension();
                $destinationPath = public_path('/uploads/room_images');
                $photo->move($destinationPath, $photo_name);

                $imageNames = $imageNames . "|" . $photo_name;
            }

            $room =  Rooms::create([
                "number_room" => $input["number_room"],
                "price" => $input["price"],
                "description" => $input["description"],
                "status" => $input["status"],
                "photos" =>  $imageNames,
            ]);

            return $this->sendResponse($room, "Success add room");
        } catch (\Exception $e) {
            return $this->sendError($e, "Failed add room");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function show(Rooms $rooms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function edit(Rooms $rooms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoomsRequest  $request
     * @param  \App\Models\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoomsRequest $request, Rooms $rooms)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rooms $rooms)
    {
        //
    }
}
