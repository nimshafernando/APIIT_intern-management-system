<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $fillable = [
        'name',
        'industry',
        'description',
        'address',
        'city',
        'country',
        'contact_person_name',
        'contact_person_position',
        'contact_email',
        'contact_phone',
        'website',
        'type',
        'notes',
    ];

    /**
     * Get the company logo URL from Google Favicon API based on website domain
     * 
     * @return string|null
     */
    public function getLogoUrlAttribute(): ?string
    {
        if (empty($this->website)) {
            return null;
        }

        // Parse the domain from the website URL
        $parsedUrl = parse_url($this->website);
        $domain = $parsedUrl['host'] ?? null;

        // Remove 'www.' prefix if present
        if ($domain && str_starts_with($domain, 'www.')) {
            $domain = substr($domain, 4);
        }

        return $domain ? "https://www.google.com/s2/favicons?domain={$domain}&sz=128" : null;
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function opportunityAnnouncements(): HasMany
    {
        return $this->hasMany(OpportunityAnnouncement::class);
    }

    public function activityDocuments(): HasMany
    {
        return $this->hasMany(ActivityDocument::class);
    }
}
