@extends('layouts.app')

@section('title')
  {{trans('comm.yinji')}} - TA的收藏详情
@endsection
   
@section('content')
<style>
body{background:#f8f8f8 !important;}
.home_box{border-radius:10px !important;}
.home_top{background:#fff !important;}
</style>
<div class="home_top">
  <div class="home_banber"> <img src="/images/home_bj.jpg" alt="个人主页图片" /></div>
  <div class="home_tongji">
  <ul>
      <li>人气</br>{{App\User::getViewNum($users->id)}} </li>
      <li>收藏</br>{{App\User::getCollectNum($users->id)}} </li>
      <li>关注</br>{{App\User::getFollowNum($users->id)}} </li>
      <li>粉丝</br>{{App\User::getFansNum($users->id)}} </li>
    </ul>
  </div>
  <div class="home_personal"> <img src="@if($users->avatar) {{$users->avatar}} @else /img/avatar.png @endif" alt="{{$users->nickname}}" />
   
  </div>
  <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> {{$users->nickname}} <img src="{{$users->vip_level}}" alt=""></h2>
  <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;">@if($users->zhiwei){{$users->zhiwei}}@else 保密 @endif - {{$users->city}} <img src="{{App\User::getVipLevel($users->id)}}" alt=""></p>
  <p style="position:absolute; text-align:center;left: 0;top:450px;width: 100%;"><span style='padding: 5px 25px;display: inline-block;background: #3d87f1;margin: 20px auto;color: #fff;'>关注</span></p>
  <div class="home_nav" style='width:610px;left:52%;'>
    <ul>
	      <li><a  href="/member/{{$users->id}}">TA的主页</a></li>
	      <li><a href="/member/homepage_finder/{{$users->id}}">TA的发现</a></li>
	      <li class="current"><a href="/member/homepage_collect/{{$users->id}}">TA的收藏</a></li>
	      <li><a href="/member/homepage_subscription/{{$users->id}}">TA的订阅</a></li>
	      <li><a href="/member/homepage_interactive/{{$users->id}}">TA的关注</a></li>
	      <li><a href="/member/homepage_fans/{{$users->id}}">TA的粉丝</a></li>
    </ul>
  </div>
</div>
<section class="wrapper">
  <div class="mt30 home_box">
    <div class="title">
      <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'>{{$folder_name or ''}}</span></h2>
      
      <span class="fr"><a href="javascript:window.history.go(-1);" data-type="collect" >&lt; 返回</a></span> </div>
    <ul class="layout_ul ajaxposts">
      <div class="post_list">
        <ul>
          @foreach ($users->collect_details as $article)
          <li class="layout_li ajaxpost">
            <article class="postgrid">
            <span class="guojia2" >
              <a style="position:absolute;bottom:60px;right:35px;z-index:9;" href="#" rel="tag">{{$article->location_cn}}</a>
            </span>
              <figure> <a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif" title="{{get_article_title($article)}}" target="_blank"> <img class="thumb" src="{{get_article_thum($article)}}" data-original="{{get_article_thum($article)}}" alt="{{get_article_title($article)}}" style="display: block;"> </a> </figure>
              <h2> <a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif" title="{{get_article_title($article)}}" target="_blank">
                <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;">{{get_article_title($article, 1)}}</div>
                <div style=" color:#666; line-height:24px;">{{get_article_title($article, 2)}}</div>
                </a> </h2>
              <div class="homeinfo"> 
                <!--分类--> 
                @if ($article->category)
                @foreach ($article->category as $category) <a href="/article/category/{{$category['id']}}" rel="category tag">{{$category['name']}}</a> @endforeach
                @endif 
                <!--时间--> 
                <span class="date">{{str_limit($article->release_time, 10, '')}}</span> 
                <!--点赞--> 
                <span title="" class="like"><i class="icon-eye"></i><span class="count">{{$article->view_num}}</span></span> </div>
            </article>
          </li>
          @endforeach
        </ul>
        <!-- 分页 --> 
      </div>
    </ul>
  </div>
</section>


@endsection