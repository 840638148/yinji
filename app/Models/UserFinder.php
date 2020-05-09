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
        'user_id', 'user_finder_folder_id', 'photo_url', 'view_time', 'title', 'photo_source','is_sc',
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
     * 发现页-》发现夹
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
 
        // dd($user_finders);

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
             
            foreach($user_finders as $user_finder){
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
                            'user_id'  => @ $user_finder->user_id,
                            'nickname' => @ $user_finder->nickname ?? '',
                            'avatar'   => @ $user_finder->avatar ?? '/img/avatar.png',
                        ]
                    ];
                }
            }
            
        }
		// dd($obj); 
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
                    $tinames=Article::where('id',$user_finder->photo_source)->value('title_name_cn');
                    $obj[$user_finder->user_finder_folder_id]['finder'][] = [
                        'img'   => url($user_finder->photo_url),
                        'url'   => url($user_finder->photo_url),
                        'title' => $user_finder->title ?? '',
                        'tinames' => $tinames,
                        'source' => $user_finder->photo_source,
                    ];
                }
                $obj[$user_finder->user_finder_folder_id]['folder']['total'] ++;
                
            } else {
                // $user_info = User::where($user_finder->user_id);
            	$user_info=User::find($user_finder->user_id);
                // $tiname=Article::where('id',$user_finder->photo_source)->find();find是whereId()和first的简写
                
                // dd($user_info);
                // $tiname=Article::find($user_finder->photo_source);
                $tinames=Article::where('id',$user_finder->photo_source)->value('title_name_cn');
    			// if(is_null($tiname)){
    			// 	continue;
    			// }
                // dd($tiname);


                // $tinames=$tiname->title_name_cn;
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
                        // 'avatar'   =>isset($user_info->avatar) ? $user_info->avatar : '/img/avatar.png',
                        'avatar'   => @$user_info->avatar ?? '/img/avatar.png',
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
    public static function recommendFinders($user_id = 0)
    {   
        $user_id=Auth::id();
        $recommend_finders = [];
        $user_finders = self::
            orderBy('user_finders.updated_at', 'desc')
            ->paginate(30);

        //去除自己的收藏夹
        $user_finders = $user_finders->reject(function ($value) use ($user_id) {
            return $value->user_id == $user_id;
        });
        
        // dd($user_finders);
        $finders = self::formatFinders($user_finders);
        foreach($finders as $k=>$v){
            foreach($v['finder'] as $key=>$val){
                $recommend_finders[] = [
                    'id' => $k,
                    'title' => $val['title'],
                    'img' => $val['img'],
                    'source' => $val['source'],
                    'tinames' => $val['tinames'],
                    'who_find' => [[
                        'userIcon' => $v['who_find']['avatar'],
                        'userName' => $v['who_find']['nickname'],
                        'userNo' => $v['who_find']['user_id'],
                        'folderName' => $v['folder']['name'],
                        'folderNo' => $v['folder']['id'],
                        'source' => $val['source'],
                        'tinames' => $val['tinames'],
                    ]]
                ];         
            }
        }
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
            // ->get();
            ->paginate(20);
        foreach ($user_finders as $finder) {
            $imgs = [];
            $img_finders = UserFinder::where('user_finder_folder_id', $finder->user_finder_folder_id)->limit(4)->get();
            foreach ($img_finders as $img_finder) {
                $imgs[] = [
                    'src' => $img_finder->photo_url,
                    'title' => $img_finder->title,
                ];
            }
            // dump($finder);

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
            ->paginate(20);
            // ->get();
 
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
                'addr' => $user->city ? $user->city :'保密' ,
                'collections' => User::getCollectNum($user->id),
                'fans' => User::getFansNum($user->id),
                'rank' => $rank,
                'vip_level'=>User::getVipLevel($user->id),
                'zhiwei'=>$user->zhiwei ? $user->zhiwei :'其他' ,
            ];
        }
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
        // dd($my_folders);
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
                'vip_level'=>'',
            ],
            'images' => [],
            'article' => '',
            'finder_time' => '',
            'static_url' => '',
        ];
        $folders = UserFinder::where('user_finder_folder_id', $folder_id)->orderBy('created_at', 'desc')->get();
        
    //    dd($folders[0]->folder);
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
                    'vip_level'=>User::getVipLevel($user->id),
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
                
                $articleid=Article::where('id',$folder->photo_source)->value('static_url');
                $articletitle=Article::where('id',$folder->photo_source)->value('title_name_cn');
                // dd($articleid);
                $folder_detail['images'][] = [
                    'photo_url' => $folder->photo_url,
                    'title' => $folder->title,
                    'static_url' => $articleid,
                    'articletitle' => $articletitle,
                ];
            }
        }

        // dd($folder_detail);
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

    /**
     * 发现页->分页
     * @param $request
     * $cates 选项卡分类
     */
    public static function getMoreTuijians(& $request,$cates)
    {   
        // dd($request->all());
        $user_id= Auth::id();
        if($request->content){
            switch ($cates) {
                case 'tjfinder':
                    $finders = self::finsearch($request);
                    $folders = self::getMyFolders($user_id);
                    // $finders=json_decode($finders);
                    $folders=json_decode($folders);
                    $data = ['finders'=>$finders,'cates'=>$cates,'folders'=>$folders,'content'=>$request->content];
                    return $data;
                    break;
                case 'tjfolder':
                    $finders = self::finsearch($request);
                    // $finders=json_decode($finders);
                    $data = ['finders'=>$finders,'cates'=>$cates,'content'=>$request->content];
                    return $data;
                    break;
                case 'tjuser':
                    $finders = self::finsearch($request);
                    // $finders=json_decode($finders);
                    $data = ['finders'=>$finders,'cates'=>$cates,'content'=>$request->content];
                    return $data;
                    break;
            }
        }else{
            switch ($cates) {
                case 'tjfinder':
                    $finders = self::recommendFinders($user_id);
                    $folders = self::getMyFolders($user_id);
                    $finders=json_decode($finders);
                    $folders=json_decode($folders);
                    $data = ['finders'=>$finders,'cates'=>$cates,'folders'=>$folders];
                    return $data;
                    break;
                case 'tjfolder':
                    $finders = self::recommendFolders($user_id);
                    $finders=json_decode($finders);
                    $data = ['finders'=>$finders,'cates'=>$cates];
                    return $data;
                    break;
                case 'tjuser':
                    $finders = self::recommendUsers($user_id);
                    $finders=json_decode($finders);
                    $data = ['finders'=>$finders,'cates'=>$cates];
                    return $data;
                    break;
            }
        }
    }

    
    /**
     * 发现页-》发现点击收藏
     * @param $request
     * @return bool
     */
    public static function findercollect($request)
    {   
        // dd($request->is_sc);
        $is_sc=$request->is_sc;
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
            ->where('is_sc',$is_sc)
            ->first();
        // dd($obj);    
        if ($obj){
            return '你已经发现过了';
        }else{
            $data = [
                'user_id' => $user_id,
                'user_finder_folder_id' => $request->user_finder_folder_id,
                'title' => $request->title ?? '',
                'photo_url' => $photo_url,
                'photo_source' => $request->source,
                'is_sc'=>$is_sc,
            ];
            self::create($data);
            return true;            
        }

    }

    /**
     * 发现页搜索框
     * @param $request
     * 
     */
    public static function finderslistsearch($request)
    {   
        $user_id = Auth::id();
        $content=$request->content;
        if (!Auth::check()) {
            return Output::makeResult($request, null, Error::USER_NOT_LOGIN);
        }

        if($request->cate=='finder'){
            //查询收藏夹名、图片名       
            $favorites=self::leftjoin('user_finder_folders','user_finder_folders.id','=','user_finders.user_finder_folder_id')
                ->leftjoin('articles','articles.id','=','user_finders.photo_source')
                ->leftjoin('users','users.id','=','user_finders.user_id')
                ->select('user_finders.photo_source','articles.title_name_cn','user_finder_folders.name','user_finders.user_finder_folder_id','user_finders.user_id','users.avatar','users.nickname','user_finders.photo_url')
                ->where("user_finder_folders.name","like","%$content%")
                ->orwhere("articles.title_name_cn","like","%$content%")
                ->orwhere("articles.title_designer_cn","like","%$content%")
                ->orwhere("articles.title_intro_cn","like","%$content%")
                ->orwhere("articles.tag_ids","like","%$content%")
                ->orwhere("articles.location_cn","like","%$content%")
                ->get();

            //查询出自己的收藏夹
            $folders=UserFinderFolder::where('user_id',$user_id)->get();

            $arr=[];
            $lists = $favorites->reject(function ($value) use ($user_id) {
                return $value->user_id == $user_id;
            });
            
            foreach($lists as $k=>$favorite){
                $arr[$k]['tuijianfinder']=$favorite;
                $arr[$k]['folder']=$folders;
            }
            // dd($arr);
            $html='';
            $data=[];
            foreach($arr as $favorite){

            $html.='<div class="item discovery-item" style="display:flex">
                        <div class="item_content"> 
                            <img src="'.$favorite["tuijianfinder"]->photo_url.'" class="bg-img" data-id="'.$favorite['tuijianfinder']->user_finder_folder_id.'" id="sourceimg" source="'.$favorite['tuijianfinder']->photo_source.'" /> 
                            <div class="find_title" data-source="'.$favorite['tuijianfinder']->photo_source.'">'.$favorite['tuijianfinder']->title_name_cn.'<a href="javascript:;" class="find_info_more"></a></div>
                            <div class="who_find" style="display:none">
                                <img src="'.$favorite['tuijianfinder']->avatar.'" />
                                <span> <a href="javascript:;">'.$favorite['tuijianfinder']->nickname.'</a> 收藏到 <a href="#">'.$favorite['tuijianfinder']->name.'</a></span>
                            </div>
                            <div class="folder" style="display: none;">
                                <div class="fl folder_bj" style="width:80%">选择文件夹<span class="fr show-more-selcect-item" style="background:url(images/arrow-ico.png); width:36px; height:36px;"></span>
                                </div>
                                <a href="javascript:void(0)" class="Button2 fr add-collection-btn">收藏</a>
                            </div>
                            <div class="folder_box" style="display: none;">   
                                <ul>';
                                foreach($favorite['folder'] as $folder){
                                    $html.='<li><h3>'.$folder['name'].'</h3> <span class="" title=""></span>
                                    <a href="javascript:void(0)" class=" Button2 fr add_finder_btn" data-id="'.$folder['id'].'" data-img="'.$favorite['tuijianfinder']->photo_url.'" data-title="'.$favorite['tuijianfinder']->title.'" data-source="'.$favorite['tuijianfinder']->photo_source.'">收藏</a> </li> ';
                                }
                                $html.='</ul>
                                <a href="javascript:void(0)" class="create create-new-folder" data-type="find" id="sourcea" sourceid="'.$favorite['tuijianfinder']->photo_source.'">创建收藏夹</a>
                            </div>
                        </div>
                    </div>'; 
            }
            // $data['tuijianfinder']=$html;
            return $html;
        }

        if($request->cate=='folder'){
            //查询收藏夹名
            $favorites=UserFinderFolder::leftjoin('users','users.id','=','user_finder_folders.user_id')
                ->select('user_finder_folders.name','user_finder_folders.id','users.avatar','users.username','user_finder_folders.user_id')
                ->where("user_finder_folders.name","like","%$content%")->get();
            
            //查询出自己的收藏夹
            $folders=UserFinderFolder::where('user_id',$user_id)->get();
            

            $arr=[];
            foreach($folders as $folder){
                $favorites = $favorites->reject(function ($value) use ($folder) {
                    // dd($value->id,$folders->id);
                    return $value->id == $folder->id;
                });               
            }
            $lists=$favorites;

            foreach($lists as $k=>$v){
                $lists[$k]['imgall']=self::where('user_finder_folder_id',$v['id'])->select('photo_url','photo_source')->limit(4)->get();
            }
            
            $html='';
            $data=[];
            foreach($lists as $favorite){
                $html.='<div class="item collection-item" data-id="'.$favorite->id.'">
                        <div class="item__content">
                        <ul onclick="location=\'/folderlist/'.$favorite->id.'\'">';
                        foreach($favorite['imgall'] as $val){
                            $html.='<li>
                                    <a href="/folderlist/'.$favorite->id.'">
                                    <img src="'.$val->photo_url.'" alt="'.$favorite->title.'"></a>
                                    </li>';
                        }
                $html.='</ul><div class="find_title"><h2>
                        <a href="folderlist/'.$favorite->id.'">'.$favorite->name.'</a></h2>
                        <a href="javascript:void(0);" class="collect-user-icon">
                        <img id="errimg" src="'.$favorite->avatar.'" onerror="this.onerror=``;this.src=`/img/avatar.png`"></a>
                        </div></div></div>';
            }
            // $data=$html;
            return $html;

        }

        if($request->cate=='user'){
            //查询用户名
           
            $favorites=User::select('users.avatar','users.nickname','users.username','users.id','users.zhiwei','users.city')
            ->where("users.username","like","%$content%")
            ->orwhere("users.nickname","like","%$content%")
            ->get();

            $res=UserFollow::where('user_id',$user_id)->select('user_id','follow_id')->get();

            $ss=$favorites->toArray();
            $gz=$res->toArray();
            foreach ($res as $follow) {
                $favorites=$favorites->reject(function ($val) use ($follow) {
                 return $val->id == $follow->follow_id;
                });
            }
            $lists=$favorites;
            $arr=[];
            $rank = User::isVip($user_id) ? 'VIP' : '普通用户';
            foreach($lists as $k=>$favorite){
                $arr[$k]['tuijianuser']=$favorite;
                $favorite['collections'] = User::getCollectNum($user_id);
                $favorite['fans'] = User::getFansNum($user_id);
                $favorite['rank'] = $rank;
                $favorite['city'] = $favorite->city ? $favorite->city :'保密' ;
                $favorite['vip_level']= User::getVipLevel($favorite->id);
                $favorite['zhiwei'] = $favorite->zhiwei ? $favorite->zhiwei :'其他' ;
            }
            
            $html='';
            $data=[];
            foreach($arr as $favorite){
                $html.='<div class="item">
                <div class="users">
                <div class="border-bottom1">
                <div class="head">
                <img width="100%" height="100%" src="'.$favorite['tuijianuser']->avatar.'" alt="头像"></div>
                <h2>
                '.$favorite['tuijianuser']->nickname.'</h2><div>'.$favorite['tuijianuser']->zhiwei.' - '.$favorite['tuijianuser']->city.'<img class="vipimg" style="width:32px !important;" src="'.$favorite['tuijianuser']->vip_level.'" /></div></div>
                <div class="Statistics">
                <ul>
                <li><span>'.$favorite['tuijianuser']->collections.'</span>收藏</li>
                <li><span>'.$favorite['tuijianuser']->fans.'</span>粉丝</li></ul>
                </div><a class="Button3 user_follow_btn" data-id="'.$favorite['tuijianuser']->id.'">关注</a></div></div>';
            }
            // $data['tuijianuser']=$html;
            return $html;
        }

    }


    public static function finsearch($request)
    {   
        $user_id = Auth::id();
        // dd($request->all());
        $content=$request->content;
        if (!Auth::check()) {
            return Output::makeResult($request, null, Error::USER_NOT_LOGIN);
        }

        if($request->cate=='tjfinder'){
            //查询收藏夹名、图片名       
            $favorites=self::leftjoin('user_finder_folders','user_finder_folders.id','=','user_finders.user_finder_folder_id')
                ->leftjoin('articles','articles.id','=','user_finders.photo_source')
                ->leftjoin('users','users.id','=','user_finders.user_id')
                ->select('user_finders.photo_source','articles.title_name_cn','user_finder_folders.name','user_finders.user_finder_folder_id','user_finders.user_id','users.avatar','users.nickname','user_finders.photo_url')
                ->where("user_finder_folders.name","like","%$content%")
                ->orwhere("articles.title_name_cn","like","%$content%")
                ->orwhere("articles.title_designer_cn","like","%$content%")
                ->orwhere("articles.title_intro_cn","like","%$content%")
                ->orwhere("articles.tag_ids","like","%$content%")
                ->orwhere("articles.location_cn","like","%$content%")
                ->paginate(15);
            // dd($favorites->toArray());
            //查询出自己的收藏夹
            $folders=UserFinderFolder::where('user_id',$user_id)->get();

            $arr=[];
            $lists = $favorites->reject(function ($value) use ($user_id) {
                return $value->user_id == $user_id;
            });
            
            foreach($lists as $k=>$favorite){
                $arr[$k]['tuijianfinder']=$favorite;
                $arr[$k]['folder']=$folders;
            }
            
            $html='';
            $data=[];
            foreach($arr as $favorite){
                // dd($favorite['tuijianfinder']);
            $html.='<div class="item discovery-item" style="display:flex">
                        <div class="item_content"> 
                            <img src="'.$favorite["tuijianfinder"]->photo_url.'" class="bg-img" data-id="'.$favorite['tuijianfinder']->user_finder_folder_id.'" id="sourceimg" source="'.$favorite['tuijianfinder']->photo_source.'" /> 
                            <div class="find_title" data-source="'.$favorite['tuijianfinder']->photo_source.'">'.$favorite['tuijianfinder']->title_name_cn.'<a href="javascript:;" class="find_info_more"></a></div>
                            <div class="who_find" style="display:none">
                                <img src="'.$favorite['tuijianfinder']->avatar.'" />
                                <span> <a href="javascript:;">'.$favorite['tuijianfinder']->nickname.'</a> 收藏到 <a href="#">'.$favorite['tuijianfinder']->name.'</a></span>
                            </div>
                            <div class="folder" style="display: none;">
                                <div class="fl folder_bj" style="width:80%">选择文件夹<span class="fr show-more-selcect-item" style="background:url(images/arrow-ico.png); width:36px; height:36px;"></span>
                                </div>
                                <a href="javascript:void(0)" class="Button2 fr add-collection-btn">收藏</a>
                            </div>
                            <div class="folder_box" style="display: none;">   
                                <ul>';
                                foreach($favorite['folder'] as $folder){
                                    $html.='<li><h3>'.$folder['name'].'</h3> <span class="" title=""></span>
                                    <a href="javascript:void(0)" class=" Button2 fr add_finder_btn" data-id="'.$folder['id'].'" data-img="'.$favorite['tuijianfinder']->photo_url.'" data-title="'.$favorite['tuijianfinder']->title.'" data-source="'.$favorite['tuijianfinder']->photo_source.'">收藏</a> </li> ';
                                }
                                $html.='</ul>
                                <a href="javascript:void(0)" class="create create-new-folder" data-type="find" id="sourcea" sourceid="'.$favorite['tuijianfinder']->photo_source.'">创建收藏夹</a>
                            </div>
                        </div>
                    </div>'; 
            }
            // $data['tuijianfinder']=$html;
            // $data[]=$html;
            // dd($html);
            return $html;
        }

        if($request->cate=='tjfolder'){
            //查询收藏夹名
            $favorites=UserFinderFolder::leftjoin('users','users.id','=','user_finder_folders.user_id')
                ->select('user_finder_folders.name','user_finder_folders.id','users.avatar','users.username','user_finder_folders.user_id')
                ->where("user_finder_folders.name","like","%$content%")->paginate(15);
            
            //查询出自己的收藏夹
            $folders=UserFinderFolder::where('user_id',$user_id)->get();
            

            $arr=[];
            foreach($folders as $folder){
                $favorites = $favorites->reject(function ($value) use ($folder) {
                    // dd($value->id,$folders->id);
                    return $value->id == $folder->id;
                });               
            }
            $lists=$favorites;

            foreach($lists as $k=>$v){
                $lists[$k]['imgall']=self::where('user_finder_folder_id',$v['id'])->select('photo_url','photo_source')->limit(4)->get();
            }
            
            $html='';
            $data=[];
            foreach($lists as $favorite){
                $html.='<div class="item collection-item" data-id="'.$favorite->id.'">
                        <div class="item__content">
                        <ul onclick="location=\'/folderlist/'.$favorite->id.'\'">';
                        foreach($favorite['imgall'] as $val){
                            $html.='<li>
                                    <a href="/folderlist/'.$favorite->id.'">
                                    <img src="'.$val->photo_url.'" alt="'.$favorite->title.'"></a>
                                    </li>';
                        }
                $html.='</ul><div class="find_title"><h2>
                        <a href="folderlist/'.$favorite->id.'">'.$favorite->name.'</a></h2>
                        <a href="javascript:void(0);" class="collect-user-icon">
                        <img id="errimg" src="'.$favorite->avatar.'" onerror="this.onerror=``;this.src=`/img/avatar.png`"></a>
                        </div></div></div>';
            }
            // $data=$html;
            return $html;

        }

        if($request->cate=='tjuser'){
            //查询用户名
           
            $favorites=User::select('users.avatar','users.nickname','users.username','users.id')
            ->where("users.username","like","%$content%")
            ->orwhere("users.nickname","like","%$content%")
            ->paginate(10);
        // dd($favorites);
            $res=UserFollow::where('user_id',$user_id)->select('user_id','follow_id')->get();

            $ss=$favorites->toArray();
            $gz=$res->toArray();
            foreach ($res as $follow) {
                $favorites=$favorites->reject(function ($val) use ($follow) {
                 return $val->id == $follow->follow_id;
                });
            }
            $lists=$favorites;
            $arr=[];
            $rank = User::isVip($user_id) ? 'VIP' : '普通用户';
            foreach($lists as $k=>$favorite){
                $arr[$k]['tuijianuser']=$favorite;
                $favorite['collections'] = User::getCollectNum($user_id);
                $favorite['fans'] = User::getFansNum($user_id);
                $favorite['rank'] = $rank;
                $favorite['city'] = $favorite->city ? $favorite->city :'保密' ;
                $favorite['vip_level']= User::getVipLevel($favorite->id);
                $favorite['zhiwei'] = $favorite->zhiwei ? $favorite->zhiwei :'其他' ;
            }
            
            $html='';
            $data=[];
            foreach($arr as $favorite){
                $html.='<div class="item">
                <div class="users">
                <div class="border-bottom1">
                <div class="head">
                <img width="100%" height="100%" src="'.$favorite['tuijianuser']->avatar.'" alt="头像"></div>
                <h2>
                <h2>
                '.mb_substr($favorite['tuijianuser']->nickname,0,10).'</h2><div>'.$favorite['tuijianuser']->zhiwei.' - '.$favorite['tuijianuser']->city.'<img class="vipimg" style="width:32px !important;" src="'.$favorite['tuijianuser']->vip_level.'" /></div></div>
                <div class="Statistics">
                <ul>
                <li><span>'.$favorite['tuijianuser']->collections.'</span>收藏</li>
                <li><span>'.$favorite['tuijianuser']->fans.'</span>粉丝</li></ul>
                </div><a class="Button3 user_follow_btn" data-id="'.$favorite['tuijianuser']->id.'">关注</a></div></div>';
            }
            // $data['tuijianuser']=$html;
            return $html;
        }

    }


}
