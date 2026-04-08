<?php

namespace App\Http\Controllers\Admin;

use App\Models\ArvStaff;
use App\Models\CatchingStaff;
use App\Models\City;
use App\Models\Doctor;
use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Ngo;
use App\Models\Vehicle;

class DashboardController extends Controller
{
    public function index()
    {
        $cityCount = City::count();
        $ngoCount = Ngo::count();
        $hospitalCount = Hospital::count();
        $doctorCount = Doctor::count();
        $vehicleCount = Vehicle::count();
        $staffCount = ArvStaff::count() + CatchingStaff::count();
        $masterDataCount = $cityCount + $ngoCount + $hospitalCount + $doctorCount + $vehicleCount + $staffCount;

        return view('admin.dashboard', compact(
            'cityCount',
            'ngoCount',
            'hospitalCount',
            'doctorCount',
            'vehicleCount',
            'staffCount',
            'masterDataCount'
        ));
    }
}
