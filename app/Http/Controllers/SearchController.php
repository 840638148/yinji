<?php
namespace App\Http\Controllers;

use App\Http\Error;
use App\Http\Output;
use App\Models\Article;
use App\Models\Designer;
use App\Models\News;
use App\Models\HotSearch;
use App\Models\UserCollectFolder;
use App\Models\UserFinderFolder;
use App\Models\CompanyWork;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Session;
class SearchController extends Controller{


    public function index(Request $request){
        $lang = $request->session()->get('language') ?? 'zh-CN';

        $keyword = $request->keyword;
        $articles = Article::getArticles($request, [], $keyword);
        $newses = News::getNewses($request, [], $keyword);
        $designers = Designer::getDesigners($request, [], $keyword);
        $finders = UserFinderFolder::getFinderFolders($request, $keyword);
        $collects = UserCollectFolder::getFinderFolders($request, $keyword);
        
        $company_work=new CompanyWork();  
        $jobs=$company_work->getJob($request);
        
        
        // $model=new \App\Models\CompanyWork; //实例化model
		// $jobs = $model -> getJob(); //调用model层中方法
    	// var_dump($jobs);die;
        
        
        // $jobs = [];

        $data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
            'keyword' => $keyword,
            'articles' => $articles,
            'newses' => $newses,
            'designers' => $designers,
            'finders' => $finders,
            'collects' => $collects,
            'jobs' => $jobs,
        ];
        return view('search', $data);
    }
	
	public function hotSearch(Request $request)
	{
		$lang = $request->session()->get('language') ?? 'zh-CN';
		if ('zh-CN' == $lang) {
            $display_name = "name_cn";
        } else {
            $display_name = "name_en";
        }

        $hot_searches = HotSearch::where('display', '0')->get();
        $arr_hot = [];
        foreach ($hot_searches as $hot_search) {
            $arr_hot[$hot_search->id] = $hot_search->$display_name;
        }
		return Output::makeResult($request, $arr_hot);
	}
}