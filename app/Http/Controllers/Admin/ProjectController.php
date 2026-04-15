<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Hospital;
use App\Models\Ngo;
use App\Models\Project;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Project::with(['ngo', 'city', 'hospital', 'vehicle'])->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $checked = $row->is_active ? 'checked' : '';
                    $disabled = auth()->user()->can('edit project') ? '' : 'disabled';

                    return '<label class="switch switch-primary">'
                        . '<input type="checkbox" class="switch-input toggle-status" data-id="' . $row->id . '" ' . $checked . ' ' . $disabled . '>'
                        . '<span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span>'
                        . '</label>';
                })
                ->addColumn('action', function ($row) {
                    return '<div class="d-inline-block action-icons">'
                        . '<a href="' . route('manage-project.edit', $row->id) . '" class="btn btn-sm btn-icon action-icon-btn text-warning me-2 item-edit" title="Edit"><i class="bx bx-edit"></i></a>'
                        . '<button type="button" class="btn btn-sm btn-icon action-icon-btn text-danger item-delete" data-id="' . $row->id . '" title="Delete"><i class="bx bx-trash"></i></button>'
                        . '</div>';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y');
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }

        $ngos = Ngo::where('is_active', 1)->get();
        $cities = City::where('is_active', 1)->get();
        $hospitals = Hospital::where('is_active', 1)->get();
        $vehicles = Vehicle::where('is_active', 1)->get();

        return view('admin.project.manage_project', compact('ngos', 'cities', 'hospitals', 'vehicles'));
    }

    public function create()
    {
        $ngos = Ngo::where('is_active', 1)->get();
        $cities = City::where('is_active', 1)->get();
        $hospitals = Hospital::where('is_active', 1)->get();
        $vehicles = Vehicle::where('is_active', 1)->get();

        return view('admin.project.add_project', compact('ngos', 'cities', 'hospitals', 'vehicles'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'ngo_id' => ['required', 'integer', 'exists:ngos,id'],
            'city_id' => ['required', 'integer', 'exists:cities,id'],
            'hospital_id' => ['required', 'integer', 'exists:hospitals,id'],
            'vehicle_id' => ['required', 'integer', 'exists:vehicles,id'],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('projects', 'name')
                    ->ignore($request->id)
                    ->whereNull('deleted_at'),
            ],
            'rfid_enabled' => ['nullable', 'boolean'],
            'contact' => ['nullable', 'string', 'max:20'],
            'pin' => ['nullable', 'string', 'max:4'],
        ]);

        Project::updateOrCreate(
            ['id' => $request->input('id')],
            [
                'ngo_id' => $request->ngo_id,
                'city_id' => $request->city_id,
                'hospital_id' => $request->hospital_id,
                'vehicle_id' => $request->vehicle_id,
                'name' => $request->name,
                'rfid_enabled' => $request->boolean('rfid_enabled'),
                'contact' => $request->contact,
                'pin' => $request->pin,
            ]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Project saved successfully!',
        ]);
    }

    public function show($id): JsonResponse
    {
        $project = Project::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $project,
        ]);
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);

        $ngos = Ngo::where('is_active', 1)->get();
        $cities = City::where('is_active', 1)->get();
        $hospitals = Hospital::where('is_active', 1)->get();
        $vehicles = Vehicle::where('is_active', 1)->get();

        return view('admin.project.add_project', compact('project', 'ngos', 'cities', 'hospitals', 'vehicles'));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->merge(['id' => $id]);

        return $this->store($request);
    }

    public function destroy($id): JsonResponse
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Project deleted successfully!',
        ]);
    }

    public function toggleStatus(Request $request): JsonResponse
    {
        $project = Project::findOrFail($request->id);
        $project->update([
            'is_active' => $project->is_active ? 0 : 1,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Project status updated successfully!',
            'is_active' => (bool) $project->is_active,
        ]);
    }
}