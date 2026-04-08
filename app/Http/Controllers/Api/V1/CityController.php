<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CityController extends Controller
{
    public function index(): JsonResponse
    {
        $data = City::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'Data fetched',
            'data' => $data,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'city_name' => ['required', 'string', 'max:255', 'unique:cities,city_name'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $directory = public_path('uploads/cities');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            $file = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $fileName);
            $validated['image'] = 'uploads/cities/' . $fileName;
        }

        $validated['is_active'] = (bool) ($validated['is_active'] ?? true);
        $data = City::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'City created successfully',
            'data' => $data,
        ], 201);
    }

    public function show(string $id): JsonResponse
    {
        $data = City::findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $data,
        ]);
    }

    public function update(Request $request, string $id): JsonResponse
    {
        $record = City::findOrFail($id);

        $validated = $request->validate([
            'city_name' => ['required', 'string', 'max:255', Rule::unique('cities', 'city_name')->ignore($record->id)],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->hasFile('image')) {
            $directory = public_path('uploads/cities');
            if (!file_exists($directory)) {
                mkdir($directory, 0777, true);
            }

            if ($record->image && file_exists(public_path($record->image))) {
                unlink(public_path($record->image));
            }

            $file = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($directory, $fileName);
            $validated['image'] = 'uploads/cities/' . $fileName;
        }

        if (!array_key_exists('is_active', $validated)) {
            $validated['is_active'] = $record->is_active;
        }

        $record->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'City updated successfully',
            'data' => $record,
        ]);
    }

    public function destroy(string $id): JsonResponse
    {
        $record = City::findOrFail($id);
        $record->delete();

        return response()->json([
            'success' => true,
            'message' => 'City deleted successfully',
        ]);
    }
}
