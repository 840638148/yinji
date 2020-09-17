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
use App\Models\Dc;
use App\Models\LouPan;
use App\Models\DcCategory;
use App\Models\DcArticle as CurrentModel;

class DcArticleController extends BaseController
{
    use HasResourceActions;

    public $strHeader    = '地产文章';
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
            $filter->like('name', '文章名');
            $filter->like('designer', '标题(设计师)');
            $filter->like('intro', '标题(项目介绍)');

        });

        $id=$grid->id('ID')->sortable();
        $grid->name('标题(中)');
        $grid->name_en('标题(英)');
        $grid->xmavg('文章平均分');
        $grid->status('状态')->display(function ($article_status) {
            switch ($article_status) {
                case '0' :
                    $article_status = '草稿';
                    break;
                case '1' :
                    $article_status = '审核中';
                    break;
                case '2' :
                    $article_status = '已发布';
                    break;
            }
            return $article_status;
        });
        $grid->area('地区');
        $grid->release_time('发布时间')->sortable();
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
            
            $form->text('url', '静态地址')->help("如果输入：New-York-Downtown.html，则访问地址为：http://www.yinjispace.com/loupan/<span style='color:#F00;'>New-York-Downtown.html</span>");
            $form->select('lp_id', '楼盘')->options(LouPan::pluck('name', 'id'));
            $form->text('view_num', '浏览数')->default(5000);
            $form->text('favorite_num', '收藏数')->default(0);
            $form->text('download', '下载地址');
            $form->multipleSelect('category_ids', '文章分类')->options(DcCategory::getSelectOptions());
            $form->radio('status', '状态')->options(['0' => '草稿', '1' => '审核中', '2' => '已发布'])->default('0');
            $form->radio('display', '公开度')->options(['0' => '公开', '-1' => '保密'])->default('0');
            $form->datetime('release_time', '发布时间')->format('YYYY-MM-DD HH:mm:ss');
            $form->text('tag_ids', '标签(逗号分隔)');

            $form->multipleSelect('designer_id', '设计师')->options(Designer::getSelectOptions());

            $form->image('bgimg', '封面')
                ->uniqueName()
                ->widen(880)
                ->move('public/photo/images/dc_article/');
            
            $form->image('special_img', '特色照片')
                ->uniqueName()
                ->widen(1920)
                ->move('public/photo/images/special_img/');
            
        })->tab('中文', function ($form) {
            $form->text('designer', '设计师');
            $form->text('name', '标题');
            $form->text('area','地区');
            $form->text('intro', '简介');
            $form->ckeditor('content', '内容');
        })->tab('English', function ($form) {
            $form->text('designer_en', '设计师(英)');
            $form->text('name_en', '标题(英)');
            $form->text('area_en', '地区(英)');
            $form->text('intro_en', '简介(英)');
            $form->ckeditor('content_en', '内容(英)');
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
        $show->name('楼盘名');
        $show->name_en('楼盘名(英)');
        $show->title('项目名称');
        $show->title_en('项目名称(英)');
        $show->url('项目地址');
        $show->area('地区');
        $show->area_en('地区(英)');

        return $show;
    }
    
    
    protected function valid(Request $request)
    {	 
    	return Validator::make($request->all(), [
    	    'name' => 'required',
    	    'name_en' => 'required',
    	    'content' => 'required',
    	    'content_en' => 'required',
    	]);
    }

}
