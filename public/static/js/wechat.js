/**
 * ---------------------------------------------
 * layui后台数据处理
 * ---------------------------------------------
 * Author  dorisnzy@163.com
 * ---------------------------------------------
 * Date 2017-12-20
 * ---------------------------------------------
 */


/**
 * form 表单验证并提交
 * @param object box_form form选择器
 * @param string node 提交按钮节点 ||类名||id值
 * @param string btn_info 提交按钮value属性值
 * @param object element 填充html的jq元素对象
 * @author doris <dorisnzy@163.com>
 */ 
var subForm = function(box_form, node, btn_info, element) {
	var box_form    = (box_form != null) ? box_form : 'form';
	var node 		= (node != null)     ? node     : '#ajaxPost';
	var btn_info 	= (btn_info != null) ? btn_info : '提交';
	var element     = (element != null)  ? element  : '#formElement';

	var obj = $(box_form);

	obj.Validform({

	    btnSubmit:node,

	    tipSweep:true, 

	    //自定义错误提示信息
	    tiptype:function(msg,o){
		    if(o.type == 3){
		        $.toptip(msg, 'error');
		    }
	    },

	    ajaxPost:true, //true为异步

	    //提交表单之前
	    beforeSubmit:function(curform){
	      	obj.find(node).attr("disabled","disabled").val('处理中……');
	      	obj.find(node).text('处理中……');
	    },

	    //回调函数
	    callback:function(result){
	    	obj.find(node).removeAttr("disabled").val(btn_info);

	    	if(result.code) {

	    		$.toptip(result.msg, 'success');
		      	setTimeout(
		      		function(){
			      		//如果有url地址则跳转
				      	if ('url' in result && result.url != '') {
				      		window.location.href = result.url;
				      	}
		      	}, 2000);

	    	} else {
	    		var msg = result.msg ? result.msg : '未知错误';
	    		$.toptip(result.msg, 'error');
		      	obj.find(node).removeAttr("disabled");
	    	}
	    }
	});
}

var webupload = function(){
	var base_url = $('#webuploder').attr('base-url');
	var service  = $('#webuploder').attr('data-url');
	// 基础配置
	var uploader = WebUploader.create({

	    // 选完文件后，是否自动上传。
    	auto: true,

	    // swf文件路径
	    swf: base_url + '/static/webuploder/Uploader.swf',

	    // 文件接收服务端。
	    server: service,

	    // 选择文件的按钮。可选。
	    pick: '#filePicker',

	     // 只允许选择图片文件。
	    accept: {
	        title: 'Images',
	        extensions: 'jpg,jpeg,png',
	        mimeTypes: 'image/jpg,image/jpeg,image/png'
	    }
	});

	// 当有文件添加进来的时候
	uploader.on( 'fileQueued', function( file ) {
	    var $li = $(
	            '<li class="weui-uploader__file" id=' + file.id +  '>' +
	            	'<img>' +
	            '</li>'

	            ),
	        $img = $li.find('img');

	    // $list为容器jQuery实例
	    $('#uploaderFiles').append( $li );

	    // 创建缩略图
	    thumbnailWidth = '79';
	    thumbnailHeight = '79';
	    uploader.makeThumb( file, function( error, src ) {
	        if ( error ) {
	            $img.replaceWith('<span>不能预览</span>');
	            return;
	        }

	        $img.attr( 'src', src );
	    }, thumbnailWidth, thumbnailHeight );
	});

	// 文件上传过程中创建进度条实时显示。
	uploader.on( 'uploadProgress', function( file, percentage ) {
	    $('#'+file.id).addClass('weui-uploader__file_status');
	    $('#'+file.id).append('<div class="weui-uploader__file-content">' + percentage * 100 + '%</div>');

	});

	// 文件上传成功，给item添加成功class, 用样式标记上传成功。
	uploader.on( 'uploadSuccess', function( file, response ) {
	    $( '#'+file.id ).find('.weui-uploader__file-content').html('<i class="weui-icon-success"></i>');
	    console.log(response);
	    $('form').append('<input type="hidden" name="attachment_id[]" value="' + response.data.attachment_id + '">');
	});

	// 文件上传失败，显示上传出错。
	uploader.on( 'uploadError', function( file, response ) {
	   $( '#'+file.id ).find('.weui-uploader__file-content').html('<i class="weui-icon-warn"></i>');
	   $.toptip(response.msg, 'error');
	});

}

// 获取列表信息
var get_list = function(element, where){
	var element 	= element ? element : $('.data-list');
	var body 		= $(element.attr('target-body'));
    var server_url 	= element.attr('data-url');
    var current 	= element.attr('data-page');
        current 	= current ? current : 1;

    if (!server_url) return false;

    var o  = {};
    o.page = current;
    o      = $.extend(o, where);

    $.get(server_url, o, function(result){
    	if (current == 1) {
    		if (!result.code) {
	    		body.html('<div style="font-size: 14px; color: #c2c2c2;text-align: center;padding: 2rem;">暂无数据</div>');
	    		return false;
	    	}
    		body.html(result.data.list);
    	} else {
	    	if (!result.code) {
	    		body.append('<div style="font-size: 14px; color: #c2c2c2;text-align: center;padding: 2rem;">暂无数据</div>');
	    		return false;
	    	}
	    	body.append(result.data.list);
    	}
    });
}

// 关键词搜索列表
var keyword_search = function(me){
	var keyword = $(me).val();
	get_list('', {keyword:keyword});
}

// 滚动加载
var loader_list = function(element){
	var loading = false;  //状态标记
	$(element).infinite().on("infinite", function() {
	  	if(loading) return;
	  	loading = true;
	    get_list();
	    loading = false;
	    $(element).destroyInfinite()
	});
}

// 上拉刷新信息
var pull_to_refresh = function(element){
	var element = element || '.data-list';
	// 初始化下拉刷新
	$(element).pullToRefresh(function () {
		get_list();
		$(element).pullToRefreshDone();
	});
}

// --------------------------- 更高级封装 --------------------------------------
$(
	function(){

		// 封装表单提交 
		$('#ajaxPost').on('click', function(){	subForm();});

		// 返回上一页
		$('#back-btn').on('click', function(){ 	history.go(-1)});

		// 文件上传
		webupload();

		// 下拉刷新列表
		pull_to_refresh('.data-list');

		// 滚动加载
		loader_list('.data-list');

		// 获取列表信息
		get_list();

		// 关键词搜索
		$('input[type="search"]').bind('blur',function(){keyword_search(this)});
	}
);