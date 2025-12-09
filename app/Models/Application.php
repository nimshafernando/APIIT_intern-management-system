<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Application extends Model
{
    protected $fillable = [
        'student_id',
        'company_id',
        'opportunity_announcement_id',
        'vacancy_id',
        'position',
        'status',
        'sent_date',
        'remarks',
        'cv_file_path',
    ];

    protected $casts = [
        'sent_date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function opportunityAnnouncement(): BelongsTo
    {
        return $this->belongsTo(OpportunityAnnouncement::class);
    }
}
