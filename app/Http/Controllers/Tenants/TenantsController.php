<?php

namespace App\Http\Controllers\Tenants;

use Illuminate\Http\Request;
use App\Tenants\Models\Tenant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use App\Http\Requests\Tenants\TenantsRequest;

class TenantsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user()
            ->tenants()
            ->paginateByRequest();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TenantsRequest $request)
    {
        $tenant = Tenant::create($request->validated());

        return Response::json([
            'message' => 'Tenant was created successfully',
            'tenant' => $tenant,
        ])->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(TenantsRequest $request, Tenant $tenant)
    {
        $this->authorize('ownership', $tenant);

        $tenant->persistAttributes($request->validated());

        return response()->json([
            'message' => 'Tenant was updated successfully',
            'tenant' => $tenant,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tenant $tenant)
    {
        $this->authorize('ownership', $tenant);

        $tenant->delete();

        return response()->json(['message' => 'Tenant was deleted successfully']);
    }
}
