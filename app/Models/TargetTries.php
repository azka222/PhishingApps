<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetTries extends Model
{
    public function target()
    {
        return $this->belongsTo(Target::class);
    }
}
