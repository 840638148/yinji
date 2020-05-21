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
use DB;
use Illuminate\Support\Facades\Mail;
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
            'verification_code_email' => 'required|verify_code',
            'user_email' => 'required|email',
        ]);
        if($request->user_phone){
            if ($validator->fails()) {
                //验证失败后建议清空存储的发送状态，防止用户重复试错
                //SmsManager::forgetState();
                return Output::makeResult($request, null, Error::MISS_PARAM, '验证码错误');
            }
        }
        if($request->user_email){
            if($request->user_email!=session('email')){
                return Output::makeResult($request, null, 500,'邮箱错误');
            }else if($request->verification_code_email!=session('code_email')){
                return Output::makeResult($request, null, 500,'邮箱验证码错误');
            }
        }

        return Output::makeResult($request,null,0,'请进行下一步操作');
    }


    /**
     * 发送邮箱验证码
     */
    public function send_email_code(Request $request){
        $email=User::select('id','username','email')->where("email","like","%$request->user_email%")->get()->toArray();
        // dd($request->all());
        if($email){
            foreach($email as $v){
                if($v['email']==$request->user_email){
                    return Output::makeResult($request, null, 500,'邮箱已存在');
                }
            }            
        }
        $view='member.email';
        $message = rand(10000,99999);
        
        session(['email'=>$request->user_email,'code_email' => $message]);
        // Cache::put($request->email, $message, 1800);
        
        $from='840638148@qq.com';
        $name='印际';
        $to = $request->user_email;
        // dd($from,$to);
        $subject = '邮箱注册通知';

        $res=Mail::send($view,['content'=>$message], function ($message) use ($from, $name, $to, $subject) {
            $message->to($to)->subject($subject);
        });
        // dd(Mail::failures());
        if(!$res){
            return Output::makeResult($request, null, 100,'发送成功');
        }else{
            return Output::makeResult($request, null, 500,'发送失败');
        }

    }



    public function doRegister(Request $request)
    {   
        // dd($request->all());
        //验证数据
        $validator = Validator::make($request->all(), [
            'user_phone' => 'required|confirm_mobile_not_change',
            'user_login' => 'required',
            'pass1' => 'required',
            'pass2' => 'required|same:pass1',
            'user_email'=>'required',
            'zhiwei'=>'required',
            'diqu'=>'required',
        ]);
 
        // if ($validator->fails()) {
        //     return Output::makeResult($request, $validator->errors(), Error::MISS_PARAM);
        // }

        $province=Db::table("province")->where('province_num',$request->provinces)->value('province_name');
        $city=Db::table("city")->where('city_num',$request->city)->value('city_name');
        $citys=$province.'-'.$city;
        // dd($province,$city,$citys);
        
     
        $user = [
            'username'     => $request->user_login,
            'nickname'     => $request->user_login,
            'password'     => bcrypt($request->pass1),
            'mobile'       => $request->user_phone,
            'register_key' => '',
            'zhiwei' => $request->zhiwei,
            'city' => $citys,
        ];
        $result = User::createUser($user);
        if (true === $result) {
            $user=User::where("username",$request->user_login)->first();
            // Auth::login($user);//传用户实例
            Auth::loginUsingId($user->id);//传用户id
            return Output::makeResult($request,null,0,'注册成功');
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
