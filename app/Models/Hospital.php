<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hospital extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'city_id',
        'name',
        'contact',
        'email',
        'address',
        'login_pin',
        'rfid_start',
        'rfid_end',
        'net_quantity',
        'image',
        'is_active',
    ];

    protected $casts = [
        'net_quantity' => 'integer',
        'is_active' => 'boolean',
    ];

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

    public function arvStaff()
    {
        return $this->hasMany(ArvStaff::class);
    }

    public function catchingStaff()
    {
        return $this->hasMany(CatchingStaff::class);
    }
}
