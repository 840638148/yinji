<?php

namespace App\Admin\Controllers;

use App\Admin\Controllers\BaseController;
use App\Models\DcArticle;
use App\Models\DcArticleComment;
use App\Models\UserPoint;
use App\User;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Http\Request;
use Validator;
use DB;
use Encore\Admin\Facades\Admin;
use Illuminate\Support\Facades\Auth;

use App\Models\DcArticleComment as CurrentModel;

class DcArticleCommentController extends BaseController
{
    use HasResourceActions;
    
    public $strHeader    = '文章评论';
    public $currentModel = CurrentModel::class;
    private $comid ;


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

        $grid->filter(function($filter){
            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->equal('display', '审核状态');

        });

        $grid->id('ID')->sortable();
        $grid->comment_id('文章ID')->sortable();
        $grid->comment_title('文章标题')->sortable()->display(function () {
            $obj = DcArticle::find($this->comment_id);
            if ($obj) {
                return get_dc_title($obj);
            }
            return '文章不存在';
        });
        $grid->user_id('评论用户')->sortable()->display(function ($user_id) {
            $obj = User::find($user_id);
            
            if ($obj) {
                return $obj->nickname;
            }
            return '用户不存在';
        });

        $grid->stars('评分')->sortable();
        $grid->content('评论内容')->display(function ($content) {
            return str_limit($content, 50, '...')?? '无评论';
        })->expand(function ($model) {
            return $model->content ?? '无评论';
        });

        $states = [
            'on'  => ['value' => 1, 'text' => '通过', 'color' => 'success'],
            'off' => ['value' => 0, 'text' => '未审核', 'color' => 'default'],
        ];
        $grid->column('display', '审核状态')->switch($states);
        $grid->created_at('发表时间')->sortable();

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
        $comid=$form->text('comment_id', '文章ID');
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
    


    public function putEdits(Request $request, $id)
    {   

    	$validator = $this->valid($request);
    	if ($validator->fails()) {
    		return back()->withInput()->withErrors($validator);
        }
        
        if($request->display=='on'){
            $user=DcArticleComment::leftjoin('users','dc_article_comments.user_id','=','users.id')->where('dc_article_comments.id',$id)->first();

            $das=[
                'user_id' => $user->user_id,
                'type' => '0',
                'point' => 12,
                'remark' => '评论',
            ];
            $re=UserPoint::where('id',$user->user_id)->create($das);
        }
    	return $this->form($request)->update($id);
    }

    protected function valid(Request $request)
    {	 
    	return Validator::make($request->all(), [
    			'display' => 'required',
    	]);
    }
}
