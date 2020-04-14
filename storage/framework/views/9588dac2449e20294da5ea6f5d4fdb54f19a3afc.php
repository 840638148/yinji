<?php $__env->startSection('title'); ?>

<?php echo e(trans('comm.yinji')); ?> - <?php echo e(trans('comm.second_title')); ?>


<?php $__env->stopSection(); ?>





<?php $__env->startSection('seo_verification'); ?>

<?php echo e(trans('comm.seo_verification')); ?>


<?php $__env->stopSection(); ?>



<?php $__env->startSection('seo_description'); ?>

<?php echo e(trans('comm.seo_description')); ?>


<?php $__env->stopSection(); ?>



<?php $__env->startSection('seo_keywords'); ?>

<?php echo e(trans('comm.seo_keywords')); ?>


<?php $__env->stopSection(); ?>





<?php $__env->startSection('content'); ?> 

<!------滚动海报-------->

<section class="slides-sticky  wow bounceInUp animated" style="visibility: visible; animation-name: bounceInUp;">
  <section class="slide-main slide-home">
    <div class="swiper-container swiper-home swiper-container-horizontal">
      <div class="swiper-wrapper"

                     style="transform: translate3d(-7876px, 0px, 0px); transition-duration: 0ms;"> <?php $__currentLoopData = $bannar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ban_item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <article class="swiper-slide slide-single" data-swiper-slide-index="<?php echo e($loop->iteration); ?>"

                                 style="width: 1145.6px;"> <a href="<?php echo e($ban_item->ad_url); ?>" class="swiper-image"

                               style="background-image: url(<?php echo e(url('uploads/' . $ban_item->ad_img)); ?>);"></a> </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </div>
      
      <!-- 导航 -->
      
      <div class="swiper-pagination swiper-home-pagination swiper-pagination-bullets"> <span class="swiper-pagination-bullet swiper-pagination-bullet-active"></span> <span class="swiper-pagination-bullet"></span> <span class="swiper-pagination-bullet"></span> </div>
      
      <!-- 按钮 -->
      
      <div class="swiper-button swiper-home-button-next swiper-button-next icon-angle-right"></div>
      <div class="swiper-button swiper-home-button-prev swiper-button-prev icon-angle-left"></div>
    </div>
    <script type="text/javascript">





                $("#lang-switch").click(function () {



                    var lang = $



                    $.ajax({



                        url: '/lang/switch',



                        type: 'POST',



                        dataType: 'json',



                        data: {lang: ''},



                        success: function () {



                            location.reload();



                        }



                    });



                });





                //首页幻灯片



                var $page_main_body = $('.slide-home');



                var $button_next = $page_main_body.find('.swiper-home-button-next');



                var $button_prev = $page_main_body.find('.swiper-home-button-prev');



                var len = $('.slide-home').find('.swiper-slide').length;



                var bannerSwiper = new Swiper('.swiper-home', {





                    pagination: '.swiper-home-pagination',





                    nextButton: '.swiper-home-button-next',





                    prevButton: '.swiper-home-button-prev',





                    autoplay: 2000,



                    autoplayDisableOnInteraction: false,



                    loop: true,



                    loopedSlides: len,



                    centeredSlides: true,



                    slidesPerView: 1.25,



                    on: {



                        init: function () {



                            var width = parseInt($page_main_body.width());



                            if ($index_pc_bt.size() > 0) {



                                $index_pc_bt.css('width', (width - this.slidesSizesGrid['0']) / 2 + 'px');



                            }



                        }



                    },



                    onInit: function (swiper) {



                        swiper.slides[2].className = "swiper-slide swiper-slide-active";//第一次打开不要动画



                    },



                    breakpoints: {



                        668: {



                            slidesPerView: 1



                        }



                    },



                    lazy: {



                        loadPrevNext: true,



                    }





                });





            </script> 
  </section>
</section>
<?php if(isset($ads_2)): ?> 

<!---广告位---->

<section class="wrapper">
  <div class="top_ad box mt20">
    <ul>
      <?php $__currentLoopData = $ads_2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      
      
      
      <?php if($loop->last): ?> <a href="<?php echo e($ad->ad_url); ?>">
      <li class="right"><img src="<?php echo e(url('uploads/' . $ad->ad_img)); ?>"

                                                       title="<?php echo e($ad->ad_title); ?>"/></li>
      </a> <?php else: ?> <a href="<?php echo e($ad->ad_url); ?>">
      <li class="mr20 left"><img src="<?php echo e(url('uploads/' . $ad->ad_img)); ?>"

                                                           title="<?php echo e($ad->ad_title); ?>"/></li>
      </a> <?php endif; ?>
      
      
      
      
      
      
      
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
  </div>
</section>

<!---广告位end----> 

<?php endif; ?>
<section class="new wrapper scroll4 box" style="position: relative;">
  <section class="cat-wrap left">
    <section class=" triangle wow bounceInUp animated" style="visibility: visible; animation-name: bounceInUp;"> 
      
      <!--标题-->
      
      <section class="home_title">
        <h3 class="left"><i class="ico_title_news"></i><?php echo e(trans('index.latest_article')); ?></h3>
      </section>
      
      <!--标题end-->
      
      <section class="new_list">
        <ul class="layout_ul ajaxposts">
          <?php $__currentLoopData = $new_articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li class="layout_li ajaxpost wow bounceInUp animated" style="visibility: visible; animation-name: bounceInUp;">
            <article class="post_main">
            <div class="index_dafen"><?php echo e($article->starsavg =='0.0' ? '5.0' : $article->starsavg); ?></div>
              <figure> <a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>"

                                               title="<?php echo e(get_article_title($article)); ?>" target="_blank"> <img

                                                    class="thumb" src="<?php echo e(get_article_thum($article)); ?>"

                                                    data-original="<?php echo e(get_article_thum($article)); ?>"

                                                    alt="<?php echo e(get_article_title($article)); ?>" style="display: block;"> </a> </figure>
              <h2> <a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>"
                                           title="<?php echo e(get_article_title($article)); ?>"
                                           target="_blank">
                <p><?php echo e(get_article_title($article, 1)); ?></p>
                <p><?php echo e(get_article_title($article, 2)); ?></p>
                </a> </h2>
              <div class="postinfo">
                <div class="left"> <span class="index-category"> <?php if($article->category): ?>
                  <?php $__currentLoopData = $article->category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <a href="/article/category/<?php echo e($category['id']); ?>"

                                                   rel="category tag"><?php echo e($category['name']); ?></a> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  <?php endif; ?> </span> </div>
                <div class="excerpt"><?php echo get_article_description($article); ?></div>
                <div class="right index_new">
                  <ul>
                    <li><span class="view"><i class="icon-eye"></i><?php echo e($article->view_num); ?></span></li>
                    <!--li><span class="comment"><i class="icon-bookmark"></i><a  href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>"><?php echo e($article->favorite_num); ?></a></span> </li>
                    <li><span class="like"><i class="icon-thumbs-up"></i><span class="count"><?php echo e($article->like_num); ?></span></span></li-->
                    <li><span><i class="icon-clock"></i> <?php echo e($article->month); ?> <?php echo e($article->day); ?>日</span></li>
                  </ul>
                </div>
                 
              </div>
            </article>
          </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </section>
    </section>
  </section>
  
  <!--边栏-->
  
  <aside class="sidebar right">
    <div style="position: relative; top: 0px; height: 0px;"></div>
    <section class="cat4_sidebar" style="width: 288px;">
      <article id="slongposts-4" class="sidebar_widget widget_salong_posts wow bounceInUp triangle animated"

                         style="visibility: visible; animation-name: bounceInUp;">
        <div class="sidebar_title">
          <h3><?php echo e(trans('index.hot_article')); ?></h3>
        </div>
        <ul class="">
          <?php $__currentLoopData = $hot_articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li>
            <article class="postlist">
              <figure> <a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>"

                                           title="<?php echo e(get_article_title($article)); ?>&nbsp;" target="_blank"> <img class="thumb" src="<?php echo e(get_article_thum($article)); ?>"

                                                 data-original="<?php echo e(get_article_thum($article)); ?>"

                                                 alt="<?php echo e(get_article_title($article)); ?>" style="display: block;"> </a> </figure>
              <h3><a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>"

                                           title="<?php echo e(get_article_title($article, 2)); ?>&nbsp;"

                                           target="_blank"><?php echo e(get_article_title($article, 2)); ?></a></h3>
              <div class="homeinfo"> <?php if($article->category): ?>
                
                
                
                <?php $__currentLoopData = $article->category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <a href="/article/category/<?php echo e($category['id']); ?>"

                                                   rel="category tag"><?php echo e($category['name']); ?></a> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                
                
                <?php endif; ?> <span class="date"><?php echo e(str_limit($article->release_time, 10, '')); ?></span> <span class="comment"><i class="icon-eye"></i><a

                                                    href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>"><?php echo e($article->view_num); ?></a></span> </div>
            </article>
          </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </article>
      <article id="text-3" class="sidebar_widget box widget_text wow bounceInUp triangle animated"

                         style="visibility: visible; animation-name: bounceInUp;"> <?php if(isset($ads_right)): ?>
        <div class="textwidget">
          <p><!-- 右侧广告代码 开始 --></p>
          <div id="playBox">
            <div class="pre"></div>
            <div class="next"></div>
            <div class="smalltitle">
              <ul>
                <li class="thistitle"></li>
                <li></li>
                <li></li>
                <li></li>
              </ul>
            </div>
            <ul class="oUlplay">
              <?php $__currentLoopData = $ads_right; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $right): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <li><a href="<?php echo e($right->ad_url); ?>" target="_blank" rel="noopener"><img

                                                        src="<?php echo e(url('uploads/' . $right->ad_img)); ?>"></a></li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </div>
          <p><!-- 右侧广告代码 结束 --></p>
        </div>
        <?php endif; ?> </article>
    </section>
  </aside>
  
  <!--边栏end-->
  
  <div class="sf4"></div>
</section>

<!---设计师---->

<section class="design_box box" >
  <div class="wrapper">
    <div class="left design_left">
      <section class="home_title mt30">
        <h3 class="left"><i class="ico_title_design"></i><?php echo e(trans('index.master_designer')); ?></h3>
      </section>
      <ul>
        <?php $__currentLoopData = $master_designers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $master): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li> <a href="<?php echo e($master->ad_url); ?>"> <img src="<?php echo e(url('uploads/' . $master->ad_img)); ?>" title="<?php echo e($master->ad_title); ?>"/> </a> </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
    <div class="design_right right">
      <section class="design_right_title mt30">
        <h2><?php echo e(trans('index.noted_designer')); ?></h2>
      </section>
      <ul>
        <?php $__currentLoopData = $noted_designers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $noted): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
        
        
        <?php if($loop->iteration % 2): ?>
        <li class="left"> <a class="ad-link" href="<?php echo e($noted->ad_url); ?>"> <img src="<?php echo e(url('uploads/' . $noted->ad_img)); ?>" title="<?php echo e($noted->ad_title); ?>"/> </a> </li>
        <?php else: ?>
        <li class="right"> <a href="<?php echo e($noted->ad_url); ?>"> <img src="<?php echo e(url('uploads/' . $noted->ad_img)); ?>" title="<?php echo e($noted->ad_title); ?>"/> </a> </li>
        <?php endif; ?>
        
        
        
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
      <a href="/designer" class="design_right_more"><?php echo e(trans('index.more_noted_designer')); ?></a></div>
  </div>
</section>

<!---设计师end----> 

<!---猜你喜欢---->

<section class="wrapper">
  <div class="cat-wrap box left">
    <section class="home_title mt30">
      <h3 class="left"><i class="ico_title_like"></i><?php echo e(trans('index.lovely')); ?></h3>
    </section>
    <article class="like">
      <ul>
        <?php $__currentLoopData = $lovely; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
        
        
        <?php if($loop->first): ?>
        <div class="left like_title">
          <ul>
            <article>
              <figure> <a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>"

                                               title="<?php echo e(get_article_title($article)); ?>" target="_blank"> <img class="thumb"

                                                     src="<?php echo e(get_article_thum($article)); ?>"

                                                     style="display: block;"> </a> </figure>
              <h2><a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>"

                                               title="<?php echo e(get_article_title($article)); ?>" target="_blank"> <?php echo e(get_article_title($article)); ?></a></h2>
              <div class="postinfo"> 
                
                <!-- 摘要 -->
                
                <div class="mb10"> &nbsp; &nbsp; &nbsp;
                  
                  <?php echo e(get_article_description($article)); ?> </div>
                
                <!-- 摘要end -->
                
                <div class="left"> 
                  
                  <!--分类--> 
                  
                  <span> <?php if($article->category): ?>
                  
                  <?php $__currentLoopData = $article->category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <a href="/article/category/<?php echo e($category['id']); ?>"

                                                               rel="category tag"><?php echo e($category['name']); ?></a> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  
                  <?php endif; ?> </span> <span><?php echo e(str_limit($article->release_time, 10, '')); ?></span> </div>
                <div class="right"> <span title="浏览人数" class="like"><i class="icon-eye"></i><?php echo e($article->view_num); ?></span> </div>
              </div>
            </article>
          </ul>
        </div>
        <?php elseif($loop->iteration%2): ?>
        <li class="right">
          <article class="postlist">
            <figure><a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>"

                                               title="<?php echo e(get_article_title($article)); ?>" target="_blank"> <img

                                                    class="thumb" src="<?php echo e(get_article_thum($article)); ?>"

                                                    data-original="<?php echo e(get_article_thum($article)); ?>"

                                                    alt="<?php echo e(get_article_title($article)); ?>" style="display: block;"> </a> </figure>
            <h3><a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>"

                                           title="<?php echo e(get_article_title($article)); ?>"

                                           target="_blank"><?php echo e(get_article_title($article)); ?></a></h3>
            <div class="homeinfo"> 
              
              <!--分类--> 
              
              <span class="category"> <?php if($article->category): ?>
              
              
              
              <?php $__currentLoopData = $article->category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <a href="/article/category/<?php echo e($category['id']); ?>"

                                                       rel="category tag"><?php echo e($category['name']); ?></a> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              
              
              
              <?php endif; ?> </span> 
              
              <!--时间--> 
              
              <span class="date"><?php echo e(str_limit($article->release_time, 10, '')); ?></span> 
              
              <!--点赞--> 
              
              <span title="浏览人数" class="like"><i class="icon-eye"></i><span

                                                    class="count"><?php echo e($article->view_num); ?></span></span></div>
          </article>
        </li>
        <?php else: ?>
        <li class="left">
          <article class="postlist">
            <figure><a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>"

                                               title="<?php echo e(get_article_title($article)); ?>" target="_blank"> <img

                                                    class="thumb" src="<?php echo e(get_article_thum($article)); ?>"

                                                    data-original="<?php echo e(get_article_thum($article)); ?>"

                                                    alt="<?php echo e(get_article_title($article)); ?>" style="display: block;"> </a> </figure>
            <h3><a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>"

                                           title="<?php echo e(get_article_title($article)); ?>"

                                           target="_blank"><?php echo e(get_article_title($article)); ?></a></h3>
            <div class="homeinfo"> 
              
              <!--分类--> 
              
              <span class="category"> <?php if($article->category): ?>
              
              
              
              <?php $__currentLoopData = $article->category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <a href="/article/category/<?php echo e($category['id']); ?>"

                                                       rel="category tag"><?php echo e($category['name']); ?></a> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              
              
              
              <?php endif; ?> </span> 
              
              <!--时间--> 
              
              <span class="date"><?php echo e(str_limit($article->release_time, 10, '')); ?></span> 
              
              <!--点赞--> 
              
              <span title="" class="like"><i class="icon-eye"></i><span

                                                    class="count"><?php echo e($article->view_num); ?></span></span></div>
          </article>
        </li>
        <?php endif; ?>
        
        
        
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </article>
  </div>
  <div class="sidebar right box">
    <section class="label_right_title">
      <h2><?php echo e(trans('index.hot_tags')); ?></h2>
    </section>
    <div class="label">
      <ul>
        <?php $__currentLoopData = $hot_tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><a href="/search?keyword=<?php if('zh-CN' == $lang): ?> <?php echo e($tag->name_cn); ?> <?php else: ?> <?php echo e($tag->name_en); ?> <?php endif; ?>"><?php if('zh-CN' == $lang): ?> <?php echo e($tag->name_cn); ?> <?php else: ?> <?php echo e($tag->name_en); ?> <?php endif; ?></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
    <?php if(isset($ads_8)): ?>
    
    <?php $__currentLoopData = $ads_8; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad8): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="index_right_ad"><a href="<?php echo e($ad8->ad_url); ?>"><img src="<?php echo e(url('uploads/' . $ad8->ad_img)); ?>" width="288" height="225"/></a></div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
    
    
    <?php endif; ?>
    <div class="jobs"><a href="/static/job_service.html" class="jobs_release"> <img src="/images/job_24.gif" width="288" height="115"

                                                                     alt="发布新工作"/></a>
      <section class="label_right_title">
        <h2><?php echo e(trans('index.latest_job')); ?></h2>
      </section>
      <ul>
        <li>（上海）以靠建筑 – 项目建筑师 / 建筑师室内设计师</li>
        <li>（北京）美国DeDeJ Architects – 建筑设项目建筑师项目建筑师</li>
        <li>（上海）寻长设计 – 室内设计师 / 平面室内设计师</li>
        <li>（北京）北京市建筑设计研究院有限公司室内设计师</li>
        <li>（北京）众建筑 PAO – 项目建筑师 ...</li>
        <li>（深圳）东木筑造设计事务所 – 室内设 ...</li>
        <li>（北京/厦门）北京中合现代工程设计有 ...</li>
        <li>（北京）未/WAY Studio建筑设计研究所 ...</li>
        <li>（深圳/香港）华阳国际设计集团 – 集团 ...</li>
        <li>（上海）CLD会筑景观 – 景观设计师 / 初 ...</li>
        <li>（上海） 栋栖设计 dongqi Architects ...</li>
        <li>（上海）Mur Mur Lab – 技术主管 / 项目 ...</li>
        <li>（上海）或者设计 – 资深空间设计师 / 空 ...</li>
        <li>（上海）华章置业(上海)米罗建筑设计事 ...</li>
        <li>（北京）FESCH Beijing飞思建筑设计 ...</li>
        <li>（深圳/香港）华阳国际设计集团 – 集团 ...</li>
        <li>（深圳）耶格卡恩建筑设计 Jaeger Kahl ...</li>
        <li>（北京）未/WAY Studio建筑设计研究所 ...</li>
      </ul>
    </div>
  </div>
</section>
<!---猜你喜欢end----> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>