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

use App\User as CurrentModel;

class MemberController extends BaseController
{
    use HasResourceActions;
    
    public $strHeader    = '会员列表';
    public $currentModel = CurrentModel::class;



    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new $this->currentModel);
        $grid->model()->where('expire_time', '>', date('Y-m-d H:i:s'));
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            // 在这里添加字段过滤器
            $filter->like('username', '用户名');
            $filter->like('nickname', '昵称');
            $filter->like('mobile', '手机');
            $filter->like('email', '邮箱');

        });

        $grid->id('ID')->sortable();
        $grid->avatar('头像')->image(30,30);
        $grid->username('用户名')->sortable();
        $grid->nickname('昵称');
        $grid->mobile('手机');
        $grid->email('邮箱');
        $grid->level('会员种类')->display(function ($level) {
            switch ($level) {
                case '0':
                    $level = '普通会员';
                    break;
                case '1':
                    $level = '月会员';
                    break;
                case '2':
                    $level = '季会员';
                    break;
                case '3':
                    $level = '年会员';
                    break;
                case '4':
                    $level = '特邀作者';
                    break;
                case '5':
                    $level = '公司会员';
                    break;
            }
            return $level;
        });
        $grid->expire_time('到期时间');
        $grid->points('积分')->sortable();
        $grid->last_login_time('上次登录')->sortable();
        $grid->created_at('注册时间')->sortable();

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
        $form->text('username', '用户名');
        $form->text('nickname', '昵称');
        $form->text('password', '修改密码')->placeholder('如果需要修改密码请输入');
        $form->text('mobile', '手机');
        $form->radio('sex', '性别')->options(['0' => '保密', '1' => '男', '2' => '女'])->default('0');
        $form->text('city', '城市');
        $form->text('url', '个人主页');
        $form->text('personal_note', '个人说明');
        $form->select('level', '会员种类')->options(
            [
                '0' => '普通会员',
                '1' => '月会员',
                '2' => '季会员',
                '3' => '年会员',
                '4' => '特邀作者',
                '5' => '公司会员',
            ]
        );
        $form->datetime('expire_time', '到期时间');
        $form->number('points', '积分');

        //保存前回调
        $form->saving(function (Form $form) {
            if ($form->password) {
                $form->password = bcrypt($form->password);
            } else {
                $form->password = $form->model()->password;
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
        $show->username('用户名');
        $show->nickname('昵称');
        $show->mobile('手机');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }
    
    
    protected function valid(Request $request)
    {	 
    	return Validator::make($request->all(), [
    	    'username' => 'required',
    	]);
    }
}
