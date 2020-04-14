$(function(){

    // 最新文章
    $('.new_list li').each(function(){
        var text = $(this).find('h2 p').eq(0).text();
        $(this).find('figure>a').append('<div class="new-article-author" style="height:'+ $(this).height() +'">'+text+'</div> ')
    })

    $('#slongposts-4 .postlist figure').each(function(){
        var text = $(this).find('a').attr('title').split('|')[0];
        $(this).find('a').append('<div class="new-article-author" style="height:'+ $(this).height() +';width:'+ $(this).parent('.postlist').width() +';font-size:14px;">'+text+'</div> ')
    })
    $('.design_box .design_right li').each(function(){
        var text = $(this).find('img').attr('title');
        $(this).css('position', 'relative')
        $(this).find('a').append('<div class="new-article-author" style="height:'+ $(this).height() +';width:'+100 +'%;font-size:14px;">'+text+'</div> ')
    })


    // 猜你喜欢点击图片加载到大图

    $(document).on('click','.like .like_title li img',function(){
        var imgSrc = $(this).attr('src')
        var imgOriginalSrc = $(this).attr('data-original');
        var imgAlt = $(this).attr('alt')

        var $img = $('.like .like_title figure img');
        $img.attr('src', imgSrc + '&h=338&w=600')
        $img.attr('data-original', imgOriginalSrc +'&h=338&w=600')
        $img.attr('alt', imgAlt)
    })

    // 右边栏轮播
    // 模拟you多个
    // $('.oUlplay').append('<li><a href="http://trolan.tyyke.com:39007" target="_blank" rel="noopener"><img src="http://120.79.234.88/uploads/public/photo/images/popularize/c77f4f2ad640c78afc0d01ea885ed469.gif"></a></li>')
    // $('.oUlplay').append('<li><a href="http://trolan.tyyke.com:39007" target="_blank" rel="noopener"><img src="http://120.79.234.88/uploads/public/photo/images/popularize/c77f4f2ad640c78afc0d01ea885ed469.gif"></a></li>')
    $('.oUlplay').append('<li><a href="http://trolan.tyyke.com:39007" target="_blank" rel="noopener"><img src="http://120.79.234.88/uploads/public/photo/images/popularize/c77f4f2ad640c78afc0d01ea885ed469.gif"></a></li>')
    
    $('.oUlplay li').each(function(){
        $(this).addClass('swiper-slide')
    })

    $('.oUlplay').addClass('swiper-wrapper')

    var indexRightBarAdSwiper = new Swiper('#playBox',{
        autoplay: 3000,
        pagination: '#playBox .smalltitle',
        paginationClickable: true,
        prevButton:'#playBox .pre',
        nextButton:'#playBox .next',
    })

})