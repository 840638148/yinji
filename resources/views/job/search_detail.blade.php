@extends('layouts.app')
@section('title')
    {{trans('comm.yinji')}} --招聘信息详情
@endsection

@section('content')
<style>
  .job_ab li .job_ab_info{
    display:none;
  }
  .job_ab li:hover .job_ab_info{
    display:block;
  }
  #projects .swiper-pagination{
    text-align:right;
    padding-right:20px;
  }


  .swiper-slide .detail{
    background:rgba(0,0,0,.7);
    position:absolute;
    width:100%;
    bottom:0;
    color:#fff;
    opacity:0;
    transition:opacity .3s .3s;
    line-height: 40px;
    padding-left: 20px;
  }
  .swiper-slide-active .detail{  
    opacity:1;
  }
  .swiper-slide .detail h3{
    width:950px;
    margin:15px auto 0;
  }
  .swiper-slide .detail p{
    width:950px;
    margin:5px auto 0;
  } 
  .swiper-slide .detail span {
  width:80%;
  display:block;
  overflow:hidden;
  text-overflow:ellipsis;
  white-space:nowrap;
  }

  .l-t-title{
  position:absolute;
  top:20px;
  height:auto;
  width:auto;
  border-bottom: 40px solid #e1244e;
  border-right:20px solid transparent;
  color: #ffffff;
  line-height: 0;
  }
  .l-t-title p{
  position: relative;
  top:20px;
  padding: 0 20px;
  }

  @media only screen and (max-width: 768px){
    .swiper-slide .detail{
      height:40px;
    }
  }
  .job_ab{max-height: 940px;overflow: hidden;}
</style>
<section><img src="/images/job_02.jpg"  alt="工作" /></section>
<section class="wrapper">
  <div class="left cat-wrap m_foot mt30"> 
    <!--招聘信息详情-->
    <div class="projects swiper-container" style="position:relative" id="projects">
        <div class="swiper-wrapper">
		@foreach ($jobproject as $list)
			<div class="swiper-slide">
				<div class="l-t-title">
				<p>公司项目 Projects</p >
			</div>
				<img onclick="location='/article/{{$list['link_url']}}'" class="img-responsive" src="/uploads/{{$list['project_photo']}}" title="{{$list['project_name']}}" name="{{$list['project_name']}}" />
  
				<p class="detail" >
					<span>{{$list['project_name']}}</span>	
				</p>
			</div>
        @endforeach
        
        
        </div>  
        <!-- 如果需要分页器 -->
        <div class="swiper-pagination" style="position:absolute; right:20px; bottom:15px;">
            <span class="swiper-pagination-bullet"></span>
        </div>
        
    </div>
    <div class="job_info mt30">
      <div class="left_title">
        <h2>招聘职位</h2>
      </div>
      <div class="job_details">
        <ul>
         @foreach ($companyde as $detail)
          <li>
            <div class="position">O {{$detail['job_name']}}</div>
            <div class="place">工作地点：{{$detail['addr']}}</div>
            <div class="position_content">
              <dl>
                <dt> 职位内容：</dt>
                <dd>
                {!! $detail['content'] !!}
                </dd>
              </dl>
            </div>
            <div class="position_content">
              <dl>
                <dt>任职要求：</dt>
               <dd>
                {!!$detail['skills']!!}
                  </dd>
              </dl>
            </div>
          </li>
           @endforeach
          
        </ul>
      </div>
      
      <div class="apply_job">
       <dl>
       	@foreach ($companyde as $list)
        @if ($loop->first)
      <dt>申请方式</dt>
       <dd>
       <p>申请人请将PDF格式的作品集及简历发到 <a href="javascript:void(0);"> {{$list->email}} </a>，并在标题处注明应聘职位。</p>
       <p>电话：{{$list->tel}}转人事部</p>
       <p>官网：<a href="{{$list->web_site}}" target="_blank">{{$list->web_site}}</a></p>
       <p>地址：{{$list->addr}}</p>
      </dd>
      </dl>
      @endif
      @endforeach
      </div>
     
      
    </div>
  </div>
  <!-------左边结束-------> 
  <!------招聘广告位----->
  <div class="right cat4_sidebar mob_hide m_foot mt30" style="background:#fff;">
  <div class="job_about">
  <div class="job_title"><h3>企业信息</h3></div>
  <div class="info">
  @foreach ($companyde as $k => $list)
  @if ($loop->first)
  <div class="info_logo"><img src="/uploads/{{$list->company_logo}}" alt="{{$list->company_name}}" /><h2>{{$list->company_name}}</h2></div>
  <div class="info_xxx">
  <li class="job_industry">行业：{{$list->category}}  </li>
  <li class="job_email">邮箱：<a href="javascript:void(0);">{{$list->email}}</a></li>
  <li class="job_web">网站：<a href="{{$list->web_site}}" target="_blank">{{$list->web_site}}</a></li>
  <li class="job_tele">电话：{{$list->tel}} 转人事部</li>
  <li class="job_address">地址：{{$list->addr}}</li>
  <li class="job_welfare">福利待遇：{!!$list->welfare!!}</li><br>
  <li class="job_company" >企业介绍：{!!$list->brief!!}</li>
  @endif
  @endforeach
  </div>
  </div>
  </div>
    <div class="job_ab mt30" style="background:#fff;">
      <div class="job_title">
        <h3>相似工作</h3>
      </div>
      <ul>
      	@foreach ($company_all_n as $key => $list)
        <li><img src="/uploads/{{$list[0]['company_logo']}}" alt="{{$list[0]['company_name']}}" />
          <div class="job_ab_info">
            <div class="title">正在热招:</div>
            @foreach ($list as $k)
            <div class="main_li"><a target="_blank" title="{{$k['job_name']}}" href="/job/detail/{{$k['id']}}">{{$k['job_name']}}</a></div>
            @endforeach
            <div style="display:block;float:right;position:absolute;bottom:10px;right:30px" class="whole"><a target="_blank" href="/job/detail/{{$list[0]['id']}}">查看全部</a></div>
          </div>
        </li>
        @endforeach

      </ul>
    </div>
    <!------招聘广告位end-----> 
  </div>
</section>

<script>
    function getSwiperImgs(imgs){
        var imgArr = imgs || [];
        var h ='';
        imgArr.map(function(img){
            h += '<div class="swiper-slide">';
            h += ' <img src="'+ img.src +'" alt="">';
			h += ' <div class="project-item-title">'+img.title+'</div>';
			h += ' <div class="project-item-name">'+img.title+'</div>';
            h += '</div>';
        })
        $('#projects .swiper-wrapper').html(h);
        if(imgs.length > 0 ){
            var mySwiper = new Swiper('.swiper-containe',{
            	StopOnlLastSide:true,//可选选项，自动滑动
                autoplay:3000,
                pagination : '.swiper-pagination',
                loop: true,
                autoplayDisableOnInteraction:false,
                paginationClickable :true,
                speed:2000,

            })
        }

        return mySwiper;
    }


var mySwiper = new Swiper(".swiper-container", {
	    observer: true, //解决数据传入后轮播问题
	    observerParents: true,
	    autoResize: true, //尺寸自适应
	    initialSlide: 0,
	    direction: "horizontal",
	    /*横向滑动*/
	    loop: true,
	    /*形成环路（即：可以从最后一张图跳转到第一张图*/
	    slidesPerView: 'auto',
	    loopedSlides: 0,
	    pagination: ".swiper-pagination",
	    /*分页器*/
	    paginationClickable: true,
	    autoplay: 3000,
	    /*每隔3秒自动播放*/
	    autoplayDisableOnInteraction: false /*点击之后是否停止自动轮播*/
})



</script>

@endsection