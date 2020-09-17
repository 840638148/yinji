<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class UserThird extends Model
{

    protected $fillable = [
        'user_id', 'third_type', 'unique_id', 'third_data','union_id','applets_openid','sessionKey','third_data_xcx',
    ];

    public static function getUniqueId($third_type, $third_data)
    {
        $unique_id = '';
        switch (strtolower($third_type)) {
            case 'weixin':
                $unique_id = $third_data['openid'];
                break;
            case 'qq':
                $unique_id = $third_data['openid'];
                break;
            case 'weixinxcx':
                $unique_id = $third_data['openid'];
                break;
    
        }
        return $unique_id;
    }
    
    public static function login($third_type,$third_data){   
        $unique_id = self::getUniqueId($third_type, $third_data);
        $unionid=self::where('union_id', $third_data['unionid'])->first();
        $user_third=self::where('unique_id', $unique_id)->first();    
            //判断如果有unionid的，小程序授权登录的
            if($unionid){
                $user = User::find($unionid['user_id']);
                if($user){
                    $user->wx=$third_data['unionid'];
                    $res=$user->save();
                }else{
                    $user_data = [
                        'username'     => $unique_id,
                        'nickname'     => $third_data['nickname'],
                        'avatar'       => $third_data['headimgurl'],
                        'wx'           => $third_data['unionid'],
                        'password'     => '',
                        'mobile'       => '',
                        'register_key' => '',
                    ];
                    $user = User::createUser($user_data, true);
                }
            }elseif($user_third){
                $user = User::find($user_third['user_id']);
                if($user){
                    $user->wx=$third_data['unionid'];
                    $res=$user->save();
                    self::where('user_id',$user->id)->update(['union_id'=>$third_data['unionid']]);
                }else{
                    $user_data = [
                        'username'     => $unique_id,
                        'nickname'     => $third_data['nickname'],
                        'avatar'       => $third_data['headimgurl'],
                        'wx'           => $third_data['unionid'],
                        'password'     => '',
                        'mobile'       => '',
                        'register_key' => '',
                    ];
                    $user = User::createUser($user_data, true);
                }

            }else{
                $user_data = [
                    'username'     => $unique_id,
                    'nickname'     => $third_data['nickname'],
                    'avatar'       => $third_data['headimgurl'],
                    'wx'           => $third_data['unionid'],
                    'password'     => '',
                    'mobile'       => '',
                    'register_key' => '',
                ];
                $user = User::createUser($user_data, true);
                $data = [
                    'user_id'    => $user->id,
                    'third_type' => $third_type,
                    'unique_id'  => $unique_id,
                    'third_data' => serialize($third_data),
                    'union_id'   => $third_data['unionid'],
                ];
                $user_third = self::create($data);

                $user->wx=$third_data['unionid'];
                $user->points = $user->points + 10; 
                $user->left_points = $user->left_points + 10;
                $user->save();
                $datas = ['user_id' => $user->id,'type' => '0','point' => 10,'remark' => '首绑微信'];
                UserPoint::create($datas);  
            }
        return true;

    }
}
