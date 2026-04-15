<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DogStageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'catching_record_id',
        'stage',
        'action_by',
        'remarks',
    ];

    public function catchingRecord(): BelongsTo
    {
        return $this->belongsTo(CatchingRecord::class);
    }

    public function actionBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'action_by');
    }
}
