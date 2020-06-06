@extends('layouts.app')

@section('title')
  {{trans('comm.yinji')}} - TA的发现
@endsection

@section('content')
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
  <div class="home_banber"> <img src="/images/home_bj.jpg" alt="个人主页图片" /></div>
  <div class="home_tongji">
    <ul>
        <li>人气</br>{{$users->view_num}} </li>
        <li>收藏</br>{{App\User::getCollectNum($users->id)}} </li>
        <li>关注</br>{{App\User::getFollowNum($users->id)}} </li>
        <li>粉丝</br>{{App\User::getFansNum($users->id)}} </li>
    </ul>
  </div>

  <div class="home_personal"> <img src="@if($users->avatar) {{$users->avatar}} @else /img/avatar.png @endif" alt="{{$users->nickname}}" />
  </div>
  <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> {{$users->nickname}} <img src="{{$users->vip_level}}" alt=""></h2>
  <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;">@if($users->zhiwei){{$users->zhiwei}}@else 保密 @endif - {{$users->city}} <img src="{{App\User::getVipLevel($users->id)}}" alt=""></p>
  <p style="position:absolute; text-align:center;left: 0;top:450px;width: 100%;"><span style='padding: 5px 25px;display: inline-block;background: #3d87f1;margin: 20px auto;color: #fff;'>关注</span></p>
  <div class="home_nav" style='width:610px;left:52%;'>
    <ul>
        <li><a  href="/member/{{$users->id}}">TA的主页</a></li>
        <li class="current"><a href="/member/homepage_finder/{{$users->id}}">TA的发现</a></li>
        <li><a href="/member/homepage_collect/{{$users->id}}">TA的收藏</a></li>
        <li><a href="/member/homepage_subscription/{{$users->id}}">TA的订阅</a></li>
        <li><a href="/member/homepage_interactive/{{$users->id}}">TA的互动</a></li>
        <li><a href="/member/homepage_record/{{$users->id}}">印记</a></li>
    </ul>
  </div>
</div>

<section class="wrapper" >
  <div class="mt30 home_box" >
    <div class="title1" style='width: 100%;border-bottom: 1px solid #eee;margin-bottom: 20px;overflow: hidden;'>
      <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;display:block !important;'>TA的发现</span></h2>
    </div>
    @if($user->level==0)
        <!--VIP专栏提示-->
        <div class="vip_prompt modal vip_prompt-member" id="vip-img"><a href="#" class="vip_buy">开通VIP会员</a><a href="#" class="vip_detail">了解VIP详情>></a></div>

        

    @else
        <div class="my-find-list" >
            @foreach($users->finders as $finder)
            <div class="item">
                <div class="item__content" style="position:relative">
                <ul data-id="{{$finder['folder']['id']}}" onclick="location.href='/member/hp_finder_detail/{{$users->id}}/{{$finder['folder']['id']}}'">
                    @foreach($finder['finder'] as $img_obj)
                        @if ($img_obj['img'])
                            <li>
                                <a href="/member/hp_finder_detail/{{$users->id}}/{{$finder['folder']['id']}}"><img src="{{$img_obj['img']}}" /></a>
                            </li>
                        @endif
                    @endforeach
                </ul>

                <div class="find_title">
                    <h2><a>{{$finder['folder']['name']}}</a></h2>
                    <div class="find_images"> <i class="icon-eye" title="公开"></i> {{$finder['folder']['total']}}</div>
                </div>
                </div>

            </div>
            @endforeach
        </div>
    @endif
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