<html lang="zh-CN">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="author" content="{{trans('comm.yinji')}}">
<meta name="viewport" content="width=device-width,height=device-height, initial-scale=1.0, user-scalable=no" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta http-equiv="Cache-Control" content="no-transform">
<meta http-equiv="Cache-Control" content="no-siteapp">

<meta http-equiv="Access-Control-Allow-Origin" content="*" />

<title>@yield('title')</title>
<meta name="verification" content="@yield('seo_verification')" />
<meta name="description" content="@yield('seo_description')" />
<meta name="keywords" content="@yield('seo_keywords')" />
<script src="/js/jquery-1.10.1.min.js"></script>
<script src="/js/swiper.jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/layer.js"></script>
<link href="/css/layer.css" rel="stylesheet">
<link href="/css/bootstrap.min.css" rel="stylesheet">
<link href="/css/swiper.min.css" rel="stylesheet">
<link href="/css/main.css" rel="stylesheet" type="text/css">
<link href="/css/style.css" rel="stylesheet" type="text/css">
<link href="/css/response.css" rel="stylesheet" type="text/css">
<link href="/css/font-awesome.min.css" rel="stylesheet">

<style>
.nav_search_box { position: relative; width: 880px; float: right; }
.nav_search_panle { position: absolute; }
.search_frame { position: relative; background: #fff; height: 48px; width: 80%; margin: 12px 10%; border-radius: 80px; overflow: hidden; padding: 0 10px; }
.nav-search-btn { top: 9px; position: absolute; right: 20px; color: #666; font-size: 20px; cursor: pointer; }
.search_keyword { width: 660px; position: absolute; left: 110px; top: 75px; height: 210px; background-color: #fff; padding: 10px; opacity: 0; transition: opacity 800ms; }
.resent-search-items>dd { display: flex; }
.resent-search-items>dd>span { flex: 1; }
#nav_search_text { transition: opacity 800ms; }
.nav_search_box_close { position: absolute; left: 50px; font-size: 20px; top: 24px; color: #fff; }
</style>
</head>

<!-- <body  ondragstart="return false" oncontextmenu="return false" onselectstart="return false"> -->

<body>
<header class="index">
<section id="header_main" class="header_main header_animated headroom--not-top headroom--not-bottom slideDown">
<section class="wrapper">

<!--菜单-->

<header class="mobile_header hide">
  <section class="mheader_main header_animated headroom--top headroom--not-bottom"> 
    
    <!--按钮--> 
    
    <i class="icon-menu"></i> <i class="icon-user"></i> 
    
    <!--按钮end--> 
    
    <!--LOGO-->
    
    <h1> <a href="/" class="logo" title="发现全球设计之美-{{trans('comm.yinji')}}"><img src="/images/logo.png" alt="{{trans('comm.yinji')}}"></a> </h1>
    
    <!--LOGOend--> 
    
  </section>
</header>
<nav class="header-nav top-nav">

<!--LOGO-->

<h1> <a href="/" class="logo left" title="{{trans('comm.yinji')}}-发现全球设计之美"><img src="/images/logo.png" alt="{{trans('comm.yinji')}}"></a> </h1>

<!--LOGO-->

<div class="header-menu  right">
<ul class="menu">
<li class="menu-item menu-item-search iphone_menu" style="border-left: 1px solid #fff; border-left-color: rgba(255,255,255,.3);" ><a href="#" title="导航"><i class="icon-list-bullet"></i></a> 
	<ul class="sub-menu">
		<li> <a href="/"> 首页</a> </li>
		<li> <a href="/news"> 新闻</a> </li>
		<li> <a href="/interior"> 室内</a> </li>
		<li> <a href="/archs"> 建筑</a> </li>
		<li> <a href="/designer"> 设计师</a> </li>
		<li> <a href="/finder"> 发现</a> </li>
		<li> <a href="/vip/promotion"> 关于我们</a> </li-->
	
	</ul>
</li>
<li class="menu-item menu-item-search search-btn" style="border-left: 1px solid #fff; border-left-color: rgba(255,255,255,.3);"><a href="#search" title="点击搜索"><i class="icon-search-1"></i></a></li>
@guest
<li class="menu-item menu-item-search"  style="border-left: 1px solid #fff; border-left-color: rgba(255,255,255,.3);"> 
  
  <!--未登录--> 
  
  <a href="/user/login" title="立即登录"><i class="icon-user"></i></a> </li>
@endguest



                        @auth
<li class="menu-item menu-item-search"  style=" border-left: 1px solid #fff; border-left-color: rgba(255,255,255,.3);"> 
  
  <!--登录后个人中心--> 
  
  <a href="/member" title=""><img class="avatar" src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="@if($user->nickname){{$user->nickname}}@endif" /></a>
  <ul class="sub-menu">
  
  <!---li> <a href="/member"> 个人中心</a> </li>



                                    <li> <a href="/myposts"> 我的文章</a> </li>



                                    <li> <a href="/contributepost"> 文章投稿</a> </li>



                                    <li> <a href="/member/collect"> 我的收藏</a> </li>



                                    <li> <a href="/member/profile"> 我的帐户</a> </li>



                                    <li> <a href="/member/point"> 我的积分</a> </li>



                                    <li> <a href="/member/porfile"> 编辑资料</a> </li-->



                                    <li> <a href="/user/logout" title="登出"> 退出登录 </a> </li>



                                </ul>



                                <!--个人中心-->



                            </li>



                        @endauth



                        <li class="menu-item menu-item-search" style="border-left: 1px solid #fff; border-left-color: rgba(255,255,255,.3);">







                            @if (isset($lang) && 'en' == $lang)



                                <a href="javascript:void(0);"><i id="lang-switch" data="zh-CN">中</i></a>



                            @else



                                <a href="javascript:void(0);"><i id="lang-switch" data="en">En</i></a>



                            @endif











                        </li>



                    </ul></div>



                <div class="nav_search_box" style="display:none">

                    <a href="#search" class="fr nav_search_box_close" title="点击关闭搜索">x</a>

                    <div class="search_frame" style="display:block;">

                        <input id="nav_search_text" name="keywords" type="text" placeholder="输入搜索的关键词" style="border:0; width:650px; float:left; line-height:36px; font-size:16px; color:#999">

                        <a href="#search" class="fr nav-search-btn" title="点击搜索"><i class="icon-search-1" style="margin:0"></i></a>



                    </div>

                    <!-----提示的搜索关键词------->

                    <div class="search_keyword">

                        <dl>

                            <dt >最近搜索</dt>

                            <div class="resent-search-items">

                            </div>



                        </dl>



                        <dl style="border-left:1px solid #f8f8f8" class="hot-search">

                            <dt>热门搜索</dt>



                        </dl>

                    </div>

                </div>











                <div class="header-menu right phc_head_menu">



                    <ul class="menu">



                        <li id="menu-item-2637" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-2637"> <a href="/" class="top_nav_link">



                                <div class="cube_container">



                                    <div class="backer">Home</div>



                                    <div class="front">首页</div>



                                </div>



                            </a> </li>



                        <li id="menu-item-2674" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2674"> <a href="/news" class="top_nav_link">



                                <div class="cube_container">



                                    <div class="backer">News</div>



                                    <div class="front">新闻</div>



                                </div>



                            </a> </li>



                        <li id="menu-item-2638" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2638"> <a href="/interior" class="top_nav_link">



                                <div class="cube_container">



                                    <div class="backer">Interiors</div>



                                    <div class="front">室内</div>



                                </div>



                            </a> </li>



                        <li id="menu-item-2673" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2673"> <a href="/archs" class="top_nav_link">



                                <div class="cube_container">



                                    <div class="backer">Architecture</div>



                                    <div class="front">建筑</div>



                                </div>



                            </a> </li>



                        <li id="menu-item-2676" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2676"> <a href="/designer" class="top_nav_link">



                                <div class="cube_container">



                                    <div class="backer">Designers</div>



                                    <div class="front">设计师</div>



                                </div>



                            </a> </li>



                        <li id="menu-item-17508" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17508"> <a href="/finder" class="top_nav_link">



                                <div class="cube_container">



                                    <div class="backer">Finder</div>



                                    <div class="front">发现</div>



                                </div>



                            </a> </li>



                        <li id="menu-item-17509" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17509"> <a href="/job" class="top_nav_link">



                                <div class="cube_container">



                                    <div class="backer">Jobs</div>



                                    <div class="front">工作</div>



                                </div>



                            </a> </li>



                        <li  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17509"> <a href="/vip/promotion" class="top_nav_link">



                                <div class="cube_container">



                                    <div class="backer">Cooperate</div>



                                    <div class="front">合作</div>



                                </div>



                            </a>



                            <!---ul class="sub-menu">



                                <li><a href="/about"> 关于印际</a></li>



                                <li> <a href="/ad"> 文章推广</a></li>



                                <li> <a href="/register"> 广告合作</a></li>



                                <li> <a href="/work"> 招聘服务</a></li>



                                <li><a href="/vip"> 会员服务</a></li>



                            </ul--->



                        </li>



                    </ul>



                </div>



            </nav>





            <!--菜单end-->



        </section>



    </section>



</header>







@yield('content')



<!-- 搜索 -->

<article class="search popup" id="search" style="display:none">

    <h3><i class="icon-search-1"></i>

        按文章类型进行搜索        </h3>

    <form method="get" class="search_form" action="http://yinji.nenyes.com">

        <select name="post_type" class="search_type">

            <option value="post">

                文章                </option>

            <option value="arch">

                建筑                </option>

            <option value="concept">

                概念                </option>

            <option value="ffe">

                家具                </option>

            <option value="designer">

                设计师                </option>

            <option value="photographer">

                摄影师                </option>

            <option value="product">

                产品                </option>

        </select>

        <input class="text_input" type="text" placeholder="输入关键字…" name="s" id="s" />

        <input type="submit" class="search_btn" id="searchsubmit" value="搜索" />

    </form>

</article>



<script >

    $('.search-btn').on('click',function(){

        $(this).hide();

        $('.phc_head_menu').hide();

        $('.nav_search_box').show();

        $('#nav_search_text').focus();

        $('.search_keyword').css('opacity',1);



        var items = localStorage.searchHistoryItems ? localStorage.searchHistoryItems.split('|') : [];

        var h = '';

        items.map(function(item,index){

            if(index<5)

            h += '<dd><span>' + item +'</span><i class="icon-cancel-circled fr remove-resent-search-item"></i></dd>'

        })

        $('.resent-search-items').html(h);

        return false;

        layer.open({

            type: 1,

            title: false,

            closeBtn: 0,

            anim: -1,

            shadeClose: true,

            isOutAnim: false,

            content: $('#search')

        })

    })







    var closeSearch = function(){



        $('.nav_search_box').hide();

        $('.search-btn').show();

        $('.phc_head_menu').show();

        $('#nav_search_text').val('');

        $('.search_keyword').css('opacity',0);

        // return false;

        // layer.open({

        //     type: 1,

        //     title: false,

        //     closeBtn: 0,

        //     anim: -1,

        //     shadeClose: true,

        //     isOutAnim: false,

        //     content: $('#search')

        // })

    }

    $('.nav_search_box_close').on('click',closeSearch)





    $('#nav_search_text').on('blur',closeSearch)



    //监听回车事件

    $(document).keyup(function(event){

        if(event.keyCode ==13){

            $('.nav-search-btn').trigger("click");

        }

    });



    // javascript阻止blur事件触发

    $('.nav-search-btn').on('mousedown',function(event){

        event.preventDefault()

    })



    $('.hot-search').on('mousedown',function(event){

        event.preventDefault()

    })



    //搜索功能 根据选择的关键字

    function searchItem(value){

        if (value && value != '') {

            window.location.href = '/search?keyword=' + encodeURIComponent(value);

        }

    }



    $('.hot-search').on('click','dd',function(event){

        var value = $(this).text()

        searchItem(value)

    })



    $('.nav-search-btn').on('click',function(){

        var value = $('#nav_search_text').val().trim();

        if(value && value!=''){

            var items = localStorage.searchHistoryItems ? localStorage.searchHistoryItems.split('|') : [];

            if(items.length>5){

                items.splice(0,1,value);

            }else{

                items.unshift(value);

            }

            localStorage.searchHistoryItems = items.join('|');

            var h = '';

            items.map(function(item,index){

                if(index<5)

                h += '<dd><span>' + item +'</span><i class="icon-cancel-circled fr remove-resent-search-item"></i></dd>'

            })

            $('.resent-search-items').html(h);



            if (value != '') {

                window.location.href = '/search?keyword=' + encodeURIComponent(value);

            }

        }



        return false;

    })



    $('.resent-search-items').on('click','span',function(){

        var value = $(this).text()

        searchItem(value)

    })



    $('.resent-search-items').on('mousedown','dd',function(event){

        event.preventDefault()

    })



    $(document).on('click','.remove-resent-search-item',function(event){

        event.preventDefault()

        var $this = $(this);

        var items = localStorage.searchHistoryItems ? localStorage.searchHistoryItems.split('|') : [];

        items.map(function(item,idx){

            if(item == $this.parent().text()){

                items.splice(idx,1);

            }

        })

        localStorage.searchHistoryItems = items.join('|');

        $(this).parent().remove();



    })

    $(document).ready(function(){

        var hotUrl =  '/hot_search_ajax'

        $.ajax({

            async: false,

            url: hotUrl,

            type: 'GET',

            dataType: 'json',

            data: {},

            success: function (data) {

                if (data.status_code == 0) {

                    var values = data.data;index = 0

                    for(i in values){

                        if(index<5)

                        $('.hot-search').append('<dd>'+values[i]+'</dd>')

                        index++

                    }



                } else {

                    layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})

                }

            }

        });



        // $('.hot-search').find('dd').

    })







</script>

<!-- 版权 -->



<section class="copyright">



    <div class="wrapper">

        <div class="social fl"><a href="/static/about.html">关于我们</a> | <a href="/static/bqbh.html">版权保护</a> | <a href="/static/flsm.html">法律声明</a>  | <a href="/static/map.html">网站地图</a></div>

        Copyright © 2016-<?php echo date('Y'); ?> 印际 / Yinji.space / 粤ICP备17108593号



        <div class="social fr">

            关注：<a href="https://weibo.com/yinjispace"><img src="/images/foot_31.gif" alt="新浪微博"></a>



            <a  href="javascript:void(0)" onMouseOut="hideImg()"  onmouseover="showImg()"><img src="/images/foot_33.gif" alt="印际微信公众">

                <div class="footer_weixin" id="wxImg">

                    <ul>

                        {{--<li><img src="/images/foot_27.gif" alt="扫一扫二维码"> <h2>印际</h2> <p>专注于全球室内设计资讯</p><p>室内/空间/设计/艺术</p></li>--}}

                        {{--<li><img src="/images/foot_28.gif" alt="扫一扫二维码"> <h2>内外</h2> <p>专注于全球室内设计资讯</p></li>--}}

                        {{--<li> <img src="/images/foot_29.gif" alt="扫一扫二维码"> <h2>每件</h2> <p>专注于全球产品设计资讯</p></li>--}}

                        {{--<li> <img src="/images/foot_30.jpg" alt="扫一扫二维码"> <h2>在线客服</h2> <p>9:00～18:00</p></li>--}}



                        <img src="/images/weixinqrcode.jpg" alt="扫一扫二维码">

                    </ul>

                </div></a>



            <a href="https://www.instagram.com/yinjispace/"><img src="/images/foot_35.gif" alt="instagram"></a>



            <a href="https://www.pinterest.com/yinjispace"><img src="/images/foot_37.gif" alt="pin"></a>



        </div>



    </div>



</section>

<script type="text/javascript">

    function  showImg(){

        document.getElementById("wxImg").style.display='block';

    }

    function hideImg(){

        document.getElementById("wxImg").style.display='none';

    }

</script>

<!-- 版权end -->



<!-- cdw 2019-07-01-->

<script src="/js/app.add.js"></script>

</body>







<script type="text/javascript">

    @guest

		var IS_LOGIN = false;

		var IS_VIP = false;

    @endguest



	@auth

		var IS_LOGIN = true;

        @if ($user && $user->is_vip)

			var IS_VIP = true;

        @else

			var IS_VIP = false;

        @endif

    @endauth



    var _token = '{{csrf_token()}}';

    $("#lang-switch").click(function () {



        var lang = $(this).attr('data');



        $.ajax({



            url: '/lang/switch',



            type: 'GET',



            dataType: 'json',



            data: {lang:lang},



            complete: function () {



                window.location.reload();



            }



        });



    });





    $(".create_finder_folder_enter_btn").click(function () {

        var finder_folder_name = $('#finder_folder_name').val();

        var finder_folder_brief = $('#finder_folder_brief').val();

        var is_open = $("input[name='is_open']").val();

        if (finder_folder_name == '') {

            alert('请填写收藏夹名称！');

            return false;

        }

        $.ajax({

            url: '/vip/add_finder_folder',

            type: 'POST',

            dataType: 'json',

            data: {

                _token:_token,

                finder_folder_name:finder_folder_name,

                finder_folder_brief:finder_folder_brief,

                is_open:is_open

            },

            success: function (data) {
				var str="<li><h3>"+data.name+"</h3><span img='' floder_id='"+data.kid+"' class='folderattr null' title='"+data.name+"'></span><a href='javascript:void(0);' class='Button2 fr to_find_floder_act add_finder_btn' data-id='"+data.kid+"' data-img='' data-source='"+data.articleid+"'>收藏</a ></li>";
				
                if (data.status_code == 0) {

                    layer.closeAll();

                    layer.msg('创建成功',{skin: 'intro-login-class layui-layer-hui'})
                    $('.collection_to ul').append(str);

                } else {

                    //alert(data.message);

                    $('#error_msg').html(data.message);

                }

            }

        });

    });





    $(".add_finder_btn").click(function () {

        var that = $(this)

        var user_finder_folder_id = $(this).attr('data-id');

        var title = $(this).attr('data-title');

        var photo_url = $(this).attr('data-img');

        var photo_source = $(this).attr('data-source');

        if (photo_url == '') {

            photo_url = $("#imageUrlJs").val();

        }

        if (title == '') {

            title = $("#imgtitle").val();

        }

        $.ajax({

            url: '/vip/add_finder',

            type: 'POST',

            dataType: 'json',

            data: {

                _token:_token,

                user_finder_folder_id:user_finder_folder_id,

                title:title,

                photo_url:photo_url,

                photo_source:photo_source

            },

            success: function (data) {

                if (data.status_code == 0) {

                    layer.msg('收藏成功',{skin: 'intro-login-class layui-layer-hui'})

                    that.text('已收藏')

                    that.removeClass('Button2')

                    that.addClass('Button')

                    that.addClass('have-disalbed')

                } else {

                    layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})

                }

            }

        });

    });





</script>

<!-- 百度统计 -->
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?e08f2882130cf549fbb9a83c44451dca";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<!-- 百度统计结束 -->

</html>








