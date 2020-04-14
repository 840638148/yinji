@extends('layouts.app')

@section('title')

    {{trans('comm.yinji')}} - {{trans($news->title_designer_cn)}}

@endsection



@section('seo_verification')

    {{get_article_title($news)}}

@endsection



@section('seo_description')

    {{get_article_description($news)}}

@endsection



@section('seo_keywords')

    {{get_article_keyword($news)}}

@endsection



@section('content')

    @php

        $first_img_url = get_html_first_imgurl($news->detail->content_cn);

        if ($first_img_url) {

            $first_img_url = url($first_img_url);

        }

    @endphp
        <div class="banner" style="background-image:url({{get_article_special($news)}});">
  <div class="banner_bj"></div>
  <section class="wrapper banner_title" style=" z-index: 1; position: absolute; left: 50%; margin-left: -600px;">
            <div class="new_title">
      <h1 class="cfff">{{get_article_title($news)}}</h1>
      <div class="new_label mt20"> @foreach ($news['category'] as $category) <span>{{$category['name']}}</span> @endforeach | 
                
                <!--时间--> 
                
                <span class="category">{{str_limit($news->release_time, 10, '')}}</span> | 
                
                <!--文章来源--> 
                
                <span> @if ($news->news_source)
        
        {{trans('article.article_source')}}：
        
        @if ($news->news_source_url) <a target="_blank" href="{{$news->news_source_url}}">{{$news->news_source}}</a> @else
        
        {{$news->news_source}}
        
        @endif
        
        @else
        
        {{trans('comm.publish_by')}}
        
        @endif </span> 
                
                <!--地点--> 
                
                <span class="comment"><i class="icon-location"></i>@if('zh-CN' == $lang) {{$news->location_cn}} @else {{$news->location_en}} @endif</span> 
                
                <!--收藏次数--> 
                
                <span class="comment"><i class="icon-bookmark"></i>{{$news->favorite_num}}</span> 
                
                <!--浏览次数--> 
                
                <span class="comment"><i class="icon-eye"></i>{{$news->view_num}}</span> </div>
      <div class="news_keyword mt10">{{trans('article.keyword')}}：{{get_article_keyword($news)}}</div>
    </div>
          </section>
</div>

        <!------顶部大图结束----->

        <section class="wrapper ">
  <div class="cat-wrap left mt20">
            <div class="content-post"> {!!get_article_content($news)!!} </div>
            
            <!---------新闻内容结束-------->
            
            <div class="new_25">
      <ul>
                {{--
                <li><i class="icon-thumbs-up"></i>已赞({{json_encode($news)}})</li>
                --}}
                
                
                
                @if($is_like)
                <li style="width:50%"><i class="icon-thumbs-up" ></i>已赞({{$news->like_num}})</li>
                @else
                <li class="like_article" style="width:50%"><i class="icon-thumbs-up"></i>点赞({{$news->like_num}})</li>
                @endif
                <li style="width:50%"><i class="icon-share"></i>分享
          <div class="fenbox">
                    <div class="jiantou" style="left:45%"></div>
                    <div class="fenxiang" style="width:96%">
              <ul>
                        <li> <a href="javascript:void(0);" title="分享到微信" id="wx_share" class="" rel="nofollow" data-toggle="modal" data-target="#qrcodeModal"> <img src="/images/foot_33.gif" alt="分享到微信"> </a> </li>
                        <li> <a target="_blank" href="https://service.weibo.com/share/share.php?url=http://120.79.234.88/article/detail/1053&amp;title=【2LG Studio | Hither Green , 时代特色与当代设计的融合】&nbsp; &nbsp; &nbsp; &nbsp;位于伦敦南部的一处双面朝向的住宅，需要被注入个性的元素，使它有家的感觉。住在这里的年轻专业新婚夫妇喜欢2LG Studio对色彩的运用，喜欢将时代特色与当代的设计并置。&nbsp;@印际&amp;appkey=&amp;pic=&amp;searchPic=true" title="分享到新浪微博" class="weibo" rel="nofollow"> <img src="/images/foot_31.gif" alt="分享到新浪微博"> </a> </li>
                        <li> <a target="_blank" href="https://connect.qq.com/widget/shareqq/index.html?url=http://120.79.234.88/article/detail/1053&amp;title=2LG Studio | Hither Green , 时代特色与当代设计的融合&amp;desc=&amp;summary=&nbsp; &nbsp; &nbsp; &nbsp;位于伦敦南部的一处双面朝向的住宅，需要被注入个性的元素，使它有家的感觉。住在这里的年轻专业新婚夫妇喜欢2LG Studio对色彩的运用，喜欢将时代特色与当代的设计并置。&amp;site=印际" title="分享到QQ好友" class="qq" rel="nofollow"> <img src="/images/foot_35.gif" alt="分享到QQ好友"> </a> </li>
                        <li> <a target="_blank" href="https://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url=http://120.79.234.88/article/detail/1053&amp;title=2LG Studio | Hither Green , 时代特色与当代设计的融合&amp;desc=&amp;summary=&nbsp; &nbsp; &nbsp; &nbsp;位于伦敦南部的一处双面朝向的住宅，需要被注入个性的元素，使它有家的感觉。住在这里的年轻专业新婚夫妇喜欢2LG Studio对色彩的运用，喜欢将时代特色与当代的设计并置。&amp;site=印际" title="分享到QQ空间" class="qqzone" rel="nofollow"> <img src="/images/foot_37.gif" alt="分享到空间"> </a> </li>
                      </ul>
            </div>
                  </div>
        </li>
              </ul>
    </div>
    		<!--点击微信分享显示二维码-->
            <div class="modal fade" id="qrcodeModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    			<div class="modal-dialog">
                	<div class="modal-content">
        				<div class="modal-header">
                    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"> × </button>
                    		<h4 class="modal-title" id="myModalLabel"> 分享到微信 </h4>
                		</div>
        				<div class="modal-body">
                    		<div id="qrcode">
            					<canvas width="256" height="256"><img src="" /></canvas>
            				</div>
                		</div>
				          <div class="modal-footer">
                    		<button type="button" class="btn btn-primary" data-dismiss="modal">关闭</button>
                		</div>
        			</div>
              </div>
    		</div>
    		<!--点击微信分享显示二维码结束-->
    		
            <div class="article">
      <ul>
                @if($previous_news)
                <li> <img src="{{get_article_thum($previous_news)}}"  alt="{{get_article_title($previous_news)}}" /> <a href="/news/detail/{{$previous_news->id}}">{{trans('article.previous')}}</a>
          <p>{{get_article_title($previous_news)}}</p>
        </li>
                @endif
                
                @if($next_news)
                <li> <img src="{{get_article_thum($next_news)}}"   alt="{{get_article_title($next_news)}}" /> <a href="/news/detail/{{$next_news->id}}">{{trans('article.next')}}</a>
          <p>{{get_article_title($next_news)}}</p>
        </li>
                @endif
              </ul>
    </div>
            <div class="new_article"> <img src="{{get_article_thum($new_news[0])}}"   alt="{{get_article_title($new_news[0])}}" /> <a href="/news/detail/{{$new_news[0]->id}}">{{trans('article.latest')}}</a>
      <p>{{get_article_title($new_news[0])}}</p>
    </div>
            
            <!-------仿QQ留言板-------->
            
            <div id="qq">
      <div class="qq_liuyan">
                <h2 class="left">留言</h2>
                <span class=" right">共<span class=" c_red">{{$comments_total or '0'}}</span>条留言</span> </div>
      <div class="msgCon"> @foreach ($comments as $comment)
                <div class="msgBox">
          <dl>
                    <dt><img src="/img/avatar.png" width="50" height="50"></dt>
                    <dd>{{$comment->user->nickname}} <i>vip1</i><span>发布于：{{$comment->created_at}}</span></dd>
                    <div class="msgTxt">{!!$comment->content!!}</div>
                  </dl>
        </div>
                @endforeach </div>
      <div class="message" contentEditable='true'></div>
      <div class="But"> <span class='submit' data-comment-type="news">发表</span> <img src="/images/qq/ico-biaoqing.png" class='bq'/> 
                
                <!--face begin--> 
                
                @component('face')
                
                
                
                @endcomponent 
                
                <!--face end--> 
                
              </div>
    </div>
            <script type="text/javascript">



                //点赞

                $(".like_article").click(function(e){

                    var that = $(this)

                    var like_id = '{{$news->id}}';

                    if(that.text().indexOf('点赞')>-1){

                        $.ajax({

                            url: '/news/like',

                            type: 'POST',

                            dataType: 'json',

                            data: {_token: '{{csrf_token()}}', like_id: like_id},

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

                        })

                    }

                })







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

                var comment_id = '{{$news->id}}';

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
            
          </div>
  
  <!-------左边新闻结束--->
  
  <!--<div class="detail_right cat4_sidebar cat4_sidebar" >-->
  <div class="sidebar right cat4_sidebar" style="margin-top:-220px;position: absolute;right: 50%;margin-right: -600px;">
            <article designerid="2690">
      <div class="item author-info">
                <div class="users"> @if ($designer)
          <div class="border-bottom1" style="position:relative">
                    <div class="head"><img src="{{get_designer_thum($designer)}}" width="440" height="375" alt="{{get_designer_title($designer)}}"></div>
                    @if ('1' == $designer->industry)
                    <div class="biaoqian">INTERIOR</div>
                    @else
                    <div  class="biaoqian">ARCHITECT</div>
                    @endif
                    <h2><a href="@if($designer->static_url) /designer/{{$designer->static_url}} @else /designer/detail/{{$designer->id}} @endif">{{get_designer_title($designer)}}</a> </h2>
                  </div>
          <div class="Statistics">
                    <ul>
              <li><span> {{$designer->article_num}} </span>作品</li>
              <li><span> {{$designer->subscription_num}} </span>粉丝</li>
            </ul>
                  </div>
          @if($is_subscription) <span class="Button have-disalbed designer" url="#" title="设计师订阅" designer_id="{{$designer->id}}">已订阅 </span> @else <span class="Button3 wpfp_designer_act designer" url="#" title="设计师订阅" designer_id="{{$designer->id}}">订阅</span> @endif
          
          
          
          
          
          @endif
          
          @if ($more_designer)
          <div class="mt20 more_design"><a href="#" >{{trans('designer.more_designers')}} <i class="icon-eye"></i> </a></div>
          <div class="works_design">
                    <ul>
              @foreach ($more_designer as $designer)
              <li>
                        <div class="more_head fl"><img src="{{get_designer_thum($designer)}}" alt="{{get_designer_title($designer)}}"  class="left"/></div>
                        <div class="right" style="width:160px; text-align:left">
                  <h3><a href="@if($designer->static_url) /designer/{{$designer->static_url}} @else /designer/detail/{{$designer->id}} @endif" title="{{get_designer_title($designer)}}" target="_blank">{{get_designer_title($designer)}}</a></h3>
                  @if ('1' == $designer->industry)
                  <p>INTERIOR  @if (!$designer->is_subscription)<a href="javascript:void(0)" class="right subscription_next_designer" designer_id="{{$designer->id}}">+订阅</a>@endif</p>
                  @else
                  <p>Architect  @if (!$designer->is_subscription)<a href="javascript:void(0)" class="right subscription_next_designer" designer_id="{{$designer->id}}">+订阅</a>@endif</p>
                  @endif </div>
                      </li>
              @endforeach
            </ul>
                  </div>
          @endif </div>
              </div>
    </article>
            <script type="text/javascript">

          $(document).ready(function(){

              // 判断是否有设计师

        if($('.users').html().trim()){

            $('.users').css('visibility','visible')

        }else{

            $('.users').css('height','216px')

        }

          $(".icon-eye").click(function(){

          $(".works_design").toggle();

          });

          });

          </script> 
            
            <!--------设计师结束----------->
            
            <article id="text-3" class="sidebar_widget box widget_text wow bounceInUp triangle animated" style="visibility: visible; animation-name: bounceInUp;"> @if (isset($ads_right))
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
                    @foreach ($ads_right as $right)
                    <li><a href="{{$right->ad_url}}" target="_blank" rel="noopener"><img src="{{url('uploads/' . $right->ad_img)}}"></a></li>
                    @endforeach
                  </ul>
        </div>
                <p><!-- 右侧广告代码 结束 --></p>
              </div>
      @endif </article>
            <div class="sidebar right">
      <section class="label_right_title">
                <h2>{{trans('index.hot_tags')}}</h2>
              </section>
      <div class="label">
                <ul>
          @foreach ($hot_tags as $tag)
          <li><a href="javascript:void(0)" onclick="goToTarget(this)">@if('zh-CN' == $lang) {{$tag->name_cn}} @else {{$tag->name_en}} @endif</a></li>
          @endforeach
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
  <div class="pic-name" style="padding: 8px;">
            <label for="" style="font-size: 14px;color: #333;"> 图片名称 </label>
            <input type="text" name="imgtitle" id="imgtitle" value="" placeholder="图片名称" style="width: 476px;">
          </div>
  <div class="collection_to">
            <ul class="discover-folders2">
      @foreach($user_finder_folders as $key => $value)
      <li>
                <h3>{{$value}}</h3>
                <span img="" floder_id="{{$key}}" class="folderattr null" title="{{$value}}"></span> <a href=" " class="Button2 fr to_find_floder_act add_finder_btn" data-id="{{$key}}" data-img="" data-source="{{$news->id}}">收藏</a > </li>
      @endforeach
    </ul>
          </div>
  <a href="#" class="create create-new-folder-btn">创建收藏夹</a>
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

        <!--弹窗--> 

        <!-- 登录 -->

        <div class="login_box" style="display:none;">
  <div class="new_folder_bj"></div>
  <div class="login_folder">
            <div id="login" class="login"> 
      
      <!--		<h1><a href="--><!--" title="--><!--" tabindex="-1">--><!--</a></h1>-->
      
      <h1><a href="/indx" title="{{trans('comm.yinji')}}" tabindex="-1">{{trans('comm.yinji')}}</a></h1>
      <h2>{{trans('login.login_title')}}</h2>
      
      <!-- 登陸 -->
      
      <form name="loginform" id="loginform" action="/user/login" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <p>
          <label for="user_login">
                    <input type="text" name="user_login" id="user_login" class="input" value="" size="20"



                                   placeholder="{{trans('login.input_username')}}">
                  </label>
        </p>
                <p>
          <label for="user_pass">
                    <input type="password" name="password" id="user_pass" class="input" value="" size="20" placeholder="{{trans('login.input_password')}}">
                  </label>
        </p>
                <p class="forgetmenot">
          <label for="rememberme">
                    <input name="rememberme" type="checkbox" id="rememberme"



                                   value="forever">
                    {{trans('login.remember_me')}} </label>
        </p>
                <p class="submit">
          <input type="button" name="wp-submit" id="wp-submit-login" class="button button-primary button-large"



                               value="{{trans('login.login')}}">
          <input type="hidden" name="redirect_to" value="/user/index">
          <input type="hidden" name="testcookie" value="1">
        </p>
              </form>
      <div style=" overflow:hidden">
                <p id="nav" class="fr"> <a href="/user/register">{{trans('login.register')}}</a> | <a



                                href="/user/forgot_password">{{trans('login.forgot_password')}}</a> </p>
                <p class="fl"> <a href="/"> ← {{trans('login.return')}} </a> </p>
              </div>
      <div class=""> <span style="float:left; line-height:36px;color: #999;"> {{trans('login.other_login')}}：</span> <a href="javascript:void(0);" onclick="WeChatLogin();" title="使用微信登录"><img src="/img/tl_weixin.png"></a> </div>
      <div class="login_ico"> <a href="javascript:void(0);" onclick="WeChatLogin();"><img src="/img/erweima.gif" width="51"



                                                                                                    height="51" alt="二维码登陆"></a> </div>
      <div class="ma_box hide">
                <h1><a href="/index" title="{{trans('comm.yinji')}}" tabindex="-1">{{trans('comm.yinji')}}</a></h1>
                
                <!-- <h2>微信扫码登陆</h2> --> 
                
                <!--

                    <p>

                        <iframe frameborder="0" scrolling="no" width="365" height="395"



                                src="/auth/weixin"></iframe>

                    </p>

                    -->
                
                <p class="backtoblog" style="text-align:center"> <a href="/"> ← {{trans('login.return')}} </a> </p>
                <div class="login_ico"><a href="javascript:void(0);" onclick="WeChatLogin();"><img



                                    src="/img/diannao_03.gif" width="51" height="51" alt="账号登陆"></a></div>
              </div>
    </div>
          </div>
</div>

        <!--登陆结束--> 

        <!--------选购会员弹窗------->

        <div class="new_folder_box" style="display:none;">
  <div class="new_folder_bj"></div>
  <div class="create_folder">
            <div class="create_folder_title">
      <h2>成为会员</h2>
    </div>
            <div class="close vip_close">关闭</div>
            <div class="vip_select mt30">
      <ul>
                <li class="determine vipfee_type1" vip_level="1" price="{{$month_price or '0.01'}}" omit="88"><em>{{$month_price or '0.01'}}</em>元
          <p>月会员</p>
          <del>原价：88元</del></li>
                <li class="vipfee_type2" vip_level="2" price="{{$season_price or '0.01'}}" omit="299"><em>{{$season_price or '0.01'}}</em>元
          <p>季会员</p>
          <del>原价：299元</del></li>
                <li class="vipfee_type3" vip_level="3" price="{{$year_price or '0.01'}}" omit="1999"><em>{{$year_price or '0.01'}}</em>元
          <p>年会员</p>
          <del>原价：1999元</del></li>
              </ul>
    </div>
            <div class="vip_check">
      <ul>
                <li>
          <input name="" type="checkbox" value="" checked="checked" />
          到期自动续费一个月，可随时取消</li>
                <li>
          <input name="" type="checkbox" value="" />
          <a href="#">同意并接受《服务条款》</a></li>
              </ul>
    </div>
            <div class="vip_pay">
      <form class="cart vip_pay" action="/vip/wxbuy" method="post" enctype="multipart/form-data">
                <input type="hidden" name="vip_type" id="vip_type" value="1" />
                <input type="hidden" name="payment_code" id="payment_code" value="wechatpay" />
                <input type="hidden" name="pay_total" id="pay_total" value="{{$month_price or '0.01'}}" />
                <input type="hidden" name="open_id" id="open_id" value="ohPM_1TdJ-oXTAWy7rP-82CT3glo" />
                <p class="vip_pay_msg">应付：<span>{{$month_price or '0.01'}}</span>元 ( 立省88元)</p>
                <p>
          <button type="button" class="single_add_to_cart_button button_red alt" id="buy_now_button">立即购买 </button>
        </p>
              </form>
    </div>
          </div>
</div>

        <!--------选购会员结束------->

        <input type="hidden" name="imageUrlJs" id="imageUrlJs" value="" />

        <!--VIP专栏提示-->

        <div class="vip_prompt modal" id="vip-img"><a href="#" class="vip_buy">开通VIP会员</a><a href="#" class="vip_detail">了解VIP详情>></a></div>

        <!--VIP专栏提示结束--> 

        <script src="/js/sharethis.js"></script> 
        <script src="/js/5c091d90711a3c0011d0822a.js"></script> 
        <script>



            function goToTarget(t) {

                var value = $(t).text()

                if (value && value != '') {

                    window.location.href = '/search?keyword=' + encodeURIComponent(value);

                }

            }



            var timer = setInterval(function(){

                console.log($('.st-btn'))

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

                        data: {_token:'{{csrf_token()}}',designer_id:designer_id},

                        success: function (data) {

                            if (data.status_code == 0) {

                                that.remove()

                            } else {

                                layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'})

                            }

                        }

                    });

                }

            });



   //订阅功能

            $(document).on('click','.wpfp_designer_act.designer',function(){

                var that =  $(this)

                if(!IS_LOGIN){

                    $('.login_box').show();

                }else{

                    if(that.text().trim()=='订阅') {

                        var designer_id = $(this).attr('designer_id');

                        $.ajax({

                            url: '/designer/subscription',

                            type: 'POST',

                            dataType: 'json',

                            data: {_token: '{{csrf_token()}}', designer_id: designer_id},

                            success: function (data) {

                                if (data.status_code == 0) {

                                    that.text('已订阅')

                                    that.removeClass('Button3')

                                    that.addClass('Button')

                                    that.addClass('have-disalbed')

                                } else {

                                    alert(data.message);

                                }

                            }

                        });

                    }

                }





            })







    //分享按钮点击

    $(document).on('click','.share-img-btn',function(){

            _img = $("#imageUrlJs").val();//$(this).parents(".img-container").find('img.alignnone.size-full').attr("src");

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

                    // getDiscoveryFoldersDom(find_favor_list,_img);

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

        h += '      <ul class="discover-folders">';

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
        {{--会员购买模块--}} 
        <script>



        _omit  = 58;

        _price = '0.01';







        $(document).on("submit",".cart",function () {



            var agree = document.getElementById("agree").checked;







            if (!agree) {







                alert('请阅读并接受《服务条款》');



                return false;



            }



        });







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

            // listen if someone clicks 'Buy Now' button



            // if(!IS_LOGIN){

            //     $('.login_box').show()

            // }

            $(document).on("click","#buy_now_button",function(){

                var vip_type = $('#vip_type').val();

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
        {{--登录模块--}} 
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
        @endsection