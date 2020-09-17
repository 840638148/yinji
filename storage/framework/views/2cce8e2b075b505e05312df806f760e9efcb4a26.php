<?php $__env->startSection('title'); ?>

  <?php echo e(trans('comm.yinji')); ?> - <?php echo e(trans('index.home')); ?> - <?php echo e(trans('index.down_center')); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<style>
body{background:#f8f8f8 !important;}
.home_box{border-radius:10px !important;}
.home_top{background:#fff !important;}
</style>
<div class="home_top">
  <div class="home_banber"> <img src="/images/home_bj.jpg" alt="个人主页图片" /></div>
  <div class="home_tongji">
  <ul>
      <li><?php echo e(trans('index.discovery')); ?></br>
        <?php echo e($user->finder_num); ?> </li>
      <li> <?php echo e(trans('index.collection')); ?></br>
        <?php echo e($user->collect_num); ?> </li>
      <li> <?php echo e(trans('index.subscription')); ?></br>
        <?php echo e($user->subscription_num); ?> </li>
      <li> <?php echo e(trans('index.follow')); ?></br>
        <?php echo e($user->follow_num); ?> </li>
    </ul>
  </div>
  <div class="home_personal"> <img src="<?php if($user->avatar): ?> <?php echo e($user->avatar); ?> <?php else: ?> /img/avatar.png <?php endif; ?>" alt="<?php echo e($user->nickname); ?>" />
  </div>
  <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> <?php echo e($user->nickname); ?> <img src="<?php echo e($user->vip_level); ?>" alt=""></h2>
  <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;"><?php echo e(trans('index.personal_description')); ?>： <?php echo e($user->personal_note); ?></p>
  <div class="home_nav">
    <ul>
        <li><a href="/member"><?php echo e(trans('index.home')); ?></a></li>
	      <li><a href="/member/finder"><?php echo e(trans('index.my_finder')); ?></a></li>
	      <li><a href="/member/collect"><?php echo e(trans('index.my_collection')); ?></a></li>
	      <li><a href="/member/subscription"><?php echo e(trans('index.my_subscription')); ?></a></li>
	      <li><a href="/member/follow"><?php echo e(trans('index.my_interactive')); ?></a></li>
	      <li class="current"><a href="/member/mydown"><?php echo e(trans('index.my_download')); ?></a></li>
	      <li><a href="/member/profile"><?php echo e(trans('index.the_personal_data')); ?></a></li>
    </ul>
  </div>
</div>
<section class="wrapper">
  <div class="mt30 home_box" style='float:left;width: 100%;'>
    <!-- 我的下载 -->
    <div class="title  mt30">
      <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'><?php echo e(trans('index.my_download')); ?></span></h2><b style=" font-size:12px; float:right;color:#f60; line-height:48px;">（<?php echo e(trans('index.tips')); ?>）</b>
    </div>



    <ul class="layout_ul ajaxposts">
      <div class="post_list">
        <ul>
        <?php $__currentLoopData = $down; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li class="layout_li ajaxpost">
            <article class="postgrid">
              <figure> <a href="/article/<?php echo e($v->static_url); ?>" target="_blank"><img src="/uploads/<?php echo e($v->custom_thum); ?>" alt="<?php echo e($v->title_designer_cn); ?> - <?php echo e($v->title_name_cn); ?>"></a></figure>
              <p style="height:30px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap; width:320px;text-indent:10px"> <?php echo e(trans('index.download_address')); ?>：<a href="<?php echo e(mb_substr($v->vip_download,0,-10)); ?>" target="_blank"><?php echo e(mb_substr($v->vip_download,0,-10)); ?></a></p>
              <p style='position: relative;text-indent:10px;'><?php echo e(trans('index.extract_the_code')); ?>：
                <input title='点我复制' class='copybtn' style='padding: 0 5px 0;background: #ccc;border-radius: 5px;cursor: pointer;border:none;width:45px;' onclick="copybtn(this)" readonly value='<?php echo e(mb_substr($v->vip_download,-4)); ?>'></p>
              <p style='text-indent:10px;'><?php echo e(trans('index.expiration_time')); ?>：<span style="color:#f60;"><?php echo e($v->guoqitime); ?></span></p>
            </article>
          </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <!-- 分页 --> 
      </div>
    </ul>














    <!-- 我的下载结束 -->
  </div>
</section>

<script type="text/javascript" src="/js/dist/clipboard.min.js"></script>	
<script>
function copybtn(obj){
  let con=document.getElementById("tqmm");
  obj.select(); // 选择对象
  document.execCommand("Copy"); // 执行浏览器复制命令
  // console.log(con);
  layer.msg('复制成功',{time: 1500,skin: 'intro-login-class layui-layer-hui'});
}


</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>