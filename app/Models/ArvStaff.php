<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArvStaff extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'hospital_id',
        'city_id',
        'name',
        'login_id',
        'login_password',
        'has_web_login',
        'web_email',
        'web_password',
        'image',
        'is_active',
    ];

    protected $casts = [
        'has_web_login' => 'boolean',
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
