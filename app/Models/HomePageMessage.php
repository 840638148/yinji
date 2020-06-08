<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class HomepageMessage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'comment_id','content','type'
    ];

    /**
    * 获取个人主页的评论
    * 
    */
    public static function getMessages($comment_id){

        $res=self::leftjoin('users','users.id','=','homepage_messages.user_id')->select('users.avatar','users.nickname','homepage_messages.user_id','homepage_messages.comment_id','homepage_messages.content','homepage_messages.created_at','homepage_messages.type')->where('homepage_messages.type',2)->where('comment_id',$comment_id)->orderby('homepage_messages.created_at','desc')->get();
        
        // foreach($res as $k=>$v){
        //     $res[$k]['reply_avatar']=User::where('id',$user_id)->value('avatar');
        //     $res[$k]['reply_nickname']=User::where('id',$user_id)->value('nickname');
        // }
       
       
        return $res;
    }

    public static function getReply($user_id,$comment_id){

        $res=self::leftjoin('users','users.id','=','homepage_messages.user_id')->select('users.avatar','users.nickname','homepage_messages.user_id','homepage_messages.comment_id','homepage_messages.content','homepage_messages.created_at','homepage_messages.type')->where('homepage_messages.type',-2)->where('homepage_messages.user_id',$user_id)->orderby('homepage_messages.created_at','desc')->get();
        
        foreach($res as $k=>$v){
            $res[$k]['reply_avatar']=User::where('id',$v->comment_id)->value('avatar');
            $res[$k]['reply_nickname']=User::where('id',$v->comment_id)->value('nickname');
        }
       
    //    dd($res);
        return $res;
    }
}
