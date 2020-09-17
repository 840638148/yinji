<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Traits\AdminBuilder;
use Encore\Admin\Traits\ModelTree;

class DcCategory extends Model
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
     * @return DcCategory[]|\Illuminate\Database\Eloquent\Collection
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

    //获取文章分类得id
    public static function getcategory($articlelists){
        foreach($articlelists as $k=>$v){
            $articlelists[$k]['category']=self::whereIn('id',$v['category_ids'])->get();
        }
        return $articlelists;
    }

}
