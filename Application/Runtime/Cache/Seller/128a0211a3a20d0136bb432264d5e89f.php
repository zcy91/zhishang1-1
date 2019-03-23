<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>商家管理后台</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.4 -->
    <link href="/Public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
 	<link href="/Public/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 --
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="/Public/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
    	folder instead of downloading all of them to reduce the load. -->
    <link href="/Public/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="/Public/plugins/iCheck/flat/blue.css" rel="stylesheet" type="text/css" />   
    <!-- jQuery 2.1.4 -->
    <script src="/Public/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <script src="/Public/js/global.js"></script>
    <script src="/Public/js/myFormValidate.js"></script>    
    <script src="/Public/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="/Public/js/layer/layer-min.js"></script><!-- 弹窗js 参考文档 http://layer.layui.com/-->
    <script src="/Public/js/myAjax.js"></script>
    <script type="text/javascript">
    function delfunc(obj){
    	layer.confirm('确认删除？', {
    		  btn: ['确定','取消'] //按钮
    		}, function(){
    		    // 确定
   				$.ajax({
   					type : 'post',
   					url : $(obj).attr('data-url'),
   					data : {act:'del',del_id:$(obj).attr('data-id')},
   					dataType : 'json',
   					success : function(data){
   						if(data==1){
   							layer.msg('操作成功', {icon: 1});
   							$(obj).parent().parent().remove();
   						}else{
   							layer.msg(data, {icon: 2,time: 2000});
   						}
   						layer.closeAll();
   					}
   				})
    		}, function(index){
    			layer.close(index);
    			return false;// 取消
    		}
    	);
    }
    
    function selectAll(name,obj){
    	$('input[name*='+name+']').prop('checked', $(obj).checked);
    }    
	
    function get_help(obj){
        layer.open({
            type: 2,
            title: '帮助手册',
            shadeClose: true,
            shade: 0.3,
            area: ['70%', '80%'],
            content: $(obj).attr('data-url'), 
        });
    }	
    </script>        
  </head>
  <body style="background-color:#ecf0f5;">
 

<style>
.ncsc-form-default{margin:0 auto;}
.ncsc-account-container {
    line-height: 20px;
    display: block;
    min-height: 20px;
    padding: 10px 0;
    border-top: dotted 1px #CCC;
}
.ncsc-account-container h4 {
    font-size: 14px;
    font-weight: 600;
    vertical-align: top;
    display: inline-block;
    width: 10%;
    border-right: dotted 1px #CCC;
    margin: 0 1%;
}
.ncsc-account-container-list {
    font-size: 0;
    vertical-align: top;
    display: inline-block;
    width: 84%;
}
.ncsc-account-container-list li {
    font-size: 12px;
    line-height: 20px;
    vertical-align: middle;
    letter-spacing: normal;
    word-spacing: normal;
    display: inline-block;
    width: 20%;
    height: 24px;
}
.ncsc-account-container-list li span{
	display: inline-block;
	vertical-align: middle;
}
.ncsc-form-default dl {
    font-size: 0;
    line-height: 20px;
    clear: both;
    padding: 0;
    margin: 0;
    border-bottom: dotted 1px #E6E6E6;
    overflow: hidden;
}
.ncsc-form-default dl dt {
    font-size: 13px;
    line-height: 32px;
    vertical-align: top;
    letter-spacing: normal;
    word-spacing: normal;
    text-align: right;
    display: inline-block;
    width: 10%;
    padding: 10px 1% 10px 0;
    margin: 0;
}
.ncsc-form-default dl dd {
    font-size: 12px;
    line-height: 32px;
    vertical-align: top;
    letter-spacing: normal;
    word-spacing: normal;
    display: inline-block;
    width: 79%;
    padding: 10px 0 10px 0;
}
.ncsc-account-container .checkbox {
    vertical-align: middle;
    margin-right: 4px;
	padding:0;
	width:16px;
	height:16px;
	display:inline-block;
}
.hint {
    font-size: 12px;
    line-height: 16px;
    color: #BBB;
    margin-top: 10px;
}
</style>
<div class="wrapper">
    <div class="breadcrumbs" id="breadcrumbs">
	<ol class="breadcrumb">
	<?php if(is_array($navigate_admin)): foreach($navigate_admin as $k=>$v): if($k == '后台首页'): ?><li><a href="<?php echo ($v); ?>"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo ($k); ?></a></li>
	    <?php else: ?>    
	        <li><a href="<?php echo ($v); ?>"><?php echo ($k); ?></a></li><?php endif; endforeach; endif; ?>          
	</ol>
</div>

	<section class="content">
	<div class="row">
		<div class="col-sm-12 ">		        	
		<form action="<?php echo U('Admin/roleSave');?>" id="roleform" method="post">
			<table class="table table-bordered table-striped">
				<tr>
					<th width="100px;">组名称:</th>
					<td>
					<input type="text" class="form-control" name="group_name" id="group_name" value="<?php echo ($detail["group_name"]); ?>" style="width:250px;">
					<p class="hint">设定权限组名称，方便区分权限类型。</p>
					</td>
				</tr>
			</table>
			<div class="ncsc-form-default">
			<dl id="function_list">
		      <dt><i class="required">*</i>权限</dt>
		      <dd>
		        <div class="ncsc-account-all">
		          <input id="btn_select_all" name="btn_select_all" style="display:inline-block" class="checkbox" type="checkbox" />
		          <label for="btn_select_all">全选</label>
		        </div>
		        <?php if(is_array($menu_list)): foreach($menu_list as $key=>$vo): ?><div class="ncsc-account-container">
			          <h4>
			            <input id="<?php echo ($key); ?>" type="checkbox" class="checkbox" nctype="btn_select_module"/>
			            <label for="<?php echo ($key); ?>"><?php echo ($vo['name']); ?></label>
			          </h4>
			          <ul class="ncsc-account-container-list">
			            <?php if(is_array($vo["child"])): foreach($vo["child"] as $key=>$vv): ?><li>
				              	<input id="<?php echo ($vv['act']); ?>@<?php echo ($vv['op']); ?>" <?php if(stripos($detail['act_limits'],$vv['act'].'@'.$vv['op'])) echo 'checked'; ?> type="checkbox" class="checkbox" name="act_limits[]" value="<?php echo ($vv['act']); ?>@<?php echo ($vv['op']); ?>" />
				            	<label for="<?php echo ($vv['act']); ?>@<?php echo ($vv['op']); ?>"><?php echo ($vv['name']); ?></label>
				            </li><?php endforeach; endif; ?>
			          </ul>
		        </div><?php endforeach; endif; ?>
		        <p class="hint"></p>
		      </dd>
		    </dl>
		    <dl>
		      <dt><i class="required"></i>消息接收权限</dt>
		      <dd>
		        <div class="ncsc-account-all">
		          <input id="smt_select_all" class="checkbox" type="checkbox" style="display:inline-block" />
		          <label for="smt_select_all">全选</label>
		        </div>
		        <div class="ncsc-account-container">
		          <ul class="ncsc-account-container-list" style="width: 99%; padding-left: 1%;">
		            <?php if(is_array($smt_list)): foreach($smt_list as $key=>$val): ?><li style="width: 20%;">
		              <input id="<?php echo ($val['smt_code']); ?>" class="checkbox" type="checkbox" <?php if(in_array(($val[smt_code]), is_array($detail["smt_limits"])?$detail["smt_limits"]:explode(',',$detail["smt_limits"]))): ?>checked<?php endif; ?> name="smt_limits[]" value="<?php echo ($val['smt_code']); ?>" />
		              <label for="<?php echo ($val['smt_code']); ?>"><?php echo ($val['smt_name']); ?></label>
		            </li><?php endforeach; endif; ?>
		          </ul>
		        </div>
		        <p class="hint">如需设置消息接收权限，请设置该权限组允许查看“系统消息”。</p>
		      </dd>
		    </dl>
			</div>
			<div class="page-bar" style="text-align:center;">
				<input type="hidden" name="group_id" value="<?php echo ($detail["group_id"]); ?>" />
				<a href="javascript:void(0)" onclick="roleSubmit()" class="btn btn-info">提交设置</a>			
			</div>
		</form>
		</div>
	</div></section>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#btn_select_all').on('click', function() {
	    if($(this).prop('checked')) {
	        $(this).parents('dd').find('input:checkbox').prop('checked', true);
	    } else {
	        $(this).parents('dd').find('input:checkbox').prop('checked', false);
	    }
	});
	
	$('[nctype="btn_select_module"]').on('click', function() {
	    if($(this).prop('checked')) {
	        $(this).parents('.ncsc-account-container').find('input:checkbox').prop('checked', true);
	    } else {
	        $(this).parents('.ncsc-account-container').find('input:checkbox').prop('checked', false);
	    }
	});
	
	$('#smt_select_all').click(function(){
		var vt = $(this).is(':checked');
		$(this).parents('dd').find('input:checkbox').prop('checked', vt);
	})
});

function roleSubmit(){
	if($('#group_name').val() == '' ){
		layer.alert('角色名称不能为空', {icon: 2});  //alert('少年，角色名称不能为空');
		return false;
	}
	$('#roleform').submit();
}
</script>
</body>
</html>