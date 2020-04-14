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
    left: 30%;
	display:none;
    cursor:pointer;
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
}

.itemww:hover .titlename,.itemww:hover .scbtm{
	display: block;
}
@media screen and (max-width: 800px) { 
    .box { 
        column-count: 2; // two columns on larger phones 
    } 
} 
@media screen and (max-width: 500px) { 
    .box { 
        column-count: 1; // two columns on larger phones 
    } 
}

</style>
<!--笼罩层-->
<div class="lzcfg"></div>
<div class="banner_news" style="background-image:url(/images/find.jpg)"> —— NEWS —— </div>

<!--点击上面的图片显示轮播图片-->
<div class="swiper-container swiper-home">
  <div style="padding:5px;color:#fff;font-size:65px;position:fixed;z-index:999999999999;top:120px;right:20px;cursor: pointer;" class="closeltb"> × </div>
  <div class="swiper-wrapper"> @foreach ($folist as  $i =>$v)
    <article class="swiper-slide slide-single" data-swiper-slide-index="{{$loop->iteration}}" > <img width="600px" height="600px" src="{{$v['photo_url']}}" data-id="{{$v['photo_source']}}" alt="{{$v['name']}}">
      <div class="scbtmlbt" data-id="{{$v['photo_source']}}" data-pid-i="{{ $i }}" onclick="getID(this)">发现</div>
    </article>
    @endforeach </div>
  <!-- 按钮 -->
  <div class="swiper-home-button-next swiper-button-next"></div>
  <div class="swiper-home-button-prev swiper-button-prev"></div>
</div>
<section class="wrapper"> @foreach ($folistname as $v)
  <h2 style="border-bottom:1px solid #ccc; line-height:60px;">{{$v['name']}}</h2>
  @endforeach 
  <!-- 内容开始 -->
  <div class="box"> @foreach ($folist as $i => $v)
    <div class="itemww"> <img id="boximg" class="img_{{$v['photo_source']}}" src="{{$v['photo_url']}}" data-photo-index="{{ $i }}" photoid="{{$v['photo_source']}}" alt="{{$v['name']}}">
      <div class="titlename" onclick="location='@if($v['static_url']) /article/{{$v['static_url']}} @else /article/detail/{{$v['id']}} @endif'">{{mb_substr($v['articlename'],0,14)}}</div>
      <div class="scbtm" data-id="{{$v['photo_source']}}" data-pid-i="{{ $i }}" onclick="getID(this)">发现</div>
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
          <span img='' floder_id='{{$value["id"]}}'  class='folderattr null' title='{{$value["name"]}}'></span> {{--@if($issc)
          <div id="modal_btns"> <a href='javascript:void(0);' class='Button  asd' scid='{{$value["id"]}}'  data-img='' >已发现</a> </div>
          @else@endif--}}
          <div id="modal_btns"> <a href='javascript:void(0);' class='Button2 to_find_floder_act asd' scid='{{$value["id"]}}'  data-img='' >发现</a> </div>
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
          <div id="modal_btns"> <a href='javascript:void(0);' class='Button  asd' scid='{{$value["id"]}}'  data-img='' >已发现</a> </div>
          @else@endif--}}
          <div id="modal_btns"> <a href='javascript:void(0);' class='Button2 to_find_floder_act asd' scid='{{$value["id"]}}'  data-img='' >发现</a> </div>
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
            <input type="text" name="user_login" id="user_login" class="input" value="" size="20"



                           placeholder="{{trans('login.input_username')}}">
          </label>
        </p>
        <p>
          <label for="user_pass">
            <input type="password" name="password" id="user_pass" class="input" value="" size="20" placeholder="{{trans('login.input_password')}}">
          </label>
        </p>
        <p class="forgetmenot">
          <label for="rememberme">
            <input name="rememberme" type="checkbox" id="rememberme"



                           value="forever">
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
        <p id="nav" class="fr"> <a href="/user/register">{{trans('login.register')}}</a> | <a



                        href="/user/forgot_password">{{trans('login.forgot_password')}}</a> </p>
        <p class="fl"> <a href="/"> ← {{trans('login.return')}} </a> </p>
      </div>
      <div class=""> <span style="float:left; line-height:36px;color: #999;"> {{trans('login.other_login')}}：</span> <a href="javascript:void(0);" onclick="WeChatLogin();" title="使用微信登录"><img src="/img/tl_weixin.png"></a> </div>
      <div class="login_ico"> <a href="javascript:void(0);" onclick="WeChatLogin();"><img src="/img/erweima.gif" width="51" height="51" alt="二维码登陆"></a> </div>
      <div class="ma_box hide">
        <h1><a href="/index" title="{{trans('comm.yinji')}}" tabindex="-1">{{trans('comm.yinji')}}</a></h1>
        <h2>微信扫码登陆</h2>
        <p>
          <iframe frameborder="0" scrolling="no" width="365" height="395"



                        src="/auth/weixin"></iframe>
        </p>
        <p class="backtoblog" style="text-align:center"> <a href="/"> ← {{trans('login.return')}} </a> </p>
        <div class="login_ico"><a href="javascript:void(0);" onclick="WeChatLogin();"><img



                            src="/img/diannao_03.gif" width="51" height="51" alt="账号登陆"></a></div>
      </div>
    </div>
  </div>
</div>

<!--登陆结束--> 

<script src="/js/layer.js"></script> 
<script type="text/javascript">
function getID(obj){
	collect_id = $(obj).attr('data-id');
	// that=$(obj);
	console.log(collect_id);
}



$(document).ready(function(){
	//判断是否为vip
	if(IS_VIP){
	    $('.order_center .order2').find('a').html('会员中心')
	    $('.order_center .order2').find('a').attr('href','/member/interest')
	}
	
	

	//--点击上面的图片显示轮播图片--
	$(document).on('click','#boximg',function(){
		$('.lzcfg').css('display','block');
		$('.swiper-container').css('display','block');

			//轮播图效果
	var $page_main_body = $('.slide-home');
	var $button_next = $page_main_body.find('.swiper-home-button-next');
	var $button_prev = $page_main_body.find('.swiper-home-button-prev');
	var len = $('.slide-home').find('.swiper-slide').length;
		bannerSwiper = new Swiper('.swiper-home', {
		pagination: '.swiper-home-pagination',
		nextButton: '.swiper-home-button-next',
		prevButton: '.swiper-home-button-prev',
		autoplayDisableOnInteraction: true,
		loop: true,
		centeredSlides: true,
		observer: true, //解决数据传入后轮播问题
	    observerParents: true,
	    autoResize: true, //尺寸自适应
	    initialSlide: 0,
	    direction: "horizontal",
	    /*形成环路（即：可以从最后一张图跳转到第一张图*/
	    slidesPerView: 'auto',
	    loopedSlides: 0,
	    autoplay: 1500,
	    /*每隔3秒自动播放*/
		on: {
			init: function () {
				var width = parseInt($page_main_body.width());
				if ($index_pc_bt.size() > 0) {
					$index_pc_bt.css('width', (width - this.slidesSizesGrid['0']) / 2 + 'px');
				}
			}
		},
		onInit: function (swiper) {
			swiper.slides[2].className = "swiper-slide swiper-slide-active";//第一次打开不要动画
		},
		breakpoints: {
			668: {
				slidesPerView: 1
			}
		},
		lazy: {
			loadPrevNext: true,
		}
	});
	})
	//点击关闭轮播图
    $(document).on('click','.closeltb',function(){
		$('.swiper-container').css('display','none');
		$('.showscbtnlbt').css('display','none');
		$('.lzcfg').css('display','none');
    })



	
	//点击图片上的收藏按钮出现弹窗	
	 $(document).on('click','.scbtm',function(ev){
	 	if(!IS_LOGIN){
            $('.login_box').show();
	 	}else{
		 	let photo_id_i = $(this).data('pid-i');
			let tpsrc=$(`.itemww img[data-photo-index=${photo_id_i}]`).attr('src');	//获取图片路径	
			let folder_id=$('.asd').attr('scid'); //获取收藏夹的id
			let folder_ids = [];
			$(".asd").each(function () {
				folder_ids.push($(this).attr("scid"));
			});
			$(".asd").data("pid-i", photo_id_i);//这个啥意思，自定义属性？相当于attr('data-pid-i', photo_id_i),,好吧
		 	
		 	for (let i = 0;i < folder_ids.length;i++) {
		 		let folder_id = folder_ids[i];
		 		console.group(folder_id)
		 		$.ajax({
	                async:false,
	                url: '/vip/scstatus',
	                type: 'POST',
	                dataType: 'json',
	                data: {_token:'{{csrf_token()}}',collect_id:collect_id,tpsrc:tpsrc,folder_id:folder_id},
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
		 	}
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
			let tpsrc=$(`.itemww img[data-photo-index=${photo_id_i}]`).attr('src');	//获取图片路径	
			let folder_id=$('.asd').attr('scid'); //获取收藏夹的id
			let folder_ids = [];
			$(".asd").each(function () {
				folder_ids.push($(this).attr("scid"));
			});
			$(".asd").data("pid-i", photo_id_i);//这个啥意思，自定义属性？相当于attr('data-pid-i', photo_id_i),,好吧
		 	
		 	for (let i = 0;i < folder_ids.length;i++) {
		 		let folder_id = folder_ids[i];
		 		console.group(folder_id)
		 		$.ajax({
	                async:false,
	                url: '/vip/scstatus',
	                type: 'POST',
	                dataType: 'json',
	                data: {_token:'{{csrf_token()}}',collect_id:collect_id,tpsrc:tpsrc,folder_id:folder_id},
	                success: function (data){
	                	console.log(data);
	                	let btn = $(`.asd[scid=${folder_id}]`);
	                    if (data.status_code == 100001) {
	                    	// let btn = $('.asd[scid=' . folder_id . ']');
	                    	$('.showscbtn').css('display','none');
	                    	$('.lzcfg').css('display','none');
				          	btn.html('已发现')
				              	.removeClass('to_find_floder_act')
				              	.removeClass('Button2')
				              	.addClass('Button')
				              	.addClass('have-disalbed')
				              	.addClass('have-collect');
	                    }else{
	                    		btn.html('发现')
				              	.addClass('to_find_floder_act')
				              	.addClass('Button2')
				              	.removeClass('Button')
				              	.removeClass('have-disalbed')
				              	.removeClass('have-collect');
	                    }
	                }
	            });
	            console.groupEnd();
		 	}
		 	tpid=$('.scbtmlbt').attr('data-id');
		 	$('.lzcfg').css('display','block');
		 	$('.showscbtnlbt').css('display','block');
		 	$('.showscbtnlbt').css('z-index','999999999999');
		 	
			// 轮播图鼠标移入停止自动滚动
			$('.showscbtnlbt').mouseenter(function() {
				bannerSwiper.stopAutoplay();
			})
			// l轮播图鼠标移出开始自动滚动
			$('.showscbtnlbt').mouseleave(function() {
				bannerSwiper.startAutoplay();
			})

	 	}
    })

 	// 鼠标移入停止自动滚动
	 $('.swiper-slide').mouseenter(function() {
	    bannerSwiper.stopAutoplay();
	})
	// 鼠标移出开始自动滚动
	$('.swiper-slide').mouseleave(function() {
	    bannerSwiper.startAutoplay();
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
			let tpsrc=$(`.itemww img[data-photo-index=${photo_id_i}]`).attr('src');
			// let tpsrc=$(`.itemww img[photoid=${collect_id}]`).attr('src');	//获取图片路径	
			let folder_id=$(this).attr('scid'); //获取收藏夹的id
			// console.log(tpid,tpsrc,userfinderfolder_id)
			// console.log(tpid);
			console.log(folder_id, collect_id)
			$.ajax({
	            async:false,
	            url: '/vip/addfolders',
	            type: 'POST',
	            dataType: 'json',
	            data: {_token:'{{csrf_token()}}',collect_id:collect_id,tpsrc:tpsrc,folder_id:folder_id},
	            success: function (data){
	            	console.log(data);
	                if(data.status_code == 0){
	                	that.html('已发现')
            			that.addClass('have-collect');
						that.removeClass('Button2');
						that.removeClass('to_find_floder_act');
				        that.addClass('Button');
				        that.addClass('have-disalbed');
	                //     layer.closeAll();
	                }
	                else{
	                	layer.msg(data.message);
	                	$('.showscbtn').css('display','none');
	                	$('.lzcfg').css('display','none');
				      	that.text('已发现')
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
            if (data.status_code == 0) {
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