<?php
namespace App\Helpers;

use Illuminate\Support\Collection;

class FileHelper
{
    public static function convertCsvToCollection(string $csv, string $separator = ","): Collection
    {
        $csv = trim($csv, "\n");
        return collect(explode("\n", $csv))->map(function ($value, $key) use ($separator) {
            $collection=collect(explode($separator, $value))->map(function ($item, $key) {
                if(($item)!="")
                return $item;
            });
            $last=$collection->last();
            $collection[$collection->count()-1]=str_replace("\r","",$last);
            return  $collection;
        });
    }
}
