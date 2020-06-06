<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class VipBuyOrder extends Model
{
	/**
	 * The attributes that aren't mass assignable.
	 *
	 * @var array
	 */
	protected $guarded = [];

	public static function dealVip($order_no,$buyer_pay_amount=null)
    {
        $order = VipBuyOrder::where('order_no', $order_no)->first();
        if (!$order) {
            return false;
        }

        $user = User::find($order->user_id);
        if (!$user) {
            return false;
        }

        $expire_time = strtotime($user->expire_time);
        $now = time();
        $left_time = $expire_time - $now;
        if ($left_time < 0) {
            $left_time = 0;
        }
        $add_time = 0;
        $point_set = 0;
        switch ($order->vip_type) {
            case '1':
                $add_time = strtotime('+1 month');
                $point_set = PointSet::find(12);
                break;
            case '2':
                $add_time = strtotime('+3 months');
                $point_set = PointSet::find(13);
                break;
            case '3':
                $add_time = strtotime('+12 months');
                $point_set = PointSet::find(14);
                break;
        }

        if ($add_time + $left_time > 0) {
            $user->expire_time = date('Y-m-d H:i:s', ($add_time + $left_time));
        }

        $user->level = $order->vip_type;
        $user->points = $user->points + $point_set->point;
        $user->left_points = $user->left_points + $point_set->point;
        $user->save();

        $point_log = [
            'user_id' => $user->id,
            'type' => '0',
            'point' => $point_set->point ?? 0,
            'remark' => $point_set->title,
        ];
        UserPoint::create($point_log);


        if($buyer_pay_amount=='94'){
            $user->left_points = $user->left_points - 50;
            $user->save();
    
            $point_log = [
                'user_id' => $user->id,
                'type' => '1',
                'point' => 50,
                'remark' => '兑换月会员抵扣',
            ];
            UserPoint::create($point_log);
        }else if($buyer_pay_amount=='260'){

            $user->left_points = $user->left_points - 280;
            $user->save();
    
            $point_log = [
                'user_id' => $user->id,
                'type' => '1',
                'point' => 280,
                'remark' => '兑换季会员抵扣',
            ];
            UserPoint::create($point_log);
        }else if($buyer_pay_amount=='911'){
 
            $user->left_points = $user->left_points - 880;
            $user->save();
    
            $point_log = [
                'user_id' => $user->id,
                'type' => '1',
                'point' => 880,
                'remark' => '兑换年会员抵扣',
            ];
            UserPoint::create($point_log);
        }







        return true;

    }
}
