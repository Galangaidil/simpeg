<?php

namespace App\Http\Controllers;

use App\Models\OffWork;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class OffWorkController extends Controller
{
    public function index()
    {
        // dd(Carbon::today()->toDateString());
        $offWork = OffWork::where('created_at', Carbon::today()->toDateString())->get();

        return Inertia::render('Offwork/Index', [
            'offworks' => $offWork
        ]);
    }

    public function create()
    {
        return Inertia::render('Offwork/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'finish_date' => 'required|date',
            'reason' => 'required|string|max:250',
            'document' => 'nullable|string'
        ]);

        $request->user()->offworks()->create($validated);

        return redirect(route('offworks.index'))->with('message', 'Permohonan cuti berhasil dibuat.');
    }

    public function show(OffWork $offWork)
    {
        return Inertia::render('Offwork/Show', [
            'offwork' => $offWork
        ]);
    }

    public function edit(OffWork $offWork)
    {
        return Inertia::render('Offwork/Edit', [
            'offwork' => $offWork
        ]);
    }

    public function update(Request $request, OffWork $offWork)
    {
        $validated = $request->validate([
            'start_date' => 'required|date',
            'finish_date' => 'required|date',
            'reason' => 'required|string|max:250',
            'document' => 'nullable|string'
        ]);

        $request->user()->offworks()->update($validated);

        return redirect(route('offworks.index'))->with('message', 'Permohonan cuti berhasil diperbarui.');
    }

    public function destroy(OffWork $offWork)
    {
        $offWork->delete();

        return redirect(route('offworks.index'))->with('message', 'Permohonan cuti berhasil dihapus.');
    }
}
