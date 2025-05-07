<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = ['name', 'description', 'company_id', 'status', 'department_id'];
    protected $table = 'groups';

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function department()
    {
        return $this->belongsTo(TargetDepartment::class, 'department_id');
    }

    public function target()
    {
        return $this->belongsToMany(Target::class, 'target_groups', 'group_id', 'target_id');
    }

}
