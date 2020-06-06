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
      <li>人气</br>{{$users->view_num}} </li>
      <li>收藏</br>{{App\User::getCollectNum($users->id)}} </li>
      <li>关注</br>{{App\User::getFollowNum($users->id)}} </li>
      <li>粉丝</br>{{App\User::getFansNum($users->id)}} </li>
    </ul>
  </div>
  <div class="home_personal"> <img src="@if($users->avatar) {{$users->avatar}} @else /img/avatar.png @endif" alt="{{$users->nickname}}" />
   
  </div>
  <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> {{$users->nickname}} <img src="{{$users->vip_level}}" alt=""></h2>
  <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;">@if($users->zhiwei){{$users->zhiwei}}@else 保密 @endif - {{$users->city}} <img src="{{App\User::getVipLevel($users->id)}}" alt=""></p>
  @if($user->id==$users->id)
  
  @elseif($users->is_follow)
  <p style="position:absolute; text-align:center;left: 0;top:450px;width: 100%;"><span class='have-disalbed' uid='{{$users->id}}' style='padding: 5px 25px;display: inline-block;background: #e62b3c;margin: 20px auto;color: #fff;cursor:pointer !important;'>取消关注</span></p>
  @else
  <p style="position:absolute; text-align:center;left: 0;top:450px;width: 100%;"><span class='gzuser' uid='{{$users->id}}' style='padding: 5px 25px;display: inline-block;background: #3d87f1;margin: 20px auto;color: #fff;cursor: pointer !important;'>关注</span></p>
  @endif
  <div class="home_nav" style='width:610px;left:52%;'>
    <ul>
	      <li class="current"><a  href="/member/{{$users->id}}">TA的主页</a></li>
	      <li><a href="/member/homepage_finder/{{$users->id}}">TA的发现</a></li>
	      <li><a href="/member/homepage_collect/{{$users->id}}">TA的收藏</a></li>
	      <li><a href="/member/homepage_subscription/{{$users->id}}">TA的订阅</a></li>
	      <li><a href="/member/homepage_interactive/{{$users->id}}">TA的互动</a></li>
	      <li><a href="/member/homepage_record/{{$users->id}}">印记</a></li>
    </ul>
  </div>
</div>
<section class="wrapper">
  <div class="mt30 home_box">
    <!-- TA的收藏 -->
    <div class="title">
      <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'>TA的收藏</span></h2>
      <span class="fr"><a href="/member/homepage_collect/{{$users->id}}">更多</a></span>
    </div>
    <div class="masonry my-collection" >   
      @foreach($users->collects as $collect)
      <div class="item collection-item " data-id="{{$collect['folder']['id']}}" onclick="location='/member/hp_collect_detail/{{$users->id}}/{{$collect['folder']['id']}}'">
        <div class="item__content">
          <ul data-id="{{$collect['folder']['id']}}" >
            @foreach($collect['collect'] as $img_obj)
            <li><a href="/member/hp_collect_detail/{{$users->id}}/{{$collect['folder']['id']}}"><img src="{{$img_obj['img']}}" /></a></li>
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
    <!-- TA的收藏end -->
    <!-- TA的关注 -->
    <div class="title mt30">
      <div class="title">
        <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'>TA的关注</span></h2>
      </div>
    </div>
    <div class="designer">
      <ul>
        @foreach ($users->follows as $key => $follow)
            @if ($key < 13)
                <li class="guanzhu-item"> <a href="/member/{{$follow->id}}" title="{{$follow->nickname}}" onclick="selectItemGuanZhu({{$key}})"><span class="select-item"></span>  <img onerror="this.onerror=``;this.src=`/img/avatar.png`" src="@if($follow->avatar) {{$follow->avatar}} @else /img/avatar.png @endif" alt="{{$follow->nickname}}" /> </a> </li>
            @elseif($key == 13)
                <li><a href="/member/homepage_interactive/{{$users->id}}" class="more-content"></a></li>
            @endif
            @endforeach
      </ul>
    </div>
    <!-- TA的关注end -->
    <!-- TA的访客 -->
    <div class="title mt30" style='position:relative'>
      <div class="title">
        <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'>访客</span><span style='position:absolute;top:0;right:60%;'>评论：</span></h2>
      </div>
    </div>
    <div class='designer' style='width:30%;float:left;'>
      <ul>
        @foreach ($visited as $follow)
            <li class="guanzhu-item" style='margin-bottom:10px;'>
              <a href="/member/{{$follow->user_id}}" ><span class="select-item"></span>  
              <img onerror="this.onerror=``;this.src=`/img/avatar.png`" src="@if($follow->avatar) {{$follow->avatar}} @else /img/avatar.png @endif" alt="{{$follow->nickname}}" /> </a> 
              @if($follow->created_at < date('Y-m-d H:i:s',time()-60))
              <span>1分钟前</span>
              @elseif($follow->created_at < date('Y-m-d H:i:s',time()-600))
              <span>10分钟前</span>
              @elseif($follow->created_at < date('Y-m-d H:i:s',time()-1800))
              <span>30分钟前</span>
              @elseif($follow->created_at < date('Y-m-d H:i:s',time()-6000))
              <span>1小时前</span>
              @elseif($follow->created_at < date('Y-m-d H:i:s',time()-86400))
              <span>1天前</span>
              @endif
            </li>
        @endforeach
      </ul>
    </div>
    <div class='fkright' style='width:65%;float:right;'>
        <div class="msgCon"> 
          @foreach ($comments as $comment)
          @if($comment->content!='')
          <div class="msgBox">
              <!-- 只显示有评论的 -->
          <dl>
              <dt><img src="{{$comment->user->avatar}}" width="50" height="50"></dt>
              
              <dd>
                  <span style="float:left">{{$comment->user->nickname}}
                      <img src="{{App\User::getVipLevel($comment->user->id)}}" alt="">
                  </span>
                  <ul class="show_number clearfix" style=" float:left;margin:10px 0 0 30px;">
                  <li style="width:200px;">
                      <div class="atar_Show2">
                      <p tip="{{$comment->stars}}"></p>
                      </div>
                      <span></span>
                  </li>
                  </ul>  
                  <span>发布于：{{$comment->created_at}}</span>
              </dd>
              <div class="msgTxt">{!!$comment->content!!}</div>
          
          </dl>
          </div> 
          @endif
          @endforeach 
        </div>
        <div class='fbpl'>
          <h2><span>发表评论</span></h2>
          
          <textarea style="resize:none;" name="con" id="con" cols="30" rows="10"></textarea>
          <span class='fbbtn' style='display: inline-block;padding: 10px 20px;background: #000;color: #fff;margin: 20px 0;'>发表评论</span>
        </div>
    </div>
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

  //取消关注TA
  $('.have-disalbed').click(function(){
    let gzid=$(this).attr('uid');
    let that=$(this);
    $.ajax({
        url: '/member/qxgzta',
        type: 'POST',
        dataType: 'json',
        data: {_token:'{{csrf_token()}}',gzid:gzid},
        success: function (data) {
            if (data.status_code == 100) {
                layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
                that.text('关注');
                that.removeClass('have-disalbed');
                that.addClass('gzuser').css('background','#3d87f1');
                window.location.reload();
            } else {
                layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
            }
        }
    });
  });

  //统计访问
  $(function(){

    let urls=window.location.href;
    let uid=urls.split('/')[4];
    console.log(uid)
    $.ajax({
        url: '/member/visited_hp',
        type: 'POST',
        dataType: 'json',
        data: {_token:'{{csrf_token()}}',uid:uid},
        success: function (data) {
            if (data.status_code == 100) {
                // layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
                
            } else {
                // layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
            }
        }
    });
  })

  //发表评论
  $('.fbbtn').click(function(){
    let con=$('#con').val();
    // console.log(con)
  })

</script>

@endsection