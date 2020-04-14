<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleTag extends Model
{
    protected $fillable = ['name_cn', 'name_en'];//开启白名单字段
  
    /**
     * 获取select-option
     * @return ArticleTag[]|\Illuminate\Database\Eloquent\Collection
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

    public static function getHotTags($limit = 20)
    {
        $obj = ArticleTag::where('display', '0')
            ->orderBy('created_at', 'desc');
        if ($limit > 0) {
            $obj->limit($limit);
        }

        return $obj->get();
    }
}
