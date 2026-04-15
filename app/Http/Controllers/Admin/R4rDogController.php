<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatchingRecord;
use App\Models\DogStageLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class R4rDogController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view r4r', ['only' => ['index', 'show']]);
        $this->middleware('permission:edit r4r', ['only' => ['updateStatus']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CatchingRecord::with(['project'])
                ->where('status', 'R4R')
                ->latest()
                ->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('project_name', function ($row) {
                    if (!$row->project) {
                        return 'N/A';
                    }

                    return $row->project->project_name ?? $row->project->name ?? 'N/A';
                })
                ->addColumn('dog_type', function ($row) {
                    return $row->dog_type ? ucfirst($row->dog_type) : '-';
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
                    $tagNo = $row->tag_no ?: 'N/A';

                    return '<div class="action-icons">'
                        . '<a href="' . route('view-r4r-dog', $row->id) . '" class="btn btn-sm action-icon-btn action-view text-info" title="View" data-id="' . $row->id . '" data-tag-no="' . $tagNo . '"><i class="bx bx-show"></i></a>'
                        . '<button type="button" class="btn btn-sm action-icon-btn action-release text-success" title="Release" data-id="' . $row->id . '" data-tag-no="' . $tagNo . '"><i class="bx bx-share"></i></button>'
                        . '<button type="button" class="btn btn-sm action-icon-btn action-owner text-info" title="Owner" data-id="' . $row->id . '" data-tag-no="' . $tagNo . '"><i class="bx bx-user-check"></i></button>'
                        . '<button type="button" class="btn btn-sm action-icon-btn action-expired text-danger" title="Expired" data-id="' . $row->id . '" data-tag-no="' . $tagNo . '"><i class="bx bx-time"></i></button>'
                        . '</div>';
                })
                ->editColumn('catch_date', function ($row) {
                    return optional($row->catch_date)->format('Y-m-d');
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        return view('admin.r4rdoglist.r4r_dog_list');
    }

    public function show($id)
    {
        $record = CatchingRecord::with(['project', 'hospital', 'vehicle', 'operation.medicines', 'stageLogs.actionBy'])
            ->findOrFail($id);

        return view('admin.r4rdoglist.view_r4r_dog', compact('record'));
    }

    public function updateStatus(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:Released,Returned to Owner,Expired'],
            'remarks' => ['nullable', 'string'],
        ]);

        $record = CatchingRecord::findOrFail($id);

        if ($record->status !== 'R4R') {
            return response()->json([
                'status' => 'error',
                'message' => 'Only R4R dogs can be transitioned.',
            ], 422);
        }

        $record->update(['status' => $validated['status']]);

        DogStageLog::create([
            'catching_record_id' => $record->id,
            'stage' => $validated['status'],
            'action_by' => auth()->id(),
            'remarks' => $validated['remarks'] ?? null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Dog status updated to ' . $validated['status'] . ' successfully.',
        ]);
    }
}
