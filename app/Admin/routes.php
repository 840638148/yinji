<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');
    //文章
    $router->get('/article/create', 'ArticleController@getCreate');
    $router->get('/article/get_designer_select_options', 'ArticleController@getDesignerSelectOptions');
    $router->get('/article', 'ArticleController@index');
    $router->get('/article/{id}', 'ArticleController@show');
    $router->post('/article', 'ArticleController@postCreate');
    $router->get('/article/{id}/edit', 'ArticleController@getEdit');
	$router->put('/article/{id}', 'ArticleController@putEdit');
	$router->delete('/article/{id}', 'ArticleController@remove');
    
    //文章分类
    $router->get('/article_category/create', 'ArticleCategoryController@getCreate');
    $router->get('/article_category', 'ArticleCategoryController@index');
    $router->get('/article_category/{id}', 'ArticleCategoryController@show');
    $router->post('/article_category', 'ArticleCategoryController@postCreate');
    $router->get('/article_category/{id}/edit', 'ArticleCategoryController@getEdit');
	$router->put('/article_category/{id}', 'ArticleCategoryController@putEdit');
	$router->delete('/article_category/{id}', 'ArticleCategoryController@remove');
    
    
    //名师标签
    $router->get('/article_tags/create', 'ArticleTagsController@getCreate');
    $router->get('/article_tags', 'ArticleTagsController@index');
    $router->get('/article_tags/{id}', 'ArticleTagsController@show');
    $router->post('/article_tags', 'ArticleTagsController@postCreate');
    $router->get('/article_tags/{id}/edit', 'ArticleTagsController@getEdit');
	$router->put('/article_tags/{id}', 'ArticleTagsController@putEdit');
	$router->delete('/article_tags/{id}', 'ArticleTagsController@remove');

    //文章专题
    $router->get('/article_topic/create', 'ArticleTopicController@getCreate');
    $router->get('/article_topic', 'ArticleTopicController@index');
    $router->get('/article_topic/{id}', 'ArticleTopicController@show');
    $router->post('/article_topic', 'ArticleTopicController@postCreate');
    $router->get('/article_topic/{id}/edit', 'ArticleTopicController@getEdit');
    $router->put('/article_topic/{id}', 'ArticleTopicController@putEdit');
    $router->delete('/article_topic/{id}', 'ArticleTopicController@remove');
    
    
    //名师
    $router->get('/designer/create', 'DesignerController@getCreate');
    $router->get('/designer', 'DesignerController@index');
    $router->get('/designer/{id}', 'DesignerController@show');
    $router->post('/designer', 'DesignerController@postCreate');
    $router->get('/designer/{id}/edit', 'DesignerController@getEdit');
	$router->put('/designer/{id}', 'DesignerController@putEdit');
	$router->delete('/designer/{id}', 'DesignerController@remove');
    
    //名师分类
    $router->get('/designer_category/create', 'DesignerCategoryController@getCreate');
    $router->get('/designer_category', 'DesignerCategoryController@index');
    $router->get('/designer_category/{id}', 'DesignerCategoryController@show');
    $router->post('/designer_category', 'DesignerCategoryController@postCreate');
    $router->get('/designer_category/{id}/edit', 'DesignerCategoryController@getEdit');
	$router->put('/designer_category/{id}', 'DesignerCategoryController@putEdit');
	$router->delete('/designer_category/{id}', 'DesignerCategoryController@remove');
    
    
    
    //名师标签
    $router->get('/designer_tags/create', 'DesignerTagsController@getCreate');
    $router->get('/designer_tags', 'DesignerTagsController@index');
    $router->get('/designer_tags/{id}', 'DesignerTagsController@show');
    $router->post('/designer_tags', 'DesignerTagsController@postCreate');
    $router->get('/designer_tags/{id}/edit', 'DesignerTagsController@getEdit');
	$router->put('/designer_tags/{id}', 'DesignerTagsController@putEdit');
	$router->delete('/designer_tags/{id}', 'DesignerTagsController@remove');

    //名师专题
    $router->get('/topic/create', 'TopicController@getCreate');
    $router->get('/topic', 'TopicController@index');
    $router->get('/topic/{id}', 'TopicController@show');
    $router->post('/topic', 'TopicController@postCreate');
    $router->get('/topic/{id}/edit', 'TopicController@getEdit');
    $router->put('/topic/{id}', 'TopicController@putEdit');
    $router->delete('/topic/{id}', 'TopicController@remove');
    
    
    //家具
    $router->get('/furniture/create', 'FurnitureController@getCreate');
    $router->get('/furniture', 'FurnitureController@index');
    $router->get('/furniture/{id}', 'FurnitureController@show');
    $router->post('/furniture', 'FurnitureController@postCreate');
    $router->get('/furniture/{id}/edit', 'FurnitureController@getEdit');
	$router->put('/furniture/{id}', 'FurnitureController@putEdit');
	$router->delete('/furniture/{id}', 'FurnitureController@remove');
    
    //家具分类
    $router->get('/furniture_category/create', 'FurnitureCategoryController@getCreate');
    $router->get('/furniture_category', 'FurnitureCategoryController@index');
    $router->get('/furniture_category/{id}', 'FurnitureCategoryController@show');
    $router->post('/furniture_category', 'FurnitureCategoryController@postCreate');
    $router->get('/furniture_category/{id}/edit', 'FurnitureCategoryController@getEdit');
	$router->put('/furniture_category/{id}', 'FurnitureCategoryController@putEdit');
	$router->delete('/furniture_category/{id}', 'FurnitureCategoryController@remove');
    
    //家具标签
    $router->get('/furniture_tags/create', 'FurnitureTagsController@getCreate');
    $router->get('/furniture_tags', 'FurnitureTagsController@index');
    $router->get('/furniture_tags/{id}', 'FurnitureTagsController@show');
    $router->post('/furniture_tags', 'FurnitureTagsController@postCreate');
    $router->get('/furniture_tags/{id}/edit', 'FurnitureTagsController@getEdit');
	$router->put('/furniture_tags/{id}', 'FurnitureTagsController@putEdit');
	$router->delete('/furniture_tags/{id}', 'FurnitureTagsController@remove');
    
    //新闻
    $router->get('/news/create', 'NewsController@getCreate');
    $router->get('/news/get_designer_select_options', 'NewsController@getDesignerSelectOptions');
    $router->get('/news', 'NewsController@index');
    $router->get('/news/{id}', 'NewsController@show');
    $router->post('/news', 'NewsController@postCreate');
    $router->get('/news/{id}/edit', 'NewsController@getEdit');
    $router->put('/news/{id}', 'NewsController@putEdit');
    $router->delete('/news/{id}', 'NewsController@remove');

    //新闻分类
    $router->get('/news_category/create', 'NewsCategoryController@getCreate');
    $router->get('/news_category', 'NewsCategoryController@index');
    $router->get('/news_category/{id}', 'NewsCategoryController@show');
    $router->post('/news_category', 'NewsCategoryController@postCreate');
    $router->get('/news_category/{id}/edit', 'NewsCategoryController@getEdit');
    $router->put('/news_category/{id}', 'NewsCategoryController@putEdit');
    $router->delete('/news_category/{id}', 'NewsCategoryController@remove');

    //新闻标签
    $router->get('/news_tags/create', 'NewsTagsController@getCreate');
    $router->get('/news_tags', 'NewsTagsController@index');
    $router->get('/news_tags/{id}', 'NewsTagsController@show');
    $router->post('/news_tags', 'NewsTagsController@postCreate');
    $router->get('/news_tags/{id}/edit', 'NewsTagsController@getEdit');
    $router->put('/news_tags/{id}', 'NewsTagsController@putEdit');
    $router->delete('/news_tags/{id}', 'NewsTagsController@remove');

    //广告设置
    $router->get('/popularize/create', 'PopularizeController@getCreate');
    $router->get('/popularize', 'PopularizeController@index');
    $router->get('/popularize/{id}', 'PopularizeController@show');
    $router->post('/popularize', 'PopularizeController@postCreate');
    $router->get('/popularize/{id}/edit', 'PopularizeController@getEdit');
    $router->put('/popularize/{id}', 'PopularizeController@putEdit');
    $router->delete('/popularize/{id}', 'PopularizeController@remove');
    
    //用户设置
    $router->get('/user/create', 'UserController@getCreate');
    $router->get('/user', 'UserController@index');
    $router->get('/user/{id}', 'UserController@show');
    $router->post('/user', 'UserController@postCreate');
    $router->get('/user/{id}/edit', 'UserController@getEdit');
    $router->put('/user/{id}', 'UserController@putEdit');
    $router->delete('/user/{id}', 'UserController@remove');

    
    //会员设置
    $router->get('/member/create', 'MemberController@getCreate');
    $router->get('/member', 'MemberController@index');
    $router->get('/member/{id}', 'MemberController@show');
    $router->post('/member', 'MemberController@postCreate');
    $router->get('/member/{id}/edit', 'MemberController@getEdit');
    $router->put('/member/{id}', 'MemberController@putEdit');
    $router->delete('/member/{id}', 'MemberController@remove');

    //会员价格设置
    $router->get('/vip_price', 'VipPriceController@index');
    $router->get('/vip_price/{id}/edit', 'VipPriceController@getEdit');
    $router->put('/vip_price/{id}', 'VipPriceController@putEdit');

    //积分设置
    $router->get('/point_set', 'PointSetController@index');
    $router->get('/point_set/{id}/edit', 'PointSetController@getEdit');
    $router->put('/point_set/{id}', 'PointSetController@putEdit');

    //公司管理
    $router->get('/company/create', 'CompanyController@getCreate');
    $router->get('/company', 'CompanyController@index');
    $router->get('/company/{id}', 'CompanyController@show');
    $router->post('/company', 'CompanyController@postCreate');
    $router->get('/company/{id}/edit', 'CompanyController@getEdit');
    $router->put('/company/{id}', 'CompanyController@putEdit');
    $router->delete('/company/{id}', 'CompanyController@remove');

    //公司项目
    $router->get('/company_project/create', 'CompanyProjectController@getCreate');
    $router->get('/company_project', 'CompanyProjectController@index');
    $router->get('/company_project/{id}', 'CompanyProjectController@show');
    $router->post('/company_project', 'CompanyProjectController@postCreate');
    $router->get('/company_project/{id}/edit', 'CompanyProjectController@getEdit');
    $router->put('/company_project/{id}', 'CompanyProjectController@putEdit');
    $router->delete('/company_project/{id}', 'CompanyProjectController@remove');

    //招聘职位
    $router->get('/company_work/create', 'CompanyWorkController@getCreate');
    $router->get('/company_work', 'CompanyWorkController@index');
    $router->get('/company_work/{id}', 'CompanyWorkController@show');
    $router->post('/company_work', 'CompanyWorkController@postCreate');
    $router->get('/company_work/{id}/edit', 'CompanyWorkController@getEdit');
    $router->put('/company_work/{id}', 'CompanyWorkController@putEdit');
    $router->delete('/company_work/{id}', 'CompanyWorkController@remove');

    //招聘热词
    $router->get('/companyhot/create', 'CompanyhotController@getCreate');
    $router->get('/companyhot', 'CompanyhotController@index');
    $router->get('/companyhot/{id}', 'CompanyhotController@show');
    $router->post('/companyhot', 'CompanyhotController@postCreate');
    $router->get('/companyhot/{id}/edit', 'CompanyhotController@getEdit');
    $router->put('/companyhot/{id}', 'CompanyhotController@putEdit');
    $router->delete('/companyhot/{id}', 'CompanyhotController@remove');

    //文章评论
    $router->get('/article_comment/create', 'ArticleCommentController@getCreate');
    $router->get('/article_comment', 'ArticleCommentController@index');
    $router->get('/article_comment/{id}', 'ArticleCommentController@show');
    $router->post('/article_comment', 'ArticleCommentController@postCreate');
    $router->get('/article_comment/{id}/edit', 'ArticleCommentController@getEdit');
    $router->put('/article_comment/{id}', 'ArticleCommentController@putEdit');
    $router->delete('/article_comment/{id}', 'ArticleCommentController@remove');

    //设计师评论
    $router->get('/designer_comment/create', 'DesignerCommentController@getCreate');
    $router->get('/designer_comment', 'DesignerCommentController@index');
    $router->get('/designer_comment/{id}', 'DesignerCommentController@show');
    $router->post('/designer_comment', 'DesignerCommentController@postCreate');
    $router->get('/designer_comment/{id}/edit', 'DesignerCommentController@getEdit');
    $router->put('/designer_comment/{id}', 'DesignerCommentController@putEdit');
    $router->delete('/designer_comment/{id}', 'DesignerCommentController@remove');

    //新闻评论
    $router->get('/news_comment/create', 'NewsCommentController@getCreate');
    $router->get('/news_comment', 'NewsCommentController@index');
    $router->get('/news_comment/{id}', 'NewsCommentController@show');
    $router->post('/news_comment', 'NewsCommentController@postCreate');
    $router->get('/news_comment/{id}/edit', 'NewsCommentController@getEdit');
    $router->put('/news_comment/{id}', 'NewsCommentController@putEdit');
    $router->delete('/news_comment/{id}', 'NewsCommentController@remove');
    
    //热门搜索
    $router->get('/hot_search/create', 'HotSearchController@getCreate');
    $router->get('/hot_search', 'HotSearchController@index');
    $router->get('/hot_search/{id}', 'HotSearchController@show');
    $router->post('/hot_search', 'HotSearchController@postCreate');
    $router->get('/hot_search/{id}/edit', 'HotSearchController@getEdit');
	$router->put('/hot_search/{id}', 'HotSearchController@putEdit');
	$router->delete('/hot_search/{id}', 'HotSearchController@remove');
});
