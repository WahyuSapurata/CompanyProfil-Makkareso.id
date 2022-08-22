<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StorageController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function local_download(Request $request, $path)
    {
        $path = Str::of($path)->replace("storage", "");
        if (!Storage::exists($path)) {
            abort(404);
        }
        $url = Storage::path($path);
        return response()->file($url);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function local_upload(Request $request)
    {
        $validator = validator($request->all(), [
            "file" => "required|file|max:5000",
            "dir" => "required|string",
            "name" => "required|string",
            "public" => "required|string|in:true,false",
        ]);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $file = $request->file("file");
        $ext = $file->extension();
        if (!!$data['public']) {
            $result = $file->storePubliclyAs("public/{$data['dir']}", "{$data['name']}.$ext");
        }
        else {
            $result = $file->storeAs($data['dir'], "{$data['name']}.$ext");
        }
        $path = "/storage/$result";
        if (!is_string($result)) {
            return response()->json("", 500);
        }
        return response()->json(["data" => $path], 201);
    }

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function local_remove(Request $request, $path)
    {
        $path = Str::of($path)->replace("storage", "");
        Storage::exists($path) && Storage::delete($path);
        return response()->json(["message" => "success"], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort(501);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(501);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort(501);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        abort(501);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort(501);
    }
}
