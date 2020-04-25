<?php $__env->startSection('title'); ?>
  <?php echo e(trans('comm.yinji')); ?> - 个人中心 -积分中心
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
        <?php echo e($user->follow_num); ?>

      </li>
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
      <li><a href="/member/subscription">我的订阅</a></li>
      <li><a href="/member/follow">我的关注</a></li>
      <li class="current"><a href="/member/point">我的积分</a></li>
      <li><a href="/member/profile">个人资料</a></li>
    </ul>
  </div>
</div>
<style>
    .item .edit_favorites{
        position: absolute;
        display: inline-block;
        vertical-align: top;
        text-indent:0;
        text-align: center;
        line-height: 32px;
        z-index:120;
        right:10px;
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
        width:230px;
        vertical-align: top
    }
    .item .item-setting-btns{
        display: none;
        position: absolute;
        right: 0;
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
    top: 10px;
    width: 800px;
    margin-left: -350px;
    height: 720px;
    min-height:0;
    background: #fff;
    z-index: 999;
    padding: 10px;
    border-radius: 5px;
  }
    .sign_box{
        width: 610px;
        padding: 20px;
        min-height: 400px;
        height: 680px;
        position: fixed;
        z-index: 9999;
        background: #fff;
        top: 16%;
        left: 50%;
        margin-left: -305px;
        box-shadow: 0px 0px 5px rgba(0,0,0,3);
        border-radius: 3px;
        overflow: auto;
    }
    .change_box{
        display:none;
    }
    .pont-list ul{display: flex;flex-wrap:wrap}
    .pont-list ul li{width: 82px;height: 108px;position: relative;margin-right: 20px;text-align: center;border-radius: 5px;margin-bottom: 20px;cursor:pointer;}
    .pont-list ul li .point-kind{padding: 18px 0 8px 0}
    .pont-list ul li .point-num{background: #eeeeee;width: 45px;height: 45px;line-height: 45px;border-radius: 50%;display: inline-block}
    .pont-list ul li:first-child{margin-left: 0}
    .pont-list ul li div{
        position: absolute;
        left: 0;
        height: 0;
        width: 100%;
        height: 100%;
        border-radius: 5px;
        background: #f9f9f9;
        overflow: hidden;
        -webkit-transform-style: preserve-3d;
        -moz-transform-style: preserve-3d;
        -webkit-transition: .8s ease-in-out ;
        -moz-transition:  .8s ease-in-out ;
        -webkit-backface-visibility: hidden;
        -moz-backface-visibility: hidden
    }
    .pont-list ul li div:first-child{
        -webkit-transform: rotateY(0);
        -moz-transform: rotateY(0);
        z-index: 2;
    }

    .pont-list ul li div:last-child{
        -webkit-transform: rotateY(180deg);
        -moz-transform: rotateY(180deg);
        z-index: 1;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .pont-list ul li a{width: 100%;height: 100%;display: inline-block}
    .pont-list ul li a:hover div:first-child{
        -webkit-transform: rotateY(-180deg);
        -moz-transform: rotateY(-180deg);
    }
    .pont-list ul li a:hover div:last-child{
        background: #ff9c00;
        color: #fff;
        -webkit-transform: rotateY(0);
        -moz-transform: rotateY(0);
    }

  .img_browse .right{
    width:260px;
    overflow: auto;
    height: calc( 100% - 50px);
  }
</style>
<section class="wrapper">
  <div class="mt30 home_box">
    <div class="jifen_tj">
      <ul>
        <li class="ico_jftj01">
          <div class="tj_shuzi">
            <span class="point-title">我的积分</span>
            <p><?php echo e($user->points); ?></p>

          </div>
        </li>
        <li class="ico_jftj02">
          <div class="tj_shuzi">
            <span class="point-title">剩余积分</span>
            <p><?php echo e($user->left_points); ?></p>
           </div>
        </li>
        <li class="ico_jftj03">
             <div class="tj_shuzi">
                <span class="point-title">已用积分</span>
                <p><?php echo e($user->points - $user->left_points); ?></p>
            </div>
        </li>
        <li class="ico_jftj04">
          <div class="tj_shuzi">
            <span class="point-title">可下载次数</span>
            </div>
            <p class="down-show"><?php echo e($user->download_num); ?><span>免费下载次数</span></p><p class="down-show"><?php echo e($user->download_num - $user->use_download_num); ?><span>可下载次数</span></p>
        </li>
      </ul>
       <ul>
            <li class="ico_jftj-inner">
                <div class="tj_shuzi">
                    <span class="point-title-small">今日积分</span>
                    <div class="today-point"><?php echo e($today_point['today']); ?></div>
                    <div class="qiandao">
                        <p>
                            <span style="margin-left: 15px">签到：</span>
                            <?php if($today_point['attendance'] > 0): ?>
                                <?php echo e($today_point['attendance']); ?>/<?php echo e($today_point['attendance']); ?>

                            <?php else: ?>
                                <a href="javascript:void(0);" class="bookInSign"  style="color: #a6c4df">去签到</a>
                            <?php endif; ?>
                            
                        </p>
                        <p><span>点赞：</span><?php echo e($today_point['like']); ?>/10</p>
                        <p><span>留言：</span><?php echo e($today_point['comment']); ?>/20</p>
                    </div>
                </div>
                <div class="bar"><span class="bar-length" style="width: <?php echo e(($today_point['today']/$today_point['total'])*100); ?>%"></span><p><span><?php echo e($today_point['today']); ?></span>/<?php echo e($today_point['total']); ?></p></div>
            </li>
            <li class="ico_jftj-inner">
                <div class="tj_shuzi">
                    <span class="point-title">月度会员兑换</span>
                    <span class="point-duihuan activity">25+50积分兑换</span>
                </div>
            </li>
            <li class="ico_jftj-inner">
                <div class="tj_shuzi">
                    <span class="point-title">季度会员兑换</span>
                    <span class="point-duihuan">25+50积分兑换</span>
                </div>
            </li>
            <li class="ico_jftj-inner">
                <div class="tj_shuzi">
                    <span class="point-title">年度会员兑换</span>
                    <span class="point-duihuan">25+50积分兑换</span>
                </div>
            </li>
        </ul>
    </div>
    <div class="title">
      <h2 class="fl">积分记录</h2>
      
    </div>

      <div class="pont-list">
          <ul class="clearfix">

              <?php $__currentLoopData = $user->point_logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  
                      
                      
                      
                              
                          
                              
                          
                  
                  <li>
                      <a href="javascript:void(0)">
                          <div>
                              <p class="point-kind"><?php echo e($log->remark); ?></p>
                              <span class="point-num" style="<?php if(1 == $log->type): ?> color: #35d32d <?php else: ?> color: #fb8f5f" <?php endif; ?>> <?php if(1 == $log->type): ?>
                                      -<?php echo e($log->point); ?>

                                  <?php else: ?>
                                      +<?php echo e($log->point); ?>

                                  <?php endif; ?>
                            </span>
                          </div>
                          <div>
                              <?php echo e($log->created_at); ?>

                          </div>
                      </a>


                  </li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


          </ul>
      </div>
    
      
        
          
          
          
        
      
      

      
      
        
        
        
          
          
          
          
      
      
        

    
  </div>

    <div class="sign_box modal" id="bookInSign">
        <div class="sign_integral_box" style=" height:100px;">
            <div class="left integral" style="width:400px;">
                <div class="sign_ico left"></div>
                <h2 class="left">积分：<span id="user-point"><?php echo e($user->points); ?></span>分</h2>
                <p class="left" style="width:316px; margin-left:20px;">已连续签到<span id="last-day"><?php echo e(isset($last_days) ? $last_days : '0'); ?></span>天</p>
            </div>
            <a href="#" class="fr Button3 mt10" id="attendance">签到</a> </div>
        <div class="sign_tab">
            <ul>
                <li class="active record_tab">签到记录</li>
                <li class="change_tab">积分兑换</li>
            </ul>
        </div>
        <!------签到记录---------->
        <div class="record_box tab_box">
            <div class="record">
                <ul>
                    <?php $__currentLoopData = $tips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($loop->first && $last_days > 0): ?>
                            <li class="active"> <?php else: ?>

                            <li> <?php endif; ?>
                                <h3><?php echo e($tip['title']); ?></h3>
                                <p>+<?php echo e($tip['point']); ?></p>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <table width="100%" border="0" cellspacing="0" cellpadding="0" class="record_details">
                <tbody>
                <tr>
                    <th>用户名</th>
                    <th>获得积分</th>
                    <th>等级</th>
                    <th>签到时间</th>
                </tr>
                <tr>
                    <td colspan="4"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="record_details2">
                            <tbody>
                            <?php if($attendances): ?>
                                <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e(isset($attendance->user->nickname) ? $attendance->user->nickname : ''); ?></td>
                                        <td>+<?php echo e(isset($attendance->point) ? $attendance->point : ''); ?></td>
                                        <td>VIP<?php echo e(isset($attendance->vip_level) ? $attendance->vip_level : ''); ?></td>
                                        <td><?php echo e($attendance->created_at->toDateString()); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                            </tbody>
                        </table></td>
                </tr>
                </tbody>

            </table>
            <div class="shuomin">说明：连续签到可获得更多积 ，本站积分可增加下载次数和会员费用抵扣。<br>
                使用规则：即10积分=1元，每增加一次下载次数使用10积分！</div>
        </div>
        <!------签到记录结束---------->
        <!--------积分兑换--------->
        <div class="change_box tab_box">
            <div class="change">
                <ul>
                    <li><img src="../images/book.jpg" alt="商品图片">
                        <dl>
                            <dt>印际月度会员兑换</dt>
                            <dd><span>￥23.00+500</span>积分</dd>
                            <del>原价:28.00</del>
                        </dl>
                        <ul>
                            <li><a href="#" class="Button3">兑换</a></li>
                            <li>已<span>78</span>人兑换</li>
                        </ul>
                    </li>
                    <li><img src="../images/book.jpg" alt="商品图片">
                        <dl>
                            <dt>印际季度会员兑换</dt>
                            <dd><span>￥76.00+1200</span>积分</dd>
                            <del>原价:88.00</del>
                        </dl>
                        <ul>
                            <li><a href="#" class="Button3">兑换</a></li>
                            <li>已<span>78</span>人兑换</li>
                        </ul>
                    </li>
                    <li><img src="../images/book.jpg" alt="商品图片">
                        <dl>
                            <dt>印际年度会员兑换</dt>
                            <dd><span>￥250.00+3000</span>积分</dd>
                            <del>原价:288.00</del>
                        </dl>
                        <ul>
                            <li><a href="#" class="Button3">兑换</a></li>
                            <li>已<span>78</span>人兑换</li>
                        </ul>
                    </li>
                </ul></div>
        </div>
    </div>
        <!--------积分兑换结束--------->
</section>
<script src="/js/layer.js"></script> 
<script src="/js/member.js"></script> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>