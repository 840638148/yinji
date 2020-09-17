<?php $__env->startSection('title'); ?>

    <?php echo e(trans('comm.yinji')); ?> - <?php echo e(trans('comm.second_title')); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="about_bj" style="background-image:url(images/banner.jpg)"> </div>
<div class="search_box">
    <div class="search_nav_bj">
        <div class="wrapper">
            <div class="search_nav">
                
                
                
                
                
            </div>

            <div class="search_nav_right">  
                <input  id="keywords" name="keywords" type="text" placeholder="输入搜索的关键词" value="<?php echo e($keyword); ?>"> 
                <a href="#" class="icon-search-1 fr" id="search-btn"></a>
            </div>
        </div>
    </div>

    <div class="wrapper" style=" padding-top:20px">
        <!----------设计师搜索结果------->
        <div class="mt30 search-result">
            <div class="title">
                <h2><?php echo e(trans('index.related_designer')); ?> <span><?php echo e(trans('index.a_total_of_found')); ?> <?php echo e($designers->total()); ?> <?php echo e(trans('index.result')); ?></span></h2>
            </div>

            <div class="public_list"> 
                <?php $__currentLoopData = $designers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="public_item" data-id="<?php echo e($designer->id); ?>">
                        <div class="item_left"> 
                            <a href="<?php if($designer->static_url): ?> /designer/<?php echo e($designer->static_url); ?> <?php else: ?> /designer/detail/<?php echo e($designer->id); ?> <?php endif; ?>" title="<?php echo e(get_designer_title($designer)); ?>" target="_blank">
                                <div class="tx"> <img src="<?php if(get_designer_thum($designer)): ?> <?php echo e(get_designer_thum($designer)); ?> <?php else: ?> /img/avatar.png <?php endif; ?>"  data-original="<?php echo e(get_designer_thum($designer)); ?>" alt="<?php echo e(get_designer_title($designer)); ?>" style="display: block;" > </div>
                            </a>

                            <div class="item_msg">
                                <div class="title"> 
                                    <a href="<?php if($designer->static_url): ?> /designer/<?php echo e($designer->static_url); ?> <?php else: ?> /designer/detail/<?php echo e($designer->id); ?> <?php endif; ?>" title="<?php echo e(get_designer_title($designer)); ?>" target="_blank"><?php echo e(get_designer_title($designer)); ?></a> 
                                </div>
                                <div class="describe"> 
                                    <span>国家：
                                        <?php $__currentLoopData = $designer->categorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php if($loop->last): ?>
                                                <?php echo e($category['name']); ?>

                                            <?php else: ?>
                                                <?php echo e($category['name']); ?>,
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                    </span>
                                    <span><?php echo get_designer_description($designer); ?></span>

                                </div>

                                <div class="focus">
                                    <div class="focus_msg"> <span>文章：<?php echo e($designer->article_num); ?></span> | <span>粉丝：<?php echo e($designer->fans_num); ?></span> </div>
                                </div>

                            </div>

                        </div>

                        <div class="item_right"> 
                            <?php $__currentLoopData = $designer->articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="works" data-id="1722"> <a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>" target="_blank"> <img src="<?php echo e(get_article_thum($article)); ?>" alt=""> <span><?php echo e(get_article_title($article)); ?></span> </a> </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php echo e($designers->appends(['keyword' => $keyword,array_except(Request::query(), 'designers')])->links()); ?>

        </div>
        <!----------设计师订阅结束------->


        
        
            
                
                        
                            
                                
                            
                                
                            

                            
                                
                                        

                                

                                    

                                    

                                        

                                        

                                

                                                

                                            

                            

                                        

                                

                            

                        

                    

                

            

        
        



        <!--------文章----------->
        <div class="mt30 search-result">
            <div class="title">
                <h2><?php echo e(trans('index.related_works')); ?> <span><?php echo e(trans('index.a_total_of_found')); ?> <?php echo e($articles->total()); ?> <?php echo e(trans('index.result')); ?></span></h2>
            </div>

            <div class="article_box search_result_box " data-type="article">
                <section class="content" file="wp-content/themes/lensnews/category.php:14">
                    <section class="post_list box post_bottom triangle wow bounceInUp animated" style="visibility: visible; animation-name: bounceInUp;">
                        <ul class="layout_ul ajaxposts article-content">
                            <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="layout_li ajaxpost">
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
            <!-- 分页 -->
            <?php echo e($articles->appends(['keyword' => $keyword,array_except(Request::query(), 'articles')])->links()); ?>

            <!-- 分页结束 -->
        </div>
        <!------文章结束-------->



        

        

            

            

                

                    

                        

                            

                                

                                    

                                

                            

                            

                                

                            

                        

                    

                

            

            

            

                

                    

                        

                            

                            

                                

                                

                        

                    

                

            

        



        
        
        

            

            

                

                    

                        

                        

                    

                

                

                    

                        

                        

                    

                

                

                    

                        

                        

                    

                

                

                    

                        

                        

                    

                

                

                    

                        

                        

                    

                

                

                    

                        

                        

                    

                

                

                    

                        

                        

                    

                

                

                    

                        

                        

                    

                

                

                    

                        

                        

                    

                

                    

                        

                        

                    

                

                

                    

                        

                        

                    

                

                

                    

                        

                        

                    

                

                

                    

                        

                        

                    

                

                

                    

                        

                        

                    

                

                

                    

                        

                        

                    

                

                

                    

                        

                        

                    

                

            

        
        <!---------工作结束-------->



        <!--------新闻----------->
        <div class="search-result">
            <div class="title">
                <h2><?php echo e(trans('index.related_news')); ?> <span><?php echo e(trans('index.a_total_of_found')); ?> <?php echo e($newses->total()); ?> <?php echo e(trans('index.result')); ?></span></h2>
            </div>

            <div class="left" style="width:100%">
                <div class="news3">
                    <ul class="layout_li ajaxpost">
                        <div class="post_list">
                            <ul>
                            <?php $__currentLoopData = $newses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $news): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="left layout_li ajaxpost">
                                    <article class="postlist postgrid">
                                        
                                            <figure><a href="/news/detail/<?php echo e($news->id); ?>">
                                                <img class="thumb" src="<?php echo e(get_article_thum($news)); ?>" data-original="<?php echo e(get_article_thum($news)); ?>" alt="<?php echo e(get_article_title($news)); ?>" style="display: block;width:unset;"></a>
                                            </figure>
                                        
                                        <h3> <a href="/news/detail/<?php echo e($news->id); ?>"><?php echo e(get_article_title($news)); ?></a></h3>
                                        <div class="news_brief" style='text-indent: 0.9em;'><a href="/news/detail/<?php echo e($news->id); ?>"><?php echo get_article_description($news); ?></a></div>
                                        <div class="homeinfo">
                                            <a href="/news/detail/<?php echo e($news->id); ?>">
                                                <span class="date"><?php echo e(str_limit($news->release_time, 10, '')); ?></span>
                                                <span class="comment"><i class="icon-eye"></i><?php echo e($news->view_num); ?></span>
                                            </a>
                                        </div>
                                    </article>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <div>
                        </ul>
                    </ul>
                </div>
            </div>
            <!-- 分页 -->
            <?php echo e($newses->appends(['keyword' => $keyword,array_except(Request::query(), 'newses')])->links()); ?>

            <!-- 分页结束 -->
        </div>
        <!------新闻结束-------->

    </div>

</div>


<script>
    $('#search-btn').on('click',function(){
        let value = $('#keywords').val();
        window.location.href = '/search?keyword=' + encodeURIComponent(value);
    });

    //绑定回车事件
    let $inp=$('input');
    $inp.keypress(function(e){
        let key=e.which;
        if(key==13){
            $('#search-btn').trigger("click");
        }
    }) 

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>