<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyStatus extends Model
{
    protected $table = 'company_statuses';
    protected $fillable = ['name'];
    public $timestamps = false;
}
