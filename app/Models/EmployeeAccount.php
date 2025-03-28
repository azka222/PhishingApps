<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeAccount extends Model
{
    protected $table = 'employee_accounts';

    protected $fillable = [
        'target_id',
    ];

    public function target()
    {
        return $this->belongsTo(Target::class);
    }
}
