<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FurnitureCategory extends Model
{
    
    /**
     * 获取select-option
     * @return FurnitureCategory[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getSelectOptions()
    {
        $options = self::select('id','name_cn as text')->get();
        $selectOption = [];
        foreach ($options as $option){
            $selectOption[$option->id] = $option->text;
        }
        return $selectOption;
    }
}
