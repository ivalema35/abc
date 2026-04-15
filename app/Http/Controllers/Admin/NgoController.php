<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Ngo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NgoController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view ngo')->only(['index', 'show']);
        $this->middleware('permission:add ngo')->only(['create', 'store']);
        $this->middleware('permission:edit ngo')->only(['edit', 'update', 'toggleStatus']);
        $this->middleware('permission:delete ngo')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Ngo::with('city')->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('city_name', function ($row) {
                    return $row->city ? $row->city->city_name : 'N/A';
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
                    $disabled = auth()->user()->can('edit ngo') ? '' : 'disabled';

                    return '<label class="switch switch-primary">'
                        . '<input type="checkbox" class="switch-input toggle-status" data-id="' . $row->id . '" ' . $checked . ' ' . $disabled . '>'
                        . '<span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span>'
                        . '</label>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-inline-block action-icons">';

                    if (auth()->user()->can('edit ngo')) {
                        $btn .= '<a href="' . route('manage-ngo.edit', $row->id) . '" class="btn action-icon-btn action-edit text-warning me-2 item-edit" title="Edit"><i class="bx bx-edit"></i></a>';
                    }

                    $btn .= '<a href="' . route('view-ngo', $row->id) . '" class="btn action-icon-btn action-view text-info me-2" title="View"><i class="bx bx-show"></i></a>';

                    if (auth()->user()->can('edit ngo')) {
                        $btn .= '<button type="button" class="btn action-icon-btn text-info me-2 toggle-status" data-id="' . $row->id . '" title="Toggle Status"><i class="bx bx-power-off"></i></button>';
                    }

                    if (auth()->user()->can('delete ngo')) {
                        $btn .= '<button type="button" class="btn action-icon-btn action-delete text-danger item-delete" data-id="' . $row->id . '"><i class="bx bx-trash"></i></button>';
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

        return view('admin.ngo.manage_ngo');
    }

    public function create()
    {
        $ngo = new Ngo();
        $cities = City::where('is_active', 1)
            ->when($ngo->exists && $ngo->city_id, function ($query) use ($ngo) {
                $query->orWhere('id', $ngo->city_id);
            })
            ->select('id', 'city_name')
            ->get();

        return view('admin.NGO.add_edit_ngo', compact('ngo', 'cities'));
    }

    public function show($id)
    {
        $ngo = Ngo::with('city')->findOrFail($id);

        return view('admin.NGO.view_ngo', compact('ngo'));
    }

    public function edit($id)
    {
        $ngo = Ngo::findOrFail($id);
        $cities = City::where('is_active', 1)
            ->when($ngo->exists && $ngo->city_id, function ($query) use ($ngo) {
                $query->orWhere('id', $ngo->city_id);
            })
            ->select('id', 'city_name')
            ->get();

        return view('admin.NGO.add_edit_ngo', compact('ngo', 'cities'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $dir = public_path('uploads/ngos');
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $imagePath = 'uploads/ngos/' . $filename;
        }

        $ngo = Ngo::create([
            'city_id' => $request->city_id,
            'name' => $request->name,
            'contact' => $request->contact,
            'email' => $request->email,
            'address' => $request->address,
            'image' => $imagePath,
            'is_active' => 1,
        ]);

        return response()->json([
            'status' => 'success',
            'success' => true,
            'message' => 'NGO added successfully!',
            'ngo' => [
                'id' => $ngo->id,
                'name' => $ngo->name,
            ],
            'redirect_url' => route('manage-ngo'),
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $ngo = Ngo::findOrFail($id);

        $request->validate([
            'city_id' => 'required|exists:cities,id',
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = [
            'city_id' => $request->city_id,
            'name' => $request->name,
            'contact' => $request->contact,
            'email' => $request->email,
            'address' => $request->address,
        ];

        if ($request->hasFile('image')) {
            $dir = public_path('uploads/ngos');
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $data['image'] = 'uploads/ngos/' . $filename;
        }

        $ngo->update($data);

        return response()->json([
            'success' => true,
            'message' => 'NGO updated successfully!',
            'redirect_url' => route('manage-ngo'),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $ngo = Ngo::findOrFail($id);

        if ($ngo->hospitals()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete this NGO because it has linked Hospitals.',
            ], 422);
        }

        $ngo->delete();

        return response()->json([
            'success' => true,
            'message' => 'NGO deleted successfully!',
        ]);
    }

    public function toggleStatus($id): JsonResponse
    {
        $ngo = Ngo::findOrFail($id);
        $ngo->update([
            'is_active' => $ngo->is_active ? 0 : 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'NGO status updated successfully!',
            'is_active' => (bool) $ngo->is_active,
        ]);
    }
}