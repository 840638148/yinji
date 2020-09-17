<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use App\Models\Article;
use App\User;
use DB;

class RedisController extends Controller
{
    public function testRedis(Request $request){
        // Redis::set('name', 'guwenjie');
        // $values = Redis::get('name');
        // dd($values);
        //输出："guwenjie"
        //加一个小例子比如网站首页某个人员或者某条新闻日访问量特别高，可以存储进redis，减轻内存压力
        // $article_redis = Article::get();
        // $user_redis = User::get();
        // Redis::set('article',$article_redis,'EX',60);//60秒后过期
        // if(Redis::exists('article')){
        //     $values = Redis::get('article');
        // }else{
        //     $values = Article::get();//此处为了测试你可以将id=1200改为另一个id
        // }
        // $a=Redis::ttl('article');//获取缓存时间


        //使用cache缓存
        // $article_cache = Article::get();
        // $user_cache = User::get();
        // Cache::put('article',$article_cache,1);

        // $value = Cache::remember('users', $minutes, function() { 
        //     return DB::table('users')->get(); 
        // });

        // if(Cache::has('article')){
        //     $article_cache=Cache::get('article');
        //     dd('还在');
        // }else{
        //     // $user_cache = User::get();
        //     // Cache::put('article',$article_cache,1);
        //     dd('不在了');
        // }

        // 或者可以用Cache::remember('users', $minutes, function() { return DB::table('users')->get(); });

        // $res=Cache::remember('vip_prices', 1, function() { 
        //     return DB::table('vip_prices')->get();
        // });
        // dd($res);
        
        dd(storage_path('app/file.txt'));
    }
}
