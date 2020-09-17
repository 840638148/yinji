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

use App\Models\Photographer as CurrentModel;

class PhotographerController extends BaseController
{
    use HasResourceActions;

    public $strHeader    = '摄影师';
    public $currentModel = CurrentModel::class;



    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new $this->currentModel);
        

        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('name', '摄影师名称');

        });

        $id=$grid->id('ID')->sortable();
        $grid->name('昵称');
        $grid->avatar('头像')->image('',50,50);
        $grid->url('链接');
        
        return $grid;
    }

        /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new $this->currentModel);

        $form->tab('基本信息', function ($form) {
            $form->text('name', '名字');

            $form->image('avatar', '头像')->thumbnail('small', $width = 300, $height = 300)
            // ->uniqueName()
            ->move('public/photo/sys_avatar/');

            $form->text('url', '链接');
       
        });

        return $form;
    }
    
    /**
     * Make a show builder.
     *
     * @param mixed   $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show($this->currentModel::findOrFail($id));

        $show->id('ID');
        $show->name('名字');
        $show->avatar('头像');
        $show->url('跳转地址');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }
    
    
    protected function valid(Request $request)
    {	 
    	return Validator::make($request->all(), [
    	    // 'name' => 'required',
            // 'url' => 'required',
    	]);
    }

}
