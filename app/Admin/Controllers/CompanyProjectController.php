<?php

namespace App\Admin\Controllers;

use App\Admin\Controllers\BaseController;
use App\Models\Company;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Validator;

use App\Models\CompanyProject as CurrentModel;

class CompanyProjectController extends BaseController
{
    use HasResourceActions;
    
    public $strHeader    = '公司项目';
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

        $grid->company_id('公司名称')->display(function ($company_id) {
            $company = Company::find($company_id);
            if ($company) {
                return $company->company_name;
            }
            return $company_id;
        });
        $grid->project_name('项目名称')->sortable();
        $grid->link_url('项目链接');
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
        $form->select('company_id', '公司名称')->options(Company::getSelectOptions());
        $form->text('project_name', '项目名称');
        $form->image('project_photo', '项目图片')->uniqueName()->move('public/photo/images/custom_thum/');
        $form->url('link_url', '项目链接');
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
        $show->project_name('项目名称');
        $show->link_url('项目链接');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }
    
    
    protected function valid(Request $request)
    {	 
    	return Validator::make($request->all(), [
    			'company_id' => 'required',
    			'project_name' => 'required',
    			//'content_cn' => 'required',
    	]);
    }
}
