@extends('layouts.app')

@section('title')
  {{trans('comm.yinji')}} - TA的互动
@endsection


@section('content')
<style>
  .container
  {
      position: absolute;
      top: 5%; left: 36%; right: 0; bottom: 0;
  }
  .action
  {
      width: 400px;
      height: 30px;
      margin: 10px 0;
  }
  .cropped>img
  {
      margin-right: 10px;
  }
  .imageBox
  {
      position: relative;
      height: 400px;
      width: 400px;
      border:1px solid #aaa;
      background: #fff;
      overflow: hidden;
      background-repeat: no-repeat;
      cursor:move;
      display: none;
      left: 400px;
      top: -159px;
  }

  .imageBox .thumbBox
  {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 120px;
      height: 120px;
      margin-top: -50px;
      margin-left: -60px;
      box-sizing: border-box;
      border: 1px solid rgb(102, 102, 102);
      box-shadow: 0 0 0 1000px rgba(0, 0, 0, 0.5);
      background: none repeat scroll 0% 0% transparent;
  }

  .imageBox .spinner
  {
      position: absolute;
      top: 0;
      left: 0;
      bottom: 0;
      right: 0;
      text-align: center;
      line-height: 400px;
      background: rgba(0,0,0,0.7);
  }
  body{background:#f8f8f8 !important;}
  .home_box{border-radius:10px !important;}
  .home_top{background:#fff !important;}
  .masonry{
	  display: flex;
	  justify-content: flex-start;
	  flex-wrap: wrap;
  }
  .masonry .item{
	  width: 25%;
  }
</style>
<div class="home_top">
<div class="home_banber"> 
    @if($users->zhuti)
    <img src="{{$users->zhuti}}" alt="个人主页图片" />
    @else
    <img src="/images/zhutibj.jpg" alt="个人主页图片" />
    @endif
  </div>

  <div class="home_tongji">
    <ul>
        <li>人气</br>{{App\User::getViewNum($users->id)}} </li>
        <li>收藏</br>{{App\User::getCollectNum($users->id)}} </li>
        <li>关注</br>{{App\User::getFollowNum($users->id)}} </li>
        <li>粉丝</br>{{App\User::getFansNum($users->id)}} </li>
    </ul>
  </div>
  <div class="home_personal"> <img src="@if($users->avatar) {{$users->avatar}} @else /img/avatar.png @endif" alt="{{$users->nickname}}" />
   
  </div>
  <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> {{$users->nickname}} <img src="{{$users->vip_level}}" alt=""></h2>
  <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;">@if($users->zhiwei){{$users->zhiwei}}@else 保密 @endif - {{$users->city}} <img src="{{App\User::getVipLevel($users->id)}}" alt=""></p>
  @if($user->id==$users->id)
  
  @elseif($users->is_follow)
  <p style="position:absolute; text-align:center;left: 0;top:450px;width: 100%;"><span class='have-disalbed' uid='{{$users->id}}' style='padding: 5px 25px;display: inline-block;background: #eee;margin: 20px auto;color: #666;cursor:no-drop !important;border-radius: 5px;'>已关注</span></p>
  @else
  <p style="position:absolute; text-align:center;left: 0;top:450px;width: 100%;"><span class='gzuser' uid='{{$users->id}}' style='padding: 5px 25px;display: inline-block;background: #3d87f1;margin: 20px auto;color: #fff;cursor: pointer !important;border-radius: 5px;'>关注</span></p>
  @endif
  <div class="home_nav" style='width:610px;left:52%;'>
    <ul>
        <li><a href="/member/{{$users->id}}">TA的主页</a></li>
        <li><a href="/member/homepage_finder/{{$users->id}}">TA的发现</a></li>
        <li><a href="/member/homepage_collect/{{$users->id}}">TA的收藏</a></li>
        <li><a href="/member/homepage_subscription/{{$users->id}}">TA的订阅</a></li>
	      <li class="current"><a href="/member/homepage_interactive/{{$users->id}}">TA的关注</a></li>
	      <li><a href="/member/homepage_fans/{{$users->id}}">TA的粉丝</a></li>
    </ul>
  </div>
</div>
<section class="wrapper" style='width:1245px;'>
  <div class="mt30 home_box">
    <div class="title">
      <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'>TA的关注</span></h2>
    </div>
    <div class="TabContent content-post"> 
      
      <!---我的关注开始--->
      
      <div id="myTab1_Content0" >
        
        <section class="wrapper">
          <div class="mt30 home_box">

            @if($user->level==0)
              <!--VIP专栏提示-->	
            <div class="vip_prompt modal vip_prompt-member" id="vip-img"><a href="javascript:void(0);" id="vip_buy" class="vip_buy">开通VIP会员</a><a href="/vip/intro" class="vip_detail">了解VIP详情>></a></div>
            @else
            <div class="masonry" > 
            @foreach ($users->follows as $follow)
              <div class="item">
                <div class="users">
                  <div class="border-bottom1" onclick='location="/member/{{$follow->id}}"'>
                    <div class="head"><a href="/member/{{$follow->id}}"><img style="margin-top:unset;" alt="头像" onerror="this.onerror=``;this.src=`/img/avatar.png`" src="@if($follow->avatar) {{$follow->avatar}} @else /img/avatar.png @endif" alt="{{$follow->nickname}}" /></a></div>
                    <h2 style='line-height:unset;'><a href="/member/{{$follow->id}}">{{$follow->nickname}}</a> </h2>
                    <p style="position:relative;margin:unset;"> 
                      
                      @if($follow->zhiwei){{$follow->zhiwei}} @else 其他 @endif
                      -
                      {{$follow->city}}

                    <span style="background:none;background: none;position: absolute;top: -3px;" class="VIP1"><img style="width:32px;" src="{{$follow->vip_level}}" alt=""></span> </p>
                    </div>
                  <div class="Statistics">
                    <ul>
                      <li><span>{{$follow->collect_num}}</span>收藏</li>
                      <li><span>{{$follow->fans_num}}</span>粉丝</li>
                    </ul>
                  </div>
                  @if($follow->has_follow)
                  <a href="javascript:void(0)" style="width:55px;background: #eee;color:#666;cursor: no-drop !important;padding: 8px 13px;border-radius: 5px;">已关注</a>
                  @else
                  <a href="javascript:void(0)" data-id="{{$follow->id}}" class="Button cancelFollow" style="width:60px;background: #636af3;color:#fff;">关注</a> 
                  @endif
                  </div>
              </div>
            @endforeach </div>
            </div>
          @endif
        </section>

      </div>
      <!-- TA的关注结束 -->


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
            <li><input name="" type="checkbox" value="" checked="checked" id="agree" /><a href="#">同意并接受《服务条款》</a></li>
        </ul>
    </div>

    <div class="vip_pay">
        <form class="cart vip_pay" action="/vip/wxbuy" method="post" enctype="multipart/form-data">
            <input type="hidden" name="vip_type" id="vip_type" value="1" />
            <input type="hidden" name="payment_code" id="payment_code" value="wechatpay" />
            <input type="hidden" name="pay_total" id="pay_total" value="{{$month_price or '0.01'}}" />
            <input type="hidden" name="open_id" id="open_id" value="ohPM_1TdJ-oXTAWy7rP-82CT3glo" />
            <p class="vip_pay_msg">应付：<span>{{$month_price or '0.01'}}</span>元 ( 立省9元)</p>
            <p><button type="button" class="single_add_to_cart_button button_red alt" id="buy_now_button">立即购买 </button></p>
        </form>
    </div>
  </div>
</div>
<!--------选购会员结束------->



</section>

<script src="/js/layer.js"></script> 
<script src="/js/member.js"></script>

<script>
$(document).ready(function(){
  if(!IS_VIP){
      $('#vip-img').show();
  }

    // $(document).on("click", ".vip_prompt .vip_buy",function () {
    $('#vip_buy').click(function () {
        $(".new_folder_box").show();
        layer.closeAll();
        // alert(123)
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


<script type="text/javascript">
  // 关注TA
  $('.gzuser').click(function(){
  let gzid=$(this).attr('uid');
  let that=$(this);
  $.ajax({
      url: '/member/gzta',
      type: 'POST',
      dataType: 'json',
      data: {_token:'{{csrf_token()}}',gzid:gzid},
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
    //关注
    $(".cancelFollow").click(function(e){
      let gzid = $(this).attr('data-id');
      console.log(gzid)
      $.ajax({
        url: '/member/gzta',
        type: 'POST',
        dataType: 'json',
        data: {_token:'{{csrf_token()}}',gzid:gzid},
        success: function (data) {
          if (data.status_code == 100) {
            layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'});
            // window.location.reload();
          } else {
            layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'});
          }
        }
      });
    });
  });
</script> 
@endsection