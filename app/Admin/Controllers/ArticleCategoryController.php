<?php

namespace App\Admin\Controllers;

use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Validator;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Column;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Row;
use Encore\Admin\Tree;
use Encore\Admin\Widgets\Box;
use Illuminate\Support\Facades\DB;

use App\Models\ArticleCategory as CurrentModel;

class ArticleCategoryController extends BaseController
{
    use HasResourceActions;
    
    public $strHeader    = '文章分类';
    public $currentModel = CurrentModel::class;
	
	
	
	
	/**
     * Index interface.
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header($this->strHeader)
            ->description(trans('admin.list'))
            ->row(function (Row $row) {
                $row->column(6, $this->treeView()->render());

                $row->column(6, function (Column $column) {
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(admin_base_path('article_category'));


                    $form->select('parent_id', trans('父级菜单'))->options(CurrentModel::selectOptions());
                    $form->text('name_cn', '名称（中）')->rules('required');
                    $form->text('name_en', '名称（英）');

                    $form->hidden('_token')->default(csrf_token());

                    $column->append((new Box(trans('admin.new'), $form))->style('success'));
                });
            });
    }


    /**
     * @return \Encore\Admin\Tree
     */
    protected function treeView()
    {

        return CurrentModel::tree(function (Tree $tree) {
            $tree->disableCreate();

            $tree->branch(function ($branch) {
                $payload = "&nbsp;<strong>{$branch['name_cn']}</strong>&nbsp;/&nbsp;<strong>{$branch['name_en']}</strong>";

                return $payload;
            });
        });
    }

    /**
     * Edit interface.
     *
     * @param string  $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header($this->header)
            ->description('编辑文章分类')
            ->row($this->form()->edit($id));
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        $form = new Form(new CurrentModel());

        $form->display('id', 'ID');

        $form->select('parent_id', trans('父级菜单'))->options(CurrentModel::selectOptions());
        $form->text('name_cn', '名称（中）')->rules('required');
        $form->text('name_en', '名称（英）');

        $form->display('created_at', trans('admin.created_at'));
        $form->display('updated_at', trans('admin.updated_at'));

        return $form;
    }
    

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit223($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header($this->header);
            $content->description('编辑文章分类');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header($this->header);
            $content->description('添加文章分类');

            $content->body($this->form());
        });
    }

    public function getCategoryOptions()
    {
        return CurrentModel::getSelectOptions();
    }
    
    
    protected function valid(Request $request)
    {	 
    	return Validator::make($request->all(), [
    			'name_cn' => 'required',
    			'name_en' => 'required',
    			//'content_cn' => 'required',
    	]);
    }
}
