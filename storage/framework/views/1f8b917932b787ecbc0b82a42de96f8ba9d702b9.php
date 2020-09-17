<?php $__env->startSection('title'); ?>
    <?php echo e(trans('comm.yinji')); ?> - 地产公司介绍
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section><img src="/images/company_banner.jpg"  alt="地产" /></section>


<div class="company_bj1">
  <div class="wrapper">
    <div class="company_left"> <img src="/images/logo_27-04.jpg" alt="万科" />
      <div class="company_ico"><a href="#"><i class="icon-sun"></i> </a><a href="#"><i class="icon-qq"></i> </a><a href="#"><i class="icon-skype"></i> </a></div>
    </div>
    <div class="company_right">
      <h1>公司简介/Company Profile</h1>
      <div class="company_Profile" style='height:340px;overflow: hidden;'><?php echo get_dc_intro($lists); ?></div>
    </div>
  </div>
</div>

<div class="company_bj2" >
    <div class="wrapper">
        <div class="company_luopan">
            <ul>
                <li><div class="index_dafen"><i>9.0</i></div><img src="/images/dc_01.jpg" alt="111" /><span class="guojia cs"><a href="#" rel="tag">广州</a></span></li>
                <li><div class="index_dafen"><i>9.0</i></div><img src="/images/dc_01.jpg" alt="111" /><span class="guojia cs"><a href="#" rel="tag">广州</a></span></li>
                <li><div class="index_dafen"><i>9.0</i></div><img src="/images/dc_01.jpg" alt="111" /><span class="guojia cs"><a href="#" rel="tag">广州</a></span></li>
            </ul>
        </div>
        <div class="fr company_button">
            <h1>1/5</h1>
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
                    <dt>大标题大标题大标题大标题</dt>
                    <dd>万科企业股份有限公司成立于1984年，经过三十余年的发展，已成为国内领先的城乡建设与生活服务商，公司业务聚焦全国经济最具活力的三大经济圈及中西部重点城市。2016年公司首次跻身《财富》“世界500强”，位列榜单第356位，2017年、2018、2019年接连上榜，分别位列榜单第307位、第332位、第254位万科企业股份有限公司成立于1984年，经过三十余年的发展，已成为国内领先的城乡建设与生活服务商，公司业务聚焦全国经济最具活力的三大经济圈及中西部重点城市。2016年公司首次跻身《财富》“世界500强”，位列榜单第356位，2017年、2018、2019年接连上榜，分别位列榜单第307位、第332位、第254位。</dd>
                </dl>
                <dl>
                    <dt>大标题大标题大标题大标题</dt>
                    <dd>万科企业股份有限公司成立于1984年，经过三十余年的发展，已成为国内领先的城乡建设与生活服务商，公司业务聚焦全国经济最具活力的三大经济圈及中西部重点城市。2016年公司首次跻身《财富》“世界500强”，位列榜单第356位，2017年、2018、2019年接连上榜，分别位列榜单第307位、第332位、第254位。</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
<!-------地产集团介绍结束------->




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>