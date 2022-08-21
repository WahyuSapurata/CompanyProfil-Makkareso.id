<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

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
            "categori" => "required|string|in:web,mobile,logo,sosmed,illustration",
            "date" => "required|date",
            "price" => "required|numeric|min:0",
            "duration" => "required|string",
            "client" => "required|string",
            "designer" => "required|string",
        ]);
        if ($validator->fails()) {
            return response()->json(["errors" => $validator->errors()], 422);
        }
        $data = $validator->validated();
        $projects = new Project;
        $projects->fill($data);
        dd($projects);
    // $projects->image = $data->image;
    // $projects->image = $data->image;
    // $projects->image = $data->image;
    // $projects->image = $data->image;
    // $projects->image = $data->image;
    // $projects->image = $data->image;
    // $projects->image = $data->image;
    // $projects->image = $data->image;
    // $projects->image = $data->image;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    //
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
    //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    //
    }
}
