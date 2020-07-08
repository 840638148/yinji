@extends('layouts.app')
@section('title')
 {{trans('comm.yinji')}} - {{trans('index.home')}} - {{trans('index.discovery_detail')}}
@endsection
@section('content')

<style>
  .item .edit_favorites{
      position: absolute;
      display: inline-block;
      vertical-align: top;
      text-indent:0;
      text-align: center;
      line-height: 32px;
      z-index: 120;
      right:10px;
  }

  .edit_favorites:hover .item-setting-btns{
      color:#555;
  }

  .find_title{
      overflow:inherit;
      position:absolute;
      bottom: -2px;

  }

  .find_title h2{
    float: none;
    width: 210px;
    vertical-align: top;
    background: #fff;
    padding: 0 5px;
    border-radius: 36px;
    margin: 0 0 5px 7px;
    display: none;
    position: absolute;
    bottom: 2px;
    height: 35px;
    line-height: 35px;
    text-indent: 1em;
  }
  .find_title a{
  display: none;
  }
  .find_title .find-icon-trash{
  position: absolute;
    bottom: 8px;
    right: 10px;
  }

  .item_content:hover .find_title h2,.item_content:hover .find_title a,.item_content:hover .find_title .dot{
    display: block;
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
      
  .lzcfg{
      background: rgba(0,0,0,0.5);
      position: fixed;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      display: none;
      z-index: 99999999;
  }

  .swiper-container{
    display:none;
    position:absolute;
    z-index:9999999999;
    top:31%;
  }

  .dot {
    position: absolute;
    bottom: 10px;
    right: 10px;
    font-size: 22px; 
    letter-spacing: 4px;
    color:#fff;
    display:none;
  }
  .move_del{
    width: 100px;
    height: 65px;
    background: rgba(0,0,0,0.5);
    text-align: center;
    color:#fff;
    position: relative;
    left: 279px;
    top: 11px;
    z-index: 999;
    display:none;
  }
  .move_del p{
    padding-top:6px;
  }
  .move_del p:hover{
    background:#ccc3c342;
  }
  .move_del .left_sjx{
    width: 0;
    height: 0;
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    border-right: 10px solid rgba(0,0,0,0.5);
    position: absolute;
    left: -10px;
    top: 23px;
  }
  .fxj{
    width: 500px;
    /* height: 300px; */
    background: #f2f2f2;
    position: fixed;
    z-index: 999;
    border:1px solid #f2f2f2;
    display:none;
    top: 28%;
    left: 37%;
    border-radius: 5px;
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
  body{background:#f8f8f8 !important;}
  .home_box{border-radius:10px !important;}
  .home_top{background:#fff !important;}
  
  /* ------------------------------------------------------------------- */
  
  .box { 
      -moz-column-count:4; /* Firefox */
      -webkit-column-count:4; /* Safari 和 Chrome */
      column-count:4;
      -moz-column-gap: 2em;
      -webkit-column-gap: 2em;
      column-gap: 2em;
      width: 100%;
      margin:2em auto;
  }
  .itemww { 
      margin-bottom: 2em;
      -moz-page-break-inside: avoid;
      -webkit-column-break-inside: avoid;
      break-inside: avoid;
      position: relative;
  }
  .titlename{
    position: absolute;
    background:rgba(250,250,250,.8);
    width: 65%;
    bottom: 0;
    color: #000;
    height: 33px;
    line-height: 35px;
    border-radius: 35px;
    margin:0 0 5px 10px;
    text-indent: 1em;
    display: none;
    cursor:pointer;
  }
  
  .scbtm{
    background: #e1244e;
      width: 50px;
      height: 35px;
      line-height: 35px;
      text-align: center;
      color: #fff;
      display: inline-block;
      border-radius: 30px;
      position: absolute;
      bottom: 5px;
      right: 18px;
      display: none;
      cursor:pointer;
  }
  .scbtmlbt{
    background: #e1244e;
      width: 50px;
      height: 35px;
      line-height: 35px;
      text-align: center;
      color: #fff;
      display: inline-block;
      border-radius: 4px;
      position: absolute;
    z-index:999999999;
      top: 5px;
      left: 5px;
    display:none;
      cursor:pointer;
  }
  .swiper-slide{
  	  display: flex;
  	  justify-content: center;
  	  align-items: center;
  	  height: 90%;
  }
  .swiper-slide img{
  	  display: inline-block;
  	  margin: auto;
  	  max-height: 64rem;
  }
  .swiper-slide:hover .scbtmlbt{
    display:block;
  }
  .showscbtn{
    position: fixed;
      left: 50%;
      top: 20%;
      width: 620px;
      margin-left: -330px;
      height: 450px;
      background: #fff;
      z-index: 19999999;
      padding: 20px;
      border-radius: 5px;
      display: none;
  }
  .showscbtnlbt{
    position: fixed;
      left: 50%;
      top: 20%;
      width: 620px;
      margin-left: -330px;
      height: 450px;
      background: #fff;
      z-index: 19999999;
      padding: 20px;
      border-radius: 5px;
      display: none;
  }
  
  .lzcfg{
      background: rgba(0,0,0,0.5);
      position: fixed;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      display: none;
      z-index: 99999999;
  }
  
  .swiper-container{
    display:none;
      top:10%;
    position:fixed;
    z-index:9999999999;
  	width: 100%;
  	height: 100%;
  }
  
  .itemww:hover .titlename,.itemww:hover .scbtm{
    display: block;
  }
  @media  screen and (max-width: 800px) { 
      .box { 
          column-count: 2; // two columns on larger phones 
      } 
  } 
  @media  screen and (max-width: 500px) { 
      .box { 
          column-count: 1; // two columns on larger phones 
      } 
  }
</style>
<div class="lzcfg"></div>
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
	      <li class="current"><a href="/member/finder">{{trans('index.my_finder')}}</a></li>
	      <li><a href="/member/collect">{{trans('index.my_collection')}}</a></li>
	      <li><a href="/member/subscription">{{trans('index.my_subscription')}}</a></li>
	      <li><a href="/member/follow">{{trans('index.my_interactive')}}</a></li>
	      <li><a href="/member/mydown">{{trans('index.my_download')}}</a></li>
	      <li><a href="/member/profile">{{trans('index.the_personal_data')}}</a></li>
    </ul>
  </div>
</div>


<!--点击上面的图片显示轮播图片-->
<div class="swiper-container swiper-home">
	<div style="padding:5px;color:#fff;font-size:65px;position:fixed;z-index:999999999999;top:120px;right:20px;cursor: pointer;" class="closeltb"> × </div>
	<div class="swiper-wrapper"> 
    @foreach ($folist as  $i =>$v)
    
    <article class="swiper-slide slide-single" data-swiper-slide-index="{{$loop->iteration}}"> 
		<div class="wrap" style="position: relative;">
			<img id="btntp" width="600px" height="600px" src="{{$v['photo_url']}}" data-id="{{$v['photo_source']}}" alt="{{$v['name']}}">
		</div>
    </article>

		@endforeach 
    </div>
      <!-- 按钮 -->
      <div style="top:36%" class="swiper-home-button-next swiper-button-next"></div>
      <div style="top:36%"  class="swiper-home-button-prev swiper-button-prev"></div>
</div>



<section class="wrapper ">
  <div class="mt30 home_box ">
    <div class="title">
      <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'>{{$folder_name or ''}}</span></h2>
      <span class="fr"><a href="javascript:window.history.go(-1);" data-type="collect" >&lt; {{trans('index.back')}}</a></span> </div>
    <div class="masonry">

      @foreach ($user->finder_details as $detail)
      <div class="item discovery-item " style="display:flex">
        <div class="item_content item_content2">
        		<li> <img src="{{$detail['photo_url']}}" data-id="{{$detail['user_finder_folder_id']}}" source='{{$detail["photo_source"]}}' alt="{{mb_substr($detail['titlename'],0,30)}}"> </li>
          <div class="find_title">
            <h2><a href="/article/{{$detail['static_url']}}" target="_blank">{{mb_substr($detail['titlename'],0,20)}}</a></h2>
            <span class='dot'>•••</span>
            <div class='move_del'>
              <div class='left_sjx'></div>
              <p><a style="padding-top: 1.5px;color:#fff;" source='{{$detail["photo_source"]}}' photo_src="{{$detail['photo_url']}}" href="javascript:;" class="yd_find_img" data-id="{{$detail['id']}}" tag="移动发现的图片到其他文件夹">移动</a></p>
              <p><a style="padding-top: 1.5px;color:#fff;" href="javascript:;" class="remove_find_img" data-id="{{$detail['id']}}" tag="删除发现的图片">删除</a></p>
            </div>
            <div class='fxj' source='' photo_src=''>
              <span class='closefxj' style='padding:5px;font-size: 22px;float: right;cursor: pointer;'>X</span>
              @foreach($folderall as $v)
              <p><span class='fxj_left'>{{$v->name}}</span><span data-id='{{$v->id}}' class='fxj_right'>移动</span></p>
              @endforeach
            </div>            
          </div>

        </div>

      </div>



      @endforeach 

    </div>

  </div>

</section>

<script type="text/javascript">
  $('.closefxj').click(function(){
    $('.fxj').hide(500);
  })

  $(document).on('click','.yd_find_img',function(){
    $('.fxj').show(500);
    let sou=$(this).attr('source');
    $('.fxj').attr('source',sou)
    let src=$(this).attr('photo_src');
    $('.fxj').attr('photo_src',src)
  })

  function getQueryString(name) {   
    let reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)"); //构造一个含有目标参数的正则表达式对象  
    let r = window.location.search.substr(1).match(reg);  //匹配目标参数
    if( r != null ) return decodeURI( r[2] ); return null;   
  }
  
  //点击移动图片到另外一个收藏夹
  $(document).on('click','.fxj_right',function(){
    let source = $(this).parents('.fxj').attr('source');
    let finder_id = $(this).attr('data-id');
    let photo_src=$(this).parents('.fxj').attr('photo_src');
    let url = window.location.pathname;
    let now_url=url.split('/')[3];
    let now_folder_id=0;
    let folder_data = {
        _token:_token,
        finder_id:finder_id,
        source:source,
        photo_src:photo_src,
        now_url:now_url,
    };
    console.log(finder_id,source,photo_src)
    $.ajax({
        async:false,
        url: '/member/movefxj',
        type: 'POST',
        dataType: 'json',
        data: folder_data,
        success: function (data) {
            if (data.status_code == 0) {
                layer.msg('移动成功！',{time: 1500,skin: 'intro-login-class layui-layer-hui'});
                window.location.reload();
            } else {
              layer.msg(data.message,{time: 1500,skin: 'intro-login-class layui-layer-hui'});
            }
        }
    });
  });

 var hoverTimer = ''
  $('.find_title>.dot').hover(function(){
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
  	$('.find_title>.dot').siblings(".move_del").css('display','none');
  });
  
  function start(){
  	let len = $(".swiper-slide").length
  	$(".swiper-slide").eq(i).show().siblings().stop(true, true).hide();
  
  }
  function change(){
      $(".swiper-slide").eq(i).show().siblings().stop(true, true).hide();
  }

	//--点击上面的图片显示轮播图片--
	$(document).on('click','.item_content2>li',function(){
		var index = $(this).index()
		console.log(index)
		i = index
		$('.lzcfg').css('display','block');
		$('.swiper-container').css('display','block');
		start() 
  })
  
	//点击关闭轮播图
    $(document).on('click','.closeltb',function(){
      $('.swiper-container').css('display','none');
      $('.showscbtnlbt').css('display','none');
      $('.lzcfg').css('display','none');
      // clearInterval(timer);
    })


 
  $(document).on('click','.swiper-button-next',function(){
  		let len = $(".swiper-slide").length
  		i++;
  		if(i >= len){
  			i = 0;
  		}
  		change();
  })
  $(document).on('mousemove','.swiper-button-next',function(){
  		// clearInterval(timer);
  })
  $(document).on('mouseout','.swiper-button-next',function(){
  		start()
  })
  
  $(document).on('click','.swiper-button-prev',function(){
  		let len = $(".swiper-slide").length
  		i--;
  		if(i <= 0){
  		    i = len-1;
  		}
  		change();
  })
  $(document).on('mousemove','.swiper-button-prev',function(){
  		// clearInterval(timer);
  })
  $(document).on('mouseout','.swiper-button-prev',function(){
  		start()
  })


  function selectItem(index){
      $('.dingyue-item .select-item').hide()
      $($('.dingyue-item')[index]).find('.select-item').show()
      localStorage.setItem("selectdD", index);
  }


  function selectItemGuanZhu(index){
      $('.guanzhu-item .select-item').hide()
      $($('.guanzhu-item')[index]).find('.select-item').show()
      localStorage.setItem("selectdG", index);
  }

  $(document).ready(function(){
      if(IS_VIP){
          $('.order_center .order2').find('a').html('会员中心')
          $('.order_center .order2').find('a').attr('href','/member/interest')
      }

      $('.dingyue-item .select-item').hide()
      var dIndex = localStorage.getItem('selectdD')
      $($('.dingyue-item')[dIndex]).find('.select-item').show()

      $('.guanzhu-item .select-item').hide()
      var gIndex = localStorage.getItem('selectdG')
      $($('.guanzhu-item')[gIndex]).find('.select-item').show()

      //最多显示8条数据
      for(var i=0;i<$('.my-collection .collection-item').length;i++){
          if(i>7){
              $($('.my-collection .collection-item')[i]).hide()
          }
      }

      for(var i=0;i<$('.my-finder .collection-item').length;i++){
          if(i>7){
              $($('.my-finder .collection-item')[i]).hide()
          }
      }

  });


</script>


<!--个人发现中心的图片浏览-->

<div class="img_browse modal" id="img-browse" >

    <div class="close">关闭</div>

    <div class="left">

        <div style="height:48px;">

            <h2 class="fl">文件夹名称333</h2>

            <span class="fr">分享到：</div>

        <div class="image"><img src="/images/ad_05.gif" alt="发现的图片" class="selected-image"/> </div>

    </div>

    <div class="right" style="margin-top:48px;">

        <div class="more_img">

            <a href="#" class="more-img-item selected"><img src="images/imges.jpg" alt="图片一" /> <div class="cover"></div></a>



            <a href="#" class="more-img-item"><img src="images/ad_05.gif" alt="图片一" /><div class="cover"></div></a>

            <a href="#" class="more-img-item"><img src="images/design_16-03.gif" alt="图片二" /><div class="cover"></div></a>

            <a href="#" class="more-img-item"><img src="images/about_img.jpg" alt="图片一" /><div class="cover"></div></a>

            <a href="#" class="more-img-item"><img src="images/ad_22.gif" alt="图片二" /><div class="cover"></div></a>

            <a href="#" class="more-img-item"><img src="images/ad_05.gif" alt="图片一" /><div class="cover"></div></a>

            <a href="#" class="more-img-item"><img src="images/design_16-03.gif" alt="图片二" /><div class="cover"></div></a>

            <a href="#" class="more-img-item"><img src="images/about_img.jpg" alt="图片一" /><div class="cover"></div></a>

            <a href="#" class="more-img-item"><img src="images/ad_22.gif" alt="图片二" /><div class="cover"></div></a>

            <a href="#" class="more-img-item"><img src="images/ad_05.gif" alt="图片一" /><div class="cover"></div></a>

            <a href="#" class="more-img-item"><img src="images/design_16-03.gif" alt="图片二" /><div class="cover"></div></a> </div>

        <hr />

        <div class="discoverer">

            <div class="head"><img width="100%" height="100%" src="images/design_16-03.gif" alt="头像" /></div>

            <h2><a href="#">大仁哥1027</a> <span class="vip1">VIP</span></h2>

            <a class="Button">关注</a>

        </div>

        <hr />

        <div class="faxian_info">

            <p>由 <a href="#">严PPPPPPPP1</a> 收藏于 <a href="#">大厅</a></p>

            <p>2017-06-02 14:59:57</p>

            <p class="laiyuan"><a href="#">来源：Lera Brumina作品 | 80㎡ Apartmen...</a></p>

        </div>

    </div>

</div>
<!--个人发现中心的浏览结束-->

<script src="/js/layer.js"></script> 

<script src="/js/member.js"></script> 

@endsection