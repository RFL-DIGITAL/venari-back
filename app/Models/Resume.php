<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Scout\Searchable;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_phone',
        'contact_email',
        'salary',
        'description',
    ];

    protected $appends = [
        'experience'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userPositions(): BelongsToMany
    {
        return $this->belongsToMany(UserPosition::class, 'user_position_resume');
    }

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'resume_skills');
    }

    public function resumeProgramSchools(): HasMany
    {
        return $this->hasMany(ResumeProgramSchool::class);
    }

    public function languageLevels(): BelongsToMany
    {
        return $this->belongsToMany(LanguageLevel::class, 'language_level_resumes');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function specialization(): BelongsTo
    {
        return $this->belongsTo(Specialization::class);
    }

    public function employment(): BelongsTo
    {
        return $this->belongsTo(Employment::class);
    }

    public function format(): BelongsTo
    {
        return $this->belongsTo(Format::class);
    }

    public function getExperienceAttribute()
    {
        $userPositions = UserPosition::whereHas('resumes', function (Builder $query) {
            $query->where('resume_id', $this->id);
        })->get();
        $experiences = [];

        $now = new Datetime();
        foreach ($userPositions as $userPosition) {
            $experiences[] = date_diff(new DateTime($userPosition->start_date),
                $userPosition?->end_date != null ? new DateTime($userPosition->end_date) : $now);
        }

        $final_result = null;

        if (count($experiences) > 0) {
            if (count($experiences) == 1) {
                $final_result = $experiences[0]->format("%y years %m months %d days");
            } else {
                for ($i = 0; $i < count($experiences) - 1; $i = $i + 2) {
                    $diff_1 = $experiences[$i];
                    $diff_2 = $experiences[$i + 1];

                    $dt = new DateTime();

                    $dt->add($diff_2);
                    $dt->add($diff_1);

                    $result = $dt->diff(new DateTime());

                    $dt = new DateTime();

                    $dt->add($result);

                    $final_result = $dt->diff(new DateTime());
                }
                return $final_result->format("%y years %m months %d days");
            }
        } else {
            $final_result = "0 years";
        }
        return $final_result;
    }
}
