<?php $__env->startSection('title'); ?>



    <?php echo e(trans('comm.yinji')); ?>- 广告合作



<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="about_bj"></div>

<div class="about_nav">

  <ul>

    <li ><a href="/vip/promotion">文章推广</a></li>

    <li class="current"><a href="/vip/ad">广告合作</a></li>

    <!--<li><a href="vip_service.html">会员服务</a></li>-->
    <li><a href="/vip/vip_service">会员服务</a></li>

    <li><a href="/vip/job_service.">招聘服务</a></li>

  </ul>

</div>

<div class="about_box">

  <section class=" wrapper box_dj">

    <div class="" style="border-bottom:1px solid #ddd; padding-bottom:30px;font-size:18px;">&nbsp;&nbsp;&nbsp;&nbsp;购买广告位请联系<a href="#">AD@yinjispace.com </a> 请在邮箱中留下联系人，电话，公司名称以及主要需求。若工作日24小时内没有及时处理您的请求，请投诉<a href="#">CO@yinjispace.com</a></div>

    <img src="/images/ad_03.jpg" alt="广告位"  /> <img src="/images/ad_05.jpg" alt="广告位" /> <img src="/images/ad_06.jpg" alt="广告位" /></section>

</div>

<!-- 版权 -->





<?php $__env->stopSection(); ?> 

<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>