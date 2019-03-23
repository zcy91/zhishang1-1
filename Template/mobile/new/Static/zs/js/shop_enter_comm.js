$(function() {
	setRem();
	initSelectDom();
	initNextStep();
	//横竖屏切换后重新计算rem值
	window.onresize = function() {
		setRem();
	};
	//解决ios下input readonly 失效的问题
	var inputReadOnly = document.querySelector("input[readonly]");
	if (inputReadOnly) {
		inputReadOnly.addEventListener("focus", function() {
			document.activeElement.blur();
		});
	}
	//document.querySelector("input[readonly]").addEventListener("focus",function(){
	//	document.activeElement.blur();
	//});
	//防止页面加载的时候由于rem的问题产生布局错乱 display=none会导致ios浏览刷新时rem重置导致布局错乱
	document.documentElement.style.visibility = "visible";
});

// function setPageZoom() {
// 	var devicePixelRatio = window.devicePixelRatio;
// 	var viewport = document.querySelector("meta[name='viewport']");
// 	var zoom = 1 / devicePixelRatio;
// 	var viewportContent = "width=device-width, initial-scale=" + +",user-scalable=no";
// 	viewport.setAttribute("content", viewportContent);
// }

//设置页面的rem
function setRem() {
	document.documentElement.style.fontSize = document.documentElement.clientWidth / 7.5 + "px";
}
//下拉框点击事件处理函数
function option_click(e, obj) {
	var t = $(obj);
	//当前点击到的option的值
	var value = t.attr("value");
	//当前点击到的option的标签文本
	var text = t.find("p").text();
	var user_input_select = obj.parentNode.parentNode.parentNode;
	var select_next = user_input_select.getAttribute("select-next");
	//如果当前被点击的select有存在相管理的下一级菜单
	if (select_next != "no" && value != user_input_select.getAttribute("value")) {
		var select_next_arr = select_next.split(",");
		for (var i = 0; i < select_next_arr.length; i++) {
			var effect = $("#" + select_next_arr[i]);
			effect.find(".user_input_select_result").find("p").text("请选择");
			effect.attr("value", null);
			//只有直接的下一级菜单才做省市联动的处理
			if (i == 0) {
				//更新省市联动数据的select下拉框
				var select_next_callback = user_input_select.getAttribute("select-next-callback");
				eval(select_next_callback + "(" + value + ")");
				// 				var updateUl = effect.find(".user_input_select_option_content_ul");
				// 				updateUl.empty();
				// 				
				// 				var newDom = $('<li value="0"><p>浙江省</p></li>');
				// 				newDom.on("tap", function(e) {
				// 					option_click(e, this);
				// 				});
				// 				updateUl.append(newDom);
			}
		}
	}
	//点击一个下拉菜单后其它所有一开启的下拉菜单收缩
	$(obj.parentNode.parentNode).hide().prev().find("p").text(text);
	user_input_select.setAttribute("value", value);
	e.stopPropagation();
}
//初始化模拟select的div  
function initSelectDom() {
	var user_input_select = $(".user_input_select");
	//div模拟的option点击事件
	$(".user_input_select_option_content>.user_input_select_option_content_ul > li").on("tap", function(e) {
		option_click(e, this);
	});
	//div模拟的select点击事件
	user_input_select.each(function(i, e) {
		var t = $(e);
		t.on("tap", function() {
			var t = $(this);
			//点击一个下拉菜单后其它所有一开启的下拉菜单收缩
			$(".user_input_select_option_content").hide();
			//当前菜单展开或关闭
			t.find(".user_input_select_option_content").toggle();
		});
	});
}
//处理下一步事件
function initNextStep() {
	var input_next_step_a = $(".input_next_step > a");
	var ajax_submit = $("#ajax_submit");
	var ajax_url = ajax_submit.attr("interface");
	var ajax_type = ajax_submit.attr("submit-type");
	input_next_step_a.each(function(i, e) {
		var t = $(this);
		t.on("tap", function(e) {
			var to = $(this);
			//获取用户在本页面所有的输入作为ajax提交的数据
			var userInput = getUserInput();
			if (userInput == null) {
				return;
			}
			$.ajax({
				url: ajax_url,
				type: ajax_type,
				data: userInput,
				success: function(data) {
					//若本页数据提交成功
					location.href = to.attr("next-page");
				}
			});
		});
	});
}

//获取用户在本页面所有的输入
function getUserInput() {
	var result = {};
	var allInputDom = $(".other_content input,div[field-name]");
	allInputDom.each(function(i, e) {
		var field_name = e.getAttribute("field-name");
		var field_value = (e.getAttribute("value") || e.value) || null;
		if (e.tagName == "INPUT" && e.getAttribute("type") == "checkbox") {
			field_value = e.checked || null;
		}
		//console.log(field_value);
		if (e.getAttribute("require") == "require" && !field_value) {
			result = null;
			alert(e.getAttribute("require-empty-tip"));
			return false;
		}
		// field_value = field_value || null;
		result[field_name] = field_value;
	});
	return result;
}
