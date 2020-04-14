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

use App\Models\Company as CurrentModel;

class CompanyController extends BaseController
{
    use HasResourceActions;
    
    public $strHeader    = '公司管理';
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
        $grid->company_name('公司名称')->sortable();
        $grid->category('所属行业')->sortable();
        $grid->tel('联系电话');
        $grid->addr('办公地址');
        $grid->sort('排序');
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
        $form = new Form(new $this->currentModel);
        
        $form->display('id', 'ID');
        $form->text('company_name', '公司名称');
        $form->image('company_logo', 'LOGO')->uniqueName()->move('public/photo/images/custom_thum/');
        $form->text('category', '所属行业');
        $form->email('email', '邮箱');
        $form->url('web_site', '网站');
        $form->text('tel', '联系电话');
        $form->text('addr', '办公地址');
        $form->ckeditor('welfare', '福利待遇');
        $form->ckeditor('brief', '公司简介');
        $form->number('sort', '排序')->default('100')->help('排序,数值越小越靠前');
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
        $show->company_name('公司名称');
        $show->category('所属行业');
        $show->email('邮箱');
        $show->web_site('网站');
        $show->tel('联系电话');
        $show->addr('办公地址');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }
    
    
    protected function valid(Request $request)
    {	 
    	return Validator::make($request->all(), [
    			'company_name' => 'required',
    			'tel' => 'required',
    			//'content_cn' => 'required',
    	]);
    }
}
