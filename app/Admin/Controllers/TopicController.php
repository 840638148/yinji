<?php

namespace App\Admin\Controllers;

use App\Admin\Controllers\BaseController;
use App\Models\ArticleCategory;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Validator;

use App\Models\Topic as CurrentModel;

class TopicController extends BaseController
{
    use HasResourceActions;

    public $strHeader    = '专题';
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
        $grid->name_en('名称（英）')->sortable();
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
        $form->text('name_cn', '名称（中）');
        $form->text('name_en', '名称（英）');
        $form->multipleSelect('category_ids', '分类')->options(ArticleCategory::getSelectOptions());
        $form->image('custom_thum', '自定义封面')
            ->uniqueName()
            ->widen(600)
            ->move('public/photo/images/custom_thum/');
        $form->image('custom_thum_2', '自定义封面2')
            ->uniqueName()
            ->widen(600)
            ->move('public/photo/images/custom_thum/');
        $form->image('special_photo', '特色照片')
            ->uniqueName()
            ->widen(1920)
            ->move('public/photo/images/special_photo/');
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
        $show->name_en('名称(英)');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
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
