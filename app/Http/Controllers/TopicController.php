<?php

namespace App\Http\Controllers;

use App\Http\Error;
use App\Http\Output;
use App\Models\Topic;
use App\Models\UserCollect;
use App\Models\UserCollectFolder;
use App\Models\UserFinderFolder;
use App\Models\UserLike;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use App\Models\Popularize;
use App\Models\ArticleTag;
use App\Models\ArticleCategory;
use App\Models\Article;
use App\Models\Designer;
use App\Models\ArticleComment;

use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{

    /**
     * 专题详情
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request, $id)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';
        $topic = Topic::find($id);
        $hot_article = Topic::getHotArticle($id);
        $hot_article_more = Topic::getHotArticleMore($id);
        $news_articles = Topic::getNewsArticles($id);
        $designers = Topic::getDesigners($id);
        $articles = Topic::getArticles($id);

        foreach($articles as $k=>$articleslist){
            $articles[$k]['starsavg'] = ArticleComment::where('comment_id', $articleslist['id'])->avg('stars');
            $articles[$k]['starsavg'] = sprintf("%.1f",$articles[$k]['starsavg']);//保留小数点一位
        }
        $data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
            'topic' => $topic,
            'hot_article' => $hot_article,
            'hot_article_more' => $hot_article_more,
            'news_articles' => $news_articles,
            'designers' => $designers,
            'articles' => $articles,
        ];
        return view('article.topic', $data);
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

        $result = UserLike::likeById('0', $request->like_id);
		if (true === $result['status']) {
            return Output::makeResult($request, $result);
        } else {
			return Output::makeResult($request, null, Error::SYSTEM_ERROR, $result['msg']);
		}
    }



    /**
     * 收藏
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
     * 下载
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
        if (true == $user->is_vip) {
            $article = Article::find($request->article_id);
            if ($article->vip_download) {
                return Output::makeResult($request, ['vip_download' => $article->vip_download]);
            } else {
                return Output::makeResult($request, null, 500, '该作品暂未提供下载，请联系管理员！');
            }
            
        }
        return Output::makeResult($request, null, Error::SYSTEM_ERROR, '您不是VIP');

    }
}
