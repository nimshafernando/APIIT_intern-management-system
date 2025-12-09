<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DocumentType extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function studentDocuments(): HasMany
    {
        return $this->hasMany(StudentDocument::class);
    }
}
