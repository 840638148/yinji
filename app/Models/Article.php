<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Article extends Model
{
    protected $dates = ['created_at', 'updated_at', 'release_time'];
    
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

    public function getTopicIdsAttribute($value)
    {
        $value = trim($value, ',');
        return explode(',', $value);
    }

    public function setTopicIdsAttribute($value)
    {
        $this->attributes['topic_ids'] = ',' . implode(',', $value) . ',';
    }

    public function detail()
    {
        return $this->hasOne(ArticleDetail::class);
    }
    
    public static function formatTitle(&$obj, $type='cn')
    {
        $title_designer = "title_designer_{$type}";
        $title_name = "title_name_{$type}";
        $title_intro = "title_intro_{$type}";
        $title = $obj->$title_designer;
        $title .= $obj->$title_name ? ' | ' . $obj->$title_name : '';
        $title .= $obj->$title_intro ? ',' . $obj->$title_intro : '';
        return $title;
    }

    public static function getNewArticles($limit = 5)
    {
        $obj = Article::where('article_status', '2')
            ->where('display', '0')
            ->orderBy('release_time', 'desc');
        if ($limit > 0) {
            $obj->limit($limit);
        }

        $articles = $obj->get();

        $lang = Session::get('language') ?? 'zh-CN';
        if ('zh-CN' == $lang) {
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

            $article->day = date('d', strtotime($article->release_time));
            if ('zh-CN' == $lang) {
                $article->month = date('n月', strtotime($article->release_time));
            } else {
                $article->month = date('M', strtotime($article->release_time));
            }


        }
        return $articles;
    }

    public static function getHotArticles($limit = 5)
    {
        $obj = Article::where('article_status', '2')
            ->where('display', '0')
            ->orderBy('view_num', 'desc');
        if ($limit > 0) {
            $obj->limit($limit);
        }

        $articles = $obj->get();

        $lang = Session::get('language') ?? 'zh-CN';
        if ('zh-CN' == $lang) {
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
        $obj = Article::where('article_status', '2')
            ->where('display', '0')
            ->inRandomOrder();
        if ($limit > 0) {
            $obj->limit($limit);
        }

        $articles = $obj->get();

        $lang = Session::get('language') ?? 'zh-CN';
        if ('zh-CN' == $lang) {
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
        $obj = Article::where('article_status', '2')
            ->where('display', '0')
            ->orderBy('release_time', 'desc');

        if ($category_ids) {
            $obj->where(function($query) use($category_ids){
                foreach ($category_ids as $category_id) {
                    $query->orWhere('category_ids', 'like', "%,{$category_id},%");
                }
            });
        }

        if ($keyword) {
            $obj->where(function($query) use($keyword){
                $query->orWhere('title_designer_cn', 'like', "%{$keyword}%");
                $query->orWhere('title_name_cn', 'like', "%{$keyword}%");
                $query->orWhere('title_intro_cn', 'like', "%{$keyword}%");
                $query->orWhere('title_designer_en', 'like', "%{$keyword}%");
                $query->orWhere('title_name_en', 'like', "%{$keyword}%");
                $query->orWhere('title_intro_en', 'like', "%{$keyword}%");
                $query->orWhere('keyword', 'like', "%{$keyword}%");
                $query->orWhere('description_cn', 'like', "%{$keyword}%");
                $query->orWhere('description_en', 'like', "%{$keyword}%");
            });
        }

        $articles = $obj->paginate(intval($request->per_page));

        $lang = Session::get('language') ?? 'zh-CN';
        if ('zh-CN' == $lang) {
            $display_name = "name_cn";
        } else {
            $display_name = "name_en";
        }
        $categories = ArticleCategory::get();
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
        }

        return $articles;
    }
    
    public static function getMoreArticles(& $request, $category_ids = [])
    {
        $articles = Article::getArticles($request, $category_ids);
        $data = [];
        foreach ($articles as $k=>$article) {
            $category_html = '';
            $articles[$k]['starsavg'] = ArticleComment::where('comment_id', $article['id'])->avg('stars');
            $articles[$k]['starsavg'] = sprintf("%.1f",$articles[$k]['starsavg']);//保留小数点一位
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
                    <div class="interior_dafen">'.($article->starsavg !=0 ? $article->starsavg : "5.0").'</div>
                        <figure>
                            <a href="' . $url . '" title="' .get_article_title($article) . '" target="_blank">
                                <img class="thumb" src="' .get_article_thum($article) . '" data-original="' .get_article_thum($article) . '" alt="' .get_article_title($article) . '" style="display: block;">
                            </a>
                        </figure>
                        <div class="chengshi">' .get_article_location($article) . '</div>
                        <h2>
                            <a href="' . $url . '" title="' .get_article_title($article) . '" target="_blank">
                                <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;">' .get_article_title($article, 1) . '</div>
                                <div style=" color:#666; line-height:24px;">' .get_article_title($article, 2) . '</div>
                            </a>
                        </h2>
                        <div class="homeinfo">
                            <!--分类-->
                            ' . $category_html . '
                            <!--时间-->
                            <span class="date">' .str_limit($article->release_time, 10, '') . '</span>
                            <!--点赞-->
                            <span title="" class="like"><i class="icon-eye"></i><span class="count">' .$article->view_num . '</span></span> </div>
                    </article>
                </li>';
            $data[] = $tmp_html;
        }
        return $data;
        
    }

    public static function getArticle($id)
    {
        $article = Article::find($id);
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

            $categories = ArticleCategory::get();
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
        $article = Article::find($id);

        if (empty($article)) {
            return [];
        }
        
        
        $obj = Article::where('article_status', '2')
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

}
