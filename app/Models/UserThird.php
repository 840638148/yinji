<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class UserThird extends Model
{

    protected $fillable = [
        'user_id', 'third_type', 'unique_id', 'third_data',
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
        }
        return $unique_id;
    }
    
    public static function login($third_type, $third_data)
    {
        $unique_id = self::getUniqueId($third_type, $third_data);
        $user_third = self::where('third_type', $third_type)
            ->where('unique_id', $unique_id)
            ->first();
        if ($user_third) {

            $user = User::find($user_third['user_id']);
            if ($user) {
                //$user->nickname = $third_data['nickname'];
                //$user->avatar = $third_data['headimgurl'];
                //$user->save();
            } else {
                $user_data = [
                    'username'     => $unique_id,
                    'nickname'     =>  $third_data['nickname'],
                    'avatar'       => $third_data['headimgurl'],
                    'password'     => '',
                    'mobile'       => '',
                    'register_key' => '',
                ];
                $user = User::createUser($user_data, true);
            }
            $user_third->third_data = serialize($third_data);
            $user_third->user_id = $user->id;
            $user_third->save();

        } else {
            $user_data = [
                'username'     => $unique_id,
                'nickname'     =>  $third_data['nickname'],
                'avatar'       => $third_data['headimgurl'],
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
            ];

            $user_third = self::create($data);
        }
        return true;

    }
}
