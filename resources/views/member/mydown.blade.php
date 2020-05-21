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
      <h2 class="fl">我的下载 </h2><b style=" font-size:12px; float:right;color:#f60; line-height:48px;">（温馨提示：有效果期三天，过期需重新兑换！）</b>
    </div>
    @foreach($down as $v)
    <div class="down" style="float:left; width:30%; margin:0 1.6% 20px 1.6%; background-color:#f8f8f8; line-height:30px;">

      <div class="downleft" >
        <a href="/article/{{$v->static_url}}" target="_blank"><img src="/uploads/{{$v->custom_thum}}" alt="{{$v->title_designer_cn}} - {{$v->title_name_cn}}"></a>
      </div>
      <div class="downright" style="float: left; margin-left: 20px;">
        <p style="height:30px;overflow: hidden;text-overflow: ellipsis;    white-space: nowrap; width:320px;">下载地址：<a href="{{mb_substr($v->vip_download,0,-10)}}" target="_blank">{{mb_substr($v->vip_download,0,-10)}}</a> </p>
        <p>提取密码：<span id="tqmm">{{mb_substr($v->vip_download,-4)}}</span> <span class='copybtn' style='float: right;padding: 0 5px 0;background: #ccc;border-radius: 5px;cursor: pointer;' onclick="copybtn()">复制</span></p>
        <!--p>兑换时间：{{$v->created_at}}</p-->
        <p>过期时间：<span style="color:#f60;">{{$v->guoqitime}}</span></p>
      </div>

    </div>
    @endforeach
    <!-- 我的下载结束 -->
  </div>
</section>
<script>
$(function() { 
  $.ajax({  
        type: "post",  
        url: "/member/one_visited",  
        data: {_token: "{{csrf_token()}}"},  
        dataType: "json",  
        success: function(data) {  
          console.log(data)
          if(data.status_code == 0){
            layer.msg(data.message,{time: 1500,skin: 'intro-login-class layui-layer-hui'});
            window.location.href='/member/profile';
          }else{
            layer.msg(data.message,{time: 1500,skin: 'intro-login-class layui-layer-hui'});
          }
          
        }  
    });      
})
</script>
<script type="text/javascript" src="/js/dist/clipboard.min.js"></script>	
<script>
function copybtn(){
  // let con=$('.copybtn').siblings("#tqmm").text();
  // alert(con)
  let texthtml = document.getElementById("tqmm");
  let shtml = texthtml.innerHTML;
  let clipboard = new ClipboardJS('.copybtn',{
    text:function(){
    return shtml;
    }
  })
  clipboard.on('success', function(e) {
    
    console.log(e);
  });

  clipboard.on('error', function(e) {
    console.log(e);
  });

}


</script>
@endsection