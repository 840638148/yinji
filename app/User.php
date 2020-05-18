<?php

namespace App;

use App\Models\UserCollect;
use App\Models\UserFollow;
use App\Models\UserPoint;
use App\Models\UserSubscription;
use App\Models\UserDownRecord;
use App\Models\UserExchangeRecord;
use App\Models\PointSet;
use App\Models\UserCollectFolder;
use App\Models\UserFinder;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'nickname', 'email', 'password', 'mobile', 'avatar', 'sex', 'city', 'wx', 'personal_note', 'level',
        'expire_time', 'points', 'left_points', 'friends', 'follower', 'register_key', 'last_login_time', 'last_login_ip', 'last_session_id', 'continuity_day'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     *  检查是否VIP
     * 
     * @param null $user_id
     * @return bool
     */
    public static function isVip($user_id = null)
    {
        if (empty($user_id)) {
            $user_id = Auth::id();
        }
        
        $user = User::find($user_id);
        // dd($user);
        if ($user && $user->expire_time && $user->expire_time >= date('Y-m-d')) {
            return true;
        }
        return false;
    }

    /**
     *  获取VIP等级
     *
     * @param null $user_id
     * @return bool
     */
    public static function getVipLevel($user_id = null)
    {
        if (empty($user_id)) {
            $user_id = Auth::id();
        }
        $user = User::find($user_id);
        // dd($user);
        // $level = 0;
        $level = '/images/v_0.png';
        if ($user->level !=0 && $user->expire_time >= date('Y-m-d')) {
            if ($user->points >= 99999) {
                // $level = 7;
                $level = '/images/v_7.png';
            } else if ($user->points >= 60000) {
                // $level = 6;
                $level = '/images/v_6.png';
            } else if ($user->points >= 36666) {
                // $level = 5;
                $level = '/images/v_5.png';
            } else if ($user->points >= 18888) {
                // $level = 4;
                $level = '/images/v_4.png';
            } else if ($user->points >= 6666) {
                // $level = 3;
                $level = '/images/v_3.png';
            } else if ($user->points >= 1888) {
                // $level = 2;
                $level = '/images/v_2.png';
            } else if ($user->points >= 0) {
                // $level = 1;
                $level = '/images/v_1.png';
            }
        }else{
            // $level = 0;
            $level = '/images/v_0.png';
        }
        return $level;
    }
    


    /**
     *  获取用户总共可用下载次数
     *
     * @param null $user_id
     * @return bool
     */
    public static function getDownloadNum($user_id = null)
    {
        $num = 0;
        
        if (empty($user_id)) {
            return $num;
        }
        $user = User::find($user_id);
        $freenum=self::getFreeDownloadNum($user_id);
        $kounum=self::getKouDownloadNum($user_id);
        $num = 0;
        // $is_vip = self::isVip($user_id);
        if ($user) {
            if ($user->level == 0) {
                $num = $freenum+$kounum;
            } else if ($user->level == 1) {
                $num = $freenum+$kounum;
            } else if ($user->level == 2) {
                $num = $freenum+$kounum;
            } else if ($user->level == 3) {
                $num = $freenum+$kounum;
            } else if ($user->level == 4) {
                $num = $freenum+$kounum;
            } else if ($user->level == 5) {
                $num = $freenum+$kounum;
            }
        }
        return $num;
    }
    
    /**
     * 用户免费下载次数
     * @param null $user_id
     */
    public static function getFreeDownloadNum($user_id = null)
    {
        $freenum = 0;
        
        if (empty($user_id)) {
            return $freenum;
        }
        $user = User::find($user_id);
        $is_vip = self::isVip($user_id);
        if ($user && $is_vip) {
            if ($user->level == 1) {
                $freenum = 5;
            } else if ($user->level == 2) {
                $freenum = 10;
            } else if ($user->level == 3) {
                $freenum = 15;
            } else if ($user->level == 4) {
                $freenum = 50;
            } else if ($user->level == 5) {
                $freenum = 88;
            }
        }else{
            $freenum = 0;
        }
        return $freenum;
    }


    
    /**
     * 用户使用印币抵扣下载次数
     * @param null $user_id
     */
    public static function getKouDownloadNum($user_id = null)
    {   
        $kounum = 0;
        if (empty($user_id)) {
            return $kounum;
        }
        $user = User::find($user_id);
        $is_vip = self::isVip($user_id);
        if ($user && $is_vip) {
            if ($user->level == 1) {
                $kounum = 3;
            } else if ($user->level == 2) {
                $kounum = 5;
            } else if ($user->level == 3) {
                $kounum = 10;
            } else if ($user->level == 4) {
                $kounum = 50;
            } else if ($user->level == 5) {
                $kounum = 88;
            }
        }else{
            $kounum = 1;
        } 
        
        // dd($kounum);
        return $kounum;
    }

    /**
     * 获取用户剩余免费下载次数
     */
    public static function getFreeSum($user_id = null)
    {  
        $num=0;
        if (empty($user_id)) {
            return $num;
        }
        $user = User::find($user_id);
        $is_vip = self::isVip($user_id);
        $today_start = date('Y-m-d 00:00:00');
        $today_end   = date('Y-m-d 23:59:59');
        $freedown=self::getFreeDownloadNum($user_id);
        $hasdown=UserDownRecord::where('user_id',$user_id)->where('is_free',1)->where('created_at', '>=', $today_start)->where('created_at', '<', $today_end)->count();
        
        if($freedown-$hasdown>0){
            $num=$freedown-$hasdown;
        }else{
            $num=0;
        }
        return $num;
    }

    /**
     * 获取用户剩余抵扣下载次数
     */
    public static function getKouSum($user_id = null)
    {  
        $num=0;
        if (empty($user_id)) {
            return $num;
        }
        $user = User::find($user_id);
        $is_vip = self::isVip($user_id);
        $today_start = date('Y-m-d 00:00:00');
        $today_end   = date('Y-m-d 23:59:59');
        $koudown=self::getKouDownloadNum($user_id);
        $hasdown=UserDownRecord::where('user_id',$user_id)->where('is_free',2)->where('created_at', '>=', $today_start)->where('created_at', '<', $today_end)->count();
        if($koudown-$hasdown>0){
            $num=$koudown-$hasdown;
        }else{
            $num=0;
        }
        return $num;
    }




    /**
     *  获取用户已用下载次数
     *
     * @param null $user_id
     * @return bool
     */
    public static function getUseDownloadNum($user_id = null)
    {
        $today_start = date('Y-m-d 00:00:00');
        $today_end   = date('Y-m-d 23:59:59');
        return UserDownRecord::where('user_id', $user_id)
            ->where('created_at', '>=', $today_start)
            ->where('created_at', '<', $today_end)
            ->count();
    }
    

    /**
     *  获取用户剩余下载次数
     *
     * @param null $user_id
     * @return bool
     */
    public static function getLeftDownloadNum($user_id = null)
    {
        $total   = self::getDownloadNum($user_id);
        $use_num = self::getUseDownloadNum($user_id);
        // dd($total,$use_num);
        return $total - $use_num;
    }
    

    /**
     *  获取用户已兑换次数
     *
     * @param null $user_id
     * @return bool
     */
    public static function getUseExchangeNum($user_id = null)
    {
        $today_start = date('Y-m-d 00:00:00');
        $today_end   = date('Y-m-d 23:59:59');
        return UserExchangeRecord::where('user_id', $user_id)
            ->where('created_at', '>=', $today_start)
            ->where('created_at', '<', $today_end)
            ->count();
    }
    
    
    /**
     *  获取用户当前可以兑换的下载次数
     *
     * @param null $user_id
     * @return bool
     */
    public static function getLeftExchangeNum($user_id = null)
    {
        $use_num = self::getUseExchangeNum($user_id);
        
        $user = User::find($user_id);
        $num = 0;
        $is_vip = self::isVip($user_id);
        if ($is_vip && $user) {
            if ($user->level == 0) {
                $point_set = PointSet::find(15);
                $num = $point_set->point;
            } else if ($user->level == 1) {
                $point_set = PointSet::find(16);
                $num = $point_set->point;
            } else if ($user->level == 2) {
                $point_set = PointSet::find(17);
                $num = $point_set->point;
            } else if ($user->level == 3) {
                $point_set = PointSet::find(18);
                $num = $point_set->point;
            } else if ($user->level == 4) {
                $num = 50;
            } else if ($user->level == 5) {
                $num = 88;
            }
        }
        
        return $num - $use_num;
        
    }


    /**
     * 检查用户名是否存在
     * @param $username
     * @return boolean
     */
    public static function isExistsByName($username, $where = null)
    {
        $obj = self::where('username', $username)->orWhere('mobile', $username);
        if ($where) {
            $obj->where($where);
        }
        if ($obj->count() > 0) {
            return true;
        }
        return false;
    }


    /**
     * 检查手机号是否存在
     * @param $mobile
     * @param $where
     * @return boolean
     */
    public static function isExistsByMobile($mobile, $where = null)
    {
        $obj = self::where('mobile', $mobile)->orWhere('username', $mobile);
        if ($where) {
            $obj->where($where);
        }
        if ($obj->count() > 0) {
            return true;
        }
        return false;
    }

    /**
     * 创建用户
     *
     * @param $user
     * @return bool|string
     */
    public static function createUser($user, $return_obj = false)
    {
        if (!empty($user['name']) && self::isExistsByName($user['name'])) {
            return '用户名已经存在';
        }

        if (!empty($user['mobile']) && self::isExistsByMobile($user['mobile'])) {
            return '手机号已经存在';
        }
        $point_set = PointSet::find(11);
        $user['points'] = $point_set->point ?? 0;
        $user['left_points'] = $point_set->point ?? 0;
        $ret = self::create($user);

        if ($ret) {
            $point_log = [
                'user_id' => $ret->id,
                'type' => '0',
                'point' => $point_set->point ?? 0,
                'remark' => '注册',
            ];
            UserPoint::create($point_log);
            if ($return_obj) {
                return $ret;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
    
    /**
     * 编辑用户
     *
     * @param $user
     * @return bool|string
     */
    public static function editUser($user_id, $edit_info = [])
    {
        $user = self::find($user_id);
        if (!$user) {
            return '用户不存在';
        }
        
        if (!empty($edit_info['username']) && self::isExistsByName($user['username'], [['id', '!=', $user_id]])) {
            return '用户名已经存在';
        }

        if (!empty($edit_info['mobile']) && self::isExistsByMobile($user['mobile'], [['id', '!=', $user_id]])) {
            return '手机号已经存在';
        }
        
        foreach ($edit_info as $k => $v) {
            $user->$k = $v;
        }
        $user->save();
        return true;
    }


    /**
     * 获得收藏数量
     *UserCollect
     * @param $user_id
     * @return mixed
     */
    public static function getCollectNum($user_id)
    {
        // return UserCollectFolder::where('user_id', $user_id)->count();
        return UserCollect::where('user_id', $user_id)->count();
    }

    /**
     * 获得发现数量
     * UserFinder
     * @param $user_id
     * @return mixed
     */
    public static function getFinderNum($user_id)
    {
        // return UserCollectFolder::where('user_id', $user_id)->count();
        return UserFinder::where('user_id', $user_id)->count();
    }


    /**
     * 获得粉丝数量
     *
     * @param $user_id
     * @return mixed
     */
    public static function getFansNum($user_id)
    {
        return UserFollow::where('follow_id', $user_id)->count();
    }


    /**
     * 获得关注数量
     *
     * @param $user_id
     * @return mixed
     */
    public static function getFollowNum($user_id)
    {
        return UserFollow::where('user_id', $user_id)->count()-1;
    }

    /**
     * 获得订阅数量
     *
     * @param $user_id
     * @return mixed
     */
    public static function getSubscriptionNum($user_id)
    {
        return UserSubscription::where('user_id', $user_id)->count();
    }
}
