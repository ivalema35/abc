<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\ArvStaff;
use App\Models\CatchingStaff;
use App\Models\City;
use App\Models\Doctor;
use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Ngo;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $cityCount = City::count();
        $ngoCount = Ngo::count();
        $hospitalCount = Hospital::count();
        $doctorCount = Doctor::count();
        $vehicleCount = Vehicle::count();
        $staffCount = ArvStaff::count() + CatchingStaff::count();
        $masterDataCount = $cityCount + $ngoCount + $hospitalCount + $doctorCount + $vehicleCount + $staffCount;

        return response()->json([
            'success' => true,
            'message' => 'Dashboard data fetched',
            'data' => [
                'cityCount' => $cityCount,
                'ngoCount' => $ngoCount,
                'hospitalCount' => $hospitalCount,
                'doctorCount' => $doctorCount,
                'vehicleCount' => $vehicleCount,
                'staffCount' => $staffCount,
                'masterDataCount' => $masterDataCount,
            ],
        ]);
    }
}
