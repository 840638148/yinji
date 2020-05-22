<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN"><!--<![endif]-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <title>印际 — 忘记密码</title>

    <style type="text/css">
        body.login div#login h1 a {-webkit-background-size: 85px 85px;background-size: 85px 85px;width: 85px;height: 85px;}
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
    <h2>找回密码</h2>
    <form name="registerform" id="step1" class="" action="/user/forgot_password"  method="post" novalidate="">
        <p style='position:relative;'>
            <label for="user_phone">
                <input type="tel" name="user_phone" maxlength='11' id="user_phone" class="input" value="" size="20" onkeyup="checkIsPhone(event)" placeholder="输入手机号">
                <span class="click_email" style="position: absolute;right: 9px;top: 0;width: 105px;height: 50px;background: #3f9cd2;line-height: 50px;text-align: center;border-radius: 5px;color: #fff;font-weight: 100;">邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱</span>
                <input style="display:none;" type="email" name="user_email" id="user_email" class="input" value="" size="20" onkeyup="checkIsPhone(event)" placeholder="输入邮箱">
                <span style="display:none;position: absolute;right: 9px;top: 0;width: 105px;height: 50px;background: #3f9cd2;line-height: 50px;text-align: center;border-radius: 5px;color: #fff;font-weight: 100;" class="click_phone">手&nbsp;机&nbsp;号</span>

            </label>
        </p>
        <p>
            <label class='code_tel' for="verification_code" style="position:relative">
                <input type="text" name="verification_code" id="verification_code" class="input" value="" size="20" placeholder="输入验证码">
                <input name="发送验证码" type="button" value="获取验证码" class="verification">
            </label>

            <label class='code_email' for="verification_code" style="position:relative;display:none;">
                <input type="email" name="verification_code_email" id="verification_code_email" class="input" value="" size="20" placeholder="输入邮箱验证码">
                <input style="padding:0 19px;position: absolute;right:8px;width:104px;height:50px;border-radius:5px;border:none;background:#d6d6d6;color: #666;" name="发送验证码" type="button" value="获取验证码" class="verification_email">
            </label>
        </p>
        <p class="forgetmenot">验证码将会以短信形式发送至您手机</p>

        <p>
            <label for="pass1">
                <input type="password" name="pass1" id="pass1" class="input" value="" size="20" placeholder="新密码">
            </label>
        </p>

        <p>
            <label for="pass2">
                <input type="password" name="pass2" id="pass2" class="input" value="" size="20" placeholder="确认新密码">
            </label>
        </p>

        <input type="hidden" name="redirect_to" value="">
        <p class="submit">
            <button type="button" name="wp-submit" id="wp-submit-1" class="button button-primary button-large">确定</button>
        </p>
    </form>
    </form>
    <p class="nav">

    </p>
    <p class="backtoblog">
        <a href="/"> ← 返回到印际 </a>
    </p>

</div>

<script type="text/javascript">
//手机邮箱切换
$('.click_email').click(function () {
    $(this).css('display','none');
    $('#user_phone').css('display','none');
    $('#user_email').css('display','block');
    $('.click_phone').css('display','block');
    $('.code_tel').css('display','none');
    $('.code_email').css('display','block');
    $('.forgetmenot').html('验证码将会以短信形式发送至您邮箱');
})

$('.click_phone').click(function () {
    $('.verification_email').css('right','8px')
    $(this).css('display','none');
    $('#user_phone').css('display','block');
    $('#user_email').css('display','none');
    $('.click_phone').css('display','none');
    $('.click_email').css('display','block');
    $('.code_tel').css('display','block');
    $('.code_email').css('display','none');
    $('.forgetmenot').html('验证码将会以短信形式发送至您手机');
})

$('.verification_email').click(function () {
    let email = $('#user_email').val();
    let emailzz = /^([A-Za-z0-9_+-.])+@([A-Za-z0-9\-.])+\.([A-Za-z]{2,22})$/;
    if(email!='' && email != null && email != undefined){
        if(!emailzz.test(email)){
        layer.msg('邮箱格式错误',{time: 1500,skin: 'intro-login-class layui-layer-hui'});
        return false;
        }
    }
    $.ajax({
        url: '/user/forget_email_code',
        type: 'POST',
        dataType: 'json',
        data: {email: email, _token: "{{csrf_token()}}"},
        success: function (data) {
            //console.log(data.status_code);
            if (data.status_code == 0) {
                layer.msg(data.message,{time:1500,skin: 'intro-login-class layui-layer-hui'});
            } else {
                layer.msg(data.message,{time:1500,skin: 'intro-login-class layui-layer-hui'});
            }
        }
    });
})



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
        let mobile = $.trim($('#user_phone').val());
        let verification_code = $.trim($('#verification_code').val());
        let verification_code_email = $.trim($('#verification_code_email').val());
        let email = $('#user_email').val();
        let emailzz = /^([A-Za-z0-9_+-.])+@([A-Za-z0-9\-.])+\.([A-Za-z]{2,22})$/;
        if(mobile!='' && mobile != null && mobile != undefined){
            if (!/1[3-8][0-9]{9}/.test(mobile)) {
                layer.msg('请输入正确手机号');
                return false;
            }
        }
        if(email!='' && email != null && email != undefined){
            if(!emailzz.test(email)){
            layer.msg('邮箱格式错误',{time: 1500,skin: 'intro-login-class layui-layer-hui'});
            return false;
            }
        }
        let pass1 = $.trim($('#pass1').val());
        let pass2 = $.trim($('#pass2').val());
        if (pass1 != pass2) {
            layer.msg('输入的两次密码不同！');
            return false;
        }
        $.ajax({
            url: '/user/reset_password',
            type: 'POST',
            dataType: 'json',
            data: {
                user_phone: mobile,
                email: email,
                verification_code: verification_code,
                verification_code_email: verification_code_email,
                pass1: pass1,
                pass2: pass2,
                _token: "{{csrf_token()}}",
            },
            success: function (data) {
                //console.log(data.status_code);
                if (data.status_code == 0) {
                    layer.msg(data.message,{time:1500,skin: 'intro-login-class layui-layer-hui'});
                    // $("#userphone").val(mobile);
                    window.location.href="/";
                } else {
                    layer.msg(data.message,{time:1500,skin: 'intro-login-class layui-layer-hui'});
                }
            }
        });
    });
    
</script>


</body>
</html>