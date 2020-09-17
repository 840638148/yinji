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
use App\Models\Dc;
use App\Models\Article;
use App\Models\DcArticle;
Use App\Models\Designer;
use App\Models\LouPan as CurrentModel;

class LouPanController extends BaseController
{
    use HasResourceActions;

    public $strHeader    = '楼盘';
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
            $filter->like('name', '楼盘名');

        });



        $id=$grid->id('ID')->sortable();
        $grid->name('楼盘名');
        $grid->view_num('浏览量');
        $grid->release_time('发布时间');
        $grid->lpavg('楼盘平均分');
        $grid->address('楼盘地址');
        $grid->email('邮箱');
        $grid->tel('电话');
        $grid->area('楼盘地区');

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
            $form->datetime('release_time', '发布时间')->format('YYYY-MM-DD HH:mm:ss');

            $form->select('dc_id', '地产')->options(Dc::pluck('name', 'id'));

            $states = [
                'on'  => ['value' => 1, 'text' => '打开', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '关闭', 'color' => 'default'],
            ];
            $form->switch('jz_display', '建筑状态')->states($states);
            $form->switch('yxzx_display', '营销中心状态')->states($states);
            $form->switch('gq_display', '公区状态')->states($states);
            $form->switch('ybf_display', '样板房状态')->states($states);
            $form->switch('yl_display', '园林状态')->states($states);
            $form->switch('hxt_display', '户型图状态')->states($states);

            $form->multipleSelect('jz_dcarticle_id', '建筑设计')->options(Article::jz_dcarticle_id());
            $form->multipleSelect('yxzx_dcarticle_id', '营销中心')->options(Article::yxzx_dcarticle_id());
            $form->multipleSelect('gq_dcarticle_id', '公共空间')->options(Article::gq_dcarticle_id());
            $form->multipleSelect('ybf_dcarticle_id', '样板房')->options(Article::ybf_dcarticle_id());
            $form->multipleSelect('yl_dcarticle_id', '园林')->options(Article::yl_dcarticle_id());

            $form->multipleSelect('designer_id', '设计师')->options(Designer::pluck('title_cn', 'id'));

            $form->image('cover', '封面')
                ->uniqueName()
                ->widen(880)
                ->move('public/photo/images/lp/');
            
            $form->image('bgimg', '背景图')
                ->uniqueName()
                ->widen(1920)
                ->move('public/photo/images/lp/');
            
            $form->image('logoimg', 'Logo')
                ->uniqueName()
                ->move('public/photo/images/lp/');
            
            $form->multipleImage('hxtimg', '户型图')
                ->uniqueName()
                ->move('public/photo/images/lp/');

        })->tab('中文', function ($form) {
            $form->text('name', '楼盘名');
            $form->text('address', '地址');
            $form->text('area','地区');
            $form->ckeditor('intro', '简介');
        })->tab('English', function ($form) {
            $form->text('name_en', '楼盘名(英文)');
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
        $show->name('楼盘名');
        $show->name_en('楼盘名(英文)');
        $show->title('项目名称');
        $show->title_en('项目名称(英文)');
        $show->url('项目地址');
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
