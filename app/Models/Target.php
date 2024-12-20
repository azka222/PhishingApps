<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    /** @use HasFactory<\Database\Factories\TargetFactory> */
    use HasFactory;


    public function department()
    {
        return $this->belongsTo(TargetDepartment::class, 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(TargetPosition::class, 'position_id');
    }
}
