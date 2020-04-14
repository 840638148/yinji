<?php
use Illuminate\Support\Facades\Session;
use App\Models\ArticleTag;

function get_real_ip()
{
    $ip=FALSE;
    //客户端IP 或 NONE get_article_thum
    if(!empty($_SERVER["HTTP_CLIENT_IP"])){
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }

    //多重代理服务器下的客户端真实IP地址（可能伪造）,如果没有使用代理，此字段为空
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode (", ", $_SERVER['HTTP_X_FORWARDED_FOR']);
        if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
        for ($i = 0; $i < count($ips); $i++) {
        	if (filter_var($ips[$i], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_NO_PRIV_RANGE)){
        		$ip = $ips[$i];
        		break;
        	}
        	//第一次登录会报500错误，说没有eregi方法
            // if (!eregi ("^(10│172.16│192.168).", $ips[$i])) {
            //     $ip = $ips[$i];
            //     break;
            // }
        }  
    }
    //客户端IP 或 (最后一个)代理服务器 IP 
    return ($ip ? $ip : $_SERVER['REMOTE_ADDR']);
}

/**
 * 获取文章内容html中第一张图片地址
 */
function get_html_first_imgurl($html)
{   
    $pattern = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/";
    preg_match_all($pattern, $html, $matchContent);
    if (isset($matchContent[1][0])) {
        $temp = $matchContent[1][0];
    } else {
        $temp = "public/images/no-image.jpg";//在相应位置放置一张命名为no-image的jpg图片
    }
    return $temp;
}


/**
 * 获取文章作者名字
 */
function get_article_designer($article, $type = null)
{
    $lang = Session::get('language') ?? 'zh-CN';
    if ('zh-CN' == $lang) {
        $title  = $article->title_designer_cn;
    } else {
        $title  = $article->title_designer_en;
    }

    switch ($type) {
        case '1':
            $tmp = explode('|', $title);
            $title = @$tmp[0];
            break;
        case '2':
            $tmp = explode('|', $title);
            $title = @$tmp[1];
            break;
    }
    return $title;
}

/**
 * 获取文章标题
 */
function get_article_title($article, $type = null)
{
    $lang = Session::get('language') ?? 'zh-CN';
    if ('zh-CN' == $lang) {
        $title  = $article->title_designer_cn;
        $title .= $article->title_name_cn ? ' | ' . $article->title_name_cn : '';
        $title .= $article->title_intro_cn ? ' , ' . $article->title_intro_cn : '';
    } else {
        $title  = $article->title_designer_en;
        $title .= $article->title_name_en ? ' | ' . $article->title_name_en : '';
        $title .= $article->title_intro_en ? ',' . $article->title_intro_en : '';
    }
    switch ($type) {
        case '1':
            $tmp = explode('|', $title);
            $title = @$tmp[0];
            break;
        case '2':
            $tmp = explode('|', $title);
            $title = @$tmp[1];
            break;
    }
    return $title;
}


/**
 * 获取文章内容
 */
function get_article_content($article)
{
    $lang = Session::get('language') ?? 'zh-CN';
    if ('zh-CN' == $lang) {
        $content  = $article->detail->content_cn;
    } else {
        $content = $article->detail->content_en;
    }
    return $content;
}

/**
 * 获取文章简要说明
 */
function get_article_description($article)
{
    $lang = Session::get('language') ?? 'zh-CN';
    if ('zh-CN' == $lang) {
        $description  = $article->description_cn ?? str_limit($article->detail->content_cn);
    } else {
        $description = $article->description_en ?? str_limit($article->detail->content_en);
    }
    return $description;
}

/**
 * 获取文章缩略图
 */
function get_article_thum($article)
{   
    // dd($article->detail);
	if (empty($article)) return '';
    if ($article->custom_thum) {
        $first_img_url = url('uploads/' . $article->custom_thum);
    } else {
        $lang = Session::get('language') ?? 'zh-CN';
        if ('zh-CN' == $lang) {
            $first_img_url = get_html_first_imgurl($article->detail->content_cn);
        } else {
            $first_img_url = get_html_first_imgurl($article->detail->content_en);
        }
        if ($first_img_url) {
            $first_img_url = url($first_img_url);
        }
    }

    return $first_img_url;
}



/**
 * 获取文章内容html中所有图片地址
 */
function get_html_all_imgurl($html, $limit = 8)
{
    $pattern = "/<[img|IMG].*?src=[\'|\"](.*?(?:[\.gif|\.jpg|\.png]))[\'|\"].*?[\/]?>/";
    preg_match_all($pattern, $html, $matchContent);

    $tmp = array_slice($matchContent[1], 0, $limit);
    return $tmp;
}

/**
 * 获取文章所有图片
 */
function get_article_all_thum($article, $limit = 8)
{

    $lang = Session::get('language') ?? 'zh-CN';
    if ('zh-CN' == $lang) {
        $all_imgurl = get_html_all_imgurl($article->detail->content_cn, $limit);
    } else {
        $all_imgurl = get_html_all_imgurl($article->detail->content_en, $limit);
    }
    if (is_array($all_imgurl)) {
        foreach ($all_imgurl as & $img) {
            $img = url($img);
        }
    }

    return $all_imgurl;
}

/**
 * 获取文章特色照片
 */
function get_article_special($article)
{

    if ($article->special_photo) {
        $first_img_url = url('uploads/' . $article->special_photo);
    } else {
        $lang = Session::get('language') ?? 'zh-CN';
        if ('zh-CN' == $lang) {
            $first_img_url = get_html_first_imgurl($article->detail->content_cn);
        } else {
            $first_img_url = get_html_first_imgurl($article->detail->content_en);
        }
        if ($first_img_url) {
            $first_img_url = url($first_img_url);
        }
    }

    return $first_img_url;
}


/**
 * 获取文章地域
 */
function get_article_location($article)
{
    $lang = Session::get('language') ?? 'zh-CN';
    if ('zh-CN' == $lang) {
        $location  = $article->location_cn;
    } else {
        $location = $article->location_en;
    }
    return $location;
}


/**
 * 获取文章关键词
 */
function get_article_keyword($article)
{
    $lang = Session::get('language') ?? 'zh-CN';
    $tag_ids = $article->tag_ids;
    if (!$tag_ids) {
        return '';
    }
    if ('zh-CN' == $lang) {
        return $tag_ids;
    } else {
        $obj = ArticleTag::where('display', '0');

        $obj->where(function($query) use($tag_ids){
            $tag_ids = explode(',', $tag_ids);
            foreach ($tag_ids as $tag_id) {
                $query->orWhere('name_en',  $tag_id);
            }
        });
        $tags = $obj->get();
        $tmp = [];
        foreach ($tags as $tag) {
            $tmp[] = $tag->name_en;
        }
        return implode(',', $tmp);
    }



}





/**
 * 获取设计师标题
 */
function get_designer_title($designer)
{
    $lang = Session::get('language') ?? 'zh-CN';
    if ('zh-CN' == $lang) {
        $title  = $designer->title_cn;
    } else {
        $title  = $designer->title_en;
    }
    return $title;
}

/**
 * 获取设计师内容
 */
function get_designer_content($designer)
{
    $lang = Session::get('language') ?? 'zh-CN';
    if ('zh-CN' == $lang) {
        $content  = $designer->detail->content_cn;
    } else {
        $content = $designer->detail->content_en;
    }
    return $content;
}

/**
 * 获取设计师缩略图
 */
function get_designer_thum($designer)
{
    return url('uploads/' . $designer->custom_thum);
}



/**
 * 获取设计师简要说明
 */
function get_designer_description($designer)
{
    $lang = Session::get('language') ?? 'zh-CN';
    if ('zh-CN' == $lang) {
        $description  = str_limit($designer->detail->content_cn);
    } else {
        $description = str_limit($designer->detail->content_en);
    }
    return $description;
}


/**
 * 获取专题标题
 */
function get_topic_title($topic)
{
    $lang = Session::get('language') ?? 'zh-CN';
    if ('zh-CN' == $lang) {
        $title  = $topic->name_cn;
    } else {
        $title  = $topic->name_en;
    }
    return $title;
}