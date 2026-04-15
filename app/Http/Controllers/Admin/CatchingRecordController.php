<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\CatchingRecord;
use App\Models\CatchingStaff;
use App\Models\DogStageLog;
use App\Models\Hospital;
use App\Models\Project;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CatchingRecordController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view catching record', ['only' => ['index', 'show']]);
        $this->middleware('permission:add catching record', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit catching record', ['only' => ['edit', 'update', 'quickRelease']]);
        $this->middleware('permission:delete catching record', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CatchingRecord::with(['project', 'hospital', 'catchingStaff', 'vehicle'])->latest();

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
                    if (! $row->image) {
                        return '<span class="badge bg-label-secondary">No Image</span>';
                    }

                    return '<img src="' . asset($row->image) . '" alt="' . e($row->tag_no ?: 'Catching Record') . '" class="project-image">';
                })
                ->addColumn('address', function ($row) {
                    return $row->address ? e($row->address) : '-';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-inline-block action-icons">';

                    if (auth()->user()->can('edit catching record')) {
                        $btn .= '<button type="button" class="btn action-icon-btn text-warning me-2 item-edit" data-id="' . $row->id . '" title="Edit"><i class="bx bx-edit"></i></button>';
                    }

                    if (auth()->user()->can('delete catching record')) {
                        $btn .= '<button type="button" class="btn action-icon-btn text-danger item-delete" data-id="' . $row->id . '" title="Delete"><i class="bx bx-trash"></i></button>';
                    }

                    $btn .= '</div>';

                    return $btn;
                })
                ->editColumn('catch_date', function ($row) {
                    return optional($row->catch_date)->format('d M Y');
                })
                ->rawColumns(['image', 'action'])
                ->make(true);
        }

        $cities = City::where('is_active', 1)->select('id', 'city_name')->get();
        $projects = Project::where('is_active', 1)->select('id', 'name')->get();
        $hospitals = Hospital::where('is_active', 1)->select('id', 'name')->get();
        $staff = CatchingStaff::where('is_active', 1)->select('id', 'name')->get();
        $vehicles = Vehicle::where('is_active', 1)->select('id', 'vehicle_number')->get();

        return view('admin.catching_records.manage_catching_records', compact('cities', 'projects', 'hospitals', 'staff', 'vehicles'));
    }

    public function create()
    {
        $cities = City::where('is_active', 1)->select('id', 'city_name')->get();
        $projects = Project::where('is_active', 1)->select('id', 'name', 'city_id')->get();
        $hospitals = Hospital::where('is_active', 1)->select('id', 'name', 'city_id')->get();
        $catchingStaffs = CatchingStaff::where('is_active', 1)->select('id', 'name', 'city_id')->get();
        $vehicles = Vehicle::where('is_active', 1)->select('id', 'vehicle_number')->get();

        return view('admin.catching_records.form_catching_record', compact(
            'cities',
            'projects',
            'hospitals',
            'catchingStaffs',
            'vehicles'
        ));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'hospital_id' => ['required', 'exists:hospitals,id'],
            'catching_staff_id' => ['required', 'exists:catching_staff,id'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'tag_no' => ['nullable', 'string', 'max:255'],
            'catch_date' => ['required', 'date'],
            'dog_type' => ['required', 'in:stray,pet'],
            'gender' => ['nullable', 'in:male,female'],
            'street' => ['nullable', 'string', 'max:255'],
            'owner_name' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'latitude' => ['nullable', 'string'],
            'longitude' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        if ($request->hasFile('image')) {
            $directory = public_path('uploads/catching_records');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $validated['image'] = 'uploads/catching_records/' . $filename;
        }

        $record = CatchingRecord::create([
            'project_id' => $validated['project_id'],
            'hospital_id' => $validated['hospital_id'],
            'catching_staff_id' => $validated['catching_staff_id'],
            'vehicle_id' => $validated['vehicle_id'],
            'tag_no' => $validated['tag_no'] ?? null,
            'catch_date' => $validated['catch_date'],
            'dog_type' => $validated['dog_type'],
            'gender' => $validated['gender'] ?? null,
            'street' => $validated['street'] ?? null,
            'owner_name' => $validated['owner_name'] ?? null,
            'address' => $validated['address'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'image' => $validated['image'] ?? null,
            'is_active' => true,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Catching record saved successfully!',
            'record' => [
                'id' => $record->id,
                'tag_no' => $record->tag_no,
            ],
        ]);
    }

    public function cityMasters(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'city_id' => ['required', 'exists:cities,id'],
        ]);

        $projects = Project::where('is_active', 1)
            ->where('city_id', $validated['city_id'])
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        $hospitals = Hospital::where('is_active', 1)
            ->where('city_id', $validated['city_id'])
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'status' => 'success',
            'projects' => $projects,
            'hospitals' => $hospitals,
        ]);
    }

    public function projectStaff(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
        ]);

        $project = Project::select('id', 'city_id')->findOrFail($validated['project_id']);

        $staff = CatchingStaff::where('is_active', 1)
            ->where('city_id', $project->city_id)
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'status' => 'success',
            'staff' => $staff,
        ]);
    }

    public function show($id)
    {
        $record = CatchingRecord::with(['project', 'hospital', 'catchingStaff', 'vehicle'])->findOrFail($id);
        $vehicles = Vehicle::where('is_active', 1)->select('id', 'vehicle_number')->get();

        return view('admin.catching_records.view_catching_record', compact('record', 'vehicles'));
    }

    public function edit($id)
    {
        $record = CatchingRecord::with(['project', 'hospital', 'catchingStaff', 'vehicle'])->findOrFail($id);
        $cities = City::where('is_active', 1)->select('id', 'city_name')->get();
        $projects = Project::where('is_active', 1)->select('id', 'name', 'city_id')->get();
        $hospitals = Hospital::where('is_active', 1)->select('id', 'name', 'city_id')->get();
        $catchingStaffs = CatchingStaff::where('is_active', 1)->select('id', 'name', 'city_id')->get();
        $vehicles = Vehicle::where('is_active', 1)->select('id', 'vehicle_number')->get();

        return view('admin.catching_records.form_catching_record', compact(
            'record',
            'cities',
            'projects',
            'hospitals',
            'catchingStaffs',
            'vehicles'
        ));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validated = $request->validate([
            'project_id' => ['required', 'exists:projects,id'],
            'hospital_id' => ['required', 'exists:hospitals,id'],
            'catching_staff_id' => ['required', 'exists:catching_staff,id'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'tag_no' => ['nullable', 'string', 'max:255'],
            'catch_date' => ['required', 'date'],
            'dog_type' => ['required', 'in:stray,pet'],
            'gender' => ['nullable', 'in:male,female'],
            'street' => ['nullable', 'string', 'max:255'],
            'owner_name' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
            'latitude' => ['nullable', 'string'],
            'longitude' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
        ]);

        $record = CatchingRecord::findOrFail($id);

        if ($request->hasFile('image')) {
            $directory = public_path('uploads/catching_records');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            if ($record->image && file_exists(public_path($record->image))) {
                unlink(public_path($record->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $validated['image'] = 'uploads/catching_records/' . $filename;
        } else {
            $validated['image'] = $record->image;
        }

        $record->update([
            'project_id' => $validated['project_id'],
            'hospital_id' => $validated['hospital_id'],
            'catching_staff_id' => $validated['catching_staff_id'],
            'vehicle_id' => $validated['vehicle_id'],
            'tag_no' => $validated['tag_no'] ?? null,
            'catch_date' => $validated['catch_date'],
            'dog_type' => $validated['dog_type'],
            'gender' => $validated['gender'] ?? null,
            'street' => $validated['street'] ?? null,
            'owner_name' => $validated['owner_name'] ?? null,
            'address' => $validated['address'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'image' => $validated['image'] ?? null,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Catching record updated successfully!',
            'record' => [
                'id' => $record->id,
                'tag_no' => $record->tag_no,
            ],
        ]);
    }

    public function quickRelease($id): JsonResponse
    {
        $record = CatchingRecord::findOrFail($id);
        $record->update([
            'status' => 'Released',
        ]);

        DogStageLog::create([
            'catching_record_id' => $record->id,
            'stage' => 'Released',
            'action_by' => auth()->id(),
            'remarks' => 'Quick Released directly from Catcher Profile view.',
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Dog released successfully.',
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $record = CatchingRecord::findOrFail($id);
        $record->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Catching record deleted successfully!',
        ]);
    }
}
