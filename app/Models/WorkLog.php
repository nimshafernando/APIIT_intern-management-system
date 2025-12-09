<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkLog extends Model
{
    protected $fillable = [
        'student_id',
        'week_number',
        'date_from',
        'date_to',
        'hours_worked',
        'description',
        'file_path',
        'status',
        'reviewed_by',
    ];

    protected $casts = [
        'date_from' => 'date',
        'date_to' => 'date',
        'hours_worked' => 'decimal:2',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
