<?php

namespace App\Admin\Controllers;

use App\Admin\Controllers\BaseController;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Validator;

use App\User as CurrentModel;

class VipsumController extends BaseController
{
    use HasResourceActions;

    public $strHeader    = '会员统计';
    public $currentModel = CurrentModel::class;



    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new $this->currentModel);
        
        $grid->model()->where('expire_time', '>', date('Y-m-d H:i:s'));
        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
            $actions->disableView();
        });
        $grid->tools(function ($tools) {
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('nickname', '昵称');

        });

        $id=$grid->id('ID')->sortable();
        $grid->avatar('头像')->image(30,30);
        $grid->nickname('昵称');
        
        
        $grid->level('会员种类')->display(function ($level) {
            switch ($level) {
                case '0':
                    $level = '普通会员';
                    break;
                case '1':
                    $level = '月会员';
                    break;
                case '2':
                    $level = '季会员';
                    break;
                case '3':
                    $level = '年会员';
                    break;
                case '4':
                    $level = '特邀作者';
                    break;
                case '5':
                    $level = '公司会员';
                    break;
            }
            return $level;
        });
       
        $grid->price('价格')->display(function () {
            $res=CurrentModel::getVipPrice($this->id);
            return $res['price'];
        });

        // $grid->title('支付类型');
        $grid->expire_time('过期时间')->sortable();

        return $grid;
    }


}
