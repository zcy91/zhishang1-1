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
 

<div class="wrapper">
     <form method="post" id="handlepost" action="<?php echo U('Store/goodd_class_save');?>">
      <div class="tab-content">                 	  
          <div class="tab-pane active" id="tab_tongyong">                           
	        <table class="table table-bordered">
	            <tbody>
	            <tr>
	                <td class="col-sm-2">分类名称：</td>
	                <td>
	                    <input type="text" class="form-control" name="cat_name" value="<?php echo ($info["cat_name"]); ?>">                                                         
	                </td>
	            </tr> 
	            <tr>
	            <td>上级分类：</td>
	            <td>			
					<select name="parent_id" id="parent_id" value="<?php echo ($menu["parent_id"]); ?>" class="input-sm">	
						<option value="0">顶级菜单</option>		
						<?php if(is_array($parent)): foreach($parent as $key=>$v): ?><option value="<?php echo ($v["cat_id"]); ?>" <?php if($v[cat_id] == $info[parent_id]): ?>selected="selected"<?php endif; ?>>&nbsp;&nbsp;|--<?php echo ($v["cat_name"]); ?></option><?php endforeach; endif; ?>
					</select>                       
	            </td>
	            </tr>
	            <tr>
	            	<td>首页此类商品显示数量：</td>
	            	<td><input type="text" class="input-sm" name="show_num" value="<?php echo ($info["show_num"]); ?>"></td>
	            </tr>
	            <tr>
	                <td>是否显示：</td>
	                <td>
	                	<input name="is_show" type="radio" value="1" <?php if($info[is_show] == 1): ?>checked<?php endif; ?>>是
	                	<input name="is_show" type="radio" value="0" <?php if($info[is_show] == 0): ?>checked<?php endif; ?>>否
					</td>
	            </tr>
	            <tr>
	                <td>是否导航显示：</td>
	                <td>
	                	<input name="is_nav_show" type="radio" value="1" <?php if($info[is_nav_show] == 1): ?>checked<?php endif; ?>>是
	                	<input name="is_nav_show" type="radio" value="0" <?php if($info[is_nav_show] == 0): ?>checked<?php endif; ?>>否
					</td>
	            </tr>
	            <tr>
	                <td>是否首页推荐：</td>
	                <td>
	                	<input name="is_recommend" type="radio" value="1" <?php if($info[is_recommend] == 1): ?>checked<?php endif; ?>>是
	                	<input name="is_recommend" type="radio" value="0" <?php if($info[is_recommend] == 0): ?>checked<?php endif; ?>>否
					</td>
	            </tr>
	            <tr>
	                <td>排序：</td>
	                <td><input type="text" name="cat_sort" value="<?php echo ($info["cat_sort"]); ?>" class="form-control" /></td>
	            </tr>
	            </tbody> 
	            <tfoot>
	            	<tr>
	            	<td  colspan="2" style="text-align:center;">
	            		<input type="hidden" name="cat_id" value="<?php echo ($info["cat_id"]); ?>">
	            		<input class="btn btn-primary" type="button" onclick="dataSave()" value="保存"></td>
	            	</tr>
	            </tfoot>                               
	          </table>
	          </div>                           
	      </div>              
</form>
</div>
<script type="text/javascript">
	function dataSave(){
		if($('input[name="cat_name"]').val() == ''){
			layer.msg('分类名称不能为空', {icon: 3});
			return;
		}
		$.ajax({
			url : "<?php echo U('Store/goods_class_save');?>",
			data : $('#handlepost').serialize(),
			type : 'post',
			dataType : 'json',
			success :function(data){
				if(data.stat=='ok'){
					window.parent.call_back(1);	
				}else{
					window.parent.call_back(0);
				}						
			}			
		});		
	}
</script>
</body>
</html>