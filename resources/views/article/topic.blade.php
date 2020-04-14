@extends('layouts.app')

@section('title')
    {{get_topic_title($topic)}}_{{trans('comm.yinji')}}
@endsection

@section('content')

    <div class="zt_banner" style="background:url(/uploads/{{$topic->special_photo}}) no-repeat; height:600px; display: block"></div>
    <section class="wrapper">
        <div class="zt_top  mt20 left">
            <div class="zt_top2">
                <ul>
                    @php
                        $ii = 0;
                        $hots = [];
                        foreach ($hot_article_more as $article) {
                            $ii ++;
                            $hots[] = $article;
                            if ($ii >= 3) {
                                break;
                            }
                        }
                    @endphp
                    @foreach($hots as $hot)
                        <li>
                            <a href="@if($hot->static_url) /article/{{$hot->static_url}} @else /article/detail/{{$hot->id}} @endif" target="_blank">
                                <img class="thumb" src="{{get_article_thum($hot)}}" style="display: block;">
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            @if ($hot_article)
            <div  class="zt_top1"><a href="@if($hot_article->static_url) /article/{{$hot_article->static_url}} @else /article/detail/{{$hot_article->id}} @endif" target="_blank"> <img class="thumb" src="{{get_article_thum($hot_article)}}" style="display: block;"> </a>
                <div class="zt_hot">
                    <h1>HOT1</h1>
                    <div class="hot_title">{{get_article_title($hot_article,2)}}</div>
                    <div class=""><i class="icon-user"></i> {{get_article_designer($hot_article)}}</div>
                    <div class="excerpt "> &nbsp; {{get_article_description($hot_article)}} </div>
                    <div class="homeinfo">
                        <!--分类-->

                        @if ($hot_article->category)
                            @foreach ($hot_article->category as $category)
                                <span class="category"><a href="/article/category/{{$category['id']}}" rel="category tag">{{$category['name']}}</a></span>
                        @endforeach
                        @endif
                        <!--时间-->
                        <span class="date">{{str_limit($hot_article->release_time, 10, '')}}</span>
                    </div>
                    <div class=" zt_li3">
                        <ul>
                            <li>
                                <!--浏览量-->
                                <span class="view"><i class="icon-eye"></i>{{$hot_article->view_num}}</span> </li>
                            <li>
                                <!--评论-->
                                <span class="comment"><i class="icon-comment"></i>{{$hot_article->view_num}}</span> </li>
                            <li>
                                <!--点赞-->
                                <span title="" class="like"><i class="icon-thumbs-up"></i><span class="count">{{$hot_article->like_num}}</span></span> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="zt_news fr mt20">
            <dl>
                <dt><span>News</span></dt>
                @foreach ($news_articles as $article)
                <dd>
                    <article class="postlist">
                        <figure>
                            <a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif" title="{{get_article_title($article)}}" target="_blank">
                                <img class="thumb" src="{{get_article_thum($article)}}" data-original="{{get_article_thum($article)}}" alt="{{get_article_title($article)}}" style="display: block;">
                            </a>
                        </figure>
                        <h3>
                            <a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif" title="{{get_article_title($article)}}" target="_blank">{{get_article_title($article, 2)}}</a>
                        </h3>
                        <div class="homeinfo">
                            <!--分类-->
                            @if ($article->category)
                                @foreach ($article->category as $category)
                                    <a href="/article/category/{{$category['id']}}" rel="category tag">{{$category['name']}}</a>
                            @endforeach
                            @endif
                            <span class="date">{{str_limit($article->release_time, 10, '')}}</span>
                            <span class="comment"><i class="icon-eye"></i><a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif">{{$article->view_num}}</a></span>
                        </div>
                    </article>
                </dd>
                @endforeach
            </dl>
            </div>
        <!---推荐设计师开始--->
        <div class="zt_design mt30">
            <div class="zt_title"><i class="icon-thumbs-up" style="margin-right:5px;"></i> 设计师推荐 </div>
            <div class="design_more">
                <div class="swiper-wrapper">
                    @foreach ($designers as $designer)
                    <div class="design_more_item">
                      <ul>
                      <li>  <a href="@if($designer->static_url) /designer/{{$designer->static_url}} @else /designer/detail/{{$designer->id}} @endif" title="{{get_designer_title($designer)}}" target="_blank">
                            <img class="thumb" src="{{get_designer_thum($designer)}}" alt="{{get_designer_title($designer)}}" style="display: block;"> </a>
                            </li>
                            </ul>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="icon-angle-left design_button-next" style="display:none"></div>
            <div class="icon-angle-right design_button-prev" style="display:none"></div>
        </div>

        <!---作品列表开始--->
        <div class="mt30 fl" style="width:100%">
            <div class="mx_title">{{get_topic_title($topic)}}</div>
            <section class="content" file="wp-content/themes/lensnews/category.php:14">
                <section class="post_list box post_bottom triangle wow bounceInUp animated" style="visibility: visible; animation-name: bounceInUp;">
                    <ul class="layout_ul ajaxposts article-content">
                        @foreach ($articles as $article)
                            <li class="layout_li ajaxpost">
                            <div class="interior_dafen">{{$article->starsavg !=0 ? $article->starsavg : '5.0'}}</div>
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
    </section>


<script>
$(function(){
    if($('.design_more_item').length > 5 ){
        $('.design_more_item').each(function(){
            $(this).addClass('swiper-slide')
        })
        $('.design_button-next').show();
        $('.design_button-prev').show();
        var swiper = new Swiper('.design_more', {
            pagination: '.swiper-pagination',
            slidesPerView: 5,
            paginationClickable: true,
            spaceBetween: 30,
            nextButton: '.design_button-prev',
            prevButton: '.design_button-next',
            loop: true,
            autoplay:3000
        });
    }
    
})
</script>
@endsection

