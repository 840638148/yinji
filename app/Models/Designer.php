<?php

namespace App\Models;
use DB;
use App\Models\Company;
use App\Models\CompanyWork;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Designer extends Model
{
    public function detail()
    {
        return $this->hasOne(DesignerDetail::class);
    }
    
    public function shares()
    {
        return $this->hasMany(DesignerShare::class);
    }
    
    public function getCategoryIdsAttribute($value)
    {
        $value = trim($value, ',');
        return explode(',', $value);
    }

    public function setCategoryIdsAttribute($value)
    {
        $this->attributes['category_ids'] = ',' . implode(',', $value) . ',';
    }

    public function getTopicIdsAttribute($value)
    {
        $value = trim($value, ',');
        return explode(',', $value);
    }

    public function setTopicIdsAttribute($value)
    {
        $this->attributes['topic_ids'] = ',' . implode(',', $value) . ',';
    }

    /**
     * 获取select-option
     * @return ArticleCategory[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getSelectOptions()
    {
        $options = self::select('id','title_cn as text')->get();
        $selectOption = [];
        foreach ($options as $option){
            $selectOption[$option->id] = $option->text;
        }
        return $selectOption;
    }

    public static function getDesigners(& $request, $category_ids = [], $keyword = null)
    {
        $obj = Designer::where('designer_status', '1')->where('display', '0');
        // $obj=Db::table('designers')->where('designer_status', 1)->where('display', 0)->orderby('designersavg','desc')->toSql();
        // dd($obj); 

        if ($category_ids) {
            $obj->where(function($query) use($category_ids){
                foreach ($category_ids as $category_id) {
                    $query->orWhere('category_ids', 'like', "%,{$category_id},%");
                }
            });
        }

        if ($keyword) {
            $obj->where(function($query) use($keyword){
                $query->orWhere('title_cn', 'like', "%{$keyword}%");
                $query->orWhere('title_en', 'like', "%{$keyword}%");
            });

            $designers = $obj->orderby('designersavg', 'desc')->paginate(intval($request->per_page), ['*'], 'designers_page');
        }else{
            $designers = $obj->orderby('designersavg', 'desc')->paginate(intval($request->per_page));
        }

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
            $designer->article_num = Article::where('article_status', 2)->where('display', '0')->where('designer_id', 'like', "%,{$designer->id},%")->count();
            $designer->fans_num = UserSubscription::where('designer_id', $designer->id)->count();
            $designer->articles = Article::where('article_status', 2)->where('display', '0')->where('designer_id', 'like', "%,{$designer->id},%")->limit(4)->get();
            $designer->categorys = $tmp;

            $res = Article::where('articles.article_status', '2')
                ->where('articles.display', '0')
                ->where('articles.designer_id', 'like', "%,{$designer->id},%");
            $related_articles = $res->get();
            $starscount = $res ->count('articles.id');

            foreach($related_articles as $k=>$designall){
                $related_articles[$k]['starsavg']=ArticleComment::where('comment_id',$designall['id'])->avg('stars');
                if($related_articles[$k]['starsavg']==''){
                    $related_articles[$k]['starsavg']='5.0';
                }
            }
            $comments_total = ArticleComment::where('comment_id', $designer->id)->where('display', '1')->count();
            foreach($related_articles as $key){
                $comments_total+=$key['starsavg'];
            }
            if($comments_total==0 || $starscount==0){
                $designer->starsav=0;
            }else{
                $starsav=$comments_total/$starscount;
                $designer->starsav=sprintf("%.1f",$starsav);//保留小数点一位            
                if($designer->starsav==''){
                    $result=Designer::where('id',$designer->id)->update(['designersavg'=>'5.0']);
                }else{
                    $result=Designer::where('id',$designer->id)->update(['designersavg'=>$designer->starsav]);
                }
            }
            //以平均分进行降序
            // $dearr=$designers->items();
            // $dearr=collect($dearr)->sortByDesc('starsav')->all();
            // $designers->dearr=$dearr;
        }
        // $designers=$designers->sortByDesc('starsav')->values();
        // dd($designers);
        return $designers;
    }
    
    //设计师分页
    public static function getMoreDesigners(& $request, $category_ids = [])
    {
        $designers = Designer::getDesigners($request, $category_ids);
        $data = [];
        foreach ($designers as $designer) {
            $class = ('1' == $designer->industry) ? 'interior' : 'architect';
            $category_html = '';
            foreach ($designer->categorys as $category) {
                $category_html .= '<a href="#" rel="tag">' . $category['name'] . '</a>';
            }
            
            if ($designer->static_url) {
                $url = url('/designer/' . $designer->static_url);
            } else {
                $url = url('/designer/detail/' . $designer->id);
            }
            $tmp_html = '<li class="layout_li ajaxpost ">
                    <div class="' . $class . '"></div>

                <article class="postgrid design" style="visibility: visible; animation-name: bounceInUp;">
                    <figure> <a href="' . $url . '" title="' . get_designer_title($designer) .'" target="_blank">
                            <img class="thumb" src="' . get_designer_thum($designer) . '" data-original="' . get_designer_thum($designer) . '" alt="' . get_designer_title($designer) . '" style="display: block;"> </a> </figure>
                    <section class="ffe_main">
                        <h2><a href="' . $url . '" title="'. get_designer_title($designer) .'" target="_blank">' .get_designer_title($designer) . '</a></h2>
                        <div class="design_post">
                            <!--分类-->
                            <span class="guojia">
                                ' . $category_html . '
                            </span>
                            <span class="ffe_liulan">' . ($designer->starsav==0 ? '5.0' : $designer->starsav) . '</span></div>
                    </section>
                </article>
            </li>';
            $data[] = $tmp_html;
        }
        return $data;
    }

    public static function getDesigner($id)
    {
        $designer = Designer::find($id);
        if (empty($designer)) {
            return false;
        }

        // dd($designer,$designer->category_ids);
        $lang = Session::get('language') ?? 'zh-CN';
        $tmp = [];
        if ($designer->category_ids) {
            if ('zh-CN' == $lang) {
                $display_name = "name_cn";
            } else {
                $display_name = "name_en";
            }

            $category_ids = $designer->category_ids;
            
            $categories = DesignerCategory::whereIn('id',$category_ids)->get();
            $arr_category = [];
            foreach ($categories as $category) {
                $arr_category[$category->id] = $category->$display_name;
            }

            foreach ($designer->category_ids as $category_id) {
                $tmp[] = [
                    'id' => $category_id,
                    'name' => @$arr_category[$category_id],
                ];
            }
        }
        $designer->company_name=Company::where('id',$designer->company_id)->value('company_name');
        $designer->companyids=CompanyWork::where('company_id',$designer->company_id)->value('id');
        // dd($designer->companyids);
        $is_subscription = UserSubscription::isSubscription($id);
        $designer->is_subscription = $is_subscription;
        $designer->categorys = $tmp;
        $designer->article_num = Article::where('article_status', 2)->where('designer_id', 'like', "%,{$id},%")->count();

        return $designer;
    }

    public static function getRelatedArticle($id)
    {
        $designer = Designer::find($id);

        if (empty($designer)) {
            return [];
        }
        
        
        $obj = Article::where('article_status', '2')
            ->where('display', '0');
        if (is_array($id)) {
            $obj->where(function($query) use($id){
                foreach ($id as $key) {
                    $query->orWhere('designer_id', 'like', "%,{$key},%");
                }
            });
        } else {
            $obj->where('designer_id', 'like', "%,{$designer->id},%");
        }

        $articles = $obj->orderBy('release_time', 'desc')->get();

        $lang = Session::get('language') ?? 'zh-EN';
        if ('zh-EN' == $lang) {
            $display_name = "name_cn";  
        } else {
            $display_name = "name_en";
        }

        $categories = ArticleCategory::get();
        $arr_category = [];
        foreach ($categories as $category) {
            $arr_category[$category->id] = $category->$display_name;
        }

        foreach ($articles as &$article) {
            $tmp = [];
            $article->category = [];
            if ($article->category_ids) {
                foreach ($article->category_ids as $category_id) {
                    $tmp[] = [
                        'id' => $category_id,
                        'name' => @$arr_category[$category_id],
                    ];
                }
            }
            $article->category = $tmp;
        }
        return $articles;
    }

    public static function getRelatedDesigner($id)
    {
        $designer = Designer::find($id);
        if (empty($designer)) {
            return false;
        }

        $designers = Designer::where('designer_status', '1')
            ->where('industry',$designer->industry)
            ->where('id', '!=', $id)
            ->where('display', '0')
            ->where('category_ids', 'like', '%,' . implode(',', $designer->category_ids) . ',%')
            ->limit(10)
            ->get();
       
        // $designers_dif =(object)array();
        if(count($designers)>0 && count($designers)<3){
            $designers_dif = Designer::where('designer_status', '1')
            ->where('industry',$designer->industry)
            ->where('id', '!=', $id)
            ->where('display', '0')
            ->limit(3)
            ->get();
         
            $starscounts=0;
            $comments_totals=0;
            // 根据上面查出相关设计师的id查出设计师旗下的文章
            foreach($designers as $k=>$designall){
                $res = Designer::getRelatedArticle($designall['id']);
                
                $starscounts=count($res);//获取该设计师下作品总数量
                $designers[$k]['count'] = $starscounts;
                $comments = [];
                //根据旗下的文章算出该设计师所有文章的平均分
                if($starscounts==0){
                    $designers[$k]['designersavg']=0;
                }
                // else{
                    
                    // foreach($res as $kk=>$vv){
                    //         $rsavg=DB::table('article_comments')->where('comment_id',$vv['id'])->value('stars');
                    //         $rsavg = ($rsavg!='') ? $rsavg : 5;
                    //         $comments[]=$rsavg;
                    //         $comments_totals+=$rsavg;//总分数
                    //         $designeravg=$comments_totals/$starscounts;
                    //         $designers[$k]['designeravg']=sprintf("%.1f",$designeravg);//保留小数点一位
                    // }
                // }
                // $designers[$k]['comments'] = $comments;
                // $designers[$k]['sum'] = $comments_totals;
                // $comments_totals = 0;//遍历一个设计师后初始化
            }   

            foreach($designers_dif as $k=>$designall){
                $res = Designer::getRelatedArticle($designall['id']);
                // dd($res);
                $starscounts=count($res);//获取该设计师下作品总数量
                $designers_dif[$k]['count'] = $starscounts;
                $comments = [];
                //根据旗下的文章算出该设计师所有文章的平均分
                if($starscounts==0){
                    $designers_dif[$k]['designersavg']=0;
                }
            }   

            $lang = Session::get('language') ?? 'zh-CN';
            if ('zh-CN' == $lang) {  
                $display_name = "name_en_abbr";
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
            }

            // dd($designers_dif);
            foreach ($designers_dif as &$designer) {
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
            }

            $deall=[];
            foreach($designers as $k=>$v){
                $deall[]=$v;
            }

            foreach($designers_dif as $k=>$v){
                $deall[]=$v;
            }
            $deall=collect($deall)->sortByDesc('designersavg');//对平均分进行降序排序
            return $deall;
        }else{
            $starscounts=0;
            $comments_totals=0;
            // 根据上面查出相关设计师的id查出设计师旗下的文章
            foreach($designers as $k=>$designall){
                $res = Designer::getRelatedArticle($designall['id']);

                $starscounts=count($res);//获取该设计师下作品总数量
                $designers[$k]['count'] = $starscounts;
                $comments = [];
                //根据旗下的文章算出该设计师所有文章的平均分
                if($starscounts==0){
                    $designers[$k]['designeravg']=0;
                }else{
                    
                    foreach($res as $kk=>$vv){
                            $rsavg=DB::table('article_comments')->where('comment_id',$vv['id'])->value('stars');
                            $rsavg = ($rsavg!='') ? $rsavg : 5;
                            $comments[]=$rsavg;
                            $comments_totals+=$rsavg;//总分数
                            $designeravg=$comments_totals/$starscounts;
                            $designers[$k]['designeravg']=sprintf("%.1f",$designeravg);//保留小数点一位
                    }
                }
                // $designers[$k]['comments'] = $comments;
                // $designers[$k]['sum'] = $comments_totals;
                $comments_totals = 0;//遍历一个设计师后初始化
            }   

            $designers=collect($designers)->sortByDesc('designeravg');//对平均分进行降序排序

            // dd($designers);

            $lang = Session::get('language') ?? 'zh-CN';
            if ('zh-CN' == $lang) {  
                $display_name = "name_en_abbr";
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
            }
            return $designers;
        }
        
    }
}
