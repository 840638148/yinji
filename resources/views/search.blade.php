@extends('layouts.app')







@section('title')

    {{trans('comm.yinji')}} - {{trans('comm.second_title')}}

@endsection



@section('content')

<div class="about_bj" style="background-image:url(images/banner.jpg)"> </div>

<div class="search_box">

    <div class="search_nav_bj">

        <div class="wrapper">

            <div class="search_nav">

                {{--<a href="#" class="cat search_nav_item" data-type="article">文章</a>--}}

                {{--<a href="#" class="search_nav_item" data-type="designers">设计师</a>--}}

                {{--<a href="#" class="search_nav_item" data-type="finders"> 发现/收藏夹</a>--}}

                {{--<a href="#" class="search_nav_item" data-type="jobs">工作</a>--}}

                {{--<a href="#" class="search_nav_item" data-type="news">新闻</a>--}}

            </div>

            <div class="search_nav_right">  <input  id="keywords" name="keywords" type="text" placeholder="输入搜索的关键词" value="{{$keyword}}"> <a href="#" class="icon-search-1 fr" id="search-btn"></a></div>

        </div>

    </div>

    <div class="wrapper" style=" padding-top:20px">



        <!----------设计师搜索结果------->

        <div class="mt30 search-result">

            <div class="title">

                <h2>相关设计师 <span>共找到{{$designers->total()}}条结果</span></h2>

            </div>



            <div class="public_list"> @foreach ($designers as $designer)

                    <div class="public_item" data-id="{{$designer->id}}">

                        <div class="item_left"> <a href="@if($designer->static_url) /designer/{{$designer->static_url}} @else /designer/detail/{{$designer->id}} @endif" title="{{get_designer_title($designer)}}" target="_blank">

                                <div class="tx"> <img src="@if(get_designer_thum($designer)) {{get_designer_thum($designer)}} @else /img/avatar.png @endif"  data-original="{{get_designer_thum($designer)}}" alt="{{get_designer_title($designer)}}" style="display: block;" > </div>

                            </a>

                            <div class="item_msg">

                                <div class="title"> <a href="@if($designer->static_url) /designer/{{$designer->static_url}} @else /designer/detail/{{$designer->id}} @endif" title="{{get_designer_title($designer)}}" target="_blank">{{get_designer_title($designer)}}</a> </div>

                                <div class="describe"> <span>国家：



                                         @foreach ($designer->categorys as $category)



                                            @if($loop->last)



                                                {{$category['name']}}



                                            @else



                                                {{$category['name']}},



                                            @endif



                                        @endforeach </span>

                                    <span>{!! get_designer_description($designer) !!}</span>

                                    </div>

                                        <div class="focus">

                                            <div class="focus_msg"> <span>文章：{{$designer->article_num}}</span> | <span>粉丝：{{$designer->fans_num}}</span> </div>

                                        </div>

                                    </div>

                        </div>

                        <div class="item_right"> @foreach($designer->articles as $article)

                                <div class="works" data-id="1722"> <a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif" target="_blank"> <img src="{{get_article_thum($article)}}" alt=""> <span>{{get_article_title($article)}}</span> </a> </div>

                            @endforeach

                        </div>

                    </div>

                @endforeach

            </div>



            <!----------设计师订阅结束------->



        </div>



        {{--<!------------设计师----->--}}

        {{--<div class="designers_box search_result_box" data-type="designers">--}}



            {{--<section class="ffe ffe_list ffe_content mt20">--}}

                {{--<ul class="layout_ul ajaxposts designer-content">--}}

                    {{--@foreach ($designers as $designer)--}}

                        {{--<li class="layout_li ajaxpost ">--}}

                            {{--@if ('1' == $designer->industry)--}}

                                {{--<div class="interior"></div>--}}

                            {{--@else--}}

                                {{--<div class="architect"></div>--}}

                            {{--@endif--}}



                            {{--<article class="postgrid design" style="visibility: visible; animation-name: bounceInUp;">--}}

                                {{--<figure> <a href="@if($designer->static_url) /designer/{{$designer->static_url}} @else /designer/detail/{{$designer->id}} @endif" title="{{get_designer_title($designer)}}" target="_blank">--}}

                                        {{--<img class="thumb" src="{{get_designer_thum($designer)}}" data-original="{{get_designer_thum($designer)}}" alt="{{get_designer_title($designer)}}" style="display: block;"> </a> </figure>--}}

                                {{--<section class="ffe_main">--}}

                                    {{--<h2><a href="@if($designer->static_url) /designer/{{$designer->static_url}} @else /designer/detail/{{$designer->id}} @endif" title="{{get_designer_title($designer)}}" target="_blank">{{get_designer_title($designer)}}</a></h2>--}}

                                    {{--<div class="design_post">--}}

                                        {{--<!--分类-->--}}

                                        {{--<span class="guojia">--}}

                                {{--@foreach ($designer->categorys as $category)--}}

                                                {{--<a href="#" rel="tag">{{$category['name']}}</a>--}}

                                            {{--@endforeach--}}

                            {{--</span>--}}

                                        {{--<span class="ffe_liulan">{{$designer->subscription_num}}</span></div>--}}

                                {{--</section>--}}

                            {{--</article>--}}

                        {{--</li>--}}

                    {{--@endforeach--}}

                {{--</ul>--}}

            {{--</section>--}}

        {{--</div>--}}



        {{--<!------------设计师结束----->--}}





        <!--------文章----------->

        <div class="mt30 search-result">

            <div class="title">

                <h2>相关作品 <span>共找到{{$articles->total()}}条结果</span></h2>

            </div>

                <div class="article_box search_result_box " data-type="article">

                    <section class="content" file="wp-content/themes/lensnews/category.php:14">

                        <section class="post_list box post_bottom triangle wow bounceInUp animated" style="visibility: visible; animation-name: bounceInUp;">

                            <ul class="layout_ul ajaxposts article-content">

                                @foreach ($articles as $article)

                                    <li class="layout_li ajaxpost">

                                        <article class="postgrid">

                                            <figure>

                                                <a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif" title="{{get_article_title($article)}}" target="_blank">

                                                    <img class="thumb" src="{{get_article_thum($article)}}" data-original="{{get_article_thum($article)}}" alt="{{get_article_title($article)}}" style="display: block;">

                                                </a>

                                            </figure>

                                            <div class="chengshi">{{get_article_location($article)}}</div>

                                            <h2>

                                                <a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif" title="{{get_article_title($article)}}" target="_blank">

                                                    <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;">{{get_article_title($article, 1)}}</div>

                                                    <div style=" color:#666; line-height:24px;">{{get_article_title($article, 2)}}</div>

                                                </a>

                                            </h2>

                                            <div class="homeinfo">

                                                <!--分类-->

                                                @if ($article->category)

                                                    @foreach ($article->category as $category)

                                                        <a href="/article/category/{{$category['id']}}" rel="category tag">{{$category['name']}}</a>

                                                @endforeach

                                            @endif

                                            <!--时间-->

                                                <span class="date">{{str_limit($article->release_time, 10, '')}}</span>

                                                <!--点赞-->

                                                <span title="" class="like"><i class="icon-eye"></i><span class="count">{{$article->view_num}}</span></span>

                                            </div>

                                        </article>

                                    </li>

                                @endforeach

                            </ul>

                        </section>

                    </section>

                </div>

        </div>



        <!------文章结束-------->



        {{--<!---------发现/收藏夹开始-------->--}}

        {{--<div class="finder_box search_result_box" data-type="finders">--}}

            {{--<div class="search_title">相关收藏夹 <span class="fr">更多>></span></div>--}}

            {{--<div class="masonry">--}}

                {{--@foreach($collects as $collect)--}}

                    {{--<div class="item collection-item">--}}

                        {{--<div class="item__content">--}}

                            {{--<ul>--}}

                                {{--@foreach($collect->imgs as $img_obj)--}}

                                    {{--<li><a><img src="{{$img_obj['img']}}" /></a></li>--}}

                                {{--@endforeach--}}

                            {{--</ul>--}}

                            {{--<div class="find_title">--}}

                                {{--<h2><a>{{$collect->name}}</a></h2>--}}

                            {{--</div>--}}

                        {{--</div>--}}

                    {{--</div>--}}

                {{--@endforeach--}}

            {{--</div>--}}

            {{--<div class="search_title">共找到<span>{{$finders->total()}}</span>个结果</div>--}}

            {{--<div class="masonry">--}}

                {{--@foreach ($finders as $detail)--}}

                    {{--<div class="item discovery-item">--}}

                        {{--<div class="item_content item_content2">--}}

                            {{--<li> <img  src="{{$detail->photo_url}}" alt="{{$detail->title}}"> </li>--}}

                            {{--<div class="find_title">--}}

                                {{--<h2><a href="{{$detail->photo_url}}" target="_blank">{{$detail->title}}</a></h2>--}}

                                {{--<a href="javascript:;" class="find-icon-trash remove_find_img" data-id="{{$detail->id}}" tag="删除发现的图片"></a> </div>--}}

                        {{--</div>--}}

                    {{--</div>--}}

                {{--@endforeach--}}

            {{--</div>--}}

        {{--</div>--}}



        {{--<!---------发现/收藏夹结束-------->--}}

        {{--<!---------工作开始-------->--}}

        {{--<div class="jobs_box search_result_box" data-type="jobs">--}}

            {{--<div class="search_title">共找到<span>200</span>个结果</div>--}}

            {{--<div class="jobs-list">--}}

                {{--<article>--}}

                    {{--<div class="post-box">--}}

                        {{--<h2 class="entry-title"><a href="工作详情.html" target="_blank">（香港/深圳）PH Alpha Design 英国湃昂国际建筑设计顾问有限公司 </a><span class="ico_new"><img src="images/new.gif" alt="最新"></span><span class="ico_new"><img src="images/ico_hot.gif" alt="热门招聘"></span><span class="ico_new"><img src="images/ji_05.gif" alt="急聘"></span></h2>--}}

                        {{--<p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>--}}

                    {{--</div>--}}

                {{--</article>--}}

                {{--<article class="post-job">--}}

                    {{--<div class="post-box">--}}

                        {{--<h2 class="entry-title"><a href="工作详情.html" target="_blank">（深圳）JS Architects 张健蘅整合建筑事务所</a><span class="ico_new"><img src="images/ji_05.gif" alt="急聘"></span></h2>--}}

                        {{--<p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>--}}

                    {{--</div>--}}

                {{--</article>--}}

                {{--<article class="post-job">--}}

                    {{--<div class="post-box">--}}

                        {{--<h2 class="entry-title"><a href="/job-tianandann.htm" target="_blank">（上海）TIANANDANN力呈建筑设计咨询有限</a><span class="ico_new"><img src="images/ico_hot.gif" alt="热门招聘"></span></h2>--}}

                        {{--<p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>--}}

                    {{--</div>--}}

                {{--</article>--}}

                {{--<article class="post-job">--}}

                    {{--<div class="post-box">--}}

                        {{--<h2 class="entry-title"><a href="/job-atelier-alter.htm" target="_blank">（北京）时境建筑 Atelier Alter</a><span class="ico_new"><img src="images/new.gif" alt="最新"></span></h2>--}}

                        {{--<p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>--}}

                    {{--</div>--}}

                {{--</article>--}}

                {{--<article>--}}

                    {{--<div class="post-box">--}}

                        {{--<h2 class="entry-title"><a href="/job-ph-alpha-design.htm" target="_blank">（香港/深圳）PH Alpha Design 英国湃昂国际建筑设计顾问有限公司 </a><span class="ico_new"><img src="images/new.gif" alt="最新"></span><span class="ico_new"><img src="images/ico_hot.gif" alt="热门招聘"></span><span class="ico_new"><img src="images/ji_05.gif" alt="急聘"></span></h2>--}}

                        {{--<p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>--}}

                    {{--</div>--}}

                {{--</article>--}}

                {{--<article class="post-job">--}}

                    {{--<div class="post-box">--}}

                        {{--<h2 class="entry-title"><a href="/job-js-architects.htm" target="_blank">（深圳）JS Architects 张健蘅整合建筑事务所</a><span class="ico_new"><img src="images/ji_05.gif" alt="急聘"></span></h2>--}}

                        {{--<p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>--}}

                    {{--</div>--}}

                {{--</article>--}}

                {{--<article class="post-job">--}}

                    {{--<div class="post-box">--}}

                        {{--<h2 class="entry-title"><a href="/job-tianandann.htm" target="_blank">（上海）TIANANDANN力呈建筑设计咨询有限</a><span class="ico_new"><img src="images/ico_hot.gif" alt="热门招聘"></span></h2>--}}

                        {{--<p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>--}}

                    {{--</div>--}}

                {{--</article>--}}

                {{--<article class="post-job">--}}

                    {{--<div class="post-box">--}}

                        {{--<h2 class="entry-title"><a href="/job-atelier-alter.htm" target="_blank">（北京）时境建筑 Atelier Alter</a><span class="ico_new"><img src="images/new.gif" alt="最新"></span></h2>--}}

                        {{--<p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>--}}

                    {{--</div>--}}

                {{--</article>--}}

                {{--<article>--}}

                    {{--<div class="post-box">--}}

                        {{--<h2 class="entry-title"><a href="/job-ph-alpha-design.htm" target="_blank">（香港/深圳）PH Alpha Design 英国湃昂国际建筑设计顾问有限公司 </a><span class="ico_new"><img src="images/new.gif" alt="最新"></span><span class="ico_new"><img src="images/ico_hot.gif" alt="热门招聘"></span><span class="ico_new"><img src="images/ji_05.gif" alt="急聘"></span></h2>--}}

                        {{--<p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>--}}

                    {{--</div>--}}

                {{--</article><article class="post-job">--}}

                    {{--<div class="post-box">--}}

                        {{--<h2 class="entry-title"><a href="/job-js-architects.htm" target="_blank">（深圳）JS Architects 张健蘅整合建筑事务所</a><span class="ico_new"><img src="images/ji_05.gif" alt="急聘"></span></h2>--}}

                        {{--<p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>--}}

                    {{--</div>--}}

                {{--</article>--}}

                {{--<article class="post-job">--}}

                    {{--<div class="post-box">--}}

                        {{--<h2 class="entry-title"><a href="/job-tianandann.htm" target="_blank">（上海）TIANANDANN力呈建筑设计咨询有限</a><span class="ico_new"><img src="images/ico_hot.gif" alt="热门招聘"></span></h2>--}}

                        {{--<p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>--}}

                    {{--</div>--}}

                {{--</article>--}}

                {{--<article class="post-job">--}}

                    {{--<div class="post-box">--}}

                        {{--<h2 class="entry-title"><a href="/job-atelier-alter.htm" target="_blank">（北京）时境建筑 Atelier Alter</a><span class="ico_new"><img src="images/new.gif" alt="最新"></span></h2>--}}

                        {{--<p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>--}}

                    {{--</div>--}}

                {{--</article>--}}

                {{--<article class="post-job">--}}

                    {{--<div class="post-box">--}}

                        {{--<h2 class="entry-title"><a href="/job-js-architects.htm" target="_blank">（深圳）JS Architects 张健蘅整合建筑事务所</a></h2>--}}

                        {{--<p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>--}}

                    {{--</div>--}}

                {{--</article>--}}

                {{--<article class="post-job">--}}

                    {{--<div class="post-box">--}}

                        {{--<h2 class="entry-title"><a href="/job-tianandann.htm" target="_blank">（上海）TIANANDANN力呈建筑设计咨询有限</a></h2>--}}

                        {{--<p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>--}}

                    {{--</div>--}}

                {{--</article>--}}

                {{--<article class="post-job">--}}

                    {{--<div class="post-box">--}}

                        {{--<h2 class="entry-title"><a href="/job-atelier-alter.htm" target="_blank">（北京）时境建筑 Atelier Alter</a><span class="ico_new"></span></h2>--}}

                        {{--<p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>--}}

                    {{--</div>--}}

                {{--</article>--}}

                {{--<article class="post-job">--}}

                    {{--<div class="post-box">--}}

                        {{--<h2 class="entry-title"><a href="/job-tianandann.htm" target="_blank">（上海）TIANANDANN力呈建筑设计咨询有限</a></h2>--}}

                        {{--<p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>--}}

                    {{--</div>--}}

                {{--</article>--}}

            {{--</div>--}}

        {{--</div>--}}



        <!---------工作结束-------->



        <!--------新闻----------->

        <div class="search-result">

            <div class="title">

                <h2>相关新闻 <span>共找到{{$newses->total()}}条结果</span></h2>

            </div>

            <div class="left" style="width:100%">

                <div class="news3">

                    <ul>

                        @foreach ($newses as $news)

                            <li class="left">

                                <article class="postlist">

                                    <a href="/news/detail/{{$news->id}}">

                                        <figure>

                                            <img class="thumb" src="{{get_article_thum($news)}}" data-original="{{get_article_thum($news)}}" alt="{{get_article_title($news)}}" style="display: block;">

                                        </figure>

                                    </a>

                                    <h3> <a href="/news/detail/{{$news->id}}">{{get_article_title($news)}}</a></h3>

                                    <div class="news_brief"><a href="/news/detail/{{$news->id}}">{!!get_article_description($news)!!}</a></div>

                                    <div class="homeinfo">

                                        <a href="/news/detail/{{$news->id}}">

                                            <span class="date">{{str_limit($news->release_time, 10, '')}}</span>

                                            <span class="comment"><i class="icon-eye"></i>{{$news->view_num}}</span>

                                        </a>

                                    </div>

                                </article>

                            </li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

        <!------新闻结束-------->

    </div>

</div>



<script>

    $('#search-btn').on('click',function(){

        var value = $('#keywords').val();

        window.location.href = '/search?keyword=' + encodeURIComponent(value);

    });

</script>







@endsection



