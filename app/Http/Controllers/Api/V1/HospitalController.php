<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Hospital;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function index(): JsonResponse
    {
        $data = Hospital::with('city')->where('is_active', 1)->get();

        return response()->json([
            'success' => true,
            'message' => 'Data fetched',
            'data' => $data,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'city_id' => ['required', 'exists:cities,id'],
            'name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'login_pin' => ['required', 'digits:4'],
            'rfid_start' => ['nullable', 'string', 'max:255'],
            'rfid_end' => ['nullable', 'string', 'max:255'],
            'net_quantity' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $directory = public_path('uploads/hospitals');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            $file = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $fileName);
            $validated['image'] = 'uploads/hospitals/' . $fileName;
        }

        $validated['is_active'] = (bool) ($validated['is_active'] ?? true);
        $data = Hospital::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Hospital created successfully',
            'data' => $data,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $data = Hospital::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $record = Hospital::findOrFail($id);

        $validated = $request->validate([
            'city_id' => ['required', 'exists:cities,id'],
            'name' => ['required', 'string', 'max:255'],
            'contact' => ['required', 'string', 'max:20'],
            'email' => ['nullable', 'email', 'max:255'],
            'address' => ['nullable', 'string'],
            'login_pin' => ['required', 'digits:4'],
            'rfid_start' => ['nullable', 'string', 'max:255'],
            'rfid_end' => ['nullable', 'string', 'max:255'],
            'net_quantity' => ['required', 'integer', 'min:0'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $directory = public_path('uploads/hospitals');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            if ($record->image && file_exists(public_path($record->image))) {
                unlink(public_path($record->image));
            }

            $file = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $fileName);
            $validated['image'] = 'uploads/hospitals/' . $fileName;
        }

        if (!array_key_exists('is_active', $validated)) {
            $validated['is_active'] = $record->is_active;
        }

        $record->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Hospital updated successfully',
            'data' => $record,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $record = Hospital::findOrFail($id);
        $record->delete();

        return response()->json([
            'success' => true,
            'message' => 'Hospital deleted successfully',
        ]);
    }
}
