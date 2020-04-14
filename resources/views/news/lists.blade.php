@extends('layouts.app')



@section('title')



    {{trans('news.all_news')}}_{{trans('comm.yinji')}}

@endsection







@section('content')



    <div class="banner_news"> —— NEWS —— </div>



    <!------顶部大图结束----->



    <section class="wrapper ">







        <div class="cat-wrap left mt20 box">



            <div class="news_box">



                @foreach ($newses as $news)



                    @if ($loop->iteration % 3 == 1)



                        <div class="news" >



                            <article class="postlist">



                                <a href="/news/detail/{{$news->id}}">



                                    <figure>

                                        <img class="thumb" src="{{get_article_special($news)}}" data-original="{{get_article_special($news)}}" alt="{{get_article_title($news)}}" style="display: block;">

                                        <div>

                                            @foreach ($news['category'] as $category)

                                                <span>{{$category['name']}}</span>

                                            @endforeach

                                        </div>

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



                        </div>



                    @else

                        @if ($loop->iteration % 3 == 2)

                            <div class="news2">

                                <ul>

                                    <li class="left">

                                        <article class="postlist">

                                            <a href="/news/detail/{{$news->id}}">

                                                <figure>

                                                    <img class="thumb" src="{{get_article_thum($news)}}" data-original="{{get_article_thum($news)}}" alt="{{get_article_title($news)}}" style="display: block;">

                                                    <div>

                                                        @foreach ($news['category'] as $category)

                                                            <span>{{$category['name']}}</span>

                                                        @endforeach

                                                    </div>

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



                                    @endif











                                    @if ($loop->iteration % 3 == 0)



                                        <li class="right">



                                            <article class="postlist">



                                                <a href="/news/detail/{{$news->id}}">



                                                    <figure>



                                                        <img class="thumb" src="{{get_article_thum($news)}}" data-original="{{get_article_thum($news)}}" alt="{{get_article_title($news)}}" style="display: block;">

                                                        <div>

                                                            @foreach ($news['category'] as $category)

                                                                <span>{{$category['name']}}</span>

                                                            @endforeach

                                                        </div>

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



                                </ul>



                            </div>



                            @endif



                            @endif







                            @if ($loop->last && $loop->iteration % 3 == 2)



                            </ul>



            </div>







            @endif







            @endforeach











        </div>



        </div>







        <a href="#"></a>



        <div class="sidebar right">



            <article id="text-3" class="widget_text wow bounceInUp triangle animated">



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



            <article id="slongposts-4" class="box widget_salong_posts wow bounceInUp triangle animated" style="visibility: visible; animation-name: bounceInUp;">



                <div class="sidebar_title">



                    <h3><a href="#">{{trans('news.hot_news')}}</a></h3>



                </div>



                <ul>



                    @foreach ($hot_newses as $news)



                        <li>



                            <article class="postlist">



                                <a href="/news/detail/{{$news->id}}">



                                    <figure>



                                        <img class="thumb" src="{{get_article_thum($news)}}" data-original="{{get_article_thum($news)}}" alt="{{get_article_thum($news)}}" style="display: block;">



                                    </figure>



                                </a>



                                <h3> <a href="/news/detail/{{$news->id}}">{{get_article_title($news)}}</a></h3>



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



            </article>



        </div>



        <a href="#"></a></section>

    <script>

        var page = 2;isEnd = false

        $(window).on('scroll',function(e){

            var bodyHeight=document.body.scrollHeight==0?document.documentElement.scrollHeight:document.body.scrollHeight;

            if(bodyHeight - $('body').scrollTop() -10 <window.innerHeight && !isEnd){

                var h  = '';

                var url = window.location.href;

                $.ajax({

                    async: false,

                    url: url + '_ajax?page=' + page,

                    type: 'GET',

                    dataType: 'json',

                    data: {},

                    success: function (data) {

                        if (data.status_code == 0) {

                            page++;

                            h =  data.data.join('')

                            $('.news_box').append(h)

                            if(data.data.length<15){

                                isEnd = true

                            }

                        } else {

                            isEnd = true

                            alert(data.message);

                        }

                    }

                });

            }

        })

    </script>

@endsection





