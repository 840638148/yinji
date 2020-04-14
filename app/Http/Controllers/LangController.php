<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\App;
use Session;
class LangController extends Controller{

    /**
     * 切换语言包
     * 使用方法：http://trolan.tyyke.com:39007/lang/switch?lang=en
     * @param Request $request
     * @return String
     */
    public function language(Request $request){
        $lang = $request->lang;
        if ($lang && in_array($lang, Config::get('app.locales'))) {
            App::setLocale($lang);  //配置默认语言
            $request->session()->put('language', $lang);  //存到session
            $res =  App::getLocale();
        } else {
            $res = $request->session()->get('language'); //获取session
        }
        return $res;
    }
}