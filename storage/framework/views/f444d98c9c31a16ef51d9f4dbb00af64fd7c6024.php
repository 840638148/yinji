<?php $__env->startSection('title'); ?>



    <?php echo e(trans('comm.yinji')); ?>- 会员服务



<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="about_bj"></div>

<div class="about_nav">

  <ul>

    <li ><a href="/vip/promotion">文章推广</a></li>

    <li><a href="/vip/ad">广告合作</a></li>

    <li class="current" style="background:#231922"><a href="/vip/vip_service">会员服务</a></li>

    <li><a href="/vip/job_service">招聘服务</a></li>

  </ul>

</div>
<div style="background: #231922; padding:30px 0;">

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="vip_deta">

      <tbody><tr>

        <th width="20">特权对比</th>

        <th width="20%">普通用户</th>

        <th width="20%">月会员</th>

        <th width="20%">季会员</th>

        <th width="20%">年会员</th>

        <!--th width="14%">特邀作者</th>

        <th width="14%">企业会员</th-->
      </tr>
      
     <tr>
        <td>身份标识</td>
        <td>×</td>
        <td><img src="/images/vip_03_32.png" title="印际月会员" /></td>
        <td><img src="/images/vip_05_32.png" title="印际季度会员" /></td>
        <td><img src="/images/vip_07_32.png" title="印际年度会员" /></td>
      </tr>

      <tr>

        <td>费用</td>

        <td class="vip_jiage">免费</td>

        <td class="vip_jiage"><em>99</em>元/月</td>

        <td class="vip_jiage"><em>288</em>元/年</td>

        <td class="vip_jiage"><em>999</em>元/年</td>

        <!--td class="vip_jiage">特邀注册</td>

        <td class="vip_jiage"><em>2888</em>元/年</td-->

      </tr>

      <tr>

        <td>积分抵扣费用</td>

        <td>×</td>

        <td>5%</td>

        <td>10%</td>

        <td>15%</td>

        <!--td >0</td>

        <td>10%</td-->

      </tr>

      <tr>

        <td>注册送积分</td>

        <td>8</td>

        <td>58</td>

        <td>168</td>

        <td>288</td>

        <!--td>888</td>

        <td>888</td-->

      </tr>

      <tr>

        <td>签到积分额外（）</td>

        <td>0</td>

        <td>5</td>

        <td>10</td>

        <td>15</td>

        <!--td>88</td>

        <td>88</td-->

      </tr>

      

      <tr>

        <td>免积分下载次数（/天）</td>

        <td>0</td>

        <td>5</td>

        <td>10</td>

        <td>15</td>

        <!--td>50</td>

        <td>88</td-->

      </tr>

      <tr>

        <td>积分下载次数（/天）</td>

        <td>1</td>

        <td>3</td>

        <td>5</td>

        <td>10</td>

        <!--td>50</td>

        <td>88</td-->

      </tr>

      <tr>

        <td>发现灵感</td>

        <td>×</td>

        <td>√</td>

        <td>√</td>

        <td>√</td>

        <!--td>√</td>

        <td>√</td-->

      </tr>

      <tr>

        <td>收藏文章</td>

        <td>√</td>

        <td>√</td>

        <td>√</td>

        <td>√</td>

        <!--td>√</td>

        <td>√</td-->

      </tr>

      <tr>

        <td>订阅设计师</td>

        <td>√</td>

        <td>√</td>

        <td>√</td>

        <td>√</td>

        <!--td>√</td>

        <td>√</td-->

      </tr>

       <tr>

        <td>关注用户</td>

        <td>√</td>

        <td>√</td>

        <td>√</td>

        <td>√</td>

        <!--td>√</td>

        <td>√</td-->

      </tr>

       <tr>

        <td>个人页面</td>

        <td>╳</td>

        <td>√</td>

        <td>√</td>

        <td>√</td>

        <!--td>√</td>

        <td>╳</td-->

      </tr>

      <tr>

        <td>企业页面</td>

        <td>╳</td>

        <td>╳</td>

        <td>╳</td>

        <td>╳</td>

        <!--td>╳</td>

        <td>√</td-->

      </tr>

     <tr>

        <td>招聘</td>

        <td>╳</td>

        <td>╳</td>

        <td>╳</td>

        <td>╳</td>

        <!--td>╳</td>

        <td>√</td-->

      </tr>

      <tr>

        <td>写稿</td>

        <td>╳</td>

        <td>╳</td>

        <td>╳</td>

        <td>╳</td>

        <!--td>√</td>

        <td>√</td-->

      </tr>

      <tr>

        <!--<td colspan="5"><a href="/vip/intro">立即开通</a></td>-->
        <td colspan="5"><section><a href="javascript:void(0);" class="openVip">立即开通</a></section></td>

      </tr>

    </tbody></table>
</div>    



<!-- 登录 -->

<div class="login_box" style="display:none;">
<div class="new_folder_bj"></div>
<div class="login_folder">
    <div id="login" class="login"> 


<h1><a href="/indx" title="<?php echo e(trans('comm.yinji')); ?>" tabindex="-1"><?php echo e(trans('comm.yinji')); ?></a></h1>
<h2><?php echo e(trans('login.login_title')); ?></h2>

<form name="loginform" id="loginform" action="/user/login" method="post">
        <input type="hidden" name="_token" value="" />
        <p>
  <label for="user_login">
            <input type="text" name="user_login" id="user_login" class="input" value="" size="20"



                           placeholder="<?php echo e(trans('login.input_username')); ?>">
          </label>
</p>
        <p>
  <label for="user_pass">
            <input type="password" name="password" id="user_pass" class="input" value="" size="20" placeholder="<?php echo e(trans('login.input_password')); ?>">
          </label>
</p>
        <p class="forgetmenot">
  <label for="rememberme">
            <input name="rememberme" type="checkbox" id="rememberme"



                           value="forever">
            <?php echo e(trans('login.remember_me')); ?> </label>
</p>
        <p class="submit">
  <input type="button" name="wp-submit" id="wp-submit-login" class="button button-primary button-large"



                       value="<?php echo e(trans('login.login')); ?>">
  <input type="hidden" name="redirect_to" value="/user/index">
  <input type="hidden" name="testcookie" value="1">
</p>
      </form>
<div style=" overflow:hidden">
        <p id="nav" class="fr"> <a href="/user/register"><?php echo e(trans('login.register')); ?></a> | <a



                        href="/user/forgot_password"><?php echo e(trans('login.forgot_password')); ?></a> </p>
        <p class="fl"> <a href="/"> ← <?php echo e(trans('login.return')); ?> </a> </p>
      </div>
<div class=""> <span style="float:left; line-height:36px;color: #999;"> <?php echo e(trans('login.other_login')); ?>：</span> <a href="javascript:void(0);" onclick="WeChatLogin();" title="使用微信登录"><img src="/img/tl_weixin.png"></a> </div>
<div class="login_ico"> <a href="javascript:void(0);" onclick="WeChatLogin();"><img src="/img/erweima.gif" width="51" height="51" alt="二维码登陆"></a> </div>
<div class="ma_box hide">
        <h1><a href="/index" title="<?php echo e(trans('comm.yinji')); ?>" tabindex="-1"><?php echo e(trans('comm.yinji')); ?></a></h1>
        
        <h2>微信扫码登陆</h2> 
        
        <p>
  <iframe frameborder="0" scrolling="no" width="365" height="395"



                        src="/auth/weixin"></iframe>
</p>
        <p class="backtoblog" style="text-align:center"> <a href="/"> ← <?php echo e(trans('login.return')); ?> </a> </p>
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
        <li class="determine vipfee_type1" vip_level="1" price="<?php echo e(isset($month_price) ? $month_price : '0.01'); ?>" omit="108"><em><?php echo e(isset($month_price) ? $month_price : '0.01'); ?></em>元
          <p>月会员</p>
          <del>原价：108元</del></li>
        <li class="vipfee_type2" vip_level="2" price="<?php echo e(isset($season_price) ? $season_price : '0.01'); ?>" omit="324"><em><?php echo e(isset($season_price) ? $season_price : '0.01'); ?></em>元
          <p>季会员</p>
          <del>原价：324元</del></li>
        <li class="vipfee_type3" vip_level="3" price="<?php echo e(isset($year_price) ? $year_price : '0.01'); ?>" omit="1296"><em><?php echo e(isset($year_price) ? $year_price : '0.01'); ?></em>元
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
        <input type="hidden" name="pay_total" id="pay_total" value="<?php echo e(isset($month_price) ? $month_price : '0.01'); ?>" />
        <p class="vip_pay_msg">应付：<span><?php echo e(isset($month_price) ? $month_price : '0.01'); ?></span>元 ( 立省9元)</p>
        <p>
          <button type="button" class="single_add_to_cart_button button_red alt" id="buy_now_button">立即购买 </button>
        </p>
      </form>
    </div>
  </div>
</div>

<!--------选购会员结束-------> 

<script type="text/javascript">
$(document).on("click",".openVip",function () {
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
<?php $__env->stopSection(); ?> 


  
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>