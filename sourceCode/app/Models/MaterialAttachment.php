<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialAttachment extends Model
{
    protected $table = 'material_attachments';

    protected $fillable = [
        'name',
        'path',
    ];
}
