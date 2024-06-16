<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class ApplicationTag extends Model
{
    use HasFactory, Searchable;

    protected $fillable =
        [
            'name'
        ];

    public function users(): BelongsToMany {
        return $this->belongsToMany(User::class, 'application_tag_users');
    }
}
