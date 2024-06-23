<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Title extends Model
{
    use HasFactory;

    public function part(): MorphOne
    {
        return $this->morphOne(Part::class, 'content');
    }

}
