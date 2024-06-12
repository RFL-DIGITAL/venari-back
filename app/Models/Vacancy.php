<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vacancy extends Model
{
    use HasFactory;

    public static int $DEFAULT_DEPARTMENT_ID = 1;

    /** @var string Стаж работы */
    public string $work_record;

    protected $appends = [
        'application_count',
        'candidate_count'
    ];

    public function getApplicationCountAttribute(): int
    {
        return $this->applications()->count();
    }

    public function getCandidateCountAttribute(): int
    {
        return $this->application_count - $this->applications()
            ->whereHas('stage', function (Builder $query) {
                $query->whereHas('stageType', function (Builder $query) {
                    $query->where('name', 'reject');
                });
            })->count();
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function skills(): BelongsToMany {
        return $this->belongsToMany(Skill::class, 'skill_vacancies');
    }

    public function city(): BelongsTo {
        return $this->belongsTo(City::class);
    }
    public function department(): BelongsTo {
        return $this->belongsTo(Department::class);
    }

    public function experience(): BelongsTo
    {
        return $this->belongsTo(Experience::class);
    }

    public function employment(): BelongsTo
    {
        return $this->belongsTo(Employment::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function format(): BelongsTo
    {
        return $this->belongsTo(Format::class);
    }

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }

    public function accountable(): BelongsTo
    {
        return $this->belongsTo(HR::class);
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }

    public function applications(): HasMany
    {
        return $this->HasMany(Application::class);
    }
}
