@extends('layouts.app')


@section('title')

{{trans('comm.yinji')}} - {{trans('comm.second_title')}}

@endsection


@section('seo_verification')

{{trans('comm.seo_verification')}}

@endsection



@section('seo_description')

{{trans('comm.seo_description')}}

@endsection



@section('seo_keywords')

{{trans('comm.seo_keywords')}}

@endsection


@section('content') 

<!------滚动海报-------->

<section class="slides-sticky  wow bounceInUp animated" style="visibility: visible; animation-name: bounceInUp;">
  <section class="slide-main slide-home">
    <div class="swiper-container swiper-home swiper-container-horizontal">
      <div class="swiper-wrapper" style="transform: translate3d(-7876px, 0px, 0px); transition-duration: 0ms;"> @foreach ($bannar as $ban_item)
        <article class="swiper-slide slide-single" data-swiper-slide-index="{{$loop->iteration}}" style="width: 1145.6px;"> <a href="{{$ban_item->ad_url}}" class="swiper-image" style="background-image: url({{url('uploads/' . $ban_item->ad_img)}});"></a> </article>
        @endforeach </div>
      
      <!-- 导航 -->
      
      <div class="swiper-pagination swiper-home-pagination swiper-pagination-bullets"> <span class="swiper-pagination-bullet swiper-pagination-bullet-active"></span> <span class="swiper-pagination-bullet"></span> <span class="swiper-pagination-bullet"></span> </div>
      
      <!-- 按钮 -->
      
      <div class="swiper-button swiper-home-button-next swiper-button-next icon-angle-right"></div>
      <div class="swiper-button swiper-home-button-prev swiper-button-prev icon-angle-left"></div>
    </div>
<script type="text/javascript">
    $("#lang-switch").click(function () {
        var lang = $
        $.ajax({
            url: '/lang/switch',
            type: 'POST',
            dataType: 'json',
            data: {lang: ''},
            success: function () {
                location.reload();
            }
        });
    });


  //首页幻灯片
  var $page_main_body = $('.slide-home');
  var $button_next = $page_main_body.find('.swiper-home-button-next');
  var $button_prev = $page_main_body.find('.swiper-home-button-prev');
  var len = $('.slide-home').find('.swiper-slide').length;
  var bannerSwiper = new Swiper('.swiper-home', {
      pagination: '.swiper-home-pagination',
      nextButton: '.swiper-home-button-next',
      prevButton: '.swiper-home-button-prev',
      autoplay: 2000,
      autoplayDisableOnInteraction: false,
      loop: true,
      loopedSlides: len,
      centeredSlides: true,
      slidesPerView: 1.25,
      on: {
          init: function () {
              var width = parseInt($page_main_body.width());
              if ($index_pc_bt.size() > 0) {
                  $index_pc_bt.css('width', (width - this.slidesSizesGrid['0']) / 2 + 'px');
              }
          }
      },
      onInit: function (swiper) {
          swiper.slides[2].className = "swiper-slide swiper-slide-active";//第一次打开不要动画
      },

      breakpoints: {
          668: {
              slidesPerView: 1
          }
      },

      lazy: {
          loadPrevNext: true,
      }
  });
</script> 
  </section>
</section>
@if (isset($ads_2)) 

<!---广告位---->

<section class="wrapper">
  <div class="top_ad box mt20">
    <ul>
      @foreach ($ads_2 as $ad)
      
      
      
      @if ($loop->last) <a href="{{$ad->ad_url}}">
      <li class="right"><img src="{{url('uploads/' . $ad->ad_img)}}"

                                                       title="{{$ad->ad_title}}"/></li>
      </a> @else <a href="{{$ad->ad_url}}">
      <li class="mr20 left"><img src="{{url('uploads/' . $ad->ad_img)}}"

                                                           title="{{$ad->ad_title}}"/></li>
      </a> @endif
      
      
      
      
      
      
      
      @endforeach
    </ul>
  </div>
</section>

<!---广告位end----> 

@endif
<section class="new wrapper scroll4 box" style="position: relative;">
  <section class="cat-wrap left">
    <section class=" triangle wow bounceInUp animated" style="visibility: visible; animation-name: bounceInUp;"> 
      
      <!--标题-->
      
      <section class="home_title">
        <h3 class="left"><i class="ico_title_news"></i>{{trans('index.latest_article')}}</h3>
      </section>
      
      <!--标题end-->
      
      <section class="new_list">
        <ul class="layout_ul ajaxposts">
          @foreach ($new_articles as $article)
          <li class="layout_li ajaxpost wow bounceInUp animated" style="visibility: visible; animation-name: bounceInUp;">
            <article class="post_main">
            <div class="index_dafen">{{$article->starsavg =='0.0' ? '5.0' : $article->starsavg}}</div>
              <figure> <a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif"

                                               title="{{get_article_title($article)}}" target="_blank"> <img

                                                    class="thumb" src="{{get_article_thum($article)}}"

                                                    data-original="{{get_article_thum($article)}}"

                                                    alt="{{get_article_title($article)}}" style="display: block;"> </a> </figure>
              <h2> <a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif"
                                           title="{{get_article_title($article)}}"
                                           target="_blank">
                <p>{{get_article_title($article, 1)}}</p>
                <p>{{get_article_title($article, 2)}}</p>
                </a> </h2>
              <div class="postinfo">
                <div class="left"> <span class="index-category"> @if ($article->category)
                  @foreach ($article->category as $category) <a href="/article/category/{{$category['id']}}"

                                                   rel="category tag">{{$category['name']}}</a> @endforeach
                  @endif </span> </div>
                <div class="excerpt">{!!get_article_description($article)!!}</div>
                <div class="right index_new">
                  <ul>
                    <li><span class="view"><i class="icon-eye"></i>{{$article->view_num}}</span></li>
                    <!--li><span class="comment"><i class="icon-bookmark"></i><a  href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif">{{$article->favorite_num}}</a></span> </li>
                    <li><span class="like"><i class="icon-thumbs-up"></i><span class="count">{{$article->like_num}}</span></span></li-->
                    <li><span><i class="icon-clock"></i> {{$article->month}} {{$article->day}}日</span></li>
                  </ul>
                </div>
                 
              </div>
            </article>
          </li>
          @endforeach
        </ul>
      </section>
    </section>
  </section>
  
  <!--边栏-->
  
  <aside class="sidebar right">
    <div style="position: relative; top: 0px; height: 0px;"></div>
    <section class="cat4_sidebar" style="width: 288px;">
      <article id="slongposts-4" class="sidebar_widget widget_salong_posts wow bounceInUp triangle animated"

                         style="visibility: visible; animation-name: bounceInUp;">
        <div class="sidebar_title">
          <h3>{{trans('index.hot_article')}}</h3>
        </div>
        <ul class="">
          @foreach ($hot_articles as $article)
          <li>
            <article class="postlist">
              <figure> <a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif"

                                           title="{{get_article_title($article)}}&nbsp;" target="_blank"> <img class="thumb" src="{{get_article_thum($article)}}"

                                                 data-original="{{get_article_thum($article)}}"

                                                 alt="{{get_article_title($article)}}" style="display: block;"> </a> </figure>
              <h3><a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif"

                                           title="{{get_article_title($article, 2)}}&nbsp;"

                                           target="_blank">{{get_article_title($article, 2)}}</a></h3>
              <div class="homeinfo"> @if ($article->category)
                
                
                
                @foreach ($article->category as $category) <a href="/article/category/{{$category['id']}}"

                                                   rel="category tag">{{$category['name']}}</a> @endforeach
                
                
                
                @endif <span class="date">{{str_limit($article->release_time, 10, '')}}</span> <span class="comment"><i class="icon-eye"></i><a

                                                    href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif">{{$article->view_num}}</a></span> </div>
            </article>
          </li>
          @endforeach
        </ul>
      </article>
      <article id="text-3" class="sidebar_widget box widget_text wow bounceInUp triangle animated"

                         style="visibility: visible; animation-name: bounceInUp;"> @if (isset($ads_right))
        <div class="textwidget">
          <p><!-- 右侧广告代码 开始 --></p>
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
          <p><!-- 右侧广告代码 结束 --></p>
        </div>
        @endif </article>
    </section>
  </aside>
  
  <!--边栏end-->
  
  <div class="sf4"></div>
</section>

<!---设计师---->

<section class="design_box box" >
  <div class="wrapper">
    <div class="left design_left">
      <section class="home_title mt30">
        <h3 class="left"><i class="ico_title_design"></i>{{trans('index.master_designer')}}</h3>
      </section>
      <ul>
        @foreach ($master_designers as $master)
        <li> <a href="{{$master->ad_url}}"> <img src="{{url('uploads/' . $master->ad_img)}}" title="{{$master->ad_title}}"/> </a> </li>
        @endforeach
      </ul>
    </div>
    <div class="design_right right">
      <section class="design_right_title mt30">
        <h2>{{trans('index.noted_designer')}}</h2>
      </section>
      <ul>
        @foreach ($noted_designers as $noted)
      
        @if ($loop->iteration % 2)
        <li class="left"> <a class="ad-link" href="{{$noted->ad_url}}"> <img src="{{url('uploads/' . $noted->ad_img)}}" title="{{$noted->ad_title}}"/> </a> </li>
        @else
        <li class="right"> <a href="{{$noted->ad_url}}"> <img src="{{url('uploads/' . $noted->ad_img)}}" title="{{$noted->ad_title}}"/> </a> </li>
        @endif
        
        @endforeach
      </ul>
      <a href="/designer" class="design_right_more">{{trans('index.more_noted_designer')}}</a></div>
  </div>
</section>

<!---设计师end----> 

<!---猜你喜欢---->

<section class="wrapper">
  <div class="cat-wrap box left">
    <section class="home_title mt30">
      <h3 class="left"><i class="ico_title_like"></i>{{trans('index.lovely')}}</h3>
    </section>
    <article class="like">
      <ul>
        @foreach ($lovely as $article)
        
        
        
        @if ($loop->first)
        <div class="left like_title">
          <ul>
            <article>
              <figure> <a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif" title="{{get_article_title($article)}}" target="_blank"> <img class="thumb" src="{{get_article_thum($article)}}" style="display: block;"> </a> </figure>
              <h2><a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif" title="{{get_article_title($article)}}" target="_blank"> {{get_article_title($article)}}</a></h2>
              <div class="postinfo"> 
                
                <!-- 摘要 -->
                
                <div class="mb10"> &nbsp; &nbsp; &nbsp;
                  
                  {{get_article_description($article)}} </div>
                
                <!-- 摘要end -->
                
                <div class="left"> 
                  
                  <!--分类--> 
                  
                  <span> @if ($article->category)
                  
                  @foreach ($article->category as $category) <a href="/article/category/{{$category['id']}}"

                                                               rel="category tag">{{$category['name']}}</a> @endforeach
                  
                  @endif </span> <span>{{str_limit($article->release_time, 10, '')}}</span> </div>
                <div class="right"> <span title="浏览人数" class="like"><i class="icon-eye"></i>{{$article->view_num}}</span> </div>
              </div>
            </article>
          </ul>
        </div>
        @elseif ($loop->iteration%2)
        <li class="right">
          <article class="postlist">
            <figure><a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif"

                                               title="{{get_article_title($article)}}" target="_blank"> <img

                                                    class="thumb" src="{{get_article_thum($article)}}"

                                                    data-original="{{get_article_thum($article)}}"

                                                    alt="{{get_article_title($article)}}" style="display: block;"> </a> </figure>
            <h3><a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif"

                                           title="{{get_article_title($article)}}"

                                           target="_blank">{{get_article_title($article)}}</a></h3>
            <div class="homeinfo"> 
              
              <!--分类--> 
              
              <span class="category"> @if ($article->category)
              
              
              
              @foreach ($article->category as $category) <a href="/article/category/{{$category['id']}}"

                                                       rel="category tag">{{$category['name']}}</a> @endforeach
              
              
              
              @endif </span> 
              
              <!--时间--> 
              
              <span class="date">{{str_limit($article->release_time, 10, '')}}</span> 
              
              <!--点赞--> 
              
              <span title="浏览人数" class="like"><i class="icon-eye"></i><span

                                                    class="count">{{$article->view_num}}</span></span></div>
          </article>
        </li>
        @else
        <li class="left">
          <article class="postlist">
            <figure><a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif"

                                               title="{{get_article_title($article)}}" target="_blank"> <img

                                                    class="thumb" src="{{get_article_thum($article)}}"

                                                    data-original="{{get_article_thum($article)}}"

                                                    alt="{{get_article_title($article)}}" style="display: block;"> </a> </figure>
            <h3><a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif"

                                           title="{{get_article_title($article)}}"

                                           target="_blank">{{get_article_title($article)}}</a></h3>
            <div class="homeinfo"> 
              
              <!--分类--> 
              
              <span class="category"> @if ($article->category)
              
              
              
              @foreach ($article->category as $category) <a href="/article/category/{{$category['id']}}"

                                                       rel="category tag">{{$category['name']}}</a> @endforeach
              
              
              
              @endif </span> 
              
              <!--时间--> 
              
              <span class="date">{{str_limit($article->release_time, 10, '')}}</span> 
              
              <!--点赞--> 
              
              <span title="" class="like"><i class="icon-eye"></i><span

                                                    class="count">{{$article->view_num}}</span></span></div>
          </article>
        </li>
        @endif
        
        
        
        @endforeach
      </ul>
    </article>
  </div>
  <div class="sidebar right box">
    <section class="label_right_title">
      <h2>{{trans('index.hot_tags')}}</h2>
    </section>
    <div class="label">
      <ul>
        @foreach ($hot_tags as $tag)
        <li><a href="/search?keyword=@if('zh-CN' == $lang) {{$tag->name_cn}} @else {{$tag->name_en}} @endif">@if('zh-CN' == $lang) {{$tag->name_cn}} @else {{$tag->name_en}} @endif</a></li>
        @endforeach
      </ul>
    </div>
    @if (isset($ads_8))
    
    @foreach ($ads_8 as $ad8)
    <div class="index_right_ad"><a href="{{$ad8->ad_url}}"><img src="{{url('uploads/' . $ad8->ad_img)}}" width="288" height="225"/></a></div>
    @endforeach
    
    
    
    @endif
    <div class="jobs"><a href="/static/job_service.html" class="jobs_release"> <img src="/images/job_24.gif" width="288" height="115"

                                                                     alt="发布新工作"/></a>
      <section class="label_right_title">
        <h2>{{trans('index.latest_job')}}</h2>
      </section>
      <ul>

      @foreach($joblist as $list)
        <li><a target="_blank" href="/job/detail/{{$list['id']}}">({{mb_substr($list['addr'],0,2)}}) {{mb_substr($list['company_name'],0,8)}} / {{mb_substr($list['job_name'],0,10)}}...</a></li>
      @endforeach  
      </ul>
    </div>
  </div>
</section>
<!---猜你喜欢end----> 
@endsection