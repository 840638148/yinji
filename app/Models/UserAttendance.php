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
        $user = User::find($user_id);
        if ($user) {
            
            $user->points = $user->points + $point;
            $user->left_points = $user->left_points + $point;
            $user->continuity_day = $last_days + 1;
            $user->save();

            $point_data = [
                'user_id' => $user_id,
                'type' => '0',
                'point' => $point,
                'remark' => '签到',
            ];
            UserPoint::create($point_data);
            
            $data = [
                'user_id' => $user_id,
                'point' => $point,
            ];
            self::create($data);
        }
        return true;
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
        if ($last_days <= 5) {
            $id = 1;
        } else if ($last_days <= 30) {
            $id = 2;
        } else {
            $id = 3;
        }
        $point_set = PointSet::find($id);
        $point = $point_set->point;

        $last_id = null;
        if (5 == $last_days) {
            $last_id = 4;
        }
        if (10 == $last_days) {
            $last_id = 5;
        }
        if (20 == $last_days) {
            $last_id = 6;
        }
        if (30 == $last_days) {
            $last_id = 7;
        }
        if ($last_days > 30 && (0 == ($last_days % 15))) {
            $last_id = 8;
        }

        if ($last_id) {
            $point_last = PointSet::find($last_id);
            if ($point_last) {
                $point += $point_last->point;
            }
        }


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
        if ($attendance) {
            $user = User::find($user_id);
            if ($user) {
                $last_days = $user->continuity_day;
            }
        }

        //var_dump($last_days);
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
        
        $last_days = self::getLastDays($user_id);
        $tips = [];
        for ($i = 0; $i < 7; $i++) {
            $tips[] = [
                'title' => '第' . ($last_days + $i) . '天',
                'point' => self::getPoint($last_days + $i - 1),
            ];
        }
        return $tips;
    }
    
    
}
