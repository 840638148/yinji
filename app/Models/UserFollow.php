<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class UserFollow extends Model
{
    protected $fillable = [
        'user_id', 'follow_id',
    ];


    /**
     * 关注用户
     * @param $follow_id
     * @return bool
     */
    public static function followByUserId($follow_id)
    {
        $user_id = Auth::id();
        
        if (empty($follow_id) || empty($user_id)) {
            return false;
        }
        $obj = self::where('user_id', $user_id)
            ->where('follow_id', $follow_id)
            ->first();

        if ($obj){
            return true;
        } else {
            $data = [
                'user_id' => Auth::id(),
                'follow_id' => $follow_id,
            ];
            self::create($data);
        }
        return true;
    }

    /**
     * 取消关注用户
     * @param $follow_id
     * @return bool
     */
    public static function cancelFollowByUserId($follow_id)
    {
        $user_id = Auth::id();
        if (empty($follow_id) || empty($user_id)) {
            return false;
        }
        $obj = self::where('user_id', $user_id)
            ->where('follow_id', $follow_id)
            ->first();

        if ($obj){
            $obj->delete();
            return true;
        } else {
            return false;
        }
    }


    /**
     *
     * @param $user_id
     * @return string
     */
    public static function getFollows($user_id)
    {
    	
        $user = User::find($user_id);
        if (!$user) {
            return '用户不存在';
        }

        $user_follows = self::where('user_id', $user_id)->get();

        $follow_ids = [];
        foreach ($user_follows as $user_follow) {
            $follow_ids[] = $user_follow->follow_id;
        }

        $users = User::whereIn('id', $follow_ids)->get();
        foreach ($users as & $user) {
            $user->is_vip = User::isVip($user->id);
            $user->collect_num = User::getCollectNum($user->id);
            $user->fans_num = User::getFansNum($user->id);
        }
// dd($user_follows);
        return $users;


    }

}
