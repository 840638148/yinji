@extends('layouts.app')

@section('title')
  {{trans('comm.yinji')}} - 个人资料中心
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
</style>
<div class="home_top">
  <div class="home_banber"> <img src="/images/home_bj.jpg" alt="个人主页图片" /></div>
  <div class="home_tongji">
  <ul>
      <li>发现</br>
        {{$user->finder_num}} </li>
      <li> 收藏</br>
        {{$user->collect_num}} </li>
      <li> 订阅</br>
        {{$user->subscription_num}} </li>
      <li> 关注</br>
        {{$user->follow_num}} </li>
    </ul>
  </div>
  <div class="home_personal"> <img src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$user->nickname}}" />
   
  </div>
  <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> {{$user->nickname}} <img src="{{$user->vip_level}}" alt=""></h2>
  <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;">个人说明： {{$user->personal_note}}</p>
  <div class="home_nav">
    <ul>
      <li><a  href="/member">个人中心</a></li>
      <li><a href="/member/finder">我的发现</a></li>
      <li><a href="/member/collect">我的收藏</a></li>
      <li><a href="/member/subscription">我的订阅</a></li>
      <li><a href="/member/follow">我的关注</a></li>
      <li><a href="/member/point">我的印币</a></li>
      <li class="current"><a href="/member/profile">个人资料</a></li>
    </ul>
  </div>
</div>
<section class="wrapper">
  <div class="mt30 home_box">
    <div class="TabTitle">
      <ul id="myTab1" style="float:left; width:600px;">
        <li class="active" onclick="nTabs(this,0);">基本信息</li>
        <li class="normal" onclick="nTabs(this,1);">账号修改</li>
      </ul>
    </div>
    <div class="TabContent content-post"> 
      
      <!---发现--->
      
      <div id="myTab1_Content0" >
        <form id="info-form" class="contribute_form" role="form" method="POST" action="/member/baseedit" enctype="multipart/form-data">
          <input type="hidden" name="_token" value="{{csrf_token()}}">
          <p>
            <label for="sex">性别</label>
            <input name="sex" type="radio" value="0" checked="checked" />
            保密
            <input name="sex" type="radio" value="1" @if('1' == $user->
            sex) checked="checked" @endif/>男
            <input name="sex" type="radio" value="2" @if('2' == $user->
            sex) checked="checked" @endif/>女 </p>
          <p>
            <label for="city">所在城市</label>
            <input type="text" id="city" name="city" value="{{$user->city}}" >
          </p>
          <p>
            <label for="zhiwei">职位</label>
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
            <select style="width: 100%;" name="zhiwei" value="职位">
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
          <p>
            <label for="personal_note">个人说明</label>
            <!-- <div contenteditable>123</div> -->
<!-- <br> -->
            <textarea rows="5" style="resize:vertical;" name="personal_note" id="personal_note">{{$user->personal_note}}</textarea>
          </p>
      {{--<div id="profile_avatar">
            <label for="avatar">头像</label>
            <div class="avatar_img" style="width:128px;height:128px;border-radius:128px;">
              <img class="avatar img-responsive" src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$user->nickname}}" style="display: block;">
            </div> 
            <a class="avatar_uploader" href="javascript:void(0)"> 点击更换头像 <input type="file" id="fileAvatar" class="filepath" onchange="changeAvatar(this)" accept="image/jpg,image/jpeg,image/png,image/PNG" /></a> 
            <span>当前为<strong>自定义头像</strong>，建议大小：120*120。获取头像的顺序为：自定义头像、社交头像、全球通用头像、默认头像</span> 
          </div>
          --}}


          {{--<div id="profile_avatar">
            <label for="avatar">头像</label>
            <div class="cropped" style="width: 120px;height: 120px;overflow: hidden;border: 1px solid red;">
                <img style="width: 120px;height:120px;padding:0;margin:0;background:none;" src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$user->nickname}}">
            </div>            

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
            <span>当前为<strong>自定义头像</strong>，建议大小：120*120。获取头像的顺序为：自定义头像、社交头像、全球通用头像、默认头像</span> 
          </div>--}}

          <div id="profile_avatar" style="position:relative;">
            <label for="avatar">头像</label>
              <style>
                .photo-clip-rotateLayer img{width:  auto !important;height:  auto !important;padding: unset !important;border: unset !important;float: unset !important;background-color:unset !important;margin-right: unset !important;}
                .photo-clip-rotateLayer{margin-top:-5px;}
                .photo-clip-view{width:120px !important;height:120px !important;}
              </style>
            <div class="cover-wrap" style="display:none;position:fixed;left:0;top:0;width:100%;height:100%;background: rgba(0, 0, 0, 0.4);z-index: 10000000;text-align:center;">	
              <div class="caijian" style="width:900px;height:600px;margin:100px auto;background-color:#FFFFFF;overflow: hidden;border-radius:4px;">
                <div id="clipArea" style="margin:10px;height: 520px;"></div>
                <div class="" style="height:56px;line-height:36px;text-align: center;padding-top:8px;position: relative;left: 365px;">
                  <!-- <span id="cannelbtn" style="width:120px;height: 36px;border-radius: 4px;background-color:#ff8a00;color: #FFFFFF;font-size: 14px;text-align: center;line-height: 30px;outline: none;float:left;margin:0 10px;">取消</span> -->
                  <span id="clipBtn" style="width:120px;height: 36px;border-radius: 4px;background-color:#ff8a00;color: #FFFFFF;font-size: 14px;text-align: center;line-height: 30px;outline: none;float:left;">保存头像</span>
                  
                </div>
              </div>
            </div>
            <div id="view" style="width:120px;height:120px;" title="请上传 120*120 的图片">
            <img style="width: 120px;height:120px;padding:0;margin:0;background:none;" src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$user->nickname}}">
            </div>
            <div style="height:10px;"></div>

            <div class="avatar_uploader" style="float:left;width:140px;height:32px;border-radius: 4px;background-color:#ff8a00;color: #FFFFFF;font-size: 14px;text-align:center;line-height:32px;outline:none;margin-left:37px;position:relative;left: 120px;top: -120px;">
              点击更换头像
              <input type="file" id="file" style="cursor:pointer;opacity:0;filter:alpha(opacity=0);width:100%;height:100%;position:absolute;top:0;left:0;">
            </div><br>
            <span style="position: absolute;top: 87px;left: 151px;">当前为<strong>自定义头像</strong>，建议大小：120*120。获取头像的顺序为：自定义头像、社交头像、全球通用头像、默认头像</span> 
          </div>



<script src="/js/cropbox.js"></script>
<script src="/js/cropbox-min.js"></script>
<script type="text/javascript">
  images = '';
  var options =
  {
    thumbBox: '.thumbBox',
    spinner: '.spinner',
    imgSrc: '/img/avatar.png'
  }
  var cropper = $('.imageBox').cropbox(options);
  $('#fileAvatar').on('change', function(){
      $(".imageBox").css('display','block')
      var reader = new FileReader();
      reader.onload = function(e) {
          options.imgSrc = e.target.result;
          cropper = $('.imageBox').cropbox(options);
      }
      reader.readAsDataURL(this.files[0]);
      // $('#fileAvatar').files = [];
  })
  $('#btnCrop').on('click', function(){
      var img = cropper.getDataURL();
      images = img;
      console.log(images);
      $.ajax({
        type:"POST",
        url:"/member/upload_img",
        data:{images:images},
        success: function (data) {
          console.log(data)
        }
      })    // console.log(images);
      $('.cropped').html('<img style="width: 120px;height:120px;padding:0;margin:0;background:none;" id="jiancai" src="'+img+'">');
      $(".imageBox").css('display','none')  
  })
  $('#btnZoomIn').on('click', function(){
      cropper.zoomIn();
  })
  $('#btnZoomOut').on('click', function(){
      cropper.zoomOut();
  })
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

<script type="text/javascript">
  var options = {
    thumbBox: '.thumbBox',
    spinner: '.spinner',
    imgSrc: 'img/avatar.png',
      imageBox: document.querySelector('.imageBox')
  };
  var cropper = cropbox(options);
  document.querySelector('#upload-file').onchange = function(){
      var reader = new FileReader();
    reader.onload = function(e) {
      options.imgSrc = e.target.result;
      cropper = cropbox(options);
    };
    reader.readAsDataURL(this.files[0]);
  }

  document.querySelector('#btnCrop').onclick = function(){
    var img = cropper.getDataURL();
    document.querySelector('.cropped').innerHTML = '';
    document.querySelector('.cropped').innerHTML = '<img src="'+img+'" align="absmiddle" style="width:180px;margin-top:4px;box-shadow:0px 0px 12px #7E7E7E;"><p>180px*180px</p>';
    var str=img.split("base64,")[1];
    alert('裁剪上传');
  };

  document.querySelector('#btnZoomIn').onclick = function() {
      cropper.zoomIn();
  }

  document.querySelector('#btnZoomOut').onclick = function() {
      cropper.zoomOut();
  }

</script>



          <div id="homepage_top_img" style="overflow:hidden">
            <label for="avatar">个人主图</label>
            <img id="avimg" src="{{$user->zhuti}}" alt="个人主图" width="600" hidden="200" style="display:block; width:200px; float:left; height:100px;" > <a class="avatar_uploader" href="javascript:void(0)" > 点击更换个人主图 <input type="file" id="fileSingleImg" class="filepath" onchange="changeSingleImg(this)" accept="image/jpg,image/jpeg,image/png,image/PNG" /></a> <span>当前为<strong>个人主页主图</strong>，建议大小：1920*300。</span> </div>
          <p>
            <input name="avatar" type="hidden" value="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" />
            <input type="submit" value="保存更改" class="submit">
          </p>
        </form>
      </div>
      <div id="myTab1_Content1"  class="none">
        <form id="pass-form" class="contribute_form" role="form" method="post" action="/member/edit">
          <input type="hidden" name="_token" value="{{csrf_token()}}">
          
          <p>
            <label for="nickname">昵称</label>
            <input type="text" id="nickname" name="nickname" value="{{$user->nickname}}" >
          </p>
          <p>
            <label for="mobile">手机号</label>
            <input type="text" id="mobile" name="mobile" value="{{$user->mobile}}" >
          </p>
          <p>
            <label for="email">电子邮件</label>
            <input type="text" id="email" name="email" value="{{$user->url}}" >
          </p>
          <p>
            <label for="pass1">新密码</label>
            <input type="password" id="pass1" name="pass1">
            <span class="help-block">如果需要修改密码，请输入新的密码，不改则留空。</span></p>
          <p>
            <label for="pass2">重复新密码</label>
            <input type="password" id="pass2" name="pass2">
            <span class="help-block">再输入一遍新密码，提示：密码最好至少包含7个字符，为了保证密码强度，使用大小写字母、数字和符号结合。</span></p>
          <p>
            <input type="submit" value="保存更改" class="submit">
          </p>
        </form>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
// function filebtn() 
// { 
//   changeAvatar(); 
// }



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

for(i=0; i <tabList.length; i++)

{

if (i == Num)

{

   thisObj.className = "active";

      document.getElementById(tabObj+"_Content"+i).style.display = "block";

}else{

   tabList[i].className = "normal";

   document.getElementById(tabObj+"_Content"+i).style.display = "none";

}

}

}

</script> 
@endsection