<?php $__env->startSection('title'); ?>

    <?php echo e(get_designer_title($designer)); ?>_<?php echo e(trans('comm.yinji')); ?>


<?php $__env->stopSection(); ?>



<?php $__env->startSection('content'); ?>
<!-----------导航介结束----->
<div class="designer_img" style="position: relative">
<img src="<?php echo e(url('uploads/' . $designer->special_photo)); ?>" alt="<?php echo e(get_designer_title($designer)); ?>" class="top_thumb">
<div class="designer_bj" style="background:rgba(0,0,0,.5); position:absolute; bottom:0; left:0; width:100%; height:60px; line-height:60px; color:#FFF">
<section class="wrapper">
<div class="left_designer">
 <h2><i class="icon-user"></i><?php echo e(get_designer_title($designer)); ?></h2>
 <div class="ffe_btn"><?php $__currentLoopData = $designer->shares; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $share): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><a href="<?php echo e($share->share_url); ?>" title="<?php echo e($share->share_name); ?>"><i class="fa <?php echo e($share->share_icon); ?>"></i></a>                 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></div>
 </div>
 <div class="right_designer">
 <ul class="show_number clearfix">
       <li>
        <div class="atar_Show">
 
          <p tip="<?php echo e(!$starsav==0 ? $starsav : '5.0'); ?>" style="width: 160px;"></p>

        </div>
        <span>5分</span>
       </li>  
    </ul>
    <script>
    //显示分数
      $(".show_number li p").each(function(index, element) {
        var num=$(this).attr("tip");
        var www=num*1*16;//
        $(this).css("width",www);
        $(this).parent(".atar_Show").siblings("span").text(num+"分");
    });
    </script>
 </div>
</section>


</div>
</div>
<!------设计师大图结束----->

<section class="wrapper">

    <section class="box triangle wow bounceInUp animated" style="visibility: visible; animation-name: bounceInUp;">

        <article class="gallery entry">

            <!-- 标题与信息 -->

           
            <!-- 文章内容 -->

            <div class="content-post">

                <?php if($designer->shares): ?>

                <?php endif; ?>

                <?php echo get_designer_content($designer); ?>


                

            </div>

            <!-- 点赞分享按钮 -->

            <div class="design_3">

                <ul>

                  <!----  <?php if($is_like): ?>

                        <li><i class="icon-thumbs-up"></i>已赞(<?php echo e($designer->like_num); ?>)</li>

                    <?php else: ?>

                        <li class="like_article"><i class="icon-thumbs-up"></i>点赞(<?php echo e($designer->like_num); ?>)</li>

                    <?php endif; ?>---->

                    <li><i class="icon-share"></i>分享

                        <div class="fenbox">

                            <div class="jiantou"></div>

                            <div class="fenxiang">

                                <ul>

                                    <li><img src="/images/foot_31.gif" alt="分享到微博" /></li>

                                    <li><img src="/images/foot_33.gif" alt="分享到微信" /></li>

                                    <li><img src="/images/foot_35.gif" alt="分享到微博" /></li>

                                    <li><img src="/images/foot_37.gif" alt="分享到微博" /></li>

                                </ul>

                            </div>

                        </div></li>



                    <?php if($is_subscription): ?>

                            <li style=" border-right:none" class="have-disalbed"><i class="icon-bookmark "></i>已订阅</li>

                    <?php else: ?>

                            <li style=" border-right:none" class="subscription_designer"><i class="icon-bookmark"></i>订阅</li>

                    <?php endif; ?>



                </ul>

            </div>



            <!-- 相关文章 -->



            <section class="ffe_posts">

                <ul class="layout_ul">

                <?php $__currentLoopData = $related_articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                  <?php if($article): ?>

                    <li class="layout_li">
                      <div class="interior_dafen"><?php echo e(sprintf("%.1f",$article['starsavg'])); ?></div>
                      <div style="position:absolute; right:20px; bottom:25px; color:#fff; z-index:999; font-size:16px; font-family:Georgia, 'Times New Roman', Times, serif; background-image:url(/images/time.jpg) bottom"><?php echo e(str_limit($article->release_time, 10, '')); ?></div>
                      <i style="display: block;background: #fff;width: 20px;height: 5px;position: absolute;bottom: 12px;right: 25px;z-index: 999;border-radius: 10px;"></i>
                        <a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>" title="<?php echo e(get_article_title($article,2)); ?>" target="_blank">

                            <img class="thumb" src="<?php echo e(get_article_thum($article)); ?>" data-original="<?php echo e(get_article_thum($article)); ?>" alt="<?php echo e(get_article_title($article,2)); ?>" style="display: block;">

                            <div class="zpbt">

                                <h3><?php echo e($article->title_name_cn); ?></h3>
  
                            </div>

                        </a>

                    </li>

                  <?php endif; ?>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </ul>

            </section>

            <!-- 相关文章end -->

        </article>





    </section>

    <!-------设计师结束--------->

    <section class="ffe ffe_list ffe_content mt20">

        <?php if(count($related_designers) > 0): ?>

        <h2  style="margin-bottom:30px;"><?php echo e(trans('designer.related_designer')); ?></h2>

        <ul class="layout_ul ajaxposts">

            <?php $__currentLoopData = $related_designers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$related_designer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                <?php if($key < 3): ?>

                        <li class="layout_li ajaxpost">
                        <div class="interior_dafen"><?php echo e(sprintf("%.1f",$starsav==0 ? '5.0' : $starsav)); ?></div>
                            <article class="postgrid wow bounceInUp animated" style="visibility: visible; animation-name: bounceInUp;">

                                <a href="<?php if($related_designer->static_url): ?> /designer/<?php echo e($related_designer->static_url); ?> <?php else: ?> /designer/detail/<?php echo e($related_designer->id); ?> <?php endif; ?>" title="<?php echo e(get_designer_title($related_designer)); ?>" target="_blank"> <img class="thumb" src="<?php echo e(url('uploads/' . $related_designer->custom_thum)); ?>" data-original="<?php echo e(url('uploads/' . $related_designer->custom_thum)); ?>" alt="<?php echo e(get_designer_title($related_designer)); ?>" style="display: block;"> </a>

                                <section class="ffe_main"  style=" position:relative;">

                                    <h2><a href="<?php if($related_designer->static_url): ?> /designer/<?php echo e($related_designer->static_url); ?> <?php else: ?> /designer/detail/<?php echo e($related_designer->id); ?> <?php endif; ?>" title="<?php echo e(get_designer_title($related_designer)); ?>" target="_blank"><?php echo e(get_designer_title($related_designer)); ?></a></h2>

                        <div class="xg_design"> 
 
                          <!--分类-->

                          <span class="guojia2">

                               <?php $__currentLoopData = $related_designer->categorys; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                                  <a href="#" rel="tag"><?php echo e($category['name']); ?></a>

                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </span>

                           </div>

                       <span class="xg_dingyue"><i class="icon-bookmark"></i> <?php echo e($related_designer['subscription_num']); ?></span>

                       <span class="xg_fenlei">

                            <?php if('1' == $related_designer->industry): ?>

                                INTERIOR

                           <?php else: ?>

                                ARCHITECT

                           <?php endif; ?>

                       </span>

                      </section>

                    </article>

                        </li>

                 <?php endif; ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </li>

        </ul>

            <?php endif; ?>

    </section>

<!---------相关设计师结束------->



    <!-- 登录 -->

    <div class="login_box" style="display:none;">

        <div class="new_folder_bj"></div>

        <div class="login_folder">

            <div id="login" class="login">



                <!--		<h1><a href="--><!--" title="--><!--" tabindex="-1">--><!--</a></h1>-->



                <h1><a href="/indx" title="<?php echo e(trans('comm.yinji')); ?>" tabindex="-1"><?php echo e(trans('comm.yinji')); ?></a></h1>

                <h2><?php echo e(trans('login.login_title')); ?></h2>



                <!-- 登陸 -->



                <form name="loginform" id="loginform" action="/user/login" method="post">

                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />

                    <p>

                        <label for="user_login">

                            <input type="text" name="user_login" id="user_login" class="input" value="" size="20"



                                   placeholder="<?php echo e(trans('login.input_username')); ?>">

                        </label>

                    </p>

                    <p>

                        <label for="user_pass">

                            <input type="password" name="password" id="user_pass" class="input" value="" size="20" placeholder="<?php echo e(trans('login.input_password')); ?>">

                        </label>

                    </p>

                    <p class="forgetmenot">

                        <label for="rememberme">

                            <input name="rememberme" type="checkbox" id="rememberme"



                                   value="forever">

                            <?php echo e(trans('login.remember_me')); ?> </label>

                    </p>

                    <p class="submit">

                        <input type="button" name="wp-submit" id="wp-submit-login" class="button button-primary button-large"



                               value="<?php echo e(trans('login.login')); ?>">

                        <input type="hidden" name="redirect_to" value="/user/index">

                        <input type="hidden" name="testcookie" value="1">

                    </p>

                </form>

                <div style=" overflow:hidden">

                    <p id="nav" class="fr"> <a href="/user/register"><?php echo e(trans('login.register')); ?></a> | <a



                                href="/user/forgot_password"><?php echo e(trans('login.forgot_password')); ?></a> </p>

                    <p class="fl"> <a href="/"> ← <?php echo e(trans('login.return')); ?> </a> </p>

                </div>

                <div class=""> <span style="float:left; line-height:36px;color: #999;"> <?php echo e(trans('login.other_login')); ?>：</span><a href="javascript:void(0);" onclick="WeChatLogin();" title="使用微信登录"><img src="/img/tl_weixin.png"></a> </div>

                <div class="login_ico"> <a href="javascript:void(0);" onclick="WeChatLogin();"><img src="/img/erweima.gif" width="51"



                                                                                                    height="51" alt="二维码登陆"></a> </div>

                <div class="ma_box hide">

                    <h1><a href="/index" title="<?php echo e(trans('comm.yinji')); ?>" tabindex="-1"><?php echo e(trans('comm.yinji')); ?></a></h1>



                    <!-- <h2>微信扫码登陆</h2> -->

                    <!--

                    <p>

                        <iframe frameborder="0" scrolling="no" width="365" height="395"



                                src="/auth/weixin"></iframe>

                    </p>

                    -->

                    <p class="backtoblog" style="text-align:center"> <a href="/"> ← <?php echo e(trans('login.return')); ?> </a> </p>
                    <div class="login_ico"><a href="javascript:void(0);" onclick="WeChatLogin();"><img
                                    src="/img/diannao_03.gif" width="51" height="51" alt="账号登陆"></a></div>

                </div>

            </div>

        </div>

    </div>

    <!--登陆结束-->



 <!-------仿QQ留言板-------->

        



       



            



                

                    

                        

                            

                            

                            

                        

                    

                



            

 

            



            



                



                



                



                



            



        

        <script type="text/javascript">



            //点赞

            $(".like_article").click(function(e){

                var that = $(this)

                if(that.text().indexOf('点赞')>-1){

                    var like_id = '<?php echo e($designer->id); ?>';

                    $.ajax({

                        url: '/designer/like',

                        type: 'POST',

                        dataType: 'json',

                        data: {_token:'<?php echo e(csrf_token()); ?>',like_id:like_id},

                        success: function (data) {

                            if (data.status_code == 0 && data.data.status == true) {

                                layer.msg('+1',{skin: 'intro-login-class layui-layer-hui'})

                                that.text('已赞('+data.data.like_num+')')

                                //window.location.reload();

                            } else {

                                layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})

                                // alert(data.message);

                            }

                        }

                    });

                }





            });



            //订阅

            $(".subscription_designer").click(function(e){

                var that = $(this)

                if(!IS_LOGIN){

                    $('.login_box').show();

                }else{

                    if(that.text() == '订阅'){

                        var designer_id = '<?php echo e($designer->id); ?>';

                        $.ajax({

                            url: '/designer/subscription',

                            type: 'POST',

                            dataType: 'json',

                            data: {_token:'<?php echo e(csrf_token()); ?>',designer_id:designer_id},

                            success: function (data) {

                                if (data.status_code == 0) {

                                    that.text('已订阅')

                                    that.addClass('have-disalbed')

                                    //window.location.reload();

                                } else {

                                    layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})

                                    // alert(data.message);

                                }

                            }

                        });

                    }

                }

            });



            //收藏

            $(".collect_article").click(function(e){



                var collect_id = '';



                var folder_id = $('#folder_id').val();

                var folder_name = $('#folder_name').val();

                if(!IS_LOGIN){

                    $('.login_box').show();

                }else{

                    $.ajax({

                        url: '/article/collect',

                        type: 'POST',

                        dataType: 'json',

                        data: {_token:'<?php echo e(csrf_token()); ?>',folder_id:folder_id,folder_name:folder_name,collect_id:collect_id},

                        success: function (data) {

                            if (data.status_code == 0) {

                                window.location.reload();

                            } else {

                                alert(data.message);



                            }

                        }

                    });

                }





            });



            //下载

            $('#vip-download').click(function(e){

                var article_id = '';

                $.ajax({

                    url: '/article/vip_download',

                    type: 'POST',

                    dataType: 'json',

                    data: {_token:'<?php echo e(csrf_token()); ?>',article_id:article_id},

                    success: function (data) {

                        if (data.status_code == 0) {                            

                            window.open(data.data.vip_download);

                        } else {

                            alert(data.message);



                        }

                    }

                });



            });





            $('.vip_prompt .vip_buy').click(function () {

                $(".new_folder_box").show();

                layer.closeAll();

            })



            $('.vip_prompt .vip_detail').click(function () {

                location.href='/vip/intro'

            })



            $(document).on("click",".vip_close",function () {

                $(".new_folder_box").hide();

                return false;

            })



            $(document).on("click",".new_folder_bj",function () {

                $(".login_box").hide();

                $(".new_folder_box").hide();

                return false;

            })





            $(document).on("click",".vip_prompt",function () {

                layer.closeAll()

                return false;

            })



            $(document).on("click",".layui-layer-shade",function () {

                layer.closeAll()

                return false;

            })



            //关闭所有展示框

            $(document).on('click','.modal .close',function(){

                class_find_layui_win();

            })



            var wx_url = "<?php echo e(url('/article/detail/')); ?>";



            //$("#qrcode").qrcode(wx_url);







            //点击小图片，显示表情



            $(".bq").click(function(e){



                $(".face").slideDown();//慢慢向下展开



                e.stopPropagation();   //阻止冒泡事件



            });







            //在桌面任意地方点击，他是关闭



            $(document).click(function(){



                $(".face").slideUp();//慢慢向上收



            });







            //点击小图标时，添加功能



            $(".face ul li").click(function(){



                var simg=$(this).find("img").clone();



                $(".message").append(simg);



            });







            //点击发表按扭，发表内容



            $("span.submit").click(function(){

                if (!IS_LOGIN) {

                    $('.login_box').show();

                    return;

                }

                var comment=$(".message").html();

                if(comment==""){

                    alert('请先输入留言内容');

                    $('.message').focus();//自动获取焦点

                    return;

                }

                var comment_id = '<?php echo e($designer->id); ?>';

                var comment_type = $(this).attr('data-comment-type');

                $.ajax({

                    url: '/member/comment',

                    type: 'POST',

                    dataType: 'json',

                    data: {

                        type:comment_type,

                        _token:_token,

                        comment_id:comment_id,

                        comment:comment

                    },

                    success: function (data) {

                        if (data.status_code == 0) {

                            //$msg = '<div class="msgBox"><dl>';

                            //$msg += '<dt><img src="' + data.data.user_info.avatar + '" width="50" height="50"/></dt>';

                            //$msg += '<dd>' + data.data.user_info.nickname + ' <i>' + data.data.user_info.vip_level + '</i>';

                            //$msg += '<span>发布于：' + data.data.comment_info.created_at + '</span></dd>';

                            //$msg += '<div class="msgTxt">' + comment + '</div></dl></div>';



                            //$(".msgCon").prepend($msg);

                            $(".message").html('');

                            alert('评论成功，审核通过后将会显示。');

                        } else {

                            alert(data.message);



                        }

                    }

                });







            });



        </script>

        <!-------仿QQ留言板结束-------->

</section>







<script type="text/javascript">

    function WeChatLogin() {



        if ($(".ma_box").hasClass("hide")) {



            $(".ma_box").removeClass("hide");



        } else {



            $(".ma_box").addClass("hide");



        }



    }







    function toLogin() {



        //以下为按钮点击事件的逻辑。注意这里要重新打开窗口



        //否则后面跳转到QQ登录，授权页面时会直接缩小当前浏览器的窗口，而不是打开新窗口



        var A = window.open("/auth/qq", "_self");







    }







    function wp_attempt_focus() {



        setTimeout(function () {



            try {



                d = document.getElementById('user_login');



                d.focus();



                d.select();



            } catch (e) {



            }



        }, 200);



    }

    //监听回车事件

    $(document).keyup(function(event){

        if(event.keyCode ==13){

            $('#wp-submit-login').trigger("click");

        }

    });



    $("#wp-submit-login").click(function () {



        // var loginform = new FormData();



        var url = $.trim($('#loginform').attr("action"));



        $.ajax({



            url: url,



            type: 'POST',



            dataType: 'json',



            data: $('#loginform').serialize(),



            success: function (data) {



                if (data.status_code == 0) {



                    setTimeout(function () {

                        location.href =  location.href



                    }, 300);



                } else {

                    layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'});

                }



            }



        });



    });

    wp_attempt_focus();

    if (typeof wpOnload == 'function') wpOnload();

</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>