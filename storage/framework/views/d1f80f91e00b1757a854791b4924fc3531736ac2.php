<div class="close">关闭</div>
<div class="left" style="width:480px;">
  <div style="height:48px;line-height: 48px">

      <div class="folder-fenxiang">
      	
        <span class="select-img-name" id="discovery-folder-name">
        <?php echo e($folder_detail['images'][0]['articletitle']); ?>

        </span>
        
        <span style="position: absolute;right: 430px;top:10px;" >分享到：</span>

        <ul class="folder-fen-content detail-fen-content" style="background: #fff;width: 120px;float: right;height: 47px;position: absolute;top: 10px;right: 300px;">
          <li>
            <a href="javascript:void(0);" title="分享到微信" id="wx_share" class="" rel="nofollow" data-toggle="modal" data-target="#qrcodeModal">
              <img src="/images/folder-weixin.png" alt="分享到微信" style="width: 80%"/>
            </a>
          </li>
          <li>
            <?php if(get_class($folder_detail['article'])=="App\Models\Article"): ?>
            <a target="_blank" href="https://service.weibo.com/share/share.php?url=<?php echo e(url('/article/detail/' . $folder_detail['article']['id'])); ?>&amp;title=【<?php echo e(get_article_title($folder_detail['article'])); ?>】&nbsp; &nbsp; &nbsp; &nbsp;<?php echo get_article_description($folder_detail['article']); ?>&nbsp;@印际&amp;appkey=&amp;pic=&amp;searchPic=true" title="分享到新浪微博" class="weibo" rel="nofollow">
            <?php else: ?>
            <a target="_blank" href="https://service.weibo.com/share/share.php?url=<?php echo e(url('/details/' . $folder_detail['article']['id'])); ?>&amp;title=【<?php echo e(get_article_title($folder_detail['article'])); ?>】&nbsp; &nbsp; &nbsp; &nbsp;<?php echo get_dc_description($folder_detail['article']); ?>&nbsp;@印际&amp;appkey=&amp;pic=&amp;searchPic=true" title="分享到新浪微博" class="weibo" rel="nofollow">
            <?php endif; ?>
              <img src="/images/folder-weibo.png" alt="分享到新浪微博" style="width: 80%"/>
            </a>
          </li>
          <li>
            <?php if(get_class($folder_detail['article'])=="App\Models\Article"): ?>
            <a target="_blank" href="https://connect.qq.com/widget/shareqq/index.html?url=<?php echo e(url('/article/detail/' . $folder_detail['article']['id'])); ?>&amp;title=<?php echo e(get_article_title($folder_detail['article'])); ?>&amp;desc=&amp;summary=&nbsp; &nbsp; &nbsp; &nbsp;<?php echo get_article_description($folder_detail['article']); ?>&amp;site=印际" title="分享到QQ好友" class="qq" rel="nofollow">
            <?php else: ?>
            <a target="_blank" href="https://connect.qq.com/widget/shareqq/index.html?url=<?php echo e(url('/details/' . $folder_detail['article']['id'])); ?>&amp;title=<?php echo e(get_dc_title($folder_detail['article'])); ?>&amp;desc=&amp;summary=&nbsp; &nbsp; &nbsp; &nbsp;<?php echo get_dc_description($folder_detail['article']); ?>&amp;site=印际" title="分享到QQ好友" class="qq" rel="nofollow">
            <?php endif; ?>
              <img src="/images/folder-qq.png" alt="分享到QQ好友" style="width: 80%"/>
            </a>
          </li>
          <li>  
            <?php if(get_class($folder_detail['article'])=="App\Models\Article"): ?>
            <a target="_blank" href="https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php echo e(url('/article/detail/' . $folder_detail['article']['id'])); ?>&amp;title=<?php echo e(get_article_title($folder_detail['article'])); ?>&amp;desc=&amp;summary=&nbsp; &nbsp; &nbsp; &nbsp;<?php echo get_article_description($folder_detail['article']); ?>&amp;site=印际" title="分享到QQ空间" class="qqzone" rel="nofollow">
            <?php else: ?>
            <a target="_blank" href="https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=<?php echo e(url('/details/' . $folder_detail['article']['id'])); ?>&amp;title=<?php echo e(get_dc_title($folder_detail['article'])); ?>&amp;desc=&amp;summary=&nbsp; &nbsp; &nbsp; &nbsp;<?php echo get_dc_description($folder_detail['article']); ?>&amp;site=印际" title="分享到QQ空间" class="qqzone" rel="nofollow">
            <?php endif; ?>
              <img src="/images/folder-qqzoe.png" alt="分享到空间" style="width: 80%"/>
            </a>
          </li>
        </ul>

      </div>

  </div>
  




  <?php if($folder_detail['images']): ?>
    <?php if(get_class($folder_detail['article'])=="App\Models\Article"): ?>       
    <div class="image content-post"><a target="_blank" href="article/<?php echo e($folder_detail['images'][0]['static_url']); ?>"><img atitle="<?php echo e($folder_detail['images'][0]['articletitle']); ?>" static_url="article/<?php echo e($folder_detail['images'][0]['static_url']); ?>" src="<?php echo e($folder_detail['images'][0]['photo_url']); ?>" alt="<?php echo e($folder_detail['images'][0]['title']); ?>" class="selected-image"/></a></div>
    <?php else: ?>
    <div class="image content-post"><a target="_blank" href="/details/<?php echo e($folder_detail['images'][0]['static_url']); ?>"><img atitle="<?php echo e($folder_detail['images'][0]['articletitle']); ?>" static_url="/details/<?php echo e($folder_detail['images'][0]['static_url']); ?>" src="<?php echo e($folder_detail['images'][0]['photo_url']); ?>" alt="<?php echo e($folder_detail['images'][0]['title']); ?>" class="selected-image" dcarticle_id="<?php echo e(isset($folder_detail['images'][0]['dcarticle_id'])); ?>"/></a></div>
    <?php endif; ?>
  <?php endif; ?>
</div>
<div class="right" >
  <div class="folder-name" style="height: 48px;line-height: 48px;text-align: center"><?php echo e($folder_detail['folder']['name']); ?></div>

  <div class="more_img" style="">
    <?php $__currentLoopData = $folder_detail['images']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    
      <?php if($loop->first): ?>
        <?php if(isset($image['dcarticle_id'])): ?>
          <a href="javascript:void(0)" class="more-img-item item-inner selected"><img atitle="<?php echo e($image['articletitle']); ?>" dcarticle_id="<?php echo e(isset($image['dcarticle_id'])?$image['dcarticle_id']:''); ?>" static_url="/details/<?php echo e($image['static_url']); ?>" src="<?php echo e($image['photo_url']); ?>" alt="<?php echo e($image['title']); ?>" /> <div class="cover"></div></a>
        <?php else: ?>
        <a href="javascript:void(0)" class="more-img-item item-inner selected"><img atitle="<?php echo e($image['articletitle']); ?>" dcarticle_id="<?php echo e(isset($image['dcarticle_id'])?$image['dcarticle_id']:''); ?>" static_url="article/<?php echo e($image['static_url']); ?>" src="<?php echo e($image['photo_url']); ?>" alt="<?php echo e($image['title']); ?>" /> <div class="cover"></div></a>
        <?php endif; ?>
      <?php else: ?>
        <?php if(isset($image['dcarticle_id'])): ?>
          <a href="javascript:void(0)" class="more-img-item item-inner"><img atitle="<?php echo e($image['articletitle']); ?>" dcarticle_id="<?php echo e(isset($image['dcarticle_id'])?$image['dcarticle_id']:''); ?>" static_url="/details/<?php echo e($image['static_url']); ?>" src="<?php echo e($image['photo_url']); ?>" alt="<?php echo e($image['title']); ?>" /> <div class="cover"></div></a>
        <?php else: ?>
        <a href="javascript:void(0)" class="more-img-item item-inner"><img atitle="<?php echo e($image['articletitle']); ?>" dcarticle_id="<?php echo e(isset($image['dcarticle_id'])?$image['dcarticle_id']:''); ?>" static_url="article/<?php echo e($image['static_url']); ?>" src="<?php echo e($image['photo_url']); ?>" alt="<?php echo e($image['title']); ?>" /> <div class="cover"></div></a>
        <?php endif; ?>
      <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
  <hr class="line-one"/>
  <div class="discoverer">
    <div class="head">
      <a href="/member/<?php echo e($folder_detail['user']['id']); ?>"><img width="100%" height="100%" src="<?php echo e($folder_detail['user']['avatar']); ?>" alt="头像" /></a>
    </div>
    <div class='headright'>
      <a href="#" style="font-size:18px;"><?php echo e($folder_detail['user']['nickname']=='' ? '匿名用户' : $folder_detail['user']['nickname']); ?></a> <span style="background:none;" class="vip1"><img style="margin: -10px 0 0 -8px;" src="<?php echo e($folder_detail['user']['vip_level']); ?>" alt=""></span>
      <a class="Button user_follow_btn" data-id="<?php echo e($folder_detail['user']['id']); ?>">关注</a>
    </div>
  </div> 
</div>

<!--弹窗-->

<!-- 模态框（Modal） -->
<div class="modal fade" id="qrcodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
          &times;
        </button>
        <h4 class="modal-title" id="myModalLabel">
          分享到微信
        </h4>
      </div>
      <div class="modal-body">
        <div id="qrcode"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal -->
</div>

<!-- 发现到 -->
<div class="create_folder modal double-create_folder" id="discoveryFolders_1">
  <div class="create_folder_title">
    <h2>图片发现到</h2>
  </div>
  <div class="close2">关闭</div>
  <div class="pic-name" style="padding: 8px;">
    <label for="" style="font-size: 14px;color: #333;"> 图片名称 </label>
    <input type="text" name="imgtitle" id="imgtitle" value="" placeholder="图片名称" style="width: 476px;">
  </div>
  <div class="collection_to">
    <ul class="discover-folders2">
        <?php $__currentLoopData = $folder_detail['user_finder_folders']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <h3><?php echo e($value['name']); ?></h3>
                <span img="" floder_id="<?php echo e($folder_detail['article']['id']); ?>" class="folderattr null" title="<?php echo e($value['name']); ?>"></span>

                <a href="javascript:;" class="Button2 fr to_find_floder_act add_finder_btn" photo_url="<?php echo e($value['name']); ?>" data-id="<?php echo e($value['id']); ?>" data-img="" data-source="<?php echo e($folder_detail['article']['id']); ?>">收藏</a >
                
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
  </div>
  <a href="#" class="create create-new-folder-btn">创建收藏夹</a>
  <div class="error_code"></div>
</div>
</div>

<!--创建发现文件夹-->
<div class="create_folder modal double-create_folder" id="new-find-model-folder">
  <div class="create_folder_title">
    <h2>创建发现文件夹</h2>
  </div>
  <div class="close1">关闭</div>
  <input type="text" value=""  placeholder="收藏夹名称（必填）" class="mt30" name="favorite" id="finder_folder_name"/>
  <textarea id="finder_folder_brief" name="memo" placeholder="简介"  rows="5" class="mt30 folder_introduction"></textarea>
  <input type="hidden" id="finder_folder_id" value="1" />
  <p class="mt30">
    <input name="is_open" type="radio" value="1" checked="checked" />
    公开
    <input name="is_open" type="radio" value="0" />
    不公开</p>
  <div class="error_msg" id="error_msg"></div>
  <div class="create_button">
    <input type="button" value="取消" class="button_gray concle-create-folder" onclick="javascript:class_find_layui_win();" />
    <input type="button" value="确定" class="button_red create_finder_folder_enter_btn"/>
  </div>
</div>


<!-- <div id="st-el-1" class=" st-image-share-buttons st-left  st-inline-share-buttons st-animated              st-hide" style="position: absolute; width: 860px; left: 0px; top: 7477px; padding: 8px; box-sizing: border-box;"></div> -->
<input type="hidden" name="imageUrlJs" id="imageUrlJs" value="" />
<script src="/js/sharethis.js"></script>
<script src="/js/5c091d90711a3c0011d0822a.js"></script>
<script src="/js/jquery.qrcode.min.js"></script>
<script>

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

var wx_url = "<?php echo e(url('/article/detail/' . $folder_detail['article']['id'])); ?>";

$("#qrcode").qrcode(wx_url);

  // 添加分享
  var _img = "";
  $('.content-post img').on('mouseenter',function(){
    _img = $(this).attr("src");
    $("#imageUrlJs").val(_img);
  })


$('.user_follow_btn').click(function () {
  var that = $(this)
  if($(this).text() == '关注'){
    var follow_id = $(this).attr('data-id');
    $.ajax({
      url: '/member/add_follow',
      type: 'POST',
      dataType: 'json',
      data: {
        _token: _token,
        follow_id: follow_id
      },
      success: function (data) {
      	// console.log(data)
        if (data.status_code == 0) {
          that.text('已关注')
          that.addClass('have-disalbed')
          layer.msg('关注成功！', {skin: 'intro-login-class layui-layer-hui'})
        } else {
          layer.msg(data.message, {skin: 'intro-login-class layui-layer-hui'})
        }
      }
    })
  }

})



$(".create_finder_folder_enter_btn").click(function () {
  var finder_folder_name = $('#finder_folder_name').val();
  var finder_folder_brief = $('#finder_folder_brief').val();
  var is_open = $("input[name='is_open']").val();
  if (finder_folder_name == '') {
    alert('请填写收藏夹名称！');
    return false;
  }
  $.ajax({
    url: '/vip/add_finder_folder',
    type: 'POST',
    dataType: 'json',
    data: {
      _token:_token,
      finder_folder_name:finder_folder_name,
      finder_folder_brief:finder_folder_brief,
      is_open:is_open
    },
    success: function (data) {
      if (data.status_code == 0) {
        $('#discoveryFolders_1').removeData("open");
        $('#discoveryFolders_1').hide()
        $('#new-find-model-folder').removeData("open");
        $('#new-find-model-folder').hide()
        layer.msg('创建成功！！',{skin: 'intro-login-class layui-layer-hui'})
      } else {
        //alert(data.message);
        $('#error_msg').html(data.message);
      }
    }
  });
});
//创建收藏收藏夹
$(document).on('click','.create_finder_folder_enter_btn',function(ev){
  $data = {};
  $data.favorite = $("#new-find-model-folder [name='favorite']").val();
  $data.memo = $("#new-find-model-folder").find("[name='memo']").val();

  $data.isopen =1;
  if ($("#new-find-model-folder").find("[name='is_open']").prop('checked')) {
    $data.isopen =2;
  }

  if (!$data.favorite) {
    $("#new-find-model-folder .error_msg").text("收藏夹名称必填");
    return false;
  } else {
    $("#new-find-model-folder .error_msg").text("");
  }

  $.post("http://yinji.nenyes.com/finderfuc?action=add_finder_Favorite",$data,function (_res) {

    _obj = eval("("+_res+")");
    if (_obj.msg) {
      $("#new-find-model-folder .error_msg").html(_obj.msg);
    }

    if (_obj.error_code==1) {
      return false;
    } else {
      alert("操作成功");
      layer.closeAll();
    }
  })
  return false;
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
dcarticle_id='';
$(function(){
  dcarticle_id=$('.selected-image').attr('dcarticle_id');
});


$(".add_finder_btn").click(function () {
  let that = $(this)
  let user_finder_folder_id = $(this).attr('data-id');
  let title = $(this).attr('data-title');
  let photo_url = $(this).attr('data-img');
  let source = $(this).attr('data-source');
  let is_sc=1;
  let dcarticle_id=$('.selected-image').attr('dcarticle_id');
  if (photo_url == '') {
    photo_url = $("#imageUrlJs").val();
  }
  if (title == '') {
    title = $("#imgtitle").val();
  }
  // console.log(dcarticle_id)
  $.ajax({
    url: '/vip/finder_collect',
    type: 'POST',
    dataType: 'json',
    data: {
      _token:_token,
      user_finder_folder_id:user_finder_folder_id,
      title:title,
      photo_url:photo_url,
      source:source,
      is_sc:is_sc,
      dcarticle_id:dcarticle_id,
    },
    success: function (data) {
      if (data.status_code == 0) {
        layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
        that.text('已收藏')
        that.removeClass('Button2')
        that.addClass('Button')
        that.addClass('have-disalbed')
      } 
      else{
      	layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
      	that.text('已收藏')
      	// that.css('width','70px')
        that.removeClass('Button2')
        that.addClass('Button')
        that.addClass('have-disalbed')
        
      }
    }
  });
});

//点“收藏”，发现收藏图片到文件夹内

$(document).on('click','.to_find_floder_act',function(ev){
  if ($(".to_find_floder_act").data("open")==1) {
    return false;
  }
  $(".to_find_floder_act").data("open",1);
  $dom = $(this).parents("li");
  photo_source = $dom.find(".folderattr").attr("floder_id");
  user_finder_folder_id=$(this).attr('data-id');
  title = null;
  photo_url=$('.selected-image').attr('src');

  // console.log(user_finder_folder_id,photo_url,photo_source);


 /* $.post("http://yinji.nenyes.com/finderfuc?action=add_find_Collection",$data,function (_res) {

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
  })*/
  return false;

})

//关闭所有展示框
function  class_find_layui_win() {
  $('#new-find-model-folder').removeData("open");
  $('#discoveryFolders_1').removeData("open");
    $("#st-el-1").remove()
  layer.closeAll();
}
$(document).on('click','#discoveryFolders_1 .close2',function(){
  $('#discoveryFolders_1').removeData("open");
  $('#discoveryFolders_1').hide()
})

$(document).on('click','#new-find-model-folder .close1',function(){
  $('#new-find-model-folder').removeData("open");
  $('#new-find-model-folder').hide()
})

//新建文件夹
$(document).on('click','.create-new-folder-btn',function(){
  if ($('#new-find-model-folder').data("open")==1) { return false; }
  $('#new-find-model-folder').data("open", 1);
  // layer.open({
  //   type: 1,
  //   title: false,
  //   closeBtn: 0,
  //   anim: -1,
  //   isOutAnim: false,
  //   content: $('#new-find-model-folder')
  // });
  $('#new-find-model-folder').show()

})

//分享按钮点击
$(document).on('click','.share-img-btn',function(){
  _img = $("#imageUrlJs").val();//$(this).parents(".img-container").find('img.alignnone.size-full').attr("src");
  let dcarticle_id=$('.content-post img').attr('dcarticle_id');
  // console.log(dcarticle_id);
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
        // class_find_layui_win();
        // getDiscoveryFoldersDom(find_favor_list,_img);
        // layer.open({
        //   type: 1,
        //   title: true,
        //   closeBtn: 1,
        //   anim: -1,
        //   isOutAnim: false,
        //   content: $('#discoveryFolders_1')
        // });

        $('#discoveryFolders_1').show()
        break;
    }
  }

})

</script>

