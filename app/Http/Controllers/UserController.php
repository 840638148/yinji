<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use SmsManager;
use App\Http\Error;
use App\Http\Output;
use App\User;

class UserController extends Controller
{
    public function login(Request $request)
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {
        if (Auth::check()) {
            return Output::makeResult($request, ['url' => '/']);
        }

        //验证数据
        $validator = Validator::make($request->all(), [
            'user_login' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return Output::makeResult($request, null, Error::MISS_PARAM);
        }

        $username_login = Auth::attempt(['username' => $request->user_login, 'password' => $request->password]);
        if (!$username_login) {
            $tmp_user = User::where('mobile', $request->user_login)->first();
            if ($tmp_user) {
                $username_login = Auth::attempt(['username' => $tmp_user->username, 'password' => $request->password]);
            }
        }
        if ($username_login) {
            $user = User::find(Auth::id());
            $user->last_login_time = date('Y-m-d H:i:s');
            $user->last_login_ip = get_real_ip();

            $session_id = Session::getId();
            if ($session_id != $user->last_session_id) {
                @unlink(storage_path('framework/sessions/') . $user->last_session_id);

                $user->last_session_id = $session_id;
            }

            $user->save();
            // 认证通过...
            return Output::makeResult($request, ['url' => '/']);
        }
        return Output::makeResult($request, null, Error::PASSWORD_ERROR);
    }
    
    
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect('/');
    }


    public function register(Request $request)
    {
        return view('register');
    }


    public function checkCode(Request $request)
    {
        //验证数据
        $validator = Validator::make($request->all(), [
            'user_phone' => 'required|confirm_mobile_not_change',
            'verification_code' => 'required|verify_code',
        ]);

        if ($validator->fails()) {
            //验证失败后建议清空存储的发送状态，防止用户重复试错
            //SmsManager::forgetState();
            return Output::makeResult($request, null, Error::MISS_PARAM, '验证码错误');
        }

        return Output::makeResult($request);
    }


    public function doRegister(Request $request)
    {
        //验证数据
        $validator = Validator::make($request->all(), [
            'user_phone' => 'required|confirm_mobile_not_change',
            'user_login' => 'required',
            'pass1' => 'required',
            'pass2' => 'required|same:pass1',
        ]);

        if ($validator->fails()) {
            return Output::makeResult($request, $validator->errors(), Error::MISS_PARAM);
        }

        $user = [
            'username'     => $request->user_login,
            'nickname'     => $request->user_login,
            'password'     => bcrypt($request->pass1),
            'mobile'       => $request->user_phone,
            'register_key' => '',
        ];
        $result = User::createUser($user);
        if (true === $result) {
            return Output::makeResult($request);
        } else {
            return Output::makeResult($request, null, Error::SYSTEM_ERROR, $result);
        }
    }

    public function forgotPassword(Request $request)
    {
        return view('forgot_password');
    }

    public function resetPassword(Request $request)
    {
        //验证数据
        $validator = Validator::make($request->all(), [
            'user_phone' => 'required|confirm_mobile_not_change',
            'verification_code' => 'required|verify_code',
            'pass1' => 'required',
            'pass2' => 'required|same:pass1',
        ]);

        if ($validator->fails()) {
            return Output::makeResult($request, $validator->errors(), Error::MISS_PARAM, '验证码错误');
        }

        $user = User::where('mobile', $request->user_phone)->first();
        if (!$user) {
            return Output::makeResult($request, null, Error::SYSTEM_ERROR, '用户不存在');
        }
        $user->password = bcrypt($request->pass1);
        $user->save();
        return Output::makeResult($request);
    }
}
