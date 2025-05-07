<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModuleAbility extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_module_abilities', 'module_abilities_id', 'role_id')
            ->withTimestamps();
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function ability()
    {
        return $this->belongsTo(Ability::class, 'ability_id');
    }
}
