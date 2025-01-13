<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
    protected $table = 'abilities';
    protected $fillable = ['name'];

    public function moduleAbilities()
    {
        return $this->hasMany(ModuleAbility::class, 'ability_id');
    }
}
