@extends('layouts.app')

@section('title')
  {{trans('comm.yinji')}} - {{trans('index.home')}} - {{trans('index.collection_detail')}}
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
      <li> {{trans('index.focus_on')}}</br>
        {{$user->follow_num}} </li>
    </ul>
  </div>
  <div class="home_personal"> <img src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$user->nickname}}" /></div>
  <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> {{$user->nickname}} <img src="{{$user->vip_level}}" alt=""></h2>
      <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;">{{trans('index.personal_description')}}： {{$user->personal_note}}</p>
  
  
  <div class="home_nav">
    <ul>
        <li><a  href="/member">{{trans('index.home')}}</a></li>
	      <li><a href="/member/finder">{{trans('index.my_finder')}}</a></li>
	      <li class="current"><a href="/member/collect">{{trans('index.my_collection')}}</a></li>
	      <li><a href="/member/subscription">{{trans('index.my_subscription')}}</a></li>
	      <li><a href="/member/follow">{{trans('index.my_interactive')}}</a></li>
	      <li><a href="/member/mydown">{{trans('index.my_download')}}</a></li>
	      <li><a href="/member/profile">{{trans('index.the_personal_data')}}</a></li>
    </ul>
  </div>
</div>
<section class="wrapper">
  <div class="mt30 home_box">
    <div class="title">
      <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'>{{$folder_name or ''}}</span></h2>
      
      <span class="fr"><a href="javascript:window.history.go(-1);" data-type="collect" >&lt; {{trans('index.back')}}</a></span> </div>
    <ul class="layout_ul ajaxposts">
      <div class="post_list">
        <ul>
          @foreach ($user->collect_details as $article)
          <li class="layout_li ajaxpost">
            <article class="postgrid">
            <span class="guojia2" >
              <a style="position:absolute;bottom:60px;right:71px;z-index:9;" href="#" rel="tag">{{$article->location_cn}}</a>
            </span>
              <figure> <a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif" title="{{get_article_title($article)}}" target="_blank"> <img class="thumb" src="{{get_article_thum($article)}}" data-original="{{get_article_thum($article)}}" alt="{{get_article_title($article)}}" style="display: block;"> </a> </figure>
              <h2> <a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif" title="{{get_article_title($article)}}" target="_blank">
                <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;">{{get_article_title($article, 1)}}</div>
                <div style=" color:#666; line-height:24px;">{{get_article_title($article, 2)}}</div>
                </a> </h2>
                <a style="position: absolute;bottom: 60px;right: 30px;" href="javascript:;" class="find-icon-trash remove_find_img" data-id="{{$article->delid}}" tag="删除发现的图片"></a> 
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
    // if (!confirm("确定删除？")) {
    //     return false;
    // }

    var finder_id = $(this).attr('data-id');
    var url = '/member/delete_folder_item';
    var folder_data = {
        _token:_token,
        finder_id:finder_id,
    };

    
    layer.open({
        title: ['温馨提示'],
        content: '确定删除？',
        btn: ['确定','取消'],
        shadeClose: true,
        //回调函数
        yes: function(index){
            // self.location='/vip/intro';//确定按钮跳转地址

        $.ajax({
            async:false,
            url: url,
            type: 'POST',
            dataType: 'json',
            data: folder_data,
            success: function (data) {
                if (data.status_code == 0) {
                    layer.msg('删除成功！',{time: 1500,skin: 'intro-login-class layui-layer-hui'});
                    // alert('删除成功！');
                    window.location.reload();
                } else { 
                    alert(data.message);
                }
            }
        });
      }
    })
    return false;
});




</script> 
@endsection