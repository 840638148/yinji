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

use App\Models\Article as CurrentModel;
use App\Models\ArticleCategory;
use App\Models\ArticleTag;
use App\Models\Designer;

class ArticleController extends BaseController
{
    use HasResourceActions;

    public $strHeader = '文章';
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
            //$filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('title_designer_cn', '标题(设计师)');
            $filter->like('title_name_cn', '标题(项目名称)');
            $filter->like('title_intro_cn', '标题(项目介绍)');

        });

        $grid->id('ID')->sortable();
        $grid->title_designer_cn('标题(中)')->display(function () {
            return CurrentModel::formatTitle($this, 'cn');
        });
        $grid->title_designer_en('标题(英)')->display(function () {
            return CurrentModel::formatTitle($this, 'en');
        });
        $grid->article_status('状态')->display(function ($article_status) {
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
        $grid->release_time('发布时间')->sortable();
        
        // $grid->column('created_at', __('发布时间'));
        $grid->created_at('添加时间')->sortable();
        // $grid->column('updated_at', __('添加时间'));

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
            //$form->text('keyword', '关键词');
            $form->text('static_url', '静态地址')->help("如果输入：New-York-Downtown.html，则访问地址为：http://www.yinjispace.com/article/<span style='color:#F00;'>New-York-Downtown.html</span>");
            $form->radio('article_status', '状态')->options(['0' => '草稿', '1' => '审核中', '2' => '已发布'])->default('0');
            $form->radio('display', '公开度')->options(['0' => '公开', '-1' => '保密'])->default('0');
            $form->datetime('release_time', '发布时间')->format('YYYY-MM-DD HH:mm:ss');
            // $form->datetime('created_at','发布时间')->format('YYYY-MM-DD HH:mm:ss');
            $form->multipleSelect('category_ids', '分类')->options(ArticleCategory::getSelectOptions());
            $form->multipleSelect('topic_ids', '专题')->options(Topic::getSelectOptions());
            $form->text('tag_ids', '标签（逗号分隔）');
            $form->text('view_num', '浏览数')->default(0);
            $form->text('like_num', '点赞数')->default(0);
            $form->text('favorite_num', '收藏数')->default(0);
            $form->text('vip_download', '下载地址');
            //$form->multipleSelect('designer_id', '设计师ID')->options(Designer::getSelectOptions());
            $form->multipleSelect('designer_id', '设计师')->options(function ($ids) {
                $designer = Designer::find($ids);
                if ($designer) {
                    return $designer->pluck('title_cn', 'id');
                }

            })->ajax('/admin/article/get_designer_select_options');
            $form->text('article_source', '文章来源');
            $form->text('article_source_url', '文章来源URL');
            $form->image('custom_thum', '自定义封面')
                ->uniqueName()
                ->widen(880)
                ->move('public/photo/images/custom_thum/');
            $form->image('special_photo', '特色照片')
                ->uniqueName()
                ->widen(1920)
                ->move('public/photo/images/special_photo/');
            $form->text('seo_title', 'SEO标题');
            $form->text('seo_keyword', 'SEO关键词');
            $form->text('seo_desc', 'SEO描述');
        })->tab('中文', function ($form) {

            $form->text('title_designer_cn', '标题(设计师)');
            $form->text('title_name_cn', '标题(项目名称)');
            $form->text('title_intro_cn', '标题(项目介绍)');
            $form->text('description_cn', '自定义描述(中)');
            $form->text('location_cn', '地域(中)');
            $form->ckeditor('detail.content_cn', '正文(中)');

        })->tab('English', function ($form) {

            $form->text('title_designer_en', '标题(设计师)');
            $form->text('title_name_en', '标题(项目名称)');
            $form->text('title_intro_en', '标题(项目介绍)');
            $form->text('description_en', '自定义描述(英)');
            $form->text('location_en', '地域(英)');
            $form->ckeditor('detail.content_en', '正文(英)');

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
                echo $tag;
                $ret = ArticleTag::firstOrCreate(['name_cn' => trim($tag)]);
            }

        });


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
        $show->title_designer_cn('标题(中)');
        $show->title_designer_en('标题(英)');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }


    protected function valid(Request $request)
    {
        return Validator::make($request->all(), [
            'title_designer_cn' => 'required',
            'title_designer_en' => 'required',
            'detail.content_cn' => 'required',
            'detail.content_en' => 'required',
        ]);
    }

    public function getDesignerSelectOptions(Request $request)
    {
        $q = $request->get('q');

        return Designer::where('title_cn', 'like', "%$q%")->paginate(null, ['id', 'title_cn as text']);
    }
}
