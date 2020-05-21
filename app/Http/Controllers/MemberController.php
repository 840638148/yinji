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
use Carbon\Carbon;
// use Mail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use DB;
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
        $user->city=explode('-',$user->city);
        // dd($user);
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
        $user=User::find(Auth::id());
        if($user->one_visited==1){
            User::where('id',$user->id)->update(['one_visited'=>2]);
            return Output::makeResult($request, null, 100,'欢迎来到印际,请移步填写信息');
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
        return $sql;//返回json数据
    }



    /**
     * 修改用户
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
        $fields = ['nickname', 'email', 'mobile', 'password','code_tel','code_email'];
        foreach ($fields as $field) {
            // if ($request->get($field)) {
                $edit_info[$field] = $request->get($field);
            // }
        }
        $usernamenum=User::getEditNicknameNum($user->id);
        if($request->nickname){
            if($usernamenum<=0){
                return Output::makeResult($request, null, 500,'修改昵称次数不够');
            }else if(($usernamenum-1)<0){
                $usernamenum=0;
            }else{
                $edit_info['nicksum']=$usernamenum-1;
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
        // dd($edit_info);
        
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
        // dd(session('code_email'));
        if($request->code_email){
            if($request->email!=session('email')){
                return Output::makeResult($request, null, 500,'邮箱错误');
            }else if($request->code_email!=session('code_email')){
                return Output::makeResult($request, null, 500,'邮箱验证码错误');
            }
        }

        // dd($edit_info);
        $result = User::editUser(Auth::id(), $edit_info);
        // dd($result);
        if (true === $result) {
            return Output::makeResult($request, null, 0,'修改成功');
            // return redirect('/member/profile');
        }
        return Output::makeResult($request, null, 500,$result);
        // return $result;
    }


    /**
     * 发送验证码到邮箱绑定邮箱
     * 1261660791@qq.com
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
        $data=json_decode(json_encode($message),true);
        $data=compact('data');
        
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
     * 修改用户基本信息
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function baseedit(Request $request)
    {
        $this->checkLogin();
        // dd($request->all());

        $edit_info = [];
        // $fields = ['avatar', 'sex', 'city', 'zhiwei', 'personal_note'];
        $fields = ['sex', 'city', 'zhiwei', 'personal_note'];
        
        foreach ($fields as $field) {
           
            if ($request->get($field)) {
                $edit_info[$field] = $request->get($field);
            }
        }
        $province=Db::table("province")->where('province_num',$request->provinces)->value('province_name');
        $city=Db::table("city")->where('city_num',$request->citys)->value('city_name');
        $edit_info['city']=$province.'-'.$city;
        $result = User::where('id',Auth::id())->update($edit_info);
        //  dd($edit_info);
        if ($result) {
            return redirect('/member/profile');
        }
        return '请重试';
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
        
        if (true === $result) {
            return Output::makeResult($request, null);
        }else{
            return Output::makeResult($request, null, 500,'您没有权限，请先开通会员获取权限');
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
        return view('member.finder', $data);
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

        $data = [
            'lang' => $lang,
            'user' => $user,
            'folist' => $folist,
            'folder_name' => $folder_name,
        ];
        return view('member.finder_detail', $data);
    }

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
