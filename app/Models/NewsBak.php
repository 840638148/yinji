<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsBak extends Model
{

    public static function getNewses(& $request, $where = null)
    {
        $obj = News::where('display', '0');

        if ($where) {
            $obj->where($where);
        }

        $newses = $obj->paginate(intval($request->per_page));
        return $newses;
    }

    public static function getHotNews(& $request, $where = null)
    {
        $obj = News::where('display', '0');

        if ($where) {
            $obj->where($where);
        }
        $obj->orderBy('view_num', 'desc');

        $newses = $obj->paginate(intval($request->per_page));
        return $newses;
    }

    public static function getNews($id)
    {
        $news = News::where('display', '0')
            ->where('id', $id)
            ->first();

        return $news;
    }
}
