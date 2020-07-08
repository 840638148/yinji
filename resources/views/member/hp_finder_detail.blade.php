@extends('layouts.app')
@section('title')
 {{trans('comm.yinji')}} - TA {{trans('index.discovery_detail')}}
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
        width: 73%;
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
        width: 35px;
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
        width: 35px;
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
    @media  screen and (max-width: 800px){ 
        .box{ 
            column-count: 2; // two columns on larger phones 
        } 
    } 
    @media  screen and (max-width: 500px){ 
        .box{ 
            column-count: 1; // two columns on larger phones 
        } 
    }
</style>
<div class="lzcfg"></div>
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
        <li class="current"><a href="/member/homepage_finder/{{$users->id}}">{{trans('index.discovery')}}</a></li>
        <li><a href="/member/homepage_collect/{{$users->id}}">{{trans('index.collection')}}</a></li>
        <li><a href="/member/homepage_subscription/{{$users->id}}">{{trans('index.subscription')}}</a></li>
        <li><a href="/member/homepage_interactive/{{$users->id}}">{{trans('index.follow')}}</a></li>
        <li><a href="/member/homepage_fans/{{$users->id}}">{{trans('index.fans')}}</a></li>
    </ul>
  </div>
</div>


<!--轮播图-->
<div class="swiper-container swiper-home">
  <div style="padding:5px;color:#fff;font-size:65px;position:fixed;z-index:999999999999;top:120px;right:20px;cursor: pointer;" class="closeltb"> × </div>
  <div class="swiper-wrapper"> 
    @foreach ($folist as  $i =>$v)
    <article class="swiper-slide slide-single" data-swiper-slide-index="{{$loop->iteration}}">
    	<div class="wrap" style="position: relative">
    		<a href="/article/{{$v['static_url']}}" target='_blank'><img id="btntp" width="600px" height="600px" src="{{$v['photo_url']}}" data-id="{{$v['photo_source']}}" alt="{{$v['name']}}"></a>
    		<div class="scbtmlbt" data-id="{{$v['photo_source']}}" data-pid-i="{{ $i }}" onclick="getID(this)" ><img style='width:20px;height:20px;margin-top:8px;' src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACUAAAAlCAQAAABvl+iIAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JQAAgIMAAPn/AACA6QAAdTAAAOpgAAA6mAAAF2+SX8VGAAAAAmJLR0QA/4ePzL8AAAAJcEhZcwAADsQAAA7EAZUrDhsAAAAHdElNRQfiDA0XHTkZwnQUAAAAVUlEQVRIx2P8z0AtwEQ1k0aNGjWKJkaxYIhgS/6MWMUZh6YHsToeTRxrGTA4PTg4jcIV7KgBy0jYoAFNDPRx1bA3ivTEgLMOHpweZBxtM4waNbiNAgDn9QhSF9pevwAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAxOC0xMi0xM1QyMzoyOTo1NyswODowMMypGaQAAAAldEVYdGRhdGU6bW9kaWZ5ADIwMTgtMTItMTNUMjM6Mjk6NTcrMDg6MDC99KEYAAAAAElFTkSuQmCC" alt=""></div>
    	</div>
    </article>
    @endforeach 
  </div>
  <!-- 按钮 -->
  <div class="swiper-home-button-next swiper-button-next"></div>
  <div class="swiper-home-button-prev swiper-button-prev"></div>
</div>
<!--轮播图结束-->



<section class="wrapper" style='width:1245px;'>
    <div class="mt30 home_box">
        <div class="title">
            <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'>{{$folder_name or ''}}</span></h2>
            <span class="fr"><a href="javascript:window.history.go(-1);" data-type="collect" >&lt; {{trans('index.back')}}</a></span> 
        </div> 
    <!-- 内容开始 -->
        <div class="box"> 
            @foreach ($users->finder_details as $i =>$v)
                <div class="itemww"> 
                    <img src="{{$v['photo_url']}}" data-id="{{$v['user_finder_folder_id']}}" source='{{$v["photo_source"]}}' data-photo-index="{{ $i }}" alt="{{mb_substr($v['titlename'],0,30)}}">
                    <div class="titlename" onclick="location='@if($v['static_url']) /article/{{$v['static_url']}} @else /article/detail/{{$v['id']}} @endif'">
                    @if(strlen($v['titlename']) < 20) {{$v['titlename']}} @else {{mb_substr($v['titlename'],0,20)}} @endif</div>
                    <div class="scbtm" photoid="{{$v['photo_source']}}" imgsrc="{{$v['photo_url']}}" data-id="{{$v['photo_source']}}" data-pid-i="{{ $i }}" onclick="getID(this)"><img style='width:20px;height:20px;margin-top:7px;' src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACUAAAAlCAQAAABvl+iIAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JQAAgIMAAPn/AACA6QAAdTAAAOpgAAA6mAAAF2+SX8VGAAAAAmJLR0QA/4ePzL8AAAAJcEhZcwAADsQAAA7EAZUrDhsAAAAHdElNRQfiDA0XHTkZwnQUAAAAVUlEQVRIx2P8z0AtwEQ1k0aNGjWKJkaxYIhgS/6MWMUZh6YHsToeTRxrGTA4PTg4jcIV7KgBy0jYoAFNDPRx1bA3ivTEgLMOHpweZBxtM4waNbiNAgDn9QhSF9pevwAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAxOC0xMi0xM1QyMzoyOTo1NyswODowMMypGaQAAAAldEVYdGRhdGU6bW9kaWZ5ADIwMTgtMTItMTNUMjM6Mjk6NTcrMDg6MDC99KEYAAAAAElFTkSuQmCC" alt=""></div>
                </div>
            @endforeach 
        </div>
    <!-- 内容结束 -->

        <!--点击收藏出现弹窗-->
        <div class="showscbtn">
            <div class="create_folder_title">
                <h2>图片收藏到</h2>
            </div>
            <div class="close">关闭</div>
            <div class="pic-name" style="padding: 8px 0 8px 8px;">
                <label for="" style="font-size: 14px;color: #333;margin-left:-10px;"> 图片名称 </label>
                <input type="text" name="imgtitle" id="imgtitle" value="" placeholder="图片名称" style="width: 512px;">
            </div>
            <div class="collection_to">
                <ul class="discover-folders2">
                @foreach($userscname as $key => $value)
                <li>
                    <h3>{{$value['name']}}</h3>
                    <span  floder_id='{{$value["id"]}}'  class='folderattr null' title='{{$value["name"]}}'></span> 
                    <div id="modal_btns"> <a href='javascript:void(0);' class='Button2 to_find_floder_act asd' scid='{{$value["id"]}}'  data-img='' >收藏</a> </div>
                </li>
                @endforeach
                </ul>
            </div>
            <a href="javascript:void(0);" class="create create-new-folder-btn">创建收藏夹</a>
            <div class="error_code"></div>
        </div>

        <!--点击轮播图收藏出现弹窗-->
        <div class="showscbtnlbt">
            <div class="create_folder_title">
                <h2>图片收藏到</h2>
            </div>
            <div class="close closelbtbtn">关闭</div>
            <div class="pic-name" style="padding: 8px 0 8px 8px;">
                <label for="" style="font-size: 14px;color: #333;margin-left:-10px;"> 图片名称 </label>
                <input type="text" name="imgtitle" id="imgtitle" value="" placeholder="图片名称" style="width: 512px;">
            </div>
            <div class="collection_to">
                <ul class="discover-folders2">
                @foreach($userscname as $key => $value)
                <li>
                    <h3>{{$value['name']}}</h3>
                    <span img='' floder_id='{{$value["id"]}}'  class='folderattr null' title='{{$value["name"]}}'></span> 
                    <div id="modal_btns"> <a href='javascript:void(0);' class='Button2 to_find_floder_act asd' scid='{{$value["id"]}}'  data-img='' >收藏</a> </div>
                </li>
                @endforeach
                </ul>
            </div>
            <a href="javascript:void(0);" class="create create-new-folder-btn">创建收藏夹</a>
            <div class="error_code"></div>
        </div>

        <!--创建收藏文件夹-->
        <div class="create_folder modal" id="new-find-model-folder" style="height:450px">
            <div class="create_folder_title">
                <h2>创建收藏文件夹</h2>
            </div>
            <div class="close">关闭</div>
            <input type="text" value=""  placeholder="收藏夹名称（必填）" class="mt30" name="favorite" id="finder_folder_name"/>
            <textarea id="finder_folder_brief" name="memo" placeholder="简介"  rows="5" class="mt30 folder_introduction"></textarea>
            <input type="hidden" id="finder_folder_id" value="1" />
            <p class="mt30"> <i class="sourceinput" sourceid=""></i>
                <input name="is_open" type="radio" value="1" checked="checked" />
                公开
                <input name="is_open" type="radio" value="0" />
                不公开 </p>
            <div class="error_msg" id="error_msg"></div>
            <div class="create_button">
                <input type="hidden" name="folder_type" id="add_folder_type"  />
                <input type="button" value="取消" class="button_gray concle-create-folder" />
                <input type="button" value="确定" class="button_red create_finder_folder_enter_btn"/>
            </div>
        </div>
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



  $('.titlename').click(function(ev){
    ev.stopPropagation(); //  阻止事件冒泡
  })

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

<!-- 轮播图和收藏的 -->
<script type="text/javascript">
    function getID(obj){
        collect_id = $(obj).attr('data-id');
    }

    $(document).ready(function(){
        let idx = 1
        let bannerSwiper = ''
        let i = 0;
        let timer;

        //判断是否为vip
        if(IS_VIP){
            $('.order_center .order2').find('a').html('会员中心')
            $('.order_center .order2').find('a').attr('href','/member/interest')
        }
        function start(){
            let len = $(".swiper-slide").length
            $(".swiper-slide").eq(i).show().siblings().stop(true, true).hide();
        }
        function change(){
            $(".swiper-slide").eq(i).show().siblings().stop(true, true).hide();
        }

        //--点击上面的图片显示轮播图片--
        $(document).on('click','.itemww',function(){
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
            clearInterval(timer);
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
            clearInterval(timer);
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
            clearInterval(timer);
        })
        $(document).on('mouseout','.swiper-button-prev',function(){
            start()
        })



        //点击图片上的收藏按钮出现弹窗	
        $(document).on('click','.scbtm',function(ev){
            ev.stopPropagation(); //  阻止事件冒泡
            if (!IS_LOGIN) {
            $('.login_box').show();
            } else {
            let photo_id_i = $(this).data('pid-i');
            let user_finder_folder_id = $('.to_find_floder_act ').attr('scid');//发现的收藏夹id
            let folder_ids = [];
            let source = $(this).attr('photoid');//图片所在的文章id
            let is_sc=1;
            let photo_url=$('.boximg').attr('src');//图片src
            // console.log(user_finder_folder_id)
            // photo_url=photo_url.substr(20)
            $(".asd").each(function () {
                folder_ids.push($(this).attr("scid"));
            });
            $(".asd").data("pid-i", photo_id_i);//这个啥意思，自定义属性？相当于attr('data-pid-i', photo_id_i),,好吧
            
            tpid=$('.scbtm').attr('data-id');
            $('.lzcfg').css('display','block');
            $('.showscbtn').css('display','block');
            $('.showscbtn').css('z-index','999999999999');
            }
        })

        //点击轮播图片上的收藏按钮出现弹窗	
        $(document).on('click','.scbtmlbt',function(ev){
            if(!IS_LOGIN){
                $('.login_box').show();
            }else{
                let photo_id_i = $(this).data('pid-i');
                let user_finder_folder_id = $('.to_find_floder_act ').attr('scid');//发现的收藏夹id
                let folder_ids = [];
                let source = $(this).attr('photoid');//图片所在的文章id
                let photo_url=$('#btntp').attr('src');//图片src
                // photo_url=photo_url.substr(20)
                let is_sc=1;
                $(".asd").each(function () {
                    folder_ids.push($(this).attr("scid"));
                });
                $(".asd").data("pid-i", photo_id_i);//这个啥意思，自定义属性？相当于attr('data-pid-i', photo_id_i),,好吧
                
                tpid=$('.scbtmlbt').attr('data-id');
                $('.lzcfg').css('display','block');
                $('.showscbtnlbt').css('display','block');
                $('.showscbtnlbt').css('z-index','999999999999');
                
                // 轮播图鼠标移入停止自动滚动
                $('.showscbtnlbt').mouseenter(function() {
                    // bannerSwiper.stopAutoplay();
                    clearInterval(timer);
                })
                // l轮播图鼠标移出开始自动滚动
                $('.showscbtnlbt').mouseleave(function() {
                    // bannerSwiper.startAutoplay();
                    start()
                })

                }
            })

        // 鼠标移入停止自动滚动
        $('.swiper-slide').mouseenter(function() {
            // bannerSwiper.stopAutoplay();
            clearInterval(timer);
        })
        // 鼠标移出开始自动滚动
        $('.swiper-slide').mouseleave(function() {
            // bannerSwiper.startAutoplay();
            start()
            // console.log(i)
        })


        //关闭收藏展示框
        $(document).on('click','.showscbtn .close',function(){
            $('.showscbtn').css('display','none');
            $('.lzcfg').css('display','none');
        })

        //关闭轮播图收藏展示框
        $(document).on('click','.showscbtnlbt .closelbtbtn',function(){
            $('.showscbtnlbt').css('display','none');
        })

        //关闭创建收藏夹窗口
        $(document).on('click','.modal .close',function(){
            $('#new-find-model-folder').css('display','none');
            $('.lzcfg').css('display','none');
        })

        $(document).on('click','.concle-create-folder',function(){
            $('#new-find-model-folder').css('display','none');
            $('.lzcfg').css('display','none');
        })


        //创建收藏收藏夹窗口
        $(document).on('click','.create-new-folder-btn',function(){
            $('.showscbtn').css('display','none');
            $('.showscbtn').css('z-index','-99999999');
            $('#new-find-model-folder').css('display','block');
            $('#new-find-model-folder').css('position','position');
            $('#new-find-model-folder').css('z-index','99999999999');
            
        })

        //创建收藏收藏夹
        $(document).on('click','.create_finder_folder_enter_btn',function(ev){
            $data = {};
            $data.favorite = $("#new-find-model-folder [name='favorite']").val();
            $data.memo = $("#new-find-model-folder").find("[name='memo']").val();

            $data.isopen =1;
            if ($("#new-find-model-folder").find("[name='isopen']").prop('checked')) {
                $data.isopen =2;
            }

            if (!$data.favorite) {
                $("#new-find-model-folder .error_msg").text("收藏夹名称必填");
                return false;
            }else{
                $("#new-find-model-folder .error_msg").text("");
            }

            $('#new-find-model-folder').css('display','none');
            $('.showscbtn').css('display','block');
            $('.showscbtn').css('z-index','99999999999');
            location.reload();
        })


        //点击收藏按钮进行收藏
        $(document).on('click','.to_find_floder_act',function(ev){
            if(!IS_LOGIN){
                $('.login_box').show();
            }else{
            var that=$(this);
            //folder_id获取图片id
            let photo_id_i = $(this).data('pid-i');
            let user_finder_folder_id=$(this).attr('scid'); //获取收藏夹的id
            let photo_url=$(`.itemww img[data-photo-index=${photo_id_i}]`).attr('src');
            let source = collect_id;//图片所在的文章id
            let is_sc=1;
           
            $.ajax({
                    async:false,
                    url: '/vip/finder_collect',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token:'{{csrf_token()}}',
                        user_finder_folder_id:user_finder_folder_id,
                        photo_url:photo_url,
                        source:source,
                        is_sc:is_sc,
                    },
                    success: function (data){
                        if(data.status_code == 0){
                            layer.msg(data.message,{zIndex:99999999999999999999,skin: 'intro-login-class layui-layer-hui'});
                            that.html('已收藏');
                            that.addClass('have-collect');
                            that.removeClass('Button2');
                            that.removeClass('to_find_floder_act');
                            that.addClass('Button');
                            that.addClass('have-disalbed');
                        }
                        else{
                            layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
                            $('.showscbtn').css('display','none');
                            $('.lzcfg').css('display','none');
                            that.text('已收藏');
                            that.removeClass('to_find_floder_act');
                            that.removeClass('Button2');
                            that.addClass('Button');
                            that.addClass('have-disalbed');
                            that.addClass('have-collect');
                        }
                    }
                });
            }
        })

    });

</script> 
<!-- 轮播图和收藏结束 -->


@endsection