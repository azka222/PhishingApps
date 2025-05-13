<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetGroup extends Model
{
    protected $table = 'target_groups';

    protected $fillable = ['target_id', 'group_id'];

    public function target()
    {
        return $this->belongsTo(Target::class, 'target_id');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
    
}
