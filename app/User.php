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
use App\Models\NicknameSum;
use App\Models\ViewNum;
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
        'username', 'nickname', 'email', 'password', 'mobile', 'avatar', 'sex', 'city', 'wx', 'personal_note', 'level','zhiwei',
        'expire_time', 'points', 'left_points', 'friends', 'follower', 'register_key', 'last_login_time', 'last_login_ip', 'last_session_id', 'continuity_day','nicksum','one_visited','leiji_freesum','leiji_dhsum'
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
     * 获取vip等级的价钱
     */
    public static function getVipPrice($user_id)
    {
        $options = self::leftjoin('vip_prices','users.level','=','vip_prices.id')->select('vip_prices.price')->where('users.id',$user_id)->where('expire_time', '>', date('Y-m-d H:i:s'))->first();
        return $options;
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
        // $freenum=self::getFreeDownloadNum($user_id);
        // $kounum=self::getKouDownloadNum($user_id);
        $freenum=self::getFreeSum($user_id);
        $kounum=self::getKouSum($user_id);

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
                $freenum = 8;
            } else if ($user->level == 3) {
                $freenum = 10;
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
                $kounum = 8;
            } else if ($user->level == 4) {
                $kounum = 50;
            } else if ($user->level == 5) {
                $kounum = 88;
            }
        }else{
            $kounum = 1;
        } 
        return $kounum;
    }

    // 获取当前所在的星期一和星期天
    public static function mondayTime(){
        $date=new \DateTime();//时间对象
        $starts=$date->modify('this week');
        $start=$date->format('Y-m-d');

        $end_times=$date->modify('this week +6 days');
        $end_time=$date->format('Y-m-d');
        return ['start'=>$start,'end'=>$end_time];
    }
    
    /**
     * 获取用户当天剩余免费下载次数
     */
    public static function getFreeSum($user_id = null)
    {  
        $num=0;
        if (empty($user_id)) {
            return $num;
        }
        $user = User::find($user_id);
        $freedown=self::getFreeDownloadNum($user_id);
        $hasdown=self::getUseDownloadNum($user_id,1);
        if($user && $freedown-$hasdown>0){
            $num=$freedown-$hasdown;
        }else{
            $num=0;
        }

        $last_downrecord=UserDownRecord::where('user_id',$user_id)->orderby('created_at','desc')->value('created_at');
        $res=0;
        $times=date('Y-m-d',strtotime($last_downrecord)); //获取上次下载时间
        if($times<date('Y-m-d')){
            //如果上次下载时间小于今天，那么计算上次下载时间距离今天时间有多少天
            $res=round((strtotime(date('Y-m-d',time()))-strtotime($times))/3600/24);
            
        }
        $nums=$num+$res*$freedown;
        // dd($freedown,$hasdown,$nums);
        
        // $user->leiji_freesum=$num;
        // $user->save();
        return $nums;
    }

    /**
     * 获取用户当天剩余抵扣下载次数
     */
    public static function getKouSum($user_id = null)
    {  
        $num=0;
        if (empty($user_id)) {
            return $num;
        }
        $user = User::find($user_id);
        $koudown=self::getKouDownloadNum($user_id);
        $hasdown=self::getUseDownloadNum($user_id,2);
        if($user && $koudown-$hasdown>0){
            $num=$koudown-$hasdown;
        }else{
            $num=0;
        }


        $last_downrecord=UserDownRecord::where('user_id',$user_id)->orderby('created_at','desc')->value('created_at');
        $res=0;
        $times=date('Y-m-d',strtotime($last_downrecord)); //获取上次下载时间
        if($times<date('Y-m-d')){
            //如果上次下载时间小于今天，那么计算上次下载时间距离今天时间有多少天
            $res=round((strtotime(date('Y-m-d',time()))-strtotime($times))/3600/24);
            
        }
        $nums=$num+$res*$koudown;

        // dd($koudown,$hasdown,$num,$nums);
        // $user->leiji_dhsum=$num;
        // $user->save();
        return $nums;
    }




    /**
     *  获取用户已用下载次数
     *
     * @param null $user_id
     * @return bool
     */
    public static function getUseDownloadNum($user_id = null,$is_free=null)
    {   
        if(date('Y-m-d')<='2020-09-07'){
            $today_start = date('Y-m-d 00:00:00');
        }else{
            $today_start = date('Y-m-d 00:00:00',strtotime('-7 days'));
        }

        if($today_start<='2020-09-07'){
            $today_start='2020-09-07 00:00:00';
        }
        
        $today_end   = date('Y-m-d 23:59:59');
        if($is_free){
            return UserDownRecord::where('user_id', $user_id)
                ->where('is_free',$is_free)
                ->where('created_at', '>=', $today_start)
                ->where('created_at', '<', $today_end)
                ->count();
        }else{
            return UserDownRecord::where('user_id', $user_id)
            ->where('created_at', '>=', $today_start)
            ->where('created_at', '<', $today_end)
            ->count();
        }
    }
    

    /**
     *  获取用户剩余总下载次数
     *
     * @param null $user_id
     * @return bool
     */
    /*public static function getLeftDownloadNum($user_id = null)
    {
        $total   = self::getDownloadNum($user_id);
        $use_num = self::getUseDownloadNum($user_id);
        $user=User::find($user_id);
        return $total - $use_num+$user->leiji_freesum;
    }*/
    

    /**
     *  获取用户已兑换次数
     *
     * @param null $user_id
     * @return bool
     */
    /*public static function getUseExchangeNum($user_id = null)
    {
        if(date('Y-m-d')<='2020-09-07'){
            $today_start = date('Y-m-d 00:00:00');
        }else{
            $today_start = date('Y-m-d 00:00:00',strtotime('-7 days'));
        }

        if($today_start<='2020-09-07'){
            $today_start='2020-09-07 00:00:00';
        }
        $today_end   = date('Y-m-d 23:59:59');
        return UserExchangeRecord::where('user_id', $user_id)
            ->where('created_at', '>=', $today_start)
            ->where('created_at', '<', $today_end)
            ->count();
    }*/
    
    
    /**
     *  获取用户当前可以兑换的下载次数
     *
     * @param null $user_id
     * @return bool
     */
    /*public static function getLeftExchangeNum($user_id = null)
    {
        $use_num = self::getUseExchangeNum($user_id);
        
        $user = User::find($user_id);
        $num = 0;
        $is_vip = self::isVip($user_id);
        if ($is_vip && $user) {
            if ($user->level == 0) {
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
        
    }*/


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
        
        // if (!empty($edit_info['username']) && self::isExistsByName($user['username'], [['id', '!=', $user_id]])) {
        //     return '用户名已经存在';
        // }
        
        $has_mobile=self::where('mobile',$edit_info['mobile'])->value('mobile');
        if($edit_info['code_tel']){
            if (!empty($edit_info['mobile']) && $has_mobile==$edit_info['mobile']) {
                return '手机号已经存在';
            }
        }

        $info=[];
        $fields = ['nickname','email','mobile','password','one_tel','one_email','sex','city','zhiwei','personal_note',];
        
        
        foreach ($fields as $field) {
            if (isset($edit_info[$field]) && !empty($edit_info[$field])){
                $info[$field] = $edit_info[$field];
            }
        }
        // dd($edit_info);
        if(@$info['nickname']){
            $data=[
                'nname_be'=>$user->nickname,
                'nname_af'=>$info['nickname'],
                'year'=>date('Y'),
                'user_id'=>Auth::id()
            ];
            NicknameSum::create($data);
            
        }
        if($info){
            User::where('id',Auth::id())->update($info);
        }

        if(@$info['one_tel']){
            if($info['one_tel']==2){
                $point_log = [
                    'user_id' => $user->id,
                    'type' => '0',
                    'point' => 10,
                    'remark' => '首绑手机',
                ];
                UserPoint::create($point_log);
            }
        }
        if(@$info['one_email']){
            if($info['one_email']==2){
                $point_log = [
                    'user_id' => $user->id,
                    'type' => '0',
                    'point' => 10,
                    'remark' => '首绑邮箱',
                ];
                UserPoint::create($point_log);
            }
        }
        $user->points = $user->points + 10;
        $user->left_points = $user->left_points + 10;
        $user->save();

        return true;
    }

    /**
     * 获取用户每年修改昵称的次数
     */
    public static function getEditNicknameNum($user_id){
        $is_vip = self::isVip($user_id);
        $user = User::find($user_id);
        $num=0;
        if($is_vip && $user){
            if($user->level==1){
                $num=1;
            }else if($user->level==2){
                $num=3;
            }else if($user->level==3){
                $num=5;
            }
        }else{
            $num=0;
        } 
        return $num;
    }

    /**
     * 获取用户每年修改昵称的记录
     */
    public static function getNickRecord($user_id){
        return NicknameSum::Where('year',date('Y'))->where('user_id',$user_id)->count();
    }

    /**
     * 获取用户每年剩下的修改昵称次数
     */
    public static function getNickSum($user_id){
        $num=0;
        $is_vip = self::isVip($user_id);
        $nickrecord=self::getNickRecord($user_id);
        $nicksum=self::getEditNicknameNum($user_id);
        $user = User::find($user_id);
        $sum=$nicksum-$nickrecord;
        $year=date('Y');
        // dd($sum);
        if($sum>0){
            $num=$sum;
        }else{
            $num=0;
        }
        return $num;
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
        $num=UserFollow::where('user_id', $user_id)->get();
        $num = $num->reject(function ($value) use ($user_id) {
            return $value->follow_id == $user_id;
        });
        return $num->count();
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

    /**
     * 获取个人主页人气
     */
    public static function getViewNum($user_id)
    {
        return ViewNum::where('visited_id', $user_id)->count();
    }

}
