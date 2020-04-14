@extends('layouts.app')



@section('title')

  {{trans('comm.yinji')}}-发现

@endsection



@section('content')
<style>

    .find_tab{

      margin-top:30px;

    }

    .folder_box{

      display: none;

      box-shadow: 0 4px 20px rgba(0,0,0,.2);

    }

    .discovery-item, .collection-item{

      margin: 10px 6px ;

      cursor: pointer; 
      /*background-color:#fbfbfb;*/

    }

    .collection-item:first-of-type,

    .discovery-item:first-of-type{

      margin-top:0;

    }
    .discovery-item .find_title{
		/*position: relative;*/
		/*bottom:40px;*/
  /*  	color: #fff;*/
    }

    .collection-item .find_title,

    .discovery-item .find_title{

      padding:0px 10px;

      line-height: 48px;

    }

    .collection-item .who_find,

    .discovery-item .who_find{
	  /*position: absolute;*/
   /*   bottom: 0px;*/
   /*   width: 100%;*/
      padding:4px 10px;

    }

    .collection-item .item__content,

    .discovery-item .item__content{

      position: relative;

    }

    .collection-item .folder,

    .discovery-item .folder{

      display: none;

    }

    .collection-item .folder_box ul,

    .discovery-item .folder_box ul{

      border-bottom: 1px solid #ddd;

    }

    .Find_login{

      margin-left:-165px;

    }

    .Find_login #login{

      padding:20px;

    }

    .modal{

      display:none;

    }

    .create_button input, .vip_pay p button{

      padding: 6px 50px;

    }

    .create_folder input[type=radio]{

      margin:0;

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



    .img_browse .right .faxian_info{

      margin-top: 10px;

    }

  </style>
<div class="banner_news" style="background-image:url(/images/find.jpg)"> —— NEWS —— </div>
<section class="wrapper"> 
  
  <!-- 选项卡1开始 -->
  
  <div class="find_tab"> 
    
    <!-- 标题开始 -->
    
    <div class="TabTitle">
      <ul id="myTab1">
        <li class="active" onclick="nTabs(this,0);">发现</li>
        <li class="normal" onclick="nTabs(this,1);">推荐收藏夹</li>
        <li class="normal" onclick="nTabs(this,2);">推荐用户</li>
      </ul>
    </div>
    
    <!-- 内容开始 -->
    
    <div class="TabContent"> 
      
      <!--发现-->
      
      <div id="myTab1_Content0" style="padding-bottom: 20px">
        <form method="get" class="search_form" action="#">
            {{--
            <input class="text_input" type="text" placeholder="输入关键字…" style=" width:1120px;">
            --}}
            
            {{--
            <input type="submit" class="search_btn" id="searchsubmit" value="搜索图片">
          </form>
           <div class="masonry" id="discoveryItems">
         
        </div>
      </div>
      
      <!--发现结束--> 
      
      <!--文件夹-->
      
      <div id="myTab1_Content1" class="none">
       <form method="get" class="search_form" action="#">
            {{--
            <input class="text_input" type="text" placeholder="输入关键字…"   style=" width:1120px;">
            --}}
            
            {{--
            <input type="submit" class="search_btn" id="searchsubmit" value="搜索文件">
            --}}
          </form>
            <div class="masonry" id="collectionItems">
         
        </div>
      </div>
      
      <!--文件夹结束-->
      
      <div id="myTab1_Content2" class="none">
        <form method="get" class="search_form" action="#">
            {{--
            <input class="text_input" type="text" placeholder="输入关键字…" style=" width:1120px;">
            --}}
            
            {{--
            <input type="submit" class="search_btn" id="searchsubmit" value="搜索用户">
            --}}
          </form>
        <div class="masonry" id="users">
        </div>
      </div>
    </div>
  </div>
  
  <!-- 选项卡1结束 --> 
  
</section>

<!--弹窗--> 

<!-- 登录 -->

<div class="login_box" style="display:none;">
  <div class="new_folder_bj"></div>
  <div class="login_folder">
    <div id="login" class="login"> 
      
      <!--		<h1><a href="--><!--" title="--><!--" tabindex="-1">--><!--</a></h1>-->
      
      <h1><a href="/indx" title="{{trans('comm.yinji')}}" tabindex="-1">{{trans('comm.yinji')}}</a></h1>
      <h2>{{trans('login.login_title')}}</h2>
      
      <!-- 登陸 -->
      
      <form name="loginform" id="loginform" action="/user/login" method="post">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
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
      <div class="login_ico"> <a href="javascript:void(0);" onclick="WeChatLogin();"><img src="/img/erweima.gif" width="51"



                                                                                            height="51" alt="二维码登陆"></a> </div>
      <div class="ma_box hide">
        <h1><a href="/index" title="{{trans('comm.yinji')}}" tabindex="-1">{{trans('comm.yinji')}}</a></h1>
        
        <!-- <h2>微信扫码登陆</h2> -->
        
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

<!--------选购会员弹窗------->

<div class="new_folder_box" style="display:none;">
  <div class="new_folder_bj"></div>
  <div class="create_folder">
    <div class="create_folder_title">
      <h2>成为会员</h2>
    </div>
    <div class="close vip_close">关闭</div>
    <div class="vip_select mt30">
      <ul>
        <li class="determine vipfee_type1" vip_level="1" price="{{$month_price or '0.01'}}" omit="108"><em>{{$month_price or '0.01'}}</em>元
          <p>月会员</p>
          <del>原价：108元</del></li>
        <li class="vipfee_type2" vip_level="2" price="{{$season_price or '0.01'}}" omit="324"><em>{{$season_price or '0.01'}}</em>元
          <p>季会员</p>
          <del>原价：324元</del></li>
        <li class="vipfee_type3" vip_level="3" price="{{$year_price or '0.01'}}" omit="1296"><em>{{$year_price or '0.01'}}</em>元
          <p>年会员</p>
          <del>原价：1296元</del></li>
      </ul>
    </div>
    <div class="vip_check">
      <ul>
        <!--li>
          <input name="" type="checkbox" value="" checked="checked" />
          到期自动续费一个月，可随时取消</li-->
        <li>
          <input name="" type="checkbox" value="" checked="checked" />
          <a href="#">同意并接受《服务条款》</a></li>
      </ul>
    </div>
    <div class="vip_pay">
      <form class="cart vip_pay" action="/vip/wxbuy" method="post" enctype="multipart/form-data">
        <input type="hidden" name="vip_type" id="vip_type" value="1" />
        <input type="hidden" name="payment_code" id="payment_code" value="wechatpay" />
        <input type="hidden" name="pay_total" id="pay_total" value="{{$month_price or '0.01'}}" />
        <input type="hidden" name="open_id" id="open_id" value="ohPM_1TdJ-oXTAWy7rP-82CT3glo" />
        <p class="vip_pay_msg">应付：<span>{{$month_price or '0.01'}}</span>元 ( 立省9元)</p>
        <p>
          <button type="button" class="single_add_to_cart_button button_red alt" id="buy_now_button">立即购买 </button>
        </p>
      </form>
    </div>
  </div>
</div>

<!--------选购会员结束-------> 

<!--VIP专栏提示-->

<div class="vip_prompt modal" id="vip-img"><a href="#" class="vip_buy">开通VIP会员</a><a href="#" class="vip_detail">了解VIP详情>></a></div>

<!--VIP专栏提示结束--> 

<!--创建文件夹-->

<div class="create_folder modal" id="newFolders">
  <div class="create_folder_title">
    <h2>创建文件夹</h2>
  </div>
  <div class="close" onclick="layer.closeAll();">关闭</div>
  <input type="text" value=""  placeholder="收藏夹名称（必填）" class="mt30" name="folder_name" id="add_folder_name"/>
  <textarea name="brief" id="add_brief" placeholder="简介"  rows="5" class="mt30 folder_introduction"></textarea>
  <p class="mt30"> <i class="sourceinput" sourceid=""></i>
    <input name="add_is_open" id="add_is_open" type="radio" value="1" checked="checked" />
    公开
    <input name="add_is_open" type="radio" value="0" />
    不公开</p>
  <div class="error_msg"></div>
  <div class="create_button">
    <input type="hidden" name="folder_type" id="add_folder_type" />
    <input type="button" value="取消" class="button_gray concle-create-folder " onclick="layer.closeAll();" />
    <input type="button" value="确定" class="button_red add_folder_btn"/>
  </div>
</div>

<!--创建文件夹结束--> 

<!--发现图片浏览-->

<div class="img_browse modal" id="discovery-img-browse" >
  <div class="close">关闭</div>
  <div class="left">
    <div style="height:48px;">
      <h2 class="fl" id="discovery-folder-name">文件夹名称</h2>
      <span class="fr">分享到：</span> </div>
    <div class="image"><img src="images/imges.jpg" alt="发现的图片" class="selected-image"/> </div>
  </div>
  <div class="right" style="margin-top:48px;">
    <div class="more_img"> <a href="#" class="more-img-item selected"><img src="/images/imges.jpg" alt="图片一" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/ad_05.gif" alt="图片一" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/design_16-03.gif" alt="图片二" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/about_img.jpg" alt="图片一" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/ad_22.gif" alt="图片二" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/ad_05.gif" alt="图片一" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/design_16-03.gif" alt="图片二" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/about_img.jpg" alt="图片一" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/ad_22.gif" alt="图片二" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/ad_05.gif" alt="图片一" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/design_16-03.gif" alt="图片二" />
      <div class="cover"></div>
      </a> </div>
    <hr />
    <div class="discoverer">
      <div class="head"><img width="100%" height="100%" src="images/design_16-03.gif" alt="头像" /></div>
      <h2><a href="#">大仁哥10327</a> <span class="vip1">VIP</span></h2>
      <a class="Button">关注</a> </div>
   
  </div>
</div>

<!--发现图片浏览结束--> 

<!--收藏夹图片浏览-->

<div class="img_browse modal" id="collection-img-browse" >
  <div class="close">关闭</div>
  <div class="left">
    <div style="height:48px;">
      <h2 class="fl">文件夹名称</h2>
      <span class="fr">分享到：</div>
    <div class="image"><img src="images/imges.jpg" alt="发现的图片" class="selected-image"/> </div>
  </div>
  <div class="right" style="margin-top:48px;">
    <div class="more_img"> <a href="#" class="more-img-item selected"> <img src="images/imges.jpg" alt="图片一" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"> <img src="images/ad_05.gif" alt="图片一" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"> <img src="images/design_16-03.gif" alt="图片二" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"> <img src="images/about_img.jpg" alt="图片一" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"> <img src="images/ad_22.gif" alt="图片二" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"> <img src="images/ad_05.gif" alt="图片一" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"> <img src="images/design_16-03.gif" alt="图片二" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"> <img src="images/about_img.jpg" alt="图片一" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"> <img src="images/ad_22.gif" alt="图片二" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"> <img src="images/ad_05.gif" alt="图片一" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"> <img src="images/design_16-03.gif" alt="图片二" />
      <div class="cover"></div>
      </a> </div>
    <hr />
    <div class="discoverer">
      <div class="head"><img width="100%" height="100%" src="images/design_16-03.gif" alt="头像" /></div>
      <h2><a href="#">大仁哥1027</a> <span class="vip1">VIP</span></h2>
      <a class="Button3">关注</a> </div>
    
  </div>
</div>

<!--收藏图片浏览结束--> 

<!--弹窗结束--> 

<!-- 模拟数据 --> 

<script src="/js/data.js"></script> 
<script src="/js/member.js"></script> 
<script type="text/javascript">

$(document).ready(function(){

      //发现

    var discoveryItems = {!!$user->finders!!};
    var folders = {!!$user->my_folders!!};
    var discoveryItemsDom = discoveryItems.map(function( item){ return getDiscoveryItemDom(item, folders) }).join('');
    $('#discoveryItems').html(discoveryItemsDom);

    // $('#discoveryItems').append(discoveryItemsDom);

            // 收藏

    var collections = {!!$user->collections!!};
    var collectionItemsDom = collections.map(function( item ){ return getCollectionItemDom(item) }).join('');
    $('#collectionItems').html(collectionItemsDom);

            //推荐用户

    var recommendUsers = {!!$user->recommend_users!!};
    var users = recommendUsers.map(function( item ){ return getUsersDom(item) }).join('');
    $('#users').html(users);



  $('.user_follow_btn').click(function () {
    var follow_id = $(this).attr('data-id');
    var that = $(this)
    $.ajax({
      url: '/member/add_follow',
      type: 'POST',
      dataType: 'json',
      data: {
        _token:_token,
        follow_id:follow_id
      },

      success: function (data) {
        if (data.status_code == 0) {
          layer.msg('关注成功！',{skin: 'intro-login-class layui-layer-hui'})
          that.text('已关注')
          that.removeClass('Button3')
          that.addClass('Button')
          that.addClass('have-disalbed')
        } else {
          layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
        }
      }
    });
  });


  //页面层-自定义
  //判断是否登录
  if(!IS_LOGIN){
    $('.login_box').show();
  }else if(IS_LOGIN && !IS_VIP){
    layer.open({
      type: 1,
      title: false,
      closeBtn: 0,
      anim:-1,
      isOutAnim:false,
      content: $('#vip-img')
    });
  }



	$('.vip_prompt .vip_buy').click(function () {
		$(".new_folder_box").show();
		layer.closeAll();
	})
	
	
	
	$('.vip_prompt .vip_detail').click(function () {
		location.href='/vip/intro'
	})



	$(document).on("click",".vip_close",function () {
		$(".new_folder_box").hide();
			if(!IS_VIP){
				  layer.open({
				    type: 1,
				    title: false,
				    closeBtn: 0,
				    anim:-1,
				    isOutAnim:false,
			    	content: $('#vip-img')
			  });
			}
		return false;
	})


//发现-点击收藏ajax交互
  $('.folder_box').on('click','.add_finder_btn',function(){
    if( $(this).html()=='收藏'){
      var that = $(this)
      var itemEle = $(this).closest('.item_content').find('.bg-img')
      var folder_id = $(this).attr('data-id');
      var collect_id = itemEle.attr('data-id');
      var folder_name = $(this).parent().find('h3').text();
      var is_sc=1;
      $.ajax({
        url: '/article/collect',
        type: 'POST',
        dataType: 'json',
        data: {
        	_token:'{{csrf_token()}}',
        	folder_id:folder_id,
        	folder_name:folder_name,
        	collect_id:collect_id,
        	// is_sc:is_sc,
        },
        success: function (data) {
			// console.log(data)
          if (data.status_code == 0) {
            that.html('已收藏')
            that.addClass('have-collect');
          }
          if(data.status_code == 100001){
          	layer.msg('已经收藏过了',{skin: 'intro-login-class layui-layer-hui'})
	      	that.text('已收藏')
	      	that.css('width','50px')
	        that.removeClass('Button2')
	        that.addClass('Button')
	        that.addClass('have-disalbed')
          	
            // layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
          }
        }
      })
    }
  })
  
})

    // 获取各种各样的DOM
 
    // 获取发现每一项的Dom

    function getDiscoveryItemDom(item,folders){

      var foldersArr = folders ||  [];
      

      var h = '';
  
      h += '<div class="item discovery-item"  style="display:flex"; >'

      h += '  <div class="item_content ">';

      h += '    <img src="' + item.img + '" class="bg-img" data-id="' + item.id + '" id="sourceimg" source="'+item.source+'"  />';

      h += '    <div class="find_title" data-source="'+item.source+'">'; 

      h += '      <h2>'+ item.who_find?item.who_find[0].tinames:'' +'...</h2>';

      if(item.who_find && item.who_find.length > 0){

        h += '      <a href="javascript:;" class="find_info_more"></a>'; 

      }

      h += '    </div>';

      h += '    <div class="who_find" style="display:none;">';

      item.who_find.map(function(user,index){
		
        h += '      <img src="' + user.userIcon + '"  />';
			
		if(user.userName){
        	h += '      <span > <a href="javascript:;">'+ user.userName +'</a> 收藏到 <a href="#">'+ user.folderName + '</a></span>';
        }else{
        	h += '      <span > <a href="javascript:;">匿名用户</a> 收藏到 <a href="#">'+ user.folderName + '</a></span>';
        }
      })

      h += '    </div>';

      h += '    <div class="folder">';

      h += '      <div class="fl folder_bj" style="width:80%" >选择文件夹';

      h += '        <span class="fr show-more-selcect-item" style="background:url(images/arrow-ico.png); width:36px; height:36px;"></span>';

      h += '      </div>';

      h += '      <a href="javascript:void(0)" class="Button2 fr add-collection-btn">收藏</a>';

      h += '    </div>';

      h += '    <div class="folder_box">';

      h += '      <ul>';

      foldersArr.map(function(folder,idx){

        h += '        <li>';

        h += '          <h3>'+ folder.title + '</h3>';
        		
        		
		var isscobj={!!json_encode($issc)!!};
		var isscarr=JSON.parse(isscobj);
    	let uc = {};
    	let is_sc = false;
    	for (let i = 0;i < isscarr.length;i++) {
    		if (isscarr[i].user_collect_folder_id == folder.id) {
    			uc = isscarr[i];
    			if (uc.collect_id == item.id) {
    				is_sc = true;
    			}
    		}
    	}
		// console.log(isscarr,item,folder,uc);

        if(is_sc){
        	h += '          <span class="' + (folder.type == 'private' ? 'private' :'') +'" title="'+(folder.typeText ? folder.typeText : '') + '" ></span> <a style="width:50px;" href="javascript:void(0)" class="have-disalbed Button fr add_finder_btn" data-id="' + folder.id + '" data-img="' + item.img + '" data-title="' + item.title + '" data-source="' + item.source + '">已收藏</a>';
        }else{
        	h += '          <span class="' + (folder.type == 'private' ? 'private' :'') +'" title="'+(folder.typeText ? folder.typeText : '') + '" ></span> <a href="javascript:void(0)" class=" Button2 fr add_finder_btn" data-id="' + folder.id + '" data-img="' + item.img + '" data-title="' + item.title + '" data-source="' + item.source + '">收藏</a>';
        }
	
        h += '        </li>';

      })
      
      h += '      </ul>';   
      h += '      <a href="javascript:void(0)" class="create create-new-folder" data-type="find" id="sourcea" sourceid="'+item.source+'" >创建收藏夹</a>';
      h += '    </div>';
      h += '  </div>';
      h += '</div>';
      return h;
   
    }



    // 获取收藏每一项的Dom

    function getCollectionItemDom(item){
      var h= '';
      h += '<div class="item collection-item" data-id="' + item.id + '">';
      h += ' <div class="item__content">';
      h += '  <ul onclick="location=\'/folderlist/' + item.id+ '\'">';

      item.imgs.map(function(img){
      	
      	// console.log(item)
			h += '    <li><a href="folderlist/'+ item.id+'"><img src="' + img.src +'" alt="' + img.alt + '" /></a></li>';
      })

      h += '  </ul>';
      h += '  <div class="find_title">';
      h += '    <h2><a href="folderlist/'+ item.id+'">'+ item.title + '</a></h2>';

      if(item.who_find && item.who_find.length > 0){
        item.who_find.map(function(user,idx){
        	
          h += '   <a href="javascript:void(0);" class="collect-user-icon"><img id="errimg" src="' + user.userIcon + '" onerror="this.onerror=``;this.src=`/img/avatar.png`" /></a> ';
        })
      }
      h += '  </div>';
      h += ' </div>';
      h += '</div>';
      return h;

    }



    // 获取推荐用户每一项的Dom

    function getUsersDom(user){
      var h= ''; 
      h += ' <div class="item">';
      h += '   <div class="users">';
      h += '     <div class="border-bottom1">';
      h += '       <div class="head"><img width="100%" height="100%" src="' + (user.icon?user.icon:'/img/avatar.png') + '" alt="头像" /></div>';
      h += '       <h2><a href="#">' + user.name.substr(0,12) + '</a> </h2>';
      h += '       <div>' +user.gender+ '-' + user.addr + ' ' + user.rank ? user.rank : '' + '</div>';
      h += '     </div>';
      h += '     <div class="Statistics">';
      h += '       <ul>';
      h += '         <li><span>' + user.collections + '</span>收藏</li>';
      h += '         <li><span>' + user.fans + '</span>粉丝</li>';
      h += '       </ul>';
      h += '     </div>';
      h += '     <a class="Button3 user_follow_btn" data-id="' + user.id + '">关注</a> </div>';
      h += '   </div>';
      h += ' </div>';
      return h;
    }



    //获取收藏图片的每一个

    function getImgBrowseImgsDom(imgs,id,index){
      var imgsArr = imgs || [];
      var idx = index || 0;
	  var h='';

      imgsArr.map(function(img, i){
        h += '<a href="#" class="more-img-item ' + (parseInt(idx) === i ? 'selected' : '') + '"><img src="' + img.src + '" alt="'+img.text+'" /> <div class="cover"></div></a>';
      })

      $( id + ' .selected-image').attr('src',imgsArr[idx].src);
      $(id + ' .more_img').html(h);

    }






    function nTabs(thisObj,Num){
      if(thisObj.className == "active")return;
      var tabObj = thisObj.parentNode.id;
      var tabList = document.getElementById(tabObj).getElementsByTagName("li");
      for(i=0; i <tabList.length; i++){
        if (i == Num){
          thisObj.className = "active";
          // document.getElementById(tabObj+i).style.display = "block"; 
          tabList[i].style.dispaly="block"; 
        }else{
          tabList[i].className = "normal";
          // document.getElementById(tabObj+i).style.display = "none";
          tabList[i].style.dispaly="none"; 
        }
      }
    }



    function wp_attempt_focus(){
      setTimeout( function(){ try{
        d = document.getElementById('user_login');
        d.focus();
        d.select();
      } catch(e){}
      }, 200);
    }



    //切换图片

    $(document).on('click','.more-img-item',function(){
      var src = '';
      //去除所有选中状态
      $('.more-img-item').each(function(){
        $(this).removeClass('selected');
      })

      // 添加选中状态
      $(this).addClass('selected');
      src = $(this).find('img').attr('src');
      $(this).parents('.img_browse').find('.selected-image').attr('src',src);
    })


/*
    // 收藏夹展示图片框

    // $(document).on('click','.collection-item',function(){
    //   var folder_id = $(this).attr('data-id');
    //   $.ajax({
    //     async:false, 
    //     url: 'vip/get_folder_detail',
    //     type: 'POST',
    //     //dataType: 'json',
    //     data: {
    //       _token:_token,
    //       folder_id:folder_id
    //     },
    //     success: function (data) {
    //       $('#collection-img-browse').html(data);
    //       //初始化相框
    //       //getImgBrowseImgsDom(browseImgs,'#collection-img-browse');打开的话会显示默认的图片
    //       layer.open({
    //         type: 1,
    //         title: false,
    //         closeBtn: 0,
    //         anim:-1,
    //         isOutAnim:false,
    //         content: $('#collection-img-browse')
    //       });
    //     }
    //   });
    // })

*/

    // 发现展示图片框

    $(document).on('click','.discovery-item .bg-img',function(){
      var folder_id = $(this).attr('data-id');
      $.ajax({
        async:false,
        url: 'vip/get_folder_detail',
        type: 'POST',
        //dataType: 'json',
        data: {
          _token:_token,
          folder_id:folder_id
        },
        success: function (data) {
          $('#discovery-img-browse').html(data);
          //初始化相框
          //getImgBrowseImgsDom(browseImgs,'#discovery-img-browse');
          layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            anim:-1,
            isOutAnim:false,
            content: $('#discovery-img-browse')
          });
        }
      });





    })



    //关闭所有展示框
    $(document).on('click','.modal .close',function(){
      layer.closeAll();
    })

    //关闭所有展示框
    $(document).on('click','.modal .concle-create-folder',function(){
      layer.closeAll();
    })



    //点击展示更多的收藏文件夹

    // $(document).on('click','.show-more-selcect-item',function(){

    //   if($(this).hasClass('showbox')){

    //     $(this).parent().css('width','80%');

    //     $(this).parent().siblings('.add-collection-btn').show()

    //     $(this).css('background-position','0px 0px');

    //     $(this).parents('.folder').siblings('.folder_box').css('display','none');

    //     $(this).removeClass('showbox')

    //   }else{

    //

    //     $(this).parent().siblings('.add-collection-btn').hide()

    //     $(this).parent().css('width','100%');

    //     $(this).css('background-position','0px -36px');

    //     $(this).parents('.folder').siblings('.folder_box').css('display','block');

    //     $(this).addClass('showbox');

    //   }

    // })



    $(document).on('click','.item_content .folder',function(){
      var moreEle =  $(this).find('.show-more-selcect-item')
      if(moreEle.hasClass('showbox')){
        moreEle.parent().css('width','80%');
        moreEle.show()
        moreEle.css('background-position','0px 0px');
        moreEle.parents('.folder').siblings('.folder_box').css('display','none');
        moreEle.removeClass('showbox')
        $(this).find('.add-collection-btn').show()
      }else{
        moreEle.parent().siblings('.add-collection-btn').hide()
        moreEle.parent().css('width','100%');
        moreEle.css('background-position','0px -36px');
        moreEle.parents('.folder').siblings('.folder_box').css('display','block');
        moreEle.addClass('showbox');
        $(this).find('.add-collection-btn').hide()
      }
    })



    // 发现页面展示收藏

    $(document).on('mouseenter','.discovery-item',function(){
      $(this).find('.folder').css('display','block');
    })

    $(document).on('mouseleave','.discovery-item',function(){
      $(this).find('.folder').css('display','none');
      $(this).find('.folder_box').css('display','none');
      $(this).find('.folder_bj').css('width','80%');
      $(this).find('.folder_bj').siblings('.add-collection-btn').show();
      $(this).find('.folder_bj .show-more-select-item').removeClass('showbox');
      $(this).find('.folder_bj .show-more-select-item').css('background-position','0px 0px');
    })





    //点击展示谁发现按钮

    $(document).on('click','.find_info_more',function(ev){
    	var dasou=$(this).parent().attr('data-source');
    	// alert(dasou);
      ev.stopPropagation()
      $(this).parents('.find_title').siblings('.who_find').each(function(){
        var isShow = $(this).css('display');
        if(isShow == 'block'){
          $(this).css('display','none');
          //$(this).parent('.discovery-item .find_title').css({"position":"absolute","bottom": "-6px","color":"#fff"});
        }else{
          $(this).css('display','block');
          //$(this).parent('.discovery-item .find_title').css({"position":"absolute","bottom": "35px","color":"#fff"});
        }
      })
    })

    //

    // $('.user_follow_btn').click(function () {

    //   var follow_id = $(this).attr('data-id');

    //   $.ajax({

    //     url: '/member/add_follow',

    //     type: 'POST',

    //     dataType: 'json',

    //     data: {

    //       _token:_token,

    //       follow_id:follow_id

    //     },

    //     success: function (data) {

    //       if (data.status_code == 0) {

    //         layer.msg('关注成功！',{skin: 'intro-login-class layui-layer-hui'})

    //       } else {

    //         layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})

    //       }

    //     }

    //   });

    // });



  </script> 
{{--会员购买模块--}} 
<script>



    _omit  = 58;

    _price = '0.01';





    $(document).on("submit",".cart",function () {



      var agree = document.getElementById("agree").checked;



      if (!agree) {







        alert('请阅读并接受《服务条款》');



        return false;



      }



    });







    $(document).on("click",".vip_select li",function () {

      _self = $(this);



      _price = _self.attr("price");

      _omit = _self.attr("omit");



      $('#vip_type').val(_self.attr("vip_level"));

      $('#pay_total').val(_price);

      $('#payment_code').val('alipay');



      $(".vip_select li").removeClass("determine");



      _self.addClass("determine");



      var c = parseInt(_omit)-parseInt(_price);



      $(".vip_pay_msg").html("应付：<span>"+_price+"</span>元 ( 立省"+c+"元)");



    });







    $(document).ready(function(){

      // listen if someone clicks 'Buy Now' button



      // if(!IS_LOGIN){

      //     $('.login_box').show()

      // }

      $(document).on("click","#buy_now_button",function(){

        var vip_type = $('#vip_type').val();

        if (vip_type == '') {

          alert('请选择会员类型');

          return false;

        }

        window.location = '/vip/pay?vip_type=' + vip_type;

        return;



        //submit the form



        //$('form.cart').submit();

        var url = '/vip/wxbuy';

        var folder_data = {

          _token:_token,

          vip_type : $('#vip_type').val(),

          payment_code : $('#payment_code').val(),

          pay_total : $('#pay_total').val(),

        };



        $.ajax({

          async:false,

          url: url,

          type: 'POST',

          dataType: 'json',

          data: folder_data,

          success: function (data) {

            if (data.status_code == 0) {

              if ('alipay' == data.data.payment_code) {

                window.location = data.data.redirect_url;

              } else {

                alert('微信支付返回二维码地址');

              }

              layer.closeAll();

            } else {

              alert(data.message);

            }

          }

        });



      });



    });



  </script> 
{{--登录模块--}} 
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



      // var loginform = new FormData();



      var url = $.trim($('#loginform').attr("action"));



      $.ajax({



        url: url,



        type: 'POST',



        dataType: 'json',



        data: $('#loginform').serialize(),



        success: function (data) {



          if (data.status_code == 0) {



            setTimeout(function () {

              location.href =  '/finder'



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
<script type="text/javascript"> 
  
	//头像中图片不存在，显示默认图片
	$(document).ready(function(){
	  $("errimg").error(function(){
	    $("img").attr('src','/img/avatar.png');
	  });
	});
		
  </script> 
@endsection 