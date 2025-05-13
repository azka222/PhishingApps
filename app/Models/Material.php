<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $table = 'materials';

 
    public function attachment()
{
    return $this->belongsTo(MaterialAttachment::class, 'material_attachment_id', 'id');
}

}
