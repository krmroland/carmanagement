<?php

namespace App\Http\Controllers\Users;

use App\Users\Models\User;
use Illuminate\Http\Request;
use App\Users\Models\Organization;
use App\Http\Controllers\Controller;

class OrganizationUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Users\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function index(Organization $organization)
    {
        $organization->gate()->authorize();

        return $organization->members()->paginateByRequest();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Users\Models\Organization  $organization
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Organization $organization)
    {
        $organization->gate()->authorize('members:write');

        $request->validate(['user_id' => 'required|exists:users,id']);

        $organization->addMember(User::findOrFail($request->user_id));

        return response()->json(['message' => 'Operation was successful']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Users\Models\Organization  $organization
     * @param  \App\Users\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Organization $organization, User $user)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Users\Models\Organization  $organization
     * @param  \App\Users\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Organization $organization, User $user)
    {
        $organization
            ->gate()
            ->authorize('members:write')
            ->ensureMemberExists($user);

        $request->validate(['abilities' => 'sometimes|array']);

        $organization->gate($user)->updateAbilities($request->abilities);

        return response()->json(['message' => 'User organization settings were set successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Users\Models\Organization  $organization
     * @param  \App\Users\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Organization $organization, User $user)
    {
        $organization
            ->gate()
            ->authorize('organization:remove_member')
            ->ensureMemberExists($user)
            ->members()
            ->detach($user);

        return response()->json(['message' => 'user was removed successfully']);
    }
}
