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
use App\User;
use DB;
use App\Models\UserDownRecord;
use App\Models\UserExchangeRecord;
use Illuminate\Support\Facades\Auth;
use App\Models\VipPrice;
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

        foreach($articles as $k=>$articleslist){
            $articles[$k]['starsavg'] = ArticleComment::where('comment_id', $articleslist['id'])->avg('stars');
            $articles[$k]['starsavg'] = sprintf("%.1f",$articles[$k]['starsavg']);//保留小数点一位
        }
   
        $data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
            'type' => $type,
            'categories' => $categories,
            'current_category' => $current_category,
            'topics' => [],
            'articles' => $articles,
            // 'starsav'   =>$starsav,
        ];
        echo("<script>console.log(".json_encode($data).");</script>");
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
        foreach($articles as $k=>$articleslist){
            $articles[$k]['starsavg'] = ArticleComment::where('comment_id', $articleslist['id'])->avg('stars');
            $articles[$k]['starsavg'] = sprintf("%.1f",$articles[$k]['starsavg']);//保留小数点一位
        }
        $data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
            'type' => $type,
            'categories' => $categories,
            'current_category' => $id,
            'topics' => $topics,
            'articles' => $articles,
            
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

        $more_designer = [];
        foreach ($arr_ids as $tmp_id) {
            $more_designer[] = Designer::getDesigner($tmp_id);
        }

        //上一条
        // $previous_id = Article::where('id', $id)->max('id');
        // $previous_article = Article::getArticle($previous_id);
        $previous_id = Article::where('id',$id)->pluck('created_at');
        $previous_article = Article::where('created_at','<',$previous_id)->first();


        //下一条
        // $next_id = Article::where('id', '>', $id)->min('id');
        // $next_article = Article::getArticle($next_id);
        $next_id = Article::where('id',$id)->pluck('created_at');
        $next_article = Article::where('created_at','>',$next_id)->first();

        //最新
        // $new_article = Article::getNewArticles(1);
        $new_article = Article::orderBy('created_at','desc')->limit(1)->get();

        $ads_right = Popularize::getPopularize(6);
        $hot_tags = ArticleTag::getHotTags();

        $is_like = UserLike::isLike('0', $id);
        $is_collect = UserCollect::isCollect($id);
        $is_subscription = UserSubscription::isSubscription($designer_id);

        $month_price = VipPrice::getPrice(1);
        $season_price = VipPrice::getPrice(2);
        $year_price = VipPrice::getPrice(3);

        if (Auth::check()) {
            $user_finder_folders = UserFinderFolder::getSelectOptionsByUserId(Auth::id());
            $user_collect_folders = UserCollectFolder::getSelectOptionsByUserId(Auth::id());
            // dd($user_finder_folders);
        } else {
            $user_finder_folders = [];
            $user_collect_folders = [];
        }
        $comments_total = ArticleComment::where('comment_id', $id)->where('display', '1')->count();
        $comments = ArticleComment::where('comment_id', $id)
            ->where('display', '1')
            ->orderBy('created_at', 'desc')
            ->limit(100)
            ->get();
            // dd($comments);
		//根据图片	id查出该id所有的记录
		$user_id = Auth::id();
        $issc = UserFinder::where('user_id', $user_id)->get()->toArray();
        
        $isvip=User::where('id',$user_id)->pluck('level')->first();

        //求打分的平均值
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
        	// $starsav=round($starsav);
        	$starsav=sprintf("%.1f",$starsav);//保留小数点一位
        }
 
        $userstars=ArticleComment::where('user_id', $user_id)->where('comment_id',$id)->value('stars');
        // $userstars=sprintf("%.1f",$userstars);
        // dd($userstars);
        // foreach($articles as $k=>$articleslist){
        //     $articles[$k]['starsavg'] = ArticleComment::where('comment_id', $articleslist['id'])->avg('stars');
        //     $articles[$k]['starsavg'] = sprintf("%.1f",$articles[$k]['starsavg']);//保留小数点一位
        // }
        // dd($starssum,$starscount,$starsav);
		// dd($userstars); 
        // $stars=ArticleComment::where('user');
        
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
            'issc' => $issc,
            'isvip' => $isvip,
            'starsav' => $starsav,
            'userstars' => $userstars,
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

        if($type=='starssort'){
            if($sjx=='desc'){
                $articles = Article::join('article_comments','articles.id','article_comments.comment_id')->orderBy('article_comments.stars','desc')->limit(99)->get();
                // dd($articles);
                $data = [];
                foreach ($articles as $k=>$article) {
                    $category_html = '';
                    // $a=ArticleComment::where('article_comments.comment_id', $article['id'])->avg('stars');
                    // dump($a);
                    $articles[$k]['starsavg'] = ArticleComment::where('comment_id', $article['comment_id'])->avg('stars');
                    $articles[$k]['starsavg'] = sprintf("%.1f",$articles[$k]['starsavg']);//保留小数点一位
                    // dd($articles);
                    if ($article->category) {
                        foreach ($article->category as $category) {
                            $category_html .='<a href="/article/category/' .$category['id'].'" rel="category tag">'.$category['name'].'</a>';
                        }
                    }
                    if ($article->static_url) {
                        $url = url('/article/'.$article->static_url);
                    } else {
                        $url = url('/article/detail/'.$article->id);
                    }
                    $tmp_html = '<li class="layout_li ajaxpost">
                    <article class="postgrid">
                    <div class="interior_dafen">'.($article->starsavg !=0 ? $article->starsavg : "5.0").'</div>
                        <figure>
                            <a href="'.$url.'" title="'.get_article_title($article).'" target="_blank">
                                <img class="thumb" src="'.get_article_thum($article).'" data-original="'.get_article_thum($article).'" alt="'.get_article_title($article).'" style="display: block;">
                            </a>
                        </figure>
                        <div class="chengshi">'.get_article_location($article).'</div>
                        <h2>
                            <a href="'.$url.'" title="'.get_article_title($article).'" target="_blank">
                                <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;">'.get_article_title($article, 1).'</div>
                                <div style=" color:#666; line-height:24px;">'.get_article_title($article, 2).'</div>
                            </a>
                        </h2>
                        <div class="homeinfo">
                            <!--分类-->
                            '.$category_html.'
                            <!--时间-->
                            <span class="date">'.str_limit($article->release_time, 10, '').'</span>
                            <!--点赞-->
                            <span title="" class="like"><i class="icon-eye"></i><span class="count">'.$article->view_num.'</span></span> </div>
                        </article>
                    </li>';
                    $data[] = [
                        'starsavg' => $article->starsavg,
                        'html' => $tmp_html
                    ];

                }
                // dd($data); 
                $data = collect($data)->sortByDesc('starsavg')->values()->all();
                $html = '';
                foreach ($data as $item) {
                    $html .= $item['html'];
                }

                return Output::makeResult($request, $html);
            }else{
                $articles = Article::join('article_comments','articles.id','article_comments.comment_id')->orderBy('article_comments.stars','asc')->limit(99)->get();
                // dd($articles);
                foreach ($articles as $k=>$article) {
                    $category_html = '';
                    $articles[$k]['starsavg'] = ArticleComment::where('comment_id', $article['comment_id'])->avg('stars');
                    $articles[$k]['starsavg'] = sprintf("%.1f",$articles[$k]['starsavg']);//保留小数点一位
                    // dd($articles);
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
                    <div class="interior_dafen">'.($article->starsavg !=0 ? $article->starsavg : "5.0").'</div>
                        <figure>
                            <a href="' . $url . '" title="'.get_article_title($article).'" target="_blank">
                                <img class="thumb" src="'.get_article_thum($article).'" data-original="'.get_article_thum($article).'" alt="' .get_article_title($article) . '" style="display: block;">
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
                            <span class="date">' .str_limit($article->release_time, 10, '') . '</span>
                            <!--点赞-->
                            <span title="" class="like"><i class="icon-eye"></i><span class="count">' .$article->view_num . '</span></span> </div>
                        </article>
                    </li>';
 
                    $data[] = [
                        'starsavg' => $article->starsavg,
                        'html' => $tmp_html
                    ];
                }
                $data = collect($data)->sortBy('starsavg')->values()->all();
                $html = '';
                foreach ($data as $item) {
                    $html .= $item['html'];
                }
                return Output::makeResult($request, $html);
            }
        }
               
        if($type=='timesort'){
            if($sjx=='desc' ){
                $articles = Article::orderBy('updated_at','desc')->limit(51)->get();
             
                foreach ($articles as $k=>$article) {
                    $category_html = '';
                    $articles[$k]['starsavg'] = ArticleComment::where('comment_id', $article['id'])->avg('stars');
                    $articles[$k]['starsavg'] = sprintf("%.1f",$articles[$k]['starsavg']);//保留小数点一位
                    // dd($articles);
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
                    <div class="interior_dafen">'.($article->starsavg !=0 ? $article->starsavg : "5.0").'</div>
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
                            <span class="date">' .str_limit($article->release_time, 10, '') . '</span>
                            <!--点赞-->
                            <span title="" class="like"><i class="icon-eye"></i><span class="count">' .$article->view_num . '</span></span> </div>
                        </article>
                    </li>';
                    $data[] = $tmp_html;
                }
                return Output::makeResult($request, $data);
            }else{
                $articles = Article::orderBy('updated_at','asc')->limit(51)->get();
                foreach ($articles as $k=>$article) {
                    $category_html = '';
                    $articles[$k]['starsavg'] = ArticleComment::where('comment_id', $article['id'])->avg('stars');
                    $articles[$k]['starsavg'] = sprintf("%.1f",$articles[$k]['starsavg']);//保留小数点一位
                    // dd($articles);
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
                    <div class="interior_dafen">'.($article->starsavg !=0 ? $article->starsavg : "5.0").'</div>
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
                            <span class="date">' .str_limit($article->release_time, 10, '') . '</span>
                            <!--点赞-->
                            <span title="" class="like"><i class="icon-eye"></i><span class="count">' .$article->view_num . '</span></span> </div>
                        </article>
                    </li>';
                    $data[] = $tmp_html;
                }
                return Output::makeResult($request, $data);
            }
        }

        
        if($type=='llsort'){
            if($sjx=='desc' ){
                $articles = Article::orderBy('view_num','desc')->limit(51)->get();
                
                foreach ($articles as $k=>$article) {
                    $category_html = '';
                    $articles[$k]['starsavg'] = ArticleComment::where('comment_id', $article['id'])->avg('stars');
                    $articles[$k]['starsavg'] = sprintf("%.1f",$articles[$k]['starsavg']);//保留小数点一位
                    // dd($articles);
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
                    <div class="interior_dafen">'.($article->starsavg !=0 ? $article->starsavg : "5.0").'</div>
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
                            <span class="date">' .str_limit($article->release_time, 10, '') . '</span>
                            <!--点赞-->
                            <span title="" class="like"><i class="icon-eye"></i><span class="count">' .$article->view_num . '</span></span> </div>
                        </article>
                    </li>';
                    $data[] = $tmp_html;
                }
                return Output::makeResult($request, $data);
            }else{
                $articles = Article::orderBy('view_num','asc')->limit(51)->get();
                foreach ($articles as $k=>$article) {
                    $category_html = '';
                    $articles[$k]['starsavg'] = ArticleComment::where('comment_id', $article['id'])->avg('stars');
                    $articles[$k]['starsavg'] = sprintf("%.1f",$articles[$k]['starsavg']);//保留小数点一位
                    // dd($articles);
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
                    <div class="interior_dafen">'.($article->starsavg !=0 ? $article->starsavg : "5.0").'</div>
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
                            <span class="date">' .str_limit($article->release_time, 10, '') . '</span>
                            <!--点赞-->
                            <span title="" class="like"><i class="icon-eye"></i><span class="count">' .$article->view_num . '</span></span> </div>
                        </article>
                    </li>';
                    $data[] = $tmp_html;
                }
                return Output::makeResult($request, $data);
            }
        }


        


        


    }










    /**
     * 点赞
     *
     * @param Request $request
     * @return array
     */
    public function like(Request $request)
    {
        //if (!Auth::check()) {
        //    return Output::makeResult($request, null, Error::USER_NOT_LOGIN);
        //}

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
		
		//查询已经收藏的记录
		// $findername = UserCollect::where('user_collect_folder_id', $request->folder_id)->where('collect_id', $request->collect_id)->first();
		// dd($request);  
		
        $result = UserCollect::collectById('0', $request);
		
        if (true === $result) {
            return Output::makeResult($request, null);
        }
        return Output::makeResult($request, null, Error::SYSTEM_ERROR, $result);
    }



    /**
     * 下载
     *
     * @param Request $request
     * @return array
     */
    public function vipDownload(Request $request)
    {
        //return Output::makeResult($request, null, 501, '您当前没有可用的下载次数！');
        if (!Auth::check()) {
            return Output::makeResult($request, null, Error::USER_NOT_LOGIN);
        }

        $user = $this->getUserInfo();
        
        $left_down_num = User::getLeftDownloadNum($user->id);
        if ($left_down_num <= 0) {
            return Output::makeResult($request, null, 501, '您当前没有可用的下载次数！');
        }
        
        if (true == $user->is_vip) {
            $article = Article::find($request->article_id);
            if ($article->vip_download) {
                $today_start = date('Y-m-d H:i:s', strtotime('-3 days'));
                $today_end   = date('Y-m-d H:i:s');
                $today_down = UserDownRecord::where('user_id', $user->id)
                    ->where('down_type', '1')
                    ->where('down_id', $request->article_id)
                    ->where('created_at', '>=', $today_start)
                    ->where('created_at', '<', $today_end)
                    ->count();
                if ($today_down <= 0) {
                    $data = [
                        'user_id' => $user->id,
                        'down_type' => '1',
                        'down_id' => $request->article_id,
                    ];
                    UserDownRecord::create($data);
                }
                
                $return_data = [
                    'vip_download' => $article->vip_download,
                    'left_down_num' => $left_down_num
                ];
                return Output::makeResult($request, $return_data);
            } else {
                return Output::makeResult($request, null, 500, '该作品暂未提供下载，请联系管理员！');
            }

        }
        return Output::makeResult($request, null, Error::SYSTEM_ERROR, '您不是VIP');

    }

    /**
     * 积分兑换下载次数
     *
     * @param Request $request
     * @return array
     */
    public function exchange(Request $request)
    {
        if (!Auth::check()) {
            return Output::makeResult($request, null, Error::USER_NOT_LOGIN);
        }

        //$user = $this->getUserInfo();
        $user = User::find(Auth::id());
        $article = Article::find($request->article_id);
        if (!$article->vip_download) {
            return Output::makeResult($request, null, 500, '该作品暂未提供下载，请联系管理员！');
        }
        
        //检查是否可以兑换
        if (User::getLeftExchangeNum($user->id)) {
            $data_exchange = [
                'user_id' => $user->id,
            ];
            UserExchangeRecord::create($data_exchange);
            
            //$user->points = $user->points - 10;
            $user->left_points = $user->left_points - 10;
            $user->save();
            
            $data_down = [
                'user_id' => $user->id,
                'down_type' => '1',
                'down_id' => $request->article_id,
            ];
            UserDownRecord::create($data_down);
            
            $left_down_num = User::getLeftDownloadNum($user->id);
            $return_data = [
                'vip_download' => $article->vip_download,
                'left_down_num' => $left_down_num
            ];
            return Output::makeResult($request, $return_data);
        } else {
            return Output::makeResult($request, null, 500, '兑换失败，请确认是否超过兑换次数或联系管理员！');
        }
    }
}
