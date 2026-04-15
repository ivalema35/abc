<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'ngo_id',
        'city_id',
        'hospital_id',
        'vehicle_id',
        'name',
        'rfid_enabled',
        'contact',
        'pin',
        'arv_months',
        'catch_visibility',
        'catch_type',
        'receive_visibility',
        'receive_type',
        'process_visibility',
        'process_type',
        'observation_visibility',
        'observation_type',
        'r4r_visibility',
        'r4r_type',
        'complete_visibility',
        'complete_type',
        'reject_visibility',
        'reject_type',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'rfid_enabled' => 'boolean',
    ];

    public function ngo(): BelongsTo
    {
        return $this->belongsTo(Ngo::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }
}
