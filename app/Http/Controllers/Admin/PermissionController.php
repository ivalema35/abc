<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Throwable;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $draw     = (int) $request->input('draw', 1);
            $start    = (int) $request->input('start', 0);
            $length   = (int) $request->input('length', 10);
            $search   = trim((string) $request->input('search.value', ''));
            $orderCol = (int) $request->input('order.0.column', 0);
            $orderDir = $request->input('order.0.dir', 'asc') === 'desc' ? 'desc' : 'asc';

            $sortMap = [1 => 'name', 2 => 'module'];

            $query = Permission::query();

            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('module', 'like', "%{$search}%");
                });
            }

            $recordsTotal    = Permission::count();
            $recordsFiltered = $query->count();
            $sortColumn      = $sortMap[$orderCol] ?? 'id';

            $permissions = $query->orderBy($sortColumn, $orderDir)
                                 ->skip($start)
                                 ->take($length)
                                 ->get();

            $data = $permissions->map(function ($permission, $index) use ($start) {
                $editBtn = '<button type="button"
                    class="btn btn-sm action-icon-btn action-edit text-warning js-edit-permission"
                    title="Edit"
                    data-permission-id="' . $permission->id . '"
                    data-permission-name="' . e($permission->name) . '"
                    data-permission-module="' . e($permission->module) . '">
                    <i class="bx bx-edit"></i></button>';

                $deleteBtn = '<button type="button"
                    class="btn btn-sm action-icon-btn action-delete text-danger js-delete-permission"
                    title="Delete"
                    data-permission-id="' . $permission->id . '"
                    data-permission-name="' . e($permission->name) . '">
                    <i class="bx bx-trash"></i></button>';

                return [
                    $start + $index + 1,
                    e($permission->name),
                    ucfirst($permission->module ?? '—'),
                    '<span class="action-icons">' . $editBtn . ' ' . $deleteBtn . '</span>',
                ];
            });

            return response()->json([
                'draw'            => $draw,
                'recordsTotal'    => $recordsTotal,
                'recordsFiltered' => $recordsFiltered,
                'data'            => $data,
            ]);
        }

        return view('admin.role&permission.permissions');
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name'   => 'required|string|max:255|unique:permissions,name',
            'module' => 'required|string|max:100',
        ]);

        $permission = Permission::create([
            'name'   => $request->name,
            'module' => $request->module,
        ]);

        return response()->json([
            'success'    => true,
            'message'    => 'Permission created successfully.',
            'permission' => $permission,
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $permission = Permission::findOrFail($id);

        $request->validate([
            'name'   => ['required', 'string', 'max:255', Rule::unique('permissions', 'name')->ignore($permission->id)],
            'module' => 'required|string|max:100',
        ]);

        $permission->update([
            'name'   => $request->name,
            'module' => $request->module,
        ]);

        return response()->json([
            'success'    => true,
            'message'    => 'Permission updated successfully.',
            'permission' => $permission,
        ]);
    }

    public function destroy($id): JsonResponse
    {
        try {
            $permission = Permission::findOrFail($id);
            $permission->roles()->detach();
            $permission->delete();

            return response()->json([
                'success' => true,
                'message' => 'Permission deleted successfully.',
            ]);
        } catch (Throwable $throwable) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to delete permission right now.',
            ], 500);
        }
    }
}
