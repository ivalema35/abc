<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Medicare;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class MedicareController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view medicare')->only(['index', 'show']);
        $this->middleware('permission:add medicare')->only(['create', 'store']);
        $this->middleware('permission:edit medicare')->only(['edit', 'update', 'toggleStatus']);
        $this->middleware('permission:delete medicare')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Medicare::latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('is_active', function ($row) {
                    $checked = $row->is_active ? 'checked' : '';
                    $disabled = auth()->user()->can('edit medicare') ? '' : 'disabled';

                    return '<label class="switch switch-primary">'
                        . '<input type="checkbox" class="switch-input toggle-status" data-id="' . $row->id . '" ' . $checked . ' ' . $disabled . '>'
                        . '<span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span>'
                        . '</label>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-inline-block action-icons">';

                    if (auth()->user()->can('edit medicare')) {
                        $btn .= '<a href="' . route('manage-medicare.edit', $row->id) . '" class="btn action-icon-btn action-edit text-warning me-2 item-edit" title="Edit"><i class="bx bx-edit"></i></a>';
                    }

                    if (auth()->user()->can('delete medicare')) {
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

        return view('admin.medicare.manage_medicare');
    }

    public function create()
    {
        $medicare = new Medicare();

        return view('admin.medicare.add_edit_medicare', compact('medicare'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:medicares,name',
        ]);

        Medicare::create([
            'name' => $request->name,
            'is_active' => 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Medicare added successfully!',
            'redirect_url' => route('manage-medicare.index'),
        ]);
    }

    public function show($id)
    {
        return redirect()->route('manage-medicare.edit', $id);
    }

    public function edit($id)
    {
        $medicare = Medicare::findOrFail($id);

        return view('admin.medicare.add_edit_medicare', compact('medicare'));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $medicare = Medicare::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('medicares', 'name')->ignore($medicare->id)],
        ]);

        $medicare->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Medicare updated successfully!',
            'redirect_url' => route('manage-medicare.index'),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $medicare = Medicare::findOrFail($id);

        try {
            $medicare->delete();
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to delete medicare right now.',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Medicare deleted successfully!',
        ]);
    }

    public function toggleStatus($id): JsonResponse
    {
        $medicare = Medicare::findOrFail($id);
        $medicare->update([
            'is_active' => $medicare->is_active ? 0 : 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Medicare status updated successfully!',
            'is_active' => (bool) $medicare->is_active,
        ]);
    }
}