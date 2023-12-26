<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController as BaseController;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loginAdmin(Request $request)
    {
        $input = $request->all();

        $admin = Admin::where("email", "=", $input["email"])->first();

        try {
            if (!$admin) {
                return $this->sendError("Admin not found", "Cannot find email admin");
            }
            if ($admin && !Hash::check($input["password"], $admin["passwod"])) {
                return $this->sendError("Invalid password", "Password wrong");
            }

            $success["token"] = $admin->createToken("KosanMakIda")->plainTextToken;
            $success['user_id'] =  $admin->id;

            return $this->sendResponse($success, "Login successfully");
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), "Error, something wrong");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
