﻿

<?php $__env->startSection('title'); ?>

      

    <?php echo e(trans('comm.yinji')); ?> - <?php echo e(get_article_title($article)); ?>


    

<?php $__env->stopSection(); ?>



<?php $__env->startSection('seo_verification'); ?>

    <?php echo e(get_article_title($article)); ?>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('seo_description'); ?>

    <?php echo e(get_article_description($article)); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('seo_keywords'); ?>

    <?php echo e(get_article_keyword($article)); ?>


<?php $__env->stopSection(); ?>


<?php $__env->startSection('content'); ?>

    <?php
        $first_img_url = get_html_first_imgurl($article->detail->content_cn);
        if ($first_img_url) {
            $first_img_url = url($first_img_url);
        }
    ?> 
<script src="/js/jquery.qrcode.min.js"></script>
<style>.users{min-height: 216px;visibility: hidden;}</style>

<div class="banner" style="background-image:url(<?php echo e(get_article_special($article)); ?>);">
  <div class="banner_bj"></div>
  <section class="wrapper banner_title">
            <div class="new_title">
      <h1 class="cfff"><?php echo e(get_article_title($article)); ?></h1>
      <div class="new_label mt20"> 
                
                <!--分类--> 
                
                <?php if($article->category): ?>
                
                <?php $__currentLoopData = $article->category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <a href="/article/category/<?php echo e($category['id']); ?>" rel="category tag"><?php echo e($category['name']); ?></a> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
                <?php endif; ?> 
                
                <!--时间--> 
                
                | <span class="category"><?php echo e(str_limit($article->release_time, 10, '')); ?></span> | 
                
                <!--文章来源--> 
                
                <span> <?php if($article->article_source): ?>
        
        <?php echo e(trans('article.article_source')); ?>：
        
        <?php if($article->article_source_url): ?> <a target="_blank" href="<?php echo e($article->article_source_url); ?>"><?php echo e($article->article_source); ?></a> <?php else: ?>
        
        <?php echo e($article->article_source); ?>

        
        <?php endif; ?>
        
        <?php else: ?>
        
        <?php echo e(trans('comm.publish_by')); ?>

        
        <?php endif; ?> </span> 
        
          <!--打分平均得分展示-->
       <ul class="show_number clearfix">
       <li>
        <div class="atar_Show">
 
          <p tip="<?php echo e($starsav !=null ? $starsav : '5.0'); ?>"></p>

        </div>
        <span></span>
       </li>
    </ul>
    <script>
    //显示分数
      $(".show_number li p").each(function(index, element) {
        var num=$(this).attr("tip");
        // alert(num)
        var www=num*1*16;//
        $(this).css("width",www);
        $(this).parent(".atar_Show").siblings("span").text(num+"分");
    });
    </script>
    <!--打分平均得分结束展示-->
                
                 </div>
      <div class="news_keyword mt10"><?php echo e(trans('article.keyword')); ?>：<?php echo e(get_article_keyword($article)); ?>  
    <!--地点--> 
                
                <span class="comment"><i class="icon-location"></i><?php if('zh-CN' == $lang): ?> <?php echo e($article->location_cn); ?> <?php else: ?> <?php echo e($article->location_en); ?> <?php endif; ?></span> 
                
                <!--收藏次数--> 
                
                <span class="comment"><i class="icon-bookmark"></i><?php echo e($article->favorite_num); ?></span> 
                
                <!--浏览次数--> 
                
                <span class="comment"><i class="icon-eye"></i><?php echo e($article->view_num); ?></span>
    </div>
    </div>
          </section>
</div>

        <!------顶部大图结束----->

        <section class="wrapper ">
  <div class="cat-wrap left">
            <div class="content-post" ca="<?php echo e($article->id); ?>"> <?php echo get_article_content($article); ?> </div>
            
            <!---------新闻内容结束-------->
            
            <div class="new_25">
      <ul>      
                <?php if($userstars !=null ): ?>
                <a href="#df"><li class="like_article"><i class="icon-thumbs-up"></i><?php echo e(trans('article.comments')); ?><?php echo e(sprintf("%.1f",$userstars)); ?></li></a>
                <?php else: ?> 
                <a href="#df"><li class="like_article"><i class="icon-thumbs-up"></i><?php echo e(trans('article.comments')); ?></li></a>
                <?php endif; ?>
                <li><i class="icon-share"></i><?php echo e(trans('article.share')); ?>

          <div class="fenbox">
                    <div class="jiantou"></div>
                    <div class="fenxiang">
              <ul>
                        <li> <a href="javascript:void(0);" title="分享到微信" id="wx_share" class="" rel="nofollow" data-toggle="modal" data-target="#qrcodeModal"> <img src="/images/foot_33.gif" alt="分享到微信" /> </a> </li>
                        <li> <a target="_blank" href="https://service.weibo.com/share/share.php?url=<?php echo e(url('/article/detail/' . $article->id)); ?>&amp;title=【<?php echo e(get_article_title($article)); ?>】&nbsp; &nbsp; &nbsp; &nbsp;<?php echo get_article_description($article); ?>&nbsp;@印际&amp;appkey=&amp;pic=&amp;searchPic=true" title="分享到新浪微博" class="weibo" rel="nofollow"> <img src="/images/foot_31.gif" alt="分享到新浪微博" /> </a> </li>
                        <li> <a target="_blank" href="https://connect.qq.com/widget/shareqq/index.html?url=<?php echo e(url('/article/detail/' . $article->id)); ?>&amp;title=<?php echo e(get_article_title($article)); ?>&amp;desc=&amp;summary=&nbsp; &nbsp; &nbsp; &nbsp;<?php echo get_article_description($article); ?>&amp;site=印际" title="分享到QQ好友" class="qq" rel="nofollow"> <img src="/images/foot_35.gif" alt="分享到QQ好友" /> </a> </li>
                        <li> <a target="_blank" href="https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php echo e(url('/article/detail/' . $article->id)); ?>&amp;title=<?php echo e(get_article_title($article)); ?>&amp;desc=&amp;summary=&nbsp; &nbsp; &nbsp; &nbsp;<?php echo get_article_description($article); ?>&amp;site=印际" title="分享到QQ空间" class="qqzone" rel="nofollow"> <img src="/images/foot_37.gif" alt="分享到空间" /> </a> </li>
                      </ul>
            </div>
                  </div>
        </li>
               <?php if($is_collect): ?>
                <li><i class="icon-bookmark"></i>已收藏</li>
                <?php else: ?>
                <li data-toggle="modal"  id="article-collect"><i class="icon-bookmark"></i><?php echo e(trans('article.collection')); ?></li>
                <?php endif; ?>
                <li style=" border-right:none" id="vip-download"> <a href="javascript:void(0)" ><i class="icon-download"></i><?php echo e(trans('article.down')); ?></a>
                <div class="down-load-tip" style='min-width:271px;'>
                    <div class="down-jiantou"></div>
                    <p class='down_con' style="height: 30px">今日剩余免费下载次数：<span id="left_down_num">0</span>次</p>
                    <p style="text-align: center;padding: 0 15px"> <span style="padding: 0 15px">下载: </span><a style="color: #428bca" href="" target="_blank" >链接</a> <span style='position: relative;padding: 0 15px;'>提取码：<input title='点我复制' class='copybtn' style='padding: 0 5px 0;background: #ccc;border-radius: 5px;cursor: pointer;border:none;width:50px;height:20px;' onclick="copybtn(this)" readonly value=''></span>
                    </p>
                </div>
        </li>
              </ul>
    </div>
            
            <!-- 模态框（Modal） -->
            
    <div class="modal fade" id="qrcodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
                <div class="modal-content">
          <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"> &times; </button>
                    <h4 class="modal-title" id="myModalLabel"> 分享到微信 </h4>
                  </div>
          <div class="modal-body">
                    <div id="qrcode"></div>
                  </div>
          <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
                  </div>
        </div>
                <!-- /.modal-content --> 
                
              </div>
      <!-- /.modal --> 
      
    </div>
            
            <!-- 模态框（Modal） -->
        <div class="modal fade" id="collectFolder" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">请选择收藏文件夹</h4></div>
                    <div class="modal-body">
                        <div class="new-collect">
                        <label>新建：</label>
                        <input type="text" id="folder_name" name="folder_name" value="" />
                        <a href=" " class="Button2 fr collect_article">收藏</a></div>
                        

                        <div class="collection_to">
                        <ul class="discover-folders2">
                            <?php $__currentLoopData = $user_collect_folders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($value['iscollects']=='1'): ?>
                                <li>
                                    <h3><?php echo e($value['name']); ?></h3>
                                    <span img="" floder_id="<?php echo e($value['id']); ?>" class="folderattr null" title="<?php echo e($value['name']); ?>"></span>
                                    <a href="javascript:void(0);" class="Button fr have-disalbed" data-id="<?php echo e($value['id']); ?>">已收藏</a>
                                </li>
                                <?php else: ?>
                                <li>
                                    <h3><?php echo e($value['name']); ?></h3>
                                    <span img="" floder_id="<?php echo e($value['id']); ?>" class="folderattr null" title="<?php echo e($value['name']); ?>"></span>
                                    <a href="javascript:void(0);" class="Button2 fr collect_article" data-id="<?php echo e($value['id']); ?>">收藏</a>
                                </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

            
            <div class="article">
      <ul>
                <?php if($previous_article): ?>
                <li> <img src="<?php echo e(get_article_thum($previous_article)); ?>"  alt="<?php echo e(get_article_title($previous_article)); ?>" /> <a href="<?php if($previous_article->static_url): ?> /article/<?php echo e($previous_article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($previous_article->id); ?> <?php endif; ?>"><?php echo e(trans('article.previous')); ?></a>
          <p><?php echo e(get_article_title($previous_article)); ?></p>
        </li>
                <?php endif; ?>
                
                
                
                <?php if($next_article): ?>
                <li> <img src="<?php echo e(get_article_thum($next_article)); ?>"   alt="<?php echo e(get_article_title($next_article)); ?>" /> <a href="<?php if($next_article->static_url): ?> /article/<?php echo e($next_article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($next_article->id); ?> <?php endif; ?>"><?php echo e(trans('article.next')); ?></a>
          <p><?php echo e(get_article_title($next_article)); ?></p>
        </li>
                <?php endif; ?>
              </ul>
    </div>
            <div class="new_article"> <img src="<?php echo e(get_article_thum($new_article[0])); ?>"   alt="<?php echo e(get_article_title($new_article[0])); ?>" /> <a href="<?php if($new_article[0]->static_url): ?> /article/<?php echo e($new_article[0]->static_url); ?> <?php else: ?> /article/detail/<?php echo e($new_article[0]->id); ?> <?php endif; ?>"><?php echo e(trans('article.latest')); ?></a>
      <p><?php echo e(get_article_title($new_article[0])); ?></p>
    </div>
            
            <!-------仿QQ留言板-------->
            
            <div id="qq">
                <div class="qq_liuyan">
                    <a name="df"></a>
                    <h2 class="left"><?php echo e(trans('article.comments')); ?></h2>
                    <span class=" right"><?php echo e(trans('article.total')); ?>&nbsp;<span class=" c_red"><?php echo e(isset($comments_all) ? $comments_all : '0'); ?>&nbsp;</span><?php echo e(trans('article.comments')); ?></span> 
                </div>
                <div class="msgCon"> 
                
                    <?php $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($comment->content!=''): ?>
                    <div class="msgBox">
                        <!-- 只显示有评论的 -->
                    
                    <dl>
                        <dt><img src="<?php echo e($comment->user->avatar); ?>" width="50" height="50"></dt>
                        
                        <dd>
                            <span style="float:left"><?php echo e($comment->user->nickname); ?>

                                <img src="<?php echo e(App\User::getVipLevel($comment->user->id)); ?>" alt="">
                            </span>
                            <ul class="show_number clearfix" style=" float:left;margin:10px 0 0 30px;">
                            <li style="width:200px;">
                                <div class="atar_Show2">
                                <p tip="<?php echo e($comment->stars); ?>"></p>
                                </div>
                                <span></span>
                            </li>
                            </ul>  
                            <span><?php echo e(trans('article.released_in')); ?>：<?php echo e($comment->created_at); ?></span>
                        </dd>
                        <div class="msgTxt"><?php echo $comment->content; ?></div>
                    
                    </dl>
                    </div> 
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
            </div>
                 <!----打分--->
    <?php if($userstars==null): ?>
     <div class="pingfen">
      <div id="startone"  class="block clearfix" >
          <div class="star_score"></div>
          <p style="float:left;"><?php echo e(trans('article.your_score')); ?>：<span class="fenshu"></span> <?php echo e(trans('article.score')); ?></p>
          <div class="attitude"></div>
    </div>
    </div>
    <!--打分结束--->
    
      <div class="message" contentEditable='true'></div>
      <div class="But"> <span class='submit' data-comment-type="article"><?php echo e(trans('article.published')); ?></span> <img src="/images/qq/ico-biaoqing.png" class='bq'/> 
       <p style=" color:#ccc;">（<?php echo e(trans('article.optional')); ?>）</p>         
                <!--face begin--> 
                <?php $__env->startComponent('face'); ?>
                
                <?php echo $__env->renderComponent(); ?> 
                <!--face end--> 
              </div>
    <?php endif; ?>
    </div>
     <!----点评星星------>
    <script type="text/javascript" src="/js/startScore.js"></script>
    <script>
        scoreFun($("#startone"))
        scoreFun($("#starttwo"),{
            fen_d:16,//每一个a的宽度
            ScoreGrade:5//a的个数 10或者
        })
         
        var num=$('.starsp').attr("tip");
            //显示分数
        $(".show_number li p").each(function(index, element) {
            var num=$(this).attr("tip");
            var www=num*1*16;//
            $(this).css("width",www);
            $(this).parent(".atar_Show").siblings("span").text(num+"分");
        });

    </script>
    <!----点评星星------>
        <script type="text/javascript">

            //点赞
            /*$(".like_article").click(function(e){
                var that = $(this)
                var like_id = '<?php echo e($article->id); ?>';
                if(that.text().indexOf('点赞')>-1){
                    $.ajax({
                        url: '/article/like',
                        type: 'POST',
                        dataType: 'json',
                        data: {_token: '<?php echo e(csrf_token()); ?>', like_id: like_id},
                        success: function (data) {
                            if (data.status_code == 0 && data.data.status == true) {
                                layer.msg('+1', {skin: 'intro-login-class layui-layer-hui'})
                                that.text('点赞(' + data.data.like_num + ')')
                                //window.location.reload();
                            } else {
                                layer.msg(data.message, {skin: 'intro-login-class layui-layer-hui'})
                                // alert(data.message);
                            }
                        }
                    });
                }
            });*/

            //收藏
            $(".collect_article").click(function(e){
                let collect_id = '<?php echo e($article->id); ?>';
                let folder_id = $(this).attr('data-id');
                let folder_name = $('#folder_name').val();
                let is_sc = 1;
                $.ajax({
                    url: '/article/collect',
                    type: 'POST',
                    dataType: 'json',
                    data: {_token:'<?php echo e(csrf_token()); ?>',folder_id:folder_id,folder_name:folder_name,collect_id:collect_id,is_sc:is_sc},
                    success: function (data) {
                        if (data.status_code == 0) {
                            window.location.reload();
                        } else {
                            layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
                        }
                    }
                });
            });

            //提取码复制
            function copybtn(obj){
                let con=document.getElementById("tqmm");
                obj.select(); // 选择对象
                document.execCommand("Copy"); // 执行浏览器复制命令
                // console.log(con);
                layer.msg('复制成功',{time: 1500,skin: 'intro-login-class layui-layer-hui'});
            }


            //下载
            $('#vip-download').click(function(e){
                if(!IS_LOGIN){
                    $('.login_box').show();
                }else{
                    var article_id = '<?php echo e($article->id); ?>';
                    $.ajax({
                        url: '/article/vip_download',
                        type: 'POST',
                        dataType: 'json',
                        data: {_token:'<?php echo e(csrf_token()); ?>',article_id:article_id},
                        success: function (data) {
                            console.log(data);
                            if(data.status_code == 100) {
                                $('.down-load-tip').show()
                                $('.down-load-tip').find('a').attr('href',data.message.vip_download)
                                $('.down-load-tip').find('input').val(data.message.vip_download.substr(-4))
                                $('.down_con').html(data.message.leftkou)
                            }else if(data.status_code == 999){
                                layer.msg(data.message,{time:2000,skin: 'intro-login-class layui-layer-hui'})
                            
                            // if(data.status_code == 501) {
                            //     //todo 弹出确认兑换框，如果用户选择确认调用兑换接口/article/vip_exchange
                            //         $.ajax({
                            //             url: '/article/exchange',
                            //             type: 'POST',
                            //             dataType: 'json',
                            //             data: {_token:'<?php echo e(csrf_token()); ?>',article_id:article_id},
                            //             success: function (data) {
                            //                 console.log(data);
                            //                 if (data.status_code == 100) {
                            //                     layer.msg(data.message.msg,{skin: 'intro-login-class layui-layer-hui'})
                            //                     $('.down-load-tip').show();
                            //                     $('.down-load-tip').find('a').attr('href',data.message.vip_download);
                            //                     $('.down-load-tip').find('input').val(data.message.vip_download.substr(-4));
                            //                     $('.down_con').html('今日剩余积分下载次数'+data.message.left_down_num);
                            //                 } else {
                            //                     // layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
                            //                     $('.down-load-tip').show();
                            //                     $('.down-load-tip').html(data.message);
                            //                 }
                            //             }
                            //         });
                            //     return ;
                            }else{
                                // layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
                                console.log(data);
                                $('.down-load-tip').show();
                                $('.down-load-tip').html(data.message);
                            }
                        }
                    });
                }
            });



            //收藏
            $('.down-load-tip').click(function (e) {
                e.stopPropagation();
            })


            $('html').click(function(e){
                $('.down-load-tip').hide()
            })

            $('#article-collect').click(function(e){
                if(!IS_LOGIN){
                    $('.login_box').show();
                }else{
                    $('#collectFolder').modal({show:true})
                    // $('#collectFolder').show()
                }
            });

            var wx_url = "<?php echo e(url('/article/detail/' . $article->id)); ?>";
            $("#qrcode").qrcode(wx_url);


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

                var comment_id = '<?php echo e($article->id); ?>';
                var comment_type = $(this).attr('data-comment-type');
                var stars=$('.fenshu').html();

                $.ajax({
                    url: '/member/comment',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        type:comment_type,
                        _token:_token,
                        comment_id:comment_id,
                        comment:comment,
                        stars:stars,
                    },

                    success: function (data) {
                        if (data.status_code == 0) {
                            //$msg = '<div class="msgBox"><dl>';
                            //$msg += '<dt><img src="' + data.data.user_info.avatar + '" width="50" height="50"/></dt>';
                            //$msg += '<dd>' + data.data.user_info.nickname + ' <i>' + data.data.user_info.vip_level + '</i>';
                            //$msg += '<span>发布于：' + data.data.comment_info.created_at + '</span></dd>';
                            //$msg += '<div class="msgTxt">' + comment + '</div></dl></div>';
                            //$(".msgCon").prepend($msg);
                            if(comment==""){
                                layer.msg('评分成功,印币+2',{skin: 'intro-login-class layui-layer-hui'});
                                location.reload();
                            }else{
                                $(".message").html('');
                                layer.msg('评论成功，审核通过后将会显示。',{skin: 'intro-login-class layui-layer-hui'});
                            }
                            
                        } else {
                            layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'});
                        }   
                    }
                });
            });



        </script> 
            
            <!-------仿QQ留言板结束--------> 
            
          </div>
  
  <!-------左边新闻结束--->
  
  <div class="sidebar right cat4_sidebar" style="margin-top:-220px;position:absolute;right: 50%;margin-right: -600px;">
    <article designerid="2690">
        <div class="item author-info" style=" padding:0">
            <div class="users"> 
                <?php if($designer): ?>
                    <div class="border-bottom1" style="position:relative">
                        <div class="head"><img src="<?php echo e(get_designer_thum($designer)); ?>" width="440" height="375" alt="<?php echo e(get_designer_title($designer)); ?>"></div>
                        <?php if('1' == $designer->industry): ?>
                        <div class="biaoqian">INTERIOR</div>
                        <?php else: ?>
                        <div class="biaoqian" >ARCHITECT</div>
                        <?php endif; ?>
                        <h2><a href="<?php if($designer->static_url): ?> /designer/<?php echo e($designer->static_url); ?> <?php else: ?> /designer/detail/<?php echo e($designer->id); ?> <?php endif; ?>"><?php echo e(get_designer_title($designer)); ?></a> </h2>
                    </div>
                    <div class="Statistics">
                        <ul>
                            <li><a href="<?php if($designer->static_url): ?>/designer/<?php echo e($designer->static_url); ?> <?php else: ?> /designer/detail/<?php echo e($designer->id); ?> <?php endif; ?>"><span><?php echo e($designer->article_num); ?></span><?php echo e(trans('article.works')); ?></a></li>
                            <li><span> <?php echo e($designer->subscription_num); ?> </span><?php echo e(trans('article.fans')); ?></li>
                        </ul>
                    </div>
                    <?php if($is_subscription): ?> 
                    <span style='width:82px;height:36px;line-height:36px;' class="Button wpfp_designer_act designer have-disalbed " title=""> <?php echo e(trans('article.subscribed')); ?> </span> 
                    <?php else: ?> 
                    <span class="Button3 wpfp_designer_act designer subscription_designer" designer_id="<?php echo e($designer->id); ?>" title=""> <?php echo e(trans('article.subscription')); ?> </span> 
                    <?php endif; ?>
                    <div class="mt20 more_design"></div>


                    <!-- 更多设计师 -->
                    <?php if($more_designer): ?>
                    <div class="works_design" style='display:block;'>
                        <ul>
                        <?php $__currentLoopData = $more_designer; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <div class="more_head fl"><img src="<?php echo e(get_designer_thum($designer)); ?>" alt="<?php echo e(get_designer_title($designer)); ?>"  class="left"/></div>
                                <div class="right" style="width:160px; text-align:left">
                                    <h3><a href="<?php if($designer->static_url): ?> /designer/<?php echo e($designer->static_url); ?> <?php else: ?> /designer/detail/<?php echo e($designer->id); ?> <?php endif; ?>" title="<?php echo e(get_designer_title($designer)); ?>" target="_blank"><?php echo e(get_designer_title($designer)); ?></a></h3>
                                    <?php if('1' == $designer->industry): ?>
                                        <p>INTERIOR  <?php if(!$designer->is_subscription): ?> <a href="javascript:void(0)" class="subscription_next_designer" designer_id="<?php echo e($designer->id); ?>" class="right">+<?php echo e(trans('article.subscription')); ?></a><?php endif; ?></p>
                                    <?php else: ?>
                                        <p>Architect <?php if(!$designer->is_subscription): ?><a href="javascript:void(0)" class="subscription_next_designer" designer_id="<?php echo e($designer->id); ?>" class="right">+<?php echo e(trans('article.subscription')); ?></a><?php endif; ?></p>
                                    <?php endif; ?> 
                                </div>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <?php endif; ?>

                    <?php if($sys): ?>
                    <div class="works_design" style='display:block;'>
                        <ul>
                            <li>
                                <div class="more_head fl"><a href="<?php echo e($sys->url); ?>" title="<?php echo e($sys->name); ?>" target="_blank"><img style='height:84px;' src="/uploads/<?php echo e($sys->avatar); ?>" alt="<?php echo e($sys->avatar); ?>"  class="left"/></a></div>
                                <div class="right" style="width:160px; text-align:left">
                                    <h3><a href="<?php echo e($sys->url); ?>" title="<?php echo e($sys->name); ?>" target="_blank"><?php echo e($sys->name); ?></a></h3>
                                    <p><a href="<?php echo e($sys->url); ?>" title="<?php echo e($sys->name); ?>" target="_blank">PHOTOGRAPHER</a></p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <?php endif; ?>




                <?php else: ?> 
                    <?php if($sys): ?>
                    <div class="border-bottom1" style="position:relative">
                        <div class="head"><a href="<?php echo e($sys->url); ?>"><img src="/uploads/<?php echo e($sys->avatar); ?>" style='width:100%;height:100%;' alt="/uploads/<?php echo e($sys->avatar); ?>"></a></div>
                       
                        <div class="biaoqian" >PHOTOGRAPHER</div>
                        
                        <h2><a href="<?php echo e($sys->url); ?>"><?php echo e($sys->name); ?></a> </h2>
                    </div>
                    <div class="Statistics">
                        <ul>
                            <li><a href="javascript:;"><span><?php echo e($sys_works); ?></span><?php echo e(trans('article.works')); ?></a></li>
                            <li><span> 0 </span><?php echo e(trans('article.fans')); ?></li>
                        </ul>
                    </div>
                    <span style='width:82px;' class="Button wpfp_designer_act designer have-disalbed " title=""> <?php echo e(trans('article.subscription')); ?> </span> 
                    <div class="mt20 more_design"></div>
                    <?php endif; ?>
                <?php endif; ?>
        

            </div>
        </div>
    </article>

    <?php if($topics): ?>
    <!-- <div class="zhuanti_zhuti"> -->
    <?php $__currentLoopData = $topics; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $topic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="zhuanti">
            <ul class="zhuanti-inner">
                <li style="width:288px;background-color:unset;">
                    <a href="/topic/<?php echo e($topic->id); ?>"><img class="img-responsive" src="/uploads/<?php echo e($topic->custom_thum_2); ?>" />
                </li>
            </ul>
        </div>
    <!-- </div> -->
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
<script type="text/javascript">
    $(document).ready(function(){
        $(".icon-eye").click(function(){
            $(".works_design").toggle();
        });


        $('.subscription_next_designer').click(function(e){
            var that =  $(this)
            if(!IS_LOGIN){
                $('.login_box').show();
            }else{
                var designer_id = $(this).attr('designer_id');
                $.ajax({
                    url: '/designer/subscription',
                    type: 'POST',
                    dataType: 'json',
                    data: {_token:'<?php echo e(csrf_token()); ?>',designer_id:designer_id},
                    success: function (data) {
                        if (data.status_code == 0) {
                            that.remove()
                        }else{
                            layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
                        }
                    }
                });
            }
        });

        //订阅
        $(".subscription_designer").click(function(e){
            var that =  $(this)
            if(!IS_LOGIN){
                $('.login_box').show();
            }else if(that.text().trim()=='订阅'){
                var designer_id = $(this).attr('designer_id');
                $.ajax({
                    url: '/designer/subscription',
                    type: 'POST',
                    dataType: 'json',
                    data: {_token:'<?php echo e(csrf_token()); ?>',designer_id:designer_id},
                    success: function (data) {
                        if (data.status_code == 0) {
                            that.text('已订阅')
                            that.css('width','82px')
                            that.css('hetght','36px')
                            that.removeClass('Button3')
                            that.addClass('Button')
                            that.addClass('have-disalbed')
                        } else {
                            layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
                        }
                    }
                });
            }
        });

    });
</script> 
            
            <!--------设计师结束----------->
            
            <article id="slongposts-2" class="sidebar_widget box widget_salong_posts wow bounceInUp triangle animated" style="visibility: visible; animation-name: bounceInUp;">
      <div class="sidebar_title">
                <h3><?php echo e(trans('designer.related_article')); ?></h3>
              </div>
      <ul class="">
                <?php $__currentLoopData = $related_articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
          <article class="postlist">
                    <figure> <a href="<?php if($article->static_url): ?> /article/<?php echo e($article->static_url); ?> <?php else: ?> /article/detail/<?php echo e($article->id); ?> <?php endif; ?>" title="<?php echo e(get_article_title($article)); ?>" target="_blank"> <img class="thumb" src="<?php echo e(get_article_thum($article)); ?>" data-original="<?php echo e(get_article_thum($article)); ?>" alt="<?php echo e(get_article_title($article)); ?>" style="display: block;"> </a> </figure>
                    <h3> <a href="/article/detail/<?php echo e($article->id); ?>" title="<?php echo e(get_article_title($article)); ?>" target="_blank"><?php echo e(get_article_title($article)); ?></a> </h3>
                    <div class="homeinfo"> 
              
              <!--分类--> 
              
              <?php if($article->category): ?>
              
              <?php $__currentLoopData = $article->category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <a href="/article/category/<?php echo e($category['id']); ?>" rel="category tag"><?php echo e($category['name']); ?></a> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              
              <?php endif; ?> <span class="date"><?php echo e(str_limit($article->release_time, 10, '')); ?></span> <span title="请先浏览本文章，再确定是否点赞！" class="like"><i class="icon-thumbs-up"></i><span class="count"><?php echo e($article->like_num); ?></span></span> </div>
                  </article>
        </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
    </article>
            <article id="text-3" class="sidebar_widget box widget_text wow bounceInUp triangle animated" style="visibility: visible; animation-name: bounceInUp;"> <?php if(isset($ads_right)): ?>
      <div class="textwidget">
                <p><!-- 右侧广告代码 开始 --></p>
                <div id="playBox">
          <div class="pre"></div>
          <div class="next"></div>
          <div class="smalltitle">
                    <ul>
              <li class="thistitle"></li>
              <li></li>
              <li></li>
              <li></li>
            </ul>
                  </div>
          <ul class="oUlplay">
                    <?php $__currentLoopData = $ads_right; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $right): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e($right->ad_url); ?>" target="_blank" rel="noopener"><img src="<?php echo e(url('uploads/' . $right->ad_img)); ?>"></a></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </ul>
        </div>
                <p><!-- 右侧广告代码 结束 --></p>
              </div>
      <?php endif; ?> </article>
            <div class="sidebar right">
      <section class="label_right_title">
                <h2><?php echo e(trans('index.hot_tags')); ?></h2>
              </section>
      <div class="label">
                <ul>
          <?php $__currentLoopData = $hot_tags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li data-tag="<?php echo e($tag); ?>"><a href="javascript:void(0)" onclick="goToTarget(this)"><?php if('zh-CN' == $lang): ?> <?php echo e($tag->name_cn); ?> <?php else: ?> <?php echo e($tag->name_en); ?> <?php endif; ?></a></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
              </div>
    </div>
          </div>
  
  <!-------右边结束---> 
  
</section>

        <!-- 发现到 -->
    <div class="create_folder modal" id="discoveryFolders_1">
        <div class="create_folder_title">
            <h2>图片发现到</h2>
        </div>
        <div class="close">关闭</div>
        <div class="pic-name" style="padding: 8px 0 8px 8px;">
            <!---label for="" style="font-size: 14px;color: #333;"> 图片名称 </label--->
            <input type="text" name="imgtitle" id="imgtitle" value="" placeholder="图片说明" style="width: 100%;border-radius:5px;">
        </div>
        <div class="collection_to">
            <ul class="discover-folders2">
            <?php $__currentLoopData = $user_finder_folders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <h3><?php echo e($value['name']); ?></h3>
                <span img='' floder_id='<?php echo e($value["id"]); ?>'  class='folderattr null' title='<?php echo e($value["name"]); ?>'> </span> 
                <div id="modal_btns"> <a href='' class='Button2 fr to_find_floder_act add_finder_btn' data-id='<?php echo e($value["id"]); ?>' data-img='' data-source=''>收藏</a> </div>
                
                 </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <a href="#" class="create create-new-folder-btn">创建发现文件夹</a>
        <div class="error_code"></div>
    </div>
    </div>

    <!--创建发现文件夹-->
    <div class="create_folder modal" id="new-find-model-folder">
        <div class="create_folder_title">
            <h2>创建发现文件夹</h2>
        </div>
        <div class="close">关闭</div>
        <input type="text" value=""  placeholder="收藏夹名称（必填）" class="mt30" name="favorite" id="finder_folder_name"/>
        <textarea id="finder_folder_brief" name="memo" placeholder="简介"  rows="5" class="mt30 folder_introduction"></textarea>
        <input type="hidden" id="finder_folder_id" value="1" />
        <p class="mt30"> 
            <i class="sourceinput" sourceid=""></i>
            <input name="is_open" type="radio" value="1" checked="checked" />公开
            <input name="is_open" type="radio" value="0" />不公开
        </p>
        <div class="error_msg" id="error_msg"></div>
        <div class="create_button">
            <input type="hidden" name="folder_type" id="add_folder_type"  />
            <input type="button" value="取消" class="button_gray concle-create-folder" onclick="javascript:class_find_layui_win();" />
            <input type="button" value="确定" class="button_red create_finder_folder_enter_btn"/>
        </div>
    </div>

        <!--弹窗--> 

    <!-- 登录 -->
    <div class="login_box" style="display:none;">
        <div class="new_folder_bj"></div>
            <div class="login_folder">
                <div id="login" class="login" style='height:640px;'> 
    
                    <div class="wxlogin">
                        <h1><a href="/" title="<?php echo e(trans('comm.yinji')); ?>" tabindex="-1"><?php echo e(trans('comm.yinji')); ?></a></h1>
                        <!-- <h2>微信扫码登陆</h2> -->
                        <p><iframe frameborder="0" scrolling="no" width="300" height="395" src="/auth/weixin"></iframe></p>
                        <div class="login_ico"><a href="javascript:void(0);" onclick="WeChatLogin();"><img src="/img/diannao_03.gif" width="51" height="51" alt="账号登陆"></a></div>
                    </div>


                    <!-- 登陸 -->
                    <div class="ma_box hide" style='top:207px;padding-top:0;height:380px;'>
                        <div class="login_ico" style='position: absolute;top:-202px;right: 5px;'><a href="javascript:void(0);" onclick="WeChatLogin();"><img src="/img/erweima.gif" width="51" height="51" alt="账号登陆"></a></div>
                        <h2><?php echo e(trans('login.login_title')); ?></h2>
                        <form name="loginform" id="loginform" action="/user/login" method="post">
                            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
                            <p>
                                <label for="user_login">
                                    <input type="text" name="user_login" id="user_login" class="input" value="" size="20" placeholder="<?php echo e(trans('login.input_username')); ?>">
                                </label>
                            </p>
                            <p>
                                <label for="user_pass">
                                    <input type="password" name="password" id="user_pass" class="input" value="" size="20" placeholder="<?php echo e(trans('login.input_password')); ?>">
                                </label>
                            </p>
                            <p class="forgetmenot" style='text-align:center;width: 316px;'>
                                <label for="rememberme">
                                    <input name="rememberme" type="checkbox" id="rememberme" value="forever"><?php echo e(trans('login.remember_me')); ?> 
                                </label>
                            </p>
                            <p class="submit">
                                <input type="button" name="wp-submit" id="wp-submit-login" class="button button-primary button-large" value="<?php echo e(trans('login.login')); ?>">
                                <input type="hidden" name="redirect_to" value="/user/index">
                                <input type="hidden" name="testcookie" value="1">
                            </p>
                        </form>
                    </div>
                    <div class='lgbtm' style='height:50px;margin-top: -16px;'>
                        <p id="nav" class="fr" style='margin-top:0;'><a href="/user/register"><?php echo e(trans('login.register')); ?></a> | <a href="/user/forgot_password"><?php echo e(trans('login.forgot_password')); ?></a></p>
                        <p class="fl" style='margin-top:0;'> <a href="/"> ← <?php echo e(trans('login.return')); ?> </a> </p>
                    </div>
                    
                
                </div>
            </div>
        </div>
    </div>
    <!--登陆结束--> 

    <!--------选购会员弹窗------->
    <div class="new_folder_box" style="display:none;">
        <div class="new_folder_bj"></div>
        <div class="create_folder">
            <div class="create_folder_title"><h2>成为会员</h2></div>
            <div class="close vip_close">关闭</div>
            <div class="vip_select mt30">
                <ul>
                    <li class="determine vipfee_type1" vip_level="1" price="<?php echo e(isset($month_price) ? $month_price : '0.01'); ?>" omit="<?php echo e($be_month_price); ?>"><em><?php echo e(isset($month_price) ? $month_price : '0.01'); ?></em>元
                    <p>月会员</p>
                    <del>原价：<?php echo e($be_month_price); ?>元</del></li>
                            <li class="vipfee_type2" vip_level="2" price="<?php echo e(isset($season_price) ? $season_price : '0.01'); ?>" omit="<?php echo e($be_season_price); ?>"><em><?php echo e(isset($season_price) ? $season_price : '0.01'); ?></em>元
                    <p>季会员</p>
                    <del>原价：<?php echo e($be_season_price); ?>元</del></li>
                            <li class="vipfee_type3" vip_level="3" price="<?php echo e(isset($year_price) ? $year_price : '0.01'); ?>" omit="<?php echo e($be_year_price); ?>"><em><?php echo e(isset($year_price) ? $year_price : '0.01'); ?></em>元
                    <p>年会员</p>
                    <del>原价：<?php echo e($be_year_price); ?>元</del></li>
                </ul>
            </div>
            <div class="vip_check">
                <ul>
                    <li><input name="" type="checkbox" value="" checked="checked" />到期自动续费一个月，可随时取消</li>
                    <li><input name="" type="checkbox" value="" id="agree" /><a href="javascript:void(0);">同意并接受《服务条款》</a></li>
                </ul>
            </div>

            <div class="vip_pay">
                <form class="cart vip_pay" action="/vip/wxbuy" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="vip_type" id="vip_type" value="1" />
                    <input type="hidden" name="payment_code" id="payment_code" value="wechatpay" />
                    <input type="hidden" name="pay_total" id="pay_total" value="<?php echo e(isset($month_price) ? $month_price : '0.01'); ?>" />
                    <input type="hidden" name="open_id" id="open_id" value="ohPM_1TdJ-oXTAWy7rP-82CT3glo" />
                    <p class="vip_pay_msg">应付：<span><?php echo e(isset($month_price) ? $month_price : '0.01'); ?></span>元 (立省9元)</p>
                    <p><button type="button" class="single_add_to_cart_button button_red alt" id="buy_now_button">立即购买 </button></p>
                </form>
            </div>
        </div>
    </div>

    <!--------选购会员结束-------> 
    <!--VIP专栏提示-->
    <div class="vip_prompt modal" id="vip-img"><a href="#" class="vip_buy">开通VIP会员</a><a href="#" class="vip_detail">了解VIP详情>></a></div>

    <!--VIP专栏提示结束--> 
    <input type="hidden" name="imageUrlJs" id="imageUrlJs" value="" />


<script src="/js/sharethis.js"></script> 
<script src="/js/5c091d90711a3c0011d0822a.js"></script> 
<script>

    function goToTarget(t) {
        var value = $(t).text()
        if (value && value != '') {
            window.location.href = '/search?keyword=' + encodeURIComponent(value);
        }
    }

    // 判断是否有设计师
    if($('.users').html().trim()){
        $('.users').css('visibility','visible')
    }else{
        $('.users').css('height','216px')
    }

    var timer = setInterval(function(){
        if($('.st-btn').length >= 3){
            var h = '<div class="fenxiang share-img-btn" style="display:none;position: absolute;width: 60px;height:60px;left: 163px;top: '+top+'px;padding: 8px;box-sizing: border-box;z-index: 100000;text-align:right">';

            h += '<a href="javascript:;" class="share-img-btn" sharetype="yinji-find"><svg xml:space="preserve"> <image id="image0" width="24" height="24" x="8" y="8" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACUAAAAlCAQAAABvl+iIAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JQAAgIMAAPn/AACA6QAAdTAAAOpgAAA6mAAAF2+SX8VGAAAAAmJLR0QA/4ePzL8AAAAJcEhZcwAADsQAAA7EAZUrDhsAAAAHdElNRQfiDA0XHTkZwnQUAAAAVUlEQVRIx2P8z0AtwEQ1k0aNGjWKJkaxYIhgS/6MWMUZh6YHsToeTRxrGTA4PTg4jcIV7KgBy0jYoAFNDPRx1bA3ivTEgLMOHpweZBxtM4waNbiNAgDn9QhSF9pevwAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAxOC0xMi0xM1QyMzoyOTo1NyswODowMMypGaQAAAAldEVYdGRhdGU6bW9kaWZ5ADIwMTgtMTItMTNUMjM6Mjk6NTcrMDg6MDC99KEYAAAAAElFTkSuQmCC" /></svg></a>';

            h += '</div>';

            h = '<div class="st-btn share-img-btn" sharetype="yinji-find" style="background:#e1244e; width:40px; height:40px; text-align:center; color:#fff; display:inline-block; border-radius: 4px;">';

            h += '<svg xml:space="preserve"> <image id="image0" width="100%" height="100%" x="0" y="0" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACUAAAAlCAQAAABvl+iIAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JQAAgIMAAPn/AACA6QAAdTAAAOpgAAA6mAAAF2+SX8VGAAAAAmJLR0QA/4ePzL8AAAAJcEhZcwAADsQAAA7EAZUrDhsAAAAHdElNRQfiDA0XHTkZwnQUAAAAVUlEQVRIx2P8z0AtwEQ1k0aNGjWKJkaxYIhgS/6MWMUZh6YHsToeTRxrGTA4PTg4jcIV7KgBy0jYoAFNDPRx1bA3ivTEgLMOHpweZBxtM4waNbiNAgDn9QhSF9pevwAAACV0RVh0ZGF0ZTpjcmVhdGUAMjAxOC0xMi0xM1QyMzoyOTo1NyswODowMMypGaQAAAAldEVYdGRhdGU6bW9kaWZ5ADIwMTgtMTItMTNUMjM6Mjk6NTcrMDg6MDC99KEYAAAAAElFTkSuQmCC" /></svg></div>';


            $("#st-el-1").append(h);
            clearInterval(timer);
            timer = null;

        }


    }, 300);

    // 添加分享
    var _img = "";
    $('.cat-wrap.left').on('mouseenter','.content-post img',function(){
        _img = $(this).attr("src");
        $("#imageUrlJs").val(_img);
    })


    //新建文件夹
    $(document).on('click','.create-new-folder-btn',function(){
     	sourceid=$(this).attr('sourceid');
        if ($('#new-find-model-folder').data("open")==1) { return false; }
        $('#new-find-model-folder').data("open", 1);
        layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            anim: -1,
            isOutAnim: false,
            content: $('#new-find-model-folder')
        });
    })



    //点击收藏的
    function resetSCBtn() {
        $(".add_finder_btn[data-id]").removeClass("Button").addClass("Button2")
        .removeClass("issca").removeClass("have-disalbed").text("收藏");
    }

    function disableSCBtn(img_url, folder_id) {
        // console.log(folder_id);
        let btn = $(`.add_finder_btn[data-id='${folder_id}']`);
        btn.removeClass("Button2").addClass("Button");
        btn.addClass("issca").addClass("have-disalbed");
        btn.text("已收藏");
    }



    //分享按钮点击
    let photo_source;
    $(document).on('click','.share-img-btn',function(){
        photo_source=$('.content-post').attr('ca');
        $('.add_finder_btn').attr('data-source',photo_source)
        // alert(photo_source)
		 // 即将收藏的图片URL
        _img = $("#imageUrlJs").val();//$(this).parents(".img-container").find('img.alignnone.size-full').attr("src");

		resetSCBtn();
		let issc = <?php echo json_encode($issc); ?>;
        for (let i = 0;i < issc.length;i++) {
        	let sc = issc[i];
        	if (sc.photo_url == _img) {
        		disableSCBtn(_img, sc.user_finder_folder_id);
        	}
        }


		//判断是否为登录状态
        if(!IS_LOGIN){
            $('.login_box').show();
        }else if(IS_LOGIN && !IS_VIP){
            layer.open({
                type: 1,
                title: false,
                closeBtn: 0,
                anim:-1,
                isOutAnim:false,
                content: $('#vip-img')
            });
        }else{
            var type = $(this).attr('sharetype');
            switch(type){
                case 'yinji-find':
                    // 获取文件夹列表
                    $('.discover-folders').html('');
                    // getDiscoveryFoldersDom(find_favor_list,_img);图片初始化操作
                    layer.open({
                        type: 1,
                        title: true,
                        closeBtn: 1,
                        anim: -1,
                        isOutAnim: false,
                        content: $('#discoveryFolders_1')
                    });

                    break;
            }
        }
    })

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
    	layer.closeAll()
    	class_find_layui_win();
    })


    //创建收藏收藏夹
    $(document).on('click','.create_finder_folder_enter_btn',function(ev){
        $data = {};
        $data.favorite = $("#new-find-model-folder [name='favorite']").val();
        $data.memo = $("#new-find-model-folder").find("[name='memo']").val();

        $data.isopen =1;
        if ($("#new-find-model-folder").find("[name='isopen']").prop('checked')) {
            $data.isopen =2;
        }

        if (!$data.favorite) {
            $("#new-find-model-folder .error_msg").text("收藏夹名称必填");
            return false;
        }else{
            $("#new-find-model-folder .error_msg").text("");
        }

        $.post("http://yinji.nenyes.com/finderfuc?action=add_finder_Favorite",$data,function (_res) {
            _obj = eval("("+_res+")");
            if (_obj.msg) {
                $("#new-find-model-folder .error_msg").html(_obj.msg);
            }

            if(_obj.error_code==1){
                return false;
            }else{
                alert("操作成功");
                layer.closeAll();
            }

        })
		//创建完成后刷新页面
		window.location.reload(true);
        return false;

    })

    
    //点“收藏”，发现收藏图片到文件夹内
    $(document).on('click','.to_find_floder_act',function(ev){
        if ($(".to_find_floder_act").data("open")==1) {
            return false;
        }

        $(".to_find_floder_act").data("open",1);
        $dom = $(this).parents("li");
        _floder_id = $dom.find(".folderattr").attr("floder_id");
        _title = $("#imgtitle").val();
        $data = {};
        $data.favor_id = _floder_id;
        $data.img =  $dom.find('.folderattr').attr("img");
        $data.img_title = _title;
        $data.url = "http://yinji.nenyes.com/nerihu-sz.html";
        $data.post_id = "17729";

        console.log(_floder_id)

        $.post("http://yinji.nenyes.com/finderfuc?action=add_find_Collection",$data,function (_res) {
            setTimeout(function () {
                $(".to_find_floder_act").removeData("open");
            },1000);
            _obj = eval("("+_res+")");

            if (_obj.msg) {
                //$(this).parents(".discoveryFolders").find(".error_msg").html(_obj.msg);
                alert(_obj.msg);
                layer.closeAll();
            }



            if (_obj.error_code==1) {
                return false;
            }
        })
        return false;
    })



    $(document).on('click','.more-img-item',function(){
        var src = '';
        //去除所有选中状态

        $('.more-img-item').each(function(){
            $(this).removeClass('selected');
        })

        // 添加选中状态
        $(this).addClass('selected');
        src = $(this).find('img').attr('src');
        $('#img-browse').find('.selected-image').attr('src',src);

    })



    function  class_find_layui_win() {
        $('#new-find-model-folder').removeData("open");
        $('#discoveryFolders_1').removeData("open");
        layer.closeAll();
    }

    
    function getDiscoveryFoldersDom(items,img){
        var folders = items || [];
        var h = '';
        h += '      <ul class="discover-folders ">';
        // console.log(items,folders,img);
        folders.map(function(folder,idx){
            h += '        <li>';
            h += '          <h3>'+ folder.favorite + '</h3>';
           // h += '          <span>图片标题：</span><input name="imgtitle"   />';
            h += '          <span ' +' img="'+img+'" floder_id="'+folder.id+'"';
            h += ' class="folderattr ' + (folder.isopen == 2 ? 'private' : null) +'" title="'+ (folder.favorite ? folder.favorite : '') + '" ></span> <a href="javascript:;" class="Button2 fr to_find_floder_act">收藏</a>';
            h += '        </li>';
        })
        h += '      </ul>';
        h += '<a href="#" class="create create-new-folder-btn">创建收藏夹</a>';
        h += '<div class="error_code"></div>';
        $('#discoveryFolders_1 .collection_to').html(h);
    }





</script> 
 
<script>
    _omit  = 58;
    _price = '0.01';


    $(document).on("click",".vip_select li",function () {
        _self = $(this);
        _price = _self.attr("price");
        _omit = _self.attr("omit");


        $('#vip_type').val(_self.attr("vip_level"));
        $('#pay_total').val(_price);
        $('#payment_code').val('alipay');
        $(".vip_select li").removeClass("determine");

        _self.addClass("determine");

        var c = parseInt(_omit)-parseInt(_price);

        $(".vip_pay_msg").html("应付：<span>"+_price+"</span>元 ( 立省"+c+"元)");
    });

    $(document).ready(function(){
        $(document).on("click","#buy_now_button",function(){
            var vip_type = $('#vip_type').val();
            let agree = document.getElementById("agree").checked;
            if(!agree){
                layer.msg('请阅读并接受《服务条款》!',{zIndex:999999999,time: 1500,skin: 'intro-login-class layui-layer-hui'});
                return false;
            }
            if (vip_type == '') {
                alert('请选择会员类型');
                return false;
            }
            window.location = '/vip/pay?vip_type=' + vip_type;
            return;
            //submit the form
            //$('form.cart').submit();

            var url = '/vip/wxbuy';
            var folder_data = {
                _token:_token,
                vip_type : $('#vip_type').val(),
                payment_code : $('#payment_code').val(),
                pay_total : $('#pay_total').val(),
            };


            $.ajax({
                async:false,
                url: url,
                type: 'POST',
                dataType: 'json',
                data: folder_data,
                success: function (data) {
                    if (data.status_code == 0) {
                        if ('alipay' == data.data.payment_code) {
                            window.location = data.data.redirect_url;
                        } else {
                            alert('微信支付返回二维码地址');
                        }
                        layer.closeAll();
                    } else {
                        alert(data.message);
                    }
                }
            });
        });
    });



</script> 
 

 
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