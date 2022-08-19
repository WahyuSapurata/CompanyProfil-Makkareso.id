<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json("Not Implemented", 501);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function key()
    {
        return response(csrf_token(), 200);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(StoreAdminRequest $request)
    {
        $data = $request->validated();
        $data = array_merge($data, ["logged" => false]);
        $admin = Admin::create($data);
        return response()->json(["data" => $admin], 201);
    }

    /**
     * @param  \App\Http\Requests\StoreAdminRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = validator($request->all(), [
            "username" => "required|min:8",
            "password" => "required|min:8",
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $result = Admin::firstWhere('username', $data['username']);
        if (!is_null($result)) {
            if ($data['password'] == $result->password) {
                $request->session()->put(["sub" => $result->id]);
                return response()->json(["data" => $result], 200);
            }
            return response()->json(["errors" => "username or password wrong"], 400);
        }
        return response()->json(["errors" => "Data not found"], 404);
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->session()->forget('sub');
        return response()->json(["data" => "success"], 200);
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function auth(Request $request)
    {
        $id = $request->session()->get('sub');
        if (!$id) {
            return response()->json(["errors" => "Not authenticate"], 401);
        }
        $result = Admin::find($id);
        if (!$result) {
            return response()->json(["errors" => "Data not found"], 404);
        }
        return response()->json(["data" => $result], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Admin $admin)
    {
        return response()->json("Not Implemented", 501);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdminRequest  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        return response()->json("Not Implemented", 501);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Admin $admin)
    {
        return response()->json("Not Implemented", 501);
    }
}
