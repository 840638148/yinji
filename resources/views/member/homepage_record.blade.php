@extends('layouts.app')

@section('title')
  {{trans('comm.yinji')}} -  TA的印记
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
    height: 100%;
  }
  .img_browse .right .head img{
    width:100%;
    height: 100%;
  }
  .img_browse .right .faxian_info{
    margin-top: 10px;
  }
</style>
<!-- <link rel="shortcut icon" href="favicon.ico"> <link href="/css/hp_css/bootstrap.min.css?v=3.3.6" rel="stylesheet"> -->
<link href="/css/hp_css/font-awesome.css?v=4.4.0" rel="stylesheet">
<link href="/css/hp_css/style.css?v=4.1.0" rel="stylesheet">
<div class="home_top">
  <div class="home_banber"> <img src="/images/home_bj.jpg" alt="个人主页图片" /></div>
  <div class="home_tongji">
    <ul>
        <li>人气</br>{{$users->view_num}} </li>
        <li>收藏</br>{{$users->collect_num}} </li>
        <li>关注</br>{{$users->follow_num}} </li>
        <li>粉丝</br>{{$users->follow_num}} </li>
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
        <li><a href="/member/homepage_finder/{{$users->id}}">TA的发现</a></li>
        <li><a href="/member/homepage_collect/{{$users->id}}">TA的收藏</a></li>
        <li><a href="/member/homepage_subscription/{{$users->id}}">TA的订阅</a></li>
        <li><a href="/member/homepage_interactive/{{$users->id}}">TA的互动</a></li>
        <li class="current"><a href="/member/homepage_record/{{$users->id}}">印记</a></li>
    </ul>
  </div>
</div>
<section class="wrapper">
    <div class="mt30 home_box">
        <div class="title">
            <h2 class="fl" style='line-height: 40px;'><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'>TA的印记</span></h2>
        </div>
        <div class=" wrapper-content">
            <div class="row animated fadeInRight">
                <div class="col-sm-12">
                    <div class="ibox float-e-margins">
                        
                        <div class="ibox-content timeline" style='border:none;'>
                            
                            <div class="timeline-item">
                                <div class="row">
                                    <div class="col-xs-3 date">
                                        <i class="fa fa-file-text"></i> 7:00
                                        <br>
                                        <small class="text-navy">3小时前</small>
                                    </div>
                                    <div class="col-xs-7 content">
                                        <p class="m-b-xs"><strong>修复了0.5个bug</strong>
                                        </p>
                                        <p>重启服务</p>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="row">
                                    <div class="col-xs-3 date">
                                        <i class="fa fa-coffee"></i> 8:00
                                        <br>
                                    </div>
                                    <div class="col-xs-7 content">
                                        <p class="m-b-xs"><strong>喝水、上厕所、做测试</strong>
                                        </p>
                                        <p>喝了4杯水，上了3次厕所，控制台输出出2324个错误，神啊，带我走吧</p>
                                        <p>喝了4杯水，上了3次厕所，控制台输出出2324个错误，神啊，带我走吧</p>
                                        <p>喝了4杯水，上了3次厕所，控制台输出出2324个错误，神啊，带我走吧</p>
                                        <p>喝了4杯水，上了3次厕所，控制台输出出2324个错误，神啊，带我走吧</p>
                                        <p>喝了4杯水，上了3次厕所，控制台输出出2324个错误，神啊，带我走吧</p>
                                        <p>喝了4杯水，上了3次厕所，控制台输出出2324个错误，神啊，带我走吧</p>
                                        <p>喝了4杯水，上了3次厕所，控制台输出出2324个错误，神啊，带我走吧</p>
                                        <p>喝了4杯水，上了3次厕所，控制台输出出2324个错误，神啊，带我走吧</p>
                                        <p>喝了4杯水，上了3次厕所，控制台输出出2324个错误，神啊，带我走吧</p>
                                        <p>喝了4杯水，上了3次厕所，控制台输出出2324个错误，神啊，带我走吧</p>
                                        <p>喝了4杯水，上了3次厕所，控制台输出出2324个错误，神啊，带我走吧</p>
                                        <p>喝了4杯水，上了3次厕所，控制台输出出2324个错误，神啊，带我走吧</p>
                                        <p>喝了4杯水，上了3次厕所，控制台输出出2324个错误，神啊，带我走吧</p>
                                        <p>喝了4杯水，上了3次厕所，控制台输出出2324个错误，神啊，带我走吧</p>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="row">
                                    <div class="col-xs-3 date">
                                        <i class="fa fa-phone"></i> 11:00
                                        <br>
                                        <small class="text-navy">21小时前</small>
                                    </div>
                                    <div class="col-xs-7 content">
                                        <p class="m-b-xs"><strong>项目经理打电话来了</strong>
                                        </p>
                                        <p>
                                            TMD，项目经理居然还没有起床！！！
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="row">
                                    <div class="col-xs-3 date">
                                        <i class="fa fa-user-md"></i> 09:00
                                        <br>
                                        <small>21小时前</small>
                                    </div>
                                    <div class="col-xs-7 content">
                                        <p class="m-b-xs"><strong>开会</strong>
                                        </p>
                                        <p>
                                            开你妹的会，老子还有897894个bug没有修复
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="timeline-item">
                                <div class="row">
                                    <div class="col-xs-3 date">
                                        <i class="fa fa-comments"></i> 12:50
                                        <br>
                                        <small class="text-navy">讨论</small>
                                    </div>
                                    <div class="col-xs-7 content">
                                        <p class="m-b-xs"><strong>…………</strong>
                                        </p>
                                        <p>
                                            又是操蛋的一天
                                        </p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
