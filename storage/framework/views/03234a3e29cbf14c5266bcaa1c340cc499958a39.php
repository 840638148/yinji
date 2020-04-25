<?php $__env->startSection('title'); ?>

  <?php echo e(trans('comm.yinji')); ?> - 个人中心 -订阅中心

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
      <li> 积分</br>
        <?php echo e($user->points); ?> </li>
      <li> 关注</br>
        <?php echo e($user->follow_num); ?> </li>
    </ul>
  </div>
  <div class="home_personal"> <img src="<?php if($user->avatar): ?> <?php echo e($user->avatar); ?> <?php else: ?> /img/avatar.png <?php endif; ?>" alt="<?php echo e($user->nickname); ?>" />
  </div>
  <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> <?php echo e($user->nickname); ?>  <?php if($user->is_vip): ?><span class="vip1">VIP<?php echo e($user->vip_level); ?></span><?php else: ?><span class="vip1" style="background-color:#ccc;color:#fff;">普通用户</span> <?php endif; ?> </h2>
  <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;">个人说明： <?php echo e($user->personal_note); ?></p>
  <div class="home_nav">
    <ul>
      <li><a  href="/member">个人中心</a></li>
      <li><a href="/member/finder">我的发现</a></li>
      <li><a href="/member/collect">我的收藏</a></li>
      <li class="current"><a href="/member/subscription">我的订阅</a></li>
      <li><a href="/member/follow">我的关注</a></li>
      <li><a href="/member/point">我的积分</a></li>
      <li><a href="/member/profile">个人资料</a></li>
    </ul>
  </div>
</div>
<section class="wrapper">
  <div class="mt30 home_box">
    <div class="title">
      <h2>我的订阅</h2>
    </div>
    
    <!----------设计师订阅------->
    
    <div class="public_list"> <?php $__currentLoopData = $user->subscriptions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subscription): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="public_item" data-id="<?php echo e($subscription->id); ?>">
        <div class="item_left"> <a href="<?php if($subscription->static_url): ?> /designer/<?php echo e($subscription->static_url); ?> <?php else: ?> /designer/detail/<?php echo e($subscription->id); ?> <?php endif; ?>">
          <div class="tx"> <img src="<?php echo e(get_designer_thum($subscription)); ?>" alt="<?php echo e(get_designer_title($subscription)); ?>"> </div>
          </a>
          <div class="item_msg">
            <div class="title"> <a href="<?php if($subscription->static_url): ?> /designer/<?php echo e($subscription->static_url); ?> <?php else: ?> /designer/detail/<?php echo e($subscription->id); ?> <?php endif; ?>"> <?php echo e(get_designer_title($subscription)); ?> </a> </div>
            <div class="describe"> <span>国家：
              
              <?php $__currentLoopData = $subscription->categorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              
              <?php if($loop->last): ?>
              
              <?php echo e($category['name']); ?>

              
              <?php else: ?>
              
              <?php echo e($category['name']); ?>,
              
              <?php endif; ?>
              
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </span> <span><?php echo get_designer_description($subscription); ?></span> </div>
            <div class="focus"> <a href="javascript:void(0)" data-id="<?php echo e($subscription->id); ?>" class="focus_btn2 click cancelSubscription"> 取消订阅 </a>
              <div class="focus_msg"> <span>作品：<?php echo e($subscription->article_num); ?></span> | <span>粉丝：<?php echo e($subscription->fans_num); ?></span> </div>
            </div>
          </div>
        </div>
        <div class="item_right"> <?php $__currentLoopData = $subscription->articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="works" data-id="1722"> <a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>" target="_blank"> <img src="<?php echo e(get_article_thum($article)); ?>" alt=""> <span><?php echo e(get_article_title($article)); ?></span> </a> </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </div>
    
    <!----------设计师订阅结束-------> 
    
  </div>
</section>
<script type="text/javascript">

    $(document).ready(function(){



      //取消订阅

      $(".cancelSubscription").click(function(e){



        var designer_id = $(this).attr('data-id');

        $.ajax({

          url: '/member/cancel_subscription',

          type: 'POST',

          dataType: 'json',

          data: {_token:'<?php echo e(csrf_token()); ?>',designer_id:designer_id},

          success: function (data) {

            if (data.status_code == 0) {

              window.location.reload();

            } else {

              alert(data.message);



            }

          }

        });



      });

    });

  </script> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>