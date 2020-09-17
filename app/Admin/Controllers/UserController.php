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
use DB;
use App\User as CurrentModel;
use Zhusaidong\GridExporter\Exporter;

class UserController extends BaseController
{
    use HasResourceActions;
    
    public $strHeader    = '用户列表';
    public $currentModel = CurrentModel::class;



    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new $this->currentModel);
        
        $exporter=Exporter::get($grid);
        $exporter->setFileName('user.xlsx');

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
        $img='/img/avatar.png';
        $grid->avatar('头像')->image(30,30);
        // dd($grid->avatar('头像'));
        $grid->username('用户名')->sortable();
        $grid->nickname('昵称');
        $grid->mobile('手机');
        $grid->email('邮箱');
        $grid->points('积分')->sortable();
        $grid->last_login_time('上次登录')->sortable();
        $grid->created_at('注册时间')->sortable();

        return $grid;
    }

    // public static function exporter(){
    //     Exporter::get($grid);
    // }

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
        // $form->text('url', '个人主页');
        $form->select('zhiwei', '职位')->options(
            [
                '建筑师' => '建筑师',
                '室内设计师' => '室内设计师',
                '软装设计师' => '软装设计师',
                '产品设计师' => '产品设计师',
                '摄影师' => '摄影师',
                '媒体人' => '媒体人',
                '地产开发' => '地产开发',                
                '其他' => '其他',
            ]
        );        
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
        $form->number('left_points', '剩余积分');

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
    
    

    /**
     * Delete action.
     *
     * @param $id
     * @return Content
     */
    public function removes($id)
    {
        $ids = explode(',', $id);
        
        $res1=Db::table('users')->where('id',$ids)->delete();
        $res2=Db::table('vip_buy_orders')->where('user_id',$ids)->delete();
        $res3=Db::table('user_thirds')->where('user_id',$ids)->delete();
        $res4=Db::table('user_subscriptions')->where('user_id',$ids)->delete();
        $res5=Db::table('user_points')->where('user_id',$ids)->delete();
        $res6=Db::table('user_likes')->where('user_id',$ids)->delete();
        $res7=Db::table('user_follows')->where('user_id',$ids)->delete();
        $res8=Db::table('user_finders')->where('user_id',$ids)->delete();
        $res9=Db::table('user_finder_folders')->where('user_id',$ids)->delete();
        $res10=Db::table('user_exchange_records')->where('user_id',$ids)->delete();
        $res11=Db::table('user_down_records')->where('user_id',$ids)->delete();
        $res12=Db::table('user_collects')->where('user_id',$ids)->delete();
        $res13=Db::table('user_collect_folders')->where('user_id',$ids)->delete();
        $res14=Db::table('user_attendances')->where('user_id',$ids)->delete();
        $res15=Db::table('nickname_sums')->where('user_id',$ids)->delete();
        $res15=Db::table('article_comments')->where('user_id',$ids)->delete();
        
        return response()->json([
                'status'  => true,
                'message' => trans('admin::lang.delete_succeeded'),
        ]);

    }


    protected function valid(Request $request)
    {	 
    	return Validator::make($request->all(), [
    	    'username' => 'required',
    	]);
    }
}
