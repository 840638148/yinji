@extends('layouts.app')

@section('title')
    {{trans('comm.yinji')}} - {{trans('index.real_estate')}}
@endsection

@section('content')
<style>
  .action{width: 400px;height: 30px;margin: 10px 0;}
  body{background:#f8f8f8 !important;}
  .home_box{border-radius:10px !important;}
  .home_top{background:#fff !important;}
  /* .postgrid figure{height:unset;} */
  /* .chengshi{bottom:10px;font-size: 16px;width: 100px;background: url(/images/cs.png) center 18px;right: 30px;} */
  #ajaxpost:hover .lpbt{display: block;position: absolute;width: 386px;height: 100%;background-color: rgba(0,0,0,.3);top: 0;left: 0;text-align: center;}
  .dcpf{transform: rotate(-45deg) !important;display: inline-block;}
  .icon-search-1{cursor: pointer;}
  #myTab1 li{width:20%;}
  .nav_fenlei .sort {right: 15px;top: 18px;}
  .content-post h2{margin:unset;padding:0 10px;}
  .TabContent{padding-top: 20px;}
  .nav_fenlei, .nav_fenlei2{margin-bottom:0;}
  .lpbt h3 {margin-top: 30%;}
</style>
<section><img src="images/company_banner.jpg"  alt="地产" /></section>
<section class="wrapper">

  <!-- <div class="mt30 home_box"> -->
    <div class="nav_fenlei TabTitle">
      <ul id="myTab1" style="float:left; width:600px;">
        <li class="active" cate='lp' onclick="nTabs(this,0);">地产楼盘</li>
        <li class="normal" id='dc' cate='dc' onclick="nTabs(this,1);">开发商</li>
      </ul>
      <div class="sort"><i class="icon-list-bullet"></i>
        <ul class="sortlist">
          <li class="allsort" so="starssort">{{trans('article.sort_by_grade')}}<span class="arrow" aw="desc">↓</span></li>
          <li class="allsort" so="timesort">{{trans('article.sort_by_time')}}<span class="arrow" aw="desc">↓</span></li>
          <li class="allsort" so="llsort">{{trans('article.sorted_by_browse')}}<span class="arrow" aw="desc">↓</span></li>
        </ul>
      </div> 
      <div class="nav_search">
        <form id="myform" action="/vip/finderslistsearch" method="post" class="search_form" onkeydown="if (event.keyCode == 13) return false"  >
          <i class="icon-search-1" id='search_icon'></i>
          <input name="" type="text" id='txt_name' class="search_input"/>
        </form>
      </div>
    </div>

    <div class="TabContent content-post"> 
      <!-- 地产楼盘开始 -->
      <div id="myTab1_Content0">
        <section class="post_list box post_bottom triangle wow bounceInUp animated" style="visibility: visible; animation-name: bounceInUp;">
          <ul class="layout_ul ajaxposts article-content">
          @foreach($loupanlists as $loupan)
            <li class="layout_li ajaxpost" id="ajaxpost" >
              <div class="interior_dafen"><span class='dcpf'>{{sprintf("%.1f",$loupan->lpavg)}}</span></div>
              <article class="postgrid">
                  <figure style='height:unset;'>
                    <img class="thumb0" src="/uploads/{{$loupan->bgimg}}" data-original="" alt="" style="display: block;">
                  </figure>
                  <div class="chengshi">{{$loupan->area}}</div>
                  <a href="/lpintro/{{$loupan->url}}" target="_blank"><div class="lpbt"><h3>{{$loupan->name}}</h3></div></a>
              </article>
            </li>
            @endforeach
          </ul>
        </section>
      </div>
      <!-- 地产楼盘结束 -->

      <!-- 地产开始 -->
      <div id="myTab1_Content1"  class="none">
        <section class="post_list box post_bottom triangle wow bounceInUp animated" style="visibility: visible; animation-name: bounceInUp;">
          <ul class="layout_ul ajaxposts article-content">
          @foreach($dclists as $dc)
            <li class="layout_li ajaxpost" id="ajaxpost">
              <article class="postgrid">
                  <figure><img class="thumb0" src="/uploads/{{$dc->cover}}" data-original="" alt="" style="display: block;"></figure>
                  <a href="/dcintro/{{$dc->url}}" target="_blank"><div class="lpbt"><h3>{{$dc->name}}</h3></div></a>
              </article>
            </li>
            @endforeach
          </ul>
        </section>
      </div>
      <!-- 地产结束 -->
    </div>
  <!-- </div> -->

</section>

<script type="text/javascript">

  // $(function(){
  //   let url=window.location.href;
  //   urls=url.split('?')[1];
  //   let cate=document.getElementById('dc');
  //   if(urls=='dc=dc'){
  //     let a=nTabs(cate,1)
  //   }
  // });



  window.cate='lp';
  // 选项卡切换
  function nTabs(thisObj,Num){
    if(thisObj.className == "active")return;
      var tabObj = thisObj.parentNode.id;
      var tabList = document.getElementById(tabObj).getElementsByTagName("li");

    for(i=0; i <tabList.length; i++){
      if (i == Num){
        thisObj.className = "active";
        document.getElementById(tabObj+"_Content"+i).style.display = "block";
        window.cate=thisObj.getAttribute('cate');//获取tab的分类
        
        page = 2;isEnd = false;
      }else{
        tabList[i].className = "normal";
        document.getElementById(tabObj+"_Content"+i).style.display = "none";
      }
    }
  }


  //绑定回车事件
  $("#myform #txt_name").keydown(function (e) { 
    var keyCode = e.keyCode ? e.keyCode : e.which ? e.which : e.charCode; //兼容IE 火狐 谷歌
    if (keyCode == 13) {
      $(this).siblings('#search_icon').trigger("click");
      return false;
    }
  });



  //打开排序列表
  $(document).on('click','.sort',function(){
    $('.sortlist').toggle(500);
  })

  //在桌面任意地方点击，关闭当前窗口  其中，$("body").click(function(e){}表示为页面的body注册点击事件，当点击页面主体内容时执行函数里面的代码。e.target和this都是DOM对象，this是可以变化的，比如说多个标签同时使用一个函数，就可以用this来获取标签中的某一个的属性。e.target是不会变化的，它永远是直接接受事件的目标DOM元素。此处的.tk,#s1表示弹出框或者其他想要排除的元素，点击除这些之外的元素执行方法，隐藏弹出框。
  $("body").click(function(e) {
    if(!$(e.target).closest(".sort").length) {
		  $(".sortlist").slideUp()
    }
  });


  window.type='';
  window.sjx='';
  $(document).on('click','.allsort',function(){
      page=1;
      let that=$(this);
      type=that.attr('so');
      sjx=that.find(".arrow").attr('aw');
      let url = window.location.href;
      // let types=url.split('/')[3];//分类名
      let category_id=url.split('/')[5];//分类id
      
      // console.log(type,page,cate); 

      layer.closeAll();  
      $.ajax({
        url: '/dichan/allsortlist',
        type: 'POST',
        dataType: 'json',
        data:{type:type,sjx:sjx,cate:cate,},
        success: function (data) {
          // console.log(data)
          //改变排序的值
          if(data.status_code == 0) {
            isEnd=false;
            page++;
            // console.log('传过来了');
            if(that.find(".arrow").attr('aw')=='desc' && that.find(".arrow").html()=='↓'){
              that.find(".arrow").attr('aw','asc');
              that.find(".arrow").html('↑');  
            }
            else if(that.find(".arrow").attr('aw')=='asc' && that.find(".arrow").html()=='↑'){
              that.find(".arrow").attr('aw','desc');
              that.find(".arrow").html('↓');
            }
            
            if(data.data.cate=='lp'){
              $('#myTab1_Content0 ul').html(data.data.res);
            }else if(data.data.cate=='dc'){
              $('#myTab1_Content1 ul').html(data.data.res);
            }

          }else{
            layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'});
          }
        }
      });
    })



  //搜索框
  window.content='';
  $(document).on('click','#search_icon',function(){
      let h='';
      window.content=$(this).siblings('.search_input').val();
      if(content=='' || content==null){
        layer.msg('请填写搜索关键词',{skin: 'intro-login-class layui-layer-hui'});
        return false;
      }else{
        $.ajax({
          async:false,
          url: '/dichan/search',
          type: 'POST',
          dataType: 'json',
          data: {content:content,cate:cate,},
          success:function(data) {
            
            if(data.status_code==0){
              if(data.message.cates=='lp'){
                $('#myTab1_Content0 ul').html(data.message.res);
              }else if(data.message.cates=='dc'){
                $('#myTab1_Content1 ul').html(data.message.res);
              }

            }else{
              layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'});
              $('.text_input').val('');
            }
          }
        });
      }  
    // }
  })

  // 分页
  let page = 2;isEnd = false;
  $(window).on('scroll',function(e){
    
    let bodyHeight=document.body.scrollHeight==0?document.documentElement.scrollHeight:document.body.scrollHeight;
    if(bodyHeight - $('body').scrollTop() -10 < window.innerHeight && !isEnd){
      let h  = '';
      let url = window.location.href;
      $.ajax({
          async: false,
          url: url + '_ajax?page=' + page+'&cate='+cate+'&content='+content+'&type='+type,
          type: 'POST',
          dataType: 'json',
          data: {},
          success: function(data){
            // console.log(data);
            let cate=data.data.cate;
            if(data.status_code == 0){
              switch(cate){
                case 'lp':
                    page++;
                    $('#myTab1_Content0 ul').append(data.data.res);
                    if(data.data.length<0){isEnd = true}else{isEnd = false}
                break;
                case 'dc':
                    page++;
                    $('#myTab1_Content1 ul').append(data.data.res);
                    if(data.data.length<0){isEnd = true}else{isEnd = false}
                break;
              }
            }else{
              isEnd = false
              layer.msg(data.message);
            }

          }
      });
    }
  })

</script>
@endsection