<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

class UserPosition extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'user_id',
        'company_id',
        'position_id',
        'start_date',
        'end_date',
        'description',
];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function resumes(): BelongsToMany
    {
        return $this->belongsToMany(Resume::class, 'user_position_resume');
    }
}
