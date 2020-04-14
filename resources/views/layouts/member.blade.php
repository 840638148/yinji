<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <title>@yield('title')</title>

    <script src="/js/jquery-1.10.1.min.js"></script>

    <link href="/css/main.css" rel="stylesheet" type="text/css" />

    <link href="/css/response.css" rel="stylesheet" type="text/css" />

    <!--

    <link href="/css/jquery.fancybox.min.css" rel="stylesheet" type="text/css" />

    <link href="/css/highlight.css" rel="stylesheet" type="text/css" />

    <link href="/css/animate.css" rel="stylesheet" type="text/css" />

    -->

</head>



<body class="bj">





@yield('content')





<!-- 版权 -->



<section class="copyright">



    <div class="wrapper">

 <div class="fl"><a href="/static/about.html">关于印际</a> | <a href="/jobs">招聘中心</a> </div>

        <!--div class="ft_logo fl"><img src="/images/foot_24.gif" alt="印际——中国最好的室内设计资讯平台"></div--->



        Copyright © 2016-<?php echo date('Y'); ?> 印际 | Yinji.space        &nbsp;



        粤ICP备17108593号                &nbsp;

       

        <div class="social fr">

             <a href="#"><img src="/images/foot_31.gif" alt="新浪微博"></a>



            <a  href="javascript:void(0)" onMouseOut="hideImg()"  onmouseover="showImg()"><img src="/images/foot_33.gif" alt="印际微信公众"> <div class="footer_weixin" id="wxImg"><ul><img src="/images/weixinqrcode.jpg" alt="扫一扫二维码"></ul></div></a>



            <a href="#"><img src="/images/foot_35.gif" alt="新浪微博"></a>

              <a href="#"><img src="/images/foot_37.gif" alt="pin"></a>

        </div>

       

    </div>



</section>

 <script type="text/javascript">

    function  showImg(){

    document.getElementById("wxImg").style.display='block';

    }

    function hideImg(){

    document.getElementById("wxImg").style.display='none';

    }

    </script>

<!-- 版权end -->
<!-- 百度统计 -->
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?e08f2882130cf549fbb9a83c44451dca";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<!-- 百度统计结束 -->

</body>

</html>

