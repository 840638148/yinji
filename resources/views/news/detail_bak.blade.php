@extends('layouts.app')



@section('title')

    {{trans('news.news_detail')}}_{{trans('comm.yinji')}}

@endsection



@section('content')

    <div class="banner" style="background-image:url(/images/banner_news.jpg);">

        <div style="background:rgba(0,0,0,.5); position:absolute;top:0; width:100%; height:400px;"></div>

    <section class="wrapper" style="    z-index: 1; position: absolute; left: 50%; margin-left: -600px;">



        <div class="new_title">



            <h1 class="cfff">{{$news->title}}</h1>



            <div class="new_label mt20">



                <!--浏览次数-->



                <span class="comment"><i class="icon-eye"></i>{{$news->view_num}}</span>

            </div>





        </div>



    </section>





</div>

<section class="wrapper ">



    <div class="cat-wrap left mt20">

        <div class="news_box">

            {!! $news->content !!}

        </div>

    </div>



    <a href="#"></a>

    <div class="sidebar right">

        <article id="text-3" class="sidebar_widget box widget_text wow bounceInUp triangle animated">

            <div class="textwidget">

                <a href="#">

                    <!-- 右侧广告代码 开始 -->

                </a>

                <div id="playBox">

                    <div class="pre"></div>

                    <div class="next"></div>

                    <div class="smalltitle">

                        <ul>

                            <li class="thistitle"></li>

                            <li></li>

                            <li></li>

                            <li></li>

                        </ul>

                    </div>

                    <ul class="oUlplay">

                        @foreach ($ads_right as $right)

                            <li><a href="{{$right->ad_url}}" target="_blank" rel="noopener"><img src="{{url('uploads/' . $right->ad_img)}}"></a></li>

                        @endforeach

                    </ul>

                </div>

                <a href="#"></a></div>

        </article>

        <article id="slongposts-4" class="sidebar_widget box widget_salong_posts wow bounceInUp triangle animated" style="visibility: visible; animation-name: bounceInUp;">

            <div class="sidebar_title">

                <h3><a href="#">{{trans('news.hot_news')}}</a></h3>

            </div>

            <ul class="">

                @foreach ($hot_newses as $news)

                    <li>

                        <article class="postlist">

                            <a href="/news/detail/{{$news->id}}">

                                <figure>

                                    <img class="thumb" src="{{get_news_thum($news)}}" data-original="{{get_news_thum($news)}}" alt="{{get_news_title($news)}}" style="display: block;">

                                </figure>

                            </a>

                            <h3> <a href="/news/detail/{{$news->id}}">{{get_news_title($news)}}</a></h3>

                            <div class="homeinfo">



                                <a href="/news/detail/{{$news->id}}">

                                    <span class="date">{{str_limit($news->publish_time, 10, '')}}</span>

                                    <span class="comment">{{$news->view_num}}</span>

                                </a>

                            </div>

                        </article>

                    </li>

                @endforeach



            </ul>

        </article>

    </div>

    <a href="#"></a></section>



@endsection

