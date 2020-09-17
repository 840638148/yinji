<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Error;
use App\Http\Output;
use App\User;
use App\Models\Popularize;
use App\Models\Article;
use App\Models\Designer;
use App\Models\ArticleTag;
use App\Models\ArticleComment;
use App\Models\CompanyWork;


header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods:OPTIONS, GET, POST'); // 允许option，get，post请求
header('Access-Control-Allow-Headers:x-requested-with, content-type'); // 允许x-requested-with请求头


class IndexController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';
        $bannar = Popularize::getPopularize(1);
        $ads_2 = Popularize::getPopularize(2);
        $ads_right = Popularize::getPopularize(3);  
        
        $new_articles = Article::getNewArticles();
        $hot_articles = Article::getHotArticles();
        $lovely = Article::getLovelyArticles();
        
        $master_designers = Popularize::getPopularize(4);
        $noted_designers = Popularize::getPopularize(5);
        $ads_8 = Popularize::getPopularize(8);
        
        foreach($new_articles as $k=>$articleslist){
            $new_articles[$k]['starsavg'] = ArticleComment::where('comment_id', $articleslist['id'])->avg('stars');
            $new_articles[$k]['starsavg'] = sprintf("%.1f",$new_articles[$k]['starsavg']);//保留小数点一位
        }

        // $articleavg=ArticleComment::get()->toArray();
        // $new_articleavg=array_column($articleavg,'stars','comment_id');
        // foreach($new_articles as $k=>$articleslist){
        //     $new_articles[$k]['starsavg'] = sprintf("%.1f",isset($new_articleavg[$articleslist['id']])?$new_articleavg[$articleslist['id']]:5);//保留小数点一位
        // }   

        // dd($new_articles->toArray());

        //获取最新的招聘信息18条
        $joblist=CompanyWork::leftjoin('companies','company_works.company_id','=','companies.id')
        ->select('companies.company_name','company_works.job_name','company_works.addr','company_works.updated_at','company_works.id')
        ->inRandomOrder('company_works.updated_at','desc')
        ->limit(16)
        ->get()->toArray();
        // dd($joblist);

        $hot_tags = ArticleTag::getHotTags();
        $data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
            'bannar' => $bannar,
            'ads_2' => $ads_2,
            'ads_right' => $ads_right,
            'new_articles' => $new_articles,
            'hot_articles' => $hot_articles,
            'master_designers' => $master_designers,
            'noted_designers' => $noted_designers,
            'hot_tags' => $hot_tags,
            'lovely' => $lovely,
            'ads_8' => $ads_8,
            'joblist' => $joblist,
        ];

        return view('index', $data);
    }
}
