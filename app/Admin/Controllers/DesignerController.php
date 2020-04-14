<?php

namespace App\Admin\Controllers;

use App\Admin\Controllers\BaseController;
use App\Models\Topic;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Validator;

use App\Models\Designer as CurrentModel;
use App\Models\DesignerCategory;
use App\Models\DesignerTag;

class DesignerController extends BaseController
{
    use HasResourceActions;
    
    public $strHeader    = '名师';
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

            // 在这里添加字段过滤器
            $filter->like('title_cn', '标题(中)');

        });

        $grid->id('ID')->sortable();
        $grid->title_cn('标题(中)');
        $grid->title_en('标题(英)');
        $grid->industry('行业')->display(function ($industry) {
            $str_industry = $industry;
            switch ($str_industry) {
                case '1':
                    $str_industry = '室内设计师';
                    break;
                case '2':
                    $str_industry = '建筑师';
                    break;

            }
            return $str_industry;
        });
        $grid->designer_status('状态')->display(function ($display) {
            return $display == 0 ? '草稿' : '已发布';
        });
        $grid->display('公开度')->display(function ($display) {
            return $display == 0 ? '公开' : '私密';
        });
//        $grid->master('设计大师')->display(function ($master) {
//            return $master == 0 ? '否' : '是';
//        });
//        $grid->noted('知名设计师')->display(function ($noted) {
//            return $noted == 0 ? '否' : '是';
//        });
        $grid->release_time('发布时间')->sortable();
        $grid->subscription_num('订阅数')->sortable();
        $grid->view_num('浏览数')->sortable();
        $grid->allow_discuss('允许评论')->display(function ($display) {
            return $display == 0 ? '不允许' : '允许';
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
        
        $form->tab('基本信息', function ($form) {

            //$form->display('id', 'ID');
            $form->text('static_url', '静态地址')->help("如果输入：Yabu-Pushelberg.html，则访问地址为：http://www.yinjispace.com/designer/<span style='color:#F00;'>Yabu-Pushelberg.html</span>");
            $form->radio('industry', '行业')->options(['1' => '室内设计师', '2'=> '建筑师'])->default('1');
            $form->radio('designer_status', '状态')->options(['0' => '草稿', '1'=> '已发布'])->default('0');
            $form->radio('display', '公开度')->options(['0' => '公开', '-1'=> '保密'])->default('0');
//            $form->radio('master', '设计大师')->options(['0' => '否', '1'=> '是'])->default('0');
//            $form->radio('noted', '知名设计师')->options(['0' => '否', '1'=> '是'])->default('0');
            $form->datetime('release_time', '发布时间')->format('YYYY-MM-DD HH:mm:ss');
            $form->multipleSelect('category_ids', '分类')->options(DesignerCategory::getSelectOptions());
            $form->multipleSelect('topic_ids', '专题')->options(Topic::getSelectOptions());
            $form->text('tag_ids', '标签');
            $form->text('subscription_num', '订阅数')->default('0');
            $form->text('like_num', '点赞数')->default('0');
            $form->text('view_num', '浏览数')->default('0');
            $form->radio('allow_discuss', '允许评论')->options(['1'=> '允许', '0' => '不允许'])->default('1');
            $form->image('custom_thum', '自定义缩略图(480x630)')->uniqueName()->move('public/photo/images/custom_thum/');
            $form->image('special_photo', '特色照片')->uniqueName()->move('public/photo/images/special_photo/');
//            $form->text('down_url', '全套作品下载链接');
            //$form->text('article_ids', '文章ID(多个用逗号隔开)');
            //$form->text('seo_title', 'SEO标题');
            //$form->text('seo_keyword', 'SEO关键词');
            //$form->text('seo_desc', 'SEO描述');
        })->tab('中文', function ($form) {

            $form->text('title_cn', '标题(中)');
            $form->ckeditor('detail.content_cn', '正文(中)');

        })->tab('English', function ($form) {

            $form->text('title_en', '标题(英)');
            $form->ckeditor('detail.content_en', '正文(英)');

        })->tab('分享网站', function ($form) {

            //$form->text('title_cn', '标题(中)');
            //$form->ckeditor('detail.content_cn', '正文(中)');
            $form->hasMany('shares', '分享网站', function (Form\NestedForm $form) {
                $form->text('share_name', '分享名称');
                $form->url('share_url', '分享链接');
                $form->icon('share_icon', '分享图标');
            });

        });

        //保存前回调
        $form->saving(function (Form $form) {
            if (empty($form->model()->release_time)) {
                $form->release_time = date('Y-m-d H:i:s');
            }
        });
      
        $form->saved(function (Form $form) {
    		$tags = explode(',', $form->tag_ids);
            foreach ($tags as $tag) {
                //echo $tag;
              	$ret = DesignerTag::firstOrCreate(['name_cn' => trim($tag)]);
            }
            
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
        $show->title_cn('标题(中)');
        $show->title_en('标题(英)');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }
    
    
    protected function valid(Request $request)
    {	 
    	return Validator::make($request->all(), [
    			'title_cn' => 'required',
    			'title_en' => 'required',
    			'detail.content_cn' => 'required',
    			'detail.content_en' => 'required',
    	]);
    }
}
