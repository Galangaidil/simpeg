<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Location;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ConfigurationController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     * @throws AuthorizationException
     */
    public function index(): \Inertia\Response
    {
        $this->authorize('manage', auth()->user());

        $configuration = Configuration::find(1);

        $location = Location::find($configuration->location);

        return Inertia::render('Master/Configuration/Index', [
            'configuration' => $configuration,
            'location' => $location
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Configuration $configuration
     * @return Response
     */
    public function show(Configuration $configuration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Configuration $configuration
     * @return \Inertia\Response
     * @throws AuthorizationException
     */
    public function edit(Configuration $configuration): \Inertia\Response
    {
        $this->authorize('manage', User::class);

        return Inertia::render('Master/Configuration/Edit', [
            'configuration' => $configuration,
            'locations' => Location::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Configuration $configuration
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, Configuration $configuration): RedirectResponse
    {
        $this->authorize('manage', User::class);

        $request->validate([
            'location' => 'required',
            'accepted_distance' => 'required',
            'start' => 'required',
            'end' => 'required'
        ]);

        $configuration->update($request->all());

        DB::table('locations')->update(['status' => 'inactive']);

        $location = Location::find($configuration->location);

        $location->update(['status' => 'active']);

        return to_route('configurations.index')->with('message', 'Pengaturan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Configuration $configuration
     * @return Response
     */
    public function destroy(Configuration $configuration)
    {
        //
    }

    public function getCurrentConf()
    {
        $configuration = Configuration::find(1);

        $location = Location::find($configuration->location);

        return $this->success([
            'configuration' => $configuration,
            'location' => $location
        ], "Konfigurasi berhasil didapatkan");
    }
}
