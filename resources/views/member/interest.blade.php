@extends('layouts.app')



@section('title')

    VIP_{{trans('comm.yinji')}} - 续费中心

@endsection
<style>
    body{
        background-color: #f8f8f8!important;
    }
</style>
@section('content')

<section style="background-color: #f8f8f8">
    {{--<div class="member_center_top">--}}
        {{--<img src="/images/member/member-center-one.jpg"  border="0" />--}}
        {{--<div class="member_info">--}}
            {{--<div class="member-detail">--}}
                {{--<div class="member-time">{{substr($user->expire_time,0,10)}}到期</div>--}}
                {{--<div class="member-personal">--}}
                    {{--<img src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$user->nickname}}" />--}}

                    {{--<div class="name">{{$user->nickname}}</div>--}}

                {{--</div>--}}

                {{--<div class="member-contain">--}}
                    {{--<div>--}}
                        {{--<div class="huiyuan">--}}
                            {{--<i class="huiyuan-icon"></i>--}}

                        {{--</div>--}}
                        {{--<p>月vip会员</p>--}}
                    {{--</div>--}}

                    {{--<div>--}}
                        {{--<div class="dengji">--}}
                            {{--<i class="dengji-icon"></i>--}}
                            {{--<span class="dengji-num">{{$user->vip_level}}</span>--}}
                        {{--</div>--}}
                        {{--<p>会员等级</p>--}}
                    {{--</div>--}}


                    {{--<div>--}}
                        {{--<div class="jifen">--}}
                            {{--{{$user->points}}--}}
                        {{--</div>--}}
                        {{--<p>总积分</p>--}}
                    {{--</div>--}}

                {{--</div>--}}
            {{--</div>--}}

        {{--</div>--}}

        {{--<div class="member_center_middle">--}}
            {{--<div class="one-img">--}}
                {{--<button class="month-btn" onclick="toMonth()">继费月会员</button>--}}
                {{--<img src="/images/member/member-center-three.jpg"  border="0" />--}}
            {{--</div>--}}

            {{--<div class="two-img">--}}
                {{--<button class="season-btn" onclick="toSeason()">成为季会员</button>--}}
                {{--<img src="/images/member/member-center-four.jpg"   border="0" />--}}
            {{--</div>--}}

            {{--<div class="three-img">--}}
                {{--<button class="year-btn" onclick="toYear()">成为年会员</button>--}}
                {{--<img src="/images/member/member-center-five.jpg"  border="0" />--}}
            {{--</div>--}}



        {{--</div>--}}
    {{--</div>--}}

    <div class="members_bj">
        <div class="wrapper">
            <div class="members_left">
                <h2>印际会员信息</h2>
                <h3>精选全球优秀作品，印际让你设计更上一层楼！</h3>
            </div>
            <div class="members_box" style="position: relative">
                <div style="position: absolute; top:20px; right: 20px;">{{substr($user->expire_time,0,10)}}到期</div>
                <div class="members_top"><img src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$user->nickname}}"></div>
                <div class="members_name">{{$user->nickname}}</div>
                <hr>
                <div class="members_info">
                    <ul>
                        <li><i class="ico_vip1"><img src="@if($user->level==1) /images/32vip_03.png @elseif($user->level==2) /images/32vip_05.png @else /images/32vip_07.png @endif " alt="月VIP会员"></i>月VIP会员</li>
                        <li><i class="ico_vip1"><img src="/images/v_r_{{$user->vip_level}}.png" alt="会员V1"></i>会员等级</li>
                        <li><i>{{$user->points}}</i>我的积分</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="wrapper">
        <div class="buy_vip">
            <ul>
                <li><i><img src="/images/vip_03.png" alt="月VIP会员"></i><h2>月VIP会员</h2><p>月度VIP会员尊享权益</p><span>尊贵表示</span><span>个人主页</span><span>限量下载</span><span>9折优惠</span>
                    <button onclick="toMonth()">继费会员</button>
                </li>
                <li><i><img src="/images/vip_05.png" alt="月VIP会员"></i><h2>季VIP会员</h2><p>季度VIP会员尊享权益</p><span>10G大空间</span><span>海量下载</span><span>下载加速</span><span>85折优惠</span>
                    <button style="background-color:blueviolet; " onclick="toSeason()">成为季会员</button>
                </li>
                <li><i><img src="/images/vip_07.png" alt="月VIP会员"></i><h2>年VIP会员</h2><p>年度VIP会员尊享权益</p><span>20G大空间</span><span>海量下载</span><span>上传图片</span><span>8折优惠</span>
                    <button style="background-color:#16b387; " onclick="toYear()">成为年会员</button>
                </li>
            </ul>
        </div>
        <div class="vip_jf fl" style="margin-left: 50px;">
            <img src="/images/vip_17.png" alt="月VIP会员">
            <dl>
                <dt>如何获取积分</dt>
                <dd>1、新注册会员可获得积分</dd>
                <dd>2、成为会员可以获得积分</dd>
                <dd>3、每日签到即可获得相应积分</dd>
                <dd>4、商城消费可以获得相应积分</dd>
            </dl>
        </div>
        <div class="vip_jf fr" style="margin-right: 50px;">
            <img src="/images/vip_20.png" alt="月VIP会员">
            <dl>
                <dt>如何使用积分</dt>
                <dd>1、积分可在印际商城换购任意商品！</dd>
                <dd>2、在商城购买商品时候可以抵扣现金！</dd>
            </dl>
        </div>
    </div>

</section>

{{--<div class="member_center_bj">--}}

    {{--<div class="member_center_foot">--}}
        {{--<img src="/images/member/member-center-six.jpg"  border="0" />--}}
        {{--<img src="/images/member/member-center-seven.jpg" border="0" />--}}
    {{--</div>--}}

{{--</div>--}}


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

        <li class="determine vipfee_type1" vip_level="1" price="{{$month_price or '0.01'}}" omit="108"><em>{{$month_price or '0.01'}}</em>元<p>月会员</p><del>原价：108元</del></li>

                <li class="vipfee_type2" vip_level="2" price="{{$season_price or '0.01'}}" omit="324"><em>{{$season_price or '0.01'}}</em>元<p>季会员</p><del>原价：324元</del></li>

                <li class="vipfee_type3" vip_level="3" price="{{$year_price or '0.01'}}" omit="1296"><em>{{$year_price or '0.01'}}</em>元<p>年会员</p><del>原价：1296元</del></li>
      </ul>

    </div>

    <div class="vip_check">

     <ul>

     <li><input name="" type="checkbox" value="" checked="checked" />到期自动续费一个月，可随时取消</li>

     <li><input name="" type="checkbox" value="" /><a href="#">同意并接受《服务条款》</a></li>

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

<script>





    $(document).on("click",".openVip",function () {
        $(".new_folder_box").show();
        return false;

    })



    $(document).on("click",".vip_close",function () {

        $(".new_folder_box").hide();

        return false;

    })


    function toMonth(){
        $(".new_folder_box").show();
        $('.vip_select li').removeClass('determine');
        // console.log($('.vip_select li').eq(0))
        $('.vip_select li').eq(0).addClass('determine');
        return false;
    }



    function toSeason(){
        $(".new_folder_box").show();
        $('.vip_select li').removeClass('determine')
        $('.vip_select li').eq(1).addClass('determine')
        return false;
    }

    function toYear(){
        $(".new_folder_box").show();
        $('.vip_select li').removeClass('determine')
        $('.vip_select li').eq(2).addClass('determine')
        return false;
    }


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
                //window.location = '/vip/buy?vip_type=' + vip_type;
                //return;

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

@endsection

