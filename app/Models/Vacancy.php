<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Vacancy extends Model
{
    use HasFactory;

    public static int $DEFAULT_DEPARTMENT_ID = 1;

    /** @var string Стаж работы */
    public string $work_record;

    protected $fillable = [
        'responsibilities',
        'requirements',
        'conditions',
        'additional',
        'experience_id',
        'employment_id',
        'lower_salary',
        'higher_salary',
        'image_id',
        'department_id',
        'has_social_support',
        'schedule',
        'link_to_test_document',
        'city_id',
        'is_outer',
        'additional_title',
        'unarchived_at',
        'format_id',
        'accountable_id',
        'status_id',
        'specialization_id',
        'position_id',
        'description',
    ];

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

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'skill_vacancies');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function department(): BelongsTo
    {
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
