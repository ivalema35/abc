<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatchingStaff;
use App\Models\City;
use App\Models\Hospital;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class CatchingStaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view catching staff')->only(['index', 'show']);
        $this->middleware('permission:add catching staff')->only(['create', 'store']);
        $this->middleware('permission:edit catching staff')->only(['edit', 'update', 'toggleStatus']);
        $this->middleware('permission:delete catching staff')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = CatchingStaff::with(['city', 'hospital'])->latest();

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

                    return '<img src="' . asset($row->image) . '" alt="' . e($row->name) . '" class="staff-image">';
                })
                ->addColumn('is_active', function ($row) {
                    $checked = $row->is_active ? 'checked' : '';
                    $disabled = auth()->user()->can('edit catching staff') ? '' : 'disabled';

                    return '<label class="switch switch-primary">'
                        . '<input type="checkbox" class="switch-input toggle-status" data-id="' . $row->id . '" ' . $checked . ' ' . $disabled . '>'
                        . '<span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span>'
                        . '</label>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-inline-block action-icons">';

                    if (auth()->user()->can('edit catching staff')) {
                        $btn .= '<a href="' . route('manage-catching-staff.edit', $row->id) . '" class="btn action-icon-btn text-warning me-2 item-edit" title="Edit"><i class="bx bx-edit"></i></a>';
                    }

                    $btn .= '<a href="' . route('manage-catching-staff.show', $row->id) . '" class="btn action-icon-btn text-info me-2" title="View"><i class="bx bx-show"></i></a>';

                    if (auth()->user()->can('delete catching staff')) {
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

        return view('admin.catching_staff.manage_catching_staff');
    }

    public function create()
    {
        $staff = new CatchingStaff();
        $hospitals = Hospital::where('is_active', 1)
            ->when($staff->exists && $staff->hospital_id, fn ($query) => $query->orWhere('id', $staff->hospital_id))
            ->select('id', 'name')
            ->get();
        $cities = City::where('is_active', 1)
            ->when($staff->exists && $staff->city_id, fn ($query) => $query->orWhere('id', $staff->city_id))
            ->select('id', 'city_name')
            ->get();

        return view('admin.catching_staff.add_edit_catching_staff', compact('staff', 'hospitals', 'cities'));
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
            $directory = public_path('uploads/catching_staff');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $imagePath = 'uploads/catching_staff/' . $filename;
        }

        CatchingStaff::create([
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
            'message' => 'Catching staff added successfully!',
            'redirect_url' => route('manage-catching-staff.index'),
        ]);
    }

    public function show($id)
    {
        $staff = CatchingStaff::with(['hospital', 'city'])->findOrFail($id);

        return view('admin.catching_staff.view_catching_staff', compact('staff'));
    }

    public function edit($id)
    {
        $staff = CatchingStaff::findOrFail($id);
        $hospitals = Hospital::where('is_active', 1)
            ->when($staff->exists && $staff->hospital_id, fn ($query) => $query->orWhere('id', $staff->hospital_id))
            ->select('id', 'name')
            ->get();
        $cities = City::where('is_active', 1)
            ->when($staff->exists && $staff->city_id, fn ($query) => $query->orWhere('id', $staff->city_id))
            ->select('id', 'city_name')
            ->get();

        return view('admin.catching_staff.add_edit_catching_staff', compact('staff', 'hospitals', 'cities'));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $staff = CatchingStaff::findOrFail($id);

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
            $directory = public_path('uploads/catching_staff');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $data['image'] = 'uploads/catching_staff/' . $filename;
        }

        $staff->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Catching staff updated successfully!',
            'redirect_url' => route('manage-catching-staff.index'),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $staff = CatchingStaff::findOrFail($id);

        try {
            $staff->delete();
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to delete catching staff. It may be linked to other records.',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Catching staff deleted successfully!',
        ]);
    }

    public function toggleStatus($id): JsonResponse
    {
        $staff = CatchingStaff::findOrFail($id);
        $staff->update([
            'is_active' => $staff->is_active ? 0 : 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Catching staff status updated successfully!',
            'is_active' => (bool) $staff->is_active,
        ]);
    }
}