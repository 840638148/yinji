<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FurnitureDetail extends Model
{
    public function furniture()
    {
        return $this->belongsTo(Furniture::class);
    }
}
