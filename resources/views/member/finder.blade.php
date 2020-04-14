@extends('layouts.app')







@section('title')



  {{trans('comm.yinji')}} - 个人中心 -发现中心



@endsection

@section('content')

<style>

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

  <div class="home_banber"> <img src="/images/home_bj.jpg" alt="个人主页图片" /></div>

  <div class="home_tongji">

    <ul>

      <li> 订阅</br>

        {{$user->subscription_num}} </li>

      <li> 收藏</br>

        {{$user->collect_num}} </li>

      <li> 积分</br>

        {{$user->points}} </li>

      <li> 关注</br>

        {{$user->follow_num}} </li>

    </ul>

  </div>

  <div class="home_personal"> <img src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$user->nickname}}" />

  

  </div>

  <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> {{$user->nickname}}  @if($user->is_vip)<span class="vip1">VIP{{$user->level}}</span>@else<span class="vip1" style="background-color:#ccc;color:#fff;">普通用户</span> @endif </h2>
  <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;">个人说明： {{$user->personal_note}}</p>

  <div class="home_nav">

    <ul>

      <li><a  href="/member">个人中心</a></li>

      <li class="current"><a href="/member/finder">我的发现</a></li>

      <li><a href="/member/collect">我的收藏</a></li>

      <li><a href="/member/subscription">我的订阅</a></li>

      <li><a href="/member/follow">我的关注</a></li>

      <li><a href="/member/point">我的积分</a></li>

      <li><a href="/member/profile">个人资料</a></li>

    </ul>

  </div>

</div>

<section class="wrapper">

  <div class="mt30 home_box">

    <div class="title">

      <h2 class="fl">我的发现</h2>

      <span class="fr"><a href="javascript:;" data-type="find" class="create-new-folder">+ 创建新文件</a></span> </div>

      <!--VIP专栏提示-->
		
      <div class="vip_prompt modal vip_prompt-member" id="vip-img"><a href="#" class="vip_buy">开通VIP会员</a><a href="#" class="vip_detail">了解VIP详情>></a></div>



    <div class="my-find-list" >



      @foreach($user->finders as $finder)

      <div class="item">

        <div class="item__content" style="position:relative">

          <ul data-id="{{$finder['folder']['id']}}" onclick="location.href='/member/finder_detail/{{$finder['folder']['id']}}'">

            @foreach($finder['finder'] as $img_obj)

                  @if ($img_obj['img'])

                    <li>

                        <a >

                            <img src="{{$img_obj['img']}}" />

                        </a>

                    </li>

                  @endif

            @endforeach

          </ul>

         <div class="edit_favorites fr" folder-type="find" data-id="{{$finder['folder']['id']}}">编辑</div>

          <div class="find_title">

            <h2><a>{{$finder['folder']['name']}}</a></h2>

               <div class="find_images"> <i class="icon-eye" title="公开"></i> {{$finder['folder']['total']}}</div>

          </div>

       

        </div>

      </div>

      @endforeach

    </div>

  </div>

</section>

</div>

<!--创建发现文件夹-->

<div class="create_folder modal" id="collectionFolders">

  <div class="create_folder_title">

    <h2>编辑文件夹</h2>

  </div>

  <div class="close" onclick="layer.closeAll();">关闭</div>

  <input type="text" value=""  placeholder="发现夹名称（必填）" class="mt30 shoucang-name" name="edit_folder_name" id="edit_folder_name"/>

  <textarea name="edit_brief" id="edit_brief" placeholder="简介"  rows="5" class="mt30 folder_introduction"></textarea>

  <p class="mt30">

    <input name="edit_is_open" type="radio" value="1" checked="checked" />

    公开

    <input name="edit_is_open" type="radio" value="0" />

    不公开 </p>

  <div class="error_msg"></div>

  <div class="create_button">

    <input type="hidden" name="edit_folder_type" id="edit_folder_type" />

    <input type="hidden" name="edit_folder_id" id="edit_folder_id" />

    <input type="button" value="取消" class="button_gray concle-create-folder " onclick="layer.closeAll();" />

    <input type="button" value="确定" class="button_red edit_folder_btn"/>

  </div>

</div>

<!--创建收藏文件夹-->

<div class="create_folder modal" id="newFolders">

  <div class="create_folder_title">

    <h2>创建文件夹</h2>

  </div>

  <div class="close" onclick="layer.closeAll();">关闭</div>

  <input type="text" value=""  placeholder="发现夹名称（必填）" class="mt30" name="folder_name" id="add_folder_name"/>

  <textarea name="brief" id="add_brief" placeholder="简介"  rows="5" class="mt30 folder_introduction"></textarea>

  <p class="mt30">

    <input name="add_is_open" id="add_is_open" type="radio" value="1" checked="checked" />

    公开

    <input name="add_is_open" type="radio" value="0" />

    不公开</p>

  <div class="error_msg"></div>

  <div class="create_button">

    <input type="hidden" name="folder_type" id="add_folder_type" />

    <input type="button" value="取消" class="button_gray concle-create-folder " onclick="layer.closeAll();" />

    <input type="button" value="确定" class="button_red add_folder_btn"/>

  </div>

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



                <li class="determine vipfee_type1" vip_level="1" price="{{$month_price or '0.01'}}" omit="108"><em>{{$month_price or '0.01'}}</em>元<p>月会员</p><del>原价：108元</del></li>



                <li class="vipfee_type2" vip_level="2" price="{{$season_price or '0.01'}}" omit="324"><em>{{$season_price or '0.01'}}</em>元<p>季会员</p><del>原价：324元</del></li>



                <li class="vipfee_type3" vip_level="3" price="{{$year_price or '0.01'}}" omit="1296"><em>{{$year_price or '0.01'}}</em>元<p>年会员</p><del>原价：1296元</del></li>

            </ul>



        </div>



        <div class="vip_check">



            <ul>



                <!---li><input name="" type="checkbox" value="" checked="checked" />到期自动续费一个月，可随时取消</li--->



                <li><input name="" type="checkbox" value="" checked="checked"  /><a href="#">同意并接受《服务条款》</a></li>



            </ul>



        </div>



        <div class="vip_pay">



            <form class="cart vip_pay" action="/vip/wxbuy" method="post" enctype="multipart/form-data">

                <input type="hidden" name="vip_type" id="vip_type" value="1" />

                <input type="hidden" name="payment_code" id="payment_code" value="wechatpay" />

                <input type="hidden" name="pay_total" id="pay_total" value="{{$month_price or '0.01'}}" />

                <input type="hidden" name="open_id" id="open_id" value="ohPM_1TdJ-oXTAWy7rP-82CT3glo" />



                <p class="vip_pay_msg">应付：<span>{{$month_price or '0.01'}}</span>元 ( 立省9元)</p>



                <p>



                    <button type="button" class="single_add_to_cart_button button_red alt" id="buy_now_button">立即购买 </button>



                </p>



            </form>



        </div>



    </div>



</div>



<!--------选购会员结束------->



<!--VIP专栏提示结束-->

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



{{--会员购买模块--}}

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

@endsection 