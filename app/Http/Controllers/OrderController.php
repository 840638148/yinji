<?php

namespace App\Http\Controllers;

use App\Models\UserCollect;
use App\Models\UserFinder;
use App\Models\UserFollow;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use SmsManager;
use App\Http\Error;
use App\Http\Output;
use App\User;

class OrderController extends Controller
{
    public function __construct() {
        if (!Auth::check()) {
            return redirect('/');
        }
    }

   
    public function vipIntro(Request $request)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';

        $user = $this->getUserInfo();

        $data = [
            'lang' => $lang,
            'user' => $user,
        ];
        return view('order.vip_intro', $data);
    }

    /**
     * 个人资料
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function profile(Request $request)
    {
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


    public function follow(Request $request)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';

        $user = $this->getUserInfo();
        $user->follows = UserFollow::getFollows($user->id);

        $data = [
            'lang' => $lang,
            'user' => $user,
        ];
        return view('member.follow', $data);
    }

    public function cancelFollow(Request $request)
    {
        $result = UserFollow::cancelFollowByUserId($request->follow_id);
        if (true === $result) {
            return Output::makeResult($request, null);
        }
        return Output::makeResult($request, null, Error::SYSTEM_ERROR);
    }


    public function subscription(Request $request)
    {
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
        $result = UserSubscription::cancelSubscriptionById($request->designer_id);
        if (true === $result) {
            return Output::makeResult($request, null);
        }
        return Output::makeResult($request, null, Error::SYSTEM_ERROR);
    }


    public function collect(Request $request)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';

        $user = $this->getUserInfo();
        $user->collects = UserCollect::getCollects($user->id);

        $data = [
            'lang' => $lang,
            'user' => $user,
        ];
        return view('member.collect', $data);
    }


    public function finder(Request $request)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';

        $user = $this->getUserInfo();
        $user->finders = UserFinder::getFinders($user->id);

        $data = [
            'lang' => $lang,
            'user' => $user,
        ];
        return view('member.finder', $data);
    }
}
