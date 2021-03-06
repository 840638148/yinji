<?php $__env->startSection('title'); ?>
    <?php echo e(trans('article.all_article')); ?>_<?php echo e(trans('comm.yinji')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<style>
    /* 小屏幕（平板，大于等于 768px） */
    @media (max-width:768px) {
        .nav_fenlei{position:relative;}
        .nav_fenlei .sort {width: 32px;height: 32px;right: 30px;top: 2px;position: absolute;cursor: pointer;}   
    }
    #ajaxposts:hover .lpbt{display: block;position: absolute;width: 386px;height: 100%;background-color: rgba(0,0,0,.3);top: 0;left: 0;text-align: center;}
    .dcpf{transform: rotate(-45deg) !important;display: inline-block;}
    .icon-search-1{cursor: pointer;}
    .nav_fenlei .sort {right: 15px;top: 18px;}
    .content-post h2{margin:unset;padding:0 10px;}
    .TabContent{padding-top: 20px;}
    .nav_fenlei, .nav_fenlei2{margin-bottom:0;}
    .lpbt h3 {margin-top: 30%;}
    #myTab1 li:hover{color:#636af3;}
</style>

    <?php if('INTERIOR' == strtoupper($type)): ?>
        <div class="banner_news" style="background-image:url(/images/banner_news2.jpg)"> —— <?php echo e(strtoupper($type)); ?> —— </div>
    <?php elseif('ARCHS'== strtoupper($type)): ?>
        <div class="banner_news" style="background-image:url(/images/banner_news1.jpg)"> —— <?php echo e(strtoupper($type)); ?> —— </div>
    <?php else: ?>
        <div class="banner_news" style="background-image:url(/images/company_banner.jpg)"> —— <?php echo e(strtoupper($type)); ?> —— </div>
    <?php endif; ?>
    <!------顶部大图结束----->
    <section class="wrapper">
        <div class="nav_fenlei">
            <?php if('ESTATE'== strtoupper($type)): ?>
                <ul>
                <li <?php if(!isset($current_category) || $current_category == 0): ?> class="current-cat" <?php endif; ?>><a href="/<?php echo e($type); ?>" ><?php echo e(trans('designer.all')); ?></a></li>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li <?php if(isset($current_category) && $current_category == $category->id): ?> class="current-cat" <?php endif; ?>><a href="/<?php echo e($type); ?>/category/<?php echo e($category->id); ?>"><?php if('zh-CN' == $lang): ?> <?php echo e($category->name_cn); ?> <?php else: ?> <?php echo e($category->name_en); ?> <?php endif; ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                
                </ul>
                <div class="sort" style='right:405px;'><i class="icon-list-bullet"></i>
                    <ul class="sortlist">
                        <li class="allsort" so="starssort"><?php echo e(trans('article.sort_by_grade')); ?><span class="arrow" aw="desc">↓</span></li>
                        <li class="allsort" so="timesort"><?php echo e(trans('article.sort_by_time')); ?><span class="arrow" aw="desc">↓</span></li>
                        <li class="allsort" so="llsort"><?php echo e(trans('article.sorted_by_browse')); ?><span class="arrow" aw="desc">↓</span></li>
                    </ul>
                </div>
                <ul id="myTab1">
                    <li style='cursor:pointer;margin-left: 120px;' id='fl1' class="normal" cate='lp' onclick="nTabs(this,0);">地产楼盘</li>
                    <li style='cursor:pointer;' class="normal" id='fl2' cate='dc' onclick="nTabs(this,1);">开发商</li>
                </ul>
                <div class="nav_search">
                    <form id="myform" action="/vip/finderslistsearch" method="post" class="search_form" onkeydown="if (event.keyCode == 13) return false"  >
                        <i class="icon-search-1" id='search_icon' style='right:145px;top:12px;'></i>
                        <input  style='width:160px;right:10px;top:10px;' name="" type="text" id='txt_name' class="search_input"/>
                    </form>
                </div>
            <?php else: ?>
            <ul>
                <li <?php if(!isset($current_category) || $current_category == 0): ?> class="current-cat" <?php endif; ?>><a href="/<?php echo e($type); ?>" ><?php echo e(trans('designer.all')); ?></a></li>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li <?php if(isset($current_category) && $current_category == $category->id): ?> class="current-cat" <?php endif; ?>><a href="/<?php echo e($type); ?>/category/<?php echo e($category->id); ?>"><?php if('zh-CN' == $lang): ?> <?php echo e($category->name_cn); ?> <?php else: ?> <?php echo e($category->name_en); ?> <?php endif; ?></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>                
            </ul>
            <div class="sort"><i class="icon-list-bullet"></i>
                <ul class="sortlist">
                    <li class="allsort" so="starssort"><?php echo e(trans('article.sort_by_grade')); ?><span class="arrow" aw="desc">↓</span></li>
                    <li class="allsort" so="timesort"><?php echo e(trans('article.sort_by_time')); ?><span class="arrow" aw="desc">↓</span></li>
                    <li class="allsort" so="llsort"><?php echo e(trans('article.sorted_by_browse')); ?><span class="arrow" aw="desc">↓</span></li>
                </ul>
            </div> 
            <?php endif; ?>
        </div>
        <!--------分类结束-------->
        <?php if($topics): ?>
            <div class="zhuanti">
                <ul class="zhuanti-inner">
                    <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                            
                        
                            
                        
                        <li>
                            <a href="/topic/<?php echo e($topic->id); ?>"><img src="/uploads/<?php echo e($topic->custom_thum); ?>" />
                                <span class="title-topic">专题</span>
                            </a>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <!---------专题结束-------->

        <section class="content">
            <section class="post_list box post_bottom triangle wow bounceInUp animated" style="visibility: visible; animation-name: bounceInUp;margin-top:20px;">
                <ul class="layout_ul ajaxposts article-content">
                    <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($article->article_status==2 && $article->display==0): ?>
                        <li class="layout_li ajaxpost" id="ajaxpost" >
                            <div class="interior_dafen"><?php echo e($article->article_avg!=''||$article->article_avg!=null?sprintf("%.1f",$article->article_avg):'5.0'); ?></div>
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
                    <?php endif; ?>    
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <!-- 分页 -->
                    <?php if('ESTATE'== strtoupper($type)): ?>
                    <!-- 地产楼盘开始 -->
                    <div id="myTab1_Content0" class="none" style='min-height:600px;'>
                        <?php $__currentLoopData = $loupanlists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $loupan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="layout_li ajaxpost" id="ajaxposts" >
                            <div class="interior_dafen"><span class='dcpf'><?php echo e(sprintf("%.1f",$loupan->lpavg)); ?></span></div>
                            <article class="postgrid">
                                <figure style='height:unset;'>
                                <img class="thumb0" src="/uploads/<?php echo e($loupan->bgimg); ?>" data-original="" alt="" style="display: block;">
                                </figure>
                                <div class="chengshi" style='bottom:20px;'><?php echo e($loupan->area); ?></div>
                                <a href="/eatatecloud/<?php echo e($loupan->url); ?>" target="_blank"><div class="lpbt"><h3><?php echo e($loupan->name); ?></h3></div></a>
                            </article>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <!-- 地产楼盘结束 -->

                    <!-- 地产开始 -->
                    <div id="myTab1_Content1" class="none" style='min-height:600px;'>
                        <?php $__currentLoopData = $dclists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dc): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="layout_li ajaxpost" id="ajaxposts">
                            <article class="postgrid">
                                <figure><img class="thumb0" src="/uploads/<?php echo e($dc->cover); ?>" data-original="" alt="" style="display: block;"></figure>
                                <a href="/develop/<?php echo e($dc->url); ?>" target="_blank"><div class="lpbt"><h3><?php echo e($dc->name); ?></h3></div></a>
                            </article>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <!-- 地产结束 -->
                    <?php endif; ?>

                </ul>




            </section>

        </section>

    </section>


    <script>
    window.cate='lp';
    // 选项卡切换
    function nTabs(thisObj,Num){
        if(thisObj.className == "active")return;
        var tabObj = thisObj.parentNode.id;
        var tabList = document.getElementById(tabObj).getElementsByTagName("li");
        $('li#ajaxpost').hide()
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

    //搜索框
    window.content='';
    $(document).on('click','#search_icon',function(){
        let h='';
        window.content=$(this).siblings('.search_input').val();
        if(content=='' || content==null){
            layer.msg('请填写搜索关键词',{skin: 'intro-login-class layui-layer-hui'});
            return false;
        }

        if($('#fl1').attr('class')=='normal' && $('#fl2').attr('class')=='normal'){
            layer.msg('请先选择分类',{skin: 'intro-login-class layui-layer-hui'});
            return false;
        }
        $.ajax({
            async:false,
            url: '/dichan/search',
            type: 'POST',
            dataType: 'json',
            data: {content:content,cate:cate,},
            success:function(data) {
            
            if(data.status_code==0){
                if(data.message.cates=='lp'){
                    $('#myTab1_Content0').html(data.message.res);
                }else if(data.message.cates=='dc'){
                    $('#myTab1_Content1').html(data.message.res);
                }

                }else{
                    layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'});
                    $('.text_input').val('');
                }
            }
        });
    })

    //打开排序列表
    $(document).on('click','.sort',function(){
        $('.sortlist').toggle(500);
    })
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
        
        console.log(page); 

        layer.closeAll();  
            $.ajax({
                url: '/article/allsortlist',
                type: 'POST',
                dataType: 'json',
                data: {type:type,sjx:sjx,category_id:category_id,},
                success: function (data) {
                    // window.vm.$data.list=data.data;
                    console.log(data)
                    //改变排序的值
                    if (data.status_code == 0) {
                        isEnd=false;
                        // 
                        page++;
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

    //分页
    $(window).on('scroll',function(e){
        var bodyHeight=document.body.scrollHeight==0?document.documentElement.scrollHeight:document.body.scrollHeight;
        if(bodyHeight - $('body').scrollTop() -10 < window.innerHeight && !isEnd){
            let h  = '';
            let url = window.location.href;
            let types =url.split('/').slice(3).join('/');
            let category_id=url.split('/')[5];

            if(category_id){//选择分类的
                urls=url + '_ajax?page=' + page+'&category_id='+category_id+'&type='+type+'&sjx='+sjx;
            }
            if($('#fl1').attr('class')=='active' || $('#fl2').attr('class')=='active'){//选中地产选项的
                urls='estates_ajax?page=' + page+'&cate='+cate+'&content='+content;
            }else{
                urls=url + '_ajax?page=' + page+'&type='+type+'&sjx='+sjx;
            }
            $.ajax({
                async: false,
                url: urls,
                type: 'POST',
                dataType: 'json',
                data: {type:type,sjx:sjx,category_id:category_id},
                success: function (data) {
                    // console.log(data.data.res);
                    if (data.status_code == 0) {
                        page++;
                        // h =  data.data.join('')
                        h =  data.data

                        if($('#fl1').attr('class')=='active' || $('#fl2').attr('class')=='active'){
                            if($('#fl1').attr('class')=='active' && $('#fl2').attr('class')=='normal'){
                                $('#myTab1_Content0').append(data.data.res);
                            }
                            if($('#fl1').attr('class')=='normal' && $('#fl2').attr('class')=='active'){
                                $('#myTab1_Content1').append(data.data.res);
                            }
                        }else{
                            $('.article-content').append(h)
                        }
                        if(data.data.length<15){isEnd = true}else{isEnd=false}
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