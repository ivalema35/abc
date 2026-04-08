<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class MedicineController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view medicine')->only(['index', 'show']);
        $this->middleware('permission:add medicine')->only(['create', 'store']);
        $this->middleware('permission:edit medicine')->only(['edit', 'update', 'toggleStatus']);
        $this->middleware('permission:delete medicine')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Medicine::latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('is_active', function ($row) {
                    $badgeClass = $row->is_active ? 'bg-success' : 'bg-danger';
                    $label = $row->is_active ? 'Active' : 'Inactive';
                    $button = '';

                    if (auth()->user()->can('edit medicine')) {
                        $button = '<button type="button" class="btn action-icon-btn text-info toggle-status" data-id="' . $row->id . '" title="Toggle Status"><i class="bx bx-power-off"></i></button>';
                    }

                    return '<div class="d-flex align-items-center gap-2"><span class="badge ' . $badgeClass . '">' . $label . '</span>' . $button . '</div>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-inline-block action-icons">';

                    if (auth()->user()->can('edit medicine')) {
                        $btn .= '<a href="' . route('manage-medicine.edit', $row->id) . '" class="btn action-icon-btn action-edit text-warning me-2 item-edit" title="Edit"><i class="bx bx-edit"></i></a>';
                    }

                    if (auth()->user()->can('delete medicine')) {
                        $btn .= '<button type="button" class="btn action-icon-btn action-delete text-danger item-delete" data-id="' . $row->id . '" title="Delete"><i class="bx bx-trash"></i></button>';
                    }

                    $btn .= '</div>';

                    return $btn;
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('d M Y');
                })
                ->rawColumns(['is_active', 'action'])
                ->make(true);
        }

        return view('admin.medicine.manage_medicine');
    }

    public function create()
    {
        $medicine = new Medicine();

        return view('admin.medicine.add_edit_medicine', compact('medicine'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:medicines,name',
            'unit' => 'required|string|max:50',
            'dose' => 'required|string|max:100',
        ]);

        Medicine::create([
            'name' => $request->name,
            'unit' => $request->unit,
            'dose' => $request->dose,
            'is_active' => 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Medicine added successfully!',
            'redirect_url' => route('manage-medicine.index'),
        ]);
    }

    public function show($id)
    {
        return redirect()->route('manage-medicine.edit', $id);
    }

    public function edit($id)
    {
        $medicine = Medicine::findOrFail($id);

        return view('admin.medicine.add_edit_medicine', compact('medicine'));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $medicine = Medicine::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('medicines', 'name')->ignore($medicine->id)],
            'unit' => 'required|string|max:50',
            'dose' => 'required|string|max:100',
        ]);

        $medicine->update([
            'name' => $request->name,
            'unit' => $request->unit,
            'dose' => $request->dose,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Medicine updated successfully!',
            'redirect_url' => route('manage-medicine.index'),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $medicine = Medicine::findOrFail($id);

        try {
            $medicine->delete();
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to delete medicine right now.',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Medicine deleted successfully!',
        ]);
    }

    public function toggleStatus($id): JsonResponse
    {
        $medicine = Medicine::findOrFail($id);
        $medicine->update([
            'is_active' => $medicine->is_active ? 0 : 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Medicine status updated successfully!',
            'is_active' => (bool) $medicine->is_active,
        ]);
    }
}