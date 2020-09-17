<?php $__env->startSection('title'); ?>
    <?php echo e(trans('comm.yinji')); ?> - 地产介绍
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>


<style>
.swiper-slide{margin-right:20px !important;}
.swiper-pagination-fraction{bottom: unset;left: unset; width: unset;}
.swiper-pagination{position: unset;}
</style>


<section><img src="/uploads/<?php echo e($lists->bgimg); ?>"  alt="地产" /></section>


<div class="company_bj1">
  <div class="wrapper">
    <div class="company_left"> <img src="/uploads/<?php echo e($lists->logoimg); ?>" alt="万科" />
      <div class="company_ico"><a href="<?php echo e($lists->url1); ?>" target='_blank'><i class="icon-sun"></i> </a><a href="<?php echo e($lists->url2); ?>" target='_blank'><i class="icon-qq"></i> </a><a href="<?php echo e($lists->url3); ?>" target='_blank'><i class="icon-skype"></i> </a></div>
    </div>
    <div class="company_right">
      <h1>公司简介/Company Profile</h1>
      <div class="company_Profile" style='height:340px;overflow: hidden;'><?php echo get_dc_intro($lists); ?></div>
    </div>
  </div>
</div>

<div class="company_bj2" >
    <div class="wrapper">
        <div class="company_luopan swiper-container">
            <ul class='swiper-wrapper'>
                <?php $__currentLoopData = $articlelist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $alist): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class='swiper-slide'><div class="index_dafen"><i><?php echo e(sprintf("%.1f",$alist->lpavg)); ?></i></div><a href="/lpintro/<?php echo e($alist->id); ?>" title='<?php echo e($alist->name); ?>' target='_blank'><img style='width:100%;height:420px;' src="/uploads/<?php echo e($alist->bgimg); ?>" alt="111" /></a><span class="guojia cs"><a href="/details/<?php echo e($alist->id); ?>" target='_blank' rel="tag"><?php echo e($alist->area); ?></a></span></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <!-- <li><div class="index_dafen"><i>9.0</i></div><img src="/images/dc_01.jpg" alt="111" /><span class="guojia cs"><a href="#" rel="tag">广州</a></span></li> -->
                <!-- <li><div class="index_dafen"><i>9.0</i></div><img src="/images/dc_01.jpg" alt="111" /><span class="guojia cs"><a href="#" rel="tag">广州</a></span></li> -->
                
            </ul>
        </div>
        <div class="fr company_button">
            <h1 class='swiper-pagination'></h1>
            <div class="swiper-button-next1 icon-angle-right"></div>
            <div class="swiper-button-prev1 icon-angle-left"></div>
        </div>
        
        <div class="wrapper">
            <div class="company_contact" >
                <h2><?php echo e(get_dc_name($lists)); ?></h2>
                <p>地址：<?php echo e(get_dc_address($lists)); ?></p>
                <p>电话：<?php echo e($lists->tel); ?></p>
                <p>传真：<?php echo e($lists->fax); ?></p>
                <p>邮箱：<?php echo e($lists->email); ?></p>
                
            </div>
            <div class="company_news">
                <dl>
                    <dt>标题一</dt>
                    <dd><?php echo e($lists->title); ?></dd>
                </dl>
                <dl>
                    <dt>标题二</dt>
                    <dd><?php echo e($lists->title1); ?></dd>
                </dl>
            </div>
        </div>
    </div>
</div>
<!-------地产集团介绍结束------->
<script src="/js/swiper-bundle.min.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 3,
        spaceBetween: 30,
        slidesPerGroup: 3,
        loop: true,
        loopFillGroupWithBlank: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
            type: 'fraction',
        },
        navigation: {
            nextEl: '.swiper-button-next1',
            prevEl: '.swiper-button-prev1',
        },
        
    });

    
</script>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>