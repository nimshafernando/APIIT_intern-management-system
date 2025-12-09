<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ActivityType extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function activityDocuments(): HasMany
    {
        return $this->hasMany(ActivityDocument::class);
    }
}
