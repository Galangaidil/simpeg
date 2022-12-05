<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Master/Location/Index', [
            'locations' => Location::latest()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     * @throws AuthorizationException
     */
    public function create(): Response
    {
        $this->authorize('manage', auth()->user());

        return Inertia::render('Master/Location/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(Request $request): RedirectResponse
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
     * @param Location $location
     * @return Response
     */
    public function show(Location $location): Response
    {
        return Inertia::render('Master/Location/Show', [
            'location' => $location
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Location $location
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(Location $location): Response
    {
        $this->authorize('manage', auth()->user());

        return Inertia::render('Master/Location/Edit', [
            'location' => $location
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Location $location
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function update(Request $request, Location $location): RedirectResponse
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
     * @param Location $location
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function destroy(Location $location): RedirectResponse
    {
        $this->authorize('manage', auth()->user());

        $location->delete();

        return to_route('locations.index')->with('message', 'Lokasi berhasil dihapus');
    }
}
