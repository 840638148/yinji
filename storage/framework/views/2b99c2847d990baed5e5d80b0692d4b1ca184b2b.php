<?php $__env->startSection('title'); ?>

    VIP_<?php echo e(trans('comm.yinji')); ?>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>
<script src="/js/layer.js"></script> 
    <script src="/js/jquery.qrcode.min.js"></script>
    <section class="wrapper pay-wrap">
        <!---支付--->
        <div class="pay_box clearfix">
            <i class="pay_ico fl mr20" ></i>
            <div style="float: left" class="pay-title"><h2 class="mt10">您的订单已提交成功！付款咯 </h2><p>购买：<span class="c_orange"><?php echo e($order_title); ?></span></p></div>
            <div style="float: right" class="pay-money"><h2 class="mt10">应付：<span class="c_red"><?php echo e($pay_total); ?></span>元</h2><p>积分抵扣:<span class="c_red"><?php echo e($point_total); ?></span>元</p></div>
            <div id="clock" style="clear: both;font-size: 18px;color:red;margin-left:90px;" >订单还有 <span id="mintue">01分</span><span id="second">00秒</span> 后自动取消订单</div>
        </div>
<script type="text/javascript">
window.onload = function () {
    function formatDuring(mss) {
    var minutes = parseInt((mss % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = (mss % (1000 * 60)) / 1000;
    return [minutes , seconds ];
    }

    var time = 10000;
    var int=0;
    int= setInterval(function(){
        time -= 1000
        if(time ==0){
            clearInterval(int);
            $.ajax({
                url: '/vip/autodelpay',
                type: 'POST',
                dataType: 'json',
                data: {},
                success: function (data) {
                    if (data.status_code == 0) {
                        // layer.msg('订单超时，请重新开通会员！',{time: 1500,skin: 'intro-login-class layui-layer-hui'});
                        //墨绿深蓝风

                        // layer.alert('订单超时，请重新开通会员！', {
                        // skin: 'layui-layer-molv' //样式类名
                        // ,closeBtn: 0
                        // })

                        layer.open({
                            title: ['温馨提示'],
                            content: '订单超时，请重新开通会员！',
                            btn: ['确定'],
                            shadeClose: true,
                            //回调函数
                            yes: function(index){
                            self.location='/vip/intro';//确定按钮跳转地址
                            }
                        })
 


                        // window.location.href='/vip/intro';
                    }else{
                        layer.msg('操作错误，请重新开通会员',{time: 1500,skin: 'intro-login-class layui-layer-hui'});
                        window.location.href='/vip/intro';
                    }
                }
            });
            
        }
        console.log(formatDuring(time));
        $('#mintue').text(formatDuring(time)[0]+"分");
        $('#second').text(formatDuring(time)[1]+"秒");

    },1000)




}




</script>
        <div class="pay_box pay_box-content mt30">
            <div class="pay_title"> 选择支付方式 </div>
            <ul class="pay">
                <li class="weixin"><div class="qr-code"><?php echo e($wx_code_url); ?></div><i class="weixin-icon"></i></li>
                <li class="alipay"><a class="qr-code"></a><i class="alipay-icon"></i></li>
            </ul>
        </div>
    </section>
    <script>

        function getUrlParam(name){
            var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if (r!=null) return unescape(r[2]); return null;
        }



        $(document).ready(function(){
            var vip_type = getUrlParam('vip_type')
            var url =  '/vip/pre_pay?vip_type='+vip_type
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                data: {},
                success: function (data) {
                    if (data.status_code == 0) {
                        var value = data.data;
                        var wx_url = value.wx_url;
                        $('.weixin .qr-code').qrcode({
                            render: "canvas", //也可以替换为table
                            width: 162,
                            height: 162,
                            text: wx_url
                        })
                        $('.alipay .qr-code').attr('href',value.alipay_url)

                    } else {
                        layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
                    }
                }
            });

            // $('.hot-search').find('dd').
        })
    </script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>