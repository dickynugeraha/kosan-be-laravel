<?php

namespace App\Http\Controllers;

use App\Models\Rooms;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Requests\StoreRoomsRequest;
use App\Http\Requests\UpdateRoomsRequest;
use Illuminate\Http\Request;

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
        $temp = array();

        foreach ($rooms as $room) {
            $arrPhotos = explode("|", $room["photos"]);

            array_push($temp, [
                "id" => $room["id"],
                "number_room" => $room["number_room"],
                "price" => $room["price"],
                "description" => $room["description"],
                "status" => $room["status"],
                "photos" => $arrPhotos,
            ]);
        }

        return $this->sendResponse($temp, "Successfully get all rooms");
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
     * @param  \App\Http\Requests\UpdateRoomsRequest $request
     * @param  \App\Models\Rooms $room
     * @return \Illuminate\Http\Response
     */
    public function updateRoom(Request $request, String $roomId)
    {
        $input = $request->all();

        $imageNewNames = "";
        
        try {
            $room = Rooms::where("id", "=", $roomId)->first();

            if ($input["is_update_photos"] === "true" || $input["is_update_photos"] === true){
                $photos = $request->file('file');

                foreach ($photos as $photo) {
                    $photoName = trim($photo->getClientOriginalName());
                    $photo_name = $photoName . "_" . time() . "." . $photo->getClientOriginalExtension();
                    $destinationPath = public_path('/uploads/room_images');
                    $photo->move($destinationPath, $photo_name);
    
                    $imageNewNames = $imageNewNames . "|" . $photo_name;
                }

                $oldPhotos = explode("|", $room->photo_transfer);

                foreach ($oldPhotos as $photo) {
                    $image = public_path('uploads/room_images/') . $photo;
                    if (file_exists($image)) @unlink($image);
                }
            } else {
                $imageNewNames = $room->photo_transfer;
            }
            $input["photo_transfer"] = $imageNewNames;

            $room->update([
                "number_room" => $input["number_room"],
                "price" => $input["price"],
                "description" => $input["description"],
                "status" => $input["status"],
                "photos" =>  $imageNewNames,
            ]);

            return $this->sendResponse($room, "Success update room");
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), "Failed update room");

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rooms  $rooms
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rooms $room)
    {
        try {
            $room->delete();
            return $this->sendResponse($room, "Successfully deleted room");
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), "Failed delete room");
        }
    }
}
