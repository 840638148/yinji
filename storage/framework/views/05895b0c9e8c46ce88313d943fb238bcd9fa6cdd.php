<?php $__env->startSection('title'); ?>
  <?php echo e(trans('comm.yinji')); ?> - TA <?php echo e(trans('index.discovery')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<style>
  body{background:#f8f8f8 !important;}
  .home_box{border-radius:10px !important;}
  .home_top{background:#fff !important;}
  .item .edit_favorites{
    position: absolute;
    display: inline-block;
    vertical-align: top;
    text-indent: 0;
    text-align: center;
    line-height: 32px;
    z-index: 120;
    right: 120px;
    top: 34%;
  }

  .edit_favorites:hover .item-setting-btns{
      color:#555;
  }

  .find_title{
      overflow:inherit;
      position:relative;
  }

  .find_title h2{
      float: none;
      width:200px;
      vertical-align: top
  }

  .item .item-setting-btns{
      display: none;
      position: absolute;
      right:-35px;
      background: #fff;
      border-radius: 4px;
      width: 90px;
      padding: 3px 0px;
      text-align: center;
      font-size: 12px;
      box-shadow: 0 0 11px rgba(0,0,0,.1);
      top:40px;
      margin-bottom: 4px;
  }

  .item.selected .item-setting-btns{
      display: block;
  }

  .modal{
    display:none;
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
    height: calc( 100% - 50px);
  }

</style>

<div class="longzhao"></div>
<div class="home_top">
    <div class="home_banber"> 
        <?php if($users->zhuti): ?>
        <img src="<?php echo e($users->zhuti); ?>" alt="个人主页图片" />
        <?php else: ?>
        <img src="/images/zhutibj.jpg" alt="个人主页图片" />
        <?php endif; ?>
    </div>
  <div class="home_tongji">
    <ul>
      <li><?php echo e(trans('index.sentiment')); ?></br><?php echo e(App\User::getViewNum($users->id)); ?> </li>
      <li><?php echo e(trans('index.collection')); ?></br><?php echo e(App\User::getCollectNum($users->id)); ?> </li>
      <li><?php echo e(trans('index.follow')); ?></br><?php echo e(App\User::getFollowNum($users->id)); ?> </li>
      <li><?php echo e(trans('index.fans')); ?></br><?php echo e(App\User::getFansNum($users->id)); ?> </li>
    </ul>
  </div>

  <div class="home_personal"> <img src="<?php if($users->avatar): ?> <?php echo e($users->avatar); ?> <?php else: ?> /img/avatar.png <?php endif; ?>" alt="<?php echo e($users->nickname); ?>" />
  </div>
  <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> <?php echo e($users->nickname); ?> <img src="<?php echo e($users->vip_level); ?>" alt=""></h2>
  <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;"><?php if($users->zhiwei): ?><?php echo e($users->zhiwei); ?><?php else: ?> 保密 <?php endif; ?> - <?php echo e($users->city); ?> <img src="<?php echo e(App\User::getVipLevel($users->id)); ?>" alt=""></p>
  <?php if($user->id==$users->id): ?>
  
  <?php elseif($users->is_follow): ?>
  <p style="position:absolute; text-align:center;left: 0;top:450px;width: 100%;"><span class='have-disalbed' uid='<?php echo e($users->id); ?>' style='padding: 5px 25px;display: inline-block;background: #eee;margin: 20px auto;color: #666;cursor:no-drop !important;border-radius: 5px;'><?php echo e(trans('index.following')); ?></span></p>
  <?php else: ?>
  <p style="position:absolute; text-align:center;left: 0;top:450px;width: 100%;"><span class='gzuser' uid='<?php echo e($users->id); ?>' style='padding: 5px 25px;display: inline-block;background: #3d87f1;margin: 20px auto;color: #fff;cursor: pointer !important;border-radius: 5px;'><?php echo e(trans('index.follow')); ?></span></p>
  <?php endif; ?>
  <div class="home_nav" style='width:610px;left:52%;'>
    <ul>
        <li><a href="/member/<?php echo e($users->id); ?>"><?php echo e(trans('index.home_page')); ?></a></li>
        <li class="current"><a href="/member/homepage_finder/<?php echo e($users->id); ?>"><?php echo e(trans('index.discovery')); ?></a></li>
        <li><a href="/member/homepage_collect/<?php echo e($users->id); ?>"><?php echo e(trans('index.collection')); ?></a></li>
        <li><a href="/member/homepage_subscription/<?php echo e($users->id); ?>"><?php echo e(trans('index.subscription')); ?></a></li>
        <li><a href="/member/homepage_interactive/<?php echo e($users->id); ?>"><?php echo e(trans('index.follow')); ?></a></li>
        <li><a href="/member/homepage_fans/<?php echo e($users->id); ?>"><?php echo e(trans('index.fans')); ?></a></li>
    </ul>
  </div>
</div>

<section class="wrapper" style='width:1245px;'>
  <div class="mt30 home_box" >
    <div class="title1" style='width: 100%;border-bottom: 1px solid #eee;margin-bottom: 20px;overflow: hidden;'>
      <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;display:block !important;'>TA <?php echo e(trans('index.discovery')); ?></span></h2>
    </div>
    <?php if($user->level==0): ?>
        <!--VIP专栏提示-->
        <div class="vip_prompt modal vip_prompt-member" id="vip-img"><a href="#" class="vip_buy">开通VIP会员</a><a href="#" class="vip_detail">了解VIP详情>></a></div>

        

    <?php else: ?>
        <div class="my-find-list" >
            <?php $__currentLoopData = $users->finders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $finder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="item">
                <div class="item__content" style="position:relative">
                <ul data-id="<?php echo e($finder['folder']['id']); ?>" onclick="location.href='/member/hp_finder_detail/<?php echo e($users->id); ?>/<?php echo e($finder['folder']['id']); ?>'">
                    <?php $__currentLoopData = $finder['finder']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img_obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($img_obj['img']): ?>
                            <li>
                                <a href="/member/hp_finder_detail/<?php echo e($users->id); ?>/<?php echo e($finder['folder']['id']); ?>"><img src="<?php echo e($img_obj['img']); ?>" /></a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>

                <div class="find_title">
                    <h2><a><?php echo e($finder['folder']['name']); ?></a></h2>
                    <div class="find_images"> <i class="icon-eye" title="公开"></i> <?php echo e($finder['folder']['total']); ?></div>
                </div>
                </div>

            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>
  </div>
</section>
</div>


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
                <li class="determine vipfee_type1" vip_level="1" price="<?php echo e(isset($month_price) ? $month_price : '0.01'); ?>" omit="<?php echo e($be_month_price); ?>"><em><?php echo e(isset($month_price) ? $month_price : '0.01'); ?></em>元
                <p>月会员</p>
                <del>原价：<?php echo e($be_month_price); ?>元</del></li>
                <li class="vipfee_type2" vip_level="2" price="<?php echo e(isset($season_price) ? $season_price : '0.01'); ?>" omit="<?php echo e($be_season_price); ?>"><em><?php echo e(isset($season_price) ? $season_price : '0.01'); ?></em>元
                <p>季会员</p>
                <del>原价：<?php echo e($be_season_price); ?>元</del></li>
                <li class="vipfee_type3" vip_level="3" price="<?php echo e(isset($year_price) ? $year_price : '0.01'); ?>" omit="<?php echo e($be_year_price); ?>"><em><?php echo e(isset($year_price) ? $year_price : '0.01'); ?></em>元
                <p>年会员</p>
                <del>原价：<?php echo e($be_year_price); ?>元</del></li>
            </ul>
        </div>

        <div class="vip_check">
            <ul>
                <!---li><input name="" type="checkbox" value="" checked="checked" />到期自动续费一个月，可随时取消</li--->
                <li><input name="" type="checkbox" value="" id="agree" /><a href="javascript:void(0);">同意并接受《服务条款》</a></li>
            </ul>
        </div>



        <div class="vip_pay">
            <form class="cart vip_pay" action="/vip/wxbuy" method="post" enctype="multipart/form-data">
                <input type="hidden" name="vip_type" id="vip_type" value="1" />
                <input type="hidden" name="payment_code" id="payment_code" value="wechatpay" />
                <input type="hidden" name="pay_total" id="pay_total" value="<?php echo e(isset($month_price) ? $month_price : '0.01'); ?>" />
                <input type="hidden" name="open_id" id="open_id" value="ohPM_1TdJ-oXTAWy7rP-82CT3glo" />
                <p class="vip_pay_msg">应付：<span><?php echo e(isset($month_price) ? $month_price : '0.01'); ?></span>元 ( 立省9元)</p>
                <p><button type="button" class="single_add_to_cart_button button_red alt" id="buy_now_button">立即购买 </button></p>
            </form>
        </div>
    </div>
</div>

<!--------选购会员结束------->



<!--VIP专栏提示结束-->

<script src="/js/layer.js"></script> 
<script src="/js/member.js"></script>


<script>
    // 关注TA
    $('.gzuser').click(function(){
    let gzid=$(this).attr('uid');
    let that=$(this);
    $.ajax({
        url: '/member/gzta',
        type: 'POST',
        dataType: 'json',
        data: {_token:'<?php echo e(csrf_token()); ?>',gzid:gzid},
        success: function (data) {
            if (data.status_code == 100) {
                layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
                that.text('取消关注');
                that.removeClass('gzuser');
                that.addClass('have-disalbed').css('background','#e62b3c');
                window.location.reload();
            } else {
                layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
            }
        }
    });
  });



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
        // if(!IS_LOGIN){
        //     $('.login_box').show()
        // }

        $(document).on("click","#buy_now_button",function(){
            var vip_type = $('#vip_type').val();
            let agree = document.getElementById("agree").checked;
            if(!agree){
                layer.msg('请阅读并接受《服务条款》!',{zIndex:999999999,time: 1500,skin: 'intro-login-class layui-layer-hui'});
                return false;
            }
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
<?php $__env->stopSection(); ?> 
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>