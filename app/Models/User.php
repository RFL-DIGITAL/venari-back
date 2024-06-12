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

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'htanle_type',
        'hrable_id',
        'sex',
        'date_of_birth',
        'workingStatus_id',
        'position_id',
        'image_id',
        'first_name',
        'last_name',
        'user_name',
        'company_name',
        'preview_name',       
    ];

    protected $attributes = [
        'post_count',
        'post_comment_count'
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

    /** @var string Стаж работы */
    public string $work_record;

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
        return $this->belongsTo(Preview::class);
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function getPostCountAttribute() {
        return Post::where('user_id', auth()->user()->id)->get()->count();
    }
  
    public function companyChats(): HasMany {
        return $this->hasMany(CompanyChat::class);
    }
}
