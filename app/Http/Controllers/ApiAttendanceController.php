<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Configuration;
use App\Models\Location;
use App\Traits\HttpResponses;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApiAttendanceController extends Controller
{
    use HttpResponses;

    public function index()
    {
        $attendances = auth()->user()->attendances()->latest()->get();

        $withDiffForHumans = $attendances->map(function($item){
            return [
                'id' => $item->id,
                "user_id" => $item->user_id,
                "latitude" => $item->latitude,
                "longitude" => $item->longitude,
                "distance" => $item->distance,
                "status" => $item->status,
                "created_at" => $item->created_at,
                "updated_at" => $item->updated_at,
                "diffForHuman" => Carbon::parse($item->created_at)->toDateTimeString()
            ];
        });

        return response()->json($withDiffForHumans);
    }

    public function store(Request $request)
    {
        if ($this->has_the_user_taken_attendace_today() > 0) {
            return $this->errors("Presensi gagal.", [
                'hint' => "Anda telah melakukan presensi."
            ]);
        }

        $conf = $this->get_current_configuration();

        if (strtotime($request->time) >= strtotime($conf['start']) && strtotime($request->time) <= strtotime($conf['end'])) {
            $distance = $this->count_distance($request->latitude, $request->longitude);

            if ($distance['m'] > (int)$conf['accepted_distance']) {
                return $this->errors("Presensi gagal.", [
                    "hint" => "Jarak anda dari lokasi presensi: " . round($distance['m'], 2) . " meter."
                ]);
            } else {
                $validated = $request->validate([
                    'time' => 'required',
                    'latitude' => 'required',
                    'longitude' => 'required'
                ]);

                $validated['distance'] = $distance['m'];

                $request->user()->attendances()->create($validated);
                return $this->simple('Presensi berhasil.');
            }
        } else {
            return $this->errors("Bukan waktu presensi.", [
                'hint' => "Waktu presensi adalah " . $conf['start'] . " - " . $conf['end'] . "."
            ]);
        }
    }

    public function has_the_user_taken_attendace_today()
    {
        return Attendance::where('user_id', auth()->user()->id)
            ->whereDate('created_at', Carbon::today())->get()->count();
    }

    public function get_current_configuration()
    {
        return Configuration::findOrFail(1);
    }

    public function get_active_location()
    {
        return Location::findOrFail((int)$this->get_current_configuration()['location']);
    }

    public function count_distance($lat, $long)
    {
        $location = $this->get_active_location();

        $latActive = deg2rad($location->latitude);
        $longActive = deg2rad($location->longitude);
        $latRequest = deg2rad($lat);
        $longRequest = deg2rad($long);

        $dlong = $longRequest - $longActive;
        $dlat = $latRequest - $latActive;

        $val = pow(sin($dlat / 2), 2) + cos($latActive) * cos($latRequest) * pow(sin($dlong / 2), 2);
        $res = 2 * asin(sqrt($val));

        $radius = 3958.756;
        $distance = $res * $radius;

        return [
            'km' => $distance * 1.609344,
            'm' => $distance * 1609.34
        ];
    }
}
