<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Laravel\Scout\Searchable;

class LinkMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'link'
    ];

    protected $table = 'link_messages';

    // $linkMessage->message()->associate(Message::where('id', 1)->first())->save();

    public function message():  MorphTo {
        return $this->morphTo();
    }
}
