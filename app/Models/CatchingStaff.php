<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CatchingStaff extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'hospital_id',
        'city_id',
        'name',
        'contact',
        'email',
        'address',
        'image',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function hospital(): BelongsTo
    {
        return $this->belongsTo(Hospital::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
