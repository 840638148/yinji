<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignerDetail extends Model
{
    public function designer()
    {
        return $this->belongsTo(Designer::class);
    }
}
