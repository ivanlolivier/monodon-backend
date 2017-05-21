<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\DB;

trait HasCoordinates
{

    static $miles2MetersCoeficient = 1609.34;

    public function setCoordinatesAttribute($value)
    {
        $point = $value['longitude'] . ',' . $value['latitude'];

        $this->attributes['coordinates'] = DB::raw("POINT($point)");
    }

    public function getCoordinatesAttribute($value)
    {
        $loc = substr($value, 6);
        $loc = preg_replace('/[ ,]+/', ',', $loc, 1);
        $loc = substr($loc, 0, -1);
        $loc = explode(',', $loc);

        return [
            'longitude' => isset($loc[0]) ? $loc[0] : null,
            'latitude'  => isset($loc[1]) ? $loc[1] : null,
        ];
    }

    public function newQuery($excludeDeleted = true)
    {
        $table_name = (new static)->getTable();
        $raw = ' ST_ASTEXT(' . $table_name . '.coordinates) as coordinates ';

        return parent::newQuery($excludeDeleted)->addSelect($table_name . '.*', DB::raw($raw));
    }
}
