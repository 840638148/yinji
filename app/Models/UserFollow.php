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
        $is_vip = User::isVip($user_id);
        if (empty($follow_id) || empty($user_id)) {
            return false;
        }else if($is_vip){
            $obj = self::where('user_id', $user_id)
            ->where('follow_id', $follow_id)
            ->first();

            if($obj){
                return true;
            } else {
                $data = [
                    'user_id' => Auth::id(),
                    'follow_id' => $follow_id,
                ];
                self::create($data);
            }
            return true;
        }else{
            return false;
        }
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
     * 我的关注
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

        //去除自己
        $user_follows = $user_follows->reject(function ($val) use ($user_id) {
            return $val->follow_id == $user_id;
        });

        $follow_ids = [];
        foreach ($user_follows as $user_follow) {
            $follow_ids[] = $user_follow->follow_id;
        }

        $users = User::whereIn('id', $follow_ids)->get();
        foreach ($users as & $user) {
            $user->is_vip = User::isVip($user->id);
            $user->collect_num = User::getCollectNum($user->id);
            $user->fans_num = User::getFansNum($user->id);
            $user->vip_level = User::getVipLevel($user->id);
            $user->city=explode('-',$user->city);
            
            if(isset($user->city[0]) && isset($user->city[1])){
                if($user->city[1]=='市辖区' || $user->city[1]=='县'){
                    $user->city=$user->city[0];
                }else{
                    $user->city=$user->city[1];
                }
            }else
            if(isset($user->city[0]) && isset($user->city[1])){
                $user->city=$user->city[1];
            }else{
                $user->city='保密';
            }
        }
        // dd($users);
        return $users;
    }

    /**
     * 我的粉丝
     */
    public static function getFans($user_id){
        $user = User::find($user_id);
        if (!$user) {
            return '用户不存在';
        }
        $user_follows = self::where('follow_id', $user_id)->get();
        $user_follows = $user_follows->reject(function ($val) use ($user_id) {
            return $val->user_id == $user_id;
        });
        
        $follow_ids = [];
        foreach ($user_follows as $user_follow) {
            $follow_ids[] = $user_follow->user_id;
        }
        $users=User::whereIn('id', $follow_ids)->get();
        foreach ($users as & $user) {
            $user->is_vip = User::isVip($user->id);
            $user->collect_num = User::getCollectNum($user->id);
            $user->fans_num = User::getFansNum($user->id);
            $user->vip_level = User::getVipLevel($user->id);
            $user->city=explode('-',$user->city);
            
            if(isset($user->city[0]) && isset($user->city[1])){
                if($user->city[1]=='市辖区' || $user->city[1]=='县'){
                    $user->city=$user->city[0];
                }else{
                    $user->city=$user->city[1];
                }
            }else
            if(isset($user->city[0]) && isset($user->city[1])){
                $user->city=$user->city[1];
            }else{
                $user->city='保密';
            }
        }
        return $users;
    }

}
