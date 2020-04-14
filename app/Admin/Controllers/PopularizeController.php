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

use App\Models\Popularize as CurrentModel;

class PopularizeController extends BaseController
{
    use HasResourceActions;
    
    public $strHeader    = '广告设置';
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
        $grid->ad_type('广告类型')->display(function ($ad_type) {
            $str_type = $ad_type;
            switch ($ad_type) {
                case '1':
                    $str_type = '首页滚动图';
                    break;
                case '2':
                    $str_type = '首页3张小图';
                    break;
                case '3':
                    $str_type = '右边滚动小图';
                    break;
                case '4':
                    $str_type = '首页设计大师';
                    break;
                case '5':
                    $str_type = '首页知名设计师';
                    break;
                case '6':
                    $str_type = '文章详情页面3个小图';
                    break;
                case '7':
                    $str_type = '新闻列表页面3个小图';
                    break;
                case '8':
                    $str_type = '首页右下小图';
                    break;

            }
            return $str_type;

        });
        $grid->ad_title('标题');
        $grid->display('是否启用')->display(function ($display) {
            return $display == 0 ? '启用' : '隐藏';
        });
        $grid->ad_url('跳转地址');
        $grid->sort('排序')->sortable();
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

        //$form->display('id', 'ID');
        $form->select('ad_type', '广告类型')->options(
            [
                '1' => '首页滚动图',
                '2' => '首页3张小图',
                '3' => '右边滚动小图',
                '4' => '首页设计大师',
                '5' => '首页知名设计师',
                '6' => '文章详情页面3个小图',
                '8' => '首页右下小图',
            ]
        );
        $form->text('ad_title', '标题');
        $form->text('ad_url', '跳转地址');
        $form->image('ad_img', '图片')->uniqueName()->move('/public/photo/images/popularize');
        $form->radio('display', '是否启用')->options(['0' => '启用', '-1'=> '隐藏'])->default('0');

        $form->text('sort', '排序')->default('0');


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
        $show->ad_type('广告类型');
        $show->ad_title('标题');
        $show->ad_url('跳转地址');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }
    
    
    protected function valid(Request $request)
    {	 
    	return Validator::make($request->all(), [
    	    'ad_type' => 'required',
            'ad_title' => 'required',
            //'ad_img' => 'required',
    		//'ad_url' => 'required',
    	]);
    }
}
