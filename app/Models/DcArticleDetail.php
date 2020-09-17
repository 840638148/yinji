<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DcArticleDetail extends Model
{
    public function article()
    {
        return $this->belongsTo(DcArticle::class);
    }
}
