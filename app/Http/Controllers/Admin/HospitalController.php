<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Hospital;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class HospitalController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view hospital')->only(['index', 'show']);
        $this->middleware('permission:add hospital')->only(['create', 'store']);
        $this->middleware('permission:edit hospital')->only(['edit', 'update', 'toggleStatus']);
        $this->middleware('permission:delete hospital')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Hospital::with('city')->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('city_name', function ($row) {
                    return $row->city ? $row->city->city_name : 'N/A';
                })
                ->addColumn('rfid_range', function ($row) {
                    return ($row->rfid_start ?: '-') . ' - ' . ($row->rfid_end ?: '-');
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
                    $disabled = auth()->user()->can('edit hospital') ? '' : 'disabled';

                    return '<label class="switch switch-primary">'
                        . '<input type="checkbox" class="switch-input toggle-status" data-id="' . $row->id . '" ' . $checked . ' ' . $disabled . '>'
                        . '<span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span>'
                        . '</label>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-inline-block action-icons">';

                    if (auth()->user()->can('edit hospital')) {
                        $btn .= '<a href="' . route('manage-hospital.edit', $row->id) . '" class="btn action-icon-btn text-warning me-2 item-edit" title="Edit"><i class="bx bx-edit"></i></a>';
                    }

                    $btn .= '<a href="' . route('view-hospital', $row->id) . '" class="btn action-icon-btn text-info me-2" title="View"><i class="bx bx-show"></i></a>';

                    if (auth()->user()->can('edit hospital')) {
                        $btn .= '<button type="button" class="btn action-icon-btn text-info me-2 toggle-status" data-id="' . $row->id . '" title="Toggle Status"><i class="bx bx-power-off"></i></button>';
                    }

                    if (auth()->user()->can('delete hospital')) {
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

        return view('admin.hospital.manage_hospital');
    }

    public function create()
    {
        $hospital = new Hospital();
        $cities = City::where('is_active', 1)
            ->when($hospital->exists && $hospital->city_id, fn ($query) => $query->orWhere('id', $hospital->city_id))
            ->select('id', 'city_name')
            ->get();

        return view('admin.hospital.add_edit_hospital', compact('hospital', 'cities'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'login_pin' => 'required|digits:4',
            'rfid_start' => 'nullable|string|max:255',
            'rfid_end' => 'nullable|string|max:255',
            'net_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $directory = public_path('uploads/hospitals');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $imagePath = 'uploads/hospitals/' . $filename;
        }

        $hospital = Hospital::create([
            'city_id' => $request->city_id,
            'name' => $request->name,
            'contact' => $request->contact,
            'email' => $request->email,
            'address' => $request->address,
            'login_pin' => $request->login_pin,
            'rfid_start' => $request->rfid_start,
            'rfid_end' => $request->rfid_end,
            'net_quantity' => $request->net_quantity,
            'image' => $imagePath,
            'is_active' => 1,
        ]);

        if ($request->boolean('quick_add')) {
            return response()->json([
                'status' => 'success',
                'success' => true,
                'message' => 'Hospital added successfully!',
                'hospital' => [
                    'id' => $hospital->id,
                    'name' => $hospital->name,
                ],
            ]);
        }

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => 'Hospital added successfully!',
            'hospital' => [
                'id' => $hospital->id,
                'name' => $hospital->name,
            ],
            'redirect_url' => route('manage-hospital.index'),
        ]);
    }

    public function show($id)
    {
        $hospital = Hospital::with('city')->findOrFail($id);

        return view('admin.hospital.view_hospital', compact('hospital'));
    }

    public function edit($id)
    {
        $hospital = Hospital::findOrFail($id);
        $cities = City::where('is_active', 1)
            ->when($hospital->exists && $hospital->city_id, fn ($query) => $query->orWhere('id', $hospital->city_id))
            ->select('id', 'city_name')
            ->get();

        return view('admin.hospital.add_edit_hospital', compact('hospital', 'cities'));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $hospital = Hospital::findOrFail($id);

        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'login_pin' => 'required|digits:4',
            'rfid_start' => 'nullable|string|max:255',
            'rfid_end' => 'nullable|string|max:255',
            'net_quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|max:5120',
        ]);

        $data = [
            'city_id' => $request->city_id,
            'name' => $request->name,
            'contact' => $request->contact,
            'email' => $request->email,
            'address' => $request->address,
            'login_pin' => $request->login_pin,
            'rfid_start' => $request->rfid_start,
            'rfid_end' => $request->rfid_end,
            'net_quantity' => $request->net_quantity,
        ];

        if ($request->hasFile('image')) {
            $directory = public_path('uploads/hospitals');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $data['image'] = 'uploads/hospitals/' . $filename;
        }

        $hospital->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Hospital updated successfully!',
            'redirect_url' => route('manage-hospital.index'),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $hospital = Hospital::findOrFail($id);

        if ($hospital->doctors()->exists() || $hospital->arvStaff()->exists() || $hospital->catchingStaff()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete this Hospital because it has linked Doctors or Staff.',
            ], 422);
        }

        $hospital->delete();

        return response()->json([
            'success' => true,
            'message' => 'Hospital deleted successfully!',
        ]);
    }

    public function toggleStatus($id): JsonResponse
    {
        $hospital = Hospital::findOrFail($id);
        $hospital->update([
            'is_active' => $hospital->is_active ? 0 : 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Hospital status updated successfully!',
            'is_active' => (bool) $hospital->is_active,
        ]);
    }
}