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
use App\Models\Designer;

use App\Models\Dc as CurrentModel;

class DcController extends BaseController
{
    use HasResourceActions;

    public $strHeader    = '地产';
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
            $filter->like('name', '地产名');

        });

        $id=$grid->id('ID')->sortable();
        $grid->name('地产名');
        $grid->view_num('浏览量');
        $grid->release_time('发布时间');
        $grid->dcavg('平均分');
        $grid->address('地址');
        $grid->email('邮箱');
        $grid->tel('电话');
        $grid->area('地区');
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
            $form->text('url', '项目地址')->help("如果输入：New-York-Downtown.html，则访问地址为：http://www.yinjispace.com/loupan/<span style='color:#F00;'>New-York-Downtown.html</span>");
            $form->mobile('tel', '电话');
            $form->email('email', '邮箱');
            $form->text('fax', '传真');
            $form->text('view_num', '浏览量')->default(5000);
            $form->text('url1', '链接1');
            $form->text('url2', '链接2');
            $form->text('url3', '链接3');
            $form->datetime('release_time', '发布时间')->format('YYYY-MM-DD HH:mm:ss');

            // $form->multipleSelect('designer_id', '设计师')->options(Designer::pluck('title_cn', 'id'));

            $form->image('logoimg', 'Logo')
                ->uniqueName()
                ->move('public/photo/images/dc/');

            $form->image('cover', '封面图')
            ->uniqueName()
            ->widen(880)
            ->move('public/photo/images/dc/');
            
            $form->image('bgimg', '背景图')
            ->uniqueName()
            ->widen(1920)
            ->move('public/photo/images/dc/');

        })->tab('中文', function ($form) {
            $form->text('name', '地产名');
            $form->text('title', '标题1');
            $form->text('title1', '标题2');
            $form->text('address', '地址');
            $form->text('area','地区');
            $form->ckeditor('intro', '简介');
        })->tab('English', function ($form) {
            $form->text('name_en', '地产名(英文)');
            $form->text('title_en', '标题1(英文)');
            $form->text('title1_en', '标题2(英文)');
            $form->text('address_en', '地址(英文)');
            $form->text('area_en', '地区(英文)');
            $form->ckeditor('intro_en', '简介(英文)');
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
        $show->name('地产名');
        $show->name_en('地产名(英文)');
        $show->area('地区');
        $show->area_en('地区(英文)');
        $show->address('地址');
        $show->email('邮箱');
        $show->tel('电话');

        return $show;
    }
    
    
    protected function valid(Request $request)
    {	 
    	return Validator::make($request->all(), [
    	    'name' => 'required',
            // 'url' => 'required',
    	]);
    }

}
