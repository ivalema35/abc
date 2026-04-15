<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Hospital;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view vehicle')->only(['index', 'show']);
        $this->middleware('permission:add vehicle')->only(['create', 'store']);
        $this->middleware('permission:edit vehicle')->only(['edit', 'update', 'toggleStatus']);
        $this->middleware('permission:delete vehicle')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Vehicle::with(['city', 'hospital'])->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('city_name', function ($row) {
                    return $row->city ? $row->city->city_name : 'N/A';
                })
                ->addColumn('hospital_name', function ($row) {
                    return $row->hospital ? $row->hospital->name : 'N/A';
                })
                ->addColumn('password_mask', function () {
                    return '****';
                })
                ->addColumn('image', function ($row) {
                    if (! $row->image) {
                        return '<span class="badge bg-label-secondary">No Image</span>';
                    }

                    $url = asset($row->image);

                    return '<img src="' . $url . '" alt="' . e($row->vehicle_number) . '" class="project-image">';
                })
                ->addColumn('is_active', function ($row) {
                    $checked = $row->is_active ? 'checked' : '';
                    $disabled = auth()->user()->can('edit vehicle') ? '' : 'disabled';

                    return '<label class="switch switch-primary">'
                        . '<input type="checkbox" class="switch-input toggle-status" data-id="' . $row->id . '" ' . $checked . ' ' . $disabled . '>'
                        . '<span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span>'
                        . '</label>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-inline-block action-icons">';

                    if (auth()->user()->can('edit vehicle')) {
                        $btn .= '<a href="' . route('manage-vehicle.edit', $row->id) . '" class="btn action-icon-btn action-edit text-warning me-2 item-edit" title="Edit"><i class="bx bx-edit"></i></a>';
                    }

                    if (auth()->user()->can('delete vehicle')) {
                        $btn .= '<button type="button" class="btn action-icon-btn action-delete text-danger item-delete" data-id="' . $row->id . '" title="Delete"><i class="bx bx-trash"></i></button>';
                    }

                    $btn .= '</div>';

                    return $btn;
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y');
                })
                ->rawColumns(['image', 'is_active', 'action'])
                ->make(true);
        }

        return view('admin.vehicle.manage_vehicle');
    }

    public function create()
    {
        $vehicle = new Vehicle();
        $hospitals = Hospital::where('is_active', 1)
            ->when($vehicle->exists && $vehicle->hospital_id, fn ($query) => $query->orWhere('id', $vehicle->hospital_id))
            ->select('id', 'name')
            ->get();
        $cities = City::where('is_active', 1)
            ->when($vehicle->exists && $vehicle->city_id, fn ($query) => $query->orWhere('id', $vehicle->city_id))
            ->select('id', 'city_name')
            ->get();

        return view('admin.vehicle.add_edit_vehicle', compact('vehicle', 'hospitals', 'cities'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'city_id' => 'required|exists:cities,id',
            'vehicle_number' => 'required|string|max:20|unique:vehicles,vehicle_number',
            'login_id' => 'required|string|max:100|unique:vehicles,login_id',
            'login_password' => 'required|string|min:4',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $directory = public_path('uploads/vehicles');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $imagePath = 'uploads/vehicles/' . $filename;
        }

        $vehicle = Vehicle::create([
            'hospital_id' => $request->hospital_id,
            'city_id' => $request->city_id,
            'vehicle_number' => $request->vehicle_number,
            'login_id' => $request->login_id,
            'login_password' => Hash::make($request->login_password),
            'image' => $imagePath,
            'is_active' => 1,
        ]);

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => 'Vehicle added successfully!',
            'vehicle' => [
                'id' => $vehicle->id,
                'name' => $vehicle->vehicle_number,
                'vehicle_number' => $vehicle->vehicle_number,
            ],
            'redirect_url' => route('manage-vehicle.index'),
        ]);
    }

    public function show($id)
    {
        return redirect()->route('manage-vehicle.edit', $id);
    }

    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $hospitals = Hospital::where('is_active', 1)
            ->when($vehicle->exists && $vehicle->hospital_id, fn ($query) => $query->orWhere('id', $vehicle->hospital_id))
            ->select('id', 'name')
            ->get();
        $cities = City::where('is_active', 1)
            ->when($vehicle->exists && $vehicle->city_id, fn ($query) => $query->orWhere('id', $vehicle->city_id))
            ->select('id', 'city_name')
            ->get();

        return view('admin.vehicle.add_edit_vehicle', compact('vehicle', 'hospitals', 'cities'));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $vehicle = Vehicle::findOrFail($id);

        $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'city_id' => 'required|exists:cities,id',
            'vehicle_number' => ['required', 'string', 'max:20', Rule::unique('vehicles', 'vehicle_number')->ignore($vehicle->id)],
            'login_id' => ['required', 'string', 'max:100', Rule::unique('vehicles', 'login_id')->ignore($vehicle->id)],
            'login_password' => 'nullable|string|min:4',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = [
            'hospital_id' => $request->hospital_id,
            'city_id' => $request->city_id,
            'vehicle_number' => $request->vehicle_number,
            'login_id' => $request->login_id,
        ];

        if ($request->filled('login_password')) {
            $data['login_password'] = Hash::make($request->login_password);
        }

        if ($request->hasFile('image')) {
            $directory = public_path('uploads/vehicles');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $data['image'] = 'uploads/vehicles/' . $filename;
        }

        $vehicle->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Vehicle updated successfully!',
            'redirect_url' => route('manage-vehicle.index'),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $vehicle = Vehicle::findOrFail($id);

        try {
            $vehicle->delete();
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to delete vehicle. It may be linked to other records.',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Vehicle deleted successfully!',
        ]);
    }

    public function toggleStatus($id): JsonResponse
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->update([
            'is_active' => $vehicle->is_active ? 0 : 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vehicle status updated successfully!',
            'is_active' => (bool) $vehicle->is_active,
        ]);
    }
}