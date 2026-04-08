<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'bd_title',
        'bd_logo',
        'bd_email',
        'bd_contact',
        'bd_address',
        'bd_location',
        'bd_support_mail',
        'sms_meta',
        'sms_logo',
        'sms_email',
        'sms_contact',
        'sms_address',
        'sms_location',
    ];
}
