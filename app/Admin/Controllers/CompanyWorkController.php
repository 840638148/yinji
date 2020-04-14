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

use App\Models\CompanyWork as CurrentModel;

class CompanyWorkController extends BaseController
{
    use HasResourceActions;
    
    public $strHeader    = '招聘职位';
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
        $grid->job_name('职位名称')->sortable();
        $grid->addr('工作地点');
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
        $form->text('job_name', '职位名称');
        $form->text('addr', '工作地点');
        // $form->ckeditor('job_require', '要求');
        $form->ckeditor('content', '职位内容');
        $form->ckeditor('skills', '任职要求');  
        $form->radio('new', '新-new')->options(['0' => '否', '1'=> '是'])->default('0');
        $form->radio('hot', '热-hot')->options(['0' => '否', '1'=> '是'])->default('0');
        $form->radio('fast', '急-fast')->options(['0' => '否', '1'=> '是'])->default('0');
        $form->number('sort', '排序')->default('100')->help('排序,数值越小越靠前');
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
        $show->job_name('职位名称');
        $show->addr('工作地点');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }
    
    
    protected function valid(Request $request)
    {	 
    	return Validator::make($request->all(), [
    			'company_id' => 'required',
    			'job_name' => 'required',
    			//'content_cn' => 'required',
    	]);
    }
}
