<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


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


            $designer->article_num = Article::where('designer_id', 'like', "%,{$designer->id},%")->count();
            $designer->fans_num = UserSubscription::where('designer_id', $designer->id)->count();
            $designer->articles = Article::where('designer_id', 'like', "%,{$designer->id},%")->limit(4)->get();
        }

        return $designers;


    }
    
}
