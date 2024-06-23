<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Text extends Model
{
    use HasFactory;

    public function part(): MorphOne
    {
        return $this->morphOne(Part::class, 'content');
    }
}
