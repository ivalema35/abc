<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BillMaster;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Throwable;
use Yajra\DataTables\Facades\DataTables;

class BillMasterController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view bill master')->only(['index', 'show', 'apiList']);
        $this->middleware('permission:add bill master')->only(['create', 'store']);
        $this->middleware('permission:edit bill master')->only(['edit', 'update', 'toggleStatus']);
        $this->middleware('permission:delete bill master')->only(['destroy']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = BillMaster::latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('is_active', function ($row) {
                    $checked = $row->is_active ? 'checked' : '';
                    $disabled = auth()->user()->can('edit bill master') ? '' : 'disabled';

                    return '<label class="switch switch-primary">'
                        . '<input type="checkbox" class="switch-input toggle-status" data-id="' . $row->id . '" ' . $checked . ' ' . $disabled . '>'
                        . '<span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span>'
                        . '</label>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-inline-block action-icons">';

                    if (auth()->user()->can('edit bill master')) {
                        $btn .= '<a href="' . route('manage-bill-master.edit', $row->id) . '" class="btn action-icon-btn action-edit text-warning me-2 item-edit" title="Edit"><i class="bx bx-edit"></i></a>';
                    }

                    if (auth()->user()->can('delete bill master')) {
                        $btn .= '<button type="button" class="btn action-icon-btn text-danger item-delete" data-id="' . $row->id . '" title="Delete"><i class="bx bx-trash"></i></button>';
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

        return view('admin.bill.manage_bill_master');
    }

    public function create()
    {
        $billMaster = new BillMaster();

        return view('admin.bill.add_edit_bill_master', compact('billMaster'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:bill_masters,name',
        ]);

        BillMaster::create([
            'name' => $request->name,
            'is_active' => 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bill master added successfully!',
            'redirect_url' => route('manage-bill-master.index'),
        ]);
    }

    public function show($id)
    {
        return redirect()->route('manage-bill-master.edit', $id);
    }

    public function edit($id)
    {
        $billMaster = BillMaster::findOrFail($id);

        return view('admin.bill.add_edit_bill_master', compact('billMaster'));
    }

    public function update(Request $request, $id): JsonResponse
    {
        $billMaster = BillMaster::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('bill_masters', 'name')->ignore($billMaster->id)],
        ]);

        $billMaster->update([
            'name' => $request->name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bill master updated successfully!',
            'redirect_url' => route('manage-bill-master.index'),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        $billMaster = BillMaster::findOrFail($id);

        try {
            $billMaster->delete();
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to delete bill master right now.',
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => 'Bill master deleted successfully!',
        ]);
    }

    public function toggleStatus($id): JsonResponse
    {
        $billMaster = BillMaster::findOrFail($id);
        $billMaster->update([
            'is_active' => $billMaster->is_active ? 0 : 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bill master status updated successfully!',
            'is_active' => (bool) $billMaster->is_active,
        ]);
    }

    public function apiList(): JsonResponse
    {
        return response()->json(
            BillMaster::where('is_active', 1)->select('id', 'name')->get()
        );
    }
}