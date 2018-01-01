/**
 * 弹框提示
 * @param string msg 提示信息
 * @param integer timer 弹框关闭时间
 * @param boolen status 状态显示 [true-成功提示，false-失败提示]
 * @author doris <dorisnzy@163.com>
 */
var showInfo = function(msg, status, timer) {
	timer = timer ? timer : 2;

	var error_bg   = 'border:none; background-color:#FF4351; color:#fff;background-color: rgba(255,67,81,.7);';
	var success_bg = 'border:none; background-color:#5eb95e; color:#fff;background-color: rgba(94,185,94,.7);';
	var style = status ? success_bg : error_bg;

	var config = {
		content : msg,
		time : timer,
		style : style,
		skin: 'msg',
	};
	layer.open(config);
}


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

// --------------------------- 更高级封装 --------------------------------------
$(
	function(){

		// 封装表单提交 
		$('#ajaxPost').on('click', function(){	subForm();});

		// 返回上一页
		$('#back-btn').on('click', function(){ 	history.go(-1)});
	}
);