<?php

namespace App\Http\Controllers;

use App\Models\OffWork;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Validation\Rule;
use Inertia\Response;

class OffWorkController extends Controller
{
    /**
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $leaves = match ($request->user()->role_id) {
            Role::isOwner => OffWork::with('user:id,name')->latest()->get(),
            Role::isPegawai => OffWork::with('user:id,name')->where('user_id', $request->user()->id)->get(),
            default => null,
        };

        return Inertia::render('Offwork/Index', [
            'offworks' => $leaves
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Offwork/Create');
    }


    /**
     * @param Request $request
     * @return Redirector|Application|RedirectResponse
     */
    public function store(Request $request): Redirector|Application|RedirectResponse
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

    /**
     * @param Request $request
     * @param OffWork $offwork
     * @return Response
     */
    public function show(Request $request, OffWork $offwork): Response
    {
        if ($request->user()->cannot('view', $offwork)){
            abort(403);
        }

        $offwork['document'] = Storage::url($offwork->document);

        $offwork['user'] = $offwork->user;

        return Inertia::render('Offwork/Show', [
            'offwork' => $offwork,
            'options' => OffWork::optionStatus
        ]);
    }

    public function edit(Request $request, OffWork $offwork)
    {
        if ($request->user()->cannot('update', $offwork)){
            abort(403);
        }

        $offwork['document_url'] = Storage::url($offwork->document);

        return Inertia::render('Offwork/Edit', [
            'offwork' => $offwork
        ]);
    }

    public function update(Request $request, OffWork $offwork)
    {
        if ($request->user()->cannot('update', $offwork)){
            abort(403);
        }

        $validated = $request->validate([
            'start_date' => 'required|date',
            'finish_date' => 'required|date',
            'reason' => 'required|string|max:1000',
        ]);

        $offwork->update($validated);

        return redirect(route('offworks.index'))->with('message', 'Permohonan cuti berhasil diperbarui.');
    }

    public function destroy(Request $request, OffWork $offwork)
    {
        if ($request->user()->cannot('delete', $offwork)){
            abort(403);
        }

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
