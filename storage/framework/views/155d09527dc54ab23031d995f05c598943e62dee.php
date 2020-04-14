<?php $__env->startSection('title'); ?>
    <?php echo e(get_topic_title($topic)); ?>_<?php echo e(trans('comm.yinji')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <div class="zt_banner" style="background:url(/uploads/<?php echo e($topic->special_photo); ?>) no-repeat; height:600px; display: block"></div>
    <section class="wrapper">
        <div class="zt_top  mt20 left">
            <div class="zt_top2">
                <ul>
                    <?php
                        $ii = 0;
                        $hots = [];
                        foreach ($hot_article_more as $article) {
                            $ii ++;
                            $hots[] = $article;
                            if ($ii >= 3) {
                                break;
                            }
                        }
                    ?>
                    <?php $__currentLoopData = $hots; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <a href="<?php if($hot->static_url): ?> /article/<?php echo e($hot->static_url); ?> <?php else: ?> /article/detail/<?php echo e($hot->id); ?> <?php endif; ?>" target="_blank">
                                <img class="thumb" src="<?php echo e(get_article_thum($hot)); ?>" style="display: block;">
                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <?php if($hot_article): ?>
            <div  class="zt_top1"><a href="<?php if($hot_article->static_url): ?> /article/<?php echo e($hot_article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($hot_article->id); ?> <?php endif; ?>" target="_blank"> <img class="thumb" src="<?php echo e(get_article_thum($hot_article)); ?>" style="display: block;"> </a>
                <div class="zt_hot">
                    <h1>HOT1</h1>
                    <div class="hot_title"><?php echo e(get_article_title($hot_article,2)); ?></div>
                    <div class=""><i class="icon-user"></i> <?php echo e(get_article_designer($hot_article)); ?></div>
                    <div class="excerpt "> &nbsp; <?php echo e(get_article_description($hot_article)); ?> </div>
                    <div class="homeinfo">
                        <!--分类-->

                        <?php if($hot_article->category): ?>
                            <?php $__currentLoopData = $hot_article->category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <span class="category"><a href="/article/category/<?php echo e($category['id']); ?>" rel="category tag"><?php echo e($category['name']); ?></a></span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <!--时间-->
                        <span class="date"><?php echo e(str_limit($hot_article->release_time, 10, '')); ?></span>
                    </div>
                    <div class=" zt_li3">
                        <ul>
                            <li>
                                <!--浏览量-->
                                <span class="view"><i class="icon-eye"></i><?php echo e($hot_article->view_num); ?></span> </li>
                            <li>
                                <!--评论-->
                                <span class="comment"><i class="icon-comment"></i><?php echo e($hot_article->view_num); ?></span> </li>
                            <li>
                                <!--点赞-->
                                <span title="" class="like"><i class="icon-thumbs-up"></i><span class="count"><?php echo e($hot_article->like_num); ?></span></span> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        <div class="zt_news fr mt20">
            <dl>
                <dt><span>News</span></dt>
                <?php $__currentLoopData = $news_articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <dd>
                    <article class="postlist">
                        <figure>
                            <a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>" title="<?php echo e(get_article_title($article)); ?>" target="_blank">
                                <img class="thumb" src="<?php echo e(get_article_thum($article)); ?>" data-original="<?php echo e(get_article_thum($article)); ?>" alt="<?php echo e(get_article_title($article)); ?>" style="display: block;">
                            </a>
                        </figure>
                        <h3>
                            <a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>" title="<?php echo e(get_article_title($article)); ?>" target="_blank"><?php echo e(get_article_title($article, 2)); ?></a>
                        </h3>
                        <div class="homeinfo">
                            <!--分类-->
                            <?php if($article->category): ?>
                                <?php $__currentLoopData = $article->category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <a href="/article/category/<?php echo e($category['id']); ?>" rel="category tag"><?php echo e($category['name']); ?></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            <span class="date"><?php echo e(str_limit($article->release_time, 10, '')); ?></span>
                            <span class="comment"><i class="icon-eye"></i><a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>"><?php echo e($article->view_num); ?></a></span>
                        </div>
                    </article>
                </dd>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </dl>
            </div>
        <!---推荐设计师开始--->
        <div class="zt_design mt30">
            <div class="zt_title"><i class="icon-thumbs-up" style="margin-right:5px;"></i> 设计师推荐 </div>
            <div class="design_more">
                <div class="swiper-wrapper">
                    <?php $__currentLoopData = $designers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="design_more_item">
                      <ul>
                      <li>  <a href="<?php if($designer->static_url): ?> /designer/<?php echo e($designer->static_url); ?> <?php else: ?> /designer/detail/<?php echo e($designer->id); ?> <?php endif; ?>" title="<?php echo e(get_designer_title($designer)); ?>" target="_blank">
                            <img class="thumb" src="<?php echo e(get_designer_thum($designer)); ?>" alt="<?php echo e(get_designer_title($designer)); ?>" style="display: block;"> </a>
                            </li>
                            </ul>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="icon-angle-left design_button-next" style="display:none"></div>
            <div class="icon-angle-right design_button-prev" style="display:none"></div>
        </div>

        <!---作品列表开始--->
        <div class="mt30 fl" style="width:100%">
            <div class="mx_title"><?php echo e(get_topic_title($topic)); ?></div>
            <section class="content" file="wp-content/themes/lensnews/category.php:14">
                <section class="post_list box post_bottom triangle wow bounceInUp animated" style="visibility: visible; animation-name: bounceInUp;">
                    <ul class="layout_ul ajaxposts article-content">
                        <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="layout_li ajaxpost">
                            <div class="interior_dafen"><?php echo e($article->starsavg !=0 ? $article->starsavg : '5.0'); ?></div>
                                <article class="postgrid">
                                    <figure>
                                        <a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>" title="<?php echo e(get_article_title($article)); ?>" target="_blank">
                                            <img class="thumb" src="<?php echo e(get_article_thum($article)); ?>" data-original="<?php echo e(get_article_thum($article)); ?>" alt="<?php echo e(get_article_title($article)); ?>" style="display: block;">
                                        </a>
                                    </figure>
                                    <div class="chengshi"><?php echo e(get_article_location($article)); ?></div>
                                    <h2>
                                        <a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>" title="<?php echo e(get_article_title($article)); ?>" target="_blank">
                                            <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;"><?php echo e(get_article_title($article, 1)); ?></div>
                                            <div style=" color:#666; line-height:24px;"><?php echo e(get_article_title($article, 2)); ?></div>
                                        </a>
                                    </h2>
                                    <div class="homeinfo">
                                        <!--分类-->
                                        <?php if($article->category): ?>
                                            <?php $__currentLoopData = $article->category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <a href="/article/category/<?php echo e($category['id']); ?>" rel="category tag"><?php echo e($category['name']); ?></a>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                    <!--时间-->
                                        <span class="date"><?php echo e(str_limit($article->release_time, 10, '')); ?></span>
                                        <!--点赞-->
                                        <span title="" class="like"><i class="icon-eye"></i><span class="count"><?php echo e($article->view_num); ?></span></span>
                                    </div>
                                </article>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </section>
            </section>
        </div>
    </section>


<script>
$(function(){
    if($('.design_more_item').length > 5 ){
        $('.design_more_item').each(function(){
            $(this).addClass('swiper-slide')
        })
        $('.design_button-next').show();
        $('.design_button-prev').show();
        var swiper = new Swiper('.design_more', {
            pagination: '.swiper-pagination',
            slidesPerView: 5,
            paginationClickable: true,
            spaceBetween: 30,
            nextButton: '.design_button-prev',
            prevButton: '.design_button-next',
            loop: true,
            autoplay:3000
        });
    }
    
})
</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>