<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetDepartment extends Model
{
    protected $table = 'target_departments';
    protected $fillable = [
        'name',
    ];
}
