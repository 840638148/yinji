<?php

namespace App\Models;

use App\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class UserLike extends Model
{


    protected $fillable = [
        'user_id', 'like_type', 'like_id',
    ];

    /**
     * 点赞
     * @param $like_type
     * @param $like_id
     * @return bool
     */
    public static function likeById($like_type, $like_id)
    {
        $user_id = Auth::id() ?? 0;
		
		$result = [
			'status' => false,
			'like_num' => 0,
			'msg' => '',
		];
        if (empty($like_id)) {
			$result['msg'] = '参数错误';
            return $result;
        }
		
		$min_ago = 10;        //点赞间隔
		$max_like_num = 10;  //点赞次数
		$ten_min_ago = date('Y-m-d H:i:s', time() - ($min_ago * 60));  //10分钟之前
        $obj = self::where('user_id', $user_id)
            ->where('like_type', $like_type)
            ->where('like_id', $like_id)
            ->where('created_at', '>', $ten_min_ago)
            ->first();
		//dd($obj);
		$like_count = self::where('user_id', $user_id)
            ->where('like_type', $like_type)
            ->where('like_id', $like_id)
            ->where('created_at', '>', $ten_min_ago)
            ->count();

        if ($like_count >= $max_like_num) {
			$result['msg'] = "最多只能点赞{$max_like_num}次";
            return $result;
		}
		
        switch ($like_type) {
            case '0':
                $like_obj = Article::where('id', $like_id)->first();
                break;
            case '1':
                $like_obj = Designer::where('id', $like_id)->first();
                break;
            case '2':
                $like_obj = News::where('id', $like_id)->first();
                break;
            default :
                $like_obj = Article::where('id', $like_id)->first();
        }
		$result['like_num'] = $like_obj->like_num + 1;
		
		if (empty($user_id)) {
			$sesion_key = "last_like_time_{$like_type}_{$like_id}";
			$now = time();
			$last_like_time = session($sesion_key);
			if (empty($last_like_time)) {
				session([$sesion_key => $now]);
			} else {
				if ($now - $last_like_time < $min_ago * 60) {
					$result['msg'] = "{$min_ago}分钟之内只能点赞一次";
					$result['like_num']--;
					return $result;
				} else {
					session([$sesion_key => $now]);
				}
			}
		}
		
        if ($obj){
			$result['msg'] = "{$min_ago}分钟之内只能点赞一次";
			$result['like_num']--;
            return $result;
        } else {
			if ($user_id) {
				$data = [
					'user_id' => $user_id,
					'like_type' => $like_type,
					'like_id' => $like_id,
				];
				self::create($data);
			}
            
            switch ($like_type) {
                case '0':
                    Article::where('id', $like_id)->increment('like_num');
                    break;
                case '1':
                    Designer::where('id', $like_id)->increment('like_num');
                    break;
                case '2':
                    News::where('id', $like_id)->increment('like_num');
                    break;
                default :
                    Article::where('id', $like_id)->increment('like_num');
            }
            
            $user = User::find($user_id);
            $user->points = $user->points + 1;
            $user->left_points = $user->left_points + 1;
            $user->save();

            $point_log = [
                'user_id' => $user->id,
                'type' => '0',
                'point' => 1,
                'remark' => '点赞',
            ];
            UserPoint::create($point_log);

        }
        
		$result['status'] = true;
		return $result;
    }


    /**
     * 检查用户是否已经点赞
     *
     * @param $like_type
     * @param $like_id
     * @return bool
     */
    public static function isLike($like_type, $like_id)
    {
        $user_id = Auth::id();
        if (empty($like_id) || empty($user_id)) {
            return false;
        }

        $obj = self::where('user_id', $user_id)
            ->where('like_type', $like_type)
            ->where('like_id', $like_id)
            ->first();

        if ($obj){
            return true;
        } else {
            return false;
        }
    }

}
