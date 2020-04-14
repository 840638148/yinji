<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UserPoint extends Model
{

    protected $fillable = [
        'user_id', 'type', 'point', 'remark',
    ];
    
    public static function getPointLogs($user_id, $limit = 50)
    {
        $point_logs = self::where('user_id', $user_id)->limit($limit)->get();
        return $point_logs;
    }
    
    public static function getTodayPoint($user_id)
    {
        $today_point = [
            'today' => 0,
            'attendance' => 0,
            'like' => 0,
            'comment' => 0,
            'total' => 0,
        ];
        $today = UserPoint::where('user_id', $user_id)
            ->where('type', '0')
            ->where('created_at', '>', date('Y-m-d 00:00:00'))
            ->where('created_at', '<=', date('Y-m-d 23:59:59'))
            ->sum('point');
        $attendance = UserPoint::where('user_id', $user_id)
            ->where('type', '0')
            ->where('remark', '签到')
            ->where('created_at', '>', date('Y-m-d 00:00:00'))
            ->where('created_at', '<=', date('Y-m-d 23:59:59'))
            ->sum('point');
        $like = UserPoint::where('user_id', $user_id)
            ->where('type', '0')
            ->where('remark', '点赞')
            ->where('created_at', '>', date('Y-m-d 00:00:00'))
            ->where('created_at', '<=', date('Y-m-d 23:59:59'))
            ->sum('point');
        $comment = UserPoint::where('user_id', $user_id)
            ->where('type', '0')
            ->where('remark', '评论')
            ->where('created_at', '>', date('Y-m-d 00:00:00'))
            ->where('created_at', '<=', date('Y-m-d 23:59:59'))
            ->sum('point');
            
        $today_point['today'] = $today;
        $today_point['attendance'] = $attendance;
        $today_point['like'] = $like;
        $today_point['comment'] = $comment;
        $today_point['total'] = 10 + 20 + UserAttendance::getPoint(UserAttendance::getLastDays($user_id));
        return $today_point;
    }
    
}
