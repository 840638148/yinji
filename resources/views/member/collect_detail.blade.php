@extends('layouts.app')

@section('title')
  {{trans('comm.yinji')}} - {{trans('index.home')}} - {{trans('index.collection_detail')}}
@endsection
   
@section('content')
<style>
  body{background:#f8f8f8 !important;}
  .home_box{border-radius:10px !important;}
  .home_top{background:#fff !important;}
  .dot{
    position:absolute;
    bottom:62px;
    right:30px;
    font-size:15px;
    letter-spacing:4px;
    color:#fff;
    cursor:pointer;
    background: #7d83f7;
    border-radius: 50%;
    height: 32px;
    line-height: 33px;
    padding-left: 3px;
  }

  .move_del{
    width: 100px;
    height: 48px;
    background: rgba(0,0,0,0.5);
    text-align: center;
    color: #fff;
    position: absolute;
    right: 71px;
    bottom: 50px;
    z-index: 999;
    display:none;
  }
  .move_del p:hover{
    background:#ccc3c342;
    cursor:pointer;
  }
  .move_del .left_sjx{
    width: 0;
    height: 0;
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    border-left: 10px solid rgba(0,0,0,0.5);
    position: absolute;
    right: -10px;
    bottom: 16px;
  }
  .fxj{
    width: 373px;
    height: auto;
    background: #f3f2f2;
    border-radius: 5px;
    position: absolute;
    top: 67%;
    left: 40%;
    z-index: 999;
    display:none;
  }
  .fxj p{
    height:50px;
    padding:5px 0;
  }
  .fxj p:nth-of-type(1){
    margin-top:30px;
  }

  .fxj .fxj_left{
    line-height:40px;
  }
  .fxj .fxj_right{
    padding:5px 10px 5px;
    background: #4a8bdc;
    color: #FFF;
    border-radius: 5px;
    float:right;
    cursor: pointer;
  }
</style>

<div class="home_top">
  <div class="home_banber"> <img src="/images/home_bj.jpg" alt="个人主页图片" /></div>
  <div class="home_tongji">
    <ul>
      <li>{{trans('index.discovery')}}</br>{{$user->finder_num}} </li>
      <li>{{trans('index.collection')}}</br>{{$user->collect_num}} </li>
      <li>{{trans('index.subscription')}}</br>{{$user->subscription_num}} </li>
      <li>{{trans('index.follow')}}</br>{{$user->follow_num}} </li>
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
      <span class="fr"><a href="javascript:window.history.go(-1);" data-type="collect" >&lt; {{trans('index.back')}}</a></span> 
    </div>

    <ul class="layout_ul ajaxposts">
      <div class="post_list">
        <ul>
          @foreach ($user->collect_details as $articles)
            @foreach ($articles as $article)
              @if(get_class($article)=='App\Models\Article')
              <li class="layout_li ajaxpost">
                <article class="postgrid">
                  <span class="guojia2" >
                    <a style="position:absolute;bottom:60px;right:71px;z-index:9;" href="#" rel="tag">{{$article->location_cn}}</a>
                  </span>
                  <figure> 
                    <a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif" title="{{get_article_title($article)}}" target="_blank"> <img class="thumb" src="{{get_article_thum($article)}}" data-original="{{get_article_thum($article)}}" alt="{{get_article_title($article)}}" style="display: block;"> </a> 
                  </figure>
                  <h2> 
                    <a href="@if($article->static_url) /article/{{$article->static_url}} @else /article/detail/{{$article->id}} @endif" title="{{get_article_title($article)}}" target="_blank">
                    <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;">{{get_article_title($article, 1)}}</div>
                    <div style=" color:#666; line-height:24px;">{{get_article_title($article, 2)}}</div>
                    </a> 
                  </h2>

                    <!-- 移动start -->
                    <span class='dot'>•••</span>
                    <div class='move_del'>
                      <div class='left_sjx'></div>
                      <p style="padding-top: 1.5px;color:#fff;" source='{{$article->id}}' href="javascript:;" class="yd_collect_img" data-id="" tag="移动发现的图片到其他文件夹">移动</p>
                      <p style="padding-top: 1.5px;color:#fff;" href="javascript:;" class="remove_collect_img" data-id="{{$article->delid}}" tag="删除发现的图片">删除</p>
                    </div>
      
                    <!-- 移动end -->

                    <!-- <a style="position: absolute;bottom: 60px;right: 30px;" href="javascript:;" class="find-icon-trash remove_find_img" data-id="{{$article->delid}}" tag="删除发现的图片"></a>  -->


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
              @else
              <li class="layout_li ajaxpost">
                <article class="postgrid">
                  <span class="guojia2" >
                    <a style="position:absolute;bottom:60px;right:71px;z-index:9;" href="#" rel="tag">{{$article->area}}</a>
                  </span>
                  <figure> 
                    <a href="/details/{{$article->id}}" title="{{get_dc_title($article)}}" target="_blank"> <img class="thumb" src="{{get_dc_thum($article)}}" data-original="{{get_dc_thum($article)}}" alt="{{get_dc_title($article)}}" style="display: block;"> </a> 
                  </figure>
                  <h2> 
                    <a href="/details/{{$article->id}}" title="{{get_dc_title($article)}}" target="_blank">
                    <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;">{{get_dc_title($article, 1)}}</div>
                    <div style=" color:#666; line-height:24px;">{{get_dc_title($article, 2)}}</div>
                    </a> 
                  </h2>

                    <!-- 移动start -->
                    <span class='dot'>•••</span>
                    <div class='move_del'>
                      <div class='left_sjx'></div>
                      <p style="padding-top: 1.5px;color:#fff;" source='{{$article->id}}' href="javascript:;" class="yd_collect_img" data-id="" tag="移动发现的图片到其他文件夹">移动</p>
                      <p style="padding-top: 1.5px;color:#fff;" href="javascript:;" class="remove_collect_img" data-id="{{$article->delid}}" tag="删除发现的图片">删除</p>
                    </div>
      
                    <!-- 移动end -->

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
              @endif 
            @endforeach
          @endforeach
        </ul>
        <!-- 分页 --> 

        <div class='fxj' source=''>
          <span class='closefxj' style='padding:5px;font-size: 22px;float: right;cursor: pointer;'>X</span>
          @foreach($collectlist as $v)
          <p><span class='fxj_left'>{{$v->name}}</span><span data-id='{{$v->id}}' class='fxj_right'>移动</span></p>
          @endforeach
        </div>
      </div>
    </ul>
  </div>
</section>

<script>

  var hoverTimer = ''
  $('.postgrid>.dot').hover(function(){
    $(this).siblings(".move_del").css('display','block');
  },function(){
    let _this = $(this)
    hoverTimer = setTimeout(function(){
    _this.siblings(".move_del").css('display','none');
    },100)
  });

  $('.move_del').hover(function(){
    clearTimeout(hoverTimer)
  },function(){
    $('.postgrid>.dot').siblings(".move_del").css('display','none');
  });

  //删除收藏文章
  $(document).on('click','.remove_collect_img',function(ev){
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

  //移动收藏文章
  $(document).on('click','.fxj_right',function(){
    let source = $(this).parents('.fxj').attr('source');
    let user_collect_folder_id = $(this).attr('data-id');

    let folder_data = {
        _token:_token,
        user_collect_folder_id:user_collect_folder_id,
        source:source,
    };
    // console.log(user_collect_folder_id,source)
    $.ajax({
        async:false,
        url: '/member/movecollect',
        type: 'POST',
        dataType: 'json',
        data: folder_data,
        success: function (data) {
            if (data.status_code == 0) {
                layer.msg(data.message,{time: 1500,skin: 'intro-login-class layui-layer-hui'});
                window.location.reload();
            } else {
              layer.msg(data.message,{time: 1500,skin: 'intro-login-class layui-layer-hui'});
            }
        }
    });
  });

  //关闭收藏夹框
  $('.closefxj').click(function(){
    $('.fxj').hide();
  })
  //点击显示收藏夹框
  $(document).on('click','.yd_collect_img',function(){
    $('.fxj').css('display','block');
    let sou=$(this).attr('source');
    $('.fxj').attr('source',sou)
  })
</script>
@endsection