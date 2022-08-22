<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Arr;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(["data" => Project::all()], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = validator($request->all(), [
            "image" => "required|string",
            "title" => "required|string",
            "description" => "required|string",
            "category" => "required|string|in:web,mobile,logo,sosmed,illustration",
            "date" => "required|date",
            "price" => "required|numeric|min:0",
            "duration" => "required|string",
            "client" => "required|string",
            "designer" => "required|string",
        ]);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }
        $data = Arr::add($validator->validated(), 'published_at', today()->toString());
        $project = Project::create($data);
        return response()->json(["data" => $project], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = Project::find($id);
        if (!$result) {
            return response()->json(["message" => "Not Found"], 404);
        }
        return response()->json(["data" => $result], 200);
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
        $result = Project::find($id);
        if (!$result) {
            return response()->json(["message" => "Not Found"], 404);
        }
        $validator = validator($request->all(), [
            "image" => "string",
            "title" => "string",
            "description" => "string",
            "category" => "string|in:web,mobile,logo,sosmed,illustration",
            "date" => "date",
            "price" => "numeric|min:0",
            "duration" => "string",
            "client" => "string",
            "designer" => "string",
        ]);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }
        $result = Project::find($id);
        if (!$result) {
            return response()->json(["message" => "Not Found"], 404);
        }
        $result->update($validator->validated());
        return response()->json(["data" => $result], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $result = Project::find($id);
        if (!$result) {
            return response()->json(["message" => "Not Found"], 404);
        }
        $result->delete();
        return response()->json(["data" => $result], 200);
    }
}
