<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Http\Output;
use App\Http\Error;

class UserCollect extends Model
{
    protected $fillable = [//为了防止用户传入奇怪的参数  fillable为白名单，表示该字段可被批量赋值；guarded为黑名单，表示该字段不可被批量赋值。
        'user_id', 'collect_type', 'user_collect_folder_id', 'collect_id','is_sc', 'photourl'
    ];

    public function folder()
    {
        return $this->belongsTo(UserCollectFolder::class, 'user_collect_folder_id', 'id');
    }

    /**
     * 文章详情点击收藏按钮进行收藏
     * @param $collect_type
     * @param $request
     * @return bool
     */
    public static function collectById($collect_type, &$request)
    {
        $user_id = Auth::id();
        if (empty($request->collect_id) || empty($user_id)) {
            return '未登录或收藏ID为空';
        }

        if (empty($request->folder_name) && empty($request->folder_id)) {
            return '请选择文件夹或新建文件夹';
        }

        if ($request->folder_id) { 
            $obj = self::where('user_id', $user_id)
                ->where('collect_type', $collect_type)
                ->where('user_collect_folder_id', $request->folder_id)
                ->where('collect_id', $request->collect_id)
                ->first();
			//通过连表左查询查出已经收藏的
			// $issc=UserFinder::where('user_finders.user_id',$user_id)->leftjoin('user_finder_folders','user_finder_folders.id','user_finders.user_finder_folder_id')->get()->toArray();
                
            if ($obj){
               //return '你已经收藏过了';
               return Output::makeResult($request, null, Error::SYSTEM_ERROR, '你已经收藏过了');
            }   
            $data = [
                'user_id' => $user_id,
                'collect_type' => $collect_type,
                'user_collect_folder_id' => $request->folder_id,
                'collect_id' => $request->collect_id,
            ];
            self::create($data);
        } else {
            $folder_data = [
                'user_id' => $user_id,
                'name' => $request->folder_name,
            ];
            $user_collect_folder = UserCollectFolder::create($folder_data);
            $data = [
                'user_id' => $user_id,
                'collect_type' => $collect_type,
                'user_collect_folder_id' => $user_collect_folder->id,
                'collect_id' => $request->collect_id,
                // 'is_sc' => '0',
            ];
            self::create($data);

        }
        if ('0' == $collect_type) {
            Article::where('id', $request->collect_id)->increment('favorite_num');
        } else {
            Designer::where('id', $request->collect_id)->increment('favorite_num');
        }

        return true;
    }


	 /**
     * 发现->推荐收藏->点击收藏按钮进行收藏
     * @param $collect_type
     * @param $request
     * @return bool
     */
    public static function foldercollectById($collect_type, &$request)
    {
        $user_id = Auth::id();
        if (empty($request->collect_id) || empty($user_id)) {
            return '未登录或收藏ID为空';
        }

        // if (empty($request->folder_name) && empty($request->folder_id)) {
        //     return '请选择文件夹或新建文件夹';
        // }

        if ($request->folder_id) { 
            $obj = self::where('user_id', $user_id)
                ->where('collect_type', $collect_type)
                ->where('user_collect_folder_id', $request->folder_id)
                ->where('collect_id', $request->collect_id)
                ->where('photourl', $request->tpsrc)
                ->first();

            if ($obj){
               return '你已经收藏过了';
               //return Output::makeResult($request, null,Error::SYSTEM_ERROR,'你已经收藏过了');
            }   
            $data = [
                'user_id' => $user_id,
                'collect_type' => $collect_type,
                'user_collect_folder_id' => $request->folder_id,
                'collect_id' => $request->collect_id,
                'photourl' => $request->tpsrc,
                'is_sc' => 1,
            ];
            self::create($data);
        } else {
            $folder_data = [
                'user_id' => $user_id,
                'name' => $request->folder_name,
            ];
            $user_collect_folder = UserCollectFolder::create($folder_data);
            $data = [
                'user_id' => $user_id,
                'collect_type' => $collect_type,
                'user_collect_folder_id' => $user_collect_folder->id,
                'collect_id' => $request->collect_id,
                'photourl' => $request->tpsrc,
                'is_sc' => 1,
            ];
            self::create($data);

        }
        if ('0' == $collect_type) {
            Article::where('id', $request->collect_id)->increment('favorite_num');
        } else {
            Designer::where('id', $request->collect_id)->increment('favorite_num');
        }

        return true;
    }




	



    /**
     * 是否已经收藏
     * @param $article_id
     * @return bool
     */
    public static function isCollect($article_id)
    {
        $user_id = Auth::id();
        if (empty($article_id) || empty($user_id)) {
            return false;
        }
        $obj = self::where('user_id', $user_id)
            ->where('collect_type', '0')
            ->where('collect_id', $article_id)
            ->first();

        if ($obj){
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取收藏
     * @param $user_id
     * @return string
     */
    public static function getCollects($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return '用户不存在';
        }

        $user_collects = self::where('user_id', $user_id)
            ->where('collect_type', '0')
            ->orderBy('created_at', 'desc')
            ->get();

        $my_collects = json_decode(UserCollect::getMyCollectolders($user_id));
        // dd($my_collects);
        return self::formatCollectsAll($user_collects,$my_collects);
        
    }

    public static function getMyCollectolders($user_id = 0)
    {
        $my_collects = [];
        $folders = UserCollectFolder::where('user_id', $user_id)->get();
        // dd($folders);
        foreach ($folders as $folder) {
            $my_collects[] = [
                'id' => $folder->id,
                'title' => $folder->name,
                'type' => ($folder->is_open == 1) ? '' : 'private',
                'typeText' => ($folder->is_open == 1) ? '' : '不公开',
            ];
        }

        return json_encode($my_collects);
    }

    /**
     * 格式化所有收藏数据
     *
     * @param $user_collects
     * @return array
     */
    public static function formatCollectsAll(& $user_collects,& $my_collects){
        $obj = self::formatCollects($user_collects);
		

        echo("<script>console.log(".json_encode($my_collects).");</script>");
        echo("<script>console.log(".json_encode($obj).");</script>");
        foreach ($my_collects as $my_collect) {
        	// dump($my_collect);
            $is_have = false;
            foreach ($obj as $item) {
                if($my_collect->id == $item['folder']['id']){
                    $is_have = true;
                }
                // dump($item['folder']['id']);	
            }
            
            if(!$is_have){
                $obj[$my_collect->id] = [
                    'folder' => [
                        'id'          => $my_collect->id,
                        'name'        => $my_collect->title,
                        'total' => 0,
                    ],
                    'collect' => [
                        [
                            'img'   => '',
                            'url'   => '',
                            'title' => '',
                            'source' => '',
                        ]
                    ],
                    'who_find' => [
                        'user_id'  => @$user_collects[0]->user_id,
                        'nickname' => @$user_collects[0]->nickname ?? '',
                        'avatar'   => @$user_collects[0]->avatar ?? '/img/avatar.png',
                    ]
                ];
            }
        }
        return $obj;
    }

    /**
     * 格式化收藏数据
     *
     * @param $user_collects
     * @return array
     */
    public static function formatCollects(& $user_collects)
    {
        $obj = [];
        foreach ($user_collects as $user_collect) {
            // dump($user_collect);
            if (empty($user_collect)) {
                continue;
            }
            if (isset($obj[$user_collect->user_collect_folder_id])) {
                if (count($obj[$user_collect->user_collect_folder_id]['collect']) < 4) {
                    if ('0' == $user_collect->collect_type) {
                        $collect_obj = Article::find($user_collect->collect_id);
                        
						if (empty($collect_obj)) {
							continue;
						}
                        $img = get_article_thum($collect_obj);
                        if ($collect_obj->static_url) {
                            $url = url('/article/' . $collect_obj->static_url);
                        } else {
                            $url = url('/article/detail/' . $collect_obj->id);
                        }
                        $title = get_article_title($collect_obj);
                    } else {
                        $collect_obj = Designer::find($user_collect->collect_id);
						if (empty($collect_obj)) {
							continue;
						}
                        $img = get_designer_thum($collect_obj);
                        if ($collect_obj->static_url) {
                            $url = url('/designer/' . $collect_obj->static_url);
                        } else {
                            $url = url('/designer/detail/' . $collect_obj->id);
                        }
                        $title = get_designer_title($collect_obj);
                    }
                    $obj[$user_collect->user_collect_folder_id]['collect'][] = [
                        'img'   => $img,
                        'url'   => $url,
                        'title' => $title,
                        'user_collect_folder_id' => $user_collect->user_collect_folder_id,
                    ];
                }
                $obj[$user_collect->user_collect_folder_id]['folder']['total'] ++;
            } else {
                $user_info = User::where('id',$user_collect->user_id)->get()->first();
                // dd($user_info);
                if (0 == $user_collect->collect_type) {
                    $collect_obj = Article::find($user_collect->collect_id);

                    if (empty($collect_obj)) {
                        continue;
                    }else{
                        $img = get_article_thum($collect_obj);
                        if ($collect_obj->static_url) {
                        $url = url('/article/' . $collect_obj->static_url);
                        } else {
                            $url = url('/article/detail/' . $collect_obj->id);
                        }
                        $title = get_article_title($collect_obj);
                    }

                } else {
                    $collect_obj = Designer::find($user_collect->collect_id);
						if (empty($collect_obj)) {
                            continue;
						}else{
                            $img = get_designer_thum($collect_obj);
                            if ($collect_obj->static_url) {
                                $url = url('/designer/' . $collect_obj->static_url);
                            } else {
                                $url = url('/designer/detail/' . $collect_obj->id);
                            }
                            $title = get_designer_title($collect_obj);
                        }

                }



                $obj[$user_collect->user_collect_folder_id] = [
                    'folder' => [
                        'id'    => @$user_collect->folder->id,
                        'name'  => @$user_collect->folder->name,
                        'total' => 1,
                        'user_collect_folder_id' => $user_collect->user_collect_folder_id,
                    ],
                    'collect' => [
                        [
                            'img'   => $img,
                            'url'   => $url,
                            'title' => $title,
                            'user_collect_folder_id' => $user_collect->user_collect_folder_id,
                        ]
                    ],
                    'who_find' => [
                        'user_id'  => $user_collect->user_id,
                        'nickname' => $user_info->nickname,
                        'avatar'   => $user_info->avatar ?? '/img/avatar.png',
                    ]
                ];
            }
        }
        return $obj;
    }

    
    /**
     * 获取收藏详情
     * @param $user_id
     * @return string
     */
    public static function getCollectDetails($user_id, $id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return '用户不存在';
        }

        $user_collects = self::where('user_id', $user_id)
            ->where('user_collect_folder_id', $id)
            ->where('collect_type', '0')
            ->orderBy('created_at', 'desc')
            ->get();
   
        $article_ids = [];

        foreach ($user_collects as $collect) { 
        	// dd($collect->folder);
            if ('1' == $collect->folder->is_open) {
                $article_ids[] = $collect->collect_id;
            }else{
            	$article_ids[] = $collect->collect_id;
            }
			
        }
        
        $articles = Article::whereIn('id', $article_ids)->get();
       
        return $articles;
    }

    
}

