<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class CityController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view city')->only(['index']);
        $this->middleware('permission:add city')->only(['store']);
        $this->middleware('permission:edit city')->only(['update', 'toggleStatus']);
        $this->middleware('permission:delete city')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = City::query()->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    if (! $row->image) {
                        return '<span class="badge bg-label-secondary">No Image</span>';
                    }

                    $url = asset($row->image);

                    return '<img src="' . $url . '" alt="' . e($row->city_name) . '" class="rounded-circle" width="40" height="40">';
                })
                ->addColumn('is_active', function ($row) {
                    $checked = $row->is_active ? 'checked' : '';
                    $disabled = auth()->user()->can('edit city') ? '' : 'disabled';

                    return '<label class="switch switch-primary">'
                        . '<input type="checkbox" class="switch-input toggle-status" data-id="' . $row->id . '" ' . $checked . ' ' . $disabled . '>'
                        . '<span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span>'
                        . '</label>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-inline-block">';

                    if (auth()->user()->can('edit city')) {
                        $btn .= '<button type="button" class="btn btn-sm btn-icon item-edit text-warning" data-id="' . $row->id . '" data-name="' . e($row->city_name) . '" data-image="' . e($row->image ?? '') . '"><i class="bx bx-edit"></i></button>';
                    }

                    if (auth()->user()->can('delete city')) {
                        $btn .= '<button type="button" class="btn btn-sm btn-icon item-delete text-danger" data-id="' . $row->id . '"><i class="bx bx-trash"></i></button>';
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

        return view('admin.city.manage_city');
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'city_name' => 'required|unique:cities,city_name|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $dir = public_path('uploads/cities');
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $imagePath = 'uploads/cities/' . $filename;
        }

        $city = City::create([
            'city_name' => $request->city_name,
            'image' => $imagePath,
            'is_active' => 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'City added successfully!',
            'city' => $city,
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $city = City::findOrFail($id);

        $request->validate([
            'city_name' => 'required|max:255|unique:cities,city_name,' . $city->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $data = ['city_name' => $request->city_name];

        if ($request->hasFile('image')) {
            $dir = public_path('uploads/cities');
            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $data['image'] = 'uploads/cities/' . $filename;
        }

        $city->update($data);

        return response()->json([
            'success' => true,
            'message' => 'City updated successfully!',
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $city = City::findOrFail($id);

        if ($city->hospitals()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete this City because it has linked Hospitals.',
            ], 422);
        }

        $city->delete();

        return response()->json([
            'success' => true,
            'message' => 'City deleted successfully!',
        ]);
    }

    public function toggleStatus($id): JsonResponse
    {
        $city = City::findOrFail($id);
        $city->update([
            'is_active' => $city->is_active ? 0 : 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'City status updated successfully!',
            'is_active' => (bool) $city->is_active,
        ]);
    }

    public function apiList(): JsonResponse
    {
        $cities = City::where('is_active', 1)
            ->select('id', 'city_name')
            ->get();

        return response()->json($cities);
    }
}