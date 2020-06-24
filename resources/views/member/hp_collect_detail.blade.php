@extends('layouts.app')

@section('title')
  {{trans('comm.yinji')}} - TA {{trans('index.collection_detail')}}
@endsection
   
@section('content')
<style>
body{background:#f8f8f8 !important;}
.home_box{border-radius:10px !important;}
.home_top{background:#fff !important;}
</style>
<div class="home_top">
<div class="home_banber"> 
    @if($users->zhuti)
    <img src="{{$users->zhuti}}" alt="个人主页图片" />
    @else
    <img src="/images/zhutibj.jpg" alt="个人主页图片" />
    @endif
  </div>
  <div class="home_tongji">
  <ul>
      <li>{{trans('index.sentiment')}}</br>{{App\User::getViewNum($users->id)}} </li>
      <li>{{trans('index.collection')}}</br>{{App\User::getCollectNum($users->id)}} </li>
      <li>{{trans('index.follow')}}</br>{{App\User::getFollowNum($users->id)}} </li>
      <li>{{trans('index.fans')}}</br>{{App\User::getFansNum($users->id)}} </li>
    </ul>
  </div>
  <div class="home_personal"> <img src="@if($users->avatar) {{$users->avatar}} @else /img/avatar.png @endif" alt="{{$users->nickname}}" />
   
  </div>
  <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> {{$users->nickname}} <img src="{{$users->vip_level}}" alt=""></h2>
  <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;">@if($users->zhiwei){{$users->zhiwei}}@else 保密 @endif - {{$users->city}} <img src="{{App\User::getVipLevel($users->id)}}" alt=""></p>
  @if($user->id==$users->id)
  
  @elseif($users->is_follow)
  <p style="position:absolute; text-align:center;left: 0;top:450px;width: 100%;"><span class='have-disalbed' uid='{{$users->id}}' style='padding: 5px 25px;display: inline-block;background: #eee;margin: 20px auto;color: #666;cursor:no-drop !important;border-radius: 5px;'>{{trans('index.following')}}</span></p>
  @else
  <p style="position:absolute; text-align:center;left: 0;top:450px;width: 100%;"><span class='gzuser' uid='{{$users->id}}' style='padding: 5px 25px;display: inline-block;background: #3d87f1;margin: 20px auto;color: #fff;cursor: pointer !important;border-radius: 5px;'>{{trans('index.follow')}}</span></p>
  @endif
  <div class="home_nav" style='width:610px;left:52%;'>
    <ul>
        <li><a href="/member/{{$users->id}}">{{trans('index.home_page')}}</a></li>
        <li><a href="/member/homepage_finder/{{$users->id}}">{{trans('index.discovery')}}</a></li>
        <li class="current"><a href="/member/homepage_collect/{{$users->id}}">{{trans('index.collection')}}</a></li>
        <li><a href="/member/homepage_subscription/{{$users->id}}">{{trans('index.subscription')}}</a></li>
        <li><a href="/member/homepage_interactive/{{$users->id}}">{{trans('index.follow')}}</a></li>
        <li><a href="/member/homepage_fans/{{$users->id}}">{{trans('index.fans')}}</a></li>
    </ul>
  </div>
</div>
<section class="wrapper" style='width:1245px;'>
  <div class="mt30 home_box">
    <div class="title">
      <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'>{{$folder_name or ''}}</span></h2>
      
      <span class="fr"><a href="javascript:window.history.go(-1);" data-type="collect" >&lt; {{trans('index.back')}}</a></span> </div>
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

<script>
  // 关注TA
  $('.gzuser').click(function(){
    let gzid=$(this).attr('uid');
    let that=$(this);
    $.ajax({
        url: '/member/gzta',
        type: 'POST',
        dataType: 'json',
        data: {_token:'{{csrf_token()}}',gzid:gzid},
        success: function (data) {
            if (data.status_code == 100) {
                layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
                that.text('取消关注');
                that.removeClass('gzuser');
                that.addClass('have-disalbed').css('background','#e62b3c');
                window.location.reload();
            } else {
                layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
            }
        }
    });
  });


</script>
@endsection