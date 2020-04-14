<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyProject extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    
    public function project(){
    	return $this->belongsTo(Project::class, 'company_id', 'id');
    }
    
}
