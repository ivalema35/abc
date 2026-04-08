<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Doctor;
use App\Models\Hospital;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view doctor')->only(['index', 'show']);
        $this->middleware('permission:add doctor')->only(['create', 'store']);
        $this->middleware('permission:edit doctor')->only(['edit', 'update', 'toggleStatus']);
        $this->middleware('permission:delete doctor')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Doctor::with(['city', 'hospital'])->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('hospital_name', function ($row) {
                    return $row->hospital ? $row->hospital->name : 'N/A';
                })
                ->addColumn('city_name', function ($row) {
                    return $row->city ? $row->city->city_name : 'N/A';
                })
                ->addColumn('email', function ($row) {
                    return $row->email ?: '-';
                })
                ->addColumn('image', function ($row) {
                    if (! $row->image) {
                        return '<span class="badge bg-label-secondary">No Image</span>';
                    }

                    $url = asset($row->image);

                    return '<img src="' . $url . '" alt="' . e($row->name) . '" class="project-image">';
                })
                ->addColumn('is_active', function ($row) {
                    $checked = $row->is_active ? 'checked' : '';
                    $disabled = auth()->user()->can('edit doctor') ? '' : 'disabled';

                    return '<label class="switch switch-primary">'
                        . '<input type="checkbox" class="switch-input toggle-status" data-id="' . $row->id . '" ' . $checked . ' ' . $disabled . '>'
                        . '<span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span>'
                        . '</label>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-inline-block action-icons">';

                    if (auth()->user()->can('edit doctor')) {
                        $btn .= '<a href="' . route('manage-doctor.edit', $row->id) . '" class="btn action-icon-btn action-edit text-warning me-2 item-edit" title="Edit"><i class="bx bx-edit"></i></a>';
                    }

                    $btn .= '<a href="' . route('manage-doctor.show', $row->id) . '" class="btn action-icon-btn action-view text-info me-2" title="View"><i class="bx bx-show"></i></a>';

                    if (auth()->user()->can('edit doctor')) {
                        $btn .= '<button type="button" class="btn action-icon-btn text-info me-2 toggle-status" data-id="' . $row->id . '" title="Toggle Status"><i class="bx bx-power-off"></i></button>';
                    }

                    if (auth()->user()->can('delete doctor')) {
                        $btn .= '<button type="button" class="btn action-icon-btn text-danger item-delete" data-id="' . $row->id . '" title="Delete"><i class="bx bx-trash"></i></button>';
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

        return view('admin.doctor.manage_doctor');
    }

    public function create()
    {
        $doctor = new Doctor();
        $hospitals = Hospital::where('is_active', 1)
            ->when($doctor->exists && $doctor->hospital_id, fn ($query) => $query->orWhere('id', $doctor->hospital_id))
            ->select('id', 'name')
            ->get();
        $cities = City::where('is_active', 1)
            ->when($doctor->exists && $doctor->city_id, fn ($query) => $query->orWhere('id', $doctor->city_id))
            ->select('id', 'city_name')
            ->get();

        return view('admin.doctor.add_edit_doctor', compact('doctor', 'hospitals', 'cities'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $directory = public_path('uploads/doctors');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $imagePath = 'uploads/doctors/' . $filename;
        }

        Doctor::create([
            'hospital_id' => $request->hospital_id,
            'city_id' => $request->city_id,
            'name' => $request->name,
            'contact' => $request->contact,
            'email' => $request->email,
            'address' => $request->address,
            'image' => $imagePath,
            'is_active' => 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Doctor added successfully!',
            'redirect_url' => route('manage-doctor.index'),
        ]);
    }

    public function show($id)
    {
        $doctor = Doctor::with(['hospital', 'city'])->findOrFail($id);

        return view('admin.doctor.view_doctor', compact('doctor'));
    }

    public function edit($id)
    {
        $doctor = Doctor::findOrFail($id);
        $hospitals = Hospital::where('is_active', 1)
            ->when($doctor->exists && $doctor->hospital_id, fn ($query) => $query->orWhere('id', $doctor->hospital_id))
            ->select('id', 'name')
            ->get();
        $cities = City::where('is_active', 1)
            ->when($doctor->exists && $doctor->city_id, fn ($query) => $query->orWhere('id', $doctor->city_id))
            ->select('id', 'city_name')
            ->get();

        return view('admin.doctor.add_edit_doctor', compact('doctor', 'hospitals', 'cities'));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $doctor = Doctor::findOrFail($id);

        $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'image' => 'nullable|image|max:5120',
        ]);

        $data = [
            'hospital_id' => $request->hospital_id,
            'city_id' => $request->city_id,
            'name' => $request->name,
            'contact' => $request->contact,
            'email' => $request->email,
            'address' => $request->address,
        ];

        if ($request->hasFile('image')) {
            $directory = public_path('uploads/doctors');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $data['image'] = 'uploads/doctors/' . $filename;
        }

        $doctor->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Doctor updated successfully!',
            'redirect_url' => route('manage-doctor.index'),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $doctor = Doctor::findOrFail($id);

        try {
            $doctor->delete();
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to delete doctor. It may be linked to other records.',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Doctor deleted successfully!',
        ]);
    }

    public function toggleStatus($id): JsonResponse
    {
        $doctor = Doctor::findOrFail($id);
        $doctor->update([
            'is_active' => $doctor->is_active ? 0 : 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Doctor status updated successfully!',
            'is_active' => (bool) $doctor->is_active,
        ]);
    }
}