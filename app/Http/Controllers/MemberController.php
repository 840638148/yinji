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

        // dd($user->collects); 
        $data = [
            'lang' => $lang,
            'user' => $user,
            'attendances' => $attendances,
            'last_days' => $last_days,
            'tips' => $tips,
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

        $data = [
            'lang' => $lang,
            'user' => $user,
        ];
        return view('member.profile', $data);
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

        $edit_info = [];
        $fields = ['username', 'nickname', 'email', 'mobile', 'avatar', 'sex', 'city', 'url', 'personal_note'];
        foreach ($fields as $field) {
            if ($request->get($field)) {
                $edit_info[$field] = $request->get($field);
            }
        }

        if (!empty($request->pass1)) {
            if (strlen($request->pass1) < 6) {
                return '密码长度至少6位';
            }

            if ($request->pass1 != $request->pass2) {
                return '两次密码不一致';
            }

            $edit_info['password'] = bcrypt($request->pass1);
        }
            
        $result = User::editUser(Auth::id(), $edit_info);
        if (true === $result) {
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

    public function addFollow(Request $request)
    {
        $this->checkLogin();

        $result = UserFollow::followByUserId($request->follow_id);
        if (true === $result) {
            return Output::makeResult($request, null);
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
        $last_days = UserAttendance::getLastDays($user->id);
        $tips = UserAttendance::getAttendanceTips();
        $data = [
            'lang' => $lang,
            'user' => $user,
            'attendances' => $attendances,
            'today_point' => $today_point,
            'last_days' => $last_days,
            'tips' => $tips,
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
		
		// dd($user->collects);
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
        // dd($user->collect_details->toArray());
        // $user->collect_details = UserCollect::getCollectDetails($user->id);
        $folder_name = '';
        $folder_obj = UserCollectFolder::find($id);
        if ($folder_obj) {
            $folder_name = $folder_obj->name;
        }
        
        foreach($user->collect_details as $k=>$v){
            //要删除的id
            // dump($v['id']);
            $user->collect_details[$k]['delid']=UserCollect::where('user_collect_folder_id',$id)->where('collect_id',$v['id'])->value('id');
        }
        // echo '<pre>';
		// dump($user->collect_details);
		// die;
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
				
				$userfinderid['titlename']=$tinames;
        	}
			
        }

        $folist=UserFinderFolder::where('user_finder_folders.id',$request->id)->leftjoin('user_finders','user_finder_folders.id','user_finders.user_finder_folder_id')->get()->toArray();

		// dd($request->id);
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
            return Output::makeResult($request, null, Error::SYSTEM_ERROR, '你无权删除该图片');
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
            return Output::makeResult($request, null, Error::SYSTEM_ERROR, '你无权删除该图片');
        }
    }

    
    public function attendance(Request $request)
    {
        $this->checkLogin();

        $result = UserAttendance::attendance();
        if (true === $result) {
            $user = $this->getUserInfo();
            $user = User::find($user->id);
            $last_days = UserAttendance::getLastDays($user->id);
            $data = [
                'last_days' => $last_days,
                'points' => $user->points,
            ];
            return Output::makeResult($request, $data);
        }
        return Output::makeResult($request, null, Error::SYSTEM_ERROR, $result);
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
            return Output::makeResult($request, null, 500, '每个用户只允许打分评论一次');
        }

        if($request->comment==''){
            $data = [
                'comment_id' => $request->comment_id,
                'user_id' => Auth::id(),
                'content' => $request->comment,
                'stars' => $request->stars,
                'display' => 1,
            ];
        }else{
            $data = [
                'comment_id' => $request->comment_id,
                'user_id' => Auth::id(),
                'content' => $request->comment,
                'stars' => $request->stars,
            ];
        }


        $result = $obj::create($data);

        $user = User::find(Auth::id());
        //$user = $this->getUserInfo();
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
            'remark' => '评论',
        ];
        UserPoint::create($point_log);

        return Output::makeResult($request, ['user_info' => $user_info, 'comment_info' => $result]);

    }
	
	
	
	public function uploadImg(Request $request)
	{
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
			return Output::makeResult($request, $data);
		}
		
		return Output::makeResult($request, null, Error::SYSTEM_ERROR);
	}
}
