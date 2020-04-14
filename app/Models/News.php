<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class News extends Model
{
    protected $dates = ['created_at', 'updated_at', 'release_time'];
    
    public function getDesignerIdAttribute($value)
    {
        $value = trim($value, ',');
      //var_dump($value);die;
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
        return $this->hasOne(NewsDetail::class);
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

    public static function getNewNewses($limit = 5)
    {
        $obj = News::where('news_status', '1')
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

        $categories = NewsCategory::get();
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

    public static function getHotNewses($limit = 6)
    {
        $obj = News::where('news_status', '1')
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

        $categories = NewsCategory::get();
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


    public static function getNewses(& $request, $category_ids = [], $keyword = null)
    {
        $obj = News::where('news_status', '1')
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

        $newses = $obj->paginate(intval($request->per_page));

        $lang = Session::get('language') ?? 'zh-CN';
        if ('zh-CN' == $lang) {
            $display_name = "name_cn";
        } else {
            $display_name = "name_en";
        }
        $categories = NewsCategory::get();
        $arr_category = [];
        foreach ($categories as $category) {
            $arr_category[$category->id] = $category->$display_name;
        }
        
        foreach ($newses as & $news) {
            $tmp = [];
            $news->category = [];
            if ($news->category_ids) {
                foreach ($news->category_ids as $category_id) {
                    $tmp[] = [
                        'id' => $category_id,
                        'name' => @$arr_category[$category_id],
                    ];
                }
            }
            $news->category = $tmp;
        }
        
        return $newses;
    }

    public static function getNews($id)
    {
        $news = News::find($id);
        if (empty($news)) {
            return false;
        }


        $lang = Session::get('language') ?? 'zh-CN';
        $tmp = [];
        if ($news->category_ids) {
            $news->categorys = $tmp;
            if ('zh-CN' == $lang) {
                $display_name = "name_cn";
            } else {
                $display_name = "name_en";
            }

            $categories = NewsCategory::get();
            $arr_category = [];
            foreach ($categories as $category) {
                $arr_category[$category->id] = $category->$display_name;
            }

            $tmp = [];
            $news->category = [];
            if ($news->category_ids) {
                foreach ($news->category_ids as $category_id) {
                    $tmp[] = [
                        'id' => $category_id,
                        'name' => @$arr_category[$category_id],
                    ];
                }
            }
            $news->category = $tmp;
        }
        return $news;
    }
    
    public static function getMoreNewses(& $request)
    {
        $newses = News::getNewses($request);
        $data = [];
        $iteration = 1;
        foreach ($newses as $news) {
            $tmp_html = '';
            if ($iteration % 3 == 1) {
                $span_html='';
                foreach ($news['category'] as $category) {
                    $span_html .=' <span>'. $category['name'] .'</span>';
                }
                $tmp_html .= '<div class="news">
                    <article class="postlist">
                        <a href="/news/detail/' . $news->id . '">
                            <figure>
                                <img class="thumb" src="' . get_article_special($news) . '" data-original="' . get_article_special($news) . '" alt="' . get_article_title($news) . '" style="display: block;">
                                <div>  
                                ' . $span_html . ' 
                                </div>
                            </figure>
                        </a>
                        <h3> <a href="/news/detail/' . $news->id . '">' . get_article_title($news) . '</a></h3>
                        <div class="news_brief"><a href="/news/detail/' . $news->id . '">' . get_article_description($news) . '</a></div>
                        <div class="homeinfo">
                            <a href="/news/detail/' . $news->id . '">
                                <span class="date">' . str_limit($news->release_time, 10, "") . '</span>
                                <span class="comment">' . $news->view_num . '</span>
                            </a>
                        </div>
                    </article>
                </div>';

            } else {
                if ($iteration % 3 == 2) {
                    $span_html='';
                    foreach ($news['category'] as $category) {
                        $span_html .=' <span>'. $category['name'] .'</span>';
                    }
                    $tmp_html .= '<div class="news2">
                        <ul>
                            <li class="left">
                                <article class="postlist">
                                    <a href="/news/detail/' . $news->id . '">
                                        <figure>
                                            <img class="thumb" src="' . get_article_special($news) . '" data-original="' . get_article_special($news) . '" alt="' . get_article_title($news) . '" style="display: block;">
                                            <div> ' . $span_html . '</div>
                                        </figure>
                                    </a>
                                    <h3> <a href="/news/detail/' . $news->id . '">' . get_article_title($news) . '</a></h3>
                                    <div class="news_brief"><a href="/news/detail/{{$news->id}}">' . get_article_description($news) . '</a></div>

                                    <div class="homeinfo">
                                        <a href="/news/detail/' . $news->id . '">
                                            <span class="date">' . str_limit($news->release_time, 10, '') . '</span>
                                            <span class="comment">' . $news->view_num . '</span>
                                        </a>
                                    </div>
                                </article>
                            </li>';
                }

                if ($iteration % 3 == 0) {
                    $span_html='';
                    foreach ($news['category'] as $category) {
                        $span_html .=' <span>'. $category['name'] .'</span>';
                    }
                    $tmp_html .= '<li class="right">
                        <article class="postlist">
                            <a href="/news/detail/' . $news->id . '">
                                <figure>
                                    <img class="thumb" src="' . get_article_special($news) . '" data-original="' . get_article_special($news) . '" alt="' . get_article_title($news) . '" style="display: block;">
                                    <span> ' . $span_html . '</span>
                                </figure>
                            </a>

                            <h3> <a href="/news/detail/' . $news->id . '">' . get_article_title($news) . '</a></h3>
                            <div class="news_brief"><a href="/news/detail/' . $news->id . '">' . get_article_description($news) . '</a></div>
                            <div class="homeinfo">
                                <a href="/news/detail/' . $news->id . '">
                                    <span class="date">' . str_limit($news->release_time, 10, '') . '</span>
                                    <span class="comment">' . $news->view_num . '</span>
                                </a>
                            </div>
                        </article>
                    </li>
                    </ul>
                    </div>';

                }
            }

            $data[] = $tmp_html;
            $iteration ++;
        }
        if ($iteration % 3 == 2) {
                $data[count($data)-1] .= '</ul></div>';
            }
            
        return $data;
        
    }
}
