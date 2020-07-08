@extends('layouts.app')



@section('title')

  {{trans('comm.yinji')}} - {{trans('index.Personal_Data_Centre')}}

@endsection


@section('content')
<style>
  body{background:#f8f8f8 !important;}
  .home_box{border-radius:10px !important;}
  .home_top{background:#fff !important;}
  .container{
    position: absolute;
    top: 5%; left: 36%; right: 0; bottom: 0;
  }

  .action{
    width: 400px;
    height: 30px;
    margin: 10px 0;
  }

  .cropped>img{
    margin-right: 10px;
  }

  .imageBox{
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

  .imageBox .thumbBox{
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

  .imageBox .spinner{
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    text-align: center;
    line-height: 400px;
    background: rgba(0,0,0,0.7);
  }

</style>
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
      <li> {{trans('index.follow')}}</br>
        {{$user->follow_num}} </li>
    </ul>
  </div>
  <div class="home_personal"> <img src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$user->nickname}}" /> </div>
  <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> {{$user->nickname}} <img src="{{$user->vip_level}}" alt=""></h2>
  <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;">{{trans('index.personal_description')}}： {{$user->personal_note}}</p>
  <div class="home_nav">
    <ul>
        <li><a href="/member">{{trans('index.home')}}</a></li>
	      <li><a href="/member/finder">{{trans('index.my_finder')}}</a></li>
	      <li><a href="/member/collect">{{trans('index.my_collection')}}</a></li>
	      <li><a href="/member/subscription">{{trans('index.my_subscription')}}</a></li>
	      <li><a href="/member/follow">{{trans('index.my_interactive')}}</a></li>
	      <li><a href="/member/mydown">{{trans('index.my_download')}}</a></li>
	      <li class="current"><a href="/member/profile">{{trans('index.the_personal_data')}}</a></li>
    </ul>
  </div>
</div>
<section class="wrapper">
  <div class="mt30 home_box"> 
    <!-- <div class="TabTitle">
      <ul id="myTab1" style="float:left; width:600px;">
        <li class="active" onclick="nTabs(this,0);">基本信息</li>
        <li class="normal" onclick="nTabs(this,1);">账号修改</li>
      </ul>
    </div> -->
    <p style='border-bottom: 1px solid #ccc;height: 50px;font-size: 20px;line-height: 65px;'><span style='border-bottom: 2px solid #3d87f1;padding-bottom: 5px;'>{{trans('index.The_basic_information')}} </span></p>
    <div class="TabContent content-post"> 
      
      <!---发现--->
      
      <div id="myTab1_Content0" >
      <form id="info-form" class="contribute_form" role="form" method="POST" action="/member/edit" enctype="multipart/form-data" onsubmit="return checkform()">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <p style='position:relative'>
          <label for="nickname">{{trans('index.nickname')}}</label>
          <input type="text" value="{{$user->nickname}}" disabled='disabled' style="height:46px;">
          <input style="padding: 0 19px;position:absolute;top:40px;height:47px;background: #636af3;color: #fff;width:98px !important;border:none;right:0;" type="button" value="({{trans('index.change_nickname')}})" class="editnick">
        <p style='font-size:14px;margin-top:-18px;color:#ccc;'>({{trans('index.nickname_tips')}})</p>
        </p>
        <p>
          <label for="sex">{{trans('index.sex')}}</label>
          <input name="sex" type="radio" value="0" checked="checked" />
          保密
          <input name="sex" type="radio" value="1" @if('1' == $user->
          sex) checked="checked" @endif/>男
          <input name="sex" type="radio" value="2" @if('2' == $user->
          sex) checked="checked" @endif/>女 </p>
        <p>
          <label for="city">{{trans('index.citys')}}</label>
          @if($user->city)
        <p style="padding-left:4px;"> {{trans('index.province')}}：
          <select name='provinces' id="provinces">
            <option value="{{$province}}" id="selectpro" >{{$user->city[0]}}</option>
          </select>
          {{trans('index.city')}}：
          <select id="citys" name='citys'>
            <option value="{{$city}}">{{$user->city[1]}}</option>
          </select>
        </p>
        @else
        <p style="padding-left:4px;"> {{trans('index.province')}}：
          <select name='provinces' id="provinces">
            <option value="" id="selectpro"  >请选择省份</option>
          </select>
          {{trans('index.city')}}：
          <select id="citys" name='citys'>
            <option value="">请选择市</option>
          </select>
        </p>
        @endif 
        
        <!-- 区：<select id="countys"><option value="">请选择县</option></select>   -->
        
        </p>
        <p>
          <label for="zhiwei">{{trans('index.position')}}</label>
          @if($user->zhiwei)
          <select style="width: 100%;" name="zhiwei" value="职位">
            <option value="{{$user->zhiwei}}" selected>{{$user->zhiwei}}</option>
            <option name="jzs" value="建筑师" >建筑师</option>
            <option name="snsjs" value="室内设计师">室内设计师</option>
            <option name="rzsjs" value="软装设计师">软装设计师</option>
            <option name="cpsjs" value="产品设计师">产品设计师</option>
            <option name="sys" value="摄影师">摄影师</option>
            <option name="mtr" value="媒体人">媒体人</option>
            <option name="dckf" value="地产开发">地产开发</option>
            <option name="qt" value="其他">其他</option>
          </select>
          @else
          <select class='zhiwei' style="width: 100%;" name="zhiwei" value="职位">
            <option name="jzs" value="建筑师" >建筑师</option>
            <option name="snsjs" value="室内设计师">室内设计师</option>
            <option name="rzsjs" value="软装设计师">软装设计师</option>
            <option name="cpsjs" value="产品设计师">产品设计师</option>
            <option name="sys" value="摄影师">摄影师</option>
            <option name="mtr" value="媒体人">媒体人</option>
            <option name="fckf" value="地产开发">地产开发</option>
            <option name="qt" value="其他" selected>其他</option>
          </select>
          @endif 
          
          <!-- <input type="text" id="url" name="url" value="{{$user->url}}"> --> 
          
        </p>
        <p style='position:relative'>
          <label for="zhuye">{{trans('index.personal_home_page')}}</label>
          <a href="/member/{{$user->id}}" style="height:46px;">{{$_SERVER['HTTP_REFERER']}}/member/{{$user->id}}</a> </p>
        <p>
          <label for="personal_note">{{trans('index.personal_description')}}</label>
          <textarea class='grsm' rows="5" style="resize:vertical;" name="personal_note" id="personal_note">{{$user->personal_note}}</textarea>
        </p>
        {{--
        <div id="profile_avatar">
          <label for="avatar">头像</label>
          <div class="avatar_img" style="width:128px;height:128px;border-radius:128px;"> <img class="avatar img-responsive" src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$user->nickname}}" style="display: block;"> </div>
          <a class="avatar_uploader" href="javascript:void(0)"> 点击更换头像
          <input type="file" id="fileAvatar" class="filepath" onchange="changeAvatar(this)" accept="image/jpg,image/jpeg,image/png,image/PNG" />
          </a> <span>当前为<strong>自定义头像</strong>，建议大小：120*120。获取头像的顺序为：自定义头像、社交头像、全球通用头像、默认头像</span> </div>
        --}}
        
        
        
        {{--
        <div id="profile_avatar">
          <label for="avatar">头像</label>
          <div class="cropped" style="width: 120px;height: 120px;overflow: hidden;border: 1px solid red;"> <img style="width: 120px;height:120px;padding:0;margin:0;background:none;" src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$user->nickname}}"> </div>
          <div class="imageBox">
            <div class="thumbBox"></div>
            <div class="spinner" style="display: none">Loading...</div>
          </div>
          <div class="action">
            <input type="file" style="float:left; width: 250px" id="fileAvatar"  accept="image/jpg,image/jpeg,image/png,image/PNG" >
          </div>
          <div class="actionbtn" style="float:left;">
            <input type="button" id="btnCrop" value="确定" style="float: right;width:50px;">
            <input type="button" id="btnZoomIn" value="+" style="float: right;width:30px;">
            <input type="button" id="btnZoomOut" value="-" style="float: right;width:30px;">
          </div>
          <br>
          <span>当前为<strong>自定义头像</strong>，建议大小：120*120。获取头像的顺序为：自定义头像、社交头像、全球通用头像、默认头像</span> </div>
        --}}
        <div id="profile_avatar" style="position:relative;">
          <label for="avatar">{{trans('index.avatar')}}</label>
          <style>
                .photo-clip-rotateLayer img{width:  auto !important;height:  auto !important;padding: unset !important;border: unset !important;float: unset !important;background-color:unset !important;margin-right: unset !important;}
                .photo-clip-rotateLayer{margin-top:-5px;}
                .photo-clip-view{width:321px !important;height:321px !important;}
                .photo-clip-area{width:321px !important;height:321px !important;left:56% !important;}
                .photo-clip-mask-left{margin-right: 162px !important;}
                .photo-clip-mask-right{margin-left: 160px !important;}
              </style>
          <div class="cover-wrap" style="display:none;position:fixed;left:0;top:0;width:100%;height:100%;background: rgba(0, 0, 0, 0.4);z-index: 10000000;text-align:center;">
            <div class="caijian" style="width:900px;height:600px;margin:100px auto;background-color:#FFFFFF;overflow: hidden;border-radius:4px;">
              <div id="clipArea" style="margin:10px;height: 520px;"></div>
              <div class="" style="height:56px;line-height:36px;text-align: center;padding-top:8px;position: relative;left: 365px;"> 
                
                <!-- <span id="cannelbtn" style="width:120px;height: 36px;border-radius: 4px;background-color:#ff8a00;color: #FFFFFF;font-size: 14px;text-align: center;line-height: 30px;outline: none;float:left;margin:0 10px;">取消</span> --> 
                
                <span id="clipBtn" style="width:120px;height: 36px;border-radius: 4px;background-color:#ff8a00;color: #FFFFFF;font-size: 14px;text-align: center;line-height: 30px;outline: none;float:left;">保存头像</span> </div>
            </div>
          </div>
          <div id="view" style="width:120px;height:120px;" title="请上传 120*120 的图片"> <img style="width: 120px;height:120px;padding:0;margin:0;background:none;" src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$user->nickname}}"> </div>
          <div style="height:10px;"></div>
          <div class="avatar_uploader" style="float:left;width:140px;height:32px;border-radius: 4px;background-color:#ff8a00;color: #FFFFFF;font-size: 14px;text-align:center;line-height:32px;outline:none;margin-left:37px;position:relative;left: 120px;top: -120px;"> {{trans('index.avatar_tips1')}}
            <input type="file" id="file" style="cursor:pointer;opacity:0;filter:alpha(opacity=0);width:100%;height:100%;position:absolute;top:0;left:0;">
          </div>
          <br>
          <span style="position: absolute;top: 87px;left: 151px;">{{trans('index.avatar_tips2')}}</span> </div>
        <div id="homepage_top_img" style="overflow:hidden">
          <label for="avatar">{{trans('index.Individual_main_photo')}}</label>
          @if($user->zhuti) <img id="avimg" src="{{$user->zhuti}}" alt="个人主图" width="600" hidden="200" style="display:block; width:200px; float:left; height:100px;" > <a class="avatar_uploader" href="javascript:void(0)" > {{trans('index.Individual_main_photo_tips1')}}
          <input type="file" id="fileSingleImg" class="filepath" onchange="changeSingleImg(this)" accept="image/jpg,image/jpeg,image/png,image/PNG" />
          </a> <span>{{trans('index.Individual_main_photo_tips2')}}</span> </div>
        @else <img id="avimg" src="/images/zhutibj.jpg" alt="个人主图" width="600" hidden="200" style="display:block; width:200px; float:left; height:100px;" > <a class="avatar_uploader" href="javascript:void(0)" > {{trans('index.Individual_main_photo_tips1')}}
        <input type="file" id="fileSingleImg" class="filepath" onchange="changeSingleImg(this)" accept="image/jpg,image/jpeg,image/png,image/PNG" />
        </a> <span>{{trans('index.Individual_main_photo_tips2')}}</span>
        </div>
        @endif
        <p>
          <input name="avatar" type="hidden" value="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" />
          
          <!-- <input type="submit" value="保存更改" class="submit"> --> 
          
        </p>
        
        <!-- </form>

      </div> -->
        
        <p style='border-bottom:1px solid #ccc;height:50px;font-size: 20px;line-height:40px;'><span style='border-bottom:2px solid #3d87f1;padding-bottom: 5px;'>{{trans('index.account_change')}}</span></p>
        
        <!-- <div id="myTab1_Content0"  > --> 
        
        <!-- <form id="pass-form" class="contribute_form" role="form" method="post" action="/member/edit" onsubmit="return checkform()"> --> 
        
        <!-- <input type="hidden" name="_token" value="{{csrf_token()}}"> -->
        
        <p>
          <label for="bdwx">{{trans('index.binding_wechat')}}</label>
          @if($user->is_wxbd)
        <div class="" style='position:relative'> <a href="javascript:void(0);" title="微信绑定"><img src="/img/tl_weixin.png"></a> <span style='position:absolute;top: 0;left: 45px;color: #6d9aec;cursor: pointer;' title="已绑定">{{trans('index.wx_tips1')}}</span> </div>
        @else
        <div class="" style='position:relative'> <a href="javascript:void(0);" title="微信绑定"><img src="/img/tl_weixin.png"></a> <span style='position:absolute;top: 0;left: 45px;color: #6d9aec;cursor: pointer;' onclick="WeChatLogins();" title="点击进行微信绑定">{{trans('index.wx_tips2')}}</span> </div>
        @endif
        <div class="ma_box" style="position: absolute;top: 160%;left: 34%;background: #eee;z-index:999;display:none;">
          <h1><a href="/index" title="{{trans('comm.yinji')}}" tabindex="-1">{{trans('comm.yinji')}}</a><span class='closebtn' style='float: right;margin-top: -46px;cursor: pointer;color:#ddd;'>X</span></h1>
          
          <!-- <h2>微信扫码登陆</h2> -->
          
          <p>
            <iframe frameborder="0" scrolling="no" width="365" height="395" src="/auth/weixin"></iframe>
          </p>
        </div>
        </p>
        <p style='position:relative'>
          <label for="mobile">{{trans('index.phone')}}</label>
          @if($user->mobile)
          <input type="tel" maxlength='11' disabled='disabled' value="{{$user->mobile}}" >
          <input style="padding: 0 19px;position:absolute;top:40px;height:47px;background: #636af3;color: #fff;width:98px !important;border:none;right:0;" type="button" value="{{trans('index.change_phone')}}" class="jbmobile">
          <label class='sjyzms' for="verification_code" style="position:relative;display:none;">{{trans('index.phone_code')}}</label>
          <input type="text" name="verification_code" id="verification_code" class="input" style='height:47px;display:none;' value="" size="20" placeholder="{{trans('index.phone_code_tips')}}">
          <input style="padding: 0 19px;position:absolute;top:127px;height:48px;background: #636af3;color: #fff;border-radius:3px;display:none;" name="发送验证码" onclick="bdtel()" type="button" value="{{trans('index.code')}}" class="verification">
          @else
          <input type="tel" id="mobile" maxlength='11' name="mobile" placeholder="{{trans('index.phone_tips')}}" value="" >
          <input style="padding: 0 19px;position:absolute;top:40px;height:48px;background: #636af3;color: #fff;border-radius:3px;" name="发送验证码" onclick="bdtel()" type="button" value="{{trans('index.code')}}" class="verification">
          <p style='position:relative;display:none;' class='tel_yzm'>
          <label for="verification_code" style="position:relative">{{trans('index.phone_code')}}</label>
          <input type="text" name="verification_code" id="verification_code" class="input" style='height:47px;' value="" size="20" placeholder="{{trans('index.phone_code_tips')}}">
        </p>
        @endif
        </p>
        <p style='position:relative;'>
          <label for="email">{{trans('index.email')}}</label>
          @if($user->email)
          <input type="email" disabled='disabled' value="{{$user->email}}" >
          <input style="padding: 0 19px;position:absolute;top:40px;height:47px;background: #636af3;color: #fff;width:98px !important;border:none;border-radius:3px;right:0;" type="button" value="{{trans('index.change_email')}}" class="jbemail">
          @else
          <input type="email" id="email" name="email" value="" placeholder="{{trans('index.email_tips')}}" >
          <input style="padding: 0 19px;position:absolute;top:40px;height:48px;background: #636af3;color: #fff;border-radius:3px;right:0;border:none;" name="发送验证码" type="button" value="{{trans('index.code')}}" class="verification_email" onclick='bdemail()'>
          <p style='position:relative;display:none;' class='email_yzm'>
          <label for="verification_code" style="position:relative">{{trans('index.email_code')}}</label>
          <input type="text" name="verification_code" id="verification_code_email" class="input" style='height:48px;' value="" size="20" placeholder="{{trans('index.email_code_tips')}}">
        </p>
        @endif
        </p>
        <p>
          <label for="pass1">{{trans('index.new_password')}}</label>
          <input type="password" id="pass1" name="pass1">
          <span class="help-block">{{trans('index.password_tips1')}}</span></p>
        <p>
          <label for="pass2">{{trans('index.repeat_the_password')}}</label>
          <input type="password" id="pass2" name="pass2">
          <span class="help-block">{{trans('index.password_tips2')}}</span></p>
        <p> 
          
          <!-- <input type="submit" value="保存更改" class="submit"> -->
          
          <input type="button" value="{{trans('index.save')}}" class="submit" onclick='subntm()'>
        </p>
      </form>
    </div>
  </div>
  </div>
</section>
<script>

  $(function() {  
    //页面初始，加载所有的省份  
    // function selectpro(){
    // $(document).on('click','#provinces',function(){
      // $('#provinces').click(function(){
      // alert(123)
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
<script src="/js/plugins/cover_js/iscroll-zoom.js" type="text/javascript" charset="utf-8"></script> 
<script src="/js/plugins/cover_js/hammer.js" type="text/javascript" charset="utf-8"></script> 
<script src="/js/plugins/cover_js/lrz.all.bundle.js" type="text/javascript" charset="utf-8"></script> 
<script src="/js/plugins/cover_js/jquery.photoClip.min.js" type="text/javascript" charset="utf-8"></script> 
<script type="text/javascript">
  //上传封面
  //document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);
  let clipArea = new bjj.PhotoClip("#clipArea", {
    size: [428, 321],// 截取框的宽和高组成的数组。默认值为[260,260]
    outputSize: [428, 321], // 输出图像的宽和高组成的数组。默认值为[0,0]，表示输出图像原始大小
    //outputType: "jpg", // 指定输出图片的类型，可选 "jpg" 和 "png" 两种种类型，默认为 "jpg"
    file: "#file", // 上传图片的<input type="file">控件的选择器或者DOM对象
    view: "#view", // 显示截取后图像的容器的选择器或者DOM对象
    ok: "#clipBtn", // 确认截图按钮的选择器或者DOM对象
    loadStart: function() {
      // 开始加载的回调函数。this指向 fileReader 对象，并将正在加载的 file 对象作为参数传入
      $('.cover-wrap').fadeIn();
      console.log("照片读取中");
    },
    loadComplete: function() {
      // 加载完成的回调函数。this指向图片对象，并将图片地址作为参数传入
      console.log("照片读取完成");
    },
    loadError: function(event) {}, // 加载失败的回调函数。this指向 fileReader 对象，并将错误事件的 event 对象作为参数传入
    clipFinish: function(dataURL) {
      // 裁剪完成的回调函数。this指向图片对象，会将裁剪出的图像数据DataURL作为参数传入
      $('.cover-wrap').fadeOut();
      // $('#view').css('background-size','100% 100%');
      console.log(dataURL);
      images = dataURL;
    }
  });

  $('#clipBtn').on('click', function(){
      console.log(images);
      $.ajax({
        type:"POST",
        url:"/member/upload_img",
        data:{images:images},
        success: function (data) {
          console.log(data)
        }
      })    
      $('#view').html('<img style="width: 120px;height:120px;padding:0;margin:0;background:none;" id="jiancai" src="'+images+'">');
  })
  //clipArea.destroy();
</script> 
<script src="/js/laravel-sms.js"></script> 
<script type="text/javascript">

  function WeChatLogins() {

    $(".ma_box").show(500);

  } 



  $('.closebtn').click(function(){
    $('.ma_box').hide(500);
  });


  function changeAvatar() {
    // var reads = new FileReader();
    // f = document.getElementById('fileAvatar').files[0];
    // reads.readAsDataURL(f);
    // reads.onload = function(e) {
    //   $('#profile_avatar .avatar').attr('src',this.result)
    // };
    var formdata=new FormData();
    let a=$('#fileAvatar')[0].files[0];
    formdata.append('file',$('#fileAvatar')[0].files[0])
    formdata.append('_token',_token)
    console.log(a);
    $.ajax({
      async: false,
      url: '/member/upload_img',
      type: 'POST',
      contentType:false,
      data:formdata,
      processData:false,
      success: function (data) {
        console.log(data)
        if (data.status_code == 0) {
          $('#profile_avatar .avatar').attr('src',data.data.path)
          $("[name='avatar']").val(data.data.path)
        } else {
          layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
        }
      }
    });
  }

  function changeSingleImg() {
    // var reads = new FileReader();
    // f = document.getElementById('fileSingleImg').files[0];
    // reads.readAsDataURL(f);
    // reads.onload = function(e) {
    //   $('#homepage_top_img img').attr('src',this.result)
    // };

    var formdata=new FormData();
    formdata.append('file',$('#fileSingleImg')[0].files[0])
    formdata.append('_token',_token)
    $.ajax({
      async: false,
      url: '/member/upload_imgs',
      type: 'POST',
      contentType:false,
      data:formdata,
      processData:false,
      success: function (data) {
        if (data.status_code == 0) {
          console.log(data.data)
          $('#homepage_top_img img').attr('src',data.data.path)
        } else {
          layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
        }
      }
    });

  }

  function nTabs(thisObj,Num){
    if(thisObj.className == "active")return;
    var tabObj = thisObj.parentNode.id;
    var tabList = document.getElementById(tabObj).getElementsByTagName("li");
    for(i=0; i <tabList.length; i++){
      if (i == Num){
        thisObj.className = "active";
        document.getElementById(tabObj+"_Content"+i).style.display = "block";
      }else{
          tabList[i].className = "normal";
          document.getElementById(tabObj+"_Content"+i).style.display = "none";
      }
    }
  }

  //点击解绑显示验证码kaung
  $('.jbmobile').click(function () {
    $('#verification_code').show();
    $('.sjyzms').show();
    $('.verification').show()
    $(this).siblings('input[type="tel"]').removeAttr('disabled');
    $(this).siblings('input[type="tel"]').attr('id','mobile');
    $(this).siblings('input[type="tel"]').attr('name','mobile');
    $(this).siblings('input[type="tel"]').val('');
    $(this).hide(100)
  })

  $('.jbemail').click(function () {
    $('.email_yzm').show(1000);
    $(this).siblings('input[type="email"]').removeAttr('disabled');
    $(this).siblings('input[type="email"]').attr('id','email');
    $(this).siblings('input[type="email"]').attr('name','email');
    $(this).siblings('input[type="email"]').val('');
    $(this).hide(100)
  })

  $(".editnick").click(function(){
    // let nickname=$('#nickname').val();
    let that=$(this);
    $.ajax({
      async: false,
      url: '/member/editnick',
      type: 'POST',
      data:{},
      success: function (data) {
        if (data.status_code == 100) {
          console.log(data.data)
          layer.msg(data.message,{time: 1500,skin: 'intro-login-class layui-layer-hui'})
          that.siblings('input[type="text"]').removeAttr('disabled');
          that.siblings('input[type="text"]').attr('id','nickname');
          that.siblings('input[type="text"]').attr('name','nickname');
          that.siblings('input[type="text"]').val('');
          that.hide(100)          
        } else {
          layer.msg(data.message,{time: 1500,skin: 'intro-login-class layui-layer-hui'})
        }
      }
    });

  })

  // 阻止提交表单
  function checkform(){
    return false;//false:阻止提交表单
  }


  //发送邮箱
  function bdemail(){
    $('#verification_code_email').val('');
    let email=$('#email').val();

    if(email==''||email==null||email==undefined){
      layer.msg('请填写邮箱',{time: 1500,skin: 'intro-login-class layui-layer-hui'});
      return false;
    }

    // alert(email)
    let emailzz = /^([A-Za-z0-9_+-.])+@([A-Za-z0-9\-.])+\.([A-Za-z]{2,22})$/;
    if(email!='' && email != null && email != undefined){
      if(!emailzz.test(email)){
        layer.msg('邮箱格式错误',{time: 1500,skin: 'intro-login-class layui-layer-hui'});
        return false;
      }
    }

    $(".email_yzm").show();
    $.ajax({
        async: false,
        url: '/member/bdemail',
        type: 'POST',
        data:{email:email},
        success: function (data) {
          console.log(data)
          if (data.status_code == 0) {
            layer.msg(data.message,{time: 1500,skin: 'intro-login-class layui-layer-hui'})
          } else {
            layer.msg(data.message,{time: 1500,skin: 'intro-login-class layui-layer-hui'})
          }
      }
    });
  }

  //发送手机
  function bdtel(){
    let mobile=$('#mobile').val();
    function wp_attempt_focus() {
      setTimeout(function () {
          try {
              d = document.getElementById('mobile');
              d.focus();
              d.select();
          } catch (e) {

          }
      }, 200);
    }

    if(mobile==''|| mobile==null||mobile==undefined){
      layer.msg('请填写手机号',{time: 1500,skin: 'intro-login-class layui-layer-hui'});
      return false;
    }

    if(mobile!='' && mobile != null && mobile != undefined){
      if(!(/^[1][3,4,5,6,7,8,9][0-9]{9}$/.test(mobile))){ 
        layer.msg('手机号格式错误',{time: 1500,skin: 'intro-login-class layui-layer-hui'});
        return false;
      }
    }

    $(".tel_yzm").show();
    wp_attempt_focus();
      if (typeof wpOnload == 'function') wpOnload();
      //获取验证码
      let is_sending = false;
      let time_limit = 60;
      let next_time = time_limit;
      let cap_btn = $('.verification');
      let verification_code = $.trim($('#verification_code').val());
      cap_btn.sms({
          //laravel csrf token
          token       : "{{csrf_token()}}",
          //请求间隔时间
          interval    : 60,
          //请求参数
          requestData : {
              //手机号
              mobile : function () {
                  return $.trim($('#mobile').val());
              },
              //手机号的检测规则
              mobile_rule : 'mobile_required'
          }
      });
  }


  //模拟表单提交
  function subntm(){
    let nickname=$('#nickname').val();
    let mobile=$('#mobile').val();
    let email=$('#email').val();
    let pass1=$('#pass1').val();
    let pass2=$('#pass2').val();
    let code_tel = $.trim($('#verification_code').val());
    let code_email = $.trim($('#verification_code_email').val());
    let zhiwei=$("select[name='zhiwei']").val();
    let grsm=$('.grsm').val();
    let provinces=$("select[name='provinces']").val();
    let citys=$("select[name='citys']").val();
    // console.log(zhiwei,grsm);

    let emailzz = /^([A-Za-z0-9_+-.])+@([A-Za-z0-9\-.])+\.([A-Za-z]{2,22})$/;

    if(nickname!='' && nickname != null && nickname != undefined){
      if (!/^[\u4E00-\u9FA5A-Za-z0-9]+$/.test(nickname)) {
        layer.msg('昵称规范:中文、英文、数字但不包括下划线等符号',{time:1500,skin: 'intro-login-class layui-layer-hui'});
        return false;
      }
    }

    if(mobile!='' && mobile != null && mobile != undefined){
      if(!(/^1[34578]\d{9}$/.test(mobile))){ 
        layer.msg('手机号格式错误',{time: 1500,skin: 'intro-login-class layui-layer-hui'});
        return false;
      }
    }
    if(email!='' && email != null && email != undefined){
      if(!emailzz.test(email)){
        layer.msg('邮箱格式错误',{time: 1500,skin: 'intro-login-class layui-layer-hui'});
        return false;
      }
    }

    $.ajax({
      async: false,
      url: '/member/edit',
      type: 'POST',
      data:{nickname:nickname,mobile:mobile,email:email,pass1:pass1,pass2:pass2,code_tel:code_tel,code_email:code_email,zhiwei:zhiwei,grsm:grsm,provinces:provinces,citys:citys},
      success: function (data) {
        if (data.status_code == 0) {
          console.log(data.data)
          layer.msg(data.message,{time: 1500,skin: 'intro-login-class layui-layer-hui'})
        } else {
          layer.msg(data.message,{time: 1500,skin: 'intro-login-class layui-layer-hui'})
        }
      }
    });
  }


</script> 
@endsection