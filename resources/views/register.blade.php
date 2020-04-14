<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<!--<![endif]-->

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>印际 — 注册新用户</title>
<style type="text/css">
body.login div#login h1 a { -webkit-background-size: 85px 85px; background-size: 85px 85px; width: 85px; height: 85px; }
</style>
<link href="/css/login_new.css" rel="stylesheet" type="text/css">
<script src="/js/jquery-1.10.1.min.js"></script>
<script src="/js/layer.js"></script>
<script src="/js/laravel-sms.js"></script>
<link rel="stylesheet" href="/css/layer.css" id="layuicss-layer">
</head>

<body class="login " style="">
<div id="login">
  <h1><a href="/" title="印际" tabindex="-1">印际</a></h1>
  <h2>注册新用户</h2>
  <form name="registerform" id="step1" class="" action="/user/register"

          method="post" novalidate>
    <p>
      <label for="user_phone">
        <input type="text" name="user_phone" id="user_phone" class="input" value="" size="20"

                       onkeyup="checkIsPhone(event)" placeholder="输入手机号/邮箱">
      </label>
    </p>
    <p>
      <label for="verification_code" style="position:relative">
        <input type="text" name="verification_code" id="verification_code" class="input" value="" size="20"

                       placeholder="输入验证码">
        <input name="发送验证码" type="button" value="获取验证码" class="verification">
      </label>
    </p>
    <p class="forgetmenot">注册验证码将会以短信形式发送至你手机</p>
    <input type="hidden" name="redirect_to" value="">
    <p class="submit">
      <button type="button" name="wp-submit" id="wp-submit-1" class="button button-primary button-large">立即注册 </button>
    </p>
  </form>
  <form class="hide" id="step2" action="/user/register" method="post"

          novalidate="">
    <input type="hidden" class="input" id="userphone" value="" size="20" name="user_phone">
    <p>
      <label for="user_login">
        <input type="text" class="input" value="" id="user_login" name="user_login" size="20"

                       placeholder="用户的昵称。">
      </label>
    </p>
    <p>
      <label for="pass1" style="position:relative">
        <input type="password" class="input" value="" id="pass1" size="20" name="pass1" placeholder="设置密码">
      </label>
    </p>
    <p>
      <label for="pass2">
        <input type="password" class="input" id="pass2" value="" name="pass2" size="20" placeholder="确认密码">
      </label>
    </p>
    
    <input type="hidden" name="redirect_to" value="/">
    <p class="submit">
      <button type="button" name="wp-submit" id="wp-submit-2" class="button button-primary button-large" value=""> 确定 </button>
    </p>
  </form>
</div>
<script type="text/javascript">

    // 判断是否为手机号

    function isPhoneAvailable(phone) {

        var myreg = /^[1][3,4,5,7,8][0-9]{9}$/;

        if (!myreg.test(phone)) {

            return false;

        } else {

            return true;

        }

    }



    //按键抬起时验证是否为手机

    function checkIsPhone(event) {

        var phone = document.getElementById('user_phone').value;

        var verification = document.querySelector('.verification');



        if (isPhoneAvailable(phone)) {

            verification.style.background = '#4091EB';

            verification.style.color = '#FFF';

        } else {

            verification.style.background = '#d6d6d6';

            verification.style.color = '#666';

        }

    }



    function wp_attempt_focus() {

        setTimeout(function () {

            try {

                d = document.getElementById('user_phone');

                d.focus();

                d.select();

            } catch (e) {



            }

        }, 200);

    }



    wp_attempt_focus();

    if (typeof wpOnload == 'function') wpOnload();

    //获取验证码

    var is_sending = false;

    var time_limit = 60;

    var next_time = time_limit;

    var cap_btn = $('.verification');



    cap_btn.sms({

        //laravel csrf token

        token       : "{{csrf_token()}}",

        //请求间隔时间

        interval    : 60,

        //请求参数

        requestData : {

            //手机号

            mobile : function () {

                return $.trim($('#user_phone').val());

            },

            //手机号的检测规则

            mobile_rule : 'mobile_required'

        }

    });





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



    wp_attempt_focus();

    try {

        document.getElementById('user_login').focus();

    } catch (e) {

    }

    if (typeof wpOnload == 'function') wpOnload();



    //step1

    $("#wp-submit-1").click(function () {

        var mobile = $.trim($('#user_phone').val());

        var verification_code = $.trim($('#verification_code').val());

        if (!/1[3-8][0-9]{9}/.test(mobile)) {

            layer.msg('请输入正确手机号');

            return false;

        }

        $.ajax({

            url: '/user/verify_code',

            type: 'POST',

            dataType: 'json',

            data: {

                user_phone: mobile,

                verification_code: verification_code,

                _token: "{{csrf_token()}}",

            },

            success: function (data) {

                //console.log(data.status_code);

                if (data.status_code == 0) {

                    $("#step1").addClass("hide");

                    $("#step2").removeClass("hide");

                    $("#userphone").val(mobile);

                } else {

                    layer.msg(data.message);

                }

            }

        });

    });

    //step2

    $("#wp-submit-2").click(function () {



        var user_phone = $.trim($('#userphone').val());

        var user_login = $.trim($('#user_login').val());

        var pass1 = $.trim($('#pass1').val());

        var pass2 = $.trim($('#pass2').val());

        if (pass1 != pass2) {

            layer.msg('输入的两次密码不同！');

            return false;

        }

        $.ajax({

            url: '/user/register',

            type: 'POST',

            dataType: 'json',

            data: {

                user_phone: user_phone,

                user_login: user_login,

                pass1: pass1,

                pass2: pass2,

                _token: "{{csrf_token()}}",

            },

            success: function (data) {

                //console.log(data.status_code);

                if (data.status_code == 0) {

                    layer.msg(data.message);

                    setTimeout(function () {

                        location.href = "/";

                    }, 300);

                } else {

                    layer.msg(data.message);

                }

            }

        });



    })

    $("#wp-submit-registered").click(function () {

        // var loginform = new FormData();

        var url = $.trim($('#registeredform').attr("action"));



        $.ajax({

            url: url,

            type: 'POST',

            dataType: 'json',

            data: $('#registeredform').serialize(),

            success: function (data) {

                console.log(data);

                //

                if (data.status_code == 0) {

                    layer.msg(data.message);

                    //layer.msg( data.msg, {icon: 1,time: 100000,shade : false});

                    setTimeout(function () {

                        location.href = "/";

                    }, 300);

                } else {

                    layer.msg(data.message);



                }

            }

        });

    })

</script>
</body>
</html>