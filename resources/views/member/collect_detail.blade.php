@extends('layouts.app')

@section('title')
  {{trans('comm.yinji')}} - 个人中心 - 收藏详情
@endsection
   
@section('content')
<div class="home_top">
  <div class="home_banber"> <img src="/images/home_bj.jpg" alt="个人主页图片" /></div>
  <div class="home_tongji">
    <ul>
      <li> 订阅</br>
        {{$user->subscription_num}} </li>
      <li> 收藏</br>
        {{$user->collect_num}} </li>
      <li> 发现</br>
        {{$user->points}} </li>
      <li> 关注</br>
        {{$user->follow_num}} </li>
    </ul>
  </div>
  <div class="home_personal"> <img src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$user->nickname}}" /></div>
   <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> {{$user->nickname}}  @if($user->is_vip)<span class="vip1">VIP{{$user->level}}</span>@else<span class="vip1" style="background-color:#ccc;color:#fff;">普通用户</span> @endif </h2>
      <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;">个人说明： {{$user->personal_note}}</p>
  
  
  <div class="home_nav">
    <ul>
      <li><a  href="/member">个人中心</a></li>
      <li><a href="/member/finder">我的发现</a></li>
      <li class="current"><a href="/member/collect">我的收藏</a></li>
      <li><a href="/member/subscription">我的订阅</a></li>
      <li><a href="/member/follow">我的关注</a></li>
      <li><a href="/member/point">我的积分</a></li>
      <li><a href="/member/profile">个人资料</a></li>
    </ul>
  </div>
</div>
<section class="wrapper">
  <div class="mt30 home_box">
    <div class="title">
      <h2 class="fl">{{$folder_name or ''}}</h2>
      
      <span class="fr"><a href="javascript:window.history.go(-1);" data-type="collect" >&lt; 返回</a></span> </div>
    <ul class="layout_ul ajaxposts">
      <div class="post_list">
        <ul>
          @foreach ($user->collect_details as $article)
          <li class="layout_li ajaxpost">
            <article class="postgrid">
            <span class="guojia2" >
              <a style="position:absolute;bottom:60px;right:71px;z-index:9;" href="#" rel="tag">加拿大</a>
            </span>
              <figure> <a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif" title="{{get_article_title($article)}}" target="_blank"> <img class="thumb" src="{{get_article_thum($article)}}" data-original="{{get_article_thum($article)}}" alt="{{get_article_title($article)}}" style="display: block;"> </a> </figure>
              <h2> <a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif" title="{{get_article_title($article)}}" target="_blank">
                <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;">{{get_article_title($article, 1)}}</div>
                <div style=" color:#666; line-height:24px;">{{get_article_title($article, 2)}}</div>
                </a> </h2>
                <a style="position: absolute;bottom: 60px;right: 30px;" href="javascript:;" class="find-icon-trash remove_find_img" data-id="{{$article->delid}}" tag="删除发现的图片"></a> </div>
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
//删除发现图片
$(document).on('click','.remove_find_img',function(ev){
    if (!confirm("确定删除？")) {
        return false;
    }

    var finder_id = $(this).attr('data-id');
    var url = '/member/delete_folder_item';
    var folder_data = {
        _token:_token,
        finder_id:finder_id,
    };

    $.ajax({
        async:false,
        url: url,
        type: 'POST',
        dataType: 'json',
        data: folder_data,
        success: function (data) {
            if (data.status_code == 0) {
                alert('删除成功！');
                window.location.reload();
            } else { 
                alert(data.message);
            }
        }
    });

    return false;
});




</script> 
@endsection