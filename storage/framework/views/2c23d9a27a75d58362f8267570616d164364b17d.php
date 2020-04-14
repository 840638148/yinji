<?php $__env->startSection('title'); ?>
    <?php echo e(trans('article.all_article')); ?>_<?php echo e(trans('comm.yinji')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php if('INTERIOR' == strtoupper($type)): ?>
        <div class="banner_news" style="background-image:url(/images/banner_news2.jpg)"> —— <?php echo e(strtoupper($type)); ?> —— </div>
    <?php else: ?>
        <div class="banner_news" style="background-image:url(/images/banner_news1.jpg)"> —— <?php echo e(strtoupper($type)); ?> —— </div>
    <?php endif; ?>
    <!------顶部大图结束----->
    <section class="wrapper">
        <div class="nav_fenlei">
            <ul>
            <li <?php if(!isset($current_category) || $current_category == 0): ?> class="current-cat" <?php endif; ?>><a href="/<?php echo e($type); ?>" ><?php echo e(trans('designer.all')); ?></a></li>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li <?php if(isset($current_category) && $current_category == $category->id): ?> class="current-cat" <?php endif; ?>><a href="/<?php echo e($type); ?>/category/<?php echo e($category->id); ?>"><?php if('zh-CN' == $lang): ?> <?php echo e($category->name_cn); ?> <?php else: ?> <?php echo e($category->name_en); ?> <?php endif; ?></a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <div class="sort"><i class="icon-list-bullet"></i>
                <ul class="sortlist">
                    <li class="allsort" so="starssort">按评分排序<span class="arrow" aw="desc">↓</span></li>
                    <li class="allsort" so="timesort">按时间排序<span class="arrow" aw="desc">↓</span></li>
                    <li class="allsort" so="llsort">按浏览排序<span class="arrow" aw="desc">↓</span></li>
                    
                </ul>
            </div> 
        </div>
        <!--------分类结束-------->
        <?php if($topics): ?>
            <div class="zhuanti">
                <ul class="zhuanti-inner">
                    <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                            
                        
                            
                        
                        <li><a href="/topic/<?php echo e($topic->id); ?>"><img src="/uploads/<?php echo e($topic->custom_thum); ?>" />
                                <span class="title-topic">专题</span>
                            </a></li>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



                </ul>

            </div>

    <?php endif; ?>

    <!---------专题结束-------->

        <section class="content" file="wp-content/themes/lensnews/category.php:14">
            <section class="post_list box post_bottom triangle wow bounceInUp animated" style="visibility: visible; animation-name: bounceInUp;">
                <ul class="layout_ul ajaxposts article-content">
                    <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="layout_li ajaxpost" id="ajaxpost" >
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

                <!-- 分页 -->

                </ul>

            </section>

        </section>

    </section>


    <script src="https://cdn.staticfile.org/vue/2.4.2/vue.min.js"></script>
    <script>
// window.vm = new Vue({
//         el: '#ajaxpost',
//         data: {
//             list:null,
            
//         },
       
//     })
// window.t=this;









    //打开排序列表
    $(document).on('click','.sort',function(){
        $('.sortlist').toggle(500);
    })

    $(document).on('click','.allsort',function(){
        let that=$(this);
        let type=that.attr('so');
        let sjx=that.find(".arrow").attr('aw');
        
        
        console.log(type,sjx); 
        console.log(that.find(".arrow").html()); 

        layer.closeAll();  
            $.ajax({
                url: '/article/allsortlist',
                type: 'POST',
                dataType: 'json',
                data: {type:type,sjx:sjx},
                success: function (data) {
                    // window.vm.$data.list=data.data;
                    console.log(data)
                    //改变排序的值
                    if (data.status_code == 0) {
                       console.log('传过来了');
                       if(that.find(".arrow").attr('aw')=='desc' && that.find(".arrow").html()=='↓'){
                                that.find(".arrow").attr('aw','asc');
                                that.find(".arrow").html('↑');  
                        }
                        else if(that.find(".arrow").attr('aw')=='asc' && that.find(".arrow").html()=='↑'){
                                that.find(".arrow").attr('aw','desc');
                                that.find(".arrow").html('↓');
                        }
                        let list = data.data;
                        $('.article-content').empty();
                        $('.article-content').html(list);
                        // for (let i = 0;i < list.length;i++) {
                        //     $('.article-content').append(list[i].html);
                        // }
                    //    $('.article-content').html(data.data);这里为啥使用追加，而不是直接替换。因为我是遍历里边一个个加的，你也可以坝html拼接在一起，然后直接替换。。我就是不想拼接才写的控制器里面那一大坨东西。。。你可以在控制器里拼接，那边拼好了，ojbk

                    } else {
                        layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'});
                    }
                }
            });
    })

 











        var page = 2;isEnd = false
        function getMoreArticle(){
            var h = `<li class="layout_li ajaxpost">
                <div class="interior_dafen">5.0</div>
                    <article class="postgrid">
                        <figure>
                            <a href="/article/detail/1107" title="贝聿铭 | 梅萨实验室 , 现代主义建筑的回响" target="_blank">
                                <img class="thumb" src="http://120.79.234.88/photo/images/00-CN/Leoh%20Ming%20Pei/02-Mesa%20Lab/01.jpg" data-original="http://120.79.234.88/photo/images/00-CN/Leoh%20Ming%20Pei/02-Mesa%20Lab/01.jpg" alt="贝聿铭 | 梅萨实验室 , 现代主义建筑的回响" style="display: block;">
                            </a>
                        </figure>
                        <div class="chengshi">科罗拉多</div>
                        <h2>
                            <a href="/article/detail/1107" title="贝聿铭 | 梅萨实验室 , 现代主义建筑的回响" target="_blank">
                                <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;">贝聿铭 </div>
                                <div style=" color:#666; line-height:24px;"> 梅萨实验室 , 现代主义建筑的回响</div>
                            </a>
                        </h2>
                        <div class="homeinfo">
                            <!--分类-->
                <a href="/article/category/1" rel="category tag">建筑</a>
                <a href="/article/category/11" rel="category tag">公用建筑</a>
                <!--时间-->
                <span class="date">2017-06-08</span>
                <!--点赞-->
                <span title="" class="like"><i class="icon-eye"></i><span class="count">7575</span></span> </div>
                </article>
                </li>`

                var arr = [];
                for(var i = 0; i< 6;i++){
                arr.push(h)
                }

                return arr.join('')
        }



        $(window).on('scroll',function(e){
            var bodyHeight=document.body.scrollHeight==0?document.documentElement.scrollHeight:document.body.scrollHeight;
                if(bodyHeight - $('body').scrollTop() -10 < window.innerHeight && !isEnd){
                    var h  = '';
                    var url = window.location.href;
                    $.ajax({
                        async: false,
                        url: url + '_ajax?page=' + page,
                        type: 'GET',
                        dataType: 'json',
                        data: {},
                        success: function (data) {
                            console.log(data);
                            if (data.status_code == 0) {
                                page++;
                                h =  data.data.join('')
                                $('.article-content').append(h)
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

    <!---------文章列表结束------->

<?php $__env->stopSection(); ?>




<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>