@extends('layouts.app')

@section('title')
    {{trans('comm.yinji')}} - 地产公司介绍
@endsection

@section('content')

<section><img src="images/company_banner.jpg"  alt="地产" /></section>

<!-------地产列表------->
<section class="wrapper box">
    <div class="nav_fenlei">
        <ul>
            <li>地产设计</li>
            <li>地产楼盘</li>
            <li class="current-cat">开发商</li>
        </ul>
    </div>
    <div class="nav_search">
        <i class="icon-search-1"></i>
        <input name="" type="text"  class="search_input"/>
    </div>
        <!--------分类结束-------->
    <div class="developers">
        <ul>
            <li>
                <div class="developers_logo"><a href="#"><img src="images/dclogo.jpg" alt="万达" /></a></div>
                <div class="property">
                    <ul>
                        <li><a href="#"><img src="images/dc_01.jpg" alt="楼盘" /></a></li>
                        <li><a href="#"><img src="images/dc_01.jpg" alt="楼盘" /></a></li>
                        <li><a href="#"><img src="images/dc_01.jpg" alt="楼盘" /></a></li>
                    </ul>
                </div>
                <a class="property_prev " href="#"><img src="images/moandmo.png" alt="上一页" /> </a> <a class="property__next" href="#"><img src="images/moandmo2.png" alt="下一页" /> </a>
            </li>
            <li>
                <div class="developers_logo"><a href="#"><img src="images/dclogo.jpg" alt="万达" /></a></div>
                <div class="property">
                    <ul>
                        <li><a href="#"><img src="images/dc_01.jpg" alt="楼盘" /></a></li>
                        <li><a href="#"><img src="images/dc_01.jpg" alt="楼盘" /></a></li>
                        <li><a href="#"><img src="images/dc_01.jpg" alt="楼盘" /></a></li>
                    </ul>
                </div>
                <a class="property_prev " href="#"><img src="images/moandmo.png" alt="上一页" /> </a> <a class="property__next" href="#"><img src="images/moandmo2.png" alt="下一页" /> </a>
            </li>
        </ul>
    </div>
</section>






@endsection