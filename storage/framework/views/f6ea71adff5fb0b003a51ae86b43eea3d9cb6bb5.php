<?php $__env->startSection('title'); ?>
  <?php echo e(trans('comm.yinji')); ?> - <?php echo e(trans('index.home')); ?> - <?php echo e(trans('index.collection_detail')); ?>

<?php $__env->stopSection(); ?>
   
<?php $__env->startSection('content'); ?>
<style>
  body{background:#f8f8f8 !important;}
  .home_box{border-radius:10px !important;}
  .home_top{background:#fff !important;}
  .dot{
    position:absolute;
    bottom:62px;
    right:30px;
    font-size:15px;
    letter-spacing:4px;
    color:#fff;
    cursor:pointer;
    background: #7d83f7;
    border-radius: 50%;
    height: 32px;
    line-height: 33px;
    padding-left: 3px;
  }

  .move_del{
    width: 100px;
    height: 48px;
    background: rgba(0,0,0,0.5);
    text-align: center;
    color: #fff;
    position: absolute;
    right: 71px;
    bottom: 50px;
    z-index: 999;
    display:none;
  }
  .move_del p:hover{
    background:#ccc3c342;
    cursor:pointer;
  }
  .move_del .left_sjx{
    width: 0;
    height: 0;
    border-top: 10px solid transparent;
    border-bottom: 10px solid transparent;
    border-left: 10px solid rgba(0,0,0,0.5);
    position: absolute;
    right: -10px;
    bottom: 16px;
  }
  .fxj{
    width: 373px;
    height: auto;
    background: #f3f2f2;
    border-radius: 5px;
    position: absolute;
    top: 67%;
    left: 40%;
    z-index: 999;
    display:none;
  }
  .fxj p{
    height:50px;
    padding:5px 0;
  }
  .fxj p:nth-of-type(1){
    margin-top:30px;
  }

  .fxj .fxj_left{
    line-height:40px;
  }
  .fxj .fxj_right{
    padding:5px 10px 5px;
    background: #4a8bdc;
    color: #FFF;
    border-radius: 5px;
    float:right;
    cursor: pointer;
  }
</style>

<div class="home_top">
  <div class="home_banber"> <img src="/images/home_bj.jpg" alt="个人主页图片" /></div>
  <div class="home_tongji">
    <ul>
      <li><?php echo e(trans('index.discovery')); ?></br><?php echo e($user->finder_num); ?> </li>
      <li><?php echo e(trans('index.collection')); ?></br><?php echo e($user->collect_num); ?> </li>
      <li><?php echo e(trans('index.subscription')); ?></br><?php echo e($user->subscription_num); ?> </li>
      <li><?php echo e(trans('index.follow')); ?></br><?php echo e($user->follow_num); ?> </li>
    </ul>
  </div>
  <div class="home_personal"> <img src="<?php if($user->avatar): ?> <?php echo e($user->avatar); ?> <?php else: ?> /img/avatar.png <?php endif; ?>" alt="<?php echo e($user->nickname); ?>" /></div>
  <h2  style="position:absolute; text-align:center;left: 0;top:390px;width: 100%;"> <?php echo e($user->nickname); ?> <img src="<?php echo e($user->vip_level); ?>" alt=""></h2>
      <p style="position:absolute; text-align:center;left: 0;top:430px;width: 100%;"><?php echo e(trans('index.personal_description')); ?>： <?php echo e($user->personal_note); ?></p>
  
  
  <div class="home_nav">
    <ul>
        <li><a  href="/member"><?php echo e(trans('index.home')); ?></a></li>
	      <li><a href="/member/finder"><?php echo e(trans('index.my_finder')); ?></a></li>
	      <li class="current"><a href="/member/collect"><?php echo e(trans('index.my_collection')); ?></a></li>
	      <li><a href="/member/subscription"><?php echo e(trans('index.my_subscription')); ?></a></li>
	      <li><a href="/member/follow"><?php echo e(trans('index.my_interactive')); ?></a></li>
	      <li><a href="/member/mydown"><?php echo e(trans('index.my_download')); ?></a></li>
	      <li><a href="/member/profile"><?php echo e(trans('index.the_personal_data')); ?></a></li>
    </ul>
  </div>
</div>

<section class="wrapper">
  <div class="mt30 home_box">

    <div class="title">
      <h2 class="fl"><span style='border-bottom:2px solid #3d87f1;padding-bottom:11px;'><?php echo e(isset($folder_name) ? $folder_name : ''); ?></span></h2>
      <span class="fr"><a href="javascript:window.history.go(-1);" data-type="collect" >&lt; <?php echo e(trans('index.back')); ?></a></span> 
    </div>

    <ul class="layout_ul ajaxposts">
      <div class="post_list">
        <ul>
          <?php $__currentLoopData = $user->collect_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $articles): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php if(get_class($article)=='App\Models\Article'): ?>
              <li class="layout_li ajaxpost">
                <article class="postgrid">
                  <span class="guojia2" >
                    <a style="position:absolute;bottom:60px;right:71px;z-index:9;" href="#" rel="tag"><?php echo e($article->location_cn); ?></a>
                  </span>
                  <figure> 
                    <a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>" title="<?php echo e(get_article_title($article)); ?>" target="_blank"> <img class="thumb" src="<?php echo e(get_article_thum($article)); ?>" data-original="<?php echo e(get_article_thum($article)); ?>" alt="<?php echo e(get_article_title($article)); ?>" style="display: block;"> </a> 
                  </figure>
                  <h2> 
                    <a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>" title="<?php echo e(get_article_title($article)); ?>" target="_blank">
                    <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;"><?php echo e(get_article_title($article, 1)); ?></div>
                    <div style=" color:#666; line-height:24px;"><?php echo e(get_article_title($article, 2)); ?></div>
                    </a> 
                  </h2>

                    <!-- 移动start -->
                    <span class='dot'>•••</span>
                    <div class='move_del'>
                      <div class='left_sjx'></div>
                      <p style="padding-top: 1.5px;color:#fff;" source='<?php echo e($article->id); ?>' href="javascript:;" class="yd_collect_img" data-id="" tag="移动发现的图片到其他文件夹">移动</p>
                      <p style="padding-top: 1.5px;color:#fff;" href="javascript:;" class="remove_collect_img" data-id="<?php echo e($article->delid); ?>" tag="删除发现的图片">删除</p>
                    </div>
      
                    <!-- 移动end -->

                    <!-- <a style="position: absolute;bottom: 60px;right: 30px;" href="javascript:;" class="find-icon-trash remove_find_img" data-id="<?php echo e($article->delid); ?>" tag="删除发现的图片"></a>  -->


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
              <?php else: ?>
              <li class="layout_li ajaxpost">
                <article class="postgrid">
                  <span class="guojia2" >
                    <a style="position:absolute;bottom:60px;right:71px;z-index:9;" href="#" rel="tag"><?php echo e($article->area); ?></a>
                  </span>
                  <figure> 
                    <a href="/details/<?php echo e($article->id); ?>" title="<?php echo e(get_dc_title($article)); ?>" target="_blank"> <img class="thumb" src="<?php echo e(get_dc_thum($article)); ?>" data-original="<?php echo e(get_dc_thum($article)); ?>" alt="<?php echo e(get_dc_title($article)); ?>" style="display: block;"> </a> 
                  </figure>
                  <h2> 
                    <a href="/details/<?php echo e($article->id); ?>" title="<?php echo e(get_dc_title($article)); ?>" target="_blank">
                    <div style="font-size:12px; line-height:30px; color:#999; font-family:Georgia , Times, serif;"><?php echo e(get_dc_title($article, 1)); ?></div>
                    <div style=" color:#666; line-height:24px;"><?php echo e(get_dc_title($article, 2)); ?></div>
                    </a> 
                  </h2>

                    <!-- 移动start -->
                    <span class='dot'>•••</span>
                    <div class='move_del'>
                      <div class='left_sjx'></div>
                      <p style="padding-top: 1.5px;color:#fff;" source='<?php echo e($article->id); ?>' href="javascript:;" class="yd_collect_img" data-id="" tag="移动发现的图片到其他文件夹">移动</p>
                      <p style="padding-top: 1.5px;color:#fff;" href="javascript:;" class="remove_collect_img" data-id="<?php echo e($article->delid); ?>" tag="删除发现的图片">删除</p>
                    </div>
      
                    <!-- 移动end -->

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
              <?php endif; ?> 
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <!-- 分页 --> 

        <div class='fxj' source=''>
          <span class='closefxj' style='padding:5px;font-size: 22px;float: right;cursor: pointer;'>X</span>
          <?php $__currentLoopData = $collectlist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <p><span class='fxj_left'><?php echo e($v->name); ?></span><span data-id='<?php echo e($v->id); ?>' class='fxj_right'>移动</span></p>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    </ul>
  </div>
</section>

<script>

  var hoverTimer = ''
  $('.postgrid>.dot').hover(function(){
    $(this).siblings(".move_del").css('display','block');
  },function(){
    let _this = $(this)
    hoverTimer = setTimeout(function(){
    _this.siblings(".move_del").css('display','none');
    },100)
  });

  $('.move_del').hover(function(){
    clearTimeout(hoverTimer)
  },function(){
    $('.postgrid>.dot').siblings(".move_del").css('display','none');
  });

  //删除收藏文章
  $(document).on('click','.remove_collect_img',function(ev){
      // if (!confirm("确定删除？")) {
      //     return false;
      // }

      var finder_id = $(this).attr('data-id');
      var url = '/member/delete_folder_item';
      var folder_data = {
          _token:_token,
          finder_id:finder_id,
      };

      
      layer.open({
          title: ['温馨提示'],
          content: '确定删除？',
          btn: ['确定','取消'],
          shadeClose: true,
          //回调函数
          yes: function(index){
              // self.location='/vip/intro';//确定按钮跳转地址

          $.ajax({
              async:false,
              url: url,
              type: 'POST',
              dataType: 'json',
              data: folder_data,
              success: function (data) {
                  if (data.status_code == 0) {
                      layer.msg('删除成功！',{time: 1500,skin: 'intro-login-class layui-layer-hui'});
                      // alert('删除成功！');
                      window.location.reload();
                  } else { 
                      alert(data.message);
                  }
              }
          });
        }
      })
      return false;
  });

  //移动收藏文章
  $(document).on('click','.fxj_right',function(){
    let source = $(this).parents('.fxj').attr('source');
    let user_collect_folder_id = $(this).attr('data-id');

    let folder_data = {
        _token:_token,
        user_collect_folder_id:user_collect_folder_id,
        source:source,
    };
    // console.log(user_collect_folder_id,source)
    $.ajax({
        async:false,
        url: '/member/movecollect',
        type: 'POST',
        dataType: 'json',
        data: folder_data,
        success: function (data) {
            if (data.status_code == 0) {
                layer.msg(data.message,{time: 1500,skin: 'intro-login-class layui-layer-hui'});
                window.location.reload();
            } else {
              layer.msg(data.message,{time: 1500,skin: 'intro-login-class layui-layer-hui'});
            }
        }
    });
  });

  //关闭收藏夹框
  $('.closefxj').click(function(){
    $('.fxj').hide();
  })
  //点击显示收藏夹框
  $(document).on('click','.yd_collect_img',function(){
    $('.fxj').css('display','block');
    let sou=$(this).attr('source');
    $('.fxj').attr('source',sou)
  })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>