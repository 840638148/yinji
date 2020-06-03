<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" lang="zh-CN">
<!--<![endif]-->

<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>印际 — 注册新用户</title>
<style type="text/css">
body.login div#login h1 a { -webkit-background-size: 85px 85px; background-size: 85px 85px; width: 85px; height: 85px; }
#user_email,.click_phone{display:none;}
.click_email,.click_phone{
    color: #fff;
    font-size: 14px;
    font-weight: 100;
    position: absolute;
    top: 1px;
    right: 9px;
    padding: 15px 26px;
    background: #1591ec;
    border-radius: 3px;
}

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
  <form name="registerform" id="step1" class="" action="/user/register" method="post" novalidate>
    <p style="position:relative;">
      <label for="user_phone">
        <input type="tel" name="user_phone" maxlength='11' id="user_phone" class="input" value="" size="20" onkeyup="checkIsPhone(event)" placeholder="输入手机号">
        <span class="click_email">邮&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;箱</span>
        <input type="email" name="email" id="user_email" class="input" value="" size="20" onkeyup="checkIsEmail(event)" placeholder="输入邮箱">
        <span style="padding: 15px 27px;" class="click_phone">手&nbsp;机&nbsp;号</span>
      </label>
    </p>
    <p>
      <label class='code_tel' for="verification_code" style="position:relative">
        <input type="text" name="verification_code" id="verification_code" class="input" value="" size="20" placeholder="输入手机验证码">
        <input style="padding: 0 19px;" name="发送验证码" type="button" value="获取验证码" class="verification">
      </label>
      <label class='code_email' for="verification_code" style="position:relative;display:none;">
        <input type="email" name="verification_code_email" id="verification_code_email" class="input" value="" size="20" placeholder="输入邮箱验证码">
        <input style="padding:0 19px;position: absolute;right:8px;width:104px;height:50px;border-radius:5px;border:none;background:#d6d6d6;color: #666;" name="发送验证码" type="button" value="获取验证码" class="verification_email">
      </label>
    </p>
    <p class="forgetmenot">注册验证码将会以短信形式发送至你手机</p>
    <input type="hidden" name="redirect_to" value="">
    <p class="submit">
      <button type="button" name="wp-submit" id="wp-submit-1" class="button button-primary button-large">立即注册 </button>
    </p>
  </form>
  <form class="hide" id="step2" action="/user/register" method="post" novalidate="">
    <input type="hidden" class="input" id="userphone" value="" size="20" name="user_phone">
    <p>
      <label for="user_login">
        <input type="text" class="input" value="" id="user_login" name="user_login" size="20" placeholder="用户的昵称。">
      </label>
    </p>
    <p>
        <select style="width:292px;border: 1px solid #ddd;height: 48px;line-height: 48px;color:#666;border-radius: 5px;" id="zhiwei" name="zhiwei" value="职位">
            <option name="jzs" value="建筑师" >建筑师</option>
            <option name="snsjs" value="室内设计师">室内设计师</option>
            <option name="rzsjs" value="软装设计师">软装设计师</option>
            <option name="cpsjs" value="产品设计师">产品设计师</option>
            <option name="sys" value="摄影师">摄影师</option>
            <option name="mtr" value="媒体人">媒体人</option>
            <option name="fckf" value="地产开发">地产开发</option>
            <option name="qt" value="其他" selected>其他</option>    
        </select>
    </p>
    <p style="padding-left:4px;"> 
        省：<select name='provinces' id="provinces" style="height: 48px;border-radius: 5px;width: 110px;">  <option value="" id="selectpro"  >请选择省份</option></select>  
        市：<select id="citys" name='citys' style="height: 48px;border-radius: 5px;width: 110px;"><option value="">请选择市</option></select> 
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
<script>
$(function() {  
  //页面初始，加载所有的省份  

    $.ajax({  
        type: "post",  
        url: "/member/citysjld",  
        data: {"type":1,_token: "{{csrf_token()}}"},  
        dataType: "json",  
        success: function(data) {  
            //遍历json数据，组装下拉选框添加到html中
            $("#provinces").append("<option value=''>请选择省</option>");  
            $.each(data, function(i, item) {  
                $("#provinces").append("<option value='" + item.province_num + "'>" + item.province_name + "</option>");  
            });
        }  
    });      
  // })

  //监听省select框
  $("#provinces").change(function() {  
      $.ajax({  
          type: "post",  
          url: "/member/citysjld",
          data: {"pnum": $(this).val(),"type":2,_token: "{{csrf_token()}}"},  
          dataType: "json",  
          success: function(data) {  
              //遍历json数据，组装下拉选框添加到html中
              $("#citys").html("<option value=''>请选择市</option>");  
              $.each(data, function(i, item) {  
                  $("#citys").append("<option value='" + item.city_num + "'>" + item.city_name + "</option>");  
              });  
          }  
      });  
  });  

});  
</script>
<script type="text/javascript">
//手机邮箱切换
$('.click_email').click(function () {
    $(this).css('display','none');
    $('#user_phone').css('display','none');
    $('#user_email').css('display','block');
    $('.click_phone').css('display','block');
    $('.code_tel').css('display','none');
    $('.code_email').css('display','block');
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
        url: '/user/send_email_code',
        type: 'POST',
        dataType: 'json',
        data: {user_email: email, _token: "{{csrf_token()}}"},
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
        var myreg = /^[1][3,4,5,6,7,8,9][0-9]{9}$/;
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
        let email = $.trim($('#user_email').val());
        let verification_code = $.trim($('#verification_code').val());
        let verification_code_email = $.trim($('#verification_code_email').val());
        let emailzz = /^([A-Za-z0-9_+-.])+@([A-Za-z0-9\-.])+\.([A-Za-z]{2,22})$/;

        if(mobile!='' && mobile != null && mobile != undefined){
            if (!/^[1][3,4,5,6,7,8,9][0-9]{9}$/.test(mobile)) {
                layer.msg('请输入正确手机号',{time:1500,skin: 'intro-login-class layui-layer-hui'});
                return false;
            }
        }
        
        if(email!='' && email != null && email != undefined){
            if(!emailzz.test(email)){
            layer.msg('邮箱格式错误',{time: 1500,skin: 'intro-login-class layui-layer-hui'});
            return false;
            }
        }
        if(mobile || email){
            $.ajax({
                url: '/user/verify_code',
                type: 'POST',
                dataType: 'json',
                data: {
                    user_phone: mobile,
                    user_email: email,
                    verification_code: verification_code,
                    verification_code_email: verification_code_email,
                    _token: "{{csrf_token()}}",
                },

                success: function (data) {
                    //console.log(data.status_code);
                    if (data.status_code == 0) {
                        layer.msg(data.message,{time:1500,skin: 'intro-login-class layui-layer-hui'});
                        $("#step1").addClass("hide");
                        $("#step2").removeClass("hide");
                        $("#userphone").val(mobile);
                    } else {
                        layer.msg(data.message,{time:1500,skin: 'intro-login-class layui-layer-hui'});
                    }
                }
            });
        }

    });

    //step2

    $("#wp-submit-2").click(function () {
        let user_phone = $.trim($('#userphone').val());
        let user_login = $.trim($('#user_login').val());
        let zhiwei=$('#zhiwei').val();
        let provinces=$("#provinces").val();
        let city=$('#citys').val();
        let email = $.trim($('#user_email').val());
        // let diqu=provinces+'-'+city;
        let pass1 = $.trim($('#pass1').val());
        let pass2 = $.trim($('#pass2').val());
        if (pass1 != pass2) {
            layer.msg('输入的两次密码不同！');
            return false;
        }

        if(user_login!='' && user_login != null && user_login != undefined){
            if (!/^[\u4E00-\u9FA5A-Za-z0-9]+$/.test(user_login)) {
                layer.msg('昵称规范:中文、英文、数字但不包括下划线等符号',{time:1500,skin: 'intro-login-class layui-layer-hui'});
                return false;
            }
        }

        $.ajax({
            url: '/user/register',
            type: 'POST',
            dataType: 'json',
            data: {
                user_phone:user_phone,
                user_login:user_login,
                pass1:pass1,
                pass2:pass2,
                provinces:provinces,
                city:city,
                zhiwei:zhiwei,
                email:email,
                _token: "{{csrf_token()}}",
            },

            success: function (data) {
                //console.log(data.status_code);
                if (data.status_code == 0) {
                    layer.msg(data.message,{time:1500,skin: 'intro-login-class layui-layer-hui'});
                    setTimeout(function () {
                        location.href = "/";
                    }, 300);
                } else {
                    layer.msg(data.message,{time:1500,skin: 'intro-login-class layui-layer-hui'});
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