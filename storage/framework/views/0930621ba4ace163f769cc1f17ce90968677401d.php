<?php $__env->startSection('title'); ?>
  <?php echo e(trans('comm.yinji')); ?> -  TA <?php echo e(trans('index.collection')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<style>
  body{background:#f8f8f8 !important;}
  .home_box{border-radius:10px !important;}
  .home_top{background:#fff !important;}
  .item .edit_favorites{
        position: absolute;
    display: inline-block;
    vertical-align: top;
    text-indent: 0;
    text-align: center;
    line-height: 32px;
    z-index: 120;
    right: 120px;
    top: 34%;
  }
  .edit_favorites:hover .item-setting-btns{
      color:#555;
  }
  .find_title{
      overflow:inherit;
      position:relative;
  }
  .find_title h2{
      float: none;
      width:200px;
      vertical-align: top
  }
  .item .item-setting-btns{
      display: none;
      position: absolute;
      right:-35px;
      background: #fff;
      border-radius: 4px;
      width: 90px;
      padding: 3px 0px;
      text-align: center;
      font-size: 12px;
      box-shadow: 0 0 11px rgba(0,0,0,.1);
      top:40px;
      margin-bottom: 4px;
  }

  .item.selected .item-setting-btns{
      display: block;
  }
  .modal{
    display:none;
  }
  .img_browse{
    position: fixed;
    left: 50%;
    top: 50%;
    width: 800px;
    margin-left: -350px;
    margin-top: -350px;
    height: 720px;
    min-height:0;
    background: #fff;
    z-index: 999;
    padding: 10px;
    border-radius: 5px;
  }
  .img_browse .right{
    width:260px;
    height: 100%;
  }
  .img_browse .right .head img{
    width:100%;
    height: 100%;
  }
  .img_browse .right .faxian_info{
    margin-top: 10px;
  }
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
        <li><a  href="/member/<?php echo e($users->id); ?>"><?php echo e(trans('index.home_page')); ?></a></li>
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
      <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'>TA <?php echo e(trans('index.collection')); ?></span></h2>
    </div>
    <div class="masonry" > <?php $__currentLoopData = $users->collects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collect): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="item">
        <div class="item__content" style="position:relative">
          <ul  onclick="location.href='/member/hp_collect_detail/<?php echo e($users->id); ?>/<?php echo e($collect['folder']['id']); ?>'">
            <?php $__currentLoopData = $collect['collect']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img_obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($img_obj['img']): ?>
                    <li><a href="/member/hp_collect_detail/<?php echo e($users->id); ?>/<?php echo e($collect['folder']['id']); ?>"><img src="<?php echo e($img_obj['img']); ?>" /></a></li>
                  <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
          <!-- <div class="edit_favorites fr" folder-type="collect" data-id="">编辑</div> -->
          <div class="find_title">
            <h2><a><?php echo e($collect['folder']['name']); ?></a></h2>
            <div class="collection_images">  <i class="icon-eye-off" title="不公开"></i> <?php echo e($collect['folder']['total']); ?></div>
          </div>
          
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </div>
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