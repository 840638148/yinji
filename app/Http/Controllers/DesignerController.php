<?php

namespace App\Http\Controllers;

use App\Http\Error;
use App\Http\Output;
use App\Models\DesignerComment;
use App\Models\UserLike;
use App\Models\UserSubscription;
use Illuminate\Http\Request;
use App\Models\DesignerCategory;
use App\Models\Designer;
use App\Models\ArticleComment;
use App\Models\Article;
use Illuminate\Support\Facades\Auth;

class DesignerController extends Controller
{
    public function lists(Request $request)
    {
        if ($request->page && $request->page > 1) {
            $more_designers = Designer::getMoreDesigners($request);
            return Output::makeResult($request, $more_designers);
        }
        
        $lang = $request->session()->get('language') ?? 'zh-CN';
        $total = Designer::where('designer_status', '1')
            ->where('display', '0')
            ->count();
        $categories = DesignerCategory::where('display', '0')->get();
        $designers = Designer::getDesigners($request);

        $data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
            'categories' => $categories,
            'total' => $total,
            'designers' => $designers
        ];
        return view('designer.lists', $data);
    }
    
    
    public function detail(Request $request, $id)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';
        Designer::where('id', $id)->increment('view_num');
        $designer = Designer::getDesigner($id);
        $related_articles = Designer::getRelatedArticle($id);//获取该设计师下的作品
        $related_designers = Designer::getRelatedDesigner($id);

        $is_like = UserLike::isLike('1', $id);
        $is_subscription = UserSubscription::isSubscription($id);

        //根据详情的id查出该设计师每个作品的分数
        foreach($related_articles as $k=>$designall){
            $related_articles[$k]['starsavg']=ArticleComment::where('comment_id',$designall['id'])->avg('stars');
            if($related_articles[$k]['starsavg']==''){
                $related_articles[$k]['starsavg']='5.0';
            }
        }

        //根据详情的id查出该设计师所有作品的平均分
        $comments_total = ArticleComment::where('comment_id', $id)->where('display', '1')->count();
        $starscount=count($related_articles);//总数
        foreach($related_articles as $key){
            $comments_total+=$key['starsavg'];
        }
        if($comments_total==0 || $starscount==0){
        	$starsav=0;   
        }else{
        	$starsav=$comments_total/$starscount;
        	$starsav=sprintf("%.1f",$starsav);//保留小数点一位
        }
        



    //     // 根据设计师的id查出设计师旗下的文章
    //     foreach($related_designers as $k=>$designall){
    //         $res = Article::where('articles.article_status', '2')
    //         ->where('articles.display', '0')
    //         ->where('articles.designer_id', 'like', "%".implode(',',$designall->category_ids)."%");// $designall->category_ids是个一维数组，要将他转为字符串用implode
            
    //     }
    //     $designer_articles = $res->get()->toArray();
    //     $starscounts = $res ->count('articles.id');
    //    dd($related_designers);

    //     // 根据设计师的id查出设计师旗下的文章
    //     foreach($designer_articles as $key=>$val){
    //         $designarticle=Designer::getRelatedArticle($val['id']);
    //         // dump($designarticle);
    //     }
        
        $data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
            'designer' => $designer,
            'related_articles' => $related_articles,
            'related_designers' => $related_designers,
            'is_like' => $is_like,
            'is_subscription' => $is_subscription,
            'comments_total' => $comments_total,
            'starsav'  =>$starsav,
        ];

        return view('designer.detail', $data);
    }
    
    
    public function category(Request $request, $id)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';
        $category_ids = [$id];
        $categories = DesignerCategory::where('display', '0')->get();
        
        if ($request->page && $request->page > 1) {
            $more_designers = Designer::getMoreDesigners($request, $category_ids);
            return Output::makeResult($request, $more_designers);
        }
        
        $designers = Designer::getDesigners($request, $category_ids);
        $data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
            'categories' => $categories,
            'current_category' => $id,
            //'total' => $total,
            'designers' => $designers
        ];
        return view('designer.lists', $data);
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

        $result = UserLike::likeById('1', $request->like_id);
		if (true === $result['status']) {
            return Output::makeResult($request, $result);
        } else {
			return Output::makeResult($request, null, Error::SYSTEM_ERROR, $result['msg']);
		}
    }



    /**
     * 订阅
     *
     * @param Request $request
     * @param $id
     * @return array
     */
    public function subscription(Request $request)
    {
        $result = UserSubscription::subscriptionByDesignerId($request->designer_id);
        if (true === $result) {
            return Output::makeResult($request, null);
        }
        return Output::makeResult($request, null, Error::SYSTEM_ERROR);
    }
}
