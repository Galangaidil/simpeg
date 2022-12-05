<?php

namespace App\Http\Controllers;

use App\Models\OffWork;
use App\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Storage;
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
//        $leaves = match ($request->user()->role_id) {
//            Role::isOwner => OffWork::with('user:id,name')->latest()->get(),
//            Role::isPegawai => OffWork::with('user:id,name')->where('user_id', $request->user()->id)->get(),
//            default => null,
//        };

        if ($request->user()->role_id == Role::isOwner){
            $leaves = OffWork::with('user:id,name')->latest()->get();
        } else {
            $leaves = OffWork::with('user:id,name')->where('user_id', $request->user()->id)->get();
        }

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
     * @param OffWork $offwork
     * @return Response
     * @throws AuthorizationException
     */
    public function show(OffWork $offwork): Response
    {
        $this->authorize('manage', $offwork);

        $offwork['document'] = Storage::url($offwork->document);

        $offwork['user'] = $offwork->user;

        return Inertia::render('Offwork/Show', [
            'offwork' => $offwork,
            'options' => OffWork::optionStatus
        ]);
    }

    /**
     * @param OffWork $offwork
     * @return Response
     * @throws AuthorizationException
     */
    public function edit(OffWork $offwork): Response
    {
        $this->authorize('manage', $offwork);

        $offwork['document_url'] = Storage::url($offwork->document);

        return Inertia::render('Offwork/Edit', [
            'offwork' => $offwork
        ]);
    }

    /**
     * @param Request $request
     * @param OffWork $offwork
     * @return Application|RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function update(Request $request, OffWork $offwork): Redirector|RedirectResponse|Application
    {
        $this->authorize('manage', $offwork);

        $validated = $request->validate([
            'start_date' => 'required|date',
            'finish_date' => 'required|date',
            'reason' => 'required|string|max:1000',
        ]);

        $offwork->update($validated);

        return redirect(route('offworks.index'))->with('message', 'Permohonan cuti berhasil diperbarui.');
    }

    /**
     * @param OffWork $offwork
     * @return Application|RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function destroy(OffWork $offwork): Redirector|RedirectResponse|Application
    {
        $this->authorize('manage', $offwork);

        Storage::delete($offwork->document);

        $offwork->delete();

        return redirect(route('offworks.index'))->with('message', 'Permohonan cuti berhasil dihapus.');
    }

    /**
     * @param Request $request
     * @param OffWork $offwork
     * @return Application|RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function updateStatus(Request $request, OffWork $offwork): Redirector|RedirectResponse|Application
    {
        $this->authorize('updateStatus', $offwork);

        $request->validate([
            'status' => ['required', Rule::in(OffWork::optionStatus)]
        ]);

        $offwork->update($request->only('status'));

        return redirect(route('offworks.show', $offwork->id))->with('message', 'Pengajuan cuti berhasil diperbarui');
    }
}
