<?php

namespace App\Admin\Controllers;

use App\Admin\Controllers\BaseController;

use App\user;
use Encore\Admin\Grid\Exporters\ExcelExporter;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExcelController extends BaseController 
{
    protected $fileName = '用户列表.xlsx';

    protected $columns = [
        'id'                    => 'ID',
        'username'              => '用户名',
        'nickname'              => '昵称',
        'avatar'                => '头像',
        'mobile'                => '手机号',
        'email'                 => '邮箱',
        'points'                => '积分',
        'last_login_time'       => '上次登录时间',
        'create_at'             => '创建时间',
    ];


    public function map($user): array
    {	//这里是字段的值 如果是主表的数据 直接对象的形式就可以写出来
        //如果是关联的表的数据 可以通过data_get()去渲染
        //其他部分是枚举类字段值的语义化 
        return [
            $user->id,
            $user->username,
            $user->nickname,            
            $user->avatar,
            $user->mobile,
            $user->email,
            $user->points,
            $user->last_login_time,
            $user->create_at
        ];
    }

}
