@extends('layouts.app')

@section('title')



    印际_{{trans('comm.yinji')}}- 招聘服务



@endsection
@section('content')


<div class="about_bj"></div>

<div class="about_nav">

  <ul>

    <li ><a href="/vip/promotion">文章推广</a></li>

    <li><a href="/vip/ad">广告合作</a></li>

    <!--<li><a href="vip_service.html">会员服务</a></li>-->
    <li><a href="/vip/vip_service">会员服务</a></li>
    
    <li class="current" style="background:#231922"><a href="/vip/job_service">招聘服务</a></li>

  </ul>

</div>

<div class="about_box" style="background: #231922;" >

  <section class="wrapper">

 <h2 style="float:left;background: #231922; padding:30px 0; color:#fff;"> 购买招聘请按发布流程下载文档填写相关信息并发送至  <a href="mailto:job@yinjispace.com ">job@yinjispace.com</a>  请在邮箱中留下联系人，电话，公司名称以及主要需求。若工作日24小时内没有及时处理您的请求，请投诉<a href="mailto:co@yinjispace.com ">hi@yinjispace.com</a></h2>

  <div class="job_box job_box_bj">

  <dl>

  <dt>发布工作流程</dt>

  <dd><span>下载报名表格</span> <a href="#" style=" line-height:48px; font-size:14px;color:#ff0;">下载免费报名表格</a></dd>

  <dd><span>填写表格并发送到<br>job@yinjispace.com</span></dd>

  <dd><span>等待审核</span></dd>

  <dd><span>确认并发布</span></dd>

  </dl>

  </div>

   <div class="job_box">

   <dl>

   <dt>服务价格</dt>

   <div class="job_tc">

   <ul>

   <li style="border:none">

       <dl>

       <dt>¥1,800<span>元/年</span>

       <p class="job_ico"><img src="/images/job_ico_07.gif" alt="会员套餐"></p>

       <p>基础套餐</p>

       </dt>

       <dd>工作页面1年推广时长</dd>

       <dd>6个职位（限同一地区2个城市）| 6 Jobs</dd>

       <dd>首页文字链接推广至少10天</dd>

       <dd>社交推广1次（微博，豆瓣，Facebook）</dd>

       <dd>1篇微信第3条文章，升第2条外加3000</dd>

       <dd>3篇20家以上公司集合推广文章，微信第1条</dd>

     </dl></li>

   <li>

       <dl>

       <dt>¥3,800<span>元/年</span>

       <p class="job_ico"><img src="/images/job_ico.gif" alt="基础套餐"></p>

       <p>白金套餐</p>

       </dt>

       <dd>工作页面1年推广时长</dd>

       <dd>8个职位（限2个地区4个城市）|8 Jobs</dd>

       <dd>1篇招聘推广文章（网站）</dd>

       <dd>首页文字链接推广至少10天</dd>

       <dd>社交推广3次（微博，豆瓣，Facebook）</dd>

       <dd>1篇微信第2条文章，升头条外加12000</dd>

       <dd>3篇20家以上公司集合推广文章，微信第1条</dd>

       <dd>工作页右侧提前2次，每次1月</dd>

       <dd>微信社群会员一年价值288</dd>

     </dl></li>

     <li>

       <dl>

       <dt>¥6,800<span>元/年</span>

       <p class="job_ico"><img src="/images/job_ico-03.gif" alt="钻石套餐"></p>

       <p>钻石套餐</p>

       </dt>

       <dd>工作页面1年推广时长</dd>

       <dd>无限个职位（不限地点）|Ultimate Jobs</dd>

       <dd>1篇招聘推广文章（网站）</dd>

       <dd>首页文字链接推广至少10天</dd>

       <dd>出现在首页左侧大图文时间流</dd>

       <dd>社交推广3次（微博，豆瓣，Facebook）</dd>

       <dd>1篇微信第2条文章，升头条外加12000</dd>

       <dd>3篇20家以上公司集合推广文章，微信第1条</dd>

       <dd>网站大图时间流中提前2次，每次1月</dd>

       <dd>工作页面右侧小广告6个月</dd>

       <dd>永久微信社群会员价值688</dd>

     </dl></li>

   </ul> 

   </div> 

   <a href="javascript:void(0);" class="job_manu">免费申请</a>

  </dl>

  </div>

</section>

</div>



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
        <li>
          <input name="" type="checkbox" value="" checked="checked" />
          到期自动续费一个月，可随时取消</li>
        <li>
          <input  name="" type="checkbox" value="" checked="checked"/>
          <a href="#">同意并接受《服务条款》</a></li>
      </ul>
    </div>
    <div class="vip_pay">
      <form class="cart vip_pay" action="/vip/wxbuy" method="post" enctype="multipart/form-data">
        <input type="hidden" name="vip_type" id="vip_type" value="1" />
        <input type="hidden" name="payment_code" id="payment_code" value="alipay" />
        <input type="hidden" name="pay_total" id="pay_total" value="{{$month_price or '0.01'}}" />
        <p class="vip_pay_msg">应付：<span>{{$month_price or '0.01'}}</span>元 ( 立省9元)</p>
        <p>
          <button type="button" class="single_add_to_cart_button button_red alt" id="buy_now_button">立即购买 </button>
        </p>
      </form>
    </div>
  </div>
</div>

<!--------选购会员结束-------> 

<script type="text/javascript">
$(document).on("click",".job_manu",function () {
  if(!IS_LOGIN){
      $('.login_box').show();
    }else{
      $(".new_folder_box").show();
      return false;
    }
})

$(document).on("click",".vip_close",function () {
    $(".new_folder_box").hide();
    return false;
})

</script> 
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
  $(document).on("click","#buy_now_button",function(){
      var vip_type = $('#vip_type').val();
      if (vip_type == '') {
        alert('请选择会员类型');
        return false;
      }
      window.location = '/vip/pay?vip_type=' + vip_type;
      return;

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
            }else{
              alert('微信支付返回二维码地址');
            }
            layer.closeAll();
          }else{
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

<!-- 版权 -->
@endsection 

