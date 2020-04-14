<?php

namespace App\Http\Controllers\ThirdLogin;

use Socialite;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use SocialiteProviders\Weibo\Provider;

class WeiboController extends Controller{
    public function redirectToProvider(Request $request)
    {   
        return Socialite::with('weibo')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        $oauthUser = Socialite::with('weibo')->user();
 
        var_dump($oauthUser->getId());
        var_dump($oauthUser->getNickname());
        var_dump($oauthUser->getName());
        var_dump($oauthUser->getEmail());
        var_dump($oauthUser->getAvatar());

    }
}