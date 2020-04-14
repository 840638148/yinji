<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    public function getCategoryIdsAttribute($value)
    {
        $value = trim($value, ',');
        return explode(',', $value);
    }

    public function setCategoryIdsAttribute($value)
    {
        $this->attributes['category_ids'] = ',' . implode(',', $value) . ',';
    }

    /**
     * 获取select-option
     * @return ArticleCategory[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getSelectOptions()
    {
        $options = self::select('id','name_cn as text')->get();
        $selectOption = [];
        foreach ($options as $option){
            $selectOption[$option->id] = $option->text;
        }
        return $selectOption;
    }

    /**
     * @param $id
     * @return array
     */
    public static function getTopicArticleIds($id)
    {
        $topic_articles = Article::where('topic_ids', 'like', "%{$id}%")->where('display', '0')->get();
        $ids = [];
        foreach ($topic_articles as $topic_article) {
            $ids[] = $topic_article->id;
        }
        return $ids;
    }

    public static function getHotArticle($id)
    {
        $ids = self::getTopicArticleIds($id);
        $article = Article::whereIn('id', $ids)->orderBy('view_num', 'desc')->first();
        if ($article) {
            $result = Article::getArticle($article->id);
        } else {
            $result = '';
        }
        return $result;
    }

    public static function getHotArticleMore($id)
    {
        $ids = self::getTopicArticleIds($id);
        $articles = Article::whereIn('id', $ids)->orderBy('view_num', 'desc')->offset(1)->limit(3)->get();
        return $articles;
    }

    public static function getNewsArticles($id)
    {
        $ids = self::getTopicArticleIds($id);
        $articles = Article::whereIn('id', $ids)->orderBy('release_time', 'desc')->limit(8)->get();
        return $articles;
    }

    public static function getDesigners($id)
    {
        $topic_designers = Designer::where('topic_ids', 'like', "%{$id}%")->get();
        $ids = [];
        foreach ($topic_designers as $topic_designer) {
            $ids[] = $topic_designer->id;
        }
        $designers = Designer::whereIn('id', $ids)->orderBy('view_num', 'desc')->get();
        return $designers;
    }

    public static function getArticles($id)
    {
        $ids = self::getTopicArticleIds($id);
        $articles = Article::whereIn('id', $ids)->orderBy('release_time', 'desc')->get();
        return $articles;
    }
}
