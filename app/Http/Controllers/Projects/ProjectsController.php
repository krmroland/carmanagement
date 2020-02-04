<?php

namespace App\Http\Controllers\Projects;

use App\Users\Models\User;
use Illuminate\Http\Request;
use App\Contracts\ProjectOwner;
use App\Http\Controllers\Controller;
use App\Users\Models\OwnerUniqueName;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Projects\ProjectRequest;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProjectOwner $projectOwner)
    {
        return $projectOwner->projects()->paginateByRequest();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request, ProjectOwner $projectOwner)
    {
        $project = $projectOwner->projects()->create($request->validated());

        return Response::json(
            ['message' => 'Project was created successfully', 'project' => $project],
            201
        );
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
