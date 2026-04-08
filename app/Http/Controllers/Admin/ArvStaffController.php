<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArvStaff;
use App\Models\City;
use App\Models\Hospital;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class ArvStaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view arv staff')->only(['index', 'show', 'apiList']);
        $this->middleware('permission:add arv staff')->only(['create', 'store']);
        $this->middleware('permission:edit arv staff')->only(['edit', 'update', 'toggleStatus']);
        $this->middleware('permission:delete arv staff')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ArvStaff::with(['city', 'hospital'])->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('city_name', function ($row) {
                    return $row->city ? $row->city->city_name : 'N/A';
                })
                ->addColumn('pin_mask', function () {
                    return '****';
                })
                ->addColumn('hospital_name', function ($row) {
                    return $row->hospital ? $row->hospital->name : 'N/A';
                })
                ->addColumn('image', function ($row) {
                    if (! $row->image) {
                        return '<span class="badge bg-label-secondary">No Image</span>';
                    }

                    return '<img src="' . asset($row->image) . '" alt="' . e($row->name) . '" class="project-image">';
                })
                ->addColumn('is_active', function ($row) {
                    $checked = $row->is_active ? 'checked' : '';
                    $disabled = auth()->user()->can('edit arv staff') ? '' : 'disabled';

                    return '<label class="switch switch-primary">'
                        . '<input type="checkbox" class="switch-input toggle-status" data-id="' . $row->id . '" ' . $checked . ' ' . $disabled . '>'
                        . '<span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span>'
                        . '</label>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-inline-block action-icons">';

                    if (auth()->user()->can('edit arv staff')) {
                        $btn .= '<a href="' . route('manage-arv-staff.edit', $row->id) . '" class="btn action-icon-btn action-edit text-warning me-2 item-edit" title="Edit"><i class="bx bx-edit"></i></a>';
                    }

                    if (auth()->user()->can('delete arv staff')) {
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

        return view('admin.arvstaff.manage_arv_staff');
    }

    public function create()
    {
        $staff = new ArvStaff();
        $hospitals = Hospital::where('is_active', 1)
            ->when($staff->exists && $staff->hospital_id, fn ($query) => $query->orWhere('id', $staff->hospital_id))
            ->select('id', 'name')
            ->get();
        $cities = City::where('is_active', 1)
            ->when($staff->exists && $staff->city_id, fn ($query) => $query->orWhere('id', $staff->city_id))
            ->select('id', 'city_name')
            ->get();

        return view('admin.arvstaff.add_edit_arv_staff', compact('staff', 'hospitals', 'cities'));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $this->validateStaff($request);

        ArvStaff::create($this->buildPayload($request, $validated));

        return response()->json([
            'success' => true,
            'message' => 'ARV staff added successfully!',
            'redirect_url' => route('manage-arv-staff.index'),
        ]);
    }

    public function show($id)
    {
        return redirect()->route('manage-arv-staff.edit', $id);
    }

    public function edit($id)
    {
        $staff = ArvStaff::findOrFail($id);
        $hospitals = Hospital::where('is_active', 1)
            ->when($staff->exists && $staff->hospital_id, fn ($query) => $query->orWhere('id', $staff->hospital_id))
            ->select('id', 'name')
            ->get();
        $cities = City::where('is_active', 1)
            ->when($staff->exists && $staff->city_id, fn ($query) => $query->orWhere('id', $staff->city_id))
            ->select('id', 'city_name')
            ->get();

        return view('admin.arvstaff.add_edit_arv_staff', compact('staff', 'hospitals', 'cities'));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $staff = ArvStaff::findOrFail($id);
        $validated = $this->validateStaff($request, $staff);

        $staff->update($this->buildPayload($request, $validated, $staff));

        return response()->json([
            'success' => true,
            'message' => 'ARV staff updated successfully!',
            'redirect_url' => route('manage-arv-staff.index'),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $staff = ArvStaff::findOrFail($id);

        try {
            $staff->delete();
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to delete ARV staff right now.',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'ARV staff deleted successfully!',
        ]);
    }

    public function toggleStatus($id): JsonResponse
    {
        $staff = ArvStaff::findOrFail($id);
        $staff->update([
            'is_active' => $staff->is_active ? 0 : 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'ARV staff status updated successfully!',
            'is_active' => (bool) $staff->is_active,
        ]);
    }

    public function apiList(): JsonResponse
    {
        return response()->json(
            ArvStaff::where('is_active', 1)->select('id', 'name')->get()
        );
    }

    protected function validateStaff(Request $request, ?ArvStaff $staff = null): array
    {
        $hasWebLogin = (bool) $request->boolean('has_web_login');

        return $request->validate([
            'hospital_id' => 'required|exists:hospitals,id',
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'login_id' => ['required', 'string', 'max:100', Rule::unique('arv_staff', 'login_id')->ignore($staff?->id)],
            'login_password' => [$staff ? 'nullable' : 'required', 'string', 'min:4'],
            'has_web_login' => 'nullable|boolean',
            'web_email' => [
                'nullable',
                'email',
                'max:255',
                Rule::requiredIf($hasWebLogin),
                Rule::unique('arv_staff', 'web_email')->ignore($staff?->id),
            ],
            'web_password' => [
                $hasWebLogin && ! $staff ? 'required' : 'nullable',
                'string',
                'min:4',
            ],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);
    }

    protected function buildPayload(Request $request, array $validated, ?ArvStaff $staff = null): array
    {
        $hasWebLogin = (int) $request->boolean('has_web_login');

        $data = [
            'hospital_id' => $validated['hospital_id'],
            'city_id' => $validated['city_id'],
            'name' => $validated['name'],
            'login_id' => $validated['login_id'],
            'has_web_login' => $hasWebLogin,
            'web_email' => $hasWebLogin ? ($validated['web_email'] ?? null) : null,
            'is_active' => $staff?->is_active ?? 1,
        ];

        if (! empty($validated['login_password'])) {
            $data['login_password'] = Hash::make($validated['login_password']);
        }

        if ($hasWebLogin) {
            if (! empty($validated['web_password'])) {
                $data['web_password'] = Hash::make($validated['web_password']);
            } elseif (! $staff) {
                $data['web_password'] = null;
            }
        } else {
            $data['web_password'] = null;
        }

        if ($request->hasFile('image')) {
            $directory = public_path('uploads/arv_staff');
            if (! file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $filename);
            $data['image'] = 'uploads/arv_staff/' . $filename;
        }

        return $data;
    }
}