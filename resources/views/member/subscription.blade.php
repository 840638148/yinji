@extends('layouts.app')



@section('title')

  {{trans('comm.yinji')}} - 个人中心 -订阅中心

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
      <li> 积分</br>
        {{$user->points}} </li>
      <li> 关注</br>
        {{$user->follow_num}} </li>
    </ul>
  </div>
  <div class="home_personal"> <img src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$user->nickname}}" />
  </div>
  <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> {{$user->nickname}}  @if($user->is_vip)<span class="vip1">VIP{{$user->level}}</span>@else<span class="vip1" style="background-color:#ccc;color:#fff;">普通用户</span> @endif </h2>
  <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;">个人说明： {{$user->personal_note}}</p>
  <div class="home_nav">
    <ul>
      <li><a  href="/member">个人中心</a></li>
      <li><a href="/member/finder">我的发现</a></li>
      <li><a href="/member/collect">我的收藏</a></li>
      <li class="current"><a href="/member/subscription">我的订阅</a></li>
      <li><a href="/member/follow">我的关注</a></li>
      <li><a href="/member/point">我的积分</a></li>
      <li><a href="/member/profile">个人资料</a></li>
    </ul>
  </div>
</div>
<section class="wrapper">
  <div class="mt30 home_box">
    <div class="title">
      <h2>我的订阅</h2>
    </div>
    
    <!----------设计师订阅------->
    
    <div class="public_list"> @foreach ($user->subscriptions as $subscription)
      <div class="public_item" data-id="{{$subscription->id}}">
        <div class="item_left"> <a href="@if($subscription->static_url) /designer/{{$subscription->static_url}} @else /designer/detail/{{$subscription->id}} @endif">
          <div class="tx"> <img src="{{get_designer_thum($subscription)}}" alt="{{get_designer_title($subscription)}}"> </div>
          </a>
          <div class="item_msg">
            <div class="title"> <a href="@if($subscription->static_url) /designer/{{$subscription->static_url}} @else /designer/detail/{{$subscription->id}} @endif"> {{get_designer_title($subscription)}} </a> </div>
            <div class="describe"> <span>国家：
              
              @foreach ($subscription->categorys as $category)
              
              @if($loop->last)
              
              {{$category['name']}}
              
              @else
              
              {{$category['name']}},
              
              @endif
              
              @endforeach </span> <span>{!! get_designer_description($subscription) !!}</span> </div>
            <div class="focus"> <a href="javascript:void(0)" data-id="{{$subscription->id}}" class="focus_btn2 click cancelSubscription"> 取消订阅 </a>
              <div class="focus_msg"> <span>作品：{{$subscription->article_num}}</span> | <span>粉丝：{{$subscription->fans_num}}</span> </div>
            </div>
          </div>
        </div>
        <div class="item_right"> @foreach($subscription->articles as $article)
          <div class="works" data-id="1722"> <a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif" target="_blank"> <img src="{{get_article_thum($article)}}" alt=""> <span>{{get_article_title($article)}}</span> </a> </div>
          @endforeach </div>
      </div>
      @endforeach </div>
    
    <!----------设计师订阅结束-------> 
    
  </div>
</section>
<script type="text/javascript">

    $(document).ready(function(){



      //取消订阅

      $(".cancelSubscription").click(function(e){



        var designer_id = $(this).attr('data-id');

        $.ajax({

          url: '/member/cancel_subscription',

          type: 'POST',

          dataType: 'json',

          data: {_token:'{{csrf_token()}}',designer_id:designer_id},

          success: function (data) {

            if (data.status_code == 0) {

              window.location.reload();

            } else {

              alert(data.message);



            }

          }

        });



      });

    });

  </script> 
@endsection