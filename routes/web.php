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
Route::post('user/send_email_code', 'UserController@send_email_code');//注册邮箱发送
Route::post('user/forget_email_code', 'UserController@forget_email_code');//忘记密码邮箱发送


//微信的登录授权
Route::get('auth/weixin', 'ThirdLogin\WeixinController@redirectToProvider');
Route::get('auth/weixin/callback','ThirdLogin\WeixinController@handleProviderCallback');
Route::get('member/wxbd','MemberController@wxbd');
Route::get('member/wxbd_callbakc','MemberController@wxbd_callbakc');


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
Route::post('interior_ajax', 'ArticleController@interiorAjax');  //室内
Route::post('interior/category/{id}_ajax', 'ArticleController@interiorCategoryAjax');  //室内更多带分页
Route::get('archs', 'ArticleController@archs');        //建筑
Route::post('archs_ajax', 'ArticleController@archsAjax');        //建筑
Route::post('archs/category/{id}_ajax', 'ArticleController@archsCategoryAjax');        //建筑更多带分页
Route::get('article/detail/{id}', 'ArticleController@detail');
Route::get('article/category/{id}', 'ArticleController@category');
Route::get('interior/category/{id}', 'ArticleController@interiorCategory');
Route::get('archs/category/{id}', 'ArticleController@archsCategory');
Route::post('article/like', 'ArticleController@like');
Route::post('article/collect', 'ArticleController@collect');//文章详情收藏
Route::post('article/vip_download', 'ArticleController@vipDownload');//用户免费下载
Route::post('article/exchange', 'ArticleController@exchange');//用户使用印币抵扣下载
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
Route::post('member/upload_img', 'MemberController@uploadImg');//修改用户的上传头像
Route::post('member/upload_imgs', 'MemberController@uploadImgs');//修改用户的个人主图
Route::post('member/baseedit', 'MemberController@baseedit');//修改用户的基本信息
Route::post('vip/duihuanvip', 'VipController@duihuanvip');//兑换会员
Route::post('member/is_enough_points', 'MemberController@is_enough_points');//积分是否够
Route::get('member/mydown', 'MemberController@mydown');//我的下载
Route::post('member/bdemail', 'MemberController@bdemail');//邮箱绑定
Route::post('member/citysjld', 'MemberController@citysjld');//城市三级联动
Route::post('member/one_visited', 'MemberController@one_visited');//是否第一次访问个人中心页面
Route::post('member/one_check', 'MemberController@one_check');//微信注册进个人中心提交信息
Route::post('member/movefxj', 'MemberController@movefxj');//移动图片到其他文件夹里
Route::post('member/desearch', 'MemberController@desearch');//搜索设计师
Route::post('member/editnick', 'MemberController@editnick');//检测是否够次数修改昵称

Route::get('member/{id}', 'MemberController@homepage');//TA的主页
Route::get('member/homepage_finder/{id}', 'MemberController@homepage_finder');//TA的发现
Route::get('member/homepage_collect/{id}', 'MemberController@homepage_collect');//TA的收藏
Route::get('member/homepage_subscription/{id}', 'MemberController@homepage_subscription');//TA的订阅
Route::get('member/homepage_interactive/{id}', 'MemberController@homepage_interactive');//TA的互动
Route::get('member/homepage_fans/{id}', 'MemberController@homepage_fans');//TA的粉丝
Route::get('member/hp_collect_detail/{uid}/{id}', 'MemberController@hp_collect_detail');//TA的收藏详情
Route::get('member/hp_finder_detail/{uid}/{id}', 'MemberController@hp_finder_detail');//TA的发现详情
Route::post('member/gzta', 'MemberController@gzta');//关注TA
Route::post('member/qxgzta', 'MemberController@qxgzta');//取消关注TA
Route::post('member/gztady', 'MemberController@gztady');//关注TA的订阅
Route::post('member/visited_hp', 'MemberController@visited_hp');//统计访问个人主页的用户
Route::post('member/homepage_messages', 'MemberController@homepage_messages');//个人主页评论
Route::post('member/reply_messages', 'MemberController@reply_messages');//个人主页回复评论



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
Route::get('vip/pre_pay', 'VipController@prePay');// 支付前检查
Route::post('vip/add_finder_folder', 'VipController@addFinderFolder');
Route::post('vip/add_collect_folder', 'VipController@addCollectFolder');
Route::post('vip/delete_folder', 'VipController@deleteFolder');
Route::post('vip/edit_folder', 'VipController@editFolder');
Route::post('vip/get_folder_detail', 'VipController@getFolderDetail');
Route::post('vip/get_folder_info', 'VipController@getFolderInfo');
Route::post('vip/edit_folder_info', 'VipController@editFolderInfo');
Route::post('vip/finder_collect', 'VipController@finder_collect');//发现页-》点击收藏  文章详情页点击图片进行收藏


Route::get('folderlist/{id}', 'VipController@folderlist');//推荐收藏夹列表
Route::post('vip/addfolders', 'VipController@addfolders');//推荐收藏夹列表
Route::post('vip/scstatus', 'VipController@scstatus');//推荐收藏夹列表收藏的真实状态
Route::post('vip/autodelpay', 'VipController@autodelpay');//半小时后未付款的自动取消订单
Route::post('finder_ajax', 'VipController@finderajax');//发现页-->发现的分页 
Route::post('vip/finderslistsearch', 'VipController@finderslistsearch');//发现页-->搜索框
Route::post('vip/finlistsearch', 'VipController@finlistsearch');//发现页-->搜索框
Route::post('vip/checkstatus', 'VipController@checkstatus');//微信支付页面查询支付状态



//工作
Route::get('job', 'JobController@index');
Route::get('job/detail/{id}', 'JobController@detail');
Route::get('job/apply', 'JobController@apply');
Route::get('job/searchjob', 'JobController@searchjob');
Route::get('job/search_detail/{id}', 'JobController@search_detail');
Route::get('job_ajax', 'JobController@index');//工作的分页
// Route::get('job/searchjob_ajax', 'JobController@searchjob');//搜索工作的分页
//搜索
Route::get('search', 'SearchController@index');
Route::get('hot_search_ajax', 'SearchController@hotSearch');