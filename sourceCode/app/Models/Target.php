<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Target extends Model
{
    /** @use HasFactory<\Database\Factories\TargetFactory> */
    use HasFactory;


    public function department()
    {
        return $this->belongsTo(TargetDepartment::class, 'department_id');
    }

    public function position()
    {
        return $this->belongsTo(TargetPosition::class, 'position_id');
    }

    public static function makeCollectionFromCsv($files)
    {
        $collection = collect();
        foreach ($files as $file) {
          $target = array();
            $target['first_name'] = $file[1];
            $target['last_name'] = $file[2];
            $target['email'] = $file[3];
            $target['department'] = TargetDepartment::where('id', $file[4])->first()->name;
            $target['position'] = TargetPosition::where('id', $file[5])->first()->name;
            $target['age'] = $file[6];
            $collection->push($target);
        }
        return $collection;
    }

    public static function makeCollectionFromCsvForImport($files){
        $collection = collect();
        foreach ($files as $file) {
            $target = array();
            $target['first_name'] = $file[1];
            $target['last_name'] = $file[2];
            $target['email'] = $file[3];
            $target['department_id'] = $file[4];
            $target['position_id'] = $file[5];
            $target['age'] = $file[6];
            $target['company_id'] = auth()->user()->company_id;
            $collection->push($target);
        }
        return $collection;
    }

    
}
