<?php $__env->startSection('title'); ?>
    <?php echo e(trans('comm.yinji')); ?> --招聘信息详情
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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

  @media  only screen and (max-width: 768px){
    .swiper-slide .detail{
      height:40px;
    }
  }

</style>
<section><img src="/images/job_02.jpg"  alt="工作" /></section>
<section class="wrapper">
  <div class="left cat-wrap m_foot mt30"> 
    <!--招聘信息详情-->
    <div class="projects swiper-container" style="position:relative" id="projects">
        <div class="swiper-wrapper">
		<?php $__currentLoopData = $jobproject; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<div class="swiper-slide">
				<div class="l-t-title">
				<p>公司项目 Projects</p >
			</div>
				<img onclick="location='<?php echo e($list['link_url']); ?>'" class="img-responsive" src="/uploads/<?php echo e($list['project_photo']); ?>" title="<?php echo e($list['project_name']); ?>" name="<?php echo e($list['project_name']); ?>" />
  
				<p class="detail" >
					<span><?php echo e($list['project_name']); ?></span>	
				</p>
			</div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        
        
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
         <?php $__currentLoopData = $companyde; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li>
            <div class="position">O <?php echo e($detail['job_name']); ?></div>
            <div class="place">工作地点：<?php echo e($detail['addr']); ?></div>
            <div class="position_content">
              <dl>
                <dt> 职位内容：</dt>
                <dd>
                <?php echo $detail['content']; ?>

                </dd>
              </dl>
            </div>
            <div class="position_content">
              <dl>
                <dt>任职要求：</dt>
               <dd>
                <?php echo $detail['skills']; ?>

                  </dd>
              </dl>
            </div>
          </li>
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          
        </ul>
      </div>
      
      <div class="apply_job">
       <dl>
       	<?php $__currentLoopData = $companyde; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($loop->first): ?>
      <dt>申请方式</dt>
       <dd>
       <p>申请人请将PDF格式的作品集及简历发到 <a href="javascript:void(0);"> <?php echo e($list->email); ?> </a>，并在标题处注明应聘职位。</p>
       <p>电话：<?php echo e($list->tel); ?>转人事部</p>
       <p>官网：<a href="<?php echo e($list->web_site); ?>" target="_blank"><?php echo e($list->web_site); ?></a></p>
       <p>地址：<?php echo e($list->addr); ?></p>
      </dd>
      </dl>
      <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
     
      
    </div>
  </div>
  <!-------左边结束-------> 
  <!------招聘广告位----->
  <div class="right cat4_sidebar mob_hide m_foot mt30" style="background:#fff;">
  <div class="job_about">
  <div class="job_title"><h3>企业信息</h3></div>
  <div class="info">
  <?php $__currentLoopData = $companyde; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php if($loop->first): ?>
  <div class="info_logo"><img src="/uploads/<?php echo e($list->company_logo); ?>" alt="<?php echo e($list->company_name); ?>" /><h2><?php echo e($list->company_name); ?></h2></div>
  <div class="info_xxx">
  <li class="job_industry">行业：<?php echo e($list->category); ?>  </li>
  <li class="job_email">邮箱：<a href="javascript:void(0);"><?php echo e($list->email); ?></a></li>
  <li class="job_web">网站：<a href="<?php echo e($list->web_site); ?>" target="_blank"><?php echo e($list->web_site); ?></a></li>
  <li class="job_tele">电话：<?php echo e($list->tel); ?> 转人事部</li>
  <li class="job_address">地址：<?php echo e($list->addr); ?></li>
  <li class="job_welfare">福利待遇：<?php echo $list->welfare; ?></li><br>
  <li class="job_company" >企业介绍：<?php echo $list->brief; ?></li>
  <?php endif; ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
  </div>
  </div>
    <div class="job_ab mt30" style="background:#fff;">
      <div class="job_title">
        <h3>相似工作</h3>
      </div>
      <ul>
      	<?php $__currentLoopData = $company_all_n; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><img src="/uploads/<?php echo e($list[0]['company_logo']); ?>" alt="<?php echo e($list[0]['company_name']); ?>" />
          <div class="job_ab_info">
            <div class="title">正在热招:</div>
            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="main_li"><a target="_blank" title="<?php echo e($k['job_name']); ?>" href="/job/detail/<?php echo e($k['id']); ?>"><?php echo e($k['job_name']); ?></a></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div style="display:block;float:right;position:absolute;bottom:10px;right:30px" class="whole"><a target="_blank" href="/job/detail/<?php echo e($list[0]['id']); ?>">查看全部</a></div>
          </div>
        </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

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

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>