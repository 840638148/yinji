<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Dcrticle;
use DB;
use App\Models\DcArticle;
use App\Models\Loupan;
use Illuminate\Support\Facades\Auth;
class Dc extends Model
{
    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    public $table = 'dichans';

    protected $fillable = [
        'name','name_en', 'intro','intro_en','dcavg','cover','tel','address','address_en','email','fax','cover2','area','area_en','designer_id'
    ];

    public static function getSelectOptions()
    {
        $options = self::select('id','title_name as text')->get();
        $selectOption = [];
        foreach ($options as $option){
            $selectOption[$option->id] = $option->text;
        }
        return $selectOption;
    }

    /**
     * 模型自动调用的
     * 修改增加调用修改器 setNameAttribute  其中Name为字段名
     * 查询 调用访问器  getNameAttribute 
     * 
     */

    //将字段修改为json类型，数据库存的时候格式为json格式["qwe","asda"],修改器
    public function setDesignerIdAttribute($value)
    {
        $this->attributes['designer_id'] =  ',' . implode(',', $value) . ',';
    }
    
    // 访问器
    public function getDesignerIdAttribute($value)
    {   
        $value = trim($value, ',');
        return explode(',', $value);
    }
    
    //搜索
    public static function getSearch($request){
        $cates=$request->cate;
        $content=$request->content;
        $html='';
        switch($cates){
            case 'lp':
                $res=LouPan::where(DB::raw("concat_ws('',name,name_en,intro,intro_en)") ,'LIKE', "%$content%")->paginate(15);
                if(count($res)!=0){
                    foreach ($res as $k=>$loupan){
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

                    $data = ['res'=>$html,'cates'=>$cates];
                }else{
                    $data = ['res'=>$html,'cates'=>$cates];
                }
            break;
            case 'dc':
                $res=self::where(DB::raw("concat_ws('',name,name_en,intro,intro_en)") ,'LIKE', "%$content%")->paginate(15);

                if(count($res)!=0){
                    foreach ($res as $k=>$dc){
                        $html.='<li class="layout_li ajaxpost" id="ajaxpost">
                                    <article class="postgrid">
                                        <figure><img class="thumb0" src="/uploads/'.($dc->cover).'" data-original="" alt="" style="display: block;"></figure>
                                        <a href="/dcintro/'.($dc->id).'" target="_blank"><div class="lpbt"><h3>'.($dc->name).'</h3></div></a>
                                    </article>
                                </li>';
                    }

                    $data = ['res'=>$html,'cates'=>$cates];
                }else{
                    $data = ['res'=>$html,'cates'=>$cates];
                }               
            break;
        }

        // if($data['res']!='[]'){
        // if(count($data['res'])!=0){//判断空对象时用这个写法    例如Collection {#items: []}这种就可以用if(count($data['res'])!=0)或者if($data['res']!='[]')
        return $data;

    }

    //分页
    public static function getMore($request){
        $cate= $request->cate;
        $type= $request->type;
        $html='';            
        $arr=[
            'timesort'=>'release_time',
            'llsort'=>'view_num',
            'starssort'=>[
                'lp'=>'lpavg',
                'dc'=>'dcavg',
            ],
            'lp'=>Loupan::query(),
            'dc'=>Dc::query(),   
        ];
        if($request->content){
            return self::getSearch($request);
        }elseif($type){

            switch($cate){
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
                        $html.='<li class="layout_li ajaxpost" id="ajaxpost">
                                    <article class="postgrid">
                                        <figure><img class="thumb0" src="/uploads/'.($dc->cover).'" data-original="" alt="" style="display: block;"></figure>
                                        <a href="/dcintro/'.($dc->id).'" target="_blank"><div class="lpbt"><h3>'.($dc->name).'</h3></div></a>
                                    </article>
                                </li>';
                    }
                break;
            }
            return ['res'=>$html,'cate'=>$cate];
        }else{
            $arr1=[
                'lp'=>Loupan::query(),
                'dc'=>Dc::query(),   
            ];
            $articles =$arr1[$cate]->orderBy('created_at','desc')->paginate(3);
            // dd($articles);
            switch($cate){
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
                    foreach ($articles as $dc){
                        $html.='<li class="layout_li ajaxpost" id="ajaxpost">
                                    <article class="postgrid">
                                        <figure><img class="thumb0" src="/uploads/'.($dc->cover).'" data-original="" alt="" style="display: block;"></figure>
                                        <a href="/dcintro/'.($dc->id).'" target="_blank"><div class="lpbt"><h3>'.($dc->name).'</h3></div></a>
                                    </article>
                                </li>';
                    }
                break;
            }
            return ['res'=>$html,'cate'=>$cate];
        }
    }



}
