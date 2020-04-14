<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FurnitureTag extends Model
{
    protected $fillable = ['name_cn', 'name_en'];//开启白名单字段
    
    /**
     * 获取select-option
     * @return FurnitureTag[]|\Illuminate\Database\Eloquent\Collection
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
