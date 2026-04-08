<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Throwable;

class RoleController extends Controller
{
    public function index()
    {
        $roles       = Role::with('permissions')->latest()->get();
        $permissions = Permission::all()->groupBy('module');

        return view('admin.role&permission.role', compact('roles', 'permissions'));
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name'            => 'required|string|max:255|unique:roles,name',
            'is_active'       => 'required|in:0,1',
            'permissions'     => 'nullable|array',
            'permissions.*'   => 'integer|exists:permissions,id',
        ]);

        $role = Role::create([
            'name'       => $request->name,
            'guard_name' => 'web',
            'is_active'  => (int) $request->is_active,
        ]);

        $role->syncPermissions($request->input('permissions', []));

        return response()->json([
            'success' => true,
            'message' => 'Role created successfully.',
            'role'    => $role,
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $role = Role::findOrFail($id);

        $request->validate([
            'name'          => ['required', 'string', 'max:255', Rule::unique('roles', 'name')->ignore($role->id)],
            'is_active'     => 'required|in:0,1',
            'permissions'   => 'nullable|array',
            'permissions.*' => 'integer|exists:permissions,id',
        ]);

        $role->update([
            'name'      => $request->name,
            'is_active' => (int) $request->is_active,
        ]);

        $role->syncPermissions($request->input('permissions', []));

        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully.',
            'role'    => $role->load('permissions'),
        ]);
    }

    public function destroy($id): JsonResponse
    {
        try {
            $role = Role::findOrFail($id);
            $role->syncPermissions([]);
            $role->delete();

            return response()->json([
                'success' => true,
                'message' => 'Role deleted successfully.',
            ]);
        } catch (Throwable $throwable) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to delete role right now.',
            ], 500);
        }
    }

    public function toggleStatus($id): JsonResponse
    {
        $role = Role::findOrFail($id);
        $role->update(['is_active' => $role->is_active ? 0 : 1]);

        return response()->json([
            'success'   => true,
            'message'   => 'Role status updated successfully.',
            'is_active' => (int) $role->is_active,
        ]);
    }
}
