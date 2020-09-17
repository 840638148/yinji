<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use App\Http\Error;
use App\Http\Output;
use App\Models\DcCategory;
use DB;
class DcArticle extends Model
{
    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    // public $table = 'dc_articles';

    protected $fillable = [
        'name','name_en', 'intro','intro_en','xmavg','bgimg','lp_id','content','content_en','display','status','url','area','area_en','view_num','favorite_num','download','seo_title','seo_keyword','seo_desc','created_at','updated_at','designer_id','designer_en','designer','tag_ids','category_ids',
    ];


    public function getDesignerIdAttribute($value)
    {
        $value = trim($value, ',');
        return explode(',', $value);
    }

    public function setDesignerIdAttribute($value)
    {
        $this->attributes['designer_id'] =  ',' . implode(',', $value) . ',';
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


    public function detail()
    {
        return $this->hasOne(DcArticleDetail::class);
    }   

    public static function formatTitle(&$obj, $type='cn')
    {
        $title_designer = "designer_{$type}";
        $title_name = "name_{$type}";
        $title_intro = "intro_{$type}";
        $title = $obj->$title_designer;
        $title .= $obj->$title_name ? ' | ' . $obj->$title_name : '';
        $title .= $obj->$title_intro ? ',' . $obj->$title_intro : '';
        return $title;
    }

    public static function getHotArticles($limit = 5)
    {
        $obj = self::where('status', '2')
            ->where('display', '0')
            ->orderBy('view_num', 'desc');
        if ($limit > 0) {
            $obj->limit($limit);
        }

        $articles = $obj->get();

        $lang = Session::get('language') ?? 'zh-CN';
        if ('zh-CN' == $lang) {
            $display_name = "name";
        } else {
            $display_name = "name_en";
        }

        $categories = DcCategory::get();
        $arr_category = [];
        foreach ($categories as $category) {
            $arr_category[$category->id] = $category->$display_name;
        }
        
        foreach ($articles as &$article) {
            $tmp = [];
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

    public static function getLovelyArticles($limit = 5)
    {
        $obj = self::where('status', '2')
            ->where('display', '0')
            ->inRandomOrder();
        if ($limit > 0) {
            $obj->limit($limit);
        }

        $articles = $obj->get();

        $lang = Session::get('language') ?? 'zh-CN';
        if ('zh-CN' == $lang) {
            $display_name = "name";
        } else {
            $display_name = "name_en";
        }

        $categories = DcCategory::get();
        $arr_category = [];
        foreach ($categories as $category) {
            $arr_category[$category->id] = $category->$display_name;
        }
        
        foreach ($articles as &$article) {
            $tmp = [];
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


    public static function getArticles(& $request, $category_ids = [], $keyword = null)
    {
        if($request->category_id){
            $obj = self::where('status', '2')->where('display', '0');
            if($request->type=='starssort'){
                if($request->sjx=='desc'){
                    $obj = $obj->orderBy('xmavg','desc');
                }else{
                    $obj = $obj->orderBy('xmavg','asc');
                }
            }
                   
            if($request->type=='timesort'){
                if($request->sjx=='desc' ){
                    $obj = $obj->orderBy('release_time','desc');
                }else{
                    $obj = $obj->orderBy('release_time','asc');
                }
            }
            
            if($request->type=='llsort'){
                if($request->sjx=='desc'){
                    $obj = $obj->orderBy('view_num','desc');
                }else{
                    $obj = $obj->orderBy('view_num','asc');
                }
            }
        }else{
            $obj = Article::where('status', '2')->where('display', '0')->orderBy('release_time', 'desc');
        }

        if ($category_ids) {
            $obj->where(function($query) use($category_ids){
                foreach ($category_ids as $category_id) {
                    $query->orWhere('category_ids', 'like', "%,{$category_id},%");
                }
            });
        }

        if ($keyword) {

            $obj->where(DB::raw("concat_ws('',designer,name,intro,designer_en,name_en,intro_en,keyword,description,description_en)") ,'LIKE', "%$keyword%");


            $articles = $obj->paginate(intval($request->per_page), ['*'], 'articles_page');
        }else{
            $articles = $obj->paginate(intval($request->per_page));
        }
        
        $lang = Session::get('language') ?? 'zh-CN';
        if ('zh-CN' == $lang) {
            $display_name = "name_cn";
        } else {
            $display_name = "name_en";
        }
        $categories = DcCategory::get();
        $arr_category = [];
        foreach ($categories as $category) {
            $arr_category[$category->id] = $category->$display_name;
        }
        
        foreach ($articles as & $article) {
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
            $aavg=DcArticleComment::where('comment_id',$article->id)->avg('stars');
            if($article->article_avg){
                $result=self::where('id',$article->id)->update(['article_avg'=>$aavg]);
            }
            else{
                $result=self::where('id',$article->id)->update(['article_avg'=>'5.0']);
            }
        }

        return $articles;
    }
    
    public static function getMoreArticles(& $request, $category_ids = [])
    {
        $data = [];

        if($request->category_id){
            $category_ids = [$request->category_id];
            $articles = self::getArticles($request, $category_ids);
            foreach ($articles as $k=>$article) {
                $category_html = '';
                if ($article->category) {
                    foreach ($article->category as $category) {
                        $category_html .= ' <a href="/article/category/' .$category['id'] . '" rel="category tag">' .$category['name'] . '</a>';
                    }
                }
                if ($article->static_url) {
                    $url = url('/article/' . $article->static_url);
                } else {
                    $url = url('/article/detail/' . $article->id);
                }
                $tmp_html = '<li class="layout_li ajaxpost">
                            <article class="postgrid">
                            <div class="interior_dafen">'.($article->xmavg !="" || $article->xmavg !=null ? sprintf("%.1f",$article->xmavg) : "5.0").'</div>
                        <figure>
                        <a href="' . $url . '" title="' .get_dc_title($article) . '" target="_blank">
                            <img class="thumb" src="' .get_dc_thum($article) . '" data-original="' .get_dc_thum($article) . '" alt="' .get_dc_title($article) . '" style="display: block;">
                        </a>
                    </figure>
                    <div class="chengshi">' .get_dc_area($article) . '</div>
                    <h2>
                        <a href="' . $url . '" title="' .get_dc_title($article) . '" target="_blank">
                            <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;">' .get_dc_title($article, 1) . '</div>
                            <div style=" color:#666; line-height:24px;">' .get_dc_title($article, 2) . '</div>
                        </a>
                    </h2>
                    <div class="homeinfo">
                        <!--分类-->
                        ' . $category_html . '
                        <!--时间-->
                        <span class="date">' .str_limit($article->release_time, 10, "") . '</span>
                        <!--点赞-->
                        <span title="" class="like"><i class="icon-eye"></i><span class="count">' .$article->view_num . '</span></span> </div>
                    </article>
                </li>';
                $data[] = $tmp_html;
            }


        }else if(empty($request->category_id) && $request->type && $request->sjx){

            $aris=self::where('status', '2')->where('display', '0');

            if($request->type=='starssort'){
                if($request->sjx=='desc'){
                    $articles = $aris->orderBy('xmavg','desc')->paginate(15);
                }else{
                    $articles = $aris->orderby('xmavg','asc')->paginate(15);
                }
            }
                   
            if($request->type=='timesort'){
                if($request->sjx=='desc' ){
                    $articles = $aris->orderBy('release_time','desc')->paginate(15);
                }else{
                    $articles = $aris->orderBy('release_time','asc')->paginate(15);
                }
            }
            
            if($request->type=='llsort'){
                if($request->sjx=='desc'){
                    $articles = $aris->orderBy('view_num','desc')->paginate(15);
                }else{
                    $articles = $aris->orderBy('view_num','asc')->paginate(15);
                }
            }

            foreach ($articles as $k=>$article) {
                $category_html = '';
                if ($article->category) {
                    foreach ($article->category as $category) {
                        $category_html .= ' <a href="/article/category/' .$category['id'] . '" rel="category tag">' .$category['name'] . '</a>';
                    }
                }
                if ($article->static_url) {
                    $url = url('/article/' . $article->static_url);
                } else {
                    $url = url('/article/detail/' . $article->id);
                }
                $tmp_html = '<li class="layout_li ajaxpost">
                                <article class="postgrid">
                                <div class="interior_dafen">'.($article->xmavg !=""  || $article->xmavg !=null ? sprintf("%.1f",$article->xmavg) : "5.0").'</div>
                                <figure>
                                <a href="' . $url . '" title="' .get_dc_title($article) . '" target="_blank">
                                    <img class="thumb" src="' .get_dc_thum($article) . '" data-original="' .get_dc_thum($article) . '" alt="' .get_dc_title($article) . '" style="display: block;">
                                </a>
                                </figure>
                                <div class="chengshi">' .get_dc_area($article) . '</div>
                                <h2>
                                    <a href="' . $url . '" title="' .get_dc_title($article) . '" target="_blank">
                                        <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;">' .get_dc_title($article, 1) . '</div>
                                        <div style=" color:#666; line-height:24px;">' .get_dc_title($article, 2) . '</div>
                                    </a>
                                </h2>
                                <div class="homeinfo">
                                    <!--分类-->
                                    ' . $category_html . '
                                    <!--时间-->
                                    <span class="date">' .str_limit($article->release_time, 10, "") . '</span>
                                    <!--点赞-->
                                    <span title="" class="like"><i class="icon-eye"></i><span class="count">' .$article->view_num . '</span></span> </div>
                                </article>
                            </li>';
                $data[] = $tmp_html;
            }
            return $data;

         
        }else{
            $articles = self::getArticles($request, $category_ids);
            foreach ($articles as $k=>$article) {
                $category_html = '';
                if ($article->category) {
                    foreach ($article->category as $category) {
                        $category_html .= ' <a href="/article/category/' .$category['id'] . '" rel="category tag">' .$category['name'] . '</a>';
                    }
                }

                if ($article->static_url) {
                    $url = url('/article/' . $article->static_url);
                } else {
                    $url = url('/article/detail/' . $article->id);
                }
                $tmp_html = '<li class="layout_li ajaxpost">
                            <article class="postgrid">
                            <div class="interior_dafen">'.($article->xmavg !=""  || $article->xmavg !=null ? sprintf("%.1f",$article->xmavg) : "5.0").'</div>
                            <figure>
                                <a href="' . $url . '" title="' .get_dc_title($article) . '" target="_blank">
                                    <img class="thumb" src="' .get_dc_thum($article) . '" data-original="' .get_dc_thum($article) . '" alt="' .get_dc_title($article) . '" style="display: block;">
                                </a>
                            </figure>
                            <div class="chengshi">' .get_dc_area($article) . '</div>
                            <h2>
                                <a href="' . $url . '" title="' .get_dc_title($article) . '" target="_blank">
                                    <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;">' .get_dc_title($article, 1) . '</div>
                                    <div style=" color:#666; line-height:24px;">' .get_dc_title($article, 2) . '</div>
                                </a>
                            </h2>
                            <div class="homeinfo">
                                <!--分类-->
                                ' . $category_html . '
                                <!--时间-->
                                <span class="date">' .str_limit($article->release_time, 10, "") . '</span>
                                <!--点赞-->
                                <span title="" class="like"><i class="icon-eye"></i><span class="count">' .$article->view_num . '</span></span> </div>
                        </article>
                    </li>';
                $data[] = $tmp_html;
            }
        }
        // dd($data);
        return $data;
        
    }

    public static function getArticle($id)
    {   

        $article = self::find($id);

        if (empty($article)) {
            return false;
        }

        $lang = Session::get('language') ?? 'zh-CN';
        $tmp = [];
        if ($article->category_ids) {
            $article->categorys = $tmp;
            if ('zh-CN' == $lang) {
                $display_name = "name_cn";
            } else {
                $display_name = "name_en";
            }

            $categories = DcCategory::get();
            
            $arr_category = [];
            foreach ($categories as $category) {
                $arr_category[$category->id] = $category->$display_name;
            }

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
       
        return $article;
    }

    public static function getRelatedArticle($id)
    {
        $article = self::find($id);

        if (empty($article)) {
            return [];
        }
        
        
        $obj = self::where('status', '2')
            ->where('display', '0')
            ->where('id', '!=', $id);
        if ($article->tag_ids) {
            $arr_tags = explode(',', trim($article->tag_ids, ','));
            $obj->where(function($query) use($arr_tags){
                foreach ($arr_tags as $key) {
                    $query->orWhere('tag_ids', 'like', "%,{$key},%");
                }
            });
        }

        $articles = $obj->orderBy('release_time', 'desc')->limit(6)->get();

        $lang = Session::get('language') ?? 'zh-CN';
        if ('zh-CN' == $lang) {
            $display_name = "name";
        } else {
            $display_name = "name_en";
        }

        $categories = DcCategory::get();
        
        $arr_category = [];
        foreach ($categories as $category) {
            $arr_category[$category->id] = $category->name_cn;
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

}
