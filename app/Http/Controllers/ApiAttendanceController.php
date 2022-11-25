<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Location;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;

class ApiAttendanceController extends Controller
{
    use HttpResponses;

    public function store(Request $request)
    {
        $conf = $this->get_current_configuration();

        if (strtotime($request->time) >= strtotime($conf['start']) && strtotime($request->time) <= strtotime($conf['end'])) {
            $distance = $this->count_distance($request->latitude, $request->longitude);

            if ($distance['m'] > (int)$conf['accepted_distance']) {
                return $this->errors("Presensi gagal.", [
                    "distance" => "Jarak anda dari lokasi presensi: " . round($distance['m'], 2) . " meter."
                ]);
            } else {
                return $this->simple('Presensi berhasil');
            }

        } else {
            return $this->errors("Bukan waktu presensi.", [
                'hint' => "Waktu presensi adalah " . $conf['start'] . " - " . $conf['end'] . "."
            ]);
        }
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
