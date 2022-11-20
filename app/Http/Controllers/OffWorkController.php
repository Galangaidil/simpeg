<?php

namespace App\Http\Controllers;

use App\Models\OffWork;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Validation\Rule;

class OffWorkController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role_id === Role::isOwner) {
            $offWorks = OffWork::latest()->get();
        } else {
            $offWorks = $user->offworks()->latest()->get();
        }

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
            'reason' => 'required|string|max:1000',
            'document' => 'required|image'
        ]);

        $path = $request->file('document')->store('public/offworks');

        $validated['document'] = $path;

        $request->user()->offworks()->create($validated);

        return redirect(route('offworks.index'))->with('message', 'Permohonan cuti berhasil dibuat.');
    }

    public function show(OffWork $offwork)
    {
        $this->authorize('view', $offwork);

        $offwork['document'] = Storage::url($offwork->document);

        $offwork['user'] = $offwork->user;

        return Inertia::render('Offwork/Show', [
            'offwork' => $offwork,
            'options' => OffWork::optionStatus
        ]);
    }

    public function edit(OffWork $offwork)
    {
        $this->authorize('update', $offwork);

        $offwork['document_url'] = Storage::url($offwork->document);

        return Inertia::render('Offwork/Edit', [
            'offwork' => $offwork
        ]);
    }

    public function update(Request $request, OffWork $offwork)
    {
        $this->authorize('update', $offwork);

        $validated = $request->validate([
            'start_date' => 'required|date',
            'finish_date' => 'required|date',
            'reason' => 'required|string|max:1000',
        ]);

        $offwork->update($validated);

        return redirect(route('offworks.index'))->with('message', 'Permohonan cuti berhasil diperbarui.');
    }

    public function destroy(OffWork $offwork)
    {
        $this->authorize('delete', $offwork);

        Storage::delete($offwork->document);

        $offwork->delete();

        return redirect(route('offworks.index'))->with('message', 'Permohonan cuti berhasil dihapus.');
    }

    public function updateStatus(Request $request, OffWork $offwork)
    {
        $this->authorize('updateStatus', $offwork);

        $request->validate([
            'status' => ['required', Rule::in(OffWork::optionStatus)]
        ]);

        $offwork->update($request->only('status'));

        return redirect(route('offworks.show', $offwork->id))->with('message', 'Pengajuan cuti berhasil diperbarui');
    }
}
