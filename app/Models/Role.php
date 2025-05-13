<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name', 'company_id'];

    public function moduleAbility()
    {
        return $this->belongsToMany(ModuleAbility::class, 'role_module_abilities', 'role_id', 'module_abilities_id')
            ->withTimestamps();
    }

    public function users(){
        return $this->hasMany(User::class);
    }

 

}
