<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyVisibility extends Model
{
    protected $table = 'company_visibilities';
    protected $fillable = ['name'];
    public $timestamps = false;
}
