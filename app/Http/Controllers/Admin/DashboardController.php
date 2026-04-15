<?php

namespace App\Http\Controllers\Admin;

use App\Models\ArvStaff;
use App\Models\CatchingRecord;
use App\Models\CatchingStaff;
use App\Models\City;
use App\Models\Doctor;
use App\Http\Controllers\Controller;
use App\Models\Hospital;
use App\Models\Ngo;
use App\Models\Vehicle;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Existing master-data counters (kept for current dashboard markup compatibility)
        $cityCount = City::count();
        $ngoCount = Ngo::count();
        $hospitalCount = Hospital::count();
        $doctorCount = Doctor::count();
        $vehicleCount = Vehicle::count();
        $staffCount = ArvStaff::count() + CatchingStaff::count();
        $masterDataCount = $cityCount + $ngoCount + $hospitalCount + $doctorCount + $vehicleCount + $staffCount;

        // Phase 3 lifecycle counters from CatchingRecord
        $totalCaughtCount = CatchingRecord::count();
        $todaysCatchCount = CatchingRecord::whereDate('catch_date', Carbon::today())->count();
        $inProcessCount = CatchingRecord::where('status', 'In Process')->count();
        $observationCount = CatchingRecord::where('status', 'Observation')->count();
        $releasedCount = CatchingRecord::whereIn('status', ['Released', 'Returned to Owner'])->count();
        $expiredCount = CatchingRecord::where('status', 'Expired')->count();

        // Weekly chart payload (last 7 days)
        $weeklyLabels = [];
        $weeklyCaught = [];
        $weeklyReleased = [];
        $weeklyExpired = [];

        for ($i = 6; $i >= 0; $i--) {
            $day = Carbon::today()->subDays($i);
            $weeklyLabels[] = $day->format('D');

            $weeklyCaught[] = CatchingRecord::whereDate('catch_date', $day)->count();
            $weeklyReleased[] = CatchingRecord::whereIn('status', ['Released', 'Returned to Owner'])
                ->whereDate('updated_at', $day)
                ->count();
            $weeklyExpired[] = CatchingRecord::where('status', 'Expired')
                ->whereDate('updated_at', $day)
                ->count();
        }

        // Monthly operation-mix payload (current month)
        $monthStart = Carbon::now()->startOfMonth();
        $monthEnd = Carbon::now()->endOfMonth();

        $monthlyMix = [
            'inProcess' => CatchingRecord::where('status', 'In Process')->whereBetween('updated_at', [$monthStart, $monthEnd])->count(),
            'observation' => CatchingRecord::where('status', 'Observation')->whereBetween('updated_at', [$monthStart, $monthEnd])->count(),
            'r4r' => CatchingRecord::where('status', 'R4R')->whereBetween('updated_at', [$monthStart, $monthEnd])->count(),
            'released' => CatchingRecord::whereIn('status', ['Released', 'Returned to Owner'])->whereBetween('updated_at', [$monthStart, $monthEnd])->count(),
            'expired' => CatchingRecord::where('status', 'Expired')->whereBetween('updated_at', [$monthStart, $monthEnd])->count(),
        ];

        return view('admin.dashboard', compact(
            'cityCount',
            'ngoCount',
            'hospitalCount',
            'doctorCount',
            'vehicleCount',
            'staffCount',
            'masterDataCount',
            'totalCaughtCount',
            'todaysCatchCount',
            'inProcessCount',
            'observationCount',
            'releasedCount',
            'expiredCount',
            'weeklyLabels',
            'weeklyCaught',
            'weeklyReleased',
            'weeklyExpired',
            'monthlyMix'
        ));
    }
}
