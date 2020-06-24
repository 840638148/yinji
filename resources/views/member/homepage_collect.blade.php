@extends('layouts.app')

@section('title')
  {{trans('comm.yinji')}} -  TA {{trans('index.collection')}}
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
        <li><a  href="/member/{{$users->id}}">{{trans('index.home_page')}}</a></li>
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
      <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'>TA {{trans('index.collection')}}</span></h2>
    </div>
    <div class="masonry" > @foreach($users->collects as $collect)
      <div class="item">
        <div class="item__content" style="position:relative">
          <ul  onclick="location.href='/member/hp_collect_detail/{{$users->id}}/{{$collect['folder']['id']}}'">
            @foreach($collect['collect'] as $img_obj)
                  @if ($img_obj['img'])
                    <li><a href="/member/hp_collect_detail/{{$users->id}}/{{$collect['folder']['id']}}"><img src="{{$img_obj['img']}}" /></a></li>
                  @endif
            @endforeach
          </ul>
          <!-- <div class="edit_favorites fr" folder-type="collect" data-id="{{--$collect['folder']['id']--}}">编辑</div> -->
          <div class="find_title">
            <h2><a>{{$collect['folder']['name']}}</a></h2>
            <div class="collection_images">  <i class="icon-eye-off" title="不公开"></i> {{$collect['folder']['total']}}</div>
          </div>
          
        </div>
      </div>
      @endforeach </div>
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