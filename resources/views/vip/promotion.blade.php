@extends('layouts.app')

@section('title')



    {{trans('comm.yinji')}}- {{trans('index.the_article_to_promote')}}



@endsection
@section('content')

<div class="about_bj"></div>

<div class="about_nav">

  <ul>

    <li  class="current"><a href="/vip/promotion">{{trans('index.the_article_to_promote')}}</a></li>

    <li><a href="/vip/ad">{{trans('index.advertising_cooperation')}}</a></li>

    <!--<li><a href="vip_service.html">会员服务</a></li>-->
    <li><a href="/vip/vip_service">{{trans('index.membership_service')}}</a></li>

    <li><a href="/vip/job_service">{{trans('index.recruitment_services')}}</a></li>

  </ul>
  
</div>   

<div class="about_box">

  <section class=" wrapper box_dj">

    <div class="" style="border-bottom:1px solid #ddd; padding-bottom:30px;font-size:18px;text-indent:2em">作品推广请联系<a href="#">Edit@yinjispace.com </a> 请将公司简介+作品摄影照片+作品简介（中英文）发送至编辑邮箱。若工作日24小时内没有及时处理您的请求，请投诉<a href="#">CO@yinjispace.com</a></div>

    <div class="promotion" style="text-indent:2em">
      <p style="color: #636af3;font-weight:900;margin-left: -30px;margin-top:15px;">一、设计师入驻</p>
        <p>1，设计师（公司）入驻20000/年，详情页包括设计师简介，外琏到设计师官网及社交网站！</p>
        <p>2，入驻后赠送一个作品发表，赠送招聘一年！</p>
      <p style="color: #636af3;font-weight:900;margin-top:15px;;margin-left: -30px;">二、非撰写仅得到完整资料后排版发布的文章价格</p>
        <p style="font-weight:700;">A.投稿未选中或招标竞赛等情况：</p>
        <p>1，网站项目文章（永久存在） 5000元/篇 ；网站招标，竞赛，招生等文章（限时存在1-2个月） 2000元/篇，每篇文章提供Instagram，，微博宣传一次。</p>
        <p>2，微信公众号头版文章35000元/篇，印际微信公众号坐拥30万+关注者。微信头版文章发布两周后统计平均数为14021，阅读中位区间为12000-20000 （统计数据为印际微信公众号2020年5月1日-2020年5月15日这半个月头版文章阅读数）部分文章阅读数极高极低值不可控，不在此讨论范围内。</p>
        <p>3，网站文章+微信公号文章合买打包价3.6万。 我们的文章版面非常珍贵，每位客户每年不得购买超过3篇。</p>
        <p style="font-weight:700;">B.投稿选中的情况下</p>
        <p>1，网站文章免费发布</p>
        <p>2，预定微信头版 25000-30000元/条。说明：印际网站坐拥100万+读者。网站每周更新40-60篇项目文章。微信公众号头版一周只有7篇，其中1-2篇将作为网站内部招聘，招生，项目对接等服务广告和网站独家专辑所用。为此每周可以共享给项目文章的微信头版为3篇左右。印际微信公众号坐拥15万+粉。如果投稿被选中发布在网站上后，希望文章也出现在微信头版，需缴纳此费用。</p>
      <p style="color: #636af3;font-weight:900;margin-top:15px;;margin-left: -30px;">三、策划撰写，含视频拍摄，照片拍摄的文章（拍摄只含人物和人文，不含建筑物等拍摄）。非标准服务，需要沟通后定价。</p>

    </div>

  </section>

</div>



<!-- 版权 -->


@endsection 

