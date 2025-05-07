<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table = 'modules';
    protected $fillable = ['name'];

    public function moduleAbilities()
    {
        return $this->hasMany(ModuleAbility::class, 'module_id');
    }

    public function abilities()
    {
        return $this->belongsToMany(Ability::class, 'module_abilities', 'module_id', 'ability_id');
    }
}
