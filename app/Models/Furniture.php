<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Furniture extends Model
{
    public function detail()
    {
        return $this->hasOne(FurnitureDetail::class);
    }
    
    public function getCategoryIdsAttribute($value)
    {
        return explode(',', $value);
    }

    public function setCategoryIdsAttribute($value)
    {
        $this->attributes['category_ids'] = implode(',', $value);
    }
}
