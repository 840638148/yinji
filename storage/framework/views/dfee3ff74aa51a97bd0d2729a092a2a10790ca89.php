<?php $__env->startSection('title'); ?>
  <?php echo e(trans('comm.yinji')); ?> - 个人中心 - 收藏中心
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
<style>
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
<section class="wrapper">
  <div class="mt30 home_box">
    <div class="title">
      <h2 class="fl">我的收藏</h2>
      <span class="fr"><a href="javascript:;" data-type="collect" class="create-new-folder">+ 创建新文件</a></span> </div>
    <div class="masonry" > <?php $__currentLoopData = $user->collects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collect): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="item">
        <div class="item__content" style="position:relative">
          <ul  onclick="location.href='/member/collect_detail/<?php echo e($collect['folder']['id']); ?>'">
            <?php $__currentLoopData = $collect['collect']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img_obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($img_obj['img']): ?>
                    <li><a><img src="<?php echo e($img_obj['img']); ?>" /></a></li>
                  <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
          <div class="edit_favorites fr" folder-type="collect" data-id="<?php echo e($collect['folder']['id']); ?>">编辑</div>
          <div class="find_title">
            <h2><a><?php echo e($collect['folder']['name']); ?></a></h2>
            <div class="collection_images">  <i class="icon-eye-off" title="不公开"></i> <?php echo e($collect['folder']['total']); ?></div>
          </div>
          
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </div>
  </div>
</section>

<!--创建收藏文件夹-->
<div class="create_folder modal" id="collectionFolders">
  <div class="create_folder_title">
    <h2>编辑文件夹</h2>
  </div>
  <div class="close" onclick="layer.closeAll();">关闭</div>
  <input type="text" value=""  placeholder="收藏夹名称（必填）" class="mt30" name="edit_folder_name" id="edit_folder_name"/>
  <textarea name="edit_brief" id="edit_brief" placeholder="简介"  rows="5" class="mt30 folder_introduction"></textarea>
  <p class="mt30">
    <input name="edit_is_open" type="radio" value="1" checked="checked" />
    公开
    <input name="edit_is_open" type="radio" value="0" />
    不公开 </p>
  <div class="error_msg"></div>
  <div class="create_button">
    <input type="hidden" name="edit_folder_type" id="edit_folder_type" />
    <input type="hidden" name="edit_folder_id" id="edit_folder_id" />
    <input type="button" value="取消" class="button_gray concle-create-folder " onclick="layer.closeAll();" />
    <input type="button" value="确定" class="button_red edit_folder_btn"/>
  </div>
</div>

<!--收藏夹图片浏览-->
<div class="img_browse modal" id="img-browse" >
  <div class="close">关闭</div>
  <div class="left">
    <div style="height:48px;">
      <h2 class="fl">文件夹名称333</h2>
      <span class="fr">分享到：</div>
    <div class="image"><img src="images/imges.jpg" alt="发现的图片" class="selected-image"/> </div>
  </div>
  <div class="right" style="margin-top:48px;">
    <div class="more_img"> <a href="#" class="more-img-item selected"><img src="images/imges.jpg" alt="图片一" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/ad_05.gif" alt="图片一" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/design_16-03.gif" alt="图片二" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/about_img.jpg" alt="图片一" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/ad_22.gif" alt="图片二" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/ad_05.gif" alt="图片一" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/design_16-03.gif" alt="图片二" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/about_img.jpg" alt="图片一" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/ad_22.gif" alt="图片二" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/ad_05.gif" alt="图片一" />
      <div class="cover"></div>
      </a> <a href="#" class="more-img-item"><img src="images/design_16-03.gif" alt="图片二" />
      <div class="cover"></div>
      </a> </div>
    <hr />
    <div class="discoverer">
      <div class="head"><img src="images/design_16-03.gif" alt="头像" /></div>
      <h2><a href="#">大仁哥1027</a> <span class="vip1">VIP</span></h2>
      <a class="Button">关注</a> </div>
    <hr />
    <div class="faxian_info">
      <p>从 <a href="#">严PPPPPPPP1</a> 收藏于 <a href="#">大厅</a></p>
      <p>2017-06-02 14:59:57</p>
      <p class="laiyuan"><a href="#">来源：Lera Brumina作品 | 80㎡ Apartmen...</a></p>
    </div>
  </div>
</div>
<!--发现图片浏览结束--> 

<!--创建收藏文件夹-->
<div class="create_folder modal" id="newFolders">
  <div class="create_folder_title">
    <h2>创建文件夹</h2>
  </div>
  <div class="close" onclick="layer.closeAll();">关闭</div>
  <input type="text" value=""  placeholder="收藏夹名称（必填）" class="mt30" name="folder_name" id="add_folder_name"/>
  <textarea name="brief" id="add_brief" placeholder="简介"  rows="5" class="mt30 folder_introduction"></textarea>
  <p class="mt30">
    <input name="add_is_open" id="add_is_open" type="radio" value="1" checked="checked" />
    公开
    <input name="add_is_open" type="radio" value="0" />
    不公开</p>
  <div class="error_msg"></div>
  <div class="create_button">
    <input type="hidden" name="folder_type" id="add_folder_type" />
    <input type="button" value="取消" class="button_gray concle-create-folder " onclick="layer.closeAll();" />
    <input type="button" value="确定" class="button_red add_folder_btn"/>
  </div>
</div>
<script src="/js/layer.js"></script> 
<script src="/js/member.js"></script> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>