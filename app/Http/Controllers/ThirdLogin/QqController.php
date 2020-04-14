<?php

namespace App\Http\Controllers\ThirdLogin;

use Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\UserThird;
use App\User;

class QqController extends Controller{
    public function redirectToProvider(Request $request)
    {   
        return Socialite::with('qq')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        $user_data = Socialite::with('qq')->stateless()->user();
        $data = array_merge($user_data->user, ['openid' => $user_data->id, 'headimgurl' => $user_data->avatar]);
        $result = UserThird::login('qq', $data);
        $user = User::where('username' , $user_data->id)->first();
        if ($result) {
            if (Auth::login($user)) {
                // 认证通过...
                //return Output::makeResult($request, ['url' => '/']);
                $user = User::find(Auth::id());
                $user->last_login_time = date('Y-m-d H:i:s');
                $user->last_login_ip = get_real_ip();
                $user->save();
                return redirect('/');
            }
            return redirect('/');
        }
        //dd($user_data);
    }
}