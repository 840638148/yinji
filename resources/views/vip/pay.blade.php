@extends('layouts.app')



@section('title')

    VIP_{{trans('comm.yinji')}}

@endsection


@section('content')
    <script src="/js/jquery.qrcode.min.js"></script>
    <section class="wrapper pay-wrap">
        <!---支付--->
        <div class="pay_box clearfix">
            <i class="pay_ico fl mr20" ></i>
            <div style="float: left" class="pay-title"><h2 class="mt10">您的订单已提交成功！付款咯 </h2><p>购买：<span class="c_orange">{{$order_title}}</span></p></div>
            <div style="float: right" class="pay-money"><h2 class="mt10">应付：<span class="c_red">{{$pay_total}}</span>元</h2><p>积分抵扣:<span class="c_red">{{$point_total}}</span>元</p></div>
        </div>

        <div class="pay_box pay_box-content mt30">
            <div class="pay_title"> 选择支付方式 </div>
            <ul class="pay">
                <li class="weixin"><div class="qr-code">{{$wx_code_url}}</div><i class="weixin-icon"></i></li>
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
@endsection

