<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\UserDownRecord;
use App\Models\UserExchangeRecord;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function checkLogin() {
        if (!Auth::check()) {
            return redirect('user/login')->send();
        }
    }

    public function getAuthUser()
    {
        $user = null;
        if (Auth::check()) {
            $user = Auth::user();
        }
        return $user;
    }

    /**
     * 获取用户对象
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getUserInfo()
    {
        $user = $this->getAuthUser();
        if ($user) {
            $user->is_vip = User::isVip($user->id);
            $user->vip_level = User::getVipLevel($user->id);
            $user->download_num = User::getDownloadNum($user->id);
            $user->use_download_num = User::getUseDownloadNum($user->id);
            $user->collect_num = User::getCollectNum($user->id);
            $user->fans_num = User::getFansNum($user->id);
            $user->follow_num = User::getFollowNum($user->id);
            $user->subscription_num = User::getSubscriptionNum($user->id);
        }
        return $user;
    }
}
