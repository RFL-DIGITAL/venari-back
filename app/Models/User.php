<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\City;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'hrable_type',
        'hrable_id',
        'sex',
        'date_of_birth',
        'workingStatus_id',
        'position_id',
        'image_id',
        'first_name',
        'last_name',
        'user_name',
        'preview_id',
        'company_id',
    ];

    protected $appends = [
        'post_count',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function hrable(): MorphTo
    {
        return $this->morphTo();
    }

    public function messages(): hasMany {
        return $this->hasMany(Message::class, 'from_id', 'id');
    }

    public function chats(): BelongsToMany {
        return $this->belongsToMany(Chat::class);
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    public function image(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function resumes(): HasMany
    {
        return $this->hasMany(Resume::class);
    }

    public function preview(): BelongsTo
    {
        return $this->belongsTo(Image::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function getPostCountAttribute() {
        return Post::where('user_id', $this->id)->where('is_from_company', false)->get()->count();
    }

    public function companyChats(): HasMany {
        return $this->hasMany(CompanyChat::class);
    }

    public function city(): BelongsTo {
        return $this->belongsTo(City::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(ApplicationTag::class, 'application_tag_users');
    }

    /**
     * Переопределение массива индекса модели по умолчанию
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        $array = $this->toArray();
        $array['search_country'] = implode(',',$this->city()->pluck('name')->toArray());
        $array['resume_description'] = implode(',', $this->resumes()->pluck('description')->toArray());
        $array['resume_solary'] = implode(',', $this->resumes()->with('userPositions')->pluck('salary')->toArray());
        $skillsCollection = User::with('resumes.skills')->get();
        $skills = [];
        foreach ($skillsCollection as $skill)
        {
            if($skill?->skill?->name) {
                $skills[] = $skill?->skill?->name;
            }
        }
        $array['skills'] = implode(',', $skills);
        return $array;
    }
}
