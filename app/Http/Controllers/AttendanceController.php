<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Configuration;
use App\Models\Location;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Validation\ValidationException;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $attendances = match ($request->input('filter')) {
            "today" => Attendance::with('user:id,name')->whereDate('created_at', Carbon::today())->latest()->get(),
            "yesterday" => Attendance::with('user:id,name')->whereDate('created_at', Carbon::yesterday())->latest()->get(),
            "this_week" => Attendance::with('user:id,name')->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->latest()->get(),
            "this_month" => Attendance::with('user:id,name')->whereMonth('created_at', date('m'))->whereYear('created_at', date('Y'))->latest()->get(),
            default => [],
        };

        if ($request->has('start') && $request->has('end')){
            $attendances = Attendance::with('user:id,name')->whereBetween('created_at', [$request->input('start'), $request->input('end')])->get();
        }

        return Inertia::render('Attendance/Index', [
            'attendances' => $attendances,
            'filtered' => $request->input('filter')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        // Get all user id and name
        $users = User::select('id', 'name')->get();

        // Get all status attendances
        $status = collect(['hadir', 'izin', 'alpha']);

        // Get lat, long from active location
        $location = Location::findOrFail((int)Configuration::find(1)->location)->only(['latitude', 'longitude']);

        return Inertia::render('Attendance/Create', [
            'users' => $users,
            'status' => $status,
            'location' => $location
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $has_the_user_taken_attendace_today = Attendance::where('user_id', $request->input('user_id'))
            ->whereDate('created_at', Carbon::today())->get()->count();

        if ($has_the_user_taken_attendace_today > 0){
            throw ValidationException::withMessages([
                'message' => 'Pegawai telah melakukan presensi.'
            ]);
        }

        $validated = $request->validate([
            'user_id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'distance' => 'required',
            'status' => 'required'
        ]);

        Attendance::create($validated);

        return to_route('attendances.index')->with('message', 'Presensi berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return Response
     */
    public function show(Attendance $attendance): Response
    {
        return Inertia::render('Attendance/Show', [
            'attendance' => $attendance,
            'username' => $attendance->user->name,
            'location' => Location::find((int)Configuration::find(1)->location),
            'status' => ['hadir', 'izin', 'alpha']
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Attendance $attendance)
    {
        $attendance->update($request->all());

        return to_route('attendances.show', $attendance)->with('message', 'Presensi berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return to_route('attendances.index')->with('message', 'Presensi berhasil dihapus.');
    }
}
