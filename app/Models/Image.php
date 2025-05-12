<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Image extends Model
{
    protected $guarded = ['id'];

    public function imageable()
    {
        return $this->morphTo();
    }
}
