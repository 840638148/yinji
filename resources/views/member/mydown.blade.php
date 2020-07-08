@extends('layouts.app')

@section('title')

  {{trans('comm.yinji')}} - {{trans('index.home')}} - {{trans('index.down_center')}}

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
      <li>{{trans('index.discovery')}}</br>
        {{$user->finder_num}} </li>
      <li> {{trans('index.collection')}}</br>
        {{$user->collect_num}} </li>
      <li> {{trans('index.subscription')}}</br>
        {{$user->subscription_num}} </li>
      <li> {{trans('index.follow')}}</br>
        {{$user->follow_num}} </li>
    </ul>
  </div>
  <div class="home_personal"> <img src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$user->nickname}}" />
  </div>
  <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> {{$user->nickname}} <img src="{{$user->vip_level}}" alt=""></h2>
  <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;">{{trans('index.personal_description')}}： {{$user->personal_note}}</p>
  <div class="home_nav">
    <ul>
        <li><a href="/member">{{trans('index.home')}}</a></li>
	      <li><a href="/member/finder">{{trans('index.my_finder')}}</a></li>
	      <li><a href="/member/collect">{{trans('index.my_collection')}}</a></li>
	      <li><a href="/member/subscription">{{trans('index.my_subscription')}}</a></li>
	      <li><a href="/member/follow">{{trans('index.my_interactive')}}</a></li>
	      <li class="current"><a href="/member/mydown">{{trans('index.my_download')}}</a></li>
	      <li><a href="/member/profile">{{trans('index.the_personal_data')}}</a></li>
    </ul>
  </div>
</div>
<section class="wrapper">
  <div class="mt30 home_box" style='float:left;width: 100%;'>
    <!-- 我的下载 -->
    <div class="title  mt30">
      <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'>{{trans('index.my_download')}}</span></h2><b style=" font-size:12px; float:right;color:#f60; line-height:48px;">（{{trans('index.tips')}}）</b>
    </div>



    <ul class="layout_ul ajaxposts">
      <div class="post_list">
        <ul>
        @foreach($down as $v)
          <li class="layout_li ajaxpost">
            <article class="postgrid">
              <figure> <a href="/article/{{$v->static_url}}" target="_blank"><img src="/uploads/{{$v->custom_thum}}" alt="{{$v->title_designer_cn}} - {{$v->title_name_cn}}"></a></figure>
              <p style="height:30px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap; width:320px;text-indent:10px"> {{trans('index.download_address')}}：<a href="{{mb_substr($v->vip_download,0,-10)}}" target="_blank">{{mb_substr($v->vip_download,0,-10)}}</a></p>
              <p style='position: relative;text-indent:10px;'>{{trans('index.extract_the_code')}}：
                <input title='点我复制' class='copybtn' style='padding: 0 5px 0;background: #ccc;border-radius: 5px;cursor: pointer;border:none;width:45px;' onclick="copybtn(this)" readonly value='{{mb_substr($v->vip_download,-4)}}'></p>
              <p style='text-indent:10px;'>{{trans('index.expiration_time')}}：<span style="color:#f60;">{{$v->guoqitime}}</span></p>
            </article>
          </li>
          @endforeach
        </ul>
        <!-- 分页 --> 
      </div>
    </ul>














    <!-- 我的下载结束 -->
  </div>
</section>

<script type="text/javascript" src="/js/dist/clipboard.min.js"></script>	
<script>
function copybtn(obj){
  let con=document.getElementById("tqmm");
  obj.select(); // 选择对象
  document.execCommand("Copy"); // 执行浏览器复制命令
  // console.log(con);
  layer.msg('复制成功',{time: 1500,skin: 'intro-login-class layui-layer-hui'});
}


</script>
@endsection