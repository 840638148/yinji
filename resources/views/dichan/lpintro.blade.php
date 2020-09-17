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

    <title>{{trans('comm.yinji')}} - 地产公司介绍</title>
    
    <script src="/js/jquery-1.10.1.min.js"></script>
    <meta name="verification" content="@yield('seo_verification')" />
    <meta name="description" content="@yield('seo_description')" />
    <meta name="keywords" content="@yield('seo_keywords')" />
    
    <script src="/js/layer.js"></script>
    <link href="/css/layer.css" rel="stylesheet">
    <link href="/css/main.css" rel="stylesheet" type="text/css">
    <link href="/css/response.css" rel="stylesheet" type="text/css">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <script type="text/javascript" src="/js/mouse.js"></script>
    <link href="/css/index_css.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="/js/main.js"></script>
    <link rel="stylesheet" href="/css/swiper-bundle.min.css">
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
        .menu li{width:95px;}
        .phc_head_menu li .top_nav_link{width:100px;}
        .nav_search_box {width: 753px;}
        .nav_search_box_close {left: 0px;}
        .search_frame {width: 93%;margin: 12px 4%;}
        .search_keyword {width: 695px;left: 30px;}

        .pingfen{position: absolute;color:#000;}
        .comments{display:none;width:880px;height:250px;background:#fff;position: relative;top: -500px;left: 20%;}
        .But img.bq {float: right;margin-right: 20px;position: absolute;right: 150px;bottom: 0px;}
        .But span.submitcomment {width: 120px;height: 36px;background: #333;display: block;float: right;line-height: 36px;cursor: pointer;color: #fff;font-size: 12px;text-align: center;font-family: "微软雅黑";}
        .message{width: 90%;overflow: auto;float: left;height: 100px;margin: 0px 44px;padding: 10px;outline: none;border: 1px solid #eee;}
        .But{width:120px;height: 36px;background: #636af3;line-height: 28px;cursor: pointer;color: #fff;font-size: 12px;text-align: center;font-family: "微软雅黑";float: right;margin-right: 44px;margin-top: 10px;}
        .closecomment{position: absolute;top: 0px;right: 20px;width: 16px;height: 16px;background: url(/images/close.jpg) no-repeat;cursor: pointer;text-indent: -99999px;border:none;}
        .But .face {width: 390px;height: 180px;background: #fff;padding: 10px;border: 1px solid #ddd;box-shadow: 2px 2px 3px #666;position: absolute;top:-11px;right: 45px;display: none;}
        .But .face ul li {width: 22px;height: 22px;list-style-type: none;float: left;margin: 2px;cursor: pointer;}
        .modal{display:none;}
        .modal-header {padding: 15px;border-bottom: 1px solid #e5e5e5;}
        .modal-body {position: relative;padding: 15px;}
        .lzcfg{background: rgba(0,0,0,0.5);position: fixed;left: 0px;top: 0px;width: 100%;height: 100%;display: none;z-index: 999;}
        .have-disalbed{height:36px;line-height:36px;cursor:not-allowed !important;}
        .huxing{width:60% !important;z-index:100;left:0;height:auto !important;right:0;margin:0 auto;}
        .huxing ul{width:100% !important;}
        .huxing li{margin:0 auto;}
        .swiper-slide{background:unset !important;}
    </style>
  <style>
    html,
    body {
      position: relative;
      height: 100%;
    }

    body {
      background: #eee;
      font-family: Helvetica Neue, Helvetica, Arial, sans-serif;
      font-size: 14px;
      color: #000;
      margin: 0;
      padding: 0;
    }

    .swiper-container {
      width: 100%;
      height: 100%;
    }

    .swiper-slide {
      text-align: center;
      font-size: 18px;
      background: #fff;

      /* Center slide text vertically */
      display: -webkit-box;
      display: -ms-flexbox;
      display: -webkit-flex;
      display: flex;
      -webkit-box-pack: center;
      -ms-flex-pack: center;
      -webkit-justify-content: center;
      justify-content: center;
      -webkit-box-align: center;
      -ms-flex-align: center;
      -webkit-align-items: center;
      align-items: center;
    }

    @media (max-width: 760px) {
      .swiper-button-next {
        right: 20px;
        transform: rotate(90deg);
      }

      .swiper-button-prev {
        left: 20px;
        transform: rotate(90deg);
      }
    }
  </style>
</head>


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
        <h1 style='width:155px;border-right:1px solid rgba(255,255,255,.3);'> <a href="/" class="logo left" title="{{trans('comm.yinji')}}-发现全球设计之美"><img style='margin-top:18px;' src="/images/logo.png" alt="{{trans('comm.yinji')}}"></a> </h1>

        <!--导航条右边-->
        <div class="header-menu  right">
            <ul class="menu">
                <li class="menu-item menu-item-search iphone_menu" style="border-left: 1px solid #fff; border-left-color: rgba(255,255,255,.3);" ><a href="#" title="导航"><i class="icon-list-bullet"></i></a> 
                    <ul class="sub-menu">
                        <li> <a href="/"> 首页</a> </li>
                        <li> <a href="/news"> 新闻</a> </li>
                        <li> <a href="/interior"> 室内</a> </li>
                        <li> <a href="/archs"> 建筑</a> </li>
                        <li> <a href="/dichan"> 地产</a> </li>
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
                      <li> <a href="/user/logout" title="登出"> {{trans('index.sign_out')}} </a> </li>
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
            </ul>
        </div>

        <!-- 全站搜索框 -->
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

        <!-- 中英文切换导航条 -->
        <div class="header-menu right phc_head_menu">
            <ul class="menu">
                <!-- <li id="menu-item-2637" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-2637"> 
                    <a href="/" class="top_nav_link" style='width:95px;'>
                        <div class="cube_container">
                            <div class="backer">Home</div>
                            <div class="front">首页</div>
                        </div>
                    </a> 
                </li> -->

                <li id="menu-item-2674" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2674"> 
                    <a href="/news" class="top_nav_link" style='width:95px;'>
                        <div class="cube_container">
                            <div class="backer">News</div>
                            <div class="front">新闻</div>
                        </div>
                    </a> 
                </li>

                <li id="menu-item-2638" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2638"> 
                    <a href="/interior" class="top_nav_link" style='width:95px;'>
                        <div class="cube_container">
                            <div class="backer">Interiors</div>
                            <div class="front">室内</div>
                        </div>
                    </a> 
                </li>
                
                <li id="menu-item-2673" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2673"> 
                    <a href="/archs" class="top_nav_link" style='width:95px;'>
                        <div class="cube_container">
                            <div class="backer">Architecture</div>
                            <div class="front">建筑</div>
                        </div>
                    </a> 
                </li>

                <li id="menu-item-2670" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2670"> 
                    <a href="/develop" class="top_nav_link" style='width:95px;'>
                        <div class="cube_container">
                            <div class="backer">Develop</div>
                            <div class="front">地产</div>
                        </div>
                    </a> 
                </li>

                <li id="menu-item-2676" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-2676"> 
                    <a href="/designer" class="top_nav_link" style='width:95px;'>
                        <div class="cube_container">
                            <div class="backer">Designers</div>
                            <div class="front">设计师</div>
                        </div>
                    </a> 
                </li>


                <li id="menu-item-17508" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17508"> 
                    <a href="/finder" class="top_nav_link" style='width:95px;'>
                        <div class="cube_container">
                            <div class="backer">Finder</div>
                            <div class="front">发现</div>
                        </div>
                    </a> 
                </li>

                <li id="menu-item-17509" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17509"> 
                    <a href="/job" class="top_nav_link" style='width:95px;'>
                        <div class="cube_container">
                            <div class="backer">Jobs</div>
                            <div class="front">工作</div>
                        </div>
                    </a> 
                </li>

                <li  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17509"> 
                    <a href="/vip/promotion" class="top_nav_link" style='width:95px;'>
                        <div class="cube_container">
                            <div class="backer">Cooperate</div>
                            <div class="front">合作</div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>

    </nav>
    <!--菜单end-->
    </section>
  </section>
</header>



<!-- 搜索 -->
<article class="search popup" id="search" style="display:none">
    <h3><i class="icon-search-1"></i>按文章类型进行搜索</h3>
    <form method="get" class="search_form" action="http://yinji.nenyes.com">
        <select name="post_type" class="search_type">
            <option value="post">文章</option>
            <option value="arch">建筑</option>
            <option value="concept">概念</option>
            <option value="ffe">家具</option>
            <option value="designer">设计师</option>
            <option value="photographer">摄影师</option>
            <option value="product">产品</option>
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
                }else{
                    layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
                }
            }
        });



        // $('.hot-search').find('dd').

    })

</script>


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
        var source = $(this).attr('data-source');
        let is_sc=1;
        console.log(photo_source);
        if(photo_url == '') {
            photo_url = $("#imageUrlJs").val();
        }

        if (title == '') {
            title = $("#imgtitle").val();
        }

        $.ajax({
            url: '/vip/finder_collect',
            type: 'POST',
            dataType: 'json',
            data: {
                _token:_token,
                user_finder_folder_id:user_finder_folder_id,
                title:title,
                photo_url:photo_url,
                source:source,
                is_sc:is_sc,
            },
            success: function (data) {
                if (data.status_code == 0) {
                    layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
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



<div class="lzcfg"></div>
<section class="section-wrap">
    <div class="section section-1" style="background:url(/uploads/{{$lists->bgimg}}) top center">
        <div class="title">
            <div class="titles"><img src="/uploads/{{$lists->logoimg}}" alt="地产详情LOGO"></div>
            <div class=" loupan_js waper_box">
                <h1>{{$lists->name}}</h1>
                <h3>{!!$lists->intro!!}</h3>
            </div>
        </div>
    </div>

    <div class="section section-2" >
        <div class="title">
            <div class="titles">设计团队 <p>DESIGN TEAM</p></div>
            <div class="Div1">
                <b class="Div1_prev Div1_prev1" ><img src="/images/l-btn.png" title="上一页" /></b> <b class="Div1_next Div1_next1" ><img src="/images/r-btn.png"  title="下一页"/></b>
                <div class="Div1_main">
                    <div class="design">
                        <ul>
                        @foreach($designer as $designers)
                        <li><a href="/designer/{{$designers->static_url}}" target='_blank'><img src="/uploads/{{$designers->special_photo}}" /></a></li>
                        <!-- <li><img src="https://www.yinjispace.com/uploads/public/photo/images/special_photo//6b5cb3be5767f5dae9fe0308ca92de15.jpg" /></li> -->
                        <!-- <li><img src="https://www.yinjispace.com/uploads/public/photo/images/special_photo//b1f47d6954825125a6a15f2310ec598f.jpg" /></li> -->
                        @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div> 

    @if($lists->jz_display)
    @foreach($jz as $v)
    <div class="section section-3">
        <div class="section-3bj"  style=" background:url({{get_article_thum($v)}}) no-repeat;background-size:100%100%;"></div>
        <div class="title">
            <div class="titles" >建筑设计 <p>Marketing Center</p> </div>
            <div class="interior_dafen" style='position: relative;left: -555px;top: 445px;'><span class='dcpf'>{{$v->article_avg?sprintf("%.1f",$v->article_avg):'5.0'}}</span></div>
            <div class="wenjiang" >
                <div class="wenjiang_img" ><img style='height:387px;' src="{{get_article_thum($v)}}" alt="{{get_article_title($v)}}"></div>
                <div class="wenjiang_neirong">
                    <h2>{{get_article_title($v)}}</h2>
                    <ul class="mt20">
                    <li>
                        <div class="atar_Show">
                            <p tip='{{$v->article_avg?sprintf("%.1f",$v->article_avg):"5.0"}}' style="width: 144px;margin-top: 0;"></p>
                        </div>
                        <span>&nbsp;&nbsp;{{$v->article_avg?sprintf("%.1f",$v->article_avg):"5.0"}}分</span>
                    </li>
                    </ul>
                    <p style='max-height:150px;width: 500px;overflow: hidden;'>{{get_article_description($v)}}</p>
                    <div class="wenjiang_more"> <a target="_blank" href="/article/{{$v->static_url}}" target='_blank'>Learn more →</a></div>
                    <div class="" style="right:0; bottom:0; position:absolute; color:#999; font-size:16px;"><i class="icon-eye"></i> {{$v->view_num}}</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif

    @if($lists->yxzx_display)
    @foreach($yxzx as $v)
    <div class="section section-4">
        <div class="section-3bj"  style=" background:url({{get_article_thum($v)}}) no-repeat;background-size:100%100%;"></div>
        <div class="title">
            <div class="titles">样板房<p> Residential </p></div>
            <div class="interior_dafen" style='position: relative;left: -555px;top: 445px;'><span class='dcpf'>{{sprintf("%.1f",$v->article_avg)}}</span></div>
            <div class="wenjiang" style="background-color:#333">
                <div class="wenjiang_img" ><img style='height:387px;' src="{{get_article_thum($v)}}" alt="{{get_article_title($v)}}"> </div>
                <div class="wenjiang_neirong">
                    <h2 style="color:#ccc">{{get_article_title($v)}}</h2>
                    <p style='max-height:90px;width: 500px;overflow: hidden;'>{{get_article_description($v)}}</p>
                    <div class="Residential_ico">
                        <a href="javascript:;" class="icon-heart-1" score='{{$v->id}}'>Score</a>
                        <a href="javascript:;"  class="icon-bookmark" article_id='{{$v->id}}'>Collection </a>
                        <a href="javascript:;" class="icon-download" article_id='{{$v->id}}'>download</a>
                    </div>
                    <div class="wenjiang_more">  <a target="_blank" href="/article/{{$v->static_url}}">Learn more →</a></div>
                    <div class="" style="right:0; bottom:0; position:absolute; color:#999; font-size:16px;"><i class="icon-eye"></i> {{$v->view_num}}</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif

    @if($lists->gq_display)
    @foreach($gq as $v)
    <div class="section section-5">
        <div class="section-3bj"  style=" background:url({{get_article_thum($v)}}) no-repeat;background-size:100%100%;"></div>
        <div class="title">
            <div class="titles">样板房<p> Residential </p></div>
            <div class="interior_dafen" style='position: relative;left: -555px;top: 445px;'><span class='dcpf'>{{$v->article_avg?sprintf("%.1f",$v->article_avg):'5.0'}}</span></div>
            <div class="wenjiang" style="background-color:#333">
                <div class="wenjiang_img" ><img style='height:387px;' src="{{get_article_thum($v)}}" alt="{{get_article_title($v)}}"> </div>
                <div class="wenjiang_neirong">
                    <h2 style="color:#ccc">{{get_article_title($v)}}</h2>
                    <p style='max-height:90px;width: 500px;overflow: hidden;'>{{get_article_description($v)}}</p>
                    <div class="Residential_ico">
                        <a href="javascript:;" class="icon-heart-1" score='{{$v->id}}'>Score</a>
                        <a href="javascript:;"  class="icon-bookmark" article_id='{{$v->id}}'>Collection </a>
                        <a href="javascript:;" class="icon-download" article_id='{{$v->id}}'>download</a>
                    </div>
                    <div class="wenjiang_more">  <a target="_blank" href="/article/{{$v->static_url}}">Learn more →</a></div>
                    <div class="" style="right:0; bottom:0; position:absolute; color:#999; font-size:16px;"><i class="icon-eye"></i> {{$v->view_num}}</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif

    @if($lists->ybf_display)
    @foreach($ybf as $v)
    <div class="section section-6">
        <div class="section-3bj"  style=" background:url({{get_article_thum($v)}}) no-repeat;background-size:100%100%;"></div>
        <div class="title">
            <div class="titles">样板房<p> Residential </p></div>
            <div class="interior_dafen" style='position: relative;left: -555px;top: 445px;'><span class='dcpf'>{{$v->article_avg?sprintf("%.1f",$v->article_avg):'5.0'}}</span></div>
            <div class="wenjiang" style="background-color:#333">
                <div class="wenjiang_img" ><img style='height:387px;' src="{{get_article_thum($v)}}" alt="{{get_article_title($v)}}"> </div>
                <div class="wenjiang_neirong">
                    <h2 style="color:#ccc">{{get_article_title($v)}}</h2>
                    <p style='max-height:90px;width: 500px;overflow: hidden;'>{{get_article_description($v)}}</p>
                    <div class="Residential_ico">
                        <a href="javascript:;" class="icon-heart-1" score='{{$v->id}}'>Score</a>
                        <a href="javascript:;"  class="icon-bookmark" article_id='{{$v->id}}'>Collection </a>
                        <a href="javascript:;" class="icon-download" article_id='{{$v->id}}'>download</a>
                    </div>
                    <div class="wenjiang_more">  <a target="_blank" href="/article/{{$v->static_url}}">Learn more →</a></div>
                    <div class="" style="right:0; bottom:0; position:absolute; color:#999; font-size:16px;"><i class="icon-eye"></i> {{$v->view_num}}</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif

    @if($lists->yl_display)
    @foreach($yl as $v)
    <div class="section section-6">
        <div class="section-3bj"  style=" background:url({{get_article_thum($v)}}) no-repeat;background-size:100%100%;"></div>
        <div class="title">
            <div class="titles">园林<p> Residential </p></div>
            <div class="interior_dafen" style='position: relative;left: -555px;top: 445px;'><span class='dcpf'>{{$v->article_avg?sprintf("%.1f",$v->article_avg):'5.0'}}</span></div>
            <div class="wenjiang" style="background-color:#333">
                <div class="wenjiang_img" ><img style='height:387px;' src="{{get_article_thum($v)}}" alt="文章封面"> </div>
                <div class="wenjiang_neirong">
                    <h2 style="color:#ccc">{{get_article_title($v)}}</h2>
                    <p style='max-height:90px;width: 500px;overflow: hidden;'>{{get_article_description($v)}}</p>
                    <div class="Residential_ico">
                        <a href="javascript:;" class="icon-heart-1" score='{{$v->id}}'>Score</a>
                        <a href="javascript:;"  class="icon-bookmark" article_id='{{$v->id}}'>Collection </a>
                        <a href="javascript:;" class="icon-download" article_id='{{$v->id}}'>download</a>
                    </div>
                    <div class="wenjiang_more">  <a target="_blank" href="/article/{{$v->static_url}}">Learn more →</a></div>
                    <div class="" style="right:0; bottom:0; position:absolute; color:#999; font-size:16px;"><i class="icon-eye"></i> {{$v->view_num}}</div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
    @if($lists->hxt_display)
    
    <div class="section section-7">
        <div class="title">
            <div class="titles ">户型图<p> House type </p></div>
        </div>

        <div class="huxing swiper-container">
            <ul class="swiper-wrapper">
                @foreach ($lists->hxtimg as $v)
                <li class="swiper-slide"><img class="thumb" src="/uploads/{{$v}}" style="display: block;"> </a></li>
                @endforeach
            </ul>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
        <!-- <b class="huxing_prev" ><img src="/images/l-btn.png" title="上一页" /></b> <b class="huxing_next" ><img src="/images/r-btn.png"  title="下一页"/></b> -->
    </div>
    
    @endif

</section>

<ul class="section-btn">
    <li class="on"></li>
    <li></li>
    @if($lists->jz_display) @foreach($jz as $v)<li></li>@endforeach @endif
    @if($lists->yxzx_display) @foreach($yxzx as $v)<li></li>@endforeach @endif
    @if($lists->gq_display) @foreach($gq as $v)<li></li>@endforeach @endif
    @if($lists->ybf_display) @foreach($ybf as $v)<li></li>@endforeach @endif
    @if($lists->yl_display) @foreach($yl as $v)<li></li>@endforeach @endif
    @if($lists->hxt_display) <li></li> @endif
</ul>

<div class="arrow">&laquo;</div>
</div>

    <!-- 下载提示框 -->
    <div class="down-load-tip" style='min-width:271px;background:#d4cccc;color:#060606;left:800px;top: 644px;'>
        <!-- <div class="down-jiantou"></div> -->
        <p class='down_con' style="height: 30px">今日剩余免费下载次数：<span id="left_down_num">0</span>次</p>
        <p style="text-align: center;padding: 0 15px"> <span style="padding: 0 15px">下载: </span><a style="color: #428bca" href="" target="_blank" >链接</a> <span style='position: relative;padding: 0 15px;'>提取码：<input title='点我复制' class='copybtn' style='padding: 0 5px 0;background:#d6d6d6;border-radius: 5px;cursor: pointer;border:none;width:50px;height:20px;' onclick="copybtn(this)" readonly value=''></span>
        </p>
    </div>
    <!-- 下载提示框结束 -->

    <!-- 登录 -->
    <div class="login_box" style="display:none;">
        <div class="new_folder_bj"></div>
            <div class="login_folder">
                <div id="login" class="login" style='height:640px;'> 
    
                    <div class="wxlogin">
                        <h1><a href="/" title="{{trans('comm.yinji')}}" tabindex="-1">{{trans('comm.yinji')}}</a></h1>
                        <!-- <h2>微信扫码登陆</h2> -->
                        <p><iframe frameborder="0" scrolling="no" width="300" height="395" src="/auth/weixin"></iframe></p>
                        <div class="login_ico"><a href="javascript:void(0);" onclick="WeChatLogin();"><img src="/img/diannao_03.gif" width="51" height="51" alt="账号登陆"></a></div>
                    </div>


                    <!-- 登陸 -->
                    <div class="ma_box hide" style='top:207px;padding-top:0;height:380px;'>
                        <div class="login_ico" style='position: absolute;top:-202px;right: 5px;'><a href="javascript:void(0);" onclick="WeChatLogin();"><img src="/img/erweima.gif" width="51" height="51" alt="账号登陆"></a></div>
                        <h2>{{trans('login.login_title')}}</h2>
                        <form name="loginform" id="loginform" action="/user/login" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
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
                            <p class="forgetmenot" style='text-align:center;width: 316px;'>
                                <label for="rememberme">
                                    <input name="rememberme" type="checkbox" id="rememberme" value="forever">{{trans('login.remember_me')}} 
                                </label>
                            </p>
                            <p class="submit">
                                <input type="button" name="wp-submit" id="wp-submit-login" class="button button-primary button-large" value="{{trans('login.login')}}">
                                <input type="hidden" name="redirect_to" value="/user/index">
                                <input type="hidden" name="testcookie" value="1">
                            </p>
                        </form>
                    </div>
                    <div class='lgbtm' style='height:50px;margin-top: -16px;'>
                        <p id="nav" class="fr" style='margin-top:0;'><a href="/user/register">{{trans('login.register')}}</a> | <a href="/user/forgot_password">{{trans('login.forgot_password')}}</a></p>
                        <p class="fl" style='margin-top:0;'> <a href="/"> ← {{trans('login.return')}} </a> </p>
                    </div>
                    
                
                </div>
            </div>
        </div>
    </div>
    <!--登陆结束--> 

    <!-- 评分 -->
    <div class="comments">
        <div class="pingfen">
            <p style='font-size: 16px;width: 90%;margin: 0 auto 20px;'>{{trans('article.comments')}}<button type="button" class="closecomment">&times;</button></p>
            <div id="startone" class="block clearfix" style='padding-left: 44px;'>
                <div class="star_score"></div>
                <p style="float:left;">{{trans('article.your_score')}}：<span class="fenshu"></span> {{trans('article.score')}}</p>
                <div class="attitude"></div>
            </div>
            <div class="message" contentEditable='true'></div>
            <div class="But"> 
                <span class='submitcomment' data-comment-type="article">{{trans('article.published')}}</span> <img src="/images/qq/ico-biaoqing.png" class='bq'/> 
                <p style=" color:#ccc;position: absolute;left: 36px;">（{{trans('article.optional')}}）</p>         
                    <!--face begin--> 
                    @component('face')
                    
                    @endcomponent 
                    <!--face end--> 
            </div>
        </div>
    </div>

    <!-- 评分end -->


    <!-- 收藏的模态框（Modal） -->
    <div class="modal fade" id="collectFolder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style='border:none;'>&times;</button>
                    <h4 class="modal-title" id="myModalLabel">请选择收藏文件夹</h4>
                </div>
                <div class="modal-body">
                    <div class="new-collect">
                        <label>新建：</label>
                        <input type="text" id="folder_name" name="folder_name" value="" />
                        <a href="javascript:;" class="Button2 fr collect_article">收藏</a>
                    </div>

                    <div class="collection_to">
                        <ul class="discover-folders2">
                            @foreach($user_collect_folders as  $value)
                                @if($value['iscollects']=='1')
                                <li>
                                    <h3>{{$value['name']}}</h3>
                                    <span floder_id="{{$value['id']}}" class="folderattr null" title="{{$value['name']}}"></span>
                                    <a href="javascript:void(0);" class="Button fr have-disalbed" data-id="{{$value['id']}}">已收藏</a>
                                </li>
                                @else
                                <li>
                                    <h3>{{$value['name']}}</h3>
                                    <span floder_id="{{$value['id']}}" class="folderattr null" title="{{$value['name']}}"></span>
                                    <a href="javascript:void(0);" class="Button2 fr collect_article" data-id="{{$value['id']}}">收藏</a>
                                </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 收藏end -->
</body>
</html>
<!-- 户型图轮播图 -->
<script src="/js/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
      slidesPerView: 3,
      direction: getDirection(),
      spaceBetween:20,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      on: {
        resize: function () {
          swiper.changeDirection(getDirection());
        }
      }
    });
    function getDirection() {
      var windowWidth = window.innerWidth;
      var direction = window.innerWidth <= 1200 ? 'vertical' : 'horizontal';

      return direction;
    }
</script>
<!-- 户型图轮播图end -->
<script type="text/javascript">
    //自定义轮播图
    $(function(){
        $('.section').each(function(index, obj){
            $(this).attr('class', 'section');
            $(this).addClass('section-' + (parseInt(index) + 1));
        });
    })  

    //提取码复制
    function copybtn(obj){
        let con=document.getElementById("tqmm");
        obj.select(); // 选择对象
        document.execCommand("Copy"); // 执行浏览器复制命令
        // console.log(con);
        layer.msg('复制成功',{time: 1500,skin: 'intro-login-class layui-layer-hui'});
    }

    //下载
    $('.icon-download').click(function(e){
        let article_id=$(this).attr('article_id');
        if(!IS_LOGIN){
            $('.login_box').show();
        }else{
            $.ajax({
                url: '/article/vip_download',
                type: 'POST',
                dataType: 'json',
                data: {_token:'{{csrf_token()}}',article_id:article_id},
                success: function (data) {
                    if(data.status_code == 100) {
                        $('.down-load-tip').show()
                        $('.down-load-tip').find('a').attr('href',data.message.vip_download)
                        $('.down-load-tip').find('input').val(data.message.vip_download.substr(-4))
                        $('.down_con').html(data.message.leftkou)
                    }else if(data.status_code == 999){
                        layer.msg(data.message,{time:2000,skin: 'intro-login-class layui-layer-hui'})
                    }else{
                        $('.down-load-tip').show();
                        $('.down-load-tip').html(data.message);
                    }
                }
            });
        }
    });
    
    // 点击其他地方,关闭下载弹窗
    $("body").click(function(e) {
        if(!$(e.target).closest(".icon-download,.down-load-tip").length) {
            $(".down-load-tip").slideUp();
        }
    });

    // 点击/关闭,评分显示评分框
    $('.icon-heart-1').click(function(){
        if($(".comments").css("display")=="none"){
            $(".comments").show(100);
        }else{
            $(".comments").hide(100);
        }
    });

    //点击发表评分
    $('.submitcomment').click(function(){
        if(!IS_LOGIN){
            $('.login_box').show();
        }else{
            let stars=$('.fenshu').text();
            let comment_id=$('.icon-heart-1').attr('score')
            let comment_type = $(this).attr('data-comment-type');
            let comment=$(".message").html();
            $.ajax({
                url: '/member/comment',
                type: 'POST',
                dataType: 'json',
                data: {comment_id:comment_id,stars:stars,comment_type:comment_type,comment:comment},
                success: function (data) {
                    if (data.status_code == 0) {
                        if(comment==""){
                            layer.msg('评分成功,印币+2',{skin: 'intro-login-class layui-layer-hui'});
                            $(".comments").hide(100);
                        }else{
                            $(".message").html('');
                            layer.msg('评论成功，审核通过后将会显示。',{skin: 'intro-login-class layui-layer-hui'});
                        }
                        
                    } else {
                        layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'});
                    }  
                }
            });
        }
    });

    //点击其他地方关闭评分框
    $('.closecomment').click(function(){
        $('.comments').css('display','none');
    });

    // 点击收藏显示弹窗
    $('.icon-bookmark').click(function(e){
        if(!IS_LOGIN){
            $('.login_box').show();
        }else{
            $('.lzcfg').show();
            $('#collectFolder').show();
            $('#collectFolder').attr('article_id',$(this).attr('article_id'));
        }
    });


    //收藏
    $(".collect_article").click(function(e){
        if(!IS_LOGIN){
            $('.login_box').show();
        }else{
            let that = $(this);
            let collect_id = $('#collectFolder').attr('article_id');//收藏的文章id
            let folder_id = $(this).attr('data-id');//收藏夹id
            let folder_name = $('#folder_name').val();//创建的收藏夹名
            let is_sc = 1;
            // console.log(collect_id)
            $.ajax({
                url: '/article/collect',
                type: 'POST',
                dataType: 'json',
                data: {folder_id:folder_id,folder_name:folder_name,collect_id:collect_id,is_sc:is_sc},
                success: function (data) {
                    // console.log(data.message.message)
                    if (data.status_code == 0) {
                        that.text('已收藏')
                        that.removeClass('Button2')
                        that.addClass('Button')
                        that.addClass('have-disalbed')
                        that.css('hieght','36px')
                    } else {
                        layer.msg(data.message.message,{zIndex:9999999999999,skin: 'intro-login-class layui-layer-hui'});
                    }
                }
            });
        }
    });

    //点击关闭收藏弹窗
    $('.close').click(function(){
        $('#collectFolder').hide();
        $('.lzcfg').hide();
    });

    //点击小图片，显示表情
    $(".bq").click(function(e){
        $(".face").slideDown();//慢慢向下展开
        e.stopPropagation();   //阻止冒泡事件
    });

    //在桌面任意地方点击，他是关闭
    $(document).click(function(){
        $(".face").slideUp();//慢慢向上收
    });

    //点击小图标时，添加功能
    $(".face ul li").click(function(){
        var simg=$(this).find("img").clone();
        $(".message").append(simg);
    });
</script>

{{--显示星星--}}
<script type="text/javascript" src="/js/startScore.js"></script>
<script type="text/javascript">
    scoreFun($("#startone"))
    scoreFun($("#starttwo"),{
        fen_d:16,//每一个a的宽度
        ScoreGrade:5//a的个数 10或者
    })
        
    var num=$('.starsp').attr("tip");
        //显示分数
    $(".show_number li p").each(function(index, element) {
        var num=$(this).attr("tip");
        var www=num*1*16;//
        $(this).css("width",www);
        $(this).parent(".atar_Show").siblings("span").text(num+"分");
    });

</script>
{{--显示星星end--}}

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
{{--登录结束--}}