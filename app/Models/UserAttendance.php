<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class UserAttendance extends Model
{

    protected $fillable = [
        'user_id', 'point'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function attendance()
    {
        $user_id = Auth::id();
        if (!$user_id) {
            return '请先登录！';
        }

        $today_start = date('Y-m-d 00:00:00');
        $today_end   = date('Y-m-d 23:59:59');
        $attendance = UserAttendance::where('user_id', $user_id)
            ->where('created_at', '>=', $today_start)
            ->where('created_at', '<=', $today_end)
            ->first();
        if ($attendance) {
            return '您今天已经签到过了！';
        }

        $last_days = self::getLastDays($user_id);
        $point = self::getPoint($last_days);
        $points=0;
        $po=0;
        // dd($point);
        $user = User::find($user_id);
        $is_vip=User::isVip($user_id);
        if ($user) {
            
            if($is_vip){
                $viplevel=User::getVipLevel($user->id);
                if($viplevel=='/images/v_1.png'){
                    $points=2;
                }else if($viplevel=='/images/v_2.png'){
                    $points=4;
                }else if($viplevel=='/images/v_3.png'){
                    $points=6;
                }else if($viplevel=='/images/v_4.png'){
                    $points=8;
                }else if($viplevel=='/images/v_5.png'){
                    $points=10;
                }else if($viplevel=='/images/v_6.png'){
                    $points=13;
                }else if($viplevel=='/images/v_7.png'){
                    $points=16;
                }else if($viplevel=='/images/v_8.png'){
                    $points=20;
                }else{
                    $points=0;
                }

                if($user->level==1){
                    $po=5;
                }else if($user->level==2){
                    $po=10;
                }else if($user->level==3){
                    $po=15;
                }else{
                    $po=0;
                }
        
                $user->points = $user->points + $point+$po+$points;
                $user->left_points = $user->left_points + $point+$po+$points;
                $user->continuity_day = $last_days + 1;
                $user->save();

                $point_data = [
                    'user_id' => $user_id,
                    'type' => '0',
                    'point' => $point+$po+$points,
                    'remark' => '签到',
                ]; 

                UserPoint::create($point_data);
                $data = [
                    'user_id' => $user_id,
                    'point' => $point+$po+$points,
                ];
                self::create($data);
            }else{
                $user->points = $user->points + $point+$po+$points;
                $user->left_points = $user->left_points + $point+$po+$points;
                $user->continuity_day = $last_days + 1;
                $user->save();
                $point_data = [
                    'user_id' => $user_id,
                    'type' => '0',
                    'point' => $point+$po+$points,
                    'remark' => '签到',
                ];
                UserPoint::create($point_data);
                $data = [
                    'user_id' => $user_id,
                    'point' => $point+$po+$points,
                ];
                self::create($data);
            }
            $re=['res'=>true,'qdyb'=>$point+$po+$points,];
           return $re;
        }else{
            $re=['res'=>false,'qdyb'=>$point+$po+$points,];
            return $re;
        }
        
    }


    /**
     * 获取当前签到可以得到多少积分
     *
     * @param $last_days
     * @return int
     */
    public static function getPoint($last_days)
    {
        $last_days ++; //这是已经签到的天数，不包括当前这次签到，所以加1
        if ($last_days < 5) {
            $id = 1;
        }else if($last_days == 5){
            $id = 2 ;
        }else if ($last_days < 15) {
            $id = 3;
        }else if ($last_days == 15) {
            $id = 4;
        }else if ($last_days < 30) {
            $id = 5;
        }else if ($last_days == 30) {
            $id = 6;
        }else if ($last_days < 45) {
            $id = 7;
        }else if ($last_days = 45) {
            $id = 8;
        }else if ($last_days > 45) {
            $id = 9;
        }
  
        $point_set = PointSet::find($id);
        $point = $point_set->point;

        return $point;
    }


    /**
     * 获取已经连续签到天数
     *
     * @param $user_id
     * @return int
     */
    public static function getLastDays($user_id)
    {
        $last_days = 0;
        //确定昨天是否有签到
        $today_start = date('Y-m-d 00:00:00', strtotime('-1 day'));
        $today_end   = date('Y-m-d 23:59:59');
        $attendance = UserAttendance::where('user_id', $user_id)
            ->where('created_at', '>=', $today_start)
            ->where('created_at', '<=', $today_end)
            ->first(); 
        $user = User::find($user_id);
        if ($attendance && $user) {
            $last_days = $user->continuity_day;
        }else{
            $last_days = 0;
        }

        // dd($last_days);
        return $last_days;
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public static function getAttendanceLog($limit = 5)
    {
        $attendances = UserAttendance::orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
        foreach ($attendances as & $attendance) {
            $attendance->vip_level = User::getVipLevel($attendance->user_id);
        }
        return $attendances;
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public static function getAttendanceTips()
    {
        $user_id = Auth::id();
        if (!$user_id) {
            return '请先登录！';
        }
        $is_vip= User::isVip($user_id);
        $user=User::find($user_id);
        $vip_level=User::getVipLevel($user_id);
        $point=0;
        $points=0;

        if($is_vip){
            if($user->level==1){
                $point=5;
            }else if($user->level==2){
                $point=10;
            }else if($user->level==3){
                $point=15;
            }

            if($vip_level=='/images/v_1.png'){
                $points=2;
            }else if($vip_level=='/images/v_2.png'){
                $points=4;
            }else if($vip_level=='/images/v_3.png'){
                $points=6;
            }else if($vip_level=='/images/v_4.png'){
                $points=8;
            }else if($vip_level=='/images/v_5.png'){
                $points=10;
            }else if($vip_level=='/images/v_6.png'){
                $points=13;
            }else if($vip_level=='/images/v_7.png'){
                $points=16;
            }else if($vip_level=='/images/v_8.png'){
                $points=20;
            }
        }else{
            $point=0;
            $points=0;
        }

        $last_days = self::getLastDays($user_id);
        $tips = [];
        for ($i = 0; $i < 7; $i++) {
            $tips[] = [
                'title' => '第' . ($last_days + $i) . '天',
                'point' => self::getPoint($last_days + $i - 1)+$points+$point,
            ];
        }
        // dd($tips,$points,$point);
        return $tips;
    }
    
    
}
