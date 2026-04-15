<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatchingRecord;
use App\Models\Doctor;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProcessDogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CatchingRecord::with(['project', 'hospital', 'vehicle'])
                ->where('status', 'Caught')
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
                        '<button type="button" class="btn btn-sm action-icon-btn action-accept text-success" title="Accept" data-record-id="' . $row->id . '" data-tag-no="' . ($row->tag_no ?: 'N/A') . '" data-bs-toggle="modal" data-bs-target="#operationModal">' .
                        '<i class="fas fa-check-circle"></i>' .
                        '</button>' .
                        '<button type="button" class="btn btn-sm action-icon-btn action-reject text-danger" title="Reject">' .
                        '<i class="fas fa-times-circle"></i>' .
                        '</button>' .
                        '</div>';
                })
                ->editColumn('catch_date', function ($row) {
                    return optional($row->catch_date)->format('Y-m-d');
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        $doctors = Doctor::where('is_active', 1)->select('id', 'name')->orderBy('name')->get();
        $medicines = Medicine::where('is_active', 1)->select('id', 'name')->orderBy('name')->get();

        return view('admin.processdoglist.process_dog_list', compact('doctors', 'medicines'));
    }
}
