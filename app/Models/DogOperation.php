<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DogOperation extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'catching_record_id',
        'doctor_id',
        'operation_date',
        'body_weight',
        'remarks',
    ];

    protected $casts = [
        'operation_date' => 'date',
        'body_weight' => 'decimal:2',
    ];

    public function catchingRecord(): BelongsTo
    {
        return $this->belongsTo(CatchingRecord::class);
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }

    public function medicines(): BelongsToMany
    {
        return $this->belongsToMany(Medicine::class, 'dog_operation_medicines')
            ->withPivot('qty')
            ->withTimestamps();
    }
}
