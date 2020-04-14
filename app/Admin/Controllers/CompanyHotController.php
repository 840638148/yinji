<?php

namespace App\Admin\Controllers;

use App\Admin\Controllers\BaseController;

use App\Models\Companyhot;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Validator;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;
use App\Models\Companyhot as CurrentModel;


class CompanyhotController extends BaseController
{
    use HasResourceActions;
    
    public $strHeader    = '热词搜索';
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
        $grid->content('添加热词')->sortable();
       /* $grid->display('公开度')->display(function ($display) {
            return $display == 0 ? '公开' : '私密';
        });*/
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
        $form = new Form(new $this->currentModel);
        
        $form->display('id', 'ID');
        $form->text('content', '热词');
        // $form->radio('display', '公开度')->options(['0' => '公开', '-1'=> '保密'])->default('0');

        return $form;
    }
    
    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
		$show = new Show($this->currentModel::findOrFail($id));
		
        $show->id('ID');
        $show->content('搜索热词');
        $show->display('公开度');
        $show->created_at('Created at');
        $show->updated_at('Updated at');
        return $show;
    }

    protected function valid(Request $request)
    {	 
    	return Validator::make($request->all(), [
    			'content' => 'required',
    	]);
    }
}
