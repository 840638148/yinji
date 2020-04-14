<?php $__env->startSection('title'); ?>
  <?php echo e(trans('comm.yinji')); ?> - 个人中心 - 收藏详情
<?php $__env->stopSection(); ?>
   
<?php $__env->startSection('content'); ?>
<div class="home_top">
  <div class="home_banber"> <img src="/images/home_bj.jpg" alt="个人主页图片" /></div>
  <div class="home_tongji">
    <ul>
      <li> 订阅</br>
        <?php echo e($user->subscription_num); ?> </li>
      <li> 收藏</br>
        <?php echo e($user->collect_num); ?> </li>
      <li> 发现</br>
        <?php echo e($user->points); ?> </li>
      <li> 关注</br>
        <?php echo e($user->follow_num); ?> </li>
    </ul>
  </div>
  <div class="home_personal"> <img src="<?php if($user->avatar): ?> <?php echo e($user->avatar); ?> <?php else: ?> /img/avatar.png <?php endif; ?>" alt="<?php echo e($user->nickname); ?>" /></div>
   <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> <?php echo e($user->nickname); ?>  <?php if($user->is_vip): ?><span class="vip1">VIP<?php echo e($user->level); ?></span><?php else: ?><span class="vip1" style="background-color:#ccc;color:#fff;">普通用户</span> <?php endif; ?> </h2>
      <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;">个人说明： <?php echo e($user->personal_note); ?></p>
  
  
  <div class="home_nav">
    <ul>
      <li><a  href="/member">个人中心</a></li>
      <li><a href="/member/finder">我的发现</a></li>
      <li class="current"><a href="/member/collect">我的收藏</a></li>
      <li><a href="/member/subscription">我的订阅</a></li>
      <li><a href="/member/follow">我的关注</a></li>
      <li><a href="/member/point">我的积分</a></li>
      <li><a href="/member/profile">个人资料</a></li>
    </ul>
  </div>
</div>
<section class="wrapper">
  <div class="mt30 home_box">
    <div class="title">
      <h2 class="fl"><?php echo e(isset($folder_name) ? $folder_name : ''); ?></h2>
      
      <span class="fr"><a href="javascript:window.history.go(-1);" data-type="collect" >&lt; 返回</a></span> </div>
    <ul class="layout_ul ajaxposts">
      <div class="post_list">
        <ul>
          <?php $__currentLoopData = $user->collect_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li class="layout_li ajaxpost">
            <article class="postgrid">
            <span class="guojia" style="bottom: 60px;right: 60px;">
              <a href="#" rel="tag">加拿大</a>
            </span>
              <figure> <a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>" title="<?php echo e(get_article_title($article)); ?>" target="_blank"> <img class="thumb" src="<?php echo e(get_article_thum($article)); ?>" data-original="<?php echo e(get_article_thum($article)); ?>" alt="<?php echo e(get_article_title($article)); ?>" style="display: block;"> </a> </figure>
              <h2> <a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>" title="<?php echo e(get_article_title($article)); ?>" target="_blank">
                <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;"><?php echo e(get_article_title($article, 1)); ?></div>
                <div style=" color:#666; line-height:24px;"><?php echo e(get_article_title($article, 2)); ?></div>
                </a> </h2>
                <a href="javascript:;" class="find-icon-trash remove_find_img" data-id="<?php echo e($article->id); ?>" tag="删除发现的图片"></a> </div>
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
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <!-- 分页 --> 
      </div>
    </ul>
  </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>