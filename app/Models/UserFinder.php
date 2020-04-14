<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\Article;
use App\Models\UserCollect;
use App\Http\Output;
use App\Http\Error;

class UserFinder extends Model
{

    protected $fillable = [
        'user_id', 'user_finder_folder_id', 'photo_url', 'view_time', 'title', 'photo_source',
    ];

    public function folder()
    {
        return $this->belongsTo(UserFinderFolder::class, 'user_finder_folder_id', 'id');
    }

    /**
     * 发现
     * @param $request
     * @return bool
     */
    public static function finderByUrl($request)
    {
        $user_id = Auth::id();
        if (empty($request->photo_url) || empty($user_id)) {
            return '未登录或URL为空';
        }

        if (empty($request->user_finder_folder_id)) {
            return '请选择文件夹';
        }
		
		$start = strpos($request->photo_url, '/photo/images/');
		if (false === $start) {
			$photo_url = $request->photo_url;
		} else {
			$photo_url = substr($request->photo_url, $start);
		}
		
		
		//查询文章详情->点击收藏后的是否收藏
        $obj = self::where('user_id', $user_id)
            ->where('user_finder_folder_id', $request->user_finder_folder_id)
            ->where('photo_url', $photo_url)
            ->first();
        if ($obj){
            return '你已经发现过了';
            // return Output::makeResult($request, null, Error::SYSTEM_ERROR, '你已经收藏过了');
        }
        $data = [
            'user_id' => $user_id,
            'user_finder_folder_id' => $request->user_finder_folder_id,
            'title' => $request->title ?? '',
            'photo_url' => $photo_url,
            'photo_source' => $request->photo_source,
        ];
        self::create($data);


        return true;
    }


    /**
     * 获取用户自己的发现
     * @param $user_id
     * @return string
     */
    public static function getFinders($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return '用户不存在';
        }

        $user_finders = self::where('user_id', $user_id)
            ->orderBy('created_at', 'desc')
            ->get();
 
        
        $my_folders = json_decode(UserFinder::getMyFolders($user_id));
	 
        return self::formatFindersAll($user_finders,$my_folders);
    }

    public static function formatFindersAll(& $user_finders,& $my_folders)
    {
    	
        $obj = self::formatFinders($user_finders);
        
        foreach ($my_folders as $my_folder) {
            $is_have = false;
            foreach ($obj as $item) {
                if($my_folder->id == $item['folder']['id']){
                    $is_have = true;
                }
            }
             
            if(!$is_have){
                $obj[$my_folder->id] = [
                    'folder' => [
                        'id'          => $my_folder->id,
                        'name'        => $my_folder->title,
                        'total' => 0,
                    ],
                    'finder' => [
                        [
                            'img'   => '',
                            'url'   => '',
                            'title' => '',
                            'source' => '',
                        ]
                    ],
                    'who_find' => [
                        'user_id'  => @ $user_finders[0]->user_id,
                        'nickname' => @ $user_finders[0]->nickname ?? '',
                        'avatar'   => @ $user_finders[0]->avatar ?? '/img/avatar.png',
                    ]
                ];
            }
        }
		
        return $obj;
    }

    public static function formatFinders(& $user_finders)//& xxx是引用这个变量
    {
    
        $obj = [];
        foreach ($user_finders as $user_key => $user_finder) {
        	
            if (!is_object($user_finder)) {
                unset($user_finders[$user_key]);
                continue;
            }
           
            if (isset($obj[$user_finder->user_finder_folder_id])) {	
            	
                if (count($obj[$user_finder->user_finder_folder_id]['finder']) < 4) {
                    $obj[$user_finder->user_finder_folder_id]['finder'][] = [
                        'img'   => url($user_finder->photo_url),
                        'url'   => url($user_finder->photo_url),
                        'title' => $user_finder->title ?? '',
                    ];
                }
                $obj[$user_finder->user_finder_folder_id]['folder']['total'] ++;
                
            } else {
                // $user_info = User::where($user_finder->user_id);
            	$user_info=User::find($user_finder->user_id);
                // $tiname=Article::where('id',$user_finder->photo_source)->find();find是whereId()和first的简写
                
                // dd($user_info);
                $tiname=Article::find($user_finder->photo_source);
    			if(is_null($tiname)){
    				continue;
    			}

                $tinames=$tiname->title_designer_cn.' | '.$tiname->title_intro_cn;
                $tinames=mb_substr($tinames,'0','21');
                $obj[$user_finder->user_finder_folder_id] = [
                    'folder' => [
                        'id'          => $user_finder->folder->id,  
                        'name'        => $user_finder->folder->name,
                        'total' => 1,
                        'tinames' => $tinames,
                        'source' => $user_finder->photo_source,
                    ],
                    'finder' => [
                        [
                            'img'   => url($user_finder->photo_url),
                            'url'   => url($user_finder->photo_url),
                            'title' => $user_finder->title,
                            'source' => $user_finder->photo_source,
                            'tinames' => $tinames,
                        ]
                    ],
                    'who_find' => [
                        'user_id'  => $user_finder->user_id,
                        'nickname' => @$user_info->nickname ?? '',
                        'avatar'   =>isset($user_info->avatar) ? $user_info->avatar : '/img/avatar.png',
                        // 'avatar'   => @$user_info->avatar ?? '/img/avatar.png',
                        'tinames' => $tinames,
                        'source' => $user_finder->photo_source,
                    ]
                ];
           
            }

        }
        // dump($obj);die;
        return $obj;
        
    }

    /**
     * 获取推荐的发现
     * @param $user_id
     * @return string
     */
    public static function recommendFinders($user_id = null)
    {
        $recommend_finders = [];
        $user_finders = self::orderBy('created_at', 'desc')
            ->groupBy('photo_url')
            // ->limit(100)
            ->get();
        
        $finders = self::formatFinders($user_finders);
		// dd($finders);
        foreach ($finders as $finder) {
            $recommend_finders[] = [
                'id' => $finder['folder']['id'],
                'title' => $finder['finder'][0]['title'],
                'img' => $finder['finder'][0]['img'],
                'source' => $finder['finder'][0]['source'],
                'tinames' => $finder['finder'][0]['tinames'],
                'who_find' => [[
                    'userIcon' => $finder['who_find']['avatar'],
                    'userName' => $finder['who_find']['nickname'],
                    'userNo' => $finder['who_find']['user_id'],
                    'folderName' => $finder['folder']['name'],
                    'folderNo' => $finder['folder']['id'],
                    'source' => $finder['finder'][0]['source'],
                	'tinames' => $finder['finder'][0]['tinames'],
                ]]
            ];
        }
        
	     //dd($recommend_finders);  
        return json_encode($recommend_finders);
    }

    /**
     * 获取推荐的收藏夹
     * @param $user_id
     * @return string
     */
    public static function recommendFolders($user_id = 0)
    {
        $recommend_folders = [];

        $user_finders = UserFinder::where('user_id', '!=', $user_id)
            ->orderBy('created_at', 'desc')
            ->groupBy('user_finder_folder_id')
            // ->limit(20)
            ->get();
        foreach ($user_finders as $finder) {
            $imgs = [];
            $img_finders = UserFinder::where('user_finder_folder_id', $finder->user_finder_folder_id)->limit(4)->get();
            foreach ($img_finders as $img_finder) {
                $imgs[] = [
                    'src' => $img_finder->photo_url,
                    'title' => $img_finder->title,
                ];
            }


            $user_info = User::find($finder->user_id);
            $recommend_folders[] = [
                'id' => $finder->folder->id,
                'title' => $finder->folder->name,
                'imgs' => $imgs,
                'who_find' => [[
                    'userIcon' => @$user_info->avatar ?? '/img/avatar.png',
                    'userName' => @$user_info->nickname,
                    'userNo' => @$user_info->id,
                    'folderName' => $finder->folder->name,
                    'folderNo' => $finder->folder->id,
                    'source' => $finder['finder'][0]['source'],
                	'tinames' => $finder['finder'][0]['tinames'],
                ]]

            ];
        }
		// dd($recommend_folders);
        return json_encode($recommend_folders);
    }

    /**
     * 获取推荐的用户
     * @param $user_id
     * @return string
     */
    public static function recommendUsers($user_id = 0)
    {
        $already = UserFollow::where('user_id', $user_id)->get();
        
        $follow_ids = [];
        array_push($follow_ids, $user_id);
        foreach ($already as $follow) {
            $follow_ids[] = $follow->follow_id;
        }

        $users = User::whereNotIn('id', $follow_ids)
            // ->limit(20)
            ->orderBy('view_num', 'desc')
            ->orderBy('level', 'desc')
            ->get();
 
        $recommend_users = [];
        foreach ($users as $user) {
            $sex = '保密';
            switch ($user->sex) {
                case '1':
                    $sex = '男';
                    break;
                case '2':
                    $sex = '女';
                    break;
            }
            $rank = User::isVip($user->id) ? 'VIP' : '普通用户';
            $recommend_users[] = [
                'id' => $user->id,
                'icon' => $user->avatar,
                'name' => $user->nickname,
                'gender' => $sex,
                'addr' => $user->city,
                'collections' => User::getCollectNum($user->id),
                'fans' => User::getFansNum($user->id),
                'rank' => $rank,

            ];
        }
        // $recommend_users=array_column($recommend_users,'sort');
		// dd($recommend_users);
        return json_encode($recommend_users);
    }
    
    public static function getMyFolders($user_id = 0)
    {
        $my_folders = [];
        $folders = UserFinderFolder::where('user_id', $user_id)->get();
        
        foreach ($folders as $folder) {
            $my_folders[] = [
                'id' => $folder->id,
                'title' => $folder->name,
                'type' => ($folder->is_open == 1) ? '' : 'private',
                'typeText' => ($folder->is_open == 1) ? '' : '不公开',
           
            ];
        }

        return json_encode($my_folders);
    }

    public static function getFolderDetail($folder_id)
    {
    	
        $folder_detail = [
            'folder' => [
                'id' => '',
                'name' => '',
            ],
            'user'   => [
                'id' => '',
                'nickname' => '',
                'avatar' => '/img/avatar.png',
            ],
            'images' => [],
            'article' => '',
            'finder_time' => '',
        ];
        $folders = UserFinder::where('user_finder_folder_id', $folder_id)->orderBy('created_at', 'desc')->get();
        
       //dd($folders);
        if ($folders) {

            $folder_detail['folder'] = [
                'id' => $folders[0]->user_finder_folder_id,
                'name' => $folders[0]->folder->name,
            ];

            $user = User::find($folders[0]->user_id);
            if ($user) {
                $folder_detail['user'] = [
                    'id' => $user->id,
                    'nickname' => $user->nickname,
                    'avatar' => $user->avatar ?? '/img/avatar.png',
                ];
            }

            $folder_detail['article'] = Article::find($folders[0]->photo_source);
            $folder_detail['finder_time'] = $folders[0]->created_at;

            if (Auth::check()) {
                $folder_detail['user_finder_folders'] = UserFinderFolder::getSelectOptionsByUserId(Auth::id());
                $folder_detail['user_collect_folders'] = UserCollectFolder::getSelectOptionsByUserId(Auth::id());
            } else {
                $folder_detail['user_collect_folders'] = [];
                $folder_detail['user_finder_folders'] = [];
            }

            foreach ($folders as $folder) {
                $folder_detail['images'][] = [
                    'photo_url' => $folder->photo_url,
                    'title' => $folder->title,
                ];
            }
        }


        return $folder_detail;
    }

    
    /**
     * 获取收藏详情
     * @param $user_id
     * @return string
     */
    public static function getFinderDetails($user_id, $id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return '用户不存在';
        }

        $user_finders = self::where('user_id', $user_id)
            ->where('user_finder_folder_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();
        return $user_finders;
    }
    
}
