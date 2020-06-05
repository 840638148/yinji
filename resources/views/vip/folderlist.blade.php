@extends('layouts.app')
@section('title')
  {{trans('comm.yinji')}}-推荐收藏列表 
@endsection
@section('content')
<style>
  h2{
    margin:30px auto;
    text-align: center;
    font-size: 2em; line-height:60px;
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
<!--笼罩层-->
<div class="lzcfg"></div>
<div class="banner_news" style="background-image:url(/images/find.jpg)"> —— NEWS —— </div>

<!--轮播图-->
<div class="swiper-container swiper-home">
  <div style="padding:5px;color:#fff;font-size:65px;position:fixed;z-index:999999999999;top:120px;right:20px;cursor: pointer;" class="closeltb"> × </div>
  <div class="swiper-wrapper"> 
    @foreach ($folist as  $i =>$v)
    <article class="swiper-slide slide-single" data-swiper-slide-index="{{$loop->iteration}}">
    	<div class="wrap" style="position: relative">
    		<img id="btntp" width="600px" height="600px" src="{{$v['photo_url']}}" data-id="{{$v['photo_source']}}" alt="{{$v['name']}}">
    		<div class="scbtmlbt" data-id="{{$v['photo_source']}}" data-pid-i="{{ $i }}" onclick="getID(this)">发现</div>
    	</div>
    </article>
    @endforeach 
  </div>
  <!-- 按钮 -->
  <div class="swiper-home-button-next swiper-button-next"></div>
  <div class="swiper-home-button-prev swiper-button-prev"></div>
</div>
<!--轮播图结束-->

<section class="wrapper"> 
  @foreach ($folistname as $v)
    <h2 style="border-bottom:1px solid #ccc; line-height:60px;">{{$v['name']}}</h2>
  @endforeach 
  <!-- 内容开始 -->
  <div class="box"> @foreach ($folist as $i => $v)
    <div class="itemww"> 
      <img id="boximg" class="img_{{$v['photo_source']}}" src="{{$v['photo_url']}}" data-photo-index="{{ $i }}" photoid="{{$v['photo_source']}}" alt="{{$v['name']}}">
      <div class="titlename" onclick="location='@if($v['static_url']) /article/{{$v['static_url']}} @else /article/detail/{{$v['id']}} @endif'">
      @if(strlen($v['articlename']) < 20) {{$v['articlename']}} @else {{mb_substr($v['articlename'],0,15)}} @endif</div>
      <div class="scbtm" photoid="{{$v['photo_source']}}" imgsrc="{{$v['photo_url']}}" data-id="{{$v['photo_source']}}" data-pid-i="{{ $i }}" onclick="getID(this)">收藏</div>
    </div>
    @endforeach </div>
  
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
          <span  floder_id='{{$value["id"]}}'  class='folderattr null' title='{{$value["name"]}}'></span> {{--@if($issc)
          <div id="modal_btns"> <a href='javascript:void(0);' class='Button  asd' scid='{{$value["id"]}}'  data-img='' >已收藏</a> </div>
          @else@endif--}}
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
          <span img='' floder_id='{{$value["id"]}}'  class='folderattr null' title='{{$value["name"]}}'></span> {{--@if($issc)
          <div id="modal_btns"> <a href='javascript:void(0);' class='Button  asd' scid='{{$value["id"]}}'  data-img='' >已收藏</a> </div>
          @else@endif--}}
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
</section>

<!--收藏图片浏览结束--> 

<!-- 登录 -->

<div class="login_box" style="display:none;">
  <div class="new_folder_bj"></div>
  <div class="login_folder">
    <div id="login" class="login">
      <h1><a href="/indx" title="{{trans('comm.yinji')}}" tabindex="-1">{{trans('comm.yinji')}}</a></h1>
      <h2>{{trans('login.login_title')}}</h2>
      <form name="loginform" id="loginform" action="/user/login" method="post">
        <input type="hidden" name="_token" value="{{-- csrf_token() --}}" />
        <p>
          <label for="user_login">
            <input type="text" name="user_login" id="user_login" class="input" value="" size="20" placeholder="{{trans('login.input_username')}}">
          </label>
        </p>
        <p>
          <label for="user_pass">
            <input type="password" name="password" id="user_pass" class="input" value="" size="20" placeholder="{{trans('login.input_password')}}">
          </label>
        </p>
        <p class="forgetmenot">
          <label for="rememberme">
            <input name="rememberme" type="checkbox" id="rememberme" value="forever">
            {{trans('login.remember_me')}} </label>
        </p>
        <p class="submit">
          <input type="button" name="wp-submit" id="wp-submit-login" class="button button-primary button-large"



                       value="{{trans('login.login')}}">
          <input type="hidden" name="redirect_to" value="/user/index">
          <input type="hidden" name="testcookie" value="1">
        </p>
      </form>
      <div style=" overflow:hidden">
        <p id="nav" class="fr"> <a href="/user/register">{{trans('login.register')}}</a> | <a href="/user/forgot_password">{{trans('login.forgot_password')}}</a> </p>
        <p class="fl"> <a href="/"> ← {{trans('login.return')}} </a> </p>
      </div>
      <div class=""> <span style="float:left; line-height:36px;color: #999;"> {{trans('login.other_login')}}：</span> <a href="javascript:void(0);" onclick="WeChatLogin();" title="使用微信登录"><img src="/img/tl_weixin.png"></a> </div>
      <div class="login_ico"> <a href="javascript:void(0);" onclick="WeChatLogin();"><img src="/img/erweima.gif" width="51" height="51" alt="二维码登陆"></a> </div>
      <div class="ma_box hide">
        <h1><a href="/index" title="{{trans('comm.yinji')}}" tabindex="-1">{{trans('comm.yinji')}}</a></h1>
        <h2>微信扫码登陆</h2>
        <p>
          <iframe frameborder="0" scrolling="no" width="365" height="395" src="/auth/weixin"></iframe>
        </p>
        <p class="backtoblog" style="text-align:center"> <a href="/"> ← {{trans('login.return')}} </a> </p>
        <div class="login_ico"><a href="javascript:void(0);" onclick="WeChatLogin();"><img src="/img/diannao_03.gif" width="51" height="51" alt="账号登陆"></a></div>
      </div>
    </div>
  </div>
</div>

<!--登陆结束--> 

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
        
        /*$.ajax({
          async:false,
          url: '/vip/scstatus',
          type: 'POST',
          dataType: 'json',
          data: {
            _token:'dinkbrs5zOGhIn0S2AAfXE1AzZCTmGiC2slhoZLD',
            user_finder_folder_id:user_finder_folder_id,
            photo_url:photo_url,
            source:source,
            is_sc:is_sc,
          },
          success: function (data) {
            // 重置按钮
            $('.asd[scid]').html('收藏')
            .addClass('to_find_floder_act')
            .addClass('Button2')
            .removeClass('Button')
            .removeClass('have-disalbed')
            .removeClass('have-collect');
            for (let i = 0; i < data.data.length; i++) {
              // 为已收藏的按钮添加效果
              const user_collect_folder_id = data.data[i];
              let btn = $(`.asd[scid=${user_collect_folder_id}]`);
              btn.html('已收藏')
              .removeClass('to_find_floder_act')
              .removeClass('Button2')
              .addClass('Button')
              .addClass('have-disalbed')
              .addClass('have-collect');
            }
          }
        });

        for (let i = 0;i < folder_ids.length;i++) {
          let folder_id = folder_ids[i];
          console.group(folder_id)
          $.ajax({
                    async:false,
                    url: '/vip/scstatus',
                    type: 'POST',
                    dataType: 'json',
                    data: {_token:'dinkbrs5zOGhIn0S2AAfXE1AzZCTmGiC2slhoZLD',collect_id:collect_id,tpsrc:tpsrc,folder_id:folder_id},
                    success: function (data){
                      console.log(data);
                      let btn = $(`.asd[scid=${folder_id}]`);
                        if (data.status_code == 100001) {
                          // let btn = $('.asd[scid=' . folder_id . ']');
                          $('.showscbtn').css('display','none');
                          $('.lzcfg').css('display','none');
                          btn.html('已收藏')
                          .removeClass('to_find_floder_act')
                          .removeClass('Button2')
                          .addClass('Button')
                          .addClass('have-disalbed')
                          .addClass('have-collect');
                        }else{
                          btn.html('收藏')
                          .addClass('to_find_floder_act')
                          .addClass('Button2')
                          .removeClass('Button')
                          .removeClass('have-disalbed')
                          .removeClass('have-collect');
                        }
                    }
                });
                console.groupEnd();
        }*/
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
      console.log(i)
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
              // window.location = "/user/login";
              $('.login_box').show();
      }else{
        var that=$(this);
        //folder_id获取图片id
        let photo_id_i = $(this).data('pid-i');
        let user_finder_folder_id=$(this).attr('scid'); //获取收藏夹的id
        let photo_url=$(`.itemww img[data-photo-index=${photo_id_i}]`).attr('src');
        let source = collect_id;//图片所在的文章id
        let is_sc=1;
        console.log(photo_url);
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
                  console.log(data);
                    if(data.status_code == 0){
                      layer.msg('收藏成功',{skin: 'intro-login-class layui-layer-hui'});
                      that.html('已收藏');
                      that.addClass('have-collect');
                      that.removeClass('Button2');
                      that.removeClass('to_find_floder_act');
                      that.addClass('Button');
                      that.addClass('have-disalbed');
                      // location.reload();
                    }
                    else{
                      layer.msg('已经收藏过了',{skin: 'intro-login-class layui-layer-hui'});
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


<!--登录模块 --> 
<script type="text/javascript">
  function WeChatLogin() {
    if ($(".ma_box").hasClass("hide")) {
      $(".ma_box").removeClass("hide");
    } else {
      $(".ma_box").addClass("hide");
    }
  }

  function toLogin() {
    //以下为按钮点击事件的逻辑。注意这里要重新打开窗口
    //否则后面跳转到QQ登录，授权页面时会直接缩小当前浏览器的窗口，而不是打开新窗口
    var A = window.open("/auth/qq", "_self");
  }

  function wp_attempt_focus() {
    setTimeout(function () {
      try {
          d = document.getElementById('user_login');
          d.focus();
          d.select();
      } catch (e) {
      }
    }, 200);
  }

  //监听回车事件

  $(document).keyup(function(event){
    if(event.keyCode ==13){
        $('#wp-submit-login').trigger("click");
    }
  });

  $("#wp-submit-login").click(function () {
    var url = $.trim($('#loginform').attr("action"));
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'json',
        data: $('#loginform').serialize(),
        success: function (data) {
          if(data.status_code == 0) {
            setTimeout(function () {
              location.href =  location.href
            }, 300);
          } else {
            layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'});
          }
      }
    });
  });

  wp_attempt_focus();

  if (typeof wpOnload == 'function') wpOnload();

</script> 
<!--登录结束--> 

@endsection
