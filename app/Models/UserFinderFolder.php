<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class UserFinderFolder extends Model
{
    protected $fillable = [
        'user_id', 'name', 'is_open', 'brief'
    ];

    public function finders()
    {
        return $this->hasMany(UserFinder::class);
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
    	//根据用户id查出创建的收藏夹名
        $options = self::where('user_id', $user_id)->select('id','name as text')->get();
        $selectOption = [];
        foreach ($options as $option){
            $selectOption[$option->id] = $option->text;
        }
        return $selectOption;
    }

    public static function getFinderFolders(& $request, $keyword = null)
    {
        $obj = UserFinder::where('title', 'like', "%{$keyword}%")
            ->groupBy('photo_url');


        $finders = $obj->paginate(intval($request->per_page));
        return $finders;
    }

}
