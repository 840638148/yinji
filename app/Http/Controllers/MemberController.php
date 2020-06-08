<?php

namespace App\Http\Controllers;

use App\Models\ArticleComment;
use App\Models\DesignerComment;
use App\Models\NewsComment;
use App\Models\UserAttendance;
use App\Models\UserCollect;
use App\Models\UserCollectFolder;
use App\Models\UserFinder;
use App\Models\UserFinderFolder;
use App\Models\UserFollow;
use App\Models\UserSubscription;
use App\Models\UserPoint;
use App\Models\UserDownRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use SmsManager;
use App\Http\Error;
use App\Http\Output;
use App\User;
use App\Models\VipPrice;
use App\Models\Article;
use App\Models\ViewNum;
use App\Models\HomepageMessage;
use Carbon\Carbon;
// use Mail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use DB;
use App\Models\UserThird;
class MemberController extends Controller
{
   
    public function index(Request $request)
    {
        $this->checkLogin();

        $lang = $request->session()->get('language') ?? 'zh-CN';

        $user = $this->getUserInfo();
        $user->follows = UserFollow::getFollows($user->id);
        $user->subscriptions = UserSubscription::getSubscriptions($user->id);
        $user->collects = UserCollect::getCollects($user->id);
        $user->finders = UserFinder::getFinders($user->id);
        $attendances = UserAttendance::getAttendanceLog();
        $last_days = UserAttendance::getLastDays($user->id);
        $tips = UserAttendance::getAttendanceTips();

        $today_start = date('Y-m-d 00:00:00');
        $today_end   = date('Y-m-d 23:59:59');
        $is_qiandao = UserAttendance::where('user_id', $user->id)->where('created_at', '>=', $today_start)->where('created_at', '<=', $today_end)->first();

        $data = [
            'lang' => $lang,
            'user' => $user,
            'attendances' => $attendances,
            'last_days' => $last_days,
            'tips' => $tips,
            'is_qiandao' => $is_qiandao,
        ];
        return view('member.index', $data);
    }

    /**
     * 个人资料
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile(Request $request)
    {
        $this->checkLogin();

        $lang = $request->session()->get('language') ?? 'zh-CN';

        $user = $this->getUserInfo();
        $user->is_wxbd=UserThird::leftjoin('users','users.id','=','user_thirds.user_id')->select('users.id','user_thirds.unique_id','users.username')->where('user_thirds.user_id',$user->id)->where('user_thirds.unique_id',$user->username)->orwhere('users.username','like','%ohPM_%')->first();
        if($user->city){
            $user->city=explode('-',$user->city);
            $province=Db::table("province")->where('province_name',$user->city[0])->value('province_num');
            $city=Db::table("city")->where('city_name',$user->city[1])->value('city_num');      
            $data = [
                'lang' => $lang,
                'user' => $user,
                'province' => $province,
                'city' => $city,
            ];
            return view('member.profile', $data);      
        }

        // dd($user->city);
        $data = [
            'lang' => $lang,
            'user' => $user,
        ];
        return view('member.profile', $data);
    }


    /**
     * 判断是否为第一次访问个人中心页面
     */
    public function one_visited(Request $request){
        if(!Auth::check()){
            return Output::makeResult($request, null, Error::USER_NOT_LOGIN);
        }

        // $user=User::where('id',Auth::id())->where('username','like','%ohPM_%')->where('created_at','<','2020-06-02 00:00:00')->where('mobile','=','')->first();
        // // dd($user);
        // if($user->one_visited==1 || $user){
        //     return Output::makeResult($request, null, 100,'欢迎来到印际,请移步填写信息');
        // }else{
        //     return Output::makeResult($request, null, 200,'欢迎回来');
        // }


        $res=User::find(Auth::id());
        $info=User::where('id',Auth::id())->where('username','like','%ohPM_%')->where('created_at','<','2020-06-07 00:00:00')->where('mobile','=','')->first();
        // dd($user);
        if($res->one_visited==1 || $info){
            return Output::makeResult($request, null, 100,'欢迎来到印际,请移步填写信息');
        }else{
            return Output::makeResult($request, null, 200,'欢迎回来');
        }
        
    }


    /**
     * 微信注册进个人中心提交信息
     */
    public function one_check(Request $request){
        if(!Auth::check()){
            return Output::makeResult($request, null, Error::USER_NOT_LOGIN);
        }
        $edit_info = [];
        $fields = ['nickname', 'mobile','verification_code','provinces','citys','zhiwei'];
        foreach ($fields as $field) {
            $edit_info[$field] = $request->get($field);
        }

        $has_nick=User::where('nickname',$edit_info['nickname'])->first();
        $has_tel=User::where('mobile',$edit_info['mobile'])->first();
        if($has_nick){
            return Output::makeResult($request, null, 500,'昵称太受欢迎了');
        }else if($has_tel){
            return Output::makeResult($request, null, 500,'手机已存在');
        }
        $validator = Validator::make($request->all(), [
            'mobile' => 'required|confirm_mobile_not_change',
            'verification_code' => 'required|verify_code',
        ]);
        if ($validator->fails()) {
            //验证失败后建议清空存储的发送状态，防止用户重复试错
            // SmsManager::forgetState();
            return Output::makeResult($request, null, Error::MISS_PARAM, '验证码错误');
        }
        $province=Db::table("province")->where('province_num',$request->provinces)->value('province_name');
        $city=Db::table("city")->where('city_num',$request->citys)->value('city_name');
        $edit_info['city']=$province.'-'.$city;
        $result = User::where('id',Auth::id())->update(['nickname' =>$edit_info['nickname'],'mobile' =>$edit_info['mobile'],'zhiwei' =>$edit_info['zhiwei'],'city' =>$edit_info['city'],'one_visited'=>2,'nicksum'=>0]); 

        if($result){
            return Output::makeResult($request, null, 100,'填写完毕');
        }else{
            return Output::makeResult($request, null, 200,'请重新填写');
        }
        
    }


    /**
     * 城市三级联动
     */
    public function citysjld(Request $request){
        // dd($request->all());
        $type = isset($request->type)?$request->type:0;//获取请求信息类型 1省 2市 3区
        $province_num = isset($request->pnum)?$request->pnum:'440000';//根据省编号查市信息
        $city_num = isset($request->cnum)?$request->cnum:'440100';//根据市编号查区信息

        switch ($type) {//根据请求信息类型，组装对应的sql
            case 1://省
                // $sql = "SELECT * FROM province";
                $sql = Db::table("province")->get();
                break;
            case 2://市
                // $sql = "SELECT * FROM city WHERE province_num='{$province_num}'";
                $sql =Db::table("city")->where('province_num',$province_num)->get();
                break;
            case 3://区
                $sql =Db::table("area")->where('city_num',$city_num)->get();
                // $sql = "SELECT * FROM area WHERE city_num='{$city_num}'";
                break;
            default:
                die('no data');
                break;
        }

        // dd($sql);
        return $sql;
    }


    /**
     * 检测是否够次数修改昵称
    */
    public function editnick(Request $request){
        if(!Auth::check()){
            return Output::makeResult($request, null, Error::USER_NOT_LOGIN);
        }
        $user = User::find(Auth::id());
        $nicknamenum=User::getNickSum($user->id);
        // dd($nicknamenum);
        if($nicknamenum<=0){
            return Output::makeResult($request, null, 500,'修改昵称次数不够');
        }else{
            return Output::makeResult($request, null, 100,'今年修改昵称还剩下'.$nicknamenum.'次');
        }
    }



    /**
     * 修改用户信息
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function edit(Request $request)
    {
        $this->checkLogin();
        // dd($request->all());
        $user = User::find(Auth::id());
        $edit_info = [];
        $fields = ['nickname', 'email', 'mobile', 'password','code_tel','code_email','one_tel','one_email','nicksum','sex','city','zhiwei','personal_note'];
        foreach ($fields as $field) {
            $edit_info[$field] = $request->get($field);
        }
        $usernamenum=User::where('nickname',$request->nickname)->first();
        if($request->nickname){
            if($usernamenum){
                return Output::makeResult($request, null, 500,'昵称太受欢迎');
            }
        }

        if($request->pass1 && $request->pass2){
            if (!empty($request->pass1)) {
                if (strlen($request->pass1) < 6) {
                    return Output::makeResult($request, null, 500,'密码长度至少6位');
                }

                if ($request->pass1 != $request->pass2) {
                    return Output::makeResult($request, null, 500,'两次密码不一致');
                }

                $edit_info['password'] = bcrypt($request->pass1);
            }
        }

        if($request->mobile){
            if($user->mobile && $edit_info['mobile']=='' || $edit_info['mobile']==null){
                return Output::makeResult($request, null, 500,'请填写手机号码');
            }else if($user->mobile=='' || $user->mobile==null){
                $edit_info['one_tel']=2;
            }else{
                $edit_info['one_tel']=3;
            }
        }
        if($request->email){
            if($user->email && $edit_info['email']=='' || $edit_info['email']==null){
                return Output::makeResult($request, null, 500,'请填写邮箱');
            }if($user->email=='' || $user->email==null){
                $edit_info['one_email']=2;
            }else{
                $edit_info['one_email']=3;
            }
        }
        if($request->code_email){
            if($request->email!=session('email')){
                return Output::makeResult($request, null, 500,'邮箱错误');
            }else if($request->code_email!=session('code_email')){
                return Output::makeResult($request, null, 500,'邮箱验证码错误');
            }
        }
        $edit_info['personal_note']=$request->grsm;
        $province=Db::table("province")->where('province_num',$request->provinces)->value('province_name');
        $city=Db::table("city")->where('city_num',$request->citys)->value('city_name');
        // dd($province,$city);
        if(empty($province) && empty($city)){
            $edit_info['city']=null;
        }else{
            $edit_info['city']=$province.'-'.$city;
        }
        
        $result = User::editUser(Auth::id(), $edit_info);
        // dd($result);
        if (true === $result) {
            return Output::makeResult($request, null, 0,'修改成功');
            // return redirect('/member/profile');
        }
        return Output::makeResult($request, null, 500,$result);
        
    }


    /**
     * 发送验证码到邮箱绑定邮箱
     * 
     */
    public function bdemail(Request $request){
        $this->checkLogin();
        $email=User::select('id','username','email')->where("email","like","%$request->email%")->get()->toArray();
        // dd($request->all());
        if($email){
            foreach($email as $v){
                if($v['email']==$request->email){
                    return Output::makeResult($request, null, 500,'邮箱已存在');
                }
            }            
        }
        $view='member.email';
        
        $message = rand(10000,99999);
        // $data=json_decode(json_encode($message),true);
        // $data=compact('data');
        
        session(['email'=>$request->email,'code_email' => $message]);
        // Cache::put($request->email, $message, 1800);
        
        $from=trim('840638148@qq.com');
        $name='印际';
        $to = trim($request->email);
        // dd($from,$to);
        $subject = '邮箱绑定通知';
        $res=Mail::send($view,['content'=>$message], function ($message) use ($from, $name, $to, $subject) {
            $message->to($to)->subject($subject);
        });
        // dd(Mail::failures());
        if(!$res){
            return Output::makeResult($request, null, 100,'发送成功');
        }else{
            return Output::makeResult($request, null, 500,'发送失败');
        }


        // 
        // $data=['content'=>$message];
        // dd($data);


        // $res=Mail::raw('尊敬的用户，您换绑的验证码为'.$message, function ($message) use ($from, $name, $to, $subject) {
        //     $message->to($to)->subject($subject);
        // });

        // dd($res);

        // $res= Mail::send('member.email',['content' => $message],function($message){
        //     $to ='840638148@qq.com';
        //     $message ->to($to)->subject('绑定邮箱测试');
        // });

        // Mail::send(
        //     'emails.eamil', 
        //     ['content' => $message], 
        //     function ($message) use($to, $subject) { 
        //         $message->to($to)->subject($subject); 
        //     }
        // );
       
    } 


    /**
     * 微信绑定
     * 1、获取微信用户信息，判断有没有code，有使用code换取access_token，没有去获取code。
     * @return array 微信用户信息数组
    */
    public function wxbd(Request $request){
        $appid = "wxcdb9881bbd6e45bb";  
        $secret = "fe636918b8e48706cc54a5e40edf9df3";  
        $callbackUrl='http://www.yinjispace.com/member/wxbd_callbakc';
        $wxOAuth = new \Yurun\OAuthLogin\Weixin\OAuth2($appid, $secret, $callbackUrl);
        // 获取登录授权跳转页地址
        $url = $wxOAuth->getAuthUrl();
        // 存储sdk自动生成的state，回调处理时候要验证
        session(['YURUN_Weixin_STATE'=>$wxOAuth->state]);
        // 跳转到登录页
        header('location:' . $url);
    }
 
    /**
     * 微信回调
     */
    public function wxbd_callbakc(Request $request){
        $code=$request->code;
        $appid = "wxcdb9881bbd6e45bb";  
        $secret = "fe636918b8e48706cc54a5e40edf9df3";  
        $wxOAuth = new \Yurun\OAuthLogin\Weixin\OAuth2($appid, $secret);        

        $wxOAuth->getAccessToken(session('YURUN_Weixin_STATE')); 
        // file_put_contents(dirname(dirname(__DIR__)) . '/a.log', json_encode($userinfo) , FILE_APPEND);
        // var_dump(
        //     'access_token:', $wxOAuth->getAccessToken(session('YURUN_Weixin_STATE')),
        //     '我也是access_token:', $wxOAuth->accessToken,
        //     '请求返回:', $wxOAuth->result,
        //     '用户资料:', $wxOAuth->getUserInfo(),
        //     'openid:', $wxOAuth->openid
        // );
        $user = User::leftjoin('user_thirds','user_thirds.user_id','=','users.id')->select('users.id','users.username','user_thirds.unique_id')->where('users.username','user_thirds.unique_id')->get()->toArray();
        $u=User::find(Auth::id());
        //如果user表的username等于oppenid得话，就说明该微信已被绑定，或者是用微信扫码注册登录得
        if($user){
            return '该微信号已被绑定了';
        }else{   
            $u->username = $wxOAuth->openid;
            $u->points = $u->points + 10; 
            $u->left_points = $u->left_points + 10;
            $u->save();  
            $data = ['user_id' => $u->id,'type' => '0','point' => 10,'remark' => '首绑微信'];
            UserPoint::create($data);   
            $datas = ['user_id'=> $u->id,'third_type' => 'weixin','unique_id'  => $wxOAuth->openid,'third_data' => serialize($wxOAuth->getUserInfo())];
            UserThird::create($datas); 
            return redirect('/member/profile');
            
        }
    }
	



    public function interest(Request $request)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';

        $user = $this->getUserInfo();
        $month_price = VipPrice::getPrice(1);
        $season_price = VipPrice::getPrice(2);
        $year_price = VipPrice::getPrice(3);

        $data = [
            'lang' => $lang,
            'user' => $user,
            'month_price' => $month_price,
            'season_price' => $season_price,
            'year_price' => $year_price,
        ];
        return view('member.interest', $data);
    }

    public function follow(Request $request)
    {
        $this->checkLogin();

        $lang = $request->session()->get('language') ?? 'zh-CN';

        $user = $this->getUserInfo();
        $user->follows = UserFollow::getFollows($user->id);
        $user->fans = UserFollow::getFans($user->id);

        $data = [
            'lang' => $lang,
            'user' => $user,
        ];
        return view('member.follow', $data);
    }

    public function mydown(Request $request){
        $this->checkLogin();

        $lang = $request->session()->get('language') ?? 'zh-CN';

        $user = $this->getUserInfo();

        $today_starts = date('Y-m-d H:i:s', strtotime('-3 days'));
        $today_ends   = date('Y-m-d H:i:s');
        $down=UserDownRecord::leftjoin('articles','user_down_records.down_id','=','articles.id')->select('articles.static_url','articles.custom_thum','user_down_records.id','articles.title_name_cn','articles.title_designer_cn','articles.vip_download','user_down_records.created_at')->where('user_down_records.user_id',$user->id)->where('user_down_records.created_at', '>=', $today_starts)->where('user_down_records.created_at', '<=', $today_ends)->orderby('created_at','desc')->get();

        foreach($down as $k=>$v){
            $down[$k]['guoqitime']=Carbon::parse($v->created_at)->addDays(3)->toDateTimeString();
        }

        $data = [
            'lang' => $lang,
            'user' => $user,
            'down' => $down,
        ];
        return view('member.mydown', $data);
    }

    public function addFollow(Request $request)
    {
        $this->checkLogin();

        $result = UserFollow::followByUserId($request->follow_id);
        
        if (true === $result['status']) {
            return Output::makeResult($request, null);
        }else{
            return Output::makeResult($request, null, 500,$result['data']);
        }
        return Output::makeResult($request, null, Error::SYSTEM_ERROR);
    }

    public function cancelFollow(Request $request)
    {
        $this->checkLogin();

        $result = UserFollow::cancelFollowByUserId($request->follow_id);
        if (true === $result) {
            return Output::makeResult($request, null);
        }
        return Output::makeResult($request, null, Error::SYSTEM_ERROR);
    }


    public function point(Request $request)
    {
        $this->checkLogin();

        $lang = $request->session()->get('language') ?? 'zh-CN';

        $user = $this->getUserInfo();
        $user->follows = UserFollow::getFollows($user->id);
        $user->point_logs = UserPoint::getPointLogs($user->id);
        $today_point = UserPoint::getTodayPoint($user->id);
        $attendances = UserAttendance::getAttendanceLog();
        $today_start = date('Y-m-d 00:00:00');
        $today_end   = date('Y-m-d 23:59:59');
        $is_qiandao = UserAttendance::where('user_id', $user->id)->where('created_at', '>=', $today_start)->where('created_at', '<=', $today_end)->first();
        // dd($today_point);
        $last_days = UserAttendance::getLastDays($user->id);
        $tips = UserAttendance::getAttendanceTips();

        // $qd_sum_points=;
        // dd($user->point_logs);
        $data = [
            'lang' => $lang,
            'user' => $user,
            'attendances' => $attendances,
            'today_point' => $today_point,
            'last_days' => $last_days,
            'tips' => $tips,
            'is_qiandao' => $is_qiandao,
        ];
        return view('member.point', $data);
    }


    public function subscription(Request $request)
    {
        $this->checkLogin();

        $lang = $request->session()->get('language') ?? 'zh-CN';

        $user = $this->getUserInfo();
        $user->subscriptions = UserSubscription::getSubscriptions($user->id);

        $data = [
            'lang' => $lang,
            'user' => $user,
        ];
        return view('member.subscription', $data);
    }


    /**
     * 我的订阅搜索框
     */
    public function desearch(Request $request){
        if(!Auth::check()){
            return Output::makeResult($request, null, Error::USER_NOT_LOGIN);
        }

		$user_id = Auth::id();
        $user = $this->getUserInfo();

        $result = UserSubscription::desearch($request,$user_id);
        if(empty($result)){
            return Output::makeResult($request, null, 500,'没有数据');
        }else{
            $data=['result'=>$result,'msg'=>'查询成功'];
            return Output::makeResult($request, $data);
        }   
    }


    public function cancelSubscription(Request $request)
    {
        $this->checkLogin();

        $result = UserSubscription::cancelSubscriptionById($request->designer_id);
        if (true === $result) {
            return Output::makeResult($request, null);
        }
        return Output::makeResult($request, null, Error::SYSTEM_ERROR, $result);
    }


    public function collect(Request $request)
    {
        $this->checkLogin();

        $lang = $request->session()->get('language') ?? 'zh-CN';

        $user = $this->getUserInfo();
        $user->collects = UserCollect::getCollects($user->id);
		
        $data = [
            'lang' => $lang,
            'user' => $user,
        ];
        return view('member.collect', $data);
    }


    public function collectDetail(Request $request, $id)
    {
        $this->checkLogin();

        $lang = $request->session()->get('language') ?? 'zh-CN';

        $user = $this->getUserInfo();
        
        $user->collect_details = UserCollect::getCollectDetails($user->id, $id);
        $folder_name = '';
        $folder_obj = UserCollectFolder::find($id);
        if ($folder_obj) {
            $folder_name = $folder_obj->name;
        }
        
        foreach($user->collect_details as $k=>$v){
            //要删除的图片id
            $user->collect_details[$k]['delid']=UserCollect::where('user_collect_folder_id',$id)->where('collect_id',$v['id'])->value('id');
        }

        $data = [
            'lang' => $lang,
            'user' => $user,
            'folder_name' => $folder_name,
        ];
        return view('member.collect_detail', $data);
    }


    public function finder(Request $request)
    {
        $this->checkLogin();

        $lang = $request->session()->get('language') ?? 'zh-CN';

        $user = $this->getUserInfo();
        $user->finders = UserFinder::getFinders($user->id);

        $month_price = VipPrice::getPrice(1);
        $season_price = VipPrice::getPrice(2);
        $year_price = VipPrice::getPrice(3);

        $data = [
            'lang' => $lang,
            'user' => $user,
            'month_price' => $month_price,
            'season_price' => $season_price,
            'year_price' => $year_price,
        ];
        return view('member.finder', $data);
    }

    /**
     * TA的主页
     */
    public function homepage(Request $request,$id){
        $this->checkLogin();

        $lang = $request->session()->get('language') ?? 'zh-CN';
        $user = User::find(Auth::id());
        $users = User::find($id);
        $users->follows = UserFollow::getFollows($users->id);
        $users->subscriptions = UserSubscription::getSubscriptions($users->id);
        $users->collects = UserCollect::getCollects($users->id);
        $users->finders = UserFinder::getFinders($users->id);
        $attendances = UserAttendance::getAttendanceLog();
        $last_days = UserAttendance::getLastDays($users->id);
        $tips = UserAttendance::getAttendanceTips();
        $users->is_follow=UserFollow::where('user_id',$user->id)->where('follow_id',$users->id)->first();
        $today_start = date('Y-m-d 00:00:00');
        $today_end   = date('Y-m-d 23:59:59');
        $is_qiandao = UserAttendance::where('user_id', $users->id)->where('created_at', '>=', $today_start)->where('created_at', '<=', $today_end)->first();
        $visited=ViewNum::leftjoin('users','users.id','=','view_nums.user_id')->select('users.avatar','view_nums.user_id','view_nums.visited_id','view_nums.created_at')->where('view_nums.visited_id',$id)->orderby('created_at','desc')->get();
        $comments=HomepageMessage::getMessages($id);
        $reply=HomepageMessage::getReply($id,$user->id);
        $messagenum=HomepageMessage::where('comment_id',$id)->where('type',2)->count();
        $replynum=HomepageMessage::where('user_id',$id)->where('type',-2)->count();
        $commentsum=$messagenum+$replynum;
        // dd($reply);
        $data = [
            'lang' => $lang,
            'user' => $user,
            'users' => $users,
            'attendances' => $attendances,
            'last_days' => $last_days,
            'tips' => $tips,
            'is_qiandao' => $is_qiandao,
            'visited' => $visited,
            'comments' => $comments,
            'commentsum'=>$commentsum,
            'messagenum'=>$messagenum,
            'replynum'=>$replynum,
            'reply'=>$reply,
        ];
        return view('member.homepage', $data);
    }

    /**
    * TA的发现  
    */
    public function homepage_finder(Request $request, $id){
        $this->checkLogin();

        $lang = $request->session()->get('language') ?? 'zh-CN';
        $user = User::find(Auth::id());
        $users = User::find($id);
        $users->finders = UserFinder::getFinders($users->id);

        $month_price = VipPrice::getPrice(1);
        $season_price = VipPrice::getPrice(2);
        $year_price = VipPrice::getPrice(3);

        $data = [
            'lang' => $lang,
            'user' => $user,
            'users' => $users,
            'month_price' => $month_price,
            'season_price' => $season_price,
            'year_price' => $year_price,
        ];
        return view('member.homepage_finder', $data);
    }

    /**
    * TA的收藏
    */
    public function homepage_collect(Request $request, $id){
        $this->checkLogin();

        $lang = $request->session()->get('language') ?? 'zh-CN';
        $user = User::find(Auth::id());
        $users = User::find($id);
        $users->collects = UserCollect::getCollects($users->id);
		
        $data = [
            'lang' => $lang,
            'users' => $users,
            'user' => $user,
        ];
        return view('member.homepage_collect', $data);
    }

    /**
    * TA的订阅
    */
    public function homepage_subscription(Request $request, $id){
        $this->checkLogin();
        $lang = $request->session()->get('language') ?? 'zh-CN';
        $user = User::find(Auth::id());
        $users = User::find($id);

        $users->subscriptions = UserSubscription::getSubscriptions($users->id);
        $data = [
            'lang' => $lang,
            'users' => $users,
            'user' => $user,
        ];
        return view('member.homepage_subscription', $data);
    }

    /**
    * TA的关注
    */
    public function homepage_interactive(Request $request, $id){
        $this->checkLogin();
        $lang = $request->session()->get('language') ?? 'zh-CN';
        $user = User::find(Auth::id());
        $users = User::find($id);
        $users->follows = UserFollow::getFollows($users->id);
        $data = [
            'lang' => $lang,
            'users' => $users,
            'user' => $user,
        ];
        return view('member.homepage_interactive', $data);
    }

    /**
    * TA的收藏详情
    */
    public function hp_collect_detail(Request $request,$uid,$id){
        $this->checkLogin();
        $lang = $request->session()->get('language') ?? 'zh-CN';
        $user = User::find(Auth::id());
        $users = User::find($uid);

        $users->collect_details = UserCollect::getCollectDetails($users->id, $id);
        $folder_name = '';
        $folder_obj = UserCollectFolder::find($id);
        if ($folder_obj) {
            $folder_name = $folder_obj->name;
        }

        $data = [
            'lang' => $lang,
            'users' => $users,
            'user' => $user,
            'folder_name' => $folder_name,
        ];
        return view('member.hp_collect_detail', $data);
    }
    
    /**
    * TA的收藏详情
    */
    public function hp_finder_detail(Request $request,$uid,$id){
        $this->checkLogin();
        $lang = $request->session()->get('language') ?? 'zh-CN';
        $user = User::find(Auth::id());
        $users = User::find($uid);

        $users->finder_details = UserFinder::getFinderDetails($users->id, $id);
        $folder_name = '';
        $folder_obj = UserFinderFolder::find($id);
        if ($folder_obj) {
            $folder_name = $folder_obj->name;
        }
        //获取用户所有发现夹，并去掉当前所在发现夹
        $folderall=UserFinderFolder::where('user_finder_folders.is_open',1)->select('id','user_id','name')->where('user_finder_folders.user_id',$uid)->get();
        $folderall = $folderall->reject(function ($value) use ($uid) {
            return $value->id == $uid;
          });

		//获取个人中心->发现中心->图片的标题
        foreach ($users->finder_details as $userfinderid){
        	
        	$tiname=Article::where('id',$userfinderid['photo_source'])->get()->toArray();
        	
        	foreach ($tiname as $tinamearr){
				$tinames=$tinamearr['title_designer_cn'].' | '.$tinamearr['title_name_cn'];
				$userfinderid['static_url']=$tinamearr['static_url'];
				$userfinderid['titlename']=$tinames;
        	}
			
        }
        //通过用户id获取收藏夹名字
    	$userscname = UserFinderFolder::where('user_finder_folders.user_id',$user->id)->get()->toArray();

        $folist=UserFinderFolder::where('user_finder_folders.id',$request->id)->leftjoin('user_finders','user_finder_folders.id','user_finders.user_finder_folder_id')->get()->toArray();
        $data = [
            'lang' => $lang,
            'users' => $users,
            'user' => $user,
            'folist' => $folist,
            'folder_name' => $folder_name,
            'folderall' => $folderall,
            'userscname' => $userscname,
        ];
        return view('member.hp_finder_detail', $data);
    }

    /**
    * TA的粉丝
    */
    public function homepage_fans(Request $request, $id){
        $this->checkLogin();
        $lang = $request->session()->get('language') ?? 'zh-CN';
        $user = User::find(Auth::id());
        $users = User::find($id);
        $users->fans = UserFollow::getFans($users->id);
        $data = [
            'lang' => $lang,
            'users' => $users,
            'user' => $user,
        ];
        return view('member.homepage_fans', $data);
    }

    /**
    * 关注TA 
    */
    public function gzta(Request $request){
        if(!Auth::check()){
            return Output::makeResult($request, null, Error::USER_NOT_LOGIN);
        }

        if(empty($request->gzid)){
            return Output::makeResult($request, null, 500,'请选择关注的用户');
        }

        if($request->gzid==Auth::id()){
            return Output::makeResult($request, null, 500,'不能关注自己');
        }

        $result=UserFollow::followByUserId($request->gzid);
        if($result['status']===true){
            return Output::makeResult($request, null, 100,$result['data']);
        }else{
            return Output::makeResult($request, null, 500,$result['data']);
        }

    }

    /**
    * 取消关注TA 
    */
    public function qxgzta(Request $request){
        if(!Auth::check()){
            return Output::makeResult($request, null, Error::USER_NOT_LOGIN);
        }

        if(empty($request->gzid)){
            return Output::makeResult($request, null, 500,'请选择取消关注的用户');
        }

        $result=UserFollow::cancelFollowByUserId($request->gzid);
        if($result===true){
            return Output::makeResult($request, null, 100,'取消关注成功');
        }else{
            return Output::makeResult($request, null, Error::SYSTEM_ERROR);
        }

    }

    /**
    * 关注TA的订阅 
    */
    public function gztady(Request $request)
    {
        if(!Auth::check()){
            return Output::makeResult($request, null, Error::USER_NOT_LOGIN);
        }

        $result = UserSubscription::subscriptionByDesignerId($request->designer_id);
        if (true === $result) {
            return Output::makeResult($request, null,100,'订阅成功');
        }else{
            return Output::makeResult($request, null,500,'订阅过');
        }
    }

    /**
    * 统计访问主页的用户
    */
    public function visited_hp(Request $request)
    {
        if(!Auth::check()){
            header("Location: /user/login");die;
        }

        $uid=$request->uid;
        $user_id=Auth::id();
        $today_start = date('Y-m-d 00:00:00');
        $today_end   = date('Y-m-d 23:59:59');
        $res=ViewNum::where('user_id',$user_id)->where('visited_id',$uid)->where('created_at', '>=', $today_start)->where('created_at', '<', $today_end)->first();
        $result=ViewNum::where('user_id',$user_id)->where('visited_id',$uid)->first();

        if($uid!=$user_id){
            if($result){
                ViewNum::where('user_id',$user_id)->first()->touch();
            }else
            if(!$res){
                $data=[
                    'user_id'=>$user_id,
                    'visited_id'=>$uid,
                ];
                ViewNum::create($data);                
            }
        }
    }

    /**
    * 个人主页评论
    */
    public function homepage_messages(Request $request){
        if(!Auth::check()){
            header("Location: /user/login");die;
        }

        $con=HomepageMessage::where('user_id',Auth::id())->where('comment_id',$request->comment_id)->first();
        if($con){
            return Output::makeResult($request, null, 500,'已评过');
        }else

        if($request->con && $request->comment_id && $request->type){
            $data=[
                'user_id'=>Auth::id(),
                'comment_id'=>$request->comment_id,
                'content'=>$request->con,
                'type'=>$request->type
            ];
            $res=HomepageMessage::create($data);    
            if($res){
                return Output::makeResult($request, null, 100,'评论成功');
            }
        }else{
            return Output::makeResult($request, null, Error::SYSTEM_ERROR);
        }

    }

    /**
     * 个人主页回复评论
     */
    public function reply_messages(Request $request){
        if(!Auth::check()){
            header("Location: /user/login");die;
        }

        if($request->user_id==$request->comment_id){
            return Output::makeResult($request, null, 500,'不能给自己评论');
        }

        if($request->con && $request->comment_id && $request->type){
            $data=[
                'user_id'=>$request->user_id,
                'comment_id'=>$request->comment_id,
                'content'=>$request->con,
                'type'=>$request->type
            ];
            $res=HomepageMessage::create($data);    
            if($res){
                return Output::makeResult($request, null, 100,'回复成功');
            }
        }else{
            return Output::makeResult($request, null, Error::SYSTEM_ERROR);
        }

    }



    public function finderDetail(Request $request, $id)
    {
        $this->checkLogin();
        $lang = $request->session()->get('language') ?? 'zh-CN';

        $user = $this->getUserInfo();
        $user->finder_details = UserFinder::getFinderDetails($user->id, $id);
        $folder_name = '';
        $folder_obj = UserFinderFolder::find($id);
        if ($folder_obj) {
            $folder_name = $folder_obj->name;
        }
        //获取用户所有发现夹，并去掉当前所在发现夹
        $folderall=UserFinderFolder::where('user_finder_folders.is_open',1)->select('id','user_id','name')->where('user_finder_folders.user_id',Auth::id())->get();
        $folderall = $folderall->reject(function ($value) use ($id) {
            return $value->id == $id;
          });
        // dd($folderall);


		//获取个人中心->发现中心->图片的标题
        foreach ($user->finder_details as $userfinderid){
        	
        	$tiname=Article::where('id',$userfinderid['photo_source'])->get()->toArray();
        	
        	foreach ($tiname as $tinamearr){
				$tinames=$tinamearr['title_designer_cn'].' | '.$tinamearr['title_name_cn'];
				$userfinderid['static_url']=$tinamearr['static_url'];
				$userfinderid['titlename']=$tinames;
        	}
			
        }

        $folist=UserFinderFolder::where('user_finder_folders.id',$request->id)->leftjoin('user_finders','user_finder_folders.id','user_finders.user_finder_folder_id')->get()->toArray();
        // dd($folder_obj);
        $data = [
            'lang' => $lang,
            'user' => $user,
            'folist' => $folist,
            'folder_name' => $folder_name,
            'folderall' => $folderall,
        ];
        return view('member.finder_detail', $data);
    }

    //移动个人中心->发现中心的->一个发现夹里的一张图片到另外一个发现夹里
    public function movefxj(Request $request)
    {
        if(!Auth::check()){
            return Output::makeResult($request, null, Error::USER_NOT_LOGIN);
        }

        $finder_id = $request->finder_id;
        $source = $request->source;
        $photo_src = $request->photo_src;
        $now_folder_id = $request->now_url;
        $user_id = Auth::id();


        $finder = UserFinder::where('user_id', $user_id)->where('photo_url', $photo_src)->where('user_finder_folder_id',$now_folder_id)->update(['user_finder_folder_id' => $finder_id]); 

        // dd($finder);
        if ($finder) {
            return Output::makeResult($request, null,0,'移动成功');
        } else {
            return Output::makeResult($request, null, Error::SYSTEM_ERROR, '您无权删除该图片');
        }
    }
    

    //删除个人中心->发现中心的->一个发现夹里的一张图片
    public function deleteFinderItem(Request $request)
    {
        $this->checkLogin();
        $finder_id = $request->finder_id;
        $user_id = Auth::id();
        $finder = UserFinder::where('user_id', $user_id)->where('id', $finder_id)->first(); 

        if ($finder) {
            $finder->delete();
            return Output::makeResult($request, null);
        } else {
            return Output::makeResult($request, null, Error::SYSTEM_ERROR, '您无权删除该图片');
        }
    }
    
    //删除个人中心->收藏中心的->一个收藏夹里的一张图片
    public function deleteFolderItem(Request $request)
    {
        $this->checkLogin();
        // dd($request->all());
        $finder_id = $request->finder_id;
        $user_id = Auth::id();
        $finder = UserCollect::where('user_id', $user_id)->where('id', $finder_id)->first(); 
        // dd($finder);
        if ($finder) {
            $finder->delete();
            return Output::makeResult($request, null);
        } else {
            return Output::makeResult($request, null, Error::SYSTEM_ERROR, '您无权删除该图片');
        }
    }

    
    public function attendance(Request $request)
    {
        $this->checkLogin();

        $result = UserAttendance::attendance();
        // dd($result);
        if (true === $result['res']) {
            $user = $this->getUserInfo();
            $user = User::find($user->id);
            $last_days = UserAttendance::getLastDays($user->id);
            $data = [
                'last_days' => $last_days,
                'points' => $user->points,
                'qdyb' => $result['qdyb'],
            ];
            return Output::makeResult($request, $data);
        }
        return Output::makeResult($request, null, Error::SYSTEM_ERROR, $result);
    }






    /**
     * 是否够印币兑换
     */
    public function is_enough_points(Request $request){
        $this->checkLogin();

        $user_id=Auth::id();
        $yb=$request->yb;
        $result=User::where('id',$user_id)->where('left_points','>',$yb)->first();
        // dd($result);
        if($result){
            $data=['msg'=>'即将跳转支付页面'];
            return Output::makeResult($request, $data);
        }
        
        return Output::makeResult($request, null,500, '印币不够');
    }


    //打分评论
    public function comment(Request $request)
    {
        $this->checkLogin();
        
        $type = $request->type ?? 'article';

        switch (strtolower($type)) {
            case 'article':
                $obj = ArticleComment::class;
                break;
            case 'designer':
                $obj = DesignerComment::class;
                break;
            case 'news':
                $obj = NewsComment::class;
                break;
        }

        if (!isset($obj)) {
            return Output::makeResult($request, null, Error::ILLEGAL_REQUEST);
        }
        
        $alaredy = $obj::where('comment_id', $request->comment_id)->where('user_id', Auth::id())->count();
        if ($alaredy) {
            return Output::makeResult($request, null, 500, '每个用户只允许评分留言一次');
        }
        if($request->stars==null){
            return Output::makeResult($request, null, 500, '请评分！');
        }

        if($request->comment==''){
            $data = [
                'comment_id' => $request->comment_id,
                'user_id' => Auth::id(),
                'content' => $request->comment,
                'stars' => $request->stars,
                'display' => 1,
            ];

            $result = $obj::create($data);

            $user = User::find(Auth::id());
            $user_info = [
                'id' => $user->id,
                'nickname' => $user->nickname,
                'vip_level' => 'level' . $user->vip_level,
                'avatar' => $user->avatar ?? '/img/avatar.png',
            ];
            
            $user->points = $user->points + 2;
            $user->left_points = $user->left_points + 2;
            $user->save();
    
            $point_log = [
                'user_id' => $user->id,
                'type' => '0',
                'point' => 2,
                'remark' => '评分',
            ];
            UserPoint::create($point_log);

        }else{
            $data = [
                'comment_id' => $request->comment_id,
                'user_id' => Auth::id(),
                'content' => $request->comment,
                'stars' => $request->stars,
            ];

            $result = $obj::create($data);

            $user = User::find(Auth::id());
            $user_info = [
                'id' => $user->id,
                'nickname' => $user->nickname,
                'vip_level' => 'level' . $user->vip_level,
                'avatar' => $user->avatar ?? '/img/avatar.png',
            ];
            
            
            // dd($is_pingyu);

        }




        return Output::makeResult($request, ['user_info' => $user_info, 'comment_info' => $result]);

    }
	
	
	
	public function uploadImgs(Request $request)
	{
        // dd($request->all());
        $tmp = $request->file('file');
        
		$path = '/uploads/images'; //public下的
		if ($tmp->isValid()) { //判断文件上传是否有效
			$FileType = $tmp->getClientOriginalExtension(); //获取文件后缀
            
			$FilePath = $tmp->getRealPath(); //获取文件临时存放位置

            $FileName = date('Y-m-d') . uniqid() . '.' . $FileType; //定义文件名
                
            Storage::disk('upload_img')->put($FileName, file_get_contents($FilePath)); //存储文件
            $data = [
                'status' => 0,
                'path' => $path . '/' . $FileName //文件路径
            ];
        
            User::where('id',Auth::id())->update(['zhuti' => $path . '/' . $FileName]);
            return Output::makeResult($request, $data);
		}
		
		return Output::makeResult($request, null, Error::SYSTEM_ERROR);
    }


    public function uploadImg(Request $request)
	{
        if($request->images){
            $base_img=$request->images;
            $img_houzhui=substr($base_img,11,3);//获取后缀名

            $base_img = substr($base_img,22);//去掉头

            $path="/";
            $FileName = date('Y-m-d'). uniqid() . '.' .$img_houzhui;//定义文件名
            $path =$path.$FileName;
            //  创建将数据流文件写入我们创建的文件内容中
            Storage::disk('upload_img')->put($FileName, base64_decode($base_img)); //存储文件

            $data = [
                'status' => 0,
                'path' => trim('/public/uploads/images' . $path) //文件路径
            ];

            User::where('id',Auth::id())->update(['avatar' => '/uploads/images' . $path]);

            return Output::makeResult($request, $data);
        }// dd($base_img);
        return Output::makeResult($request, null, Error::SYSTEM_ERROR);
    }
    
}
