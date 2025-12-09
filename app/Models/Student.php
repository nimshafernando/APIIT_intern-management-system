<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    protected $fillable = [
        'student_id',
        'name',
        'email',
        'phone_number',
        'date_of_birth',
        'profile_photo',
        'programme',
        'batch',
        'semester',
        'cumulative_marks',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function interests(): HasMany
    {
        return $this->hasMany(StudentInterest::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function documents(): HasMany
    {
        return $this->hasMany(StudentDocument::class);
    }

    public function workLogs(): HasMany
    {
        return $this->hasMany(WorkLog::class);
    }

    public function activityDocuments(): HasMany
    {
        return $this->hasMany(ActivityDocument::class);
    }
}
