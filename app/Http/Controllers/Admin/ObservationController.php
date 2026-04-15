<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatchingRecord;
use App\Models\DogStageLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ObservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view observation', ['only' => ['index', 'show']]);
        $this->middleware('permission:edit observation', ['only' => ['updateStatus']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CatchingRecord::with(['project', 'hospital', 'vehicle', 'operation'])
                ->where('status', 'Observation')
                ->latest()
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('project_name', function ($row) {
                    return $row->project ? $row->project->name : 'N/A';
                })
                ->addColumn('dog_type', function ($row) {
                    return ucfirst($row->dog_type);
                })
                ->addColumn('gender', function ($row) {
                    return $row->gender ? ucfirst($row->gender) : '-';
                })
                ->addColumn('image', function ($row) {
                    if (!$row->image) {
                        return '<span class="badge bg-label-secondary">No Image</span>';
                    }

                    return '<img src="' . asset($row->image) . '" alt="Dog Image" width="50" class="rounded">';
                })
                ->addColumn('action', function ($row) {
                    return '<div class="action-icons">' .
                        '<a href="' . route('view-observation-dog-list', $row->id) . '" class="btn btn-sm action-icon-btn action-view text-info" title="View"><i class="bx bx-show"></i></a>' .
                        '<button type="button" class="btn btn-sm action-icon-btn action-r4r text-success" title="R4R" data-id="' . $row->id . '" data-tag-no="' . ($row->tag_no ?: 'N/A') . '"><i class="fas fa-check-circle"></i></button>' .
                        '<button type="button" class="btn btn-sm action-icon-btn action-expired text-danger" title="Expired" data-id="' . $row->id . '" data-tag-no="' . ($row->tag_no ?: 'N/A') . '"><i class="fas fa-circle-xmark"></i></button>' .
                        '</div>';
                })
                ->editColumn('catch_date', function ($row) {
                    return optional($row->catch_date)->format('Y-m-d');
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('admin.observationdoglist.observation_dog_list');
    }

    public function show($id)
    {
        $record = CatchingRecord::with(['project', 'hospital', 'vehicle', 'operation.medicines', 'stageLogs.actionBy'])
            ->findOrFail($id);

        return view('admin.observationdoglist.view_observation_dog', compact('record'));
    }

    public function updateStatus(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:R4R,Expired'],
            'remarks' => ['nullable', 'string'],
        ]);

        $record = CatchingRecord::findOrFail($id);

        // Ensure record is in Observation state
        if ($record->status !== 'Observation') {
            return response()->json([
                'status' => 'error',
                'message' => 'Only observation dogs can be transitioned.',
            ], 422);
        }

        // Update status
        $newStatus = $validated['status'] === 'R4R' ? 'R4R' : 'Expired';
        $record->update(['status' => $newStatus]);

        // Log the stage transition
        DogStageLog::create([
            'catching_record_id' => $record->id,
            'stage' => $newStatus,
            'action_by' => auth()->id(),
            'remarks' => $validated['remarks'] ?? null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Dog status updated to ' . $newStatus . ' successfully.',
        ]);
    }
}
