<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\DesignerDetail;

class UserSubscription extends Model
{
    protected $fillable = [
        'user_id', 'designer_id', 'view_time',
    ];

    /**
     * 订阅设计师
     * @param $designer_id
     * @return bool
     */
    public static function subscriptionByDesignerId($designer_id)
    {
        $user_id = Auth::id();
        if (empty($designer_id) || empty($user_id)) {
            return false;
        }
        $obj = self::where('user_id', $user_id)
            ->where('designer_id', $designer_id)
            ->first();

        if ($obj){
            return false;
        } else {
            $data = [
                'user_id' => Auth::id(),
                'designer_id' => $designer_id,
            ];
            self::create($data);
            Designer::where('id', $designer_id)->increment('subscription_num');
        }
        return true;
    }

    /**
    * 我的订阅搜索框 
    * 
    */
    public static function desearch($request,$user_id){

        $user = User::find($user_id);
        $con=self::leftjoin('designers','designers.id','=','user_subscriptions.designer_id')
            ->select('user_subscriptions.designer_id','user_subscriptions.user_id','designers.title_cn','designers.category_ids','designers.topic_ids','designers.static_url','designers.custom_thum as d_custom_thum')
            ->where('user_subscriptions.user_id',$user_id)
            ->where("designers.title_cn","like","%$request->content%")
            ->get();

        $html='';
       
        foreach($con as $k=>$v){
            $con[$k]['category_ids']=explode(',',$v->category_ids);
            $con[$k]['country']=DesignerCategory::whereIn("id",$v->category_ids)->get();
            $con[$k]['article_num'] = Article::where('designer_id', 'like', "%,{$v->designer_id},%")->count();
            $con[$k]['fans_num'] = self::where('designer_id', $v->designer_id)->count();
            $con[$k]['articles'] = Article::where('designer_id', 'like', "%,{$v->designer_id},%")->limit(4)->get();
            $con[$k]['deintro']=DesignerDetail::where('designer_id',$v->designer_id)->value('content_cn');
            
            $html.='<div class="public_item" data-id="'.$v->designer_id.'">';
            $html.='    <div class="item_left"> ';
            $html.='        <a href="/designer/'.$v->static_url.'">';
            $html.='            <div class="tx"><img class="img-responsive" src="/uploads/'.$v->d_custom_thum.'" alt="'.$v->title_cn.'"> </div>';
            $html.='        </a>';
            $html.='        <div class="item_msg">';
            $html.='            <div class="title"> <a href="/designer/'.$v->static_url.'">'.$v->title_cn.'</a> </div>';
            $html.='            <div class="describe">';
            $html.='                <span>国家';
            foreach($v->country as $contrys){
                $html.=$contrys->name_cn;
            }
            $html.='                </span>';
            $html.='                <span>'.mb_substr($v->deintro,0,82).'...</span>';
            $html.='            </div>';
            $html.='            <div class="focus">';
            $html.='                <a href="javascript:void(0)" data-id="'.$v->designer_id.'" class="focus_btn2 click cancelSubscription"> 取消订阅 </a>';
            $html.='                <div class="focus_msg"> <span>作品：'.$v->article_num.'</span> | <span>粉丝：'.$v->fans_num.'</span> </div>';
            $html.='            </div>';
            $html.='        </div>';
            $html.='    </div>';
            $html.='    <div class="item_right">';
            foreach($v->articles as $articles){
                $html.='    <div class="works" data-id="'.$articles->article_id.'">';            
                $html.='        <a href="/article/'.$articles->static_url.'" target="_blank">';
                $html.='            <img src="'.get_article_thum($articles).'" alt=""> ';
                $html.='            <span>'.get_article_title($articles).'</span>';
                $html.='        </a>';
                $html.='    </div>';
            }
            $html.='    </div>';     
            $html.='</div>';     
        }
        
        return $html;
        


        // dd($con);



    }


    /**
     * 是否已经订阅
     * @param $designer_id
     * @return bool
     */
    public static function isSubscription($designer_id)
    {
        $user_id = Auth::id();
        if (empty($designer_id) || empty($user_id)) {
            return false;
        }
        $obj = self::where('user_id', $user_id)
            ->where('designer_id', $designer_id)
            ->first();

        if ($obj){
            return true;
        } else {
            return false;
        }
    }

    /**
     * 取消订阅
     * @param $designer_id
     * @return bool
     */
    public static function cancelSubscriptionById($designer_id)
    {
        $user_id = Auth::id();
        if (empty($designer_id) || empty($user_id)) {
            return false;
        }
        $obj = self::where('user_id', $user_id)
            ->where('designer_id', $designer_id)
            ->first();

        if ($obj){
            $obj->delete();
            return true;
        } else {
            return false;
        }
    }


    /**
     *
     * @param $user_id
     * @return string
     */
    public static function getSubscriptions($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return '用户不存在';
        }

        $user_subscriptions = self::where('user_id', $user_id)->get();
        $subscription_ids = [];
        foreach ($user_subscriptions as $user_subscription) {
            $subscription_ids[] = $user_subscription->designer_id;
        }

        $designers = Designer::whereIn('id', $subscription_ids)->get();
        $lang = Session::get('language') ?? 'zh-CN';
        if ('zh-CN' == $lang) {
            $display_name = "name_cn";
        } else {
            $display_name = "name_en_abbr";
        }

        $categories = DesignerCategory::get();
        $arr_category = [];
        foreach ($categories as $category) {
            $arr_category[$category->id] = $category->$display_name;
        }

        foreach ($designers as &$designer) {
            $tmp = [];
            if ($designer->category_ids) {
                foreach ($designer->category_ids as $category_id) {
                    $tmp[] = [
                        'id' => $category_id,
                        'name' => @$arr_category[$category_id],
                    ];
                }
            }
            $designer->categorys = $tmp;

            // dd($designer);
            $designer->article_num = Article::where('designer_id', 'like', "%,{$designer->id},%")->count();
            $designer->fans_num = UserSubscription::where('designer_id', $designer->id)->count();
            $designer->articles = Article::where('designer_id', 'like', "%,{$designer->id},%")->where('article_status', '2')->where('display', '0')->limit(4)->get();
        }

        return $designers;


    }
    
}
