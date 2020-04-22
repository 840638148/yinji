@extends('layouts.app')
@section('title')
    {{trans('designer.all_designer')}}_{{trans('comm.yinji')}}
@endsection
@section('content')
<!-----------导航介结束----->
<div class="banner_news"  style="background-image:url(/images/banner_news3.jpg)"> —— Designer —— </div>
<!------顶部大图结束----->
<section class="wrapper box" style="min-height: 670px">
    <div class="nav_fenlei">

        <ul class="categories-wrap" data-categories = '{{$categories}}'>

            <li @if (!isset($current_category) || $current_category == 0) class="current-cat" @endif><a href="/designer" >{{trans('designer.all')}}</a></li>

            @foreach ($categories as $key=>$category)

                <li style="display:{{$key>7?'none':'block'}}" @if (isset($current_category) && $current_category == $category->id) class="current-cat" @endif><a href="/designer/category/{{$category->id}}">@if('zh-CN' == $lang) {{$category->name_cn}} @else {{$category->name_en}} @endif</a></li>

            @endforeach

            <!--<li><a href="#"><i class="icon-align-justify"></i></a></li>-->

        </ul>

    </div>

    <!--------分类结束-------->



    <section class="ffe ffe_list ffe_content mt20">

        <ul class="layout_ul ajaxposts designer-content">

            @foreach ($designers as $designer)

            <li class="layout_li ajaxpost ">
          
                @if ('1' == $designer->industry)

                    <div class="interior"></div>

                @else

                    <div class="architect"></div>

                @endif



                <article class="postgrid design" style="visibility: visible; animation-name: bounceInUp;">

                    <figure> <a href="@if($designer->static_url) /designer/{{$designer->static_url}} @else /designer/detail/{{$designer->id}} @endif" title="{{get_designer_title($designer)}}" target="_blank">

                            <img class="thumb" src="{{get_designer_thum($designer)}}" data-original="{{get_designer_thum($designer)}}" alt="{{get_designer_title($designer)}}" style="display: block;"> </a> </figure>

                    <section class="ffe_main">

                        <h2><a href="@if($designer->static_url) /designer/{{$designer->static_url}} @else /designer/detail/{{$designer->id}} @endif" title="{{get_designer_title($designer)}}" target="_blank">{{get_designer_title($designer)}}</a></h2>

                        <div class="design_post">

                            <!--分类-->

                            <span class="guojia">

                                @foreach ($designer->categorys as $category)

                                    <a href="#" rel="tag">{{$category['name']}}</a>

                                @endforeach

                            </span>  

                            <span class="ffe_liulan">{{$designer->starsav==0 ? '5.0' : $designer->starsav}}</span></div>

                    </section>  

                </article>

            </li>

            @endforeach

        </ul>

    </section>

</section>



<script>

    var page = 2;isEnd = false

    function getMoreDesigner(){

        /*

        var h = `<li class="layout_li ajaxpost">
                     <div class="architect"></div>
                        <article class="postgrid design" style="visibility: visible; animation-name: bounceInUp;">
                            <figure> <a href="/designer/detail/14" title="贝聿铭" target="_blank">
                            <img class="thumb" src="http://120.79.234.88/uploads/public/photo/images/custom_thum//bf087a13357fad9412d3c591dba48062.jpg" data-original="http://120.79.234.88/uploads/public/photo/images/custom_thum//bf087a13357fad9412d3c591dba48062.jpg" alt="贝聿铭" style="display: block;"> </a> </figure>
                            <section class="ffe_main">
                                <h2><a href="/designer/detail/14" title="贝聿铭" target="_blank">贝聿铭</a></h2>
                                <div class="design_post">
                                    <!--分类-->
                                    <span class="guojia">
                                        <a href="#" rel="tag">中国</a>
                                        <a href="#" rel="tag">美国</a>
                                </span>
                                    <span class="ffe_liulan">10</span></div>
                            </section>
                        </article>
                </li>`



        var arr = [];
        for(var i = 0; i< 6;i++){
            arr.push(h)
        }
        */
    }



    $(function(){
        var $lis = [];
        var isEN =  "<?php echo $lang?>"
        var h = '<li class="more_designer_contury"><a class="more-nav-item"><i class="icon-align-justify"></i></a><ul>';
        $('.nav_fenlei>ul li').each(function(i, item){
            if(i >= 9){
                $(item).hide();
                h += '<li style="width:25%">' + $(item).html()+'</li>';
            }
        })
        h += '</ul></li>'
        $('.nav_fenlei ul').append(h)


        // 添加选中状态
        var url = window.location.href ,tempIndex  = 0;
        var item = url.split('/').splice(-1,1);
        var categorys = JSON.parse($('.categories-wrap').attr('data-categories'))
        var itemText = '';
        categorys.map(function (list,index) {
            if(list.id == item){
                tempIndex=index
                if(isEN=='zh-CN'){
                    itemText = list.name_cn
                }else{
                    itemText = list.name_en
                }
            }
        })

        if(tempIndex>7){
            // console.log(itemText)
            $('.more_designer_contury .more-nav-item').html(itemText + '<i class="icon-align-justify"></i>')
            $('.more_designer_contury').addClass('current-cat')
            $('.more_designer_contury').siblings().removeClass('current-cat')
        }
    })




    //设计师分页
    $(window).on('scroll',function(e){
        var bodyHeight=document.body.scrollHeight==0?document.documentElement.scrollHeight:document.body.scrollHeight;
        if(bodyHeight - $('body').scrollTop() -10 <window.innerHeight && !isEnd){
            var h  = '';
            var url = window.location.href;
            $.ajax({
                async: false,
                url: url + '?page=' + page,
                type: 'GET',
                dataType: 'json',
                data: {},
                success: function (data) {
                    if (data.status_code == 0) {
                        page++;
                        h =  data.data.join('')
                        $('.designer-content').append(h)
                        if(data.data.length<15){
                            isEnd = true
                        }
                    } else {
                        isEnd = true
                        alert(data.message);
                    }
                }
            });
        }
    })

</script>

@endsection

