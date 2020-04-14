<?php

namespace App\Http\Controllers;

use App\Http\Error;
use App\Http\Output;
use App\Models\NewsComment;
use Illuminate\Http\Request;
use App\Models\News;
use App\Models\NewsTag;
use App\Models\Designer;
use App\Models\Popularize;
use App\Models\UserSubscription;
use App\Models\UserLike;
use Illuminate\Support\Facades\Auth;
use App\Models\UserFinderFolder;
use App\Models\UserCollectFolder;
use App\Models\VipPrice;


header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:OPTIONS, GET, POST'); // 允许option，get，post请求
header('Access-Control-Allow-Headers:x-requested-with, content-type'); // 允许x-requested-with请求头


class NewsController extends Controller

{
    public function lists(Request $request)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';
        $newses = News::getNewses($request);

        $hot_newses = News::getHotNewses();
        $ads_right = Popularize::getPopularize(7);
        $data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
            'newses' => $newses,
            'hot_newses' => $hot_newses,
            'ads_right' => $ads_right,
        ];
        return view('news.lists', $data);
    }
    
    
    public function listsAjax(Request $request)
    {
        
        $more_newses = News::getMoreNewses($request);
        return Output::makeResult($request, $more_newses);
    }
    
    
    public function detail(Request $request, $id)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';
        News::where('id', $id)->increment('view_num');
        $news = News::getNews($id);
        //$related_articles = Designer::getRelatedArticle($article->designer_id);
        $arr_ids = $news->designer_id;
        $designer_id = array_shift($arr_ids);
        $designer = Designer::getDesigner($designer_id);

        $more_designer = [];
        foreach ($arr_ids as $tmp_id) {
            $more_designer[] = Designer::getDesigner($tmp_id);
        }

        //上一条
        $previous_id = News::where('id', '<', $id)->max('id');
        $previous_news = News::getNews($previous_id);

        //下一条
        $next_id = News::where('id', '>', $id)->min('id');
        $next_news = News::getNews($next_id);

        //最新
        $new_news = News::getNewNewses(1);

        $ads_right = Popularize::getPopularize(7);
        $hot_tags = NewsTag::getHotTags();
		
        $is_like = UserLike::isLike('2', $id);
        $is_subscription = UserSubscription::isSubscription($designer_id);

        if (Auth::check()) {
            $user_finder_folders = UserFinderFolder::getSelectOptionsByUserId(Auth::id());
            $user_collect_folders = UserCollectFolder::getSelectOptionsByUserId(Auth::id());
        } else {
            $user_finder_folders = [];
            $user_collect_folders = [];
        }

        $comments_total = NewsComment::where('comment_id', $id)->where('display', '1')->count();
        $comments = NewsComment::where('comment_id', $id)
            ->where('display', '1')
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        $month_price = VipPrice::getPrice(1);
        $season_price = VipPrice::getPrice(2);
        $year_price = VipPrice::getPrice(3);

// dd($news->title_designer_cn);

        $data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
            'news' => $news,
            'designer' => $designer,
            'more_designer' => $more_designer,
            //'related_articles' => $related_articles,
            'previous_news' => $previous_news,
            'next_news' => $next_news,
            'new_news' => $new_news,
            'ads_right' => $ads_right,
            'hot_tags' => $hot_tags,
            'is_like' => $is_like,
            'is_subscription' => $is_subscription,
            'comments_total' => $comments_total,
            'user_finder_folders' => $user_finder_folders,
            'user_collect_folders' => $user_collect_folders,
            'comments' => $comments,
            'month_price' => $month_price,
            'season_price' => $season_price,
            'year_price' => $year_price,
        ];
        return view('news.detail', $data);
    }

    /**
     * 点赞
     *
     * @param Request $request
     * @return array
     */
    public function like(Request $request)
    {
        if (!Auth::check()) {
            return Output::makeResult($request, null, Error::USER_NOT_LOGIN);
        }

        $result = UserLike::likeById('2', $request->like_id);
		if (true === $result['status']) {
            return Output::makeResult($request, $result);
        } else {
			return Output::makeResult($request, null, Error::SYSTEM_ERROR, $result['msg']);
		}
    }
}
