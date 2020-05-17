@extends('layouts.app')

@section('title')

  {{trans('comm.yinji')}} - 个人中心 -下载中心

@endsection

@section('content')
<div class="home_top">
  <div class="home_banber"> <img src="/images/home_bj.jpg" alt="个人主页图片" /></div>
  <div class="home_tongji">
  <ul>
      <li>发现</br>
        {{$user->finder_num}} </li>
      <li> 收藏</br>
        {{$user->collect_num}} </li>
      <li> 订阅</br>
        {{$user->subscription_num}} </li>
      <li> 关注</br>
        {{$user->follow_num}} </li>
    </ul>
  </div>
  <div class="home_personal"> <img src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$user->nickname}}" />
  </div>
  <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> {{$user->nickname}} <img src="{{$user->vip_level}}" alt=""></h2>
  <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;">个人说明： {{$user->personal_note}}</p>
  <div class="home_nav">
    <ul>
      <li><a  href="/member">个人中心</a></li>
      <li><a href="/member/finder">我的发现</a></li>
      <li><a href="/member/collect">我的收藏</a></li>
      <li><a href="/member/subscription">我的订阅</a></li>
      <li><a href="/member/follow">我的关注</a></li>
      <li class="current"><a href="/member/mydown">我的下载</a></li>
      <li><a href="/member/profile">个人资料</a></li>
    </ul>
  </div>
</div>
<section class="wrapper">
  <div class="mt30 home_box">
    <!-- 我的下载 -->
    <div class="title  mt30">
     <b style="font-size:12px; float:right;color:#ccc; line-height:48px;">(温馨提示：所有的下载链接只显示三天时间,三天过后自动过期,需要再次去相应文章下载兑换哦!)</b>
      <h2 class="fl">我的下载</h2>
    </div>

    @foreach($down as $v)
    <div class="down" style="margin-bottom:20px; border-bottom:1px solid #eee; float:left; width:100%">

      <div class="downleft" style="width: 180px;">
        <a href="/article/{{$v->static_url}}" target="_blank"><img src="/uploads/{{$v->custom_thum}}" alt="{{$v->title_designer_cn}} - {{$v->title_name_cn}}"></a>
      </div>
      <div class="downright" style="float: left;margin-left: 100px;">
        <p>下载地址：<a href="{{mb_substr($v->vip_download,0,-10)}}" target="_blank">{{mb_substr($v->vip_download,0,-10)}}</a> </p>
        <p>提取密码：{{mb_substr($v->vip_download,-4)}}</p>
        <p>兑换时间：{{$v->created_at}}</p>
        <p>过期时间：<span style="color:#f60;">{{$v->guoqitime}}</span></p>
      </div>

    </div>
    @endforeach
    <!-- 我的下载结束 -->
  </div>
</section>

@endsection