<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        // return $users;
        return $this->sendResponse($users, "Successfully get all customers");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required",
            "email" => "required",
            "address" => "required",
            "phone" => "required",
            "password" => "required",
            "job" => "required",
        ]);

        // if (!$validator->fails()) {
        //     return $this->sendError("Validation Error", $validator->errors());
        // }

        $input = $request->all();
        $input["password"] = Hash::make($input["password"]);
        $newUser = User::create($input);
        $success["user_id"] = $newUser->id;

        return $this->sendResponse($success, "Successfully create new user");
    }

    public function loginUser(Request $request)
    {
        $user = User::where("email", "=", $request->email)->first();

        if (!$user || $user === null) {
            return $this->sendError('Unauthorised.', ['error' => 'User not found']);
        }
        if ($user && !Hash::check($request->password, $user["password"])) {
            return $this->sendError('Unauthorised.', ['error' => 'Invalid password']);
        }

        $success["token"] = $user->createToken("KosanMakIda")->plainTextToken;
        $success['user_id'] =  $user->id;

        return $this->sendResponse($success, 'User login successfully.');
        // if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        //     $user = Auth::user();
        //     $success["token"] = $user->createToken("KosanMakIda")->accessToken;
        //     $success['user_id'] =  $user->id;

        //     return $this->sendResponse($success, 'User login successfully.');
        // } else {
        //     return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->sendResponse($user, "Successfully get single user");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
