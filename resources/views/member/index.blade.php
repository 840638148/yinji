@extends('layouts.app')
@section('title')
  {{trans('comm.yinji')}} - {{trans('index.home')}}
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
  right: 123px;
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
      right: 0;
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
  .sign_box{
    width: 610px;
    padding: 20px;
    min-height: 400px;
    height: 680px;
    position: fixed;
    z-index: 9999;
    background: #fff;
    top: 16%;
    left: 50%;
    margin-left: -305px;
    box-shadow: 0px 0px 5px rgba(0,0,0,3);
    border-radius: 3px;
    overflow: auto;
  }
  .change_box{
    display:none;
  }
  .img_browse{
    position: fixed;
    left: 50%;
    top:50%;
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
  .lzcfg{
    background: rgba(0,0,0,0.5);
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    display: none;
    z-index: 999;
  }
</style>
<!--笼罩层-->
<div class="lzcfg"></div>
<div class="home_top">
  <div class="home_banber"> <img src="/images/home_bj.jpg" alt="个人主页图片" /></div>
  <div class="home_tongji">
  <ul>
      <li>{{trans('index.discovery')}}</br>
        {{$user->finder_num}} </li>
      <li> {{trans('index.collection')}}</br>
        {{$user->collect_num}} </li>
      <li> {{trans('index.subscription')}}</br>
        {{$user->subscription_num}} </li>
      <li> {{trans('index.focus_on')}}</br>
        {{$user->follow_num}} </li>
    </ul>
  </div>
  <div class="home_personal"> <img src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$user->nickname}}" />
   
  </div>
  <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> {{$user->nickname}} <img src="{{$user->vip_level}}" alt=""></h2>
  <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;">{{trans('index.personal_description')}}： {{$user->personal_note}}</p>
  <div class="home_nav">
    <ul>
    	
	      <li class="current"><a  href="/member">{{trans('index.home')}}</a></li>
	      <li><a href="/member/finder">{{trans('index.my_finder')}}</a></li>
	      <li><a href="/member/collect">{{trans('index.my_collection')}}</a></li>
	      <li><a href="/member/subscription">{{trans('index.my_subscription')}}</a></li>
	      <li><a href="/member/follow">{{trans('index.my_interactive')}}</a></li>
	      <li><a href="/member/mydown">{{trans('index.my_download')}}</a></li>
	      <li><a href="/member/profile">{{trans('index.the_personal_data')}}</a></li>
    </ul>
  </div>
</div>
<section class="wrapper">
  <div class="mt30 home_box">
    <div class="order_center">
      <ul>
        <!-- <li class="order1"><a href="/vip/index/{{$user->id}}">我的主页</a><i class="order1_bj"></i> </li> -->
        <li class="order1"><a href="/member/{{$user->id}}">{{trans('index.home')}}</a><i class="order1_bj"></i> </li>
        <li class="order2"><a href="/vip/intro">{{trans('index.become_a_member')}}</a><i class="order1_bj"></i> </li>
        <li class="order3"><a href="/member/point">{{trans('index.my_points')}}</a><i class="order1_bj"></i> </li>
        <li class="order4 bookInSign"><a href="javascript:;">{{trans('index.sign_in')}}</a></li>
      </ul>
    </div>
    <div class="title">
      <h2>{{trans('index.my_subscription')}}</h2>
    </div>
    <div class="designer">
      <ul>
        @foreach ($user->subscriptions as $key => $subscription)
              @if ($key < 13)
                <li class="dingyue-item"> <a href="/designer/detail/{{$subscription->id}}" onclick="selectItem({{$key}})" target="_blank" title="{{get_designer_title($subscription)}}"><span class="select-item"></span> <img src="{{get_designer_thum($subscription)}}" alt="{{get_designer_title($subscription)}}" /> </a> </li>
              @endif

             @if ($key==13)
                  <li><a href="/member/subscription" class="more-content"></a></li>
              @endif
        @endforeach
      </ul>
    </div>
    



    <!----------设计师订阅结束------->
    @if($user->is_vip)
    <div class="title mt30">
      <h2>{{trans('index.my_attention')}}</h2>
    </div>
    <div class="designer">
      <ul>
        @foreach ($user->follows as $key => $follow)
              @if ($key < 13)
                <li class="guanzhu-item"> <a href="/member/{{$follow->id}}" title="{{$follow->nickname}}" onclick="selectItemGuanZhu({{$key}})"><span class="select-item"></span>  <img onerror="this.onerror=``;this.src=`/img/avatar.png`" src="@if($follow->avatar) {{$follow->avatar}} @else /img/avatar.png @endif" alt="{{$follow->nickname}}" /> </a> </li>
              @elseif($key == 13)
                      <li><a href="/member/follow" class="more-content"></a></li>
                @endif
             @endforeach
      </ul>
    </div>
    
    <div class="title  mt30">
      <h2 class="fl">{{trans('index.my_finder')}}</h2>
      <span class="fr"><a href="/member/finder">{{trans('index.more')}}</a></span>
    </div>
    <!--<div class="masonry my-finder" >需要点击图片打开弹窗就开启这个 -->
    <!--<div class="masonry flex-item" >-->
    <div class="masonry" >

        @foreach($user->finders as $key=>$finder)
              <!--<div class="item collection-item item-col" data-id="{{$finder['folder']['id']}}">-->
              <div class="item collection-item " data-id="{{$finder['folder']['id']}}" onclick="location='/member/finder_detail/{{$finder['folder']['id']}}'">
                <div class="item__content">
                  <ul data-id="{{$finder['folder']['id']}}" 	>
                    @foreach($finder['finder'] as  $img_obj)
                          @if ($img_obj['img'])
                            <li><a href="/member/finder_detail/{{$finder['folder']['id']}}"><img src="{{$img_obj['img']}}" /></a></li>
                            <!--<li><a><img src="{{--$img_obj['img']--}}" /></a></li>-->
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
    <div class="title  mt30">
    
      <h2 class="fl">{{trans('index.my_collection')}}</h2>
      <span class="fr"><a href="/member/collect">{{trans('index.more')}}</a></span> </div>
    <div class="masonry my-collection" >   
      @foreach($user->collects as $collect)
      <div class="item collection-item " data-id="{{$collect['folder']['id']}}" onclick="location='/member/collect_detail/{{$collect['folder']['id']}}'">
        <div class="item__content">
          <ul data-id="{{$collect['folder']['id']}}" >
            @foreach($collect['collect'] as $img_obj)
            <li><a href="/member/collect_detail/{{$collect['folder']['id']}}"><img src="{{$img_obj['img']}}" /></a></li>
            @endforeach
          </ul>
          <div class="find_title">
            <h2><a>{{$collect['folder']['name']}}</a></h2>
          <div class="collection_images">  <i class="icon-eye" title="公开"></i> {{$collect['folder']['total']}}</div>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
</section>
<div class="sign_box modal" id="bookInSign">
<div class="sign_integral_box" style=" height:100px;">
  <div class="left integral" style="width:400px;">
    <div class="sign_ico left"></div>
    <h2 class="left">印币：<span id="user-point">{{$user->points}}</span>分</h2>
    <p class="left" style="width:316px; margin-left:20px;">已连续签到<span id="last-day">{{$last_days or '0'}}</span>天</p>
  </div>
  <span class="closebtn" onclick="layer.closeAll();" style="position: absolute;right:0;top:0;padding: 10px 10px 5px 10px;cursor: pointer;">╳</span>
  @if($is_qiandao)
      <a href="javascript:void(0);" class="fr Button6 mt10" disabled="disabled" id="attendances">已签到</a> 
  @else
      <a href="javascript:void(0);" class="fr Button3 mt10" id="attendance" style="position: absolute;right:30px;top:50px;">签到</a> 
  @endif
  </div>
<div class="sign_tab">
  <ul>
    <li class="active record_tab">签到记录</li>
    <li class="change_tab">签到规则</li>
  </ul>
</div>
<!------签到记录---------->
<div class="record_box tab_box">
  <div class="record">
    <ul>
      @foreach ($tips as $tip)
      @if ($loop->first && $last_days > 0)
      <li class="active"> 
      @else

      <li> @endif
        <h3>{{$tip['title']}}</h3>
        <p>+{{$tip['point']}}</p>
      </li>
      @endforeach
    </ul>
  </div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="record_details">
      <tbody>
    
    <tr>
      <th>用户名</th>
      <th>获得印币</th>
      <th>等级</th>
      <th>签到时间</th>
    </tr>
    <tr>
      <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="record_details2">
          <tbody>
          @if ($attendances)
          @foreach($attendances as $attendance)
          <tr>
            <td>{{$attendance->user->nickname or ''}}</td>
            <td>+{{$attendance->point or ''}}</td>
            <td><img src="{{$attendance->vip_level}}" alt=""></td>
            <td>{{$attendance->created_at->toDateString()}}</td>
          </tr>
          @endforeach
              @endif
            </tbody>
          
        </table></td>
    </tr>
      </tbody>
    
  </table>
  <div class="shuomin">说明：连续签到可获得{{trans('index.more')}}积 ，本站印币可增加下载次数和会员费用抵扣。<br>
   使用规则：即10印币=1元，每增加一次下载次数使用10印币！</div>
</div>
<!------签到记录结束---------->
<!--------签到规则--------->
<div class="change_box tab_box">
  <div class="change">
    <table style="text-align:center;margin-top:30px;">
      <tr>
        <td>连续签到天数</td>
        <td>1~4</td>
        <td>5</td>
        <td>6~14</td>
        <td>15</td>
        <td>16~29</td>
        <td>30</td>
        <td>31+</td>
        <td>30+15*n</td>
      </tr>

      <tr>
        <td>基础印币</td>
        <td>10</td>
        <td>25</td>
        <td>20</td>
        <td>40</td>
        <td>20</td>
        <td>70</td>
        <td>30</td>
        <td>130</td>
      </tr>

      <tr>
        <td>会员种类</td>
        <td colspan='3'>月会员</td>
        <td colspan='2'>季会员</td>
        <td colspan='3'>年会员</td>
      </tr>

      <tr>
        <td>会员额外印币</td>
        <td colspan='3'>+5</td>
        <td colspan='2'>+10</td>
        <td colspan='3'>+15</td>
      </tr>

      <tr>
        <td>会员等级</td>
        <td>VIP1</td>
        <td>VIP2</td>
        <td>VIP3</td>
        <td>VIP4</td>
        <td>VIP5</td>
        <td>VIP6</td>
        <td>VIP7</td>
        <td>VIP8</td>
      </tr>

      <tr>
        <td>等级额外印币</td>
        <td>+2</td>
        <td>+4</td>
        <td>+6</td>
        <td>+8</td>
        <td>+10</td>
        <td>+13</td>
        <td>+16</td>
        <td>+20</td>
      </tr>
      <tr><td colspan='9'>说明：签到最终印币=基础印币+会员额外印币+等级额外印币，节日{{trans('index.more')}}惊喜等着你哦！</td></tr>
    </table>
  </div>
</div>
<!--------签到规则结束--------->
</div>
    
  <script type="text/javascript">

    function selectItem(index){
      $('.dingyue-item .select-item').hide()
      $($('.dingyue-item')[index]).find('.select-item').show()
      localStorage.setItem("selectdD", index);
    }

    function selectItemGuanZhu(index){
      $('.guanzhu-item .select-item').hide()
      $($('.guanzhu-item')[index]).find('.select-item').show()
      localStorage.setItem("selectdG", index);
    }



    $(document).ready(function(){
        if(IS_VIP){
            $('.order_center .order2').find('a').html('{{trans("index.the_member_center")}}')
            $('.order_center .order2').find('a').attr('href','/member/interest')
        }

        $('.dingyue-item .select-item').hide()
        var dIndex = localStorage.getItem('selectdD')
        $($('.dingyue-item')[dIndex]).find('.select-item').show()

        $('.guanzhu-item .select-item').hide()
        var gIndex = localStorage.getItem('selectdG')
        $($('.guanzhu-item')[gIndex]).find('.select-item').show()

        //最多显示8条数据
        for(var i=0;i<$('.my-collection .collection-item').length;i++){
          if(i>7){
            $($('.my-collection .collection-item')[i]).hide()
          }
        }

        for(var i=0;i<$('.my-finder .collection-item').length;i++){
          if(i>7){
            $($('.my-finder .collection-item')[i]).hide()
          }
        }

      //取消订阅
      $(".cancelSubscription").click(function(e){
        var designer_id = $(this).attr('data-id');
        $.ajax({
          url: '/member/cancel_subscription',
          type: 'POST',
          dataType: 'json',
          data: {_token:'{{csrf_token()}}',designer_id:designer_id},
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

  <!--创建收藏文件夹-->
  <div class="create_folder modal" id="newFolders">
    <div class="create_folder_title">
        <h2>创建文件夹</h2>
    </div>
    <div class="close" onclick="layer.closeAll();">关闭</div>
    <input type="text" value=""  placeholder="收藏夹名称（必填）" class="mt30" name="folder_name" id="add_folder_name"/>
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
<!--创建收藏文件夹-->
<div class="create_folder modal" id="collectionFolders">
    <div class="create_folder_title">
        <h2>编辑文件夹</h2>
    </div>
    <div class="close" onclick="layer.closeAll();">关闭</div>
    <input type="text" value=""  placeholder="收藏夹名称（必填）" class="mt30" name="folder_name" id="edit_folder_name"/>
    <textarea name="memo" placeholder="简介"  rows="5" class="mt30 folder_introduction"></textarea>
    <p class="mt30">
        <input name="is_open" type="radio" value="1" checked="checked" />
        公开
        <input name="is_open" type="radio" value="0" />
        不公开</p>
    <div class="error_msg"></div>
    <div class="create_button">
        <input type="hidden" name="folder_id" id="edit_folder_id" />
        <input type="hidden" name="folder_type" id="edit_folder_type" />
        <input type="button" value="取消" class="button_gray concle-create-folder " onclick="layer.closeAll();" />
        <input type="button" value="确定" class="button_red edit_folder_btn"/>
    </div>
</div>

<!-- 微信注册的第一次进入个人主页出现弹窗 -->
<div class='txxx' style='width: 340px;height: 445px;background: #fff;position:absolute;top:40%;left: 40%;z-index:9999;padding:20px;border-radius: 10px;display:none;'>
  <form id="info-form" class="contribute_form" role="form" method="POST" action="/member/one_check"  onsubmit="return checkforms()">
    <p style="width:292px;">  
      <label for="nickname">
        <input type="text" id='nickname' value="" placeholder='请填写昵称' style="height:46px;border-radius: 5px;">
      </label>  
      <span style='font-size:10px;margin-top:-5px;color:#ccc;'>(非会员用户只能更改一次)</span>
    </p>
    <p style="position:relative;width:292px;margin: 10px 0;">
      <label for="user_phone">
        <input type="tel" style='border-radius: 5px;' name="user_phone" maxlength='11' id="user_phone" class="input" value="" size="20" placeholder="输入手机号">
      </label>
    </p>
    <p style="width:292px;">
      <label class='code_tel' for="verification_code" style="position:relative">
        <input type="text" name="verification_code" style="height:46px;border-radius: 5px;" id="verification_code" class="input" value="" size="20" placeholder="输入手机验证码">
        <input style="padding: 0 19px;height:46px;" name="发送验证码" type="button" value="获取验证码" class="verification">
      </label>
    </p>
    <p>职位：
      <select style="width:245px;border: 1px solid #ddd;height:42px;line-height:27px;color:#666;margin-top:10px;border-radius: 5px;" id="zhiwei" name="zhiwei" value="职位">
          <option name="jzs" value="" >请选择您的职业</option>
          <option name="jzs" value="建筑师" >建筑师</option>
          <option name="snsjs" value="室内设计师">室内设计师</option>
          <option name="rzsjs" value="软装设计师">软装设计师</option>
          <option name="cpsjs" value="产品设计师">产品设计师</option>
          <option name="sys" value="摄影师">摄影师</option>
          <option name="mtr" value="媒体人">媒体人</option>
          <option name="fckf" value="地产开发">地产开发</option>
          <option name="qt" value="其他">其他</option>    
      </select>
    </p>
    <p style="margin-top:20px ;"> 
        地区：<select name='provinces' id="provinces" style="height: 42px;border-radius: 5px;width: 120px;margin-left: 4px;">  <option value="" id="selectpro"  >请选择省份</option></select>  
        <select id="citys" name='citys' style="height: 42px;border-radius: 5px;width: 120px;"><option value="">请选择市</option></select> 
    </p>
    <p class="submit0" style='margin-top:23px;'>
      <input type="hidden" name="_token" value="{{csrf_token()}}">
      <button type="button" id="wp-submit-1" class="button button-primary button-large" value=""> 确定 </button>
    </p>
  </form>
</div>


<!-- 邮箱注册第一次进入个人主页出现弹窗 -->
<div class='emailxx' style='width: 340px;height: 246px;background: #fff;position:absolute;top:40%;left: 40%;z-index:9999;padding:20px;border-radius: 10px;display:none;'>
  <form id="info-form" class="contribute_form" role="form" method="POST" action="/member/one_check"  onsubmit="return checkforms()">

    <p style="position:relative;width:292px;margin: 10px 0;">
      <label for="user_phone">
        <input type="tel" style='border-radius: 5px;' name="user_phone" maxlength='11' id="user_phone" class="input" value="" size="20" placeholder="输入手机号">
      </label>
    </p>
    <p style="width:292px;">
      <label class='code_tel' for="verification_code" style="position:relative">
        <input type="text" name="verification_code" style="height:46px;border-radius: 5px;" id="verification_code" class="input" value="" size="20" placeholder="输入手机验证码">
        <input style="padding: 0 19px;height:46px;" name="发送验证码" type="button" value="获取验证码" class="verification">
      </label>
    </p>

    <p class="submit0" style='margin-top:23px;'>
      <input type="hidden" name="_token" value="{{csrf_token()}}">
      <button type="button" id="wp-submit-2" class="button button-primary button-large" value=""> 确定 </button>
    </p>
  </form>
</div>

<script src="/js/laravel-sms.js"></script>
<script src="/js/layer.js"></script>
<script src="/js/member.js"></script>
<script type="text/javascript">
  $(function() {  
    //页面初始，加载所有的省份  
      $.ajax({  
          type: "post",  
          url: "/member/citysjld",  
          data: {"type":1,_token: "{{csrf_token()}}"},  
          dataType: "json",  
          success: function(data) {  
              //遍历json数据，组装下拉选框添加到html中
              $("#provinces").append("<option value=''>请选择省</option>");  
              $.each(data, function(i, item) {  
                  $("#provinces").append("<option value='" + item.province_num + "'>" + item.province_name + "</option>");  
              });
          }  
      });      
    // })

    //监听省select框
    $("#provinces").change(function() {  
        $.ajax({  
            type: "post",  
            url: "/member/citysjld",
            data: {"pnum": $(this).val(),"type":2,_token: "{{csrf_token()}}"},  
            dataType: "json",  
            success: function(data) {  
                //遍历json数据，组装下拉选框添加到html中
                $("#citys").html("<option value=''>请选择市</option>");  
                $.each(data, function(i, item) {  
                    $("#citys").append("<option value='" + item.city_num + "'>" + item.city_name + "</option>");  
                });  
            }  
        });  
    });  

  });  
</script>
<script>
  $(function() { 
    $.ajax({  
        type: "post",  
        url: "/member/one_visited",  
        data: {_token: "{{csrf_token()}}"},  
        dataType: "json",  
        success: function(data) {  
          // console.log(data)
          if(data.status_code == 200){
            $('.lzcfg').show(500)
            $('.txxx').show(500)
            $('.emailxx').empty()
          }else if(data.status_code == 100){
            $('.lzcfg').show(500)
            $('.emailxx').show(500)
            $('.txxx').empty()
          }else{
            // layer.msg(data.message,{time: 1500,skin: 'intro-login-class layui-layer-hui'});
          }
          
        }  
    });      
  })
</script>

<script type="text/javascript">
// 阻止提交表单
  function checkforms(){
    return false;//false:阻止提交表单
  }

  function wp_attempt_focus() {
    setTimeout(function () {
      try {
          d = document.getElementById('user_phone');
          d.focus();
          d.select();
      } catch (e) {

      }
    }, 200);
  }

  wp_attempt_focus();
  if (typeof wpOnload == 'function') wpOnload();
  //获取验证码
  var is_sending = false;
  var time_limit = 60;
  var next_time = time_limit;
  var cap_btn = $('.verification');

  cap_btn.sms({
    //laravel csrf token
    token       : "{{csrf_token()}}",
    //请求间隔时间
    interval    : 60,
    //请求参数
    requestData : {
        //手机号
        mobile : function () {
            return $.trim($('#user_phone').val());
        },
        //手机号的检测规则
        mobile_rule : 'mobile_required'
    }
  });
  
  $("#wp-submit-1").click(function () {
    let nickname = $.trim($('#nickname').val());
    let mobile = $.trim($('#user_phone').val());
    let provinces = $.trim($('#provinces').val());
    let citys = $.trim($('#citys').val());
    let zhiwei = $.trim($('#zhiwei').val());
    let verification_code = $.trim($('#verification_code').val());

    if(nickname=='' || nickname == null || nickname == undefined){
      layer.msg('请填写昵称',{time:1500,skin: 'intro-login-class layui-layer-hui'});
      return false;
    }else
    if(mobile=='' || mobile == null || mobile == undefined){
      layer.msg('请填写手机号',{time:1500,skin: 'intro-login-class layui-layer-hui'});
      return false;
    }else
    if(zhiwei=='' || zhiwei == null || zhiwei == undefined){
      layer.msg('请填写职位',{time:1500,skin: 'intro-login-class layui-layer-hui'});
      return false;
    }else
    if(provinces=='' || provinces == null || provinces == undefined){
      layer.msg('请填写省份',{time:1500,skin: 'intro-login-class layui-layer-hui'});
      return false;
    }else

    if(verification_code=='' || verification_code == null || verification_code == undefined){
      layer.msg('请输入验证码',{time:1500,skin: 'intro-login-class layui-layer-hui'});
        return false;
    }
    if(nickname!='' && nickname != null && nickname != undefined){
      if (!/^[\u4E00-\u9FA5A-Za-z0-9]+$/.test(nickname)) {
        layer.msg('昵称规范:中文、英文、数字但不包括下划线等符号',{time:1500,skin: 'intro-login-class layui-layer-hui'});
        return false;
      }
    }
    if(mobile!='' && mobile != null && mobile != undefined){
      if (!/1[3-8][0-9]{9}/.test(mobile)) {
          layer.msg('请输入正确手机号',{time:1500,skin: 'intro-login-class layui-layer-hui'});
          return false;
      }
    }

    $.ajax({
        url: '/member/one_check',
        type: 'POST',
        dataType: 'json',
        data: {
            mobile: mobile,
            nickname: nickname,
            zhiwei: zhiwei,
            provinces: provinces,
            citys: citys,
            verification_code: verification_code,
            _token: "{{csrf_token()}}",
        },
        success: function (data) {
            //console.log(data.status_code);
            if (data.status_code == 100) {
                layer.msg(data.message,{time:1500,skin: 'intro-login-class layui-layer-hui'});
                setTimeout(function () {
                    location.href = "/member";
                },1600);
            }else{
                layer.msg(data.message,{time:1500,skin: 'intro-login-class layui-layer-hui'});
            }
        }
    });
    
  });

  $("#wp-submit-2").click(function () {
    let mobile = $.trim($('#user_phone').val());
    let verification_code = $.trim($('#verification_code').val());

    if(mobile=='' || mobile == null || mobile == undefined){
      layer.msg('请填写手机号',{time:1500,skin: 'intro-login-class layui-layer-hui'});
      return false;
    }else
    if(mobile!='' && mobile != null && mobile != undefined){
      if (!/1[3-8][0-9]{9}/.test(mobile)) {
          layer.msg('请输入正确手机号',{time:1500,skin: 'intro-login-class layui-layer-hui'});
          return false;
      }
    }

    $.ajax({
        url: '/member/one_check',
        type: 'POST',
        dataType: 'json',
        data: {
            mobile: mobile,
            verification_code: verification_code,
            _token: "{{csrf_token()}}",
        },
        success: function (data) {
            //console.log(data.status_code);
            if (data.status_code == 100) {
                layer.msg(data.message,{time:1500,skin: 'intro-login-class layui-layer-hui'});
                setTimeout(function () {
                    location.href = "/member";
                },1600);
            }else{
                layer.msg(data.message,{time:1500,skin: 'intro-login-class layui-layer-hui'});
            }
        }
    });
    
  });


</script>
@endsection