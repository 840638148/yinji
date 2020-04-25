<?php $__env->startSection('title'); ?>

  <?php echo e(trans('comm.yinji')); ?> - 个人中心 -关注中心

<?php $__env->stopSection(); ?>





<?php $__env->startSection('content'); ?>
<div class="home_top">
  <div class="home_banber"> <img src="/images/home_bj.jpg" alt="个人主页图片" /></div>
  <div class="home_tongji">
    <ul>
      <li> 订阅</br>
        <?php echo e($user->subscription_num); ?> </li>
      <li> 收藏</br>
        <?php echo e($user->collect_num); ?> </li>
      <li> 积分</br>
        <?php echo e($user->points); ?> </li>
      <li> 关注</br>
        <?php echo e($user->follow_num); ?> </li>
    </ul>
  </div>
  <div class="home_personal"> <img src="<?php if($user->avatar): ?> <?php echo e($user->avatar); ?> <?php else: ?> /img/avatar.png <?php endif; ?>" alt="<?php echo e($user->nickname); ?>" />
  </div>
      <<h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> <?php echo e($user->nickname); ?>  <?php if($user->is_vip): ?><span class="vip1">VIP<?php echo e($user->vip_level); ?></span><?php else: ?><span class="vip1" style="background-color:#ccc;color:#fff;">普通用户</span> <?php endif; ?> </h2>
  <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;">个人说明： <?php echo e($user->personal_note); ?></p>
  
  <div class="home_nav">
    <ul>
      <li><a  href="/member">个人中心</a></li>
      <li><a href="/member/finder">我的发现</a></li>
      <li><a href="/member/collect">我的收藏</a></li>
      <li><a href="/member/subscription">我的订阅</a></li>
      <li class="current"><a href="/member/follow">我的关注</a></li>
      <li><a href="/member/point">我的积分</a></li>
      <li><a href="/member/profile">个人资料</a></li>
    </ul>
  </div>
</div>
<section class="wrapper">
  <div class="mt30 home_box">
    <div class="title">
      <h2>我的关注</h2>
    </div>
     <!--<?php if(!$user->is_vip): ?>-->
      <!--VIP专栏提示-->	
      <div class="vip_prompt modal vip_prompt-member" id="vip-img"><a href="#" class="vip_buy">开通VIP会员</a><a href="#" class="vip_detail">了解VIP详情>></a></div>
     <!--<?php endif; ?>-->
    <div class="masonry" > <?php $__currentLoopData = $user->follows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $follow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="item">
        <div class="users">
          <div class="border-bottom1">
            
            <div class="head"><a href="javascript:void(0)" onclick="showNoEnter()"><img src="<?php if($follow->avatar): ?> <?php echo e($follow->avatar); ?> <?php else: ?> /img/avatar.png <?php endif; ?>" alt="<?php echo e($follow->nickname); ?>" /></a></div>
            <h2><a href="/vip/index/<?php echo e($follow->id); ?>"><?php echo e($follow->nickname); ?></a> </h2>
            <p> <?php if(1 == $follow->sex): ?>
              
              男
              
              <?php elseif(2 == $follow->sex): ?>
              
              女
              
              <?php else: ?>
              
              保密
              
              <?php endif; ?>
              
              
              
              <?php if($follow->city): ?>
              
              -
              
              <?php echo e($follow->city); ?>

              
              <?php endif; ?>
              
              
              
              <?php if($follow->is_vip): ?> <span class="vip1">VIP<?php echo e($user->vip_level); ?></span> <?php endif; ?> </p>
          </div>
          <div class="Statistics">
            <ul>
              <li><span><?php echo e($follow->collect_num); ?></span>收藏</li>
              <li><span><?php echo e($follow->fans_num); ?></span>粉丝</li>
            </ul>
          </div>
          <a href="javascript:void(0)" data-id="<?php echo e($follow->id); ?>" class="Button cancelFollow">取消关注</a> </div>
      </div>
     
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </div>
  </div>
</section>


<script src="/js/layer.js"></script> 

<script src="/js/member.js"></script>



<script>

    $(document).ready(function(){

        if(!IS_VIP){

            $('.home_box .title').hide()

            $('#vip-img').show();

        }else{



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

            return false;

        })



        $(document).on("click",".new_folder_bj",function () {

            $(".login_box").hide();

            $(".new_folder_box").hide();

            return false;

        })





        $(document).on("click",".vip_prompt",function () {

            layer.closeAll()

            return false;

        })



        $(document).on("click",".layui-layer-shade",function () {

            layer.closeAll()

            return false;

        })



        //关闭所有展示框

        $(document).on('click','.modal .close',function(){

            class_find_layui_win();

        })

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


<script type="text/javascript">

  function showNoEnter(){
    layer.msg('敬请期待！',{skin: 'intro-login-class layui-layer-hui'})
  }

    $(document).ready(function(){



      //取消关注

      $(".cancelFollow").click(function(e){



        var follow_id = $(this).attr('data-id');

        $.ajax({

          url: '/member/cancel_follow',

          type: 'POST',

          dataType: 'json',

          data: {_token:'<?php echo e(csrf_token()); ?>',follow_id:follow_id},

          success: function (data) {

            if (data.status_code == 0) {

              window.location.reload();

            } else {
              alert(data.message);

            }

          }

        });



      });

    });

  </script> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>