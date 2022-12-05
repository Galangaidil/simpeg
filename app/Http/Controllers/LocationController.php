<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Master/Location/Index', [
            'locations' => Location::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('manage', auth()->user());

        return Inertia::render('Master/Location/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('manage', auth()->user());

        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        Location::create($request->only(['name', 'latitude', 'longitude']));

        return to_route('locations.index')->with('message', 'Lokasi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Location $location)
    {
        return Inertia::render('Master/Location/Show', [
            'location' => $location
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location)
    {
        $this->authorize('manage', auth()->user());

        return Inertia::render('Master/Location/Edit', [
            'location' => $location
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $this->authorize('manage', auth()->user());

        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|max:200',
            'longitude' => 'required|max:200',
        ]);

        $location->update($request->only(['name', 'latitude', 'longitude']));

        return to_route('locations.index')->with('message', 'Lokasi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        $this->authorize('manage', auth()->user());

        $location->delete();

        return to_route('locations.index')->with('message', 'Lokasi berhasil dihapus');
    }
}
