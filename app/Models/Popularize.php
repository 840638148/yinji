<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Popularize extends Model
{
    public static function getPopularize($ad_type = 1, $limit = null)
    {
        $obj = Popularize::where('ad_type', $ad_type)
            ->where('display', '0')
            ->orderBy('sort', 'asc');

        if ($limit > 0) {
            $obj->limit($limit);
        }

        return $obj->get();
    }
}
