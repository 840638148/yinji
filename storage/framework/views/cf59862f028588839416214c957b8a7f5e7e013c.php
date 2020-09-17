<?php $__env->startSection('title'); ?>
  <?php echo e(trans('comm.yinji')); ?> - TA Home Page
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
    right: 123px;
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
  .img_browse{
    position: fixed;
    left: 50%;
    top:50%;
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
    height: calc( 100% - 50px);
  }
  .lzcfg{
    background: rgba(0,0,0,0.5);
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    display: none;
    z-index: 999;
  }
  .replyBox{
    background: #fff;
    width: 100%;
    float: left;
    margin-bottom: 20px;
    border-bottom: 1px solid #eee;
  }
  .replyBox:hover{
    background: #f8f8f8;
    cursor: pointer;
  }
  .replyBox dl{
    min-height: 60px;
    float: left;
    width: 100%;
  }
  .replyBox dt{
    width: 50px;
    height: 50px;
    float: left;
    margin-top: 10px;
    border-radius: 25px;
    overflow: hidden;
  }
  .replyBox dd{
    float: right;
    width: 93%;
    height: 36px;
    line-height: 36px;
    font-size: 16px;
    font-family: "微软雅黑";
  }
  .replyBox .msgTxt{
    float: right;
    width: 93%;
    font-size: 14px;
    color: #999;
    padding: 5px 0;
    min-height: 36px;
    line-height: 24px;
  }
</style>
<!--笼罩层-->
<div class="lzcfg"></div>
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
	      <li class="current"><a  href="/member/<?php echo e($users->id); ?>"><?php echo e(trans('index.home_page')); ?></a></li>
	      <li><a href="/member/homepage_finder/<?php echo e($users->id); ?>"><?php echo e(trans('index.discovery')); ?></a></li>
	      <li><a href="/member/homepage_collect/<?php echo e($users->id); ?>"><?php echo e(trans('index.collection')); ?></a></li>
	      <li><a href="/member/homepage_subscription/<?php echo e($users->id); ?>"><?php echo e(trans('index.subscription')); ?></a></li>
	      <li><a href="/member/homepage_interactive/<?php echo e($users->id); ?>"><?php echo e(trans('index.follow')); ?></a></li>
	      <li><a href="/member/homepage_fans/<?php echo e($users->id); ?>"><?php echo e(trans('index.fans')); ?></a></li>
    </ul>
  </div>
</div>
<section class="wrapper" style='width:1245px;'>
  <div class="mt30 home_box">
    <!-- TA的发现 -->
    <div class="title">
      <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'>TA <?php echo e(trans('index.discovery')); ?></span></h2>
      <span class="fr"><a href="/member/homepage_finder/<?php echo e($users->id); ?>"><?php echo e(trans('index.more')); ?></a></span>
    </div>
    <div class="masonry" style='height:350px;width: 1200px;overflow: hidden;'>
        <?php $__currentLoopData = $users->finders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$finder): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div class="item collection-item " data-id="<?php echo e($finder['folder']['id']); ?>" onclick="location='/member/hp_finder_detail/<?php echo e($users->id); ?>/<?php echo e($finder['folder']['id']); ?>'">
                <div class="item__content">
                  <ul data-id="<?php echo e($finder['folder']['id']); ?>" 	>
                    <?php $__currentLoopData = $finder['finder']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img_obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php if($img_obj['img']): ?>
                            <li><a href="/member/hp_finder_detail/<?php echo e($users->id); ?>/<?php echo e($finder['folder']['id']); ?>"><img src="<?php echo e($img_obj['img']); ?>" /></a></li>
                          <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
                  <div class="find_title">
                    <h2><a><?php echo e($finder['folder']['name']); ?></a></h2>
                   <div class="find_images"> <i class="icon-eye" title="公开"></i> <?php echo e($finder['folder']['total']); ?></div>
                   </div>
                </div>
              </div>
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <!-- TA的发现end -->

    <!-- TA的收藏 -->
    <div class="title">
      <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'>TA <?php echo e(trans('index.collection')); ?></span></h2>
      <span class="fr"><a href="/member/homepage_collect/<?php echo e($users->id); ?>"><?php echo e(trans('index.more')); ?></a></span>
    </div>
    <div class="masonry my-collection"  style='height:350px;width: 1200px;overflow: hidden;'>   
      <?php $__currentLoopData = $users->collects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $collect): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="item collection-item " data-id="<?php echo e($collect['folder']['id']); ?>" onclick="location='/member/hp_collect_detail/<?php echo e($users->id); ?>/<?php echo e($collect['folder']['id']); ?>'">
        <div class="item__content">
          <ul data-id="<?php echo e($collect['folder']['id']); ?>" >
            <?php $__currentLoopData = $collect['collect']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img_obj): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><a href="/member/hp_collect_detail/<?php echo e($users->id); ?>/<?php echo e($collect['folder']['id']); ?>"><img src="<?php echo e($img_obj['img']); ?>" /></a></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </ul>
          <div class="find_title">
            <h2><a><?php echo e($collect['folder']['name']); ?></a></h2>
          <div class="collection_images">  <i class="icon-eye" title="公开"></i> <?php echo e($collect['folder']['total']); ?></div>
          </div>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <!-- TA的收藏end -->

    <!-- TA的关注 -->
    <div class="title mt30">
      <div class="title">
        <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'>TA <?php echo e(trans('index.follow')); ?></span></h2>
      </div>
    </div>
    <div class="designer">
      <ul>
        <?php $__currentLoopData = $users->follows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $follow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($key < 13): ?>
                <li class="guanzhu-item"> <a href="/member/<?php echo e($follow->id); ?>" title="<?php echo e($follow->nickname); ?>" onclick="selectItemGuanZhu(<?php echo e($key); ?>)"><span class="select-item"></span>  <img onerror="this.onerror=``;this.src=`/img/avatar.png`" src="<?php if($follow->avatar): ?> <?php echo e($follow->avatar); ?> <?php else: ?> /img/avatar.png <?php endif; ?>" alt="<?php echo e($follow->nickname); ?>" /> </a> </li>
            <?php elseif($key == 13): ?>
                <li><a href="/member/homepage_interactive/<?php echo e($users->id); ?>" class="more-content"></a></li>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
    <!-- TA的关注end -->
  </div>
</section>
  <!-- TA的访客 -->
<section class="wrapper" style='width:1245px;'>
  <div class="mt30 home_box">
    
    <div class="title mt30" style='position:relative;border:unset !important;'>
      <div class="title" style="border:unset !important;">
        <h2 class="fl" style='width: 33%;border-bottom: 1px solid #eee;line-height: 40px;'><?php echo e(trans('index.visitors')); ?></h2>
        <h2 class="fr" style='width: 65%;border-bottom: 1px solid #eee;line-height: 40px;'><?php echo e(trans('index.comments')); ?>：<span style='position:absolute;top:0;right:0%;font-size:12px;color:#9E9E9E;'>共<?php echo e($commentsum); ?>条评论，访客：<?php echo e($messagenum); ?>条，博主：<?php echo e($replynum); ?>条</span></h2>
      </div>
    </div>
    <div class='designer' style='width:30%;float:left;height:400px;height:400px;'>
      <ul>
        <?php $__currentLoopData = $visited; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $follow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="guanzhu-item" style='margin-bottom:10px;text-align: center;'>
              <a href="/member/<?php echo e($follow->user_id); ?>" ><span class="select-item"></span>  
              <img onerror="this.onerror=``;this.src=`/img/avatar.png`" src="<?php if($follow->avatar): ?> <?php echo e($follow->avatar); ?> <?php else: ?> /img/avatar.png <?php endif; ?>" alt="<?php echo e($follow->nickname); ?>" /> </a> 
              <span><?php echo e($follow->created_at->diffForHumans()); ?></span>

            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </ul>
    </div>
    
    <div class='fkright' style='width:65%;float:right;'>
        <div class="msgCon"> 
          <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="msgBox cons" onclick='getID(this)' data-id='<?php echo e($comment->user_id); ?>'>
            <dl>
                <dt><img style='width:100%;height:100%;' src="<?php echo e($comment->avatar); ?>"></dt>
                <dd>
                    <span style="float:left;margin-left:10px;"><?php echo e($comment->nickname); ?>

                        <img src="<?php echo e(App\User::getVipLevel($comment->user_id)); ?>" alt="">
                    </span>
                    <span>发布于：<?php echo e($comment->created_at); ?></span>
                </dd>
                <div class="msgTxt" style='padding-left:10px;'><?php echo $comment->content; ?></div>
            </dl>
          </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 

          <?php $__currentLoopData = $reply; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="replyBox cons" onclick='getID(this)' data-id='<?php echo e($user->id); ?>'>
            <dl>
                <dt><img style='width:100%;height:100%;' src="<?php echo e($v->avatar); ?>"></dt>
                <dd>
                    <span style="float:left;margin-left:10px;"><?php echo e($v->nickname); ?>

                        <img src="<?php echo e(App\User::getVipLevel($v->user_id)); ?>" alt="">
                    </span>
                    <span style='font-size: 12px;color: #999;float: right;'>发布于：<?php echo e($v->created_at); ?></span>
                </dd>
                <div class="msgTxt" style='padding-left:10px;'>回复<?php echo e($v->reply_nickname); ?>：<?php echo $v->content; ?></div>
            </dl>
          </div> 
        
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         </div>
        <div class='fbpl'>
          <h2><span><?php echo e(trans('index.comment')); ?></span></h2>
          
          <textarea style="resize:none;" name="con" id="con" cols="30" rows="10"></textarea>
          <span class='fbbtn' style='display: inline-block;padding: 10px 20px;background: #000;color: #fff;margin: 20px 0;cursor: pointer;'><?php echo e(trans('index.published')); ?></span>
          <span class='hfbtn' style='display: none;padding: 10px 20px;background: #000;color: #fff;margin: 20px 0;cursor: pointer;'>回复评论</span>
        </div> 
        
    </div>
    <div style='clear:both;'></div>
  </div>
</section>


<script> 
  function getID(obj){
    comment_ids = $(obj).attr('data-id');console.log(comment_ids)
  }

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

  //统计访问
  $(function(){

    let urls=window.location.href;
    let uid=urls.split('/')[4];
    $.ajax({
        url: '/member/visited_hp',
        type: 'POST',
        dataType: 'json',
        data: {_token:'<?php echo e(csrf_token()); ?>',uid:uid},
        success: function (data) {
          //
        }
    });
  })
  
  //发表评论
  $('.fbbtn').click(function(){
    let con=$('#con').val();
    let urls=window.location.href;
    let comment_id=urls.split('/')[4];
    let type=2;
    console.log(comment_id)
    if(con==''||con==null||con==undefined){
      layer.msg('评论不能为空',{skin: 'intro-login-class layui-layer-hui'});
      return false;
    }
    $.ajax({
        url: '/member/homepage_messages',
        type: 'POST',
        dataType: 'json',
        data: {_token:'<?php echo e(csrf_token()); ?>',con:con,comment_id:comment_id,type:type},
        success: function (data) {
            if (data.status_code == 100) {
                layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
                setTimeout(function () {
                  window.location.reload();
                }, 1500);
            } else {
                layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
            }
        }
    });
  })

  $('.msgBox').click(function(){
    $(".fbbtn").css('display','none');
    $(".hfbtn").css('display','inline-block');
    $(".fbpl h2 span").text('回复评论');
  })

  $('.replyBox').click(function(){
    $(".fbbtn").css('display','none');
    $(".hfbtn").css('display','inline-block');
    $(".fbpl h2 span").text('回复评论');
  })


  //回复评论
  $('.hfbtn').click(function(){
    let con=$('#con').val();
    let urls=window.location.href;
    // let comment_id=$('.cons').attr('data-id');
    let comment_id=comment_ids
    // let user_id=urls.split('/')[4];
    let user_id=urls.split('/')[4];
    let type=-2;
    console.log('评论id'+user_id,'被评论id'+comment_id)
    if(con==''||con==null||con==undefined){
      layer.msg('评论不能为空',{skin: 'intro-login-class layui-layer-hui'});
      return false;
    }
    $.ajax({
        url: '/member/reply_messages',
        type: 'POST',
        dataType: 'json',
        data: {_token:'<?php echo e(csrf_token()); ?>',con:con,comment_id:comment_id,type:type},
        success: function (data) {
            if (data.status_code == 100) {
                layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
                setTimeout(function () {
                  window.location.reload();
                }, 1500);
            } else {
                layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
            }
        }
    });
  })

</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>