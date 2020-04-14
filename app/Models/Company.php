<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * 获取select-option
     * @return DesignerCategory[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getSelectOptions()
    {
        $options = self::select('id','company_name as text')->get();
        $selectOption = [];
        foreach ($options as $option){
            $selectOption[$option->id] = $option->text;
        }
        return $selectOption;
    }
    
    
        
    public function work()
	{
	    return $this->hasOne(CompanyWork::class, 'company_id', 'id');

	}

}
