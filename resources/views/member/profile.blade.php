@extends('layouts.app')



@section('title')

  {{trans('comm.yinji')}} - 个人资料中心

@endsection





@section('content')
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
      <li><a href="/member/finder">我的发现</a></li>
      <li><a href="/member/collect">我的收藏</a></li>
      <li><a href="/member/subscription">我的订阅</a></li>
      <li><a href="/member/follow">我的关注</a></li>
      <li><a href="/member/point">我的积分</a></li>
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
        <form id="info-form" class="contribute_form" role="form" method="POST" action="/member/edit">
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
            <label for="url">个人主页</label>
            <input type="text" id="url" name="url" value="{{$user->url}}">
          </p>
          <p>
            <label for="personal_note">个人说明</label>
            <textarea rows="3" name="personal_note" id="personal_note">{{$user->personal_note}}</textarea>
          </p>
          <div id="profile_avatar">
            <label for="avatar">头像</label>
            <img class="avatar" src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$user->nickname}}" style="display: block;"> <a class="avatar_uploader" href="javascript:void(0)"> 点击更换头像 <input type="file" id="fileAvatar" class="filepath" onchange="changeAvatar(this)" accept="image/jpg,image/jpeg,image/png,image/PNG" /></a> <span>当前为<strong>自定义头像</strong>，建议大小：120*120。获取头像的顺序为：自定义头像、社交头像、全球通用头像、默认头像</span> </div>
          <div id="homepage_top_img" style="overflow:hidden">
            <label for="avatar">个人主图</label>
            <img src="http://www.yinjispace.com/wp-content/uploads/2017/10/2017102803344214.jpg" alt="个人主图" width="600" hidden="200" style="display:block; width:200px; float:left; height:100px;" > <a class="avatar_uploader" href="javascript:void(0)" > 点击更换个人主图 <input type="file" id="fileSingleImg" class="filepath" onchange="changeSingleImg(this)" accept="image/jpg,image/jpeg,image/png,image/PNG" /></a> <span>当前为<strong>个人主页主图</strong>，建议大小：1920*300。</span> </div>
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
            <label for="username">用户名(必填)</label>
            <input type="text" id="username" name="username" value="{{$user->username}}" required="">
          </p>
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

function changeAvatar() {
  // var reads = new FileReader();
  // f = document.getElementById('fileAvatar').files[0];
  // reads.readAsDataURL(f);
  // reads.onload = function(e) {
  //   $('#profile_avatar .avatar').attr('src',this.result)
  // };
  var formdata=new FormData();
  formdata.append('file',$('#fileAvatar')[0].files[0])
  formdata.append('_token',_token)
  $.ajax({
    async: false,
    url: '/member/upload_img',
    type: 'POST',
    contentType:false,
    data:formdata,
    processData:false,
    success: function (data) {
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
    url: '/member/upload_img',
    type: 'POST',
    contentType:false,
    data:formdata,
    processData:false,
    success: function (data) {
      if (data.status_code == 0) {
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