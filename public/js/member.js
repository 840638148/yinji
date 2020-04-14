function getItemSettingTab(folder_type, folder_id){
    var h = '<div class="item-setting-btns">';
    h += '<p class="create-folder-btn" folder-type="' + folder_type + '" data-id="' + folder_id + '" >编辑文件夹</p>';
    h += '<p class="remove-folder-btn" folder-type="' + folder_type + '" data-id="' + folder_id + '" >删除</p>';
    h += '</div>';
    return h;
}

$('.item .edit_favorites').each(function(){
    var folder_type = $(this).attr('folder-type');
    var folder_id = $(this).attr('data-id');
    $(this).html(getItemSettingTab(folder_type, folder_id));
    $(this).addClass('item-setting-btn');
})

$(document).on('click','.edit_favorites',function(){
    if($(this).children('.item-setting-btns').css('display') == 'none'){
        $(this).children('.item-setting-btns').show();
        $(this).parents('.item').css('marginBottom','1px')
    }else{
        $(this).children('.item-setting-btns').hide();
    }
})


$('.item__content').hover(function () {
},function () {
    if($(this).find('.item-setting-btns').css('display') == 'block'){
        $(this).find('.item-setting-btns').hide()
    }
})


//个人中心的创建新文件夹
$(document).on('click','.create-new-folder',function(ev){
    var type = $(this).attr('data-type'); 
    $('#add_folder_type').val(type);
    
    $('#add_is_open').prop("checked","checked");
    
    $('#newFolders .create_folder_title h2').html('创建' + (type == 'find' ? '发现' : '收藏')+ '文件夹')
    ;    layer.open({
        type: 1,
        title: false,
        closeBtn: 0,
        anim: -1,
        isOutAnim: false,
        content: $('#newFolders'),
        success: function (layero, index) {
        	// console.log(layero, index)
            $('.newFolders').data("open", 1);
            // window.location.reload;
        }
    })
    return false;
});

$(document).on('click','.add_folder_btn',function(ev){
    var folder_name = $('#add_folder_name').val();
    
    if (folder_name == '') {
        alert('请输入收藏夹名称');
        return false;
    }
    var is_open = $("input[name='add_is_open']:checked").val();
    var brief = $('#add_brief').val();   
    var folder_type = $('#add_folder_type').val();
    var articleid=$('#sourceimg').attr('source')  

    if (folder_type == 'find') {  
        var url = '/vip/add_finder_folder';      
        var folder_data = {
            _token:_token,
            is_open:is_open,
            finder_folder_brief:brief,
            finder_folder_name:folder_name,
            articleid:articleid,
        };
    } else {
        var url = '/vip/add_collect_folder';
        var folder_data = {
            _token:_token,
            is_open:is_open,
            collect_folder_brief:brief,
            collect_folder_name:folder_name,
            articleid:articleid,
        };
    }    

    $.ajax({
        async:true,
        url: url,
        type: 'POST',
        dataType: 'JSON',
        data: folder_data,  
        success: function (data) {
        	console.log(data);
            var str="<li><h3>"+data.name+"</h3><span img='' floder_id='"+data.kid+"' class='folderattr null' title='"+data.name+"'></span><a href='javascript:void(0);' class='Button2 fr to_find_floder_act add_finder_btn' data-id='"+data.kid+"' data-img='' data-source='"+data.articleid+"'>收藏</a ></li>";
            
            if (data.status_code == 0) {   
                layer.closeAll();
                layer.msg('创建成功',{skin: 'intro-login-class layui-layer-hui'});
                $('.folder_box ul').append(str);
            } else {
                layer.msg(data.message,{skin: 'intro-login-class layui-layer-hui'});
            }
        }
    });
  
    return false;
});

   

//编辑文件夹
$(document).on('click','.create-folder-btn',function(ev){
    var url = '/vip/get_folder_info';
    var folder_type = $(this).attr('folder-type');
    var folder_id = $(this).attr('data-id');
    $('#edit_folder_type').val(folder_type);
    $('#edit_folder_id').val(folder_id);

    var folder_data = {
        _token:_token,
        folder_type:folder_type,
        folder_id:folder_id,
    };
    $.ajax({
        async:false,
        url: url,
        type: 'POST',
        dataType: 'json',
        data: folder_data,
        success: function (data) {
            if (data.status_code == 0) {
                $('#edit_folder_id').val(data.data.id);
                $('#edit_folder_name').val(data.data.name);
                $('#edit_brief').val(data.data.brief);
                $('#edit_is_open').val(data.data.is_open);
                layer.open({
                    type: 1,
                    title: false,
                    closeBtn: 0,
                    anim: -1,
                    isOutAnim: false,
                    content: $('#collectionFolders'),
                    success: function (layero, index) {
                        $('.collectionFolders').data("open", 1);
                    }
                })
            } else {
                alert(data.message);
            }
        }
    });

    return false;
});


$(document).on('click','.edit_folder_btn',function(ev){
    var folder_name = $('#edit_folder_name').val();
    if (folder_name == '') {
        alert('请输入收藏夹名称');
        return false;
    }

    var folder_id = $('#edit_folder_id').val();
    var is_open = $("input[name='edit_is_open']:checked").val();
    var brief = $('#edit_brief').val();

    var folder_type = $('#edit_folder_type').val();
    var url = '/vip/edit_folder_info';
    var folder_data = {
        _token:_token,
        folder_type:folder_type,
        folder_id:folder_id,
        folder_name:folder_name,
        folder_brief:brief,
        is_open:is_open,
    };

    $.ajax({
        async:false,
        url: url,
        type: 'POST',
        dataType: 'json',
        data: folder_data,
        success: function (data) {
            if (data.status_code == 0) {
                layer.closeAll();
                layer.msg('编辑成功',{skin: 'intro-login-class layui-layer-hui'})
                location.href=location.href
            } else {
                alert(data.message);
            }
        }
    });

    return false;
});


//删除文件夹
$(document).on('click','.remove-folder-btn',function(ev){
    // if (!confirm("确定删除？")) {
    //     return false;
    // }
    var folder_type = $(this).attr('folder-type');
    var folder_id = $(this).attr('data-id');
    layer.confirm('确定删除这条数据吗？', {btn: ['确定','取消'] , skin: 'intro-login-class layer-confirm'},
        function(){layer.closeAll('dialog');
            deleteData(folder_type,folder_id)
        });



})

function deleteData(folder_type,folder_id){
    var url = '/vip/delete_folder';
    var folder_data = {
        _token:_token,
        folder_id:folder_id,
        folder_type:folder_type,
    };
    $.ajax({
        async:false,
        url: url,
        type: 'POST',
        dataType: 'json',
        data: folder_data,
        success: function (data) {
            if (data.status_code == 0) {
                layer.closeAll();
                window.location.reload();
            } else {
                alert(data.message);
            }
        }

    });
}

// 签到
$(document).on('click','.bookInSign',function(){
    layer.open({
        type: 1,
        title: false,
        closeBtn: 0,
        anim: -1,
        shadeClose: true,
        isOutAnim: false,
        content: $('#bookInSign')
    })
})

//切换签到tab
$(document).on('click','.sign_tab li',function(){
    var index = $(this).index();
    if(!$(this).hasClass('active')){
        $(this).addClass('active');
        $(this).siblings().removeClass('active');

        $('.tab_box').eq(index).show();

        $('.tab_box').eq(index).siblings('.tab_box').hide();
    }

})
$(document).on('click','.record li',function(){
    var index = $(this).index();
    if(!$(this).hasClass('active')){
        $(this).addClass('active');
        $(this).siblings().removeClass('active');
    }

})

$(document).on('click','.my-finder .item_content > li',function(){
// alert('安顺达杀手');
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
            $('#img-browse').html(data);
            //初始化相框
            // getImgBrowseImgsDom(browseImgs,'#discovery-img-browse');
            layer.open({
                type: 1,
                title: false,
                closeBtn: 0,
                anim:-1,
                isOutAnim:false,
                content: $('#img-browse')
            });
        }
    });
})
//关闭所有展示框
$(document).on('click','.modal .close',function(){
    layer.closeAll();
})
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

$(document).on('click','#attendance',function(){
    $.ajax({
        url: '/member/attendance',
        type: 'POST',
        dataType: 'json',
        data: {
            _token:_token
        },
        success: function (data) {
            if (data.status_code == 0) {
                $('#user-point').html(data.data.points);
                $('#last-day').html(data.data.last_days);
                alert('签到成功！');
            } else {
                alert(data.message);
            }
        }
    });

})


//删除发现图片
$(document).on('click','.remove_find_img',function(ev){
    if (!confirm("确定删除？")) {
        return false;
    }

    var finder_id = $(this).attr('data-id');
    var url = '/member/delete_finder_item';
    var folder_data = {
        _token:_token,
        finder_id:finder_id,
    };

    $.ajax({
        async:false,
        url: url,
        type: 'POST',
        dataType: 'json',
        data: folder_data,
        success: function (data) {
            if (data.status_code == 0) {
                alert('删除成功！');
                window.location.reload();
            } else {
                alert(data.message);
            }
        }
    });

    return false;
});

//刷新保持浏览器位置
window.onbeforeunload = function() {
    var scrollPos;
    if(typeof window.pageYOffset != 'undefined') {
        scrollPos = window.pageYOffset;
    } else if(typeof document.compatMode != 'undefined' &&
        document.compatMode != 'BackCompat') {
        scrollPos = document.documentElement.scrollTop;
    } else if(typeof document.body != 'undefined') {
        scrollPos = document.body.scrollTop;
    }
    document.cookie = "scrollTop=" + scrollPos; //存储滚动条位置到cookies中
}
window.onload = function() {
    if(document.cookie.match(/scrollTop=([^;]+)(;|$)/) != null) {
        var arr = document.cookie.match(/scrollTop=([^;]+)(;|$)/); //cookies中不为空，则读取滚动条位置
        document.documentElement.scrollTop = parseInt(arr[1]);
        document.body.scrollTop = parseInt(arr[1]);
    }
}