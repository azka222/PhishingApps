<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory;

    public function status()
    {
        return $this->belongsTo(CompanyStatus::class, 'status_id');
    }

    public function visibility()
    {
        return $this->belongsTo(CompanyVisibility::class, 'visibility_id');
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}


