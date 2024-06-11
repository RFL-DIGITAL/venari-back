<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class CompanyMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'companyChat_id',
        'body'
    ];

    public function companyChat(): BelongsTo {
        return $this->belongsTo(CompanyChat::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fileMessage(): MorphOne
    {
        return $this->morphOne(FileMessage::class, 'message');
    }

    public function imageMessage(): MorphOne
    {
        return $this->morphOne(ImageMessage::class, 'message');
    }

    public function linkMessage(): MorphOne
    {
        return $this->morphOne(LinkMessage::class, 'message');
    }
}
