@extends('layouts.app')

@section('title')
  {{trans('comm.yinji')}} - 个人中心 -积分中心
@endsection

@section('content')
<style>
    .item .edit_favorites{
        position: absolute;
        display: inline-block;
        vertical-align: top;
        text-indent:0;
        text-align: center;
        line-height: 32px;
        z-index:120;
        right:10px;
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
        width:230px;
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
    .img_browse{
    position: fixed;
    left: 50%;
    top: 10px;
    width: 800px;
    margin-left: -350px;
    height: 720px;
    min-height:0;
    background: #fff;
    z-index: 999;
    padding: 10px;
    border-radius: 5px;
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
    .pont-list ul{display: flex;flex-wrap:wrap}
    .pont-list ul li{width: 82px;height: 108px;position: relative;margin-right: 20px;text-align: center;border-radius: 5px;margin-bottom: 20px;cursor:pointer;}
    .pont-list ul li .point-kind{padding: 18px 0 8px 0}
    .pont-list ul li .point-num{background: #eeeeee;width: 45px;height: 45px;line-height: 45px;border-radius: 50%;display: inline-block}
    .pont-list ul li:first-child{margin-left: 0}
    .pont-list ul li div{
        position: absolute;
        left: 0;
        height: 0;
        width: 100%;
        height: 100%;
        border-radius: 5px;
        background: #f9f9f9;
        overflow: hidden;
        -webkit-transform-style: preserve-3d;
        -moz-transform-style: preserve-3d;
        -webkit-transition: .8s ease-in-out ;
        -moz-transition:  .8s ease-in-out ;
        -webkit-backface-visibility: hidden;
        -moz-backface-visibility: hidden
    }
    .pont-list ul li div:first-child{
        -webkit-transform: rotateY(0);
        -moz-transform: rotateY(0);
        z-index: 2;
    }

    .pont-list ul li div:last-child{
        -webkit-transform: rotateY(180deg);
        -moz-transform: rotateY(180deg);
        z-index: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .pont-list ul li a{width: 100%;height: 100%;display: inline-block}
    .pont-list ul li a:hover div:first-child{
        -webkit-transform: rotateY(-180deg);
        -moz-transform: rotateY(-180deg);
    }
    .pont-list ul li a:hover div:last-child{
        background: #ff9c00;
        color: #fff;
        -webkit-transform: rotateY(0);
        -moz-transform: rotateY(0);
    }

  .img_browse .right{
    width:260px;
    overflow: auto;
    height: calc( 100% - 50px);
  }
  .point-duihuan{
    cursor:pointer;
  }
  .point-duihuan:hover{
    background: #636af3 !important;
    color: #fff !important;
  }
  .lzcfg{
    background: rgba(0,0,0,0.5);
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    display: none;
    z-index: 99999999;
  }
</style>
<div class="lzcfg"></div>
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
      <li><a href="/member/mydown">我的下载</a></li>
      <li><a href="/member/profile">个人资料</a></li>
    </ul>
  </div>
</div>

<section class="wrapper">
  <div class="mt30 home_box">
    <div class="jifen_tj">
      <ul>
        <li class="ico_jftj01">
          <div class="tj_shuzi">
            <span class="point-title">我的印币</span>
            <p>{{$user->points}}</p>

          </div>
        </li>
        <li class="ico_jftj02">
          <div class="tj_shuzi">
            <span class="point-title">剩余印币</span>
            <p>{{$user->left_points}}</p>
           </div>
        </li>
        <li class="ico_jftj03">
             <div class="tj_shuzi">
                <span class="point-title">已用印币</span>
                <p>{{$user->points - $user->left_points}}</p>
            </div>
        </li>
        <li class="ico_jftj04" style="font-size:13px;">
          <div class="tj_shuzi">
            <span class="point-title">总下载次数: <b style="color:red">{{$user->download_num}}</b></span>
            </div>
            <p class="down-show" style="padding:0 !important;padding-right:16px !important;">{{$user->getFreeSum}}<span style="font-size:13px;">免费可下载次数</span></p><p class="down-show" style="padding:0 !important;padding-left: 16px !important;">{{$user->getKouSum}}<span style="font-size:13px;">印币可抵扣次数</span></p>
        </li>
      </ul>
       <ul>
            <li class="ico_jftj-inner">
                <div class="tj_shuzi">
                    <span class="point-title-small">今日印币</span>
                    <div class="today-point">{{ $today_point['today'] }}</div>
                    <div class="qiandao">
                        <p>
                            <span style="margin-left: 15px;padding-left: 2.5px;">签到：
                            @if ($today_point['attendance'] > 0)
                                {{ $today_point['attendance'] }}/{{ $today_point['attendance'] }}
                            @else
                                <a href="javascript:void(0);" class="bookInSign"  style="color: #a6c4df">去签到</a>
                            @endif
                            </span>
                        </p>
                        <p><span>发现：</span>{{ $today_point['faxian'] }}/50</p>
                        <p><span style="padding-left: 7px;">评论：</span>{{ $today_point['comment'] }}/600</p>
                    </div>
                </div>
                <div class="bar"><span class="bar-length" style="width: {{($today_point['today']/(650+$today_point['attendance']))*100}}%"></span><p><span>{{ $today_point['today'] }}</span>/{{650+$today_point['attendance']}}</p></div>
            </li>
            <li class="ico_jftj-inner">
                <div class="tj_shuzi">
                    <span class="point-title vip_type">月度会员兑换</span>
                    <!-- <span class="point-duihuan activity">25+50积分兑换</span> -->
                    <span class="point-duihuan" yb="50" money="94">94+50印币兑换</span>
                </div>
            </li>
            <li class="ico_jftj-inner">
                <div class="tj_shuzi">
                    <span class="point-title vip_type">季度会员兑换</span>
                    <span class="point-duihuan" yb="280" money="260">260+280印币兑换</span>
                </div>
            </li>
            <li class="ico_jftj-inner">
                <div class="tj_shuzi">
                    <span class="point-title vip_type">年度会员兑换</span>
                    <span class="point-duihuan" yb="880" money="911">911+880印币兑换</span>
                </div>
            </li>
        </ul>
    </div>
    <div class="title" style="position:relative">
      <h2 class="fl">印币记录<span class="ybrole" style="position: absolute;right: 10px;cursor: pointer;font-size: 15px;">印币规则</span></h2>
      {{--<a class="fr" href="/static/integral.html" style="line-height:48px; color:#06C">如何印币?</a>--}}
    </div>

      <div class="pont-list">
          <ul class="clearfix">

              @foreach($user->point_logs as $log)
                <li>
                @if ($log->type == 1)
                    <a href="javascript:void(0)">
                        <div>
                        <p class="point-kind">{{$log->remark}}</p>
                        <span class="point-num" style="color: #35d32d"> 
                            -{{$log->point}}
                        </span>
                        </div>
                        <div>
                            {{$log->created_at}}
                        </div>
                    </a>
                @else
                <a href="javascript:void(0)">
                        <div>
                            <p class="point-kind">{{$log->remark}}</p>
                            <span class="point-num" style="color: #fb8f5f"> 
                            +{{$log->point}}
                        </span>
                        </div>
                        <div>
                            {{$log->created_at}}
                        </div>
                    </a>
                @endif
                </li>
              @endforeach


          </ul>
          
      </div>
    {{--<table class="shop_table my_account_points_rewards my_account_orders">--}}
      {{--<thead>--}}
        {{--<tr>--}}
          {{--<th class="points-rewards-event-description"><span class="nobr">事件</span></th>--}}
          {{--<th class="points-rewards-event-date"><span class="nobr">日期</span></th>--}}
          {{--<th class="points-rewards-event-points"><span class="nobr">积分</span></th>--}}
        {{--</tr>--}}
      {{--</thead>--}}
      {{--<tbody>--}}

      {{--@foreach($user->point_logs as $log)--}}
      {{--<tr class="points-event">--}}
        {{--<td class="points-rewards-event-description">{{$log->remark}}</td>--}}
        {{--<td class="points-rewards-event-date"><abbr title="{{$log->created_at}}">{{$log->created_at}}</abbr></td>--}}
        {{--<td class="points-rewards-event-points" width="1%"> @if (1 == $log->type)--}}
          {{---{{$log->point}}--}}
          {{--@else--}}
          {{--+{{$log->point}}--}}
          {{--@endif </td>--}}
      {{--</tr>--}}
      {{--@endforeach--}}
        {{--</tbody>--}}

    {{--</table>--}}
  </div>

    <div class="sign_box modal" id="bookInSign">
        <div class="sign_integral_box" style=" height:100px;">
            <div class="left integral" style="width:400px;">
                <div class="sign_ico left"></div>
                <h2 class="left">积分：<span id="user-point">{{$user->points}}</span>分</h2>
                <p class="left" style="width:316px; margin-left:20px;">已连续签到<span id="last-day">{{$last_days or '0'}}</span>天</p>
            </div>
            <span class="closebtn" onclick="layer.closeAll();" style="position: absolute;right:0;top:0;padding: 10px 10px 5px 10px;cursor: pointer;">╳</span>
            @if($is_qiandao)
                <a href="javascript:void(0);" class="fr Button6 mt10" disabled="disabled" id="attendances" >已签到</a> 
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
                            <li class="active"> @else

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
            <div class="shuomin">说明：连续签到可获得更多印币 ，本站印币可增加下载次数和会员费用抵扣。<br>
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
                        <td>等级额外积分</td>
                        <td>+2</td>
                        <td>+4</td>
                        <td>+6</td>
                        <td>+8</td>
                        <td>+10</td>
                        <td>+13</td>
                        <td>+16</td>
                        <td>+20</td>
                    </tr>
                    <tr><td colspan='9'>说明：签到最终印币=基础印币+会员额外印币+等级额外印币，节日更多惊喜等着你哦！</td></tr>
                </table>
            </div>
        </div>
    </div>
        <!--------签到规则结束--------->


    <!-- 印币规则开始 -->
    <div class="ybtab" style="position: absolute;top: 80%;left: 22%;z-index: 99;width: 900px;height: 660px;background:#fff;border-radius: 7px;text-align: center;display:none;">
        <span class="closeybtab" style="position: absolute;right:0;top:0;padding: 10px 10px 5px 10px;cursor: pointer;font-size: 18px;">╳</span>
        <table style="text-align:center;margin:50px auto;width:850px;">
            <tr style="text-align:center;font-size:18px;"><td colspan="9">印币规则</td></tr>
            <tr>
                <td colspan="3">类型</td>
                <td colspan="2">印币单位：印币</td>
                <td colspan="2">印币比例：1：10</td>
                <td colspan="2">印币抵扣（次/印币）1：10</td>
            </tr>
            <tr>
                <td rowspan="10">印币的获取</td>
                <td rowspan="8">获取（通用）</td>
                <td rowspan="2">签到</td>
                <td colspan="6" rowspan="2">详见签到印币规则</td>
            </tr>
            <tr>
               
            </tr>
            <tr>
                <td rowspan="2">评分</td>
                <td colspan="3">设置</td>
                <td colspan="3">获取印币（次）</td>

            </tr>
            <tr>
                <td colspan="3">印币</td>
                <td colspan="3">2</td>
            </tr>

            <tr>
                <td rowspan="2">发现</td>
                <td colspan="2">设置</td>
                <td colspan="2">获取印币（次）</td>
                <td colspan="2">每天次数</td>

            </tr>
            <tr>
                <td colspan="2">印币</td>
                <td colspan="2">1</td>
                <td colspan="2">50</td>
            </tr>

            <tr>
                <td rowspan="2">评论</td>
                <td colspan="3">设置</td>
                <td colspan="3">获取印币（次）</td>

            </tr>
            <tr>
                <td colspan="3">印币</td>
                <td colspan="3">12</td>
            </tr>
            
            <tr>
                <td colspan="2">会员类型</td>
                <td>普通会员</td>
                <td>月会员</td>
                <td>季会员</td>
                <td>年会员</td>
                <td>特邀作者</td>
                <td>公司</td>
            </tr>
            <tr>
                <td>获取（会员）</td>
                <td>开通会员（印币）</td>
                <td>8</td>
                <td>58</td>
                <td>168</td>
                <td>288</td>
                <td colspan="2" rowspan="4">Space2.0  敬请期待！</td>
                

            </tr>
            <tr>
                <td rowspan="3">印币消费</td>
                <td rowspan="2">消费（普通）</td>
                <td>抵扣下载次数（次/天）</td>
                <td>1</td>
                <td>3</td>
                <td>5</td>
                <td>10</td>
             
            </tr>
            <tr>
                <td>抵扣印币（印币/天）</td>
                <td>-10</td>
                <td>-30</td>
                <td>-50</td>
                <td>-100</td>
        
            </tr>
            <tr>
                <td>消费（会员）</td>
                <td>开通会员抵扣印币（印币）</td>
                <td>0</td>
                <td>-50</td>
                <td>-280</td>
                <td>-880</td>
         
            </tr>




        </table>
    </div>
    <!-- 印币规则结束 -->

</section>
<script>
$(function() { 
  $.ajax({  
        type: "post",  
        url: "/member/one_visited",  
        data: {_token: "{{csrf_token()}}"},  
        dataType: "json",  
        success: function(data) {  
          console.log(data)
          if(data.status_code == 0){
            layer.msg(data.message,{time: 1500,skin: 'intro-login-class layui-layer-hui'});
            window.location.href='/member/profile';
          }else{
            layer.msg(data.message,{time: 1500,skin: 'intro-login-class layui-layer-hui'});
          }
          
        }  
    });      
})
</script>
<script>
    //点击兑换VIP出现确定弹窗
    $('.point-duihuan').click(function(){
        let yb=$(this).attr('yb');
        let vip_type=$(this).siblings('.vip_type').html();
        vip_types=vip_type.substr(0,4);
        let viptype=0;
        if(yb=='50'){
            viptype=1;
        }else if(yb=='280'){
            viptype=2;
        }else if(yb=='880'){
            viptype=3;
        }
        layer.open({
            title: ['温馨提示'],
            content: '确定兑换'+vip_types,
            btn: ['确定','取消'],
            shadeClose: true,
            //回调函数
            yes: function(index){
                // self.location='/vip/intro';//确定按钮跳转地址
                $.ajax({
                    url: '/member/is_enough_points',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _token:_token,
                        yb:yb,
                    },
                    success: function (data) {
                        console.log(data)
                        if (data.status_code == 0) {
                            layer.msg(data.data.msg,{time: 1500,skin: 'intro-login-class layui-layer-hui'});
                            window.location = '/vip/pay?vip_type=' + viptype+'&yb='+yb;
                            return;
                        } else {
                            layer.msg(data.message,{time: 1500,skin: 'intro-login-class layui-layer-hui'});

                        }
                    }
                });
            }
        })


        /*$.ajax({
            url: '/member/duihuanvip',
            type: 'POST',
            dataType: 'json',
            data: {
                _token:_token,
                yb:yb,
            },
            success: function (data) {
                console.log(data)
                if (data.status_code == 0) {
                    
                    layer.msg(data.data.remark,{time: 1500,skin: 'intro-login-class layui-layer-hui'});
                } else {
                    // alert(data.message);
                    layer.msg(data.message,{time: 1500,skin: 'intro-login-class layui-layer-hui'});

                }
            }
        });*/
    })
    $(document).on("click", ".ybrole",function () {
        $('.lzcfg').css('display','block');
        $('.ybtab').css('display','block');
        $('.ybtab').css('z-index','999999999999');
    })
    
    $(document).on("click", ".closeybtab",function () {
        $('.lzcfg').css('display','none');
        $('.ybtab').css('display','none');
    })
</script>


<script src="/js/layer.js"></script> 
<script src="/js/member.js"></script> 
@endsection