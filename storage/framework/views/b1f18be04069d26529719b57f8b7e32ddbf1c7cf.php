<?php $__env->startSection('title'); ?>



    <?php echo e(trans('news.all_news')); ?>_<?php echo e(trans('comm.yinji')); ?>


<?php $__env->stopSection(); ?>







<?php $__env->startSection('content'); ?>



    <div class="banner_news"> —— NEWS —— </div>



    <!------顶部大图结束----->



    <section class="wrapper ">







        <div class="cat-wrap left mt20 box">



            <div class="news_box">



                <?php $__currentLoopData = $newses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>



                    <?php if($loop->iteration % 3 == 1): ?>



                        <div class="news" >



                            <article class="postlist">



                                <a href="/news/detail/<?php echo e($news->id); ?>">



                                    <figure>

                                        <img class="thumb" src="<?php echo e(get_article_special($news)); ?>" data-original="<?php echo e(get_article_special($news)); ?>" alt="<?php echo e(get_article_title($news)); ?>" style="display: block;">

                                        <div>

                                            <?php $__currentLoopData = $news['category']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                <span><?php echo e($category['name']); ?></span>

                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        </div>

                                    </figure>



                                </a>



                                <h3> <a href="/news/detail/<?php echo e($news->id); ?>"><?php echo e(get_article_title($news)); ?></a></h3>



                                <div class="news_brief"><a href="/news/detail/<?php echo e($news->id); ?>"><?php echo get_article_description($news); ?></a></div>



                                <div class="homeinfo">



                                    <a href="/news/detail/<?php echo e($news->id); ?>">



                                        <span class="date"><?php echo e(str_limit($news->release_time, 10, '')); ?></span>



                                        <span class="comment"><i class="icon-eye"></i><?php echo e($news->view_num); ?></span>



                                    </a>



                                </div>



                            </article>



                        </div>



                    <?php else: ?>

                        <?php if($loop->iteration % 3 == 2): ?>

                            <div class="news2">

                                <ul>

                                    <li class="left">

                                        <article class="postlist">

                                            <a href="/news/detail/<?php echo e($news->id); ?>">

                                                <figure>

                                                    <img class="thumb" src="<?php echo e(get_article_thum($news)); ?>" data-original="<?php echo e(get_article_thum($news)); ?>" alt="<?php echo e(get_article_title($news)); ?>" style="display: block;">

                                                    <div>

                                                        <?php $__currentLoopData = $news['category']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                            <span><?php echo e($category['name']); ?></span>

                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                    </div>

                                                </figure>



                                            </a>



                                            <h3> <a href="/news/detail/<?php echo e($news->id); ?>"><?php echo e(get_article_title($news)); ?></a></h3>



                                            <div class="news_brief"><a href="/news/detail/<?php echo e($news->id); ?>"><?php echo get_article_description($news); ?></a></div>



                                            <div class="homeinfo">



                                                <a href="/news/detail/<?php echo e($news->id); ?>">



                                                    <span class="date"><?php echo e(str_limit($news->release_time, 10, '')); ?></span>



                                                    <span class="comment"><i class="icon-eye"></i><?php echo e($news->view_num); ?></span>



                                                </a>



                                            </div>



                                        </article>



                                    </li>



                                    <?php endif; ?>











                                    <?php if($loop->iteration % 3 == 0): ?>



                                        <li class="right">



                                            <article class="postlist">



                                                <a href="/news/detail/<?php echo e($news->id); ?>">



                                                    <figure>



                                                        <img class="thumb" src="<?php echo e(get_article_thum($news)); ?>" data-original="<?php echo e(get_article_thum($news)); ?>" alt="<?php echo e(get_article_title($news)); ?>" style="display: block;">

                                                        <div>

                                                            <?php $__currentLoopData = $news['category']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                                                <span><?php echo e($category['name']); ?></span>

                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                                        </div>

                                                    </figure>



                                                </a>



                                                <h3> <a href="/news/detail/<?php echo e($news->id); ?>"><?php echo e(get_article_title($news)); ?></a></h3>



                                                <div class="news_brief"><a href="/news/detail/<?php echo e($news->id); ?>"><?php echo get_article_description($news); ?></a></div>



                                                <div class="homeinfo">



                                                    <a href="/news/detail/<?php echo e($news->id); ?>">



                                                        <span class="date"><?php echo e(str_limit($news->release_time, 10, '')); ?></span>



                                                        <span class="comment"><i class="icon-eye"></i><?php echo e($news->view_num); ?></span>



                                                    </a>



                                                </div>



                                            </article>



                                        </li>



                                </ul>



                            </div>



                            <?php endif; ?>



                            <?php endif; ?>







                            <?php if($loop->last && $loop->iteration % 3 == 2): ?>



                            </ul>



            </div>







            <?php endif; ?>







            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>











        </div>



        </div>







        <a href="#"></a>



        <div class="sidebar right">



            <article id="text-3" class="widget_text wow bounceInUp triangle animated">



                <div class="textwidget">



                    <a href="#">



                        <!-- 右侧广告代码 开始 -->



                    </a>



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



                                <li><a href="<?php echo e($right->ad_url); ?>" target="_blank" rel="noopener"><img src="<?php echo e(url('uploads/' . $right->ad_img)); ?>"></a></li>



                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                        </ul>



                    </div>



                    <a href="#"></a></div>



            </article>



            <article id="slongposts-4" class="box widget_salong_posts wow bounceInUp triangle animated" style="visibility: visible; animation-name: bounceInUp;">



                <div class="sidebar_title">



                    <h3><a href="#"><?php echo e(trans('news.hot_news')); ?></a></h3>



                </div>



                <ul>



                    <?php $__currentLoopData = $hot_newses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>



                        <li>



                            <article class="postlist">



                                <a href="/news/detail/<?php echo e($news->id); ?>">



                                    <figure>



                                        <img class="thumb" src="<?php echo e(get_article_thum($news)); ?>" data-original="<?php echo e(get_article_thum($news)); ?>" alt="<?php echo e(get_article_thum($news)); ?>" style="display: block;">



                                    </figure>



                                </a>



                                <h3> <a href="/news/detail/<?php echo e($news->id); ?>"><?php echo e(get_article_title($news)); ?></a></h3>



                                <div class="homeinfo">







                                    <a href="/news/detail/<?php echo e($news->id); ?>">



                                        <span class="date"><?php echo e(str_limit($news->release_time, 10, '')); ?></span>



                                        <span class="comment"><i class="icon-eye"></i><?php echo e($news->view_num); ?></span>



                                    </a>



                                </div>



                            </article>



                        </li>



                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                </ul>



            </article>



        </div>



        <a href="#"></a></section>

    <script>

        var page = 2;isEnd = false

        $(window).on('scroll',function(e){

            var bodyHeight=document.body.scrollHeight==0?document.documentElement.scrollHeight:document.body.scrollHeight;

            if(bodyHeight - $('body').scrollTop() -10 <window.innerHeight && !isEnd){

                var h  = '';

                var url = window.location.href;

                $.ajax({

                    async: false,

                    url: url + '_ajax?page=' + page,

                    type: 'GET',

                    dataType: 'json',

                    data: {},

                    success: function (data) {

                        if (data.status_code == 0) {

                            page++;

                            h =  data.data.join('')

                            $('.news_box').append(h)

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

<?php $__env->stopSection(); ?>






<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>