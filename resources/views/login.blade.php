<!DOCTYPE html>
<!-- saved from url=(0052)http://yinji.nenyes.com/wp-login.php?redirect_to=%2F -->
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<!--<![endif]-->

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>{{trans('comm.yinji')}} — {{trans('login.login')}}</title>
<link href="/css/login_new.css" rel="stylesheet" type="text/css">
<script src="/js/jquery-1.10.1.min.js"></script>
<script src="/js/layer.js"></script>
<link rel="stylesheet" href="/css/layer.css" id="layuicss-layer">
</head>
<body class="login" >
<div id="login" style="height:530px;"> 
  <!-- 登陸 -->

  <div class="wxlogin">
    <h1><a href="/" title="{{trans('comm.yinji')}}" tabindex="-1">{{trans('comm.yinji')}}</a></h1>
    <!-- <h2>微信扫码登陆</h2> -->
    <p><iframe frameborder="0" scrolling="no" width="300" height="395" src="/auth/weixin"></iframe></p>
    <div class="login_ico"><a href="javascript:void(0);" onclick="WeChatLogin();"><img src="/img/diannao_03.gif" width="51" height="51" alt="账号登陆"></a></div>
  </div>

  <div class="ma_box hide" style='top:165px;padding-top:0;height:400px;'>
    <div class="login_ico" style='position: absolute;top: -160px;right: 5px;'><a href="javascript:void(0);" onclick="WeChatLogin();"><img src="/img/erweima.gif" width="51" height="51" alt="账号登陆"></a></div>
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

  <p class="fl backtoblog" style='float:left;margin-top:0;'> <a href="/"> ← {{trans('login.return')}} </a> </p>
  <p id="nav" class="nav fr" style='margin-top:0;'> <a href="/user/register">{{trans('login.register')}}</a> | <a href="/user/forgot_password">{{trans('login.forgot_password')}}</a> </p>
  <!--VIP专栏提示-->
  <div class="vip_prompt hide modal" id="vip-img">
    <a href="/vip_page" class="vip_buy">开通VIP会员</a><a href="/vip_page" class="vip_detail">了解VIP详情&gt;&gt;</a>
  </div>

  
  <!--VIP专栏提示结束--> 
  <script type="text/javascript">
    function WeChatLogin() {
      if($(".ma_box").hasClass("hide")) {
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
              if(data.status_code == 0) {
                  setTimeout(function () {
                      location.href = data.data.url;
                  }, 300);
              }else{
                  layer.msg(data.message);
              }
          }
        });
    });

    wp_attempt_focus();
    if (typeof wpOnload == 'function') wpOnload();
  </script> 
</div>

<style type="text/css">
  body.login div#login h1 a {-webkit-background-size: 85px 85px;background-size: 85px 85px;width: 85px;height: 85px;}
  .impowerBox .qrcode {width: 250px !important;}
  .impowerBox .title {text-align: center;font-size: 30px !important; }
</style>

</body>
</html>