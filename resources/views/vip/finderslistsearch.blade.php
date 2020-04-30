@extends('layouts.app')

@section('title')
    {{trans('comm.yinji')}} - {{trans('comm.second_title')}}
@endsection

@section('content')
<style>
    .imgvip{ width:32px !important;}
</style>
<!--笼罩层-->
<div class="lzcfg"  style="background: rgba(0,0,0,0.5);position: fixed;left: 0px;top: 0px;width: 100%;height: 100%;display: none;z-index: 99999999;"></div>
<div class="banner_news" style="background-image:url(/images/find.jpg)"> —— NEWS —— </div>

    
<div class="TabContent" style="padding-top:0;"> 
     
    <!--发现-->
    <div id="myTab1_Content0" style="width:1200px;padding-bottom: 20px;margin:30px auto;">
        <h1 style="width:100%;text-align:center;margin:30px auto;">发现 - 搜索中心<a style="padding: 10px;background: #636af3;color: #fff;float: right;font-size:16px;" href="javascript:history.go(-1);">返回</a></h1>

       <div class="masonry" id="discoveryItems"> 
            @if($result=='')
            没有数据 
            @else
                {!!$result!!}
            @endif
            
        </div>
    </div>
</div>     



<!--创建收藏文件夹-->

<div class="create_folder modal" id="new-find-model-folder" style="height:450px">
    <div class="create_folder_title">
        <h2>创建收藏文件夹</h2>
    </div>
    <div class="close">关闭</div>
    <input type="text" value=""  placeholder="收藏夹名称（必填）" class="mt30" name="favorite" id="finder_folder_name"/>
    <textarea id="finder_folder_brief" name="memo" placeholder="简介"  rows="5" class="mt30 folder_introduction"></textarea>
    <input type="hidden" id="finder_folder_id" value="1" />
    <p class="mt30"> <i class="sourceinput" sourceid=""></i>
        <input name="is_open" type="radio" value="1" checked="checked" />
        公开
        <input name="is_open" type="radio" value="0" />
        不公开 </p>
    <div class="error_msg" id="error_msg"></div>
    <div class="create_button">
        <input type="hidden" name="folder_type" id="add_folder_type"  />
        <input type="button" value="取消" class="button_gray concle-create-folder" />
        <input type="button" value="确定" class="button_red create_finder_folder_enter_btn"/>
    </div>
</div>




<!-- 点击图片出现展示框 -->
<div class="img_browse modal" id="discovery-img-browse" >
  <div class="close">关闭</div>
  <div class="left">
    <div style="height:48px;">
      <h2 class="fl" id="discovery-folder-name">文件夹名称</h2>
      <span class="fr">分享到：</span> </div>
    <div class="image"><img src="images/imges.jpg" alt="发现的图片" class="selected-image"/> </div>
  </div>
  <div class="right" style="margin-top:48px;">
    <div class="more_img"> <a href="#" class="more-img-item selected"><img src="/images/imges.jpg" alt="图片一" />
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
      <h2><a href="#">大仁哥10327</a> <span class="vip1"><img class="imgvip" width="32px" src="/images/v_0.png" />VIP</span></h2>
      <a class="Button">关注</a> </div>
    <hr />
    <div class="faxian_info">
      <p>从 <a href="#">严PPPPPPPP1</a> 收藏于 <a href="#">大厅</a></p>
      <p>2017-06-02 14:59:57</p>
      <p class="laiyuan"><a href="#">来源：Lera Brumina作品 | 80㎡ Apartmen...</a></p>
    </div>
  </div>
</div>


<script>
    $('#search-btn').on('click',function(){
        var value = $('#keywords').val();
        window.location.href = '/search?keyword=' + encodeURIComponent(value);
    });

    //点击关注用户
    $('.users').on('click', '.user_follow_btn', function(){
      var follow_id = $(this).attr('data-id');
      var that = $(this)
      $.ajax({
        url: '/member/add_follow',
        type: 'POST',
        dataType: 'json',
        data: {
          _token:_token,
          follow_id:follow_id
        },

        success: function (data) {
          if (data.status_code == 0) {
            layer.msg('关注成功！',{skin: 'intro-login-class layui-layer-hui'})
            that.text('已关注')
            that.removeClass('Button3')
            that.addClass('Button')
            that.addClass('have-disalbed')
          } else {
            layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})
          }
        }
      });
    });


    //获取收藏图片的每一个
    function getImgBrowseImgsDom(imgs,id,index){
      var imgsArr = imgs || [];
      var idx = index || 0;
      var h = '';
      imgsArr.map(function(img, i){
        h += '<a href="#" class="more-img-item ' + (parseInt(idx) === i ? 'selected' : '') + '"><img src="' + img.src + '" alt="'+img.text+'" /> <div class="cover"></div></a>';
      })
      $( id + ' .selected-image').attr('src',imgsArr[idx].src);
      $(id + ' .more_img').html(h);
    }


    function wp_attempt_focus(){
      setTimeout( function(){ try{
        d = document.getElementById('user_login');
        d.focus();
        d.select();
      } catch(e){}
      }, 200);
    }

    //切换图片

    $(document).on('click','.more-img-item',function(){
      var src = '';
      //去除所有选中状态
      $('.more-img-item').each(function(){
        $(this).removeClass('selected');
      })

      // 添加选中状态
      $(this).addClass('selected');
      src = $(this).find('img').attr('src');
      $(this).parents('.img_browse').find('.selected-image').attr('src',src);
    })


    // 发现展示图片框
    $(document).on('click','.discovery-item #sourceimg',function(){
      var folder_id = $(this).attr('data-id');
      $.ajax({
        async:false,
        url: '/vip/get_folder_detail',
        type: 'POST',
        //dataType: 'json',
        data: {
          _token:_token,
          folder_id:folder_id
        },
        success: function (data) {
          console.log(data);
          $('#discovery-img-browse').html(data);
          //初始化相框
          //getImgBrowseImgsDom(browseImgs,'#discovery-img-browse');
          layer.open({
            type: 1,
            title: false,
            closeBtn: 0,
            anim:-1,
            isOutAnim:false,
            content: $('#discovery-img-browse')
          });
        }
      });
    })

    //关闭所有展示框
    $(document).on('click','.modal .close',function(){
      layer.closeAll();
    })

    //关闭所有展示框
    $(document).on('click','.modal .concle-create-folder',function(){
      layer.closeAll();
    })

    $(document).on('click','.item_content .folder',function(){
      var moreEle =  $(this).find('.show-more-selcect-item')
      if(moreEle.hasClass('showbox')){
        moreEle.parent().css('width','80%');
        moreEle.show()
        moreEle.css('background-position','0px 0px');
        moreEle.parents('.folder').siblings('.folder_box').css('display','none');
        moreEle.removeClass('showbox')
        $(this).find('.add-collection-btn').show()
      }else{
        moreEle.parent().siblings('.add-collection-btn').hide()
        moreEle.parent().css('width','100%');
        moreEle.css('background-position','0px -36px');
        moreEle.parents('.folder').siblings('.folder_box').css('display','block');
        moreEle.addClass('showbox');
        $(this).find('.add-collection-btn').hide()
      }
    })


    // 发现页面展示收藏
    $(document).on('mouseenter','.discovery-item',function(){
      $(this).find('.folder').css('display','block');
    })

    $(document).on('mouseleave','.discovery-item',function(){
      $(this).find('.folder').css('display','none');
      $(this).find('.folder_box').css('display','none');
      $(this).find('.folder_bj').css('width','80%');
      $(this).find('.folder_bj').siblings('.add-collection-btn').show();
      $(this).find('.folder_bj .show-more-select-item').removeClass('showbox');
      $(this).find('.folder_bj .show-more-select-item').css('background-position','0px 0px');
    })

        //点击展示谁发现按钮
    $(document).on('click','.find_info_more',function(ev){
        var dasou=$(this).parent().attr('data-source');
        // alert(dasou);
        ev.stopPropagation()
        $(this).parents('.find_title').siblings('.who_find').each(function(){
            var isShow = $(this).css('display');
            if(isShow == 'block'){
                $(this).css('display','none');
            }else{
                $(this).css('display','block');
            }
        })
    })


    //关闭创建收藏夹窗口
    $(document).on('click','.modal .close',function(){
    	$('#new-find-model-folder').css('display','none');
    	$('.lzcfg').css('display','none');
    })
    $(document).on('click','.concle-create-folder',function(){
    	$('#new-find-model-folder').css('display','none');
    	$('.lzcfg').css('display','none');
    })


	  //创建收藏收藏夹窗口
     $(document).on('click','.create-new-folder',function(){
        $('.lzcfg').css('display','block');
        $('.showscbtn').css('display','none');
        $('.showscbtn').css('z-index','-99999999');
        $('#new-find-model-folder').css('display','block');
        $('#new-find-model-folder').css('position','position');
        $('#new-find-model-folder').css('z-index','99999999999');
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

		$('#new-find-model-folder').css('display','none');
		$('.showscbtn').css('display','block');
		$('.showscbtn').css('z-index','99999999999');
		$('.lzcfg').css('display','none');
    location.reload();
    })
</script>



@endsection



