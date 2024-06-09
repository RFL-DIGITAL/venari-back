<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Vacancy extends Model
{
    use HasFactory;

    public static int $DEFAULT_DEPARTMENT_ID = 1;

    /** @var string Стаж работы */
    public string $work_record;

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
}
