<?php

namespace App\Models;
use App\User;
use Illuminate\Database\Eloquent\Model;


class UserPoint extends Model
{

    protected $fillable = [
        'user_id', 'type', 'point', 'remark',
    ];
    
    public static function getPointLogs($user_id, $limit = 50)
    {
        $point_logs = self::where('user_id', $user_id)->orderby('created_at','desc')->limit($limit)->get();
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
            'faxian' => 0,
            'pingfen' => 0,
        ];
        $user = User::find($user_id);
        $res=UserPoint::where('user_id', $user_id)->where('type', '0')
            ->where('created_at', '>=', date('Y-m-d 00:00:00'))
            ->where('created_at', '<', date('Y-m-d 23:59:59'))
            ->get();
        
        $today = $res->sum('point');

        $attendance = $res->where('remark', '签到')->sum('point');

        $pingfen = $res->where('remark', '评分')->sum('point');

        $comment = $res->where('remark', '评论')->sum('point');

        $faxian = $res->where('remark', '发现')->sum('point');

        $like = $res->where('remark', '点赞')->sum('point');
            
        $today_point['today'] = $today;
        $today_point['attendance'] = $attendance;
        $today_point['pingfen'] = $pingfen;
        $today_point['comment'] = $comment;
        $today_point['like'] = $like;
        $today_point['faxian'] = $faxian;
        $today_point['total'] = 10 + 20 + UserAttendance::getPoint(UserAttendance::getLastDays($user_id));
        return $today_point;
    }
    
}
