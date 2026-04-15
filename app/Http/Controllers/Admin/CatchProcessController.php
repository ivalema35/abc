<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatchingRecord;
use Illuminate\Support\Facades\DB;

class CatchProcessController extends Controller
{
    public function index()
    {
        $counts = CatchingRecord::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        return view('admin.catchprocess.catch_process', compact('counts'));
    }
}
