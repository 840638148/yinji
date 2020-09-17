<?php $__env->startSection('title'); ?>
  <?php echo e(trans('comm.yinji')); ?> - TA <?php echo e(trans('index.collection_detail')); ?>

<?php $__env->stopSection(); ?>
   
<?php $__env->startSection('content'); ?>
<style>
body{background:#f8f8f8 !important;}
.home_box{border-radius:10px !important;}
.home_top{background:#fff !important;}
</style>
<div class="home_top">
<div class="home_banber"> 
    <?php if($users->zhuti): ?>
    <img src="<?php echo e($users->zhuti); ?>" alt="个人主页图片" />
    <?php else: ?>
    <img src="/images/zhutibj.jpg" alt="个人主页图片" />
    <?php endif; ?>
  </div>
  <div class="home_tongji">
  <ul>
      <li><?php echo e(trans('index.sentiment')); ?></br><?php echo e(App\User::getViewNum($users->id)); ?> </li>
      <li><?php echo e(trans('index.collection')); ?></br><?php echo e(App\User::getCollectNum($users->id)); ?> </li>
      <li><?php echo e(trans('index.follow')); ?></br><?php echo e(App\User::getFollowNum($users->id)); ?> </li>
      <li><?php echo e(trans('index.fans')); ?></br><?php echo e(App\User::getFansNum($users->id)); ?> </li>
    </ul>
  </div>
  <div class="home_personal"> <img src="<?php if($users->avatar): ?> <?php echo e($users->avatar); ?> <?php else: ?> /img/avatar.png <?php endif; ?>" alt="<?php echo e($users->nickname); ?>" />
   
  </div>
  <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> <?php echo e($users->nickname); ?> <img src="<?php echo e($users->vip_level); ?>" alt=""></h2>
  <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;"><?php if($users->zhiwei): ?><?php echo e($users->zhiwei); ?><?php else: ?> 保密 <?php endif; ?> - <?php echo e($users->city); ?> <img src="<?php echo e(App\User::getVipLevel($users->id)); ?>" alt=""></p>
  <?php if($user->id==$users->id): ?>
  
  <?php elseif($users->is_follow): ?>
  <p style="position:absolute; text-align:center;left: 0;top:450px;width: 100%;"><span class='have-disalbed' uid='<?php echo e($users->id); ?>' style='padding: 5px 25px;display: inline-block;background: #eee;margin: 20px auto;color: #666;cursor:no-drop !important;border-radius: 5px;'><?php echo e(trans('index.following')); ?></span></p>
  <?php else: ?>
  <p style="position:absolute; text-align:center;left: 0;top:450px;width: 100%;"><span class='gzuser' uid='<?php echo e($users->id); ?>' style='padding: 5px 25px;display: inline-block;background: #3d87f1;margin: 20px auto;color: #fff;cursor: pointer !important;border-radius: 5px;'><?php echo e(trans('index.follow')); ?></span></p>
  <?php endif; ?>
  <div class="home_nav" style='width:610px;left:52%;'>
    <ul>
        <li><a href="/member/<?php echo e($users->id); ?>"><?php echo e(trans('index.home_page')); ?></a></li>
        <li><a href="/member/homepage_finder/<?php echo e($users->id); ?>"><?php echo e(trans('index.discovery')); ?></a></li>
        <li class="current"><a href="/member/homepage_collect/<?php echo e($users->id); ?>"><?php echo e(trans('index.collection')); ?></a></li>
        <li><a href="/member/homepage_subscription/<?php echo e($users->id); ?>"><?php echo e(trans('index.subscription')); ?></a></li>
        <li><a href="/member/homepage_interactive/<?php echo e($users->id); ?>"><?php echo e(trans('index.follow')); ?></a></li>
        <li><a href="/member/homepage_fans/<?php echo e($users->id); ?>"><?php echo e(trans('index.fans')); ?></a></li>
    </ul>
  </div>
</div>
<section class="wrapper" style='width:1245px;'>
  <div class="mt30 home_box">
    <div class="title">
      <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'><?php echo e(isset($folder_name) ? $folder_name : ''); ?></span></h2>
      
      <span class="fr"><a href="javascript:window.history.go(-1);" data-type="collect" >&lt; <?php echo e(trans('index.back')); ?></a></span> </div>
    <ul class="layout_ul ajaxposts">
      <div class="post_list">
        <ul>
          <?php $__currentLoopData = $users->collect_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $articles): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if(get_class($article)=='App\Models\Article'): ?>
                <li class="layout_li ajaxpost">
                  <article class="postgrid">
                  <span class="guojia2" >
                    <a style="position:absolute;bottom:60px;right:35px;z-index:9;" href="#" rel="tag"><?php echo e($article->location_cn); ?></a>
                  </span>
                    <figure> <a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>" title="<?php echo e(get_article_title($article)); ?>" target="_blank"> <img class="thumb" src="<?php echo e(get_article_thum($article)); ?>" data-original="<?php echo e(get_article_thum($article)); ?>" alt="<?php echo e(get_article_title($article)); ?>" style="display: block;"> </a> </figure>
                    <h2> <a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>" title="<?php echo e(get_article_title($article)); ?>" target="_blank">
                      <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;"><?php echo e(get_article_title($article, 1)); ?></div>
                      <div style=" color:#666; line-height:24px;"><?php echo e(get_article_title($article, 2)); ?></div>
                      </a> </h2>
                    <div class="homeinfo"> 
                      <!--分类--> 
                      <?php if($article->category): ?>
                      <?php $__currentLoopData = $article->category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <a href="/article/category/<?php echo e($category['id']); ?>" rel="category tag"><?php echo e($category['name']); ?></a> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php endif; ?> 
                      <!--时间--> 
                      <span class="date"><?php echo e(str_limit($article->release_time, 10, '')); ?></span> 
                      <!--点赞--> 
                      <span title="" class="like"><i class="icon-eye"></i><span class="count"><?php echo e($article->view_num); ?></span></span> </div>
                  </article>
                </li>
              <?php else: ?>
                <li class="layout_li ajaxpost">
                  <article class="postgrid">
                  <span class="guojia2" >
                    <a style="position:absolute;bottom:60px;right:35px;z-index:9;" href="#" rel="tag"><?php echo e($article->area); ?></a>
                  </span>
                    <figure> <a href="/details/<?php echo e($article->id); ?>" title="<?php echo e(get_dc_title($article)); ?>" target="_blank"> <img class="thumb" src="<?php echo e(get_dc_thum($article)); ?>" data-original="<?php echo e(get_dc_thum($article)); ?>" alt="<?php echo e(get_dc_title($article)); ?>" style="display: block;"> </a> </figure>
                    <h2> <a href="/details/<?php echo e($article->id); ?>" title="<?php echo e(get_dc_title($article)); ?>" target="_blank">
                      <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;"><?php echo e(get_dc_title($article, 1)); ?></div>
                      <div style=" color:#666; line-height:24px;"><?php echo e(get_dc_title($article, 2)); ?></div>
                      </a> </h2>
                    <div class="homeinfo"> 
                      <!--分类--> 
                      <?php if($article->category): ?>
                      <?php $__currentLoopData = $article->category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <a href="/article/category/<?php echo e($category['id']); ?>" rel="category tag"><?php echo e($category['name']); ?></a> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php endif; ?> 
                      <!--时间--> 
                      <span class="date"><?php echo e(str_limit($article->release_time, 10, '')); ?></span> 
                      <!--点赞--> 
                      <span title="" class="like"><i class="icon-eye"></i><span class="count"><?php echo e($article->view_num); ?></span></span> </div>
                  </article>
                </li>
              <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <!-- 分页 --> 
      </div>
    </ul>
  </div>
</section>

<script>
  // 关注TA
  $('.gzuser').click(function(){
    let gzid=$(this).attr('uid');
    let that=$(this);
    $.ajax({
        url: '/member/gzta',
        type: 'POST',
        dataType: 'json',
        data: {_token:'<?php echo e(csrf_token()); ?>',gzid:gzid},
        success: function (data) {
            if (data.status_code == 100) {
                layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
                that.text('取消关注');
                that.removeClass('gzuser');
                that.addClass('have-disalbed').css('background','#e62b3c');
                window.location.reload();
            } else {
                layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
            }
        }
    });
  });


</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>