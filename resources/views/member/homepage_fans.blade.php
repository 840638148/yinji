@extends('layouts.app')

@section('title')
  {{trans('comm.yinji')}} -  TA的印记
@endsection

@section('content')
<style>
  body{background:#f8f8f8 !important;}
  .home_box{border-radius:10px !important;}
  .home_top{background:#fff !important;}
  .item .edit_favorites{
        position: absolute;
    display: inline-block;
    vertical-align: top;
    text-indent: 0;
    text-align: center;
    line-height: 32px;
    z-index: 120;
    right: 120px;
    top: 34%;
  }
  .edit_favorites:hover .item-setting-btns{
      color:#555;
  }
  .find_title{
      overflow:inherit;
      position:relative;
  }
  .find_title h2{
      float: none;
      width:200px;
      vertical-align: top
  }
  .item .item-setting-btns{
      display: none;
      position: absolute;
      right:-35px;
      background: #fff;
      border-radius: 4px;
      width: 90px;
      padding: 3px 0px;
      text-align: center;
      font-size: 12px;
      box-shadow: 0 0 11px rgba(0,0,0,.1);
      top:40px;
      margin-bottom: 4px;
  }

  .item.selected .item-setting-btns{
      display: block;
  }
  .modal{
    display:none;
  }
  .img_browse{
    position: fixed;
    left: 50%;
    top: 50%;
    width: 800px;
    margin-left: -350px;
    margin-top: -350px;
    height: 720px;
    min-height:0;
    background: #fff;
    z-index: 999;
    padding: 10px;
    border-radius: 5px;
  }
  .img_browse .right{
    width:260px;
    height: 100%;
  }
  .img_browse .right .head img{
    width:100%;
    height: 100%;
  }
  .img_browse .right .faxian_info{
    margin-top: 10px;
  }
</style>
<!-- <link rel="shortcut icon" href="favicon.ico"> <link href="/css/hp_css/bootstrap.min.css?v=3.3.6" rel="stylesheet"> -->
<link href="/css/hp_css/font-awesome.css?v=4.4.0" rel="stylesheet">
<link href="/css/hp_css/style.css?v=4.1.0" rel="stylesheet">
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
        <li><a href="/member/homepage_collect/{{$users->id}}">TA的收藏</a></li>
        <li><a href="/member/homepage_subscription/{{$users->id}}">TA的订阅</a></li>
        <li><a href="/member/homepage_interactive/{{$users->id}}">TA的关注</a></li>
        <li><a href="/member/homepage_fans/{{$users->id}}">TA的粉丝</a></li>
    </ul>
  </div>
</div>
<section class="wrapper">
    <div class="mt30 home_box">
        <div class="title">
            <h2 class="fl" style='line-height: 40px;'><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'>TA的粉丝</span></h2>
        </div>
        <!-- TA的粉丝开始 -->
        <div class="masonry" > 
        @foreach ($users->fans as $follow)
          <div class="item">
            <div class="users">
              <div class="border-bottom1">
                {{--<div class="head"><a href="/vip/index/{{$follow->id}}"><img src="@if($follow->avatar) {{$follow->avatar}} @else /img/avatar.png @endif" alt="{{$follow->nickname}}" /></a></div>--}}
                <div class="head"><a href="javascript:void(0)"><img style="margin-top:unset;" alt="头像" onerror="this.onerror=``;this.src=`/img/avatar.png`" src="@if($follow->avatar) {{$follow->avatar}} @else /img/avatar.png @endif" alt="{{$follow->nickname}}" /></a></div>
                <h2><a style='font-size:16px;' href="/vip/index/{{$follow->id}}">{{$follow->nickname}}</a> </h2>
                <p style="position:relative;"> 
                  
                  @if($follow->zhiwei){{$follow->zhiwei}} @else 其他 @endif
                  -
                  {{$follow->city}}

                <span style="background:none;background: none;position: absolute;top: -3px;" class="VIP1"><img style="width:32px;" src="{{$follow->vip_level}}" alt=""></span> </p>
                </div>
              <div class="Statistics">
                <ul>
                  <li><span>{{$follow->collect_num}}</span>收藏</li>
                  <li><span>{{$follow->fans_num}}</span>粉丝</li>
                </ul>
              </div>
              <a href="javascript:void(0)" data-id="{{$follow->id}}" class="Button cancelFollow" style="width:60px;">关注</a> 
                </div>
          </div>

          @endforeach 
          </div>
      <!-- 我的粉丝结束 -->
    </div>
</section>
<script>
    $(document).ready(function(){
      //关注
      $(".cancelFollow").click(function(e){
        let gzid = $(this).attr('data-id');
        console.log(gzid)
        $.ajax({
          url: '/member/gzta',
          type: 'POST',
          dataType: 'json',
          data: {_token:'{{csrf_token()}}',gzid:gzid},
          success: function (data) {
            if (data.status_code == 100) {
              layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'});
              // window.location.reload();
            } else {
              layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'});
            }
          }
        });
      });
    });
</script>


@endsection
