<?php

namespace App\Admin\Controllers;

use App\Admin\Controllers\BaseController;
use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\Designer;
use App\Models\News;
use App\User;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Validator;
use Encore\Admin\Facades\Admin;

use App\Models\NewsComment as CurrentModel;

class NewsCommentController extends BaseController
{
    use HasResourceActions;
    
    public $strHeader    = '新闻评论';
    public $currentModel = CurrentModel::class;



    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new $this->currentModel);
        $grid->model()->orderBy('created_at', 'desc');

        $grid->disableCreateButton();
        $grid->actions(function ($actions) {
            $actions->disableView();
            $actions->disableEdit();
        });

        $grid->id('ID')->sortable();
        $grid->comment_id('新闻ID')->sortable();
        $grid->comment_title('新闻标题')->sortable()->display(function () {
            $obj = News::find($this->comment_id);
            if ($obj) {
                return get_designer_title($obj);
            }
            return '新闻不存在';
        });
        $grid->user_id('评论用户')->sortable()->display(function ($user_id) {
            $obj = User::find($user_id);
            if ($obj) {
                return $obj->nickname;
            }
            return '用户不存在';
        });
        $grid->content('评论内容')->display(function ($content) {
            return str_limit($content, 50, '...');
        })->expand(function ($model) {

            return $model->content;
        });


        $states = [
            'on'  => ['value' => 1, 'text' => '通过', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '未审核', 'color' => 'default'],
        ];
        $grid->column('display', '审核状态')->switch($states);
        //$grid->display('审核状态')->switch($states);
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
        $form->text('comment_id', '文章ID');
        $form->text('content', '评论内容');

        $states = [
            'on'  => ['value' => 1, 'text' => '通过', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '未审核', 'color' => 'default'],
        ];
        $form->switch('display', '审核状态')->states($states);

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

        return $show;
    }
    
    
    protected function valid(Request $request)
    {	 
    	return Validator::make($request->all(), [
    			'display' => 'required',
    	]);
    }
}
