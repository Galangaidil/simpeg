<?php

namespace App\Http\Controllers;

use App\Models\OffWork;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Inertia\Inertia;

class OffWorkController extends Controller
{
    public function index()
    {
        $offWorks = OffWork::whereDate('created_at', Carbon::today()->toDateString())->get();

        $limitReason = $offWorks->map(function($item) {
            return [
                'id' => $item->id,
                'user_id' => $item->user_id,
                'start_date' => $item->start_date,
                'finish_date' => $item->finish_date,
                'reason' => Str::limit($item->reason, 30, '...'),
                'document' => $item->document,
                'status' => $item->status,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'user_name' => $item->user->name
            ];
        });

        return Inertia::render('Offwork/Index', [
            'offworks' => $limitReason
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
