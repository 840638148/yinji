@extends('layouts.app')

@section('title')
    {{trans('comm.yinji')}} - 地产介绍
@endsection

@section('content')


<style>
.swiper-slide{margin-right:20px !important;}
.swiper-pagination-fraction{bottom: unset;left: unset; width: unset;}
.swiper-pagination{position: unset;}
</style>


<section><img src="/uploads/{{$lists->bgimg}}"  alt="地产" /></section>


<div class="company_bj1">
  <div class="wrapper">
    <div class="company_left"> <img src="/uploads/{{$lists->logoimg}}" alt="万科" />
      <div class="company_ico"><a href="{{$lists->url1}}" target='_blank'><i class="icon-sun"></i> </a><a href="{{$lists->url2}}" target='_blank'><i class="icon-qq"></i> </a><a href="{{$lists->url3}}" target='_blank'><i class="icon-skype"></i> </a></div>
    </div>
    <div class="company_right">
      <h1>公司简介/Company Profile</h1>
      <div class="company_Profile" style='height:340px;overflow: hidden;'>{!!get_dc_intro($lists)!!}</div>
    </div>
  </div>
</div>

<div class="company_bj2" >
    <div class="wrapper">
        <div class="company_luopan swiper-container">
            <ul class='swiper-wrapper'>
                @foreach($articlelist as $alist)
                <li class='swiper-slide'><div class="index_dafen"><i>{{sprintf("%.1f",$alist->lpavg)}}</i></div><a href="/lpintro/{{$alist->id}}" title='{{$alist->name}}' target='_blank'><img style='width:100%;height:420px;' src="/uploads/{{$alist->bgimg}}" alt="111" /></a><span class="guojia cs"><a href="/details/{{$alist->id}}" target='_blank' rel="tag">{{$alist->area}}</a></span></li>
                @endforeach
                <!-- <li><div class="index_dafen"><i>9.0</i></div><img src="/images/dc_01.jpg" alt="111" /><span class="guojia cs"><a href="#" rel="tag">广州</a></span></li> -->
                <!-- <li><div class="index_dafen"><i>9.0</i></div><img src="/images/dc_01.jpg" alt="111" /><span class="guojia cs"><a href="#" rel="tag">广州</a></span></li> -->
                
            </ul>
        </div>
        <div class="fr company_button">
            <h1 class='swiper-pagination'></h1>
            <div class="swiper-button-next1 icon-angle-right"></div>
            <div class="swiper-button-prev1 icon-angle-left"></div>
        </div>
        
        <div class="wrapper">
            <div class="company_contact" >
                <h2>{{get_dc_name($lists)}}</h2>
                <p>地址：{{get_dc_address($lists)}}</p>
                <p>电话：{{$lists->tel}}</p>
                <p>传真：{{$lists->fax}}</p>
                <p>邮箱：{{$lists->email}}</p>
                
            </div>
            <div class="company_news">
                <dl>
                    <dt>标题一</dt>
                    <dd>{{$lists->title}}</dd>
                </dl>
                <dl>
                    <dt>标题二</dt>
                    <dd>{{$lists->title1}}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
<!-------地产集团介绍结束------->
<script src="/js/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 3,
        spaceBetween: 30,
        slidesPerGroup: 3,
        loop: true,
        loopFillGroupWithBlank: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            type: 'fraction',
        },
        navigation: {
            nextEl: '.swiper-button-next1',
            prevEl: '.swiper-button-prev1',
        },
        
    });

    
</script>


@endsection