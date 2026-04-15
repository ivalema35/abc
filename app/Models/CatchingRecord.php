<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatchingRecord extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'project_id',
        'hospital_id',
        'catching_staff_id',
        'vehicle_id',
        'tag_no',
        'catch_date',
        'dog_type',
        'gender',
        'street',
        'owner_name',
        'address',
        'latitude',
        'longitude',
        'image',
        'status',
        'is_active',
    ];

    protected $casts = [
        'catch_date' => 'date',
        'is_active' => 'boolean',
    ];

    protected $attributes = [
        'status' => 'Caught',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    public function catchingStaff(): BelongsTo
    {
        return $this->belongsTo(CatchingStaff::class, 'catching_staff_id');
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function operation(): HasOne
    {
        return $this->hasOne(DogOperation::class);
    }

    public function stageLogs(): HasMany
    {
        return $this->hasMany(DogStageLog::class)->orderBy('created_at', 'desc');
    }
}
