<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class VehicleController extends Controller
{
    public function index(): JsonResponse
    {
        $data = Vehicle::where('is_active', 1)->get();

        return response()->json([
            'success' => true,
            'message' => 'Data fetched',
            'data' => $data,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'hospital_id' => ['required', 'exists:hospitals,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'vehicle_number' => ['required', 'string', 'max:20', 'unique:vehicles,vehicle_number'],
            'login_id' => ['required', 'string', 'max:100', 'unique:vehicles,login_id'],
            'login_password' => ['required', 'string', 'min:4'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $directory = public_path('uploads/vehicles');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            $file = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $fileName);
            $validated['image'] = 'uploads/vehicles/' . $fileName;
        }

        $validated['login_password'] = Hash::make($validated['login_password']);
        $validated['is_active'] = (bool) ($validated['is_active'] ?? true);
        $data = Vehicle::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Vehicle created successfully',
            'data' => $data,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $data = Vehicle::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $record = Vehicle::findOrFail($id);

        $validated = $request->validate([
            'hospital_id' => ['required', 'exists:hospitals,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'vehicle_number' => ['required', 'string', 'max:20', Rule::unique('vehicles', 'vehicle_number')->ignore($record->id)],
            'login_id' => ['required', 'string', 'max:100', Rule::unique('vehicles', 'login_id')->ignore($record->id)],
            'login_password' => ['nullable', 'string', 'min:4'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $directory = public_path('uploads/vehicles');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            if ($record->image && file_exists(public_path($record->image))) {
                unlink(public_path($record->image));
            }

            $file = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $fileName);
            $validated['image'] = 'uploads/vehicles/' . $fileName;
        }

        if (!empty($validated['login_password'])) {
            $validated['login_password'] = Hash::make($validated['login_password']);
        } else {
            unset($validated['login_password']);
        }

        if (!array_key_exists('is_active', $validated)) {
            $validated['is_active'] = $record->is_active;
        }

        $record->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Vehicle updated successfully',
            'data' => $record,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $record = Vehicle::findOrFail($id);
        $record->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vehicle deleted successfully',
        ]);
    }
}
