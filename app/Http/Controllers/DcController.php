<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Http\Error;
use App\Http\Output;
use App\User;
use App\Models\Dc;
use App\Models\Article;
use App\Models\Loupan;
use App\Models\Designer;
use App\Models\UserCollect;
use App\Models\UserCollectFolder;

use DB;

class DcController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';

        $dclists=Dc::orderby('created_at','desc')->paginate(3);
        $loupanlists=Loupan::orderby('created_at','desc')->paginate(3);
        
        // 分页
        if($request->page && $request->page>1) {
            $resule = Dc::getMore($request);
            // dd($request->all());
            return Output::makeResult($request, $resule);
        }

        
    	$data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
            'dclists' => $dclists,
            'loupanlists' => $loupanlists,
        ];

        return view('dichan.index', $data);
    }
        
    //楼盘简介
    public function lpintro(Request $request,$id)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';
        // dd($request->all(),$id);
        $lists=Loupan::where('url',$id)->first();
        $designer=Designer::whereIn('id',$lists->designer_id)->get();
        
        $jz=Article::whereIn('id',$lists->jz_dcarticle_id)->get();
        $yl=Article::whereIn('id',$lists->yl_dcarticle_id)->get();
        $yxzx=Article::whereIn('id',$lists->yxzx_dcarticle_id)->get();
        $gq=Article::whereIn('id',$lists->gq_dcarticle_id)->get();
        $ybf=Article::whereIn('id',$lists->ybf_dcarticle_id)->get();

        // dd($jz,$yl,$yxzx,$gq,$ybf,$hxt);

        // $user_collect_folders=UserCollectFolder::where('user_id', Auth::id())->get();



        $user_collect_folders=UserCollectFolder::where('user_id', Auth::id())->select('id','name')->get();//用户所有收藏夹
        $iscollects=UserCollect::where('user_id', Auth::id())->select('id','collect_id','user_collect_folder_id')->where('collect_type','0')->where('is_sc',1)->get()->toArray();//用户已经收藏的文章

        // $iscollects=UserCollect::where('user_id', Auth::id())->select('user_collect_folder_id',DB::raw('group_concat(collect_id)'))->where('collect_type','0')->where('is_sc',1)->get()->groupBy('user_collect_folder_id')->toArray();//用户已经收藏的文章
        // $iscollects=UserCollect::where('user_id', Auth::id())->select('user_collect_folder_id',DB::raw('group_concat(collect_id) AS collect_ids'))->where('collect_type','0')->where('is_sc',1)->groupBy('user_collect_folder_id')->get()->toArray();//用户已经收藏的文章

        // $user_collect_folder_ids = array_column($iscollects,'user_collect_folder_id');
        // $collect_ids = array_column($iscollects,'collect_ids');
        // $iscollects = array_combine($user_collect_folder_ids,$collect_ids);
        // foreach ($user_collect_folders as &$collect_folder){
        //     $collect_folder['is_collects'] = 2;
        // }
        // unset($collect_folder);

        // foreach ($ybf as &$value){
        //     $value['user_collect_folders'] = $user_collect_folders;
        // }
        // unset($value);
        // $arr=[];
        // foreach ($ybf as $Key =>$val){
        //     foreach ($val['user_collect_folders'] as $ke => $va){
        //         // $arr[] =1;
        //         if ($iscollects[$va['id']]){
        //             $arr[] = in_array($val['id'],explode(',',$iscollects[$va['id']]))?1:2;
        //         }
        //     }
        // }


        // dd($arr);
        // dd($ybf,$user_collect_folders,$iscollects);
        foreach($user_collect_folders as $key => $value){
            foreach($ybf as $v){
                $iscollects=UserCollect::where('user_collect_folder_id',$value['id'])
                    ->where('user_id', Auth::id())
                    ->where('collect_type', '0')
                    ->where('collect_id', $v->id)
                    ->where('is_sc',1)
                    ->first();                
            }

            $user_collect_folders[$key]['iscollects']=$iscollects;

            if($user_collect_folders[$key]['iscollects']){
                $user_collect_folders[$key]['iscollects']='1';
            }else{
                $user_collect_folders[$key]['iscollects']='2';
            }
                       
        }

    	$data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
            'lists' => $lists,
            'designer' => $designer,
            'jz' => $jz,
            'yl' => $yl,
            'yxzx' => $yxzx,
            'gq' => $gq,
            'ybf' => $ybf,
            'user_collect_folders' => $user_collect_folders,
        ];

        return view('dichan.lpintro', $data);
    }
    
    //地产简介
    public function dcintro(Request $request,$id)
    {
        $lang = $request->session()->get('language') ?? 'zh-CN';
        
        $lists=Dc::where('url',$id)->first();
        $articlelist=Loupan::where('dc_id',$lists->id)->orderby('release_time','desc')->paginate(15);
        // dd($designer);

    	$data = [
            'user' => $this->getUserInfo(),
            'lang' => $lang,
            'lists' => $lists,
            'articlelist' => $articlelist,
        ];

        return view('dichan.dcintro', $data);
    }



    // 搜索
    public function search(Request $request){


        $result=Dc::getSearch($request);
        // dd($result);
        if($result['res']!=""){
            return Output::makeResult($request, null, 0, $result); 
        }else{
            return Output::makeResult($request, null, 500, '没有数据'); 
        }

        return $result;
       
    }

    /**
    * 按照评分排序
    * @param Request $request
    * @return array
    * 
    */
    public function allsortlist(Request $request){

        $type=$request->type;//排序类型
        $sjx=$request->sjx;//升/降序
        $cate=$request->cate;//分类的排序
        $data=[];

        $arr=[
            'timesort'=>'release_time',
            'llsort'=>'view_num',
            'starssort'=>[
                'dcarticle'=>'xmavg',
                'lp'=>'lpavg',
                'dc'=>'dcavg',
            ],
            'dcarticle'=>DcArticle::where('status', '2')->where('display', '0'),
            'lp'=>Loupan::query(),
            'dc'=>Dc::query(),   
        ];
        
        $articles =$arr[$cate]->orderBy($type=='starssort'?$arr[$type][$cate]:$arr[$type],$sjx)->paginate(15);

        $html='';
        switch($cate){
            case 'dcarticle':
                foreach ($articles as $article){
                    $html.='<li class="layout_li ajaxpost" id="ajaxpost" >
                                <div class="interior_dafen">'.($article->xmavg?sprintf("%.1f",$article->xmavg):"5.0").'</div>
                                    <article class="postgrid">
                                        <figure>
                                            <a href="/details/'.($article->id).'" title="'.(get_dc_title($article)).'" target="_blank">
                                                <img class="thumb" src="'.(get_dc_thum($article)).'" data-original="'.(get_dc_thum($article)).'" alt="'.(get_dc_title($article)).'" style="display: block;">
                                            </a>
                                        </figure>
                                        <div class="chengshi">'.(get_dc_area($article)).'</div>
                                        <h2>
                                            <a href="/details/'.($article->id).'" title="'.(get_dc_title($article)).'" target="_blank">
                                                <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;">'.(get_dc_title($article, 1)).'</div>
                                                <div style=" color:#666; line-height:24px;">'.(get_dc_title($article, 2)).'</div>
                                            </a>
                                        </h2>
                                        <div class="homeinfo">
                                            <!--分类-->';

                                            if ($article->category){
                                                foreach ($article->category as $category){
                                                    $html.='<a href="/article/category/'.($category['id']).'" rel="category tag">'.($category->name_cn).'</a>';
                                                }
                                            }

                                            $html.='<!--时间-->
                                            <span class="date">'.(str_limit($article->release_time, 10,'')).'</span>
                                            <!--浏览量-->
                                            <span title="" class="like"><i class="icon-eye"></i><span class="count">'.($article->view_num).'</span></span>
                                        </div>
                                    </article>
                            </li>';                        
                }
            break;
            case 'lp':
                foreach ($articles as $k=>$loupan){
                    $html.='<li class="layout_li ajaxpost" id="ajaxpost" >
                            <div class="interior_dafen"><span class="dcpf">'.($loupan->lpavg?sprintf("%.1f",$loupan->lpavg):"5.0").'</span></div>
                            <article class="postgrid">
                                <figure style="height:unset;">
                                <img class="thumb0" src="/uploads/'.($loupan->bgimg).'" data-original="" alt="" style="display: block;">
                                </figure>
                                <div class="chengshi">'.($loupan->area).'</div>
                                <a href="/lpintro/'.($loupan->id).'" target="_blank"><div class="lpbt"><h3>'.($loupan->name).'</h3></div></a>
                            </article>
                            </li>';
                }
            break;
            case 'dc':
                foreach ($articles as $k=>$dc){
                    $html.='<li>
                                <div class="developers_logo"><a href="/dcintro/'.($dc->id).'" target="_blank"><img style="margin-top:50%;" src="/uploads/'.($dc->cover).'" alt="'.($dc->name).'" /></a></div>
                                <div class="property">
                                    <ul>
                                        <li><a href="/dcintro/'.($dc->id).'" target="_blank"><img src="/uploads/'.($dc->cover2).'" alt="'.($dc->name).'" /></a></li>
                                    </ul>
                                </div>
                                <a class="property_prev " href="#"><img src="/images/moandmo.png" alt="上一页" /> </a> <a class="property__next" href="#"><img src="images/moandmo2.png" alt="下一页" /> </a>
                            </li>';
                }
            break;
        }

        // dd(Dc::query());
        /*// 第二种写法
            $arr=[
                'timesort'=>'release_time',
                'llsort'=>'view_num',
                'starssort'=>[
                    'dcarticle'=>'xmavg',
                    'lp'=>'lpavg',
                    'dc'=>'dcavg',
                ]  
            ];
            $dcarticle=DcArticle::where('status', '2')->where('display', '0');
            switch($cate){
                case 'dcarticle':
                    $articles = $dcarticle->orderBy($arr[$type][$cate],$sjx)->paginate(15);
                break;
                case 'lp':
                    $articles = Loupan::orderBy($arr[$type][$cate],$sjx)->paginate(15);
                break;
                case 'dc':
                    $articles = Dc::orderBy($arr[$type][$cate],$sjx)->paginate(15);
                break;
            }
        */
        return Output::makeResult($request,['res'=>$html,'cate'=>$cate]);
    }




}
