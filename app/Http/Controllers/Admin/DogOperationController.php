<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CatchingRecord;
use App\Models\DogOperation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DogOperationController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'catching_record_id' => ['required', 'exists:catching_records,id'],
            'doctor_id' => ['required', 'exists:doctors,id'],
            'operation_date' => ['required', 'date'],
            'body_weight' => ['nullable', 'numeric', 'min:0'],
            'remarks' => ['nullable', 'string'],
            'medicines' => ['nullable', 'array'],
            'medicines.*.medicine_id' => ['required_with:medicines', 'exists:medicines,id'],
            'medicines.*.qty' => ['required_with:medicines', 'integer', 'min:1'],
        ]);

        $operation = DB::transaction(function () use ($validated) {
            $operation = DogOperation::create([
                'catching_record_id' => $validated['catching_record_id'],
                'doctor_id' => $validated['doctor_id'],
                'operation_date' => $validated['operation_date'],
                'body_weight' => $validated['body_weight'] ?? null,
                'remarks' => $validated['remarks'] ?? null,
            ]);

            $pivotPayload = [];
            foreach ($validated['medicines'] ?? [] as $medicineRow) {
                $pivotPayload[$medicineRow['medicine_id']] = [
                    'qty' => $medicineRow['qty'],
                ];
            }

            if (! empty($pivotPayload)) {
                $operation->medicines()->sync($pivotPayload);
            }

            CatchingRecord::where('id', $validated['catching_record_id'])
                ->update(['status' => 'Observation']);

            return $operation;
        });

        return response()->json([
            'status' => 'success',
            'message' => 'Operation saved and dog moved to Observation successfully.',
            'record' => [
                'id' => $operation->id,
                'catching_record_id' => $operation->catching_record_id,
            ],
        ]);
    }
}
