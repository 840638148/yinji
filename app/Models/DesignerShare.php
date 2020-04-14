<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DesignerShare extends Model
{
    protected $fillable = ['designer_id', 'share_name', 'share_url', 'share_icon'];
    
    public function designer()
    {
        return $this->belongsTo(Designer::class);
    }
}
