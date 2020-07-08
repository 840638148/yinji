@extends('layouts.app')

@section('title')

  {{trans('comm.yinji')}} - TA {{trans('index.subscription')}}

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
        <li><a href="/member/homepage_collect/{{$users->id}}">{{trans('index.collection')}}</a></li>
        <li class="current"><a href="/member/homepage_subscription/{{$users->id}}">{{trans('index.subscription')}}</a></li>
        <li><a href="/member/homepage_interactive/{{$users->id}}">{{trans('index.follow')}}</a></li>
        <li><a href="/member/homepage_fans/{{$users->id}}">{{trans('index.fans')}}</a></li>
    </ul>
  </div>
</div>
<section class="wrapper" style='width:1245px;'>
  <div class="mt30 home_box">
    <div class="title" style='position: relative;'>
      <h2><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'>TA {{trans('index.subscription')}}</span></h2>
      <div class="desearch" style='position: absolute;top: 6px;right: 0;'>
        <form id="myform" action="/member/desearch"  style="position:relative;padding:0;" method="post" class="search_form" onkeydown="if (event.keyCode == 13) return false"  >
            <i class="findersearch_btn icon-search-1 fr" style="position: absolute;left: 10px;top: -3px;padding: 5px;cursor: pointer;border:none;width: 30px;display: block;height: 30px;"></i>
            <input name="content" id="txt_name" class="text_input" type="text" placeholder="{{trans('index.Please_enter_the_designer_name')}}" style=" width:90%;height:33px;text-indent: 2.5em;border-radius: 50px;" >
        </form>
      </div>
    </div>
    
    <!----------设计师订阅------->
    
    <div class="public_list"> 
      @foreach ($users->subscriptions as $subscription)
      <div class="public_item" data-id="{{$subscription->id}}">
        <div class="item_left"> 
          <a href="@if($subscription->static_url) /designer/{{$subscription->static_url}} @else /designer/detail/{{$subscription->id}} @endif">
            <div class="tx"><img src="{{get_designer_thum($subscription)}}" alt="{{get_designer_title($subscription)}}"></div>
          </a>
          <div class="item_msg">
            <div class="title"> 
              <a href="@if($subscription->static_url) /designer/{{$subscription->static_url}} @else /designer/detail/{{$subscription->id}} @endif"> {{get_designer_title($subscription)}} </a> 
            </div>
            <div class="describe"> 
              <span>国家：
                @foreach ($subscription->categorys as $category)
                @if($loop->last)
                {{$category['name']}}
                @else
                {{$category['name']}},
                @endif
                @endforeach 
              </span>
              <span style='height:25px !important;'>{!! get_designer_description($subscription) !!}</span> 
            </div>
            <div class="focus">
            @if($subscription->has_dy)
              <a href="javascript:void(0)"  style='background: #eee;color: #999;padding: 3px 30px;border-radius: 30px;cursor: no-drop;'> {{trans('index.subscribed')}} </a>
            @else 
              <a href="javascript:void(0)" data-id="{{$subscription->id}}" class="focus_btn2 click cancelSubscription" style='background: #636af3;color: #FFF;'> {{trans('index.subscription')}} </a>
            @endif
              <div class="focus_msg"><span>作品：{{$subscription->article_num}}</span> | <span>粉丝：{{$subscription->fans_num}}</span></div>
            </div>
          </div>
        </div>
        <div class="item_right"> 
          @foreach($subscription->articles as $article)
            <div class="works" data-id="1722"> 
              <a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif" target="_blank"> 
                <img src="{{get_article_thum($article)}}" alt=""> 
                <span>{{get_article_title($article)}}</span> 
              </a> 
            </div>
          @endforeach 
        </div>
      </div>
      @endforeach 
    </div>
    
    <!----------设计师订阅结束-------> 
    
  </div>
</section>

<script type="text/javascript">
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




  $(document).ready(function(){
    //订阅
    $(document).on('click','.cancelSubscription',function(e){
      let designer_id = $(this).attr('data-id');
      $.ajax({
        url: '/member/gztady',
        type: 'POST',
        dataType: 'json',
        data: {_token:'{{csrf_token()}}',designer_id:designer_id},
        success: function (data) {
          if (data.status_code == 100) {
            layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
            // window.location.reload();
          } else {
            layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
          }
        }
      });
    });


    //绑定回车事件
    $("#myform #txt_name").keydown(function (e) { 
        var keyCode = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode; //兼容IE 火狐 谷歌
        if (keyCode == 13) {
          $(this).siblings('.findersearch_btn').trigger("click");
            // $(".findersearch_btn").trigger("click");
            return false;
        }
    });

    // 搜索框
    window.content='';
    $(document).on('click','.findersearch_btn',function(){
      window.content=$(this).siblings('.text_input').val();
      if(content=='' || content==null){
        layer.msg('请填写搜索关键词!!!',{skin: 'intro-login-class layui-layer-hui'});
        return false;
      }else{
        let h='';
        // console.log(content)
        $.ajax({
          async:false,
          url: '/member/desearch',
          type: 'POST',
          dataType: 'json',
          data: {content:content},
          success:function(data) {
            console.log(data.data)
            if(data.status_code==0){
              // layer.msg(data.data.msg,{skin: 'intro-login-class layui-layer-hui'});
              $('.public_list').html(data.data.result); 
            }else{
              layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'});
              $('.text_input').val('');
            }
          }
        });
      }  

    })
  })

</script> 
@endsection