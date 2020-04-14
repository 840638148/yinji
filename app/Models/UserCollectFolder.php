<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UserCollectFolder extends Model
{
    protected $fillable = [
        'user_id', 'name', 'is_open', 'brief'
    ];

    public function collects()
    {
        return $this->hasMany(UserCollect::class);
    }

    /**
     * 获取select-option
     * @return DesignerCategory[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function getSelectOptions()
    {
        $options = self::select('id','name as text')->get();
        $selectOption = [];
        foreach ($options as $option){
            $selectOption[$option->id] = $option->text;
        }
        return $selectOption;
    }


    public static function getSelectOptionsByUserId($user_id)
    {
        $options = self::where('user_id', $user_id)->select('id','name as text')->get();
        $selectOption = [];
        foreach ($options as $option){
            $selectOption[$option->id] = $option->text;
        }
        return $selectOption;
    }

    public static function getFinderFolders(& $request, $keyword = null)
    {
        $obj = UserCollectFolder::where('is_open', '1');

        if ($keyword) {
            $obj->where(function($query) use($keyword){
                $query->orWhere('name', 'like', "%{$keyword}%");
                $query->orWhere('brief', 'like', "%{$keyword}%");
            });
        }


        $collectFolders = $obj->paginate(intval($request->per_page));

        foreach ($collectFolders as & $collectFolder) {
            $user_collects = UserCollect::where('user_collect_folder_id', $collectFolder->id)->limit(4)->get();
            $tmp = [];
            foreach ($user_collects as $user_collect) {
                $collect_obj = Article::find($user_collect->collect_id);
                if ($collect_obj->static_url) {
                    $url = url('/article/' . $collect_obj->static_url);
                } else {
                    $url = url('/article/detail/' . $collect_obj->id);
                }
                $tmp[] = [
                    'img' =>get_article_thum($collect_obj),
                    'url' => $url
                ];

            }
            $collectFolder->imgs = $tmp;

        }
        return $collectFolders;
    }

}
