@extends('layouts.app')
@section('title')
  {{trans('comm.yinji')}} - 个人主页
@endsection
@section('content')
<style>
  .item .edit_favorites{
    position: absolute;
    display: inline-block;
    vertical-align: top;
    text-indent: 0;
    text-align: center;
    line-height: 32px;
    z-index: 120;
    right: 123px;
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
    right: 0;
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
  .sign_box{
    width: 610px;
    padding: 20px;
    min-height: 400px;
    height: 680px;
    position: fixed;
    z-index: 9999;
    background: #fff;
    top: 16%;
    left: 50%;
    margin-left: -305px;
    box-shadow: 0px 0px 5px rgba(0,0,0,3);
    border-radius: 3px;
    overflow: auto;
  }
  .change_box{
    display:none;
  }
  .img_browse{
    position: fixed;
    left: 50%;
    top:50%;
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
    height: calc( 100% - 50px);
  }
  .lzcfg{
    background: rgba(0,0,0,0.5);
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    display: none;
    z-index: 999;
  }
</style>
<!--笼罩层-->
<div class="lzcfg"></div>
<div class="home_top">
  <div class="home_banber"> <img src="/images/home_bj.jpg" alt="个人主页图片" /></div>
  <div class="home_tongji">
  <ul>
    <li>人气</br>{{$user->finder_num}} </li>
    <li>收藏</br>{{$user->collect_num}} </li>
    <li>发现</br>{{$user->finder_num}} </li>
    <li>关注</br>{{$user->follow_num}} </li>
    <li>粉丝</br>{{$user->follow_num}} </li>
        
    </ul>
  </div>
  <div class="home_personal"> <img src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$user->nickname}}" />
   
  </div>
  <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> {{$user->nickname}} <img src="{{$user->vip_level}}" alt=""></h2>
  <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;">个人说明： {{$user->personal_note}}</p>
  <p>关注</p>
  <div class="home_nav">
    <ul>
    	
	      <li class="current"><a  href="/">首页</a></li>
	      <li><a href="/member/finder">TA的发现</a></li>
	      <li><a href="/member/collect">TA的收藏</a></li>
	      <li><a href="/member/subscription">TA的订阅</a></li>
	      <li><a href="/member/follow">TA的互动</a></li>
	      <li><a href="/member/profile">印记</a></li>
    </ul>
  </div>
</div>
<section class="wrapper">
  <div class="mt30 home_box">

    <h2 class="fl">TA的收藏</h2>
    <span class="fr"><a href="/member/collect">更多</a></span> </div>
    <div class="masonry my-collection" >   
      @foreach($user->collects as $collect)
      <div class="item collection-item " data-id="{{$collect['folder']['id']}}" onclick="location='/member/collect_detail/{{$collect['folder']['id']}}'">
        <div class="item__content">
          <ul data-id="{{$collect['folder']['id']}}" >
            @foreach($collect['collect'] as $img_obj)
            <li><a href="/member/collect_detail/{{$collect['folder']['id']}}"><img src="{{$img_obj['img']}}" /></a></li>
            @endforeach
          </ul>
          <div class="find_title">
            <h2><a>{{$collect['folder']['name']}}</a></h2>
          <div class="collection_images">  <i class="icon-eye" title="公开"></i> {{$collect['folder']['total']}}</div>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <div class="title mt30">
      <h2>TA的关注</h2>
    </div>
    <div class="designer">
      <ul>
        @foreach ($user->follows as $key => $follow)
            @if ($key < 13)
                <li class="guanzhu-item"> <a href="javascript:alert1();" title="{{$follow->nickname}}" onclick="selectItemGuanZhu({{$key}})"><span class="select-item"></span>  <img onerror="this.onerror=``;this.src=`/img/avatar.png`" src="@if($follow->avatar) {{$follow->avatar}} @else /img/avatar.png @endif" alt="{{$follow->nickname}}" /> </a> </li>
            @elseif($key == 13)
                <li><a href="/member/follow" class="more-content"></a></li>
            @endif
            @endforeach
      </ul>
    </div>

   
</div>
    
  <script type="text/javascript">
    function alert1(){
      layer.msg('敬请期待！',{time: 1500,skin: 'intro-login-class layui-layer-hui'});
    }
    
  </script>


@endsection