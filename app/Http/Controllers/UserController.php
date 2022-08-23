<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json("", 501);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = validator($request->all(), [
            "name" => "required|min:4",
            "email" => "required|email:rfc|unique:users,email",
            "username" => "required|string|min:4|unique:users,username",
            "password" => "required|string|min:4",
            "role" => "required|string",
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $user = User::create($data);
        $token = $user->createToken($user->username);
        info("[user:register] { username: $user->username }", $user->toArray());
        return response()->json([
            "data" => $user,
            "token" => $token->plainTextToken,
        ], 201);
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function auth(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(["errors" => "User not found"], 404);
        }
        return response()->json(["data" => $user], 200);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = validator($request->all(), [
            "username" => "required|string|min:4",
            "password" => "required|string|min:4",
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $user = User::firstWhere('username', $data['username']);
        if (!is_null($user)) {
            if ($data['password'] == $user->password) {
                $token = $user->createToken($user->username);
                info("[user:login] { username: $user->username }", $user->toArray());
                return response()->json([
                    "data" => $user,
                    "token" => $token->plainTextToken,
                ], 200);
            }
            return response()->json(["errors" => "username or password wrong"], 400);
        }
        return response()->json(["errors" => "User not found"], 404);
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(["data" => "success"], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        return response()->json("", 501);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return response()->json("", 501);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = validator($request->all(), [
            "image" => "string",
            "name" => "string|min:4",
            "email" => "email:rfc|unique:users,email",
            "phone" => "string|unique:users,phone",
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $user = User::find($id);
        if (!$user) {
            return response()->json(["errors" => "User not found"], 404);
        }
        $user->fill($data);
        $user->save();
        return response()->json(["data" => $user], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        return response()->json("", 501);
    }
}
