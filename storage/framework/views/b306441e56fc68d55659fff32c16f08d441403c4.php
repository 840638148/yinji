<?php $__env->startSection('title'); ?>
 <?php echo e(trans('comm.yinji')); ?> - 个人中心 -发现详情
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<style>

    .item .edit_favorites{

        position: absolute;

        display: inline-block;

        vertical-align: top;

        text-indent:0;

        text-align: center;

        line-height: 32px;

        z-index: 120;

        right:10px;

    }

    .edit_favorites:hover .item-setting-btns{

        color:#555;

    }

    .find_title{

        overflow:inherit;

        position:absolute;
        bottom: -2px;

    }

    .find_title h2{

        float: none;
	    width: 210px;
	    vertical-align: top;
	    background: #fff;
	    padding: 0 5px;
	    border-radius: 6px;
	    margin: 0 0 5px 7px;
		display: none;
	    position: absolute;
	    bottom: 2px;
	    height: 35px;
	    line-height: 30px;
	    text-indent: 1em;
    }
    .find_title a{
		display: none;
    }
    .find_title .find-icon-trash{
		position: absolute;
	    bottom: 8px;
	    right: 10px;
    }

	.item_content:hover .find_title h2,.item_content:hover .find_title a{
		display: block;
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
    
.lzcfg{
    background: rgba(0,0,0,0.5);
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    display: none;
    z-index: 99999999;
}

.swiper-container{
	display:none;
	position:absolute;
	z-index:9999999999;
  top:31%;
}

</style>
<div class="lzcfg"></div>
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

      <li class="current"><a href="/member/finder">我的发现</a></li>

      <li><a href="/member/collect">我的收藏</a></li>

      <li><a href="/member/subscription">我的订阅</a></li>

      <li><a href="/member/follow">我的关注</a></li>

      <li><a href="/member/point">我的积分</a></li>

      <li><a href="/member/profile">个人资料</a></li>

    </ul>

  </div>

</div>






<!--点击上面的图片显示轮播图片-->
<div class="swiper-container swiper-home">
	<div style="padding:5px;color:#fff;font-size:65px;position:fixed;z-index:999999999999;top:120px;right:20px;cursor: pointer;" class="closeltb"> × </div>
	<div class="swiper-wrapper"> 
		<?php $__currentLoopData = $folist; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i =>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

			<article class="swiper-slide slide-single" data-swiper-slide-index="<?php echo e($loop->iteration); ?>" >
				<img width="600px" height="600px" src="<?php echo e($v['photo_url']); ?>" data-id="<?php echo e($v['photo_source']); ?>" alt="<?php echo e($v['name']); ?>">
				<div class="scbtmlbt" data-id="<?php echo e($v['photo_source']); ?>" data-pid-i="<?php echo e($i); ?>" onclick="getID(this)">收藏</div>
			</article>
			
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
    </div>
      <!-- 按钮 -->
      <div style="top:36%" class="swiper-home-button-next swiper-button-next"></div>
      <div style="top:36%"  class="swiper-home-button-prev swiper-button-prev"></div>
</div>






<section class="wrapper ">

  <div class="mt30 home_box ">

    <div class="title">

      <h2 class="fl"><?php echo e(isset($folder_name) ? $folder_name : ''); ?></h2>

      <span class="fr"><a href="javascript:window.history.go(-1);" data-type="collect" >&lt; 返回</a></span> </div>

    <div class="masonry">

        <?php $__currentLoopData = $user->finder_details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

      <div class="item discovery-item ">

        <div class="item_content item_content2">
        		<!--<li> <img onclick="location='<?php echo e($detail['photo_url']); ?>'" src="<?php echo e($detail['photo_url']); ?>" alt=""> </li>-->
        		<li> <img src="<?php echo e($detail['photo_url']); ?>" data-id="<?php echo e($detail['user_finder_folder_id']); ?>" alt="<?php echo e(mb_substr($detail['titlename'],0,30)); ?>"> </li>
          <div class="find_title">

            <h2><a href="<?php echo e($detail['photo_url']); ?>" target="_blank"><?php echo e(mb_substr($detail['titlename'],0,20)); ?></a></h2>

            <a href="javascript:;" class="find-icon-trash remove_find_img" data-id="<?php echo e($detail['id']); ?>" tag="删除发现的图片"></a> </div>

        </div>

      </div>

      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 

    </div>

  </div>

</section>

<script type="text/javascript">

	//--点击上面的图片显示轮播图片--
	$(document).on('click','.masonry .item_content>li',function(){
      $('.lzcfg').css('display','block');
      $('.swiper-container').css('display','block');

        //轮播图效果
    var $page_main_body = $('.slide-home');
    var $button_next = $page_main_body.find('.swiper-home-button-next');
    var $button_prev = $page_main_body.find('.swiper-home-button-prev');
    var len = $('.slide-home').find('.swiper-slide').length;
      bannerSwiper = new Swiper('.swiper-home', {
      pagination: '.swiper-home-pagination',
      nextButton: '.swiper-home-button-next',
      prevButton: '.swiper-home-button-prev',
      autoplayDisableOnInteraction: true,
      loop: true,
      centeredSlides: true,
      observer: true, //解决数据传入后轮播问题
        observerParents: true,
        autoResize: true, //尺寸自适应
        initialSlide: 0,
        direction: "horizontal",
        /*形成环路（即：可以从最后一张图跳转到第一张图*/
        slidesPerView: 'auto',
        loopedSlides: 0,
        autoplay: 1500,
        /*每隔3秒自动播放*/
      on: {
        init: function () {
          var width = parseInt($page_main_body.width());
          if ($index_pc_bt.size() > 0) {
            $index_pc_bt.css('width', (width - this.slidesSizesGrid['0']) / 2 + 'px');
          }
        }
      },
      onInit: function (swiper) {
        swiper.slides[2].className = "swiper-slide swiper-slide-active";//第一次打开不要动画
      },
      breakpoints: {
        668: {
          slidesPerView: 1
        }
      },
      lazy: {
        loadPrevNext: true,
      }
    });
	})
	//点击关闭轮播图
    $(document).on('click','.closeltb',function(){
      $('.swiper-container').css('display','none');
      $('.showscbtnlbt').css('display','none');
      $('.lzcfg').css('display','none');
    })




// $(document).on('click','.masonry .item_content>li',function(){

//     var folder_id = $('.masonry .item_content>li img').attr('data-id');
//     // alert(folder_id); 
//     $.ajax({
//         async:false,
//         url: '/vip/get_folder_detail',
//         type: 'POST',
//         //dataType: 'json',
//         data: {
//             _token:_token,
//             folder_id:folder_id
//         },
//         success: function (data) {
//             $('#img-browse').html(data);
            
//             //初始化相框
//             // getImgBrowseImgsDom(browseImgs,'#discovery-img-browse');
//             layer.open({
//                 type: 1,
//                 title: false,
//                 closeBtn: 0,
//                 anim:-1,
//                 isOutAnim:false,
//                 content: $('#img-browse')
//             });
//         }
//     });
// })
//切换图片
$(document).on('click','.more-img-item',function(){
    var src = '';
    //去除所有选中状态
    $('.more-img-item').each(function(){
        $(this).removeClass('selected');
    })
    $(this).parents('.right').prev().find('#discovery-folder-name').html($(this).find('img').attr('alt'))
    // 添加选中状态
    $(this).addClass('selected');

    src = $(this).find('img').attr('src');
    $(this).parents('.img_browse').find('.selected-image').attr('src',src);
})


      function selectItem(index){

          $('.dingyue-item .select-item').hide()

          $($('.dingyue-item')[index]).find('.select-item').show()

          localStorage.setItem("selectdD", index);

      }



      function selectItemGuanZhu(index){

          $('.guanzhu-item .select-item').hide()

          $($('.guanzhu-item')[index]).find('.select-item').show()

          localStorage.setItem("selectdG", index);

      }







    $(document).ready(function(){

        if(IS_VIP){

            $('.order_center .order2').find('a').html('会员中心')

            $('.order_center .order2').find('a').attr('href','/member/interest')

        }



        $('.dingyue-item .select-item').hide()

        var dIndex = localStorage.getItem('selectdD')

        $($('.dingyue-item')[dIndex]).find('.select-item').show()



        $('.guanzhu-item .select-item').hide()

        var gIndex = localStorage.getItem('selectdG')

        $($('.guanzhu-item')[gIndex]).find('.select-item').show()



        //最多显示8条数据

        for(var i=0;i<$('.my-collection .collection-item').length;i++){

            if(i>7){

                $($('.my-collection .collection-item')[i]).hide()

            }

        }



        for(var i=0;i<$('.my-finder .collection-item').length;i++){

            if(i>7){

                $($('.my-finder .collection-item')[i]).hide()

            }

        }



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

<!--个人发现中心的图片浏览-->

<div class="img_browse modal" id="img-browse" >

    <div class="close">关闭</div>

    <div class="left">

        <div style="height:48px;">

            <h2 class="fl">文件夹名称333</h2>

            <span class="fr">分享到：</div>

        <div class="image"><img src="/images/ad_05.gif" alt="发现的图片" class="selected-image"/> </div>

    </div>

    <div class="right" style="margin-top:48px;">

        <div class="more_img">

            <a href="#" class="more-img-item selected"><img src="images/imges.jpg" alt="图片一" /> <div class="cover"></div></a>



            <a href="#" class="more-img-item"><img src="images/ad_05.gif" alt="图片一" /><div class="cover"></div></a>

            <a href="#" class="more-img-item"><img src="images/design_16-03.gif" alt="图片二" /><div class="cover"></div></a>

            <a href="#" class="more-img-item"><img src="images/about_img.jpg" alt="图片一" /><div class="cover"></div></a>

            <a href="#" class="more-img-item"><img src="images/ad_22.gif" alt="图片二" /><div class="cover"></div></a>

            <a href="#" class="more-img-item"><img src="images/ad_05.gif" alt="图片一" /><div class="cover"></div></a>

            <a href="#" class="more-img-item"><img src="images/design_16-03.gif" alt="图片二" /><div class="cover"></div></a>

            <a href="#" class="more-img-item"><img src="images/about_img.jpg" alt="图片一" /><div class="cover"></div></a>

            <a href="#" class="more-img-item"><img src="images/ad_22.gif" alt="图片二" /><div class="cover"></div></a>

            <a href="#" class="more-img-item"><img src="images/ad_05.gif" alt="图片一" /><div class="cover"></div></a>

            <a href="#" class="more-img-item"><img src="images/design_16-03.gif" alt="图片二" /><div class="cover"></div></a> </div>

        <hr />

        <div class="discoverer">

            <div class="head"><img width="100%" height="100%" src="images/design_16-03.gif" alt="头像" /></div>

            <h2><a href="#">大仁哥1027</a> <span class="vip1">VIP</span></h2>

            <a class="Button">关注</a>

        </div>

        <hr />

        <div class="faxian_info">

            <p>由 <a href="#">严PPPPPPPP1</a> 收藏于 <a href="#">大厅</a></p>

            <p>2017-06-02 14:59:57</p>

            <p class="laiyuan"><a href="#">来源：Lera Brumina作品 | 80㎡ Apartmen...</a></p>

        </div>

    </div>

</div>
<!--个人发现中心的浏览结束-->

<script src="/js/layer.js"></script> 

<script src="/js/member.js"></script> 

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>