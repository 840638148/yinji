@extends('layouts.app')
@section('title')
  {{trans('comm.yinji')}} - 个人中心
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
</style>
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
    	
	      <li class="current"><a  href="/member">个人中心</a></li>
	      <li><a href="/member/finder">我的发现</a></li>
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
    <div class="order_center">
      <ul>
        <li class="order1"><a href="/vip/index/{{$user->id}}">我的主页</a><i class="order1_bj"></i> </li>
        <li class="order2"><a href="/vip/intro">成为会员</a><i class="order1_bj"></i> </li>
        <li class="order3"><a href="/member/point">我的积分</a><i class="order1_bj"></i> </li>
        <li class="order4 bookInSign"><a href="javascript:;">签到</a></li>
      </ul>
    </div>
    <div class="title">
      <h2>我的订阅</h2>
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
      <h2>我的关注</h2>
    </div>
    <div class="designer">
      <ul>
        @foreach ($user->follows as $key => $follow)
              @if ($key < 13)
                <li class="guanzhu-item"> <a href="/user/index/{{$follow->id}}" target="_blank" title="{{$follow->nickname}}" onclick="selectItemGuanZhu({{$key}})"><span class="select-item"></span>  <img src="@if($user->avatar) {{$user->avatar}} @else /img/avatar.png @endif" alt="{{$follow->nickname}}" /> </a> </li>
              @elseif($key == 13)
                      <li><a href="/member/follow" class="more-content"></a></li>
                @endif
             @endforeach
      </ul>
    </div>
    
    <div class="title  mt30">
      <h2 class="fl">我的发现</h2>
      <span class="fr"><a href="/member/finder">更多</a></span>
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
    
      <h2 class="fl">我的收藏</h2>
      <span class="fr"><a href="/member/collect">更多</a></span> </div>
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
    <h2 class="left">积分：<span id="user-point">{{$user->points}}</span>分</h2>
    <p class="left" style="width:316px; margin-left:20px;">已连续签到<span id="last-day">{{$last_days or '0'}}</span>天</p>
  </div>
  <a href="#" class="fr Button3 mt10" id="attendance">签到</a> </div>
<div class="sign_tab">
  <ul>
    <li class="active record_tab">签到记录</li>
    <li class="change_tab">积分兑换</li>
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
      <th>获得积分</th>
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
            <td>VIP{{$attendance->vip_level or ''}}</td>
            <td>{{$attendance->created_at->toDateString()}}</td>
          </tr>
          @endforeach
              @endif
            </tbody>
          
        </table></td>
    </tr>
      </tbody>
    
  </table>
  <div class="shuomin">说明：连续签到可获得更多积 ，本站积分可增加下载次数和会员费用抵扣。<br>
   使用规则：即10积分=1元，每增加一次下载次数使用10积分！</div>
</div>
<!------签到记录结束---------->
<!--------积分兑换--------->
<div class="change_box tab_box">
  <div class="change">
  <ul>
  <li><img src="images/book.jpg" alt="商品图片">
  <dl>
  <dt>印际月度会员兑换</dt>
  <dd><span>￥23.00+500</span>积分</dd>
  <del>原价:28.00</del>
  </dl>
  <ul>
  <li><a href="#" class="Button3">兑换</a></li>
  <li>已<span>78</span>人兑换</li>
  </ul>
  </li>
   <li><img src="images/book.jpg" alt="商品图片">
  <dl>
  <dt>印际季度会员兑换</dt>
  <dd><span>￥76.00+1200</span>积分</dd>
  <del>原价:88.00</del>
  </dl>
  <ul>
  <li><a href="#" class="Button3">兑换</a></li>
  <li>已<span>78</span>人兑换</li>
  </ul>
  </li>
   <li><img src="images/book.jpg" alt="商品图片">
  <dl>
  <dt>印际年度会员兑换</dt>
  <dd><span>￥250.00+3000</span>积分</dd>
  <del>原价:288.00</del>
  </dl>
  <ul>
  <li><a href="#" class="Button3">兑换</a></li>
  <li>已<span>78</span>人兑换</li>
  </ul>
  </li>
  </ul></div>
</div>
<!--------积分兑换结束--------->
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
            $('.order_center .order2').find('a').html('会员中心')
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


<!--收藏夹图片浏览-->
<!--<div class="img_browse modal" id="img-browse" >
  <div class="close">关闭</div>
  <div class="left">
    <div style="height:48px;">
      <h2 class="fl">文件夹名称333</h2>
      <span class="fr">分享到：</div>
    <div class="image"><img src="/images/ad_05.gif" alt="发现的图片" class="selected-image"/> </div>
  </div>
  <div class="right" style="margin-top:48px;">
    <div class="more_img"> 
      <a href="#" class="more-img-item selected"><img src="images/imges.jpg" alt="图片一" /> <div class="cover"></div></a>
      
      <a href="#" class="more-img-item"><img src="images/ad_05.gif" alt="图片一" /><div class="cover"></div></a> 
      <a href="#" class="more-img-item"><img src="images/design_16-03.gif" alt="图片二" /><div class="cover"></div></a> 
      <a href="#" class="more-img-item"><img src="images/about_img.jpg" alt="图片一" /><div class="cover"></div></a> 
      <a href="#" class="more-img-item"><img src="images/ad_22.gif" alt="图片二" /><div class="cover"></div></a> 
      <a href="#" class="more-img-item"><img src="images/ad_05.gif" alt="图片一" /><div class="cover"></div></a> 
      <a href="#" class="more-img-item"><img src="images/design_16-03.gif" alt="图片二" /><div class="cover"></div></a> 
      <a href="#" class="more-img-item"><img src="images/about_img.jpg" alt="图片一" /><div class="cover"></div></a> 
      <a href="#" class="more-img-item"><img src="images/ad_22.gif" alt="图片二" /><div class="cover"></div></a> 
      <a href="#" class="more-img-item"><img src="images/ad_05.gif" alt="图片一" /><div class="cover"></div></a> 
      <a href="#" class="more-img-item"><img src="images/design_16-03.gif" alt="图片二" /><div class="cover"></div></a> </div>
    <hr />
    <div class="discoverer">
        <div class="head"><img src="images/design_16-03.gif" alt="头像" /></div>
        <h2><a href="#">大仁哥1027</a> <span class="vip1">VIP</span></h2>
          <a class="Button">关注</a>
      </div>
    <hr />
    <div class="faxian_info">
      <p>由 <a href="#">严PPPPPPPP1</a> 收藏于 <a href="#">大厅</a></p>
      <p>2017-06-02 14:59:57</p>
      <p class="laiyuan"><a href="#">来源：Lera Brumina作品 | 80㎡ Apartmen...</a></p>
    </div>
  </div>
</div>-->
<!--发现图片浏览结束--> 

<script src="/js/layer.js"></script>
<script src="/js/member.js"></script>




@endsection