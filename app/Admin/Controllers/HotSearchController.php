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
use Encore\Admin\Facades\Admin;

use App\Models\HotSearch as CurrentModel;

class HotSearchController extends BaseController
{
    use HasResourceActions;
    
    public $strHeader    = '热门搜索';
    public $currentModel = CurrentModel::class;



    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new $this->currentModel);

        $grid->id('ID')->sortable();
        $grid->name_cn('名称（中）')->sortable();
        $grid->name_en('名称（英/全）')->sortable();
        $grid->display('公开度')->display(function ($display) {
            return $display == 0 ? '公开' : '私密';
        });
        $grid->created_at('添加时间')->sortable();

        return $grid;
    }


    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form($this->currentModel);
        
        $form->display('id', 'ID');
        $form->text('name_cn', '名称（中）');
        $form->text('name_en', '名称（英/全）');
        $form->radio('display', '公开度')->options(['0' => '公开', '-1'=> '保密'])->default('0');
        //$form->display('created_at', 'Created At');
        //$form->display('updated_at', 'Updated At');

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
        $show->name_cn('名称(中)');
        $show->name_en('名称(英/全)');
        $show->display('公开度');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }
    
    
    protected function valid(Request $request)
    {	 
    	return Validator::make($request->all(), [
    			'name_cn' => 'required',
                'name_en' => 'required',
    	]);
    }
}
