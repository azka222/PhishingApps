<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetPosition extends Model
{
    protected $table = 'target_positions';
    protected $fillable = [
        'name',
    ];
}
