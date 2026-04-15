<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Exports\CompletedOperationExport;
use App\Exports\DailyRunningSheetExport;
use App\Exports\ProjectSummaryExport;
use App\Models\CatchingRecord;
use App\Models\Hospital;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view reports')->only(['dailyRunningSheet', 'projectSummary', 'completedOperationList']);
        $this->middleware('permission:export reports')->only(['exportDailyRunningSheet', 'exportProjectSummary', 'exportCompletedOperationList']);
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

    public function exportProjectSummary(Request $request)
    {
        return Excel::download(
            new ProjectSummaryExport(),
            'project_summary_' . date('Ymd') . '.xlsx'
        );
    }

    public function completedOperationList(Request $request)
    {
        $projects = Project::query()
            ->where('is_active', 1)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $hospitals = Hospital::query()
            ->where('is_active', 1)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        if ($request->ajax()) {
            $query = CatchingRecord::with(['project', 'hospital', 'operation.doctor'])
                ->whereIn('status', ['Released', 'Returned to Owner', 'Expired']);

            if ($request->filled('project_id')) {
                $query->where('project_id', $request->project_id);
            }

            if ($request->filled('hospital_id')) {
                $query->where('hospital_id', $request->hospital_id);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('project_name', function ($row) {
                    return $row->project ? $row->project->name : 'N/A';
                })
                ->addColumn('hospital_name', function ($row) {
                    return $row->hospital ? $row->hospital->name : 'N/A';
                })
                ->addColumn('dog_type', function ($row) {
                    return $row->dog_type ? ucfirst($row->dog_type) : '-';
                })
                ->addColumn('gender', function ($row) {
                    return $row->gender ? ucfirst($row->gender) : '-';
                })
                ->addColumn('status', function ($row) {
                    return $row->status ?? '-';
                })
                ->addColumn('catch_date_formatted', function ($row) {
                    return $row->catch_date ? Carbon::parse($row->catch_date)->format('d M Y') : '-';
                })
                ->addColumn('operation_date', function ($row) {
                    return $row->operation && $row->operation->operation_date
                        ? Carbon::parse($row->operation->operation_date)->format('d M Y')
                        : '-';
                })
                ->addColumn('doctor_name', function ($row) {
                    return $row->operation && $row->operation->doctor ? $row->operation->doctor->name : '-';
                })
                ->addColumn('remarks', function ($row) {
                    return $row->operation && $row->operation->remarks ? e($row->operation->remarks) : '-';
                })
                ->make(true);
        }

        return view('admin.completeoperationlist.completed_operation_list', compact('projects', 'hospitals'));
    }

    public function exportCompletedOperationList(Request $request)
    {
        return Excel::download(
            new CompletedOperationExport($request->project_id, $request->hospital_id),
            'completed_operation_list_' . date('Ymd') . '.xlsx'
        );
    }

    public function exportDailyRunningSheet(Request $request)
    {
        return Excel::download(
            new DailyRunningSheetExport($request->project_id, $request->running_date),
            'daily_running_sheet_' . date('Ymd') . '.xlsx'
        );
    }
}