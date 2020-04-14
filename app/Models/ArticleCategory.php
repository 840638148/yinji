<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class ArticleCategory extends Model
{
    use ModelTree, AdminBuilder;
  
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setParentColumn('parent_id');
        $this->setOrderColumn('sort');
        $this->setTitleColumn('name_cn');
    }
  
    /**
     * 获取select-option
     * @return ArticleCategory[]|\Illuminate\Database\Eloquent\Collection
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

    public static function getTopics($id)
    {
        $topics = Topic::where('category_ids', 'like', "%{$id}%")->orderBy('created_at', 'desc')->get();
        return $topics;
    }
}
