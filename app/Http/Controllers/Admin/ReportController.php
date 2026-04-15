<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatchingRecord;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view reports')->only(['dailyRunningSheet', 'projectSummary']);
        $this->middleware('permission:export reports')->only(['exportDailyRunningSheet']);
    }

    public function dailyRunningSheet(Request $request)
    {
        $projects = Project::query()
            ->where('is_active', 1)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        if ($request->ajax()) {
            $query = CatchingRecord::query()
                ->leftJoin('projects', 'projects.id', '=', 'catching_records.project_id')
                ->leftJoin('hospitals', 'hospitals.id', '=', 'catching_records.hospital_id')
                ->leftJoin('dog_operations', 'dog_operations.catching_record_id', '=', 'catching_records.id')
                ->select([
                    'catching_records.id',
                    'catching_records.project_id',
                    'catching_records.hospital_id',
                    'catching_records.tag_no',
                    'catching_records.catch_date',
                    'catching_records.status',
                    'projects.name as project_name',
                    'hospitals.name as hospital_name',
                    'dog_operations.body_weight as surgery_body_weight',
                    'dog_operations.operation_date as surgery_date',
                    'dog_operations.remarks as surgery_remarks',
                ])
                ->where(function ($builder) {
                    $builder->whereIn('catching_records.status', ['Observation', 'Released'])
                        ->orWhereNotNull('dog_operations.id');
                });

            if ($request->filled('project_id')) {
                $query->where('catching_records.project_id', $request->project_id);
            }

            if ($request->filled('running_date')) {
                $query->where(function ($dateBuilder) use ($request) {
                    $dateBuilder->whereDate('catching_records.catch_date', $request->running_date)
                        ->orWhereDate('dog_operations.operation_date', $request->running_date);
                });
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('catch_date_formatted', function ($row) {
                    return $row->catch_date ? Carbon::parse($row->catch_date)->format('d M Y') : '-';
                })
                ->addColumn('surgery_date_formatted', function ($row) {
                    return $row->surgery_date ? Carbon::parse($row->surgery_date)->format('d M Y') : '-';
                })
                ->addColumn('body_weight', function ($row) {
                    if ($row->surgery_body_weight === null) {
                        return '-';
                    }

                    return rtrim(rtrim(number_format((float) $row->surgery_body_weight, 2, '.', ''), '0'), '.') . ' kg';
                })
                ->make(true);
        }

        return view('admin.dailyrunnigsheet.daily_running_sheet', compact('projects'));
    }

    public function projectSummary(Request $request)
    {
        if ($request->ajax()) {
            $query = CatchingRecord::query()
                ->leftJoin('projects', 'projects.id', '=', 'catching_records.project_id')
                ->leftJoin('dog_operations', 'dog_operations.catching_record_id', '=', 'catching_records.id')
                ->selectRaw(
                    'catching_records.project_id,
                    COALESCE(projects.name, "Unassigned") as project_name,
                    COUNT(DISTINCT catching_records.id) as total_caught,
                    COUNT(DISTINCT dog_operations.id) as operated_count,
                    SUM(CASE WHEN catching_records.status IN ("Released", "Returned to Owner") THEN 1 ELSE 0 END) as released_count,
                    SUM(CASE WHEN catching_records.status = "Expired" THEN 1 ELSE 0 END) as expired_count'
                )
                ->groupBy('catching_records.project_id', 'projects.name')
                ->orderBy('project_name');

            return DataTables::of($query)
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.projectsummary.project_summary');
    }

    public function exportDailyRunningSheet()
    {
        abort(501, 'Daily running sheet export is not implemented yet.');
    }
}