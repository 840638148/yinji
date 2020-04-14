<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'IndexController@index');

//语言切换
Route::get('lang/switch', 'LangController@language');

Route::fallback('NotFoundController@index');


/*Route::get('static/promotion', function () {
    return view('static.promotion');
});
*/

//登录
Route::get('user/login', 'UserController@login');
Route::post('user/login', 'UserController@doLogin');
Route::get('user/logout', 'UserController@logout');
Route::get('user/register', 'UserController@register');
Route::get('user/forgot_password', 'UserController@forgotPassword');
Route::post('user/verify_code', 'UserController@checkCode');
Route::post('user/register', 'UserController@doRegister');
Route::post('user/reset_password', 'UserController@resetPassword');


//微信的登录授权
Route::get('auth/weixin', 'ThirdLogin\WeixinController@redirectToProvider');
Route::get('auth/weixin/callback','ThirdLogin\WeixinController@handleProviderCallback');

//支付回调
Route::any('notify/weixin','VipController@weixinNotify');
Route::any('notify/alipay','VipController@alipayNotify');

//新浪微博的登录授权
Route::get('auth/weibo', 'ThirdLogin\WeiboController@redirectToProvider');
Route::get('auth/weibo/callback', 'ThirdLogin\WeiboController@handleProviderCallback');

//QQ的登录授权
Route::get('auth/qq', 'ThirdLogin\QqController@redirectToProvider');
Route::get('auth/qq/callback', 'ThirdLogin\QqController@handleProviderCallback');


//新闻
Route::get('news', 'NewsController@lists');
Route::get('news/detail/{id}', 'NewsController@detail');
Route::get('news_ajax', 'NewsController@listsAjax');
Route::post('news/like', 'NewsController@like');


//设计师
Route::get('designer', 'DesignerController@lists');
Route::get('designer/detail/{id}', 'DesignerController@detail');
Route::get('designer/category/{id}', 'DesignerController@category');
Route::post('designer/like', 'DesignerController@like');
Route::post('designer/subscription', 'DesignerController@subscription');

//文章
Route::get('article', 'ArticleController@lists');      //所有
Route::get('interiors', 'ArticleController@interior');  //室内
Route::get('interior', 'ArticleController@interior');  //室内
Route::get('interior_ajax', 'ArticleController@interiorAjax');  //室内
Route::get('interior/category/{id}_ajax', 'ArticleController@interiorCategoryAjax');  //室内更多带分页
Route::get('archs', 'ArticleController@archs');        //建筑
Route::get('archs_ajax', 'ArticleController@archsAjax');        //建筑
Route::get('archs/category/{id}_ajax', 'ArticleController@archsCategoryAjax');        //建筑更多带分页
Route::get('article/detail/{id}', 'ArticleController@detail');
Route::get('article/category/{id}', 'ArticleController@category');
Route::get('interior/category/{id}', 'ArticleController@interiorCategory');
Route::get('archs/category/{id}', 'ArticleController@archsCategory');
Route::post('article/like', 'ArticleController@like');
Route::post('article/collect', 'ArticleController@collect');
Route::post('article/vip_download', 'ArticleController@vipDownload');
Route::post('article/allsortlist', 'ArticleController@allsortlist');    //点击进行排序



//专题
Route::get('topic/{id}', 'TopicController@detail');


//个人中心 - 查看自己
Route::get('member', 'MemberController@index');
Route::get('member/order', 'MemberController@order');
Route::get('member/finder', 'MemberController@finder');
Route::get('member/finder_detail/{id}', 'MemberController@finderDetail');
Route::get('member/collect', 'MemberController@collect');
Route::get('member/collect_detail/{id}', 'MemberController@collectDetail');
Route::get('member/subscription', 'MemberController@subscription');
Route::get('member/follow', 'MemberController@follow');
Route::get('member/point', 'MemberController@point');
Route::get('member/profile', 'MemberController@profile');
Route::get('member/interest', 'MemberController@interest');
Route::post('member/edit', 'MemberController@edit');
Route::post('member/add_follow', 'MemberController@addFollow');
Route::post('member/cancel_follow', 'MemberController@cancelFollow');
Route::post('member/cancel_subscription', 'MemberController@cancelSubscription');
Route::post('member/attendance', 'MemberController@attendance');
Route::post('member/delete_finder_item', 'MemberController@deleteFinderItem');  //删除个人发现的一张图片
Route::post('member/delete_folder_item', 'MemberController@deleteFolderItem');  //删除个人收藏中心的一张图片
Route::post('member/comment', 'MemberController@comment');
Route::post('member/upload_img', 'MemberController@uploadImg');

//用户中心 - 查看其它用户
Route::get('user/index/{id}', 'MemberController@info');
Route::get('user/finder/{id}', 'MemberController@finder');
Route::get('user/collect/{id}', 'MemberController@collect');
Route::get('user/subscription/{id}', 'MemberController@subscription');
Route::get('user/follow/{id}', 'MemberController@follow');
Route::get('user/info/{id}', 'MemberController@profile');
Route::get('user/trace/{id}', 'MemberController@profile');

//VIP相关
Route::get('vip/intro', 'VipController@intro');
Route::get('vip/vip_service', 'VipController@vip_service');
Route::get('vip/ad', 'VipController@ad');
Route::get('vip/promotion', 'VipController@promotion');
Route::get('vip/job_service', 'VipController@job_service');
Route::get('finder', 'VipController@finder');
Route::post('vip/buy', 'VipController@buy');
Route::get('vip/pay', 'VipController@pay');
Route::post('vip/wxbuy', 'VipController@wxbuy');
Route::get('vip/pre_pay', 'VipController@prePay');
Route::post('vip/add_finder_folder', 'VipController@addFinderFolder');
Route::post('vip/add_collect_folder', 'VipController@addCollectFolder');
Route::post('vip/delete_folder', 'VipController@deleteFolder');
Route::post('vip/edit_folder', 'VipController@editFolder');
Route::post('vip/add_finder', 'VipController@addFinder');
Route::post('vip/get_folder_detail', 'VipController@getFolderDetail');
Route::post('vip/get_folder_info', 'VipController@getFolderInfo');
Route::post('vip/edit_folder_info', 'VipController@editFolderInfo');

Route::get('folderlist/{id}', 'VipController@folderlist');//推荐收藏夹列表
Route::post('vip/addfolders', 'VipController@addfolders');//推荐收藏夹列表
Route::post('vip/scstatus', 'VipController@scstatus');//推荐收藏夹列表收藏的真实状态



//工作
Route::get('job', 'JobController@index');
Route::get('job/detail/{id}', 'JobController@detail');
Route::get('job/apply', 'JobController@apply');
Route::get('job/searchjob', 'JobController@searchjob');

//搜索
Route::get('search', 'SearchController@index');
Route::get('hot_search_ajax', 'SearchController@hotSearch');