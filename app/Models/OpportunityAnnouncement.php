<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OpportunityAnnouncement extends Model
{
    protected $fillable = [
        'company_id',
        'roles',
        'skills',
        'deadline',
        'announced_at',
        'contact_person',
        'contact_email',
        'document_path',
        'status',
        'remarks',
    ];

    protected $casts = [
        'roles' => 'array',
        'deadline' => 'date',
        'announced_at' => 'date',
    ];

    // Relationship with Company
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    // Relationship with Applications
    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    // Get status badge color
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'Open' => 'green',
            'Closed' => 'gray',
            'Filled' => 'blue',
            'Expired' => 'red',
            default => 'gray',
        };
    }

    // Check if opportunity is expired
    public function isExpired()
    {
        return $this->deadline < now()->toDateString();
    }

    // Check if opportunity should be marked as filled
    public function shouldBeMarkedFilled()
    {
        // This would check applications count when that relationship exists
        return false; // Placeholder for future implementation
    }
}
