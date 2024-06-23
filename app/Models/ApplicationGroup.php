<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class ApplicationGroup extends Model
{
    use HasFactory, Searchable;

    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Application::class, 'application_application_groups');
    }
}
