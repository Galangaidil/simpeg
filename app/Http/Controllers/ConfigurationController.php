<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Location;
use App\Models\User;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class ConfigurationController extends Controller
{
    use HttpResponses;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
     * @param  \App\Models\Configuration  $configuration
     * @return \Illuminate\Http\Response
     */
    public function show(Configuration $configuration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Configuration  $configuration
     * @return \Illuminate\Http\Response
     */
    public function edit(Configuration $configuration)
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Configuration  $configuration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Configuration $configuration)
    {
        $this->authorize('manage', User::class);

        $request->validate([
            'salary' => 'required',
            'workday' => 'required|lte:31',
            'location' => 'required',
            'accepted_distance' => 'required'
        ]);

        $configuration->update([
            'salary' => $request->salary,
            'workday' => $request->workday,
            'location' => $request->location,
            'accepted_distance' => $request->accepted_distance
        ]);

        DB::table('locations')->update(['status' => 'inactive']);

        $location = Location::find($configuration->location);

        $location->update(['status' => 'active']);

        return to_route('configurations.index')->with('message', 'Pengaturan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Configuration  $configuration
     * @return \Illuminate\Http\Response
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
