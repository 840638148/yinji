<?php

namespace App\Http\Controllers;

use App\Http\Error;
use App\Http\Output;
use App\Models\ArticleComment;
use App\Models\UserCollect;
use App\Models\UserCollectFolder;
use App\Models\UserFinderFolder;
use App\Models\UserFinder;
use App\Models\UserLike;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use App\Models\Popularize;
use App\Models\ArticleTag;
use App\Models\ArticleCategory;
use App\Models\Article;
use App\Models\Designer;
use App\Models\UserPoint;
use App\Models\Topic;
use App\User;
use DB;
use App\Models\UserDownRecord;
use App\Models\UserExchangeRecord;
use Illuminate\Support\Facades\Auth;
use App\Models\VipPrice;
use App\Models\Photographer;
use App\Models\Dc;
use App\Models\Loupan;

use Illuminate\Support\Collection;
class ArticleController extends Controller
{
    /**
     * 家具
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function interior(Request $request)
    {
        $where_category = [
            'parent_id' => '2'
        ];

        $category_ids = [];
        $categories = ArticleCategory::select('id')
            ->where('parent_id', 2)
            ->where('display', '0')
            ->get();
        foreach ($categories as $category) {
            $category_ids[] = $category->id;
        }
        $current_category = null;
        $type = "interior";
        return $this->doLists($request, $type, $where_category, $category_ids, $current_category);
    }

    
    /**
     * 家具分页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function interiorAjax(Request $request)
    {
        $where_category = [
            'parent_id' => '2'
        ];
        // dd($request->all());
        $category_ids = [];
        $categories = ArticleCategory::select('id')
            ->where('parent_id', 2)
            ->where('display', '0')
            ->get();
        foreach ($categories as $category) {
            $category_ids[] = $category->id;
        }
        $more_articles = Article::getMoreArticles($request, $category_ids);
        // dd($more_articles);
        return Output::makeResult($request, $more_articles);
    }

    /**
     * 家具分页带分类
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function interiorCategoryAjax(Request $request, $id)
    {   
        
        $where_category = [
            'parent_id' => '2'
        ];

        $category_ids = [$id];
        $more_articles = Article::getMoreArticles($request, $category_ids);
        return Output::makeResult($request, $more_articles);
    }

    /**
     * 建筑
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function archs(Request $request)
    {
        $where_category = [
            'parent_id' => '1'
        ];

        $category_ids = [];
        $categories = ArticleCategory::select('id')
            ->where('parent_id', 1)
            ->where('display', '0')
            ->get();
        foreach ($categories as $category) {
            $category_ids[] = $category->id;
        }
        $current_category = null;
        $type = "archs";

        return $this->doLists($request, $type, $where_category, $category_ids, $current_category);
    }

    /**
     * 建筑分页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function archsAjax(Request $request)
    {
        $where_category = [
            'parent_id' => '1'
        ];

        $category_ids = [];
        $categories = ArticleCategory::select('id')
            ->where('parent_id', 1)
            ->where('display', '0')
            ->get();
        foreach ($categories as $category) {
            $category_ids[] = $category->id;
        }
        $more_articles = Article::getMoreArticles($request, $category_ids);
        return Output::makeResult($request, $more_articles);
    }


    /**
     * 建筑更多带分页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function archsCategoryAjax(Request $request, $id)
    {
        $where_category = [
            'parent_id' => '1'
        ];

        $category_ids = [$id];

        $more_articles = Article::getMoreArticles($request, $category_ids);
        return Output::makeResult($request, $more_articles);
    }


    /**
     * 地产
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function develop(Request $request)
    {
        $where_category = [
            'parent_id' => '19'
        ];

        $category_ids = [];
        $categories = ArticleCategory::select('id')
            ->where('parent_id', 19)
            ->where('display', '0')
            ->get();
        foreach ($categories as $category) {
            $category_ids[] = $category->id;
        }
        $current_category = null;
        $type = "estate";

        return $this->doLists($request, $type, $where_category, $category_ids, $current_category);
    }

    /**
     * 地产分页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function developAjax(Request $request)
    {
        $where_category = [
            'parent_id' => '19'
        ];

        $category_ids = [];
        $categories = ArticleCategory::select('id')
            ->where('parent_id', 19)
            ->where('display', '0')
            ->get();
        foreach ($categories as $category) {
            $category_ids[] = $category->id;
        }
        $more_articles = Article::getMoreArticles($request, $category_ids);
        return Output::makeResult($request, $more_articles);
    }


    /**
     * 地产更多带分页
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function developCategoryAjax(Request $request, $id)
    {
        $where_category = [
            'parent_id' => '19'
        ];

        $category_ids = [$id];

        $more_articles = Article::getMoreArticles($request, $category_ids);
        return Output::makeResult($request, $more_articles);
    }



    /**
     * 所有文章列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function lists(Request $request)
    {
        return $this->doLists($request, 'article');
    }


    /**
     * 根据条件显示文章列表
     * @param Request $request
     * @param null $type
     * @param null $where_category
     * @param null $category_ids
     * @param null $current_category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function doLists(Request $request, $type = null, $where_category = null, $category_ids = null, $current_category = null)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';

        if ($where_category) {
            $categories = ArticleCategory::where($where_category)->where('display', '0')->get();
        } else {
            $categories = ArticleCategory::where('display', '0')->get();
        }

        if ($request->isMethod('post') && $request->page && $request->page > 1) {
            $more_articles = Article::getMoreArticles($request, $category_ids);
            return Output::makeResult($request, $more_articles);
        }
        global $articles;
        $articles = Article::getArticles($request, $category_ids);
        $dclists=Dc::orderby('created_at','desc')->paginate(15);
        $loupanlists=Loupan::orderby('created_at','desc')->paginate(15);


        $data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
            'type' => $type,
            'categories' => $categories,
            'current_category' => $current_category,
            'topics' => [],
            'articles' => $articles,
            'dclists' => $dclists,
            'loupanlists' => $loupanlists,
            // 'starsav'   =>$starsav,
        ];
        // echo("<script>console.log(".json_encode($data).");</script>");
        return view('article.lists', $data);
    }


    /**
     * 室内分类
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function interiorCategory(Request $request, $id)
    {
        $category_where = [
            ['parent_id', 2]
        ];
        $type = 'interior';
        return $this->doCategory($request, $id, $type, $category_where);
    }


    /**
     * 建筑分类
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function archsCategory(Request $request, $id)
    {
        $category_where = [
            ['parent_id', 1]
        ];
        $type = 'archs';
        return $this->doCategory($request, $id, $type, $category_where);
    }


    /**
     * 地产分类
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function developCategory(Request $request, $id)
    {
        $category_where = [
            ['parent_id', 19]
        ];
        $type = 'estate';
        return $this->doCategory($request, $id, $type, $category_where);
    }


    /**
     * 所有分类
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category(Request $request, $id)
    {
        $type = 'article';
        return $this->doCategory($request, $id, $type);
    }


    /**
     * 建筑分类
     * @param Request $request
     * @param $id
     * @param $type
     * @param null $category_where
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function doCategory(Request $request, $id, $type, $category_where = null)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';
        $category_ids = [$id];
        if ($category_where) {
            $categories = ArticleCategory::where('display', '0')->where($category_where)->get();
        } else {
            $categories = ArticleCategory::where('display', '0')->get();
        }
        $topics = ArticleCategory::getTopics($id);

        $articles = Article::getArticles($request, $category_ids);
        $dclists=Dc::orderby('created_at','desc')->paginate(15);
        $loupanlists=Loupan::orderby('created_at','desc')->paginate(15);

        $data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
            'type' => $type,
            'categories' => $categories,
            'current_category' => $id,
            'topics' => $topics,
            'articles' => $articles,
            'dclists' => $dclists,
            'loupanlists' => $loupanlists,
            
        ];
        return view('article.lists', $data);
    }

    /**
     * 文章详情
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request, $id)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';
        Article::where('id', $id)->increment('view_num');
        $article = Article::getArticle($id);
        $related_articles = Article::getRelatedArticle($id);
        $arr_ids = $article->designer_id;
        $designer_id = array_shift($arr_ids);
        $designer = Designer::getDesigner($designer_id);

        if($article->article_status !=2){
            abort(404);
        }else if($article->display !=0){
            abort(404);
        }  

        $more_designer = [];
        foreach ($arr_ids as $tmp_id) {
            $more_designer[] = Designer::getDesigner($tmp_id);
        }

        //上一条
        // $previous_id = Article::where('id', $id)->max('id');
        // $previous_article = Article::getArticle($previous_id);
        $previous_id = Article::where('id',$id)->pluck('release_time');
        $previous_article = Article::where('release_time','<',$previous_id)->where('display',0)->where('article_status',2)->orderby('release_time','desc')->first();


        //下一条
        // $next_id = Article::where('id', '>', $id)->min('id');
        // $next_article = Article::getArticle($next_id);
        $next_id = Article::where('id',$id)->pluck('release_time');
        $next_article = Article::where('release_time','>',$next_id)->where('display',0)->where('article_status',2)->orderby('release_time','desc')->first();

        //最新
        // $new_article = Article::getNewArticles(1);
        $new_article = Article::where('display',0)->where('article_status',2)->orderby('release_time','desc')->limit(1)->get();

        $ads_right = Popularize::getPopularize(6);
        $hot_tags = ArticleTag::getHotTags();

        $is_like = UserLike::isLike('0', $id);
        $is_collect = UserCollect::isCollect($id);
        $is_subscription = UserSubscription::isSubscription($designer_id);

        $month_price = VipPrice::getPrice(1);
        $season_price = VipPrice::getPrice(2);
        $year_price = VipPrice::getPrice(3);
        $be_month_price= VipPrice::where('id',1)->value('be_price');
        $be_season_price= VipPrice::where('id',2)->value('be_price');
        $be_year_price= VipPrice::where('id',3)->value('be_price');

        if (Auth::check()) {
            $user_finder_folders = UserFinderFolder::getSelectOptionsByUserId(Auth::id());
            $user_collect_folders = UserCollectFolder::getSelectOptionsByUserId(Auth::id());
            
        } else {
            $user_finder_folders = [];
            $user_collect_folders = [];
        }
        $comments_total = ArticleComment::where('comment_id', $id)->where('display', '1')->count();
        $comments_all=ArticleComment::where('comment_id', $id)->where('display', '1')->where('content','!=','')->count();//评论条数
        
        $comments = ArticleComment::where('comment_id', $id)
            ->where('display', '1')
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get();
        
		//根据图片	id查出该id所有的记录
		$user_id = Auth::id();
        $issc = UserFinder::where('user_id', $user_id)->get()->toArray();
        
        $isvip=User::where('id',$user_id)->pluck('level')->first();

        // //求打分的平均值
        $starsaverage=$comments->toArray();
        $starssum=0;
        $starscount=count($starsaverage);
        foreach($starsaverage as $key){
            $starssum+=$key['stars'];
        }
        if($starssum==0){
        	$starsav=0;
        }else{
        	$starsav=$starssum/$starscount;
        	$starsav=sprintf("%.1f",$starsav);//保留小数点一位
        }

        $userstars=ArticleComment::where('user_id', $user_id)->where('comment_id',$id)->value('stars');

        foreach($user_collect_folders as $key => $value){
            $iscollects=UserCollect::where('user_collect_folder_id',$value['id'])
                ->where('user_collects.user_id', $user_id)
                ->where('user_collects.collect_type', '0')
                ->where('user_collects.collect_id', $id)
                ->where('user_collects.is_sc',1)
                ->first();

            $user_collect_folders[$key]['iscollects']=$iscollects;
            if($user_collect_folders[$key]['iscollects']){
                $user_collect_folders[$key]['iscollects']='1';
            }else{
                $user_collect_folders[$key]['iscollects']='2';
            }
                       
        }

        $articleqwe=Article::where('id',$id)->get();
        foreach($articleqwe as $k=>$articleqqq){
            $topics = Topic::query();

            foreach ($articleqqq->category_ids as $cid) {
                $topics =ArticleCategory::getTopics($cid);
            }
        }
        $sys=Photographer::where('id',$article->sys_id)->first();
        $sys_works=Photographer::leftjoin('articles','articles.sys_id','=','photographers.id')->select('photographers.id','photographers.name','articles.sys_id')->count('articles.sys_id');
        // dd($sys);
        $data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
            'article' => $article,
            'designer' => $designer,
            'more_designer' => $more_designer,
            'related_articles' => $related_articles,
            'previous_article' => $previous_article,
            'next_article' => $next_article,
            'new_article' => $new_article,
            'ads_right' => $ads_right,
            'hot_tags' => $hot_tags,
            'is_like' => $is_like,
            'is_collect' => $is_collect,
            'is_subscription' => $is_subscription,
            'user_collect_folders' => $user_collect_folders,
            'user_finder_folders' => $user_finder_folders,
            'comments_total' => $comments_total,
            'comments' => $comments,
            'month_price' => $month_price,
            'season_price' => $season_price,
            'year_price' => $year_price,
            'be_month_price' => $be_month_price,
            'be_season_price' => $be_season_price,
            'be_year_price' => $be_year_price,
            'issc' => $issc,
            'isvip' => $isvip,
            'starsav' => $starsav,
            'userstars' => $userstars,
            'comments_all' => $comments_all,
            'topics' => $topics,
            'sys' => $sys,
            'sys_works' => $sys_works,
        ];
        return view('article.detail', $data);
    }



    
    /**
     * 按照评分排序
     * @param Request $request
     * @return array
     * 
     */
    public function allsortlist(Request $request)
    {
        $type=$request->type;
        $sjx=$request->sjx;
        // dd($request->all());
        $data=[];

        if($request->category_id){
            $category_ids = [$request->category_id];
            
            $articles =Article::getMoreArticles($request, $category_ids);

            foreach ($articles as $k=>$article) {
                $data[] = $article;
            }
        }else{
            $articles = Article::where('article_status', '2')->where('display', '0');
            if($request->type=='starssort'){
                if($request->sjx=='desc'){
                    $articles = $articles->orderBy('article_avg','desc')->paginate(15);
                }else{
                    $articles = $articles->orderby('article_avg','asc')->paginate(15);
                }
            }
                
            if($request->type=='timesort'){
                if($request->sjx=='desc' ){
                    $articles = $articles->orderBy('release_time','desc')->paginate(15);
                }else{
                    $articles = $articles->orderBy('release_time','asc')->paginate(15);
                }
            }

            if($request->type=='llsort'){
                if($request->sjx=='desc'){
                    $articles = $articles->orderBy('view_num','desc')->paginate(15);
                }else{
                    $articles = $articles->orderBy('view_num','asc')->paginate(15);
                }
            }
            
            foreach ($articles as $k=>$article) {
                $category_html = '';
                if ($article->category) {
                    foreach ($article->category as $category) {
                        $category_html .= ' <a href="/article/category/' .$category['id'] . '" rel="category tag">' .$category['name'] . '</a>';
                    }
                }
                if ($article->static_url) {
                    $url = url('/article/' . $article->static_url);
                } else {
                    $url = url('/article/detail/' . $article->id);
                }
                $tmp_html = '<li class="layout_li ajaxpost">
                        <article class="postgrid">
                        <div class="interior_dafen">'.($article->article_avg !="" || $article->article_avg !=null ? sprintf("%.1f",$article->article_avg) : "5.0").'</div>
                        <figure>
                        <a href="' . $url . '" title="' .get_article_title($article) . '" target="_blank">
                            <img class="thumb" src="' .get_article_thum($article) . '" data-original="' .get_article_thum($article) . '" alt="' .get_article_title($article) . '" style="display: block;">
                        </a>
                    </figure>
                    <div class="chengshi">' .get_article_location($article) . '</div>
                    <h2>
                        <a href="' . $url . '" title="' .get_article_title($article) . '" target="_blank">
                            <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;">' .get_article_title($article, 1) . '</div>
                            <div style=" color:#666; line-height:24px;">' .get_article_title($article, 2) . '</div>
                        </a>
                    </h2>
                    <div class="homeinfo">
                        <!--分类-->
                        ' . $category_html . '
                        <!--时间-->
                        <span class="date">' .str_limit($article->release_time, 10, "") . '</span>
                        <!--点赞-->
                        <span title="" class="like"><i class="icon-eye"></i><span class="count">' .$article->view_num . '</span></span> </div>
                    </article>
                </li>';
                $data[] = $tmp_html;
            }
        }


        return Output::makeResult($request, $data);

    }










    /**
     * 点赞
     *
     * @param Request $request
     * @return array
     */
    public function like(Request $request)
    {
        $result = UserLike::likeById('0', $request->like_id);
		if (true === $result['status']) {
            return Output::makeResult($request, $result);
        } else {
			return Output::makeResult($request, null, Error::SYSTEM_ERROR, $result['msg']);
		}
        
    }



    /**
     * 点击->收藏
     *
     * @param Request $request
     * @return array
     */
    public function collect(Request $request)
    {
        if (!Auth::check()) {
            return Output::makeResult($request, null, Error::USER_NOT_LOGIN);
        }
	
        $result = UserCollect::collectById('0', $request);
		
        if (true === $result) {
            return Output::makeResult($request, null);
        }
        return Output::makeResult($request, null, Error::SYSTEM_ERROR, $result);
    }



    /**
     * 免费下载
     *
     * @param Request $request
     * @return array
     */
    public function vipDownload(Request $request)
    {
        if (!Auth::check()) {
            return Output::makeResult($request, null, Error::USER_NOT_LOGIN);
        }

        $user = $this->getUserInfo();
                
        //查出用户下载次数
        $today_starts = date('Y-m-d H:i:s', strtotime('-7 days'));
        $today_ends   = date('Y-m-d H:i:s');
        $today_start = date('Y-m-d 00:00:00');
        $today_end   = date('Y-m-d 23:59:59');

        $article = Article::find($request->article_id);
        //七天内重复下载
        $sandays=UserDownRecord::where('user_id', $user->id)->where('down_id',$request->article_id)->where('created_at', '>=', $today_starts)->where('created_at', '<', $today_ends)->get()->toArray();

        $leftkou=User::getFreeSum($user->id);
        if(!empty($sandays)){
            return Output::makeResult($request, null, 999, '您已经兑换过,请您移步到个人中心查看!');
        }
        if($leftkou>0){
            
            if($article->vip_download){
                $data = [
                    'user_id' => $user->id,
                    'down_type' => '1',
                    'is_free' => 1,
                    'down_id' => $request->article_id,
                ];
                UserDownRecord::create($data);

                $return_data = [
                    'vip_download' => $article->vip_download,
                    'leftkou' => '今日剩余免费下载次数'.(($leftkou-1)<0?0:$leftkou-1).' ',
                    'msg'=>'免费兑换成功',
                ];
                return Output::makeResult($request,null, 100, $return_data);
            }else{
                return Output::makeResult($request, null, 500, '因版权要求，本作品暂不提供下载！');
            }

        }else{
            // 印币兑换下载
            if(!$article->vip_download){
                return Output::makeResult($request, null, 500, '因版权要求，本作品暂不提供下载！');
            }
            $leftkou=User::getKouSum($user->id);
            //检查是否可以兑换
            
            if($user->left_points>10){
                if($leftkou>0){
                    $data_exchange = ['user_id' => $user->id,];
                    UserExchangeRecord::create($data_exchange);
                    
                    $das=[
                        'user_id' => $user->id,
                        'type' => '1',
                        'point' => 10,
                        'remark' => '印币抵扣',
                    ];
                    $re=UserPoint::create($das);

                    $user->left_points = $user->left_points - 10;
                    $user->save();
                   
                    $data_down = [
                        'user_id' => $user->id,
                        'down_type' => '1',
                        'is_free' => 2,
                        'down_id' => $request->article_id,
                    ];
                    UserDownRecord::create($data_down);
                    
                    $return_data = [
                        'vip_download' => $article->vip_download,
                        'leftkou' => '今日剩余积分下载次数'.(($leftkou-1)<1?0:$leftkou-1).' ',
                        'msg'=>'抵扣成功,扣除10印币',
                    ];
                    return Output::makeResult($request,null,100, $return_data);

                }else{
                    if($user->level=0){
                        return Output::makeResult($request, null, 500, '您的印币不足，更多下载请<a href="/vip/vip_service" style="color:red;">开通会员</a>');
                    }else if($user->level=1 && $user->expire_time && $user->expire_time >= date('Y-m-d')){
                        return Output::makeResult($request, null, 500, '您的印币不足，更多下载请<a href="/vip/vip_service" style="color:red;">升级会员</a>');
                    }else if($user->level=2 && $user->expire_time && $user->expire_time >= date('Y-m-d')){
                        return Output::makeResult($request, null, 500, '您的印币不足，更多下载请<a href="/vip/vip_service" style="color:red;">升级会员</a>');
                    }else if($user->level=3 && $user->expire_time && $user->expire_time >= date('Y-m-d')){
                    return Output::makeResult($request, null, 500, '您的今日下载次数已用完');
                    }
                }
            }else{
                return Output::makeResult($request, null, 500, '兑换失败，您的印币不足！');
            }

        }
    }

    /**
    * 印币兑换下载
    *
    * @param Request $request
    * @return array
    */
    /*public function exchange(Request $request)
    {
        if (!Auth::check()) {
            return Output::makeResult($request, null, Error::USER_NOT_LOGIN);
        }

        $user = User::find(Auth::id());
        $article = Article::find($request->article_id);
        if (!$article->vip_download) {
            return Output::makeResult($request, null, 500, '因版权要求，本作品暂不提供下载！');
        }
        $leftdown=User::getLeftDownloadNum($user->id);
        $today_start = date('Y-m-d 00:00:00');
        $today_end   = date('Y-m-d 23:59:59');
        $koudown=User::getKouDownloadNum($user->id);
        $has_koudown=UserDownRecord::where('user_id', $user->id)->where('is_free','2')->where('created_at', '>=', $today_start)->where('created_at', '<', $today_end)->count();
        $leftkou=USer::getKouSum($user->id);
        // dd($user->left_points);
        //检查是否可以兑换
        
        if($user->left_points>10){
            // dd($leftkou);
            if($leftkou>0){
                $data_exchange = [
                    'user_id' => $user->id,
                ];
                UserExchangeRecord::create($data_exchange);
                
                $das=[
                    'user_id' => $user->id,
                    'type' => '1',
                    'point' => 10,
                    'remark' => '印币抵扣',
                ];
                $re=UserPoint::create($das);

                $user->left_points = $user->left_points - 10;
                $user->save();
                
                $data_down = [
                    'user_id' => $user->id,
                    'down_type' => '1',
                    'is_free' => 2,
                    'down_id' => $request->article_id,
                ];
                UserDownRecord::create($data_down);
                
                $return_data = [
                    'vip_download' => $article->vip_download,
                    'left_down_num' => ($leftkou-1)<1?0:$leftkou-1,
                    'msg'=>'抵扣成功,扣除10印币',
                ];
                return Output::makeResult($request,null,100, $return_data);
            }else{
                if($user->level=0){
                    return Output::makeResult($request, null, 500, '您的印币不足，更多下载请<a href="/vip/vip_service">开通会员</a>');
                }else if($user->level=1 && $user->expire_time && $user->expire_time >= date('Y-m-d')){
                    return Output::makeResult($request, null, 500, '您的印币不足，更多下载请<a href="/vip/vip_service">升级会员</a>');
                }else if($user->level=2 && $user->expire_time && $user->expire_time >= date('Y-m-d')){
                    return Output::makeResult($request, null, 500, '您的印币不足，更多下载请<a href="/vip/vip_service">升级会员</a>');
                }else if($user->level=1 && $user->expire_time && $user->expire_time >= date('Y-m-d')){
                    return Output::makeResult($request, null, 500, '您的今日下载次数已用完');
                }
            }

        }else{
            return Output::makeResult($request, null, 500, '兑换失败，您的印币不足！');
        }
        
    }*/
}
