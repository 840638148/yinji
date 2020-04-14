<?php $__env->startSection('title'); ?>

    <?php echo e(trans('comm.yinji')); ?> - 招聘

<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>

<section><img src="/images/job_02.jpg"  alt="工作" /></section>
<style>
.searchtype-lists{
  position: absolute;
  width: calc( 100% - 0.5px);
  background: #fff;
  box-shadow: 0 4px 20px rgba(0,0,0,.2);
  z-index: 100;
}
.job_ab li .job_ab_info{
  display:none;
}
.job_ab li:hover .job_ab_info{
  display:block;
}
.tj-cont-seach .search {
    width: 20%;
    height: 42px;
    border: 0;
    background: #636af3;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
}
</style>
<section class="wrapper">

  <div class="left cat-wrap  m_foot"> 

    <!----搜索--->

    <div class="job_seach_box mt30">

      <div class="tj-cont-seach">

        <div class="seach-block1">

          <form action="/job/searchjob" method="get">

            <div class="menu" id="searchtype">

            <h2 class="searchtype-content">
                <font class="searchtype-content-text">
                    职位
                </font><span></span>
                <ul class="searchtype-lists" style="display:none">
                    <li class="searchtype-list"  id="position" value="1" >职位</li>
                    <li class="searchtype-list"  id="company" value="2" >公司</li>
                    
                </ul>
                 
              </h2>  
              <!--隐藏框可获取ul-li的文本-->
			              <input class="text" name="jobcategory" id="jobcategory" type="hidden" value="1">
             
              <input class="text" id="txt_keyword" name="keywords" type="text" placeholder="请输入职位或公司名称" value="" >

            </div>
            
			
            <input class="search" type="submit" id="btn_search" value="搜索" >

            <div class="clear"></div>

          </form>

        </div>

      </div>

      <div class="tj-cont-hotseach"> 

        	<!--热门搜索--> 
	        热门搜索： 
	        <?php $__currentLoopData = $hotword; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	        <a href="/job/searchjob?jobcategory=1&keywords=<?php echo e($list['content']); ?>" ><?php echo e($list['content']); ?></a> 
	        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </div>

    </div>

    <!----搜索结束---> 

    <!------招聘信息------>

    <div class="job_recommend mt30">

      <div class="left_title"><h2>招聘职位</h2></div>

      <div class="jobs-list">
		<?php $__currentLoopData = $joblist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <article>

          <div class="post-box">

              <h2 class="entry-title">
                <a href="/job/detail/<?php echo e($list->id); ?>"><?php echo e($list->job_name); ?></a>
                <?php if($list->new==1): ?>
                <span class="ico_new"><img src="images/new.gif" alt="最新" /></span>
                <?php endif; ?>
                <?php if($list->hot==1): ?>
                <span class="ico_new"><img src="images/ico_hot.gif" alt="热门招聘" /></span>
                <?php endif; ?>
                <?php if($list->fast==1): ?>
                <span class="ico_new"><img src="images/ji_05.gif" alt="急聘" /></span>
                <?php endif; ?>
              </h2>

              <p><a href="/job/detail/<?php echo e($list->id); ?>" target="_blank"><?php echo e($list->company_name); ?></a></p>
 
            </div>

        </article>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<!--        <article>

          <div class="post-box">

              <h2 class="entry-title"><a href="/job/detail/1" target="_blank">（香港/深圳）PH Alpha Design 英国湃昂国际建筑设计顾问有限公司 </a><span class="ico_new"><img src="images/new.gif" alt="最新" /></span><span class="ico_new"><img src="images/ico_hot.gif" alt="热门招聘" /></span><span class="ico_new"><img src="images/ji_05.gif" alt="急聘" /></span></h2>

              <p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>

            </div>

        </article>

        <article class="post-job">

            <div class="post-box">

              <h2 class="entry-title"><a href="/job/detail/1" target="_blank">（深圳）JS Architects 张健蘅整合建筑事务所</a><span class="ico_new"><img src="images/ji_05.gif" alt="急聘" /></span></h2>

               <p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>

               </div>

        </article>

        <article class="post-job">

            <div class="post-box">

              <h2 class="entry-title"><a href="/job-tianandann.htm" target="_blank">（上海）TIANANDANN力呈建筑设计咨询有限</a><span class="ico_new"><img src="images/ico_hot.gif" alt="热门招聘" /></span></h2>

               <p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>

            </div>

        </article>

        <article class="post-job">

            <div class="post-box">

              <h2 class="entry-title"><a href="/job-atelier-alter.htm" target="_blank">（北京）时境建筑 Atelier Alter</a><span class="ico_new"><img src="images/new.gif" alt="最新" /></span></h2> 

               <p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>

          </div>

        </article>

         <article>

          <div class="post-box">

              <h2 class="entry-title"><a href="/job-ph-alpha-design.htm" target="_blank">（香港/深圳）PH Alpha Design 英国湃昂国际建筑设计顾问有限公司 </a><span class="ico_new"><img src="images/new.gif" alt="最新" /></span><span class="ico_new"><img src="images/ico_hot.gif" alt="热门招聘" /></span><span class="ico_new"><img src="images/ji_05.gif" alt="急聘" /></span></h2>

              <p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>

            </div>

        </article>

        <article class="post-job">

            <div class="post-box">

              <h2 class="entry-title"><a href="/job-js-architects.htm" target="_blank">（深圳）JS Architects 张健蘅整合建筑事务所</a><span class="ico_new"><img src="images/ji_05.gif" alt="急聘" /></span></h2>

               <p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>

               </div>

        </article>

        <article class="post-job">

            <div class="post-box">

              <h2 class="entry-title"><a href="/job-tianandann.htm" target="_blank">（上海）TIANANDANN力呈建筑设计咨询有限</a><span class="ico_new"><img src="images/ico_hot.gif" alt="热门招聘" /></span></h2>

               <p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>

            </div>

        </article>

        <article class="post-job">

            <div class="post-box">

              <h2 class="entry-title"><a href="/job-atelier-alter.htm" target="_blank">（北京）时境建筑 Atelier Alter</a><span class="ico_new"><img src="images/new.gif" alt="最新" /></span></h2> 

               <p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>

          </div>

        </article>

         <article>

          <div class="post-box">

              <h2 class="entry-title"><a href="/job-ph-alpha-design.htm" target="_blank">（香港/深圳）PH Alpha Design 英国湃昂国际建筑设计顾问有限公司 </a><span class="ico_new"><img src="images/new.gif" alt="最新" /></span><span class="ico_new"><img src="images/ico_hot.gif" alt="热门招聘" /></span><span class="ico_new"><img src="images/ji_05.gif" alt="急聘" /></span></h2>

              <p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>

            </div>

        </article><article class="post-job">

            <div class="post-box">

              <h2 class="entry-title"><a href="/job-js-architects.htm" target="_blank">（深圳）JS Architects 张健蘅整合建筑事务所</a><span class="ico_new"><img src="images/ji_05.gif" alt="急聘" /></span></h2>

               <p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>

                     </div>

        </article>

        <article class="post-job">

            <div class="post-box">

              <h2 class="entry-title"><a href="/job-tianandann.htm" target="_blank">（上海）TIANANDANN力呈建筑设计咨询有限</a><span class="ico_new"><img src="images/ico_hot.gif" alt="热门招聘" /></span></h2>

               <p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>

            </div>

        </article>

        <article class="post-job">

            <div class="post-box">

              <h2 class="entry-title"><a href="/job-atelier-alter.htm" target="_blank">（北京）时境建筑 Atelier Alter</a><span class="ico_new"><img src="images/new.gif" alt="最新" /></span></h2> 

               <p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>

          </div>

        </article>

        <article class="post-job">

            <div class="post-box">

              <h2 class="entry-title"><a href="/job-js-architects.htm" target="_blank">（深圳）JS Architects 张健蘅整合建筑事务所</a></h2>

               <p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>

                     </div>

        </article>

        <article class="post-job">

            <div class="post-box">

              <h2 class="entry-title"><a href="/job-tianandann.htm" target="_blank">（上海）TIANANDANN力呈建筑设计咨询有限</a></h2>

               <p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>

            </div>

        </article>

        <article class="post-job">

            <div class="post-box">

              <h2 class="entry-title"><a href="/job-atelier-alter.htm" target="_blank">（北京）时境建筑 Atelier Alter</a><span class="ico_new"></span></h2> 

               <p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>

          </div>

        </article>

        <article class="post-job">

            <div class="post-box">

              <h2 class="entry-title"><a href="/job-tianandann.htm" target="_blank">（上海）TIANANDANN力呈建筑设计咨询有限</a></h2>

               <p><a href="#">主任建筑设计师</a> / <a href="#">高级建筑设计师 </a> / <a href="#">建筑设计师</a> / <a href="#"> 助理建筑设计师</a> / <a href="#">高级室内设计师</a> / <a href="#">室内设计师</a> / <a href="#">助理室内设计师</a> / <a href="#"> 平面设计 </a> / <a href="#">实习生</a></p>

            </div>

        </article>-->

  </div>

  <!---翻页---->
	<style>
		.pagination {
			clear: both;
		    /*width: 18%;*/
		    float: right;
		}
	</style>
  <!--<div class="fanye"><span class="disabled"> 首页 </span><span class="disabled"> 上一页 </span><span class="current">1</span><a href="#?page=2">2</a><a href="#?page=3">3</a><a href="#?page=4">4</a><a href="#?page=5">5</a><a href="#?page=6">6</a><a href="#?page=7">7</a>...<a href="#?page=199">199</a><a href="#?page=200">200</a><a href="#?page=2"> 下一页 </a><a href="#?page=2"> 末页</a>  </div>       -->
	<?php echo e($joblist); ?>

  <!---翻页结束---->

  </div>

  </div>

  <!-------左边结束------->

  <!------招聘广告位----->

  <div class="right cat4_sidebar mob_ m_foot mt30" style="background:#fff;">

    <div class="job_ab">

      <ul>
		<?php $__currentLoopData = $company_all_n; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>       <!-- 获取companies表的数据  -->
			
        <li><img src="/uploads/<?php echo e($list[0]['company_logo']); ?>" alt="<?php echo e($list[0]['company_name']); ?>" />
        	
          <!--<h2></h2>-->
          <div class="job_ab_info">
            <div class="title">正在热招:</div>
            <?php if(count($list)<7): ?>
            <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="main_li"><a target="_blank" title="<?php echo e($k['job_name']); ?>" href="/job/detail/<?php echo e($k['id']); ?>"><?php echo e($k['job_name']); ?></a></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div style="display:block;float:right;position:absolute;bottom:10px;right:30px" class="whole"><a target="_blank" href="/job/detail/<?php echo e($list[0]['id']); ?>">查看全部</a></div>
            <?php endif; ?>
          </div>
          
        </li>
        
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<!--        <li><img src="images/job_ab1.jpg" alt="绿地地产" />

          <h2>绿地地产</h2>

          <div class="job_ab_info">

            <div class="title">正在热招:</div>

            <div class="main_li"><a target="_blank" title="运营主管" href="/zhaopin/260101.html">运营主管</a></div>

            <div class="main_li"><a target="_blank" title="装饰工程师" href="/zhaopin/1008851.html">装饰工程师</a></div>

            <div class="main_li"><a target="_blank" title="项目总经理" href="/zhaopin/1028099.html">项目总经理</a></div>

            <div class="main_li"><a target="_blank" title="项目经理" href="/zhaopin/1007667.html">项目经理</a></div>

            <div class="whole"><a target="_blank" href="/company/989600.html">查看全部</a></div>

          </div>

        </li>

        <li><img src="images/job_ab2.jpg" alt="绿地地产" />

          <h2>绿地地产</h2>

          <div class="job_ab_info ">

            <div class="title">正在热招:</div>

            <div class="main_li"><a target="_blank" title="运营主管" href="/zhaopin/260101.html">运营主管</a></div>

            <div class="main_li"><a target="_blank" title="装饰工程师" href="/zhaopin/1008851.html">装饰工程师</a></div>

            <div class="main_li"><a target="_blank" title="项目总经理" href="/zhaopin/1028099.html">项目总经理</a></div>

            <div class="main_li"><a target="_blank" title="项目经理" href="/zhaopin/1007667.html">项目经理</a></div>

            <div class="whole"><a target="_blank" href="/company/989600.html">查看全部</a></div>

          </div>

        </li>

        <li><img src="images/job_ab3.png" alt="绿地地产" />

          <h2>绿地地产</h2>

          <div class="job_ab_info ">

            <div class="title">正在热招:</div>

            <div class="main_li"><a target="_blank" title="运营主管" href="/zhaopin/260101.html">运营主管</a></div>

            <div class="main_li"><a target="_blank" title="装饰工程师" href="/zhaopin/1008851.html">装饰工程师</a></div>

            <div class="main_li"><a target="_blank" title="项目总经理" href="/zhaopin/1028099.html">项目总经理</a></div>

            <div class="main_li"><a target="_blank" title="项目经理" href="/zhaopin/1007667.html">项目经理</a></div>

            <div class="whole"><a target="_blank" href="/company/989600.html">查看全部</a></div>

          </div>

        </li>

        <li><img src="images/job_ab4.png" alt="绿地地产" />

          <h2>绿地地产</h2>

          <div class="job_ab_info ">

            <div class="title">正在热招:</div>

            <div class="main_li"><a target="_blank" title="运营主管" href="/zhaopin/260101.html">运营主管</a></div>

            <div class="main_li"><a target="_blank" title="装饰工程师" href="/zhaopin/1008851.html">装饰工程师</a></div>

            <div class="main_li"><a target="_blank" title="项目总经理" href="/zhaopin/1028099.html">项目总经理</a></div>

            <div class="main_li"><a target="_blank" title="项目经理" href="/zhaopin/1007667.html">项目经理</a></div>

            <div class="whole"><a target="_blank" href="/company/989600.html">查看全部</a></div>

          </div>

        </li>

         <li><img src="images/job_ab1.jpg" alt="绿地地产" />

          <h2>绿地地产</h2>

          <div class="job_ab_info ">

            <div class="title">正在热招:</div>

            <div class="main_li"><a target="_blank" title="运营主管" href="/zhaopin/260101.html">运营主管</a></div>

            <div class="main_li"><a target="_blank" title="装饰工程师" href="/zhaopin/1008851.html">装饰工程师</a></div>

            <div class="main_li"><a target="_blank" title="项目总经理" href="/zhaopin/1028099.html">项目总经理</a></div>

            <div class="main_li"><a target="_blank" title="项目经理" href="/zhaopin/1007667.html">项目经理</a></div>

            <div class="whole"><a target="_blank" href="/company/989600.html">查看全部</a></div>

          </div>

        </li>

        <li><img src="images/job_ab2.jpg" alt="绿地地产" />

          <h2>绿地地产</h2>

          <div class="job_ab_info ">

            <div class="title">正在热招:</div>

            <div class="main_li"><a target="_blank" title="运营主管" href="/zhaopin/260101.html">运营主管</a></div>

            <div class="main_li"><a target="_blank" title="装饰工程师" href="/zhaopin/1008851.html">装饰工程师</a></div>

            <div class="main_li"><a target="_blank" title="项目总经理" href="/zhaopin/1028099.html">项目总经理</a></div>

            <div class="main_li"><a target="_blank" title="项目经理" href="/zhaopin/1007667.html">项目经理</a></div>

            <div class="whole"><a target="_blank" href="/company/989600.html">查看全部</a></div>

          </div>

        </li>

        <li><img src="images/job_ab3.png" alt="绿地地产" />

          <h2>绿地地产</h2>

          <div class="job_ab_info ">

            <div class="title">正在热招:</div>

            <div class="main_li"><a target="_blank" title="运营主管" href="/zhaopin/260101.html">运营主管</a></div>

            <div class="main_li"><a target="_blank" title="装饰工程师" href="/zhaopin/1008851.html">装饰工程师</a></div>

            <div class="main_li"><a target="_blank" title="项目总经理" href="/zhaopin/1028099.html">项目总经理</a></div>

            <div class="main_li"><a target="_blank" title="项目经理" href="/zhaopin/1007667.html">项目经理</a></div>

            <div class="whole"><a target="_blank" href="/company/989600.html">查看全部</a></div>

          </div>

        </li>

        <li><img src="images/job_ab4.png" alt="绿地地产" />

          <h2>绿地地产</h2>

          <div class="job_ab_info ">

            <div class="title">正在热招:</div>

            <div class="main_li"><a target="_blank" title="运营主管" href="/zhaopin/260101.html">运营主管</a></div>

            <div class="main_li"><a target="_blank" title="装饰工程师" href="/zhaopin/1008851.html">装饰工程师</a></div>

            <div class="main_li"><a target="_blank" title="项目总经理" href="/zhaopin/1028099.html">项目总经理</a></div>

            <div class="main_li"><a target="_blank" title="项目经理" href="/zhaopin/1007667.html">项目经理</a></div>

            <div class="whole"><a target="_blank" href="/company/989600.html">查看全部</a></div>

          </div>

        </li>-->

      </ul>

    </div>

    <!------招聘广告位end-----> 

  </div>

</section>
<script>
  $(document).on('click','.searchtype-list',function(){
      var text  = $(this).text();
      $('.searchtype-content-text').text(text);
      $('.searchtype-lists').hide();
      var jobcate=$(this).val();
      var qwe=$('#jobcategory').val(jobcate);
      
      // console.log(qwe);
      // $('.searchtype-list').val=$('[name="jobcategory"]').val;
  })
  $(document).on('mouseenter','h2.searchtype-content',function(){
      
      $('.searchtype-lists').show();
  })
  $(document).on('mouseleave','h2.searchtype-content',function(){
      
      $('.searchtype-lists').hide();
  })

</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>