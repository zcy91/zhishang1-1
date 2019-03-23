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
    <div class="breadcrumbs" id="breadcrumbs">
	<ol class="breadcrumb">
	<?php if(is_array($navigate_admin)): foreach($navigate_admin as $k=>$v): if($k == '后台首页'): ?><li><a href="<?php echo ($v); ?>"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo ($k); ?></a></li>
	    <?php else: ?>    
	        <li><a href="<?php echo ($v); ?>"><?php echo ($k); ?></a></li><?php endif; endforeach; endif; ?>          
	</ol>
</div>

	<section class="content">
       <div class="row">
       		<div class="col-xs-12">
	       		<div class="box">
	             <div class="box-header">
	             	<nav class="navbar navbar-default">	     
				        <div class="collapse navbar-collapse">
				            <div class="navbar-form row">
					            <a href="javascript:;" onclick="go_class_info(this)" data-url="<?php echo U('Store/goods_class_info');?>" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> 新增分类</a>
				            </div>
				      	</div>
	    			</nav> 	               
	             </div><!-- /.box-header -->
	           <div class="box-body">
	           <div class="row">
	            <div class="col-sm-12">
	              <table id="list-table" class="table table-bordered table-striped">
	                 <thead>
	                   <tr role="row">
		                   <th><input type="checkbox" onclick="javascript:$('input[name*=\'category\']').prop('checked', this.checked);">全选&nbsp;&nbsp;&nbsp;&nbsp;分类名称</th>
		                   <th>是否显示</th>
		                   <th>是否导航显示</th>
		                   <th>排序</th>
		                   <th>操作</th>
	                   </tr>
	                 </thead>
					<tbody>
					  <?php if(is_array($cat_list)): foreach($cat_list as $k=>$vo): ?><tr role="row" align="left">
					     <td><input type="checkbox" name="category[]" value="<?php echo ($vo["cat_id"]); ?>">&nbsp;&nbsp;<?php if($vo[deep] == 2): ?>&nbsp;&nbsp;&nbsp;&nbsp;<?php endif; echo ($vo["cat_name"]); ?>&nbsp;&nbsp;
					     <?php if($vo[deep] == 1): ?><a class="btn btn-default" data-url="<?php echo U('Store/goods_class_info',array('parent_id'=>$vo['cat_id']));?>" href="javascript:;" onclick="go_class_info(this)">新增下级</a><?php endif; ?>
					     </td>
	                     <td>
                             <?php if($vo[is_show] == 1): ?>是     <?php else: ?> 否<?php endif; ?>
                         </td>
                         <td>
                             <?php if($vo[is_nav_show] == 1): ?>是     <?php else: ?> 否<?php endif; ?>
                         </td>
	                 	 <td>                         
                            <input type="text"  class="input-sm" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onpaste="this.value=this.value.replace(/[^\d]/g,'')" onchange="updateSort2('store_goods_class','cat_id','<?php echo ($vo["cat_id"]); ?>','cat_sort',this)" size="4" value="<?php echo ($vo["cat_sort"]); ?>" />
                         </td>
	                     <td>
	                       <a class="btn btn-primary" data-url="<?php echo U('Store/goods_class_info',array('cat_id'=>$vo['cat_id']));?>" href="javascript:;" onclick="go_class_info(this)"><i class="fa fa-pencil"></i></a>
	                       <a class="btn btn-danger" href="javascript:void(0)" data-url="<?php echo U('Store/goods_class_save');?>" data-id="<?php echo ($vo["cat_id"]); ?>" onclick="delfun(this)"><i class="fa fa-trash-o"></i></a>
						</td>
	                   </tr><?php endforeach; endif; ?>
	                   </tbody>
	               </table></div>
	               </div>
	             </div>
	           </div>
       		</div>
       </div>
     </section>
</div>
<script type="text/javascript">
function delfun(obj){
	if(confirm('确认删除')){		
		$.ajax({
			type : 'post',
			url : $(obj).attr('data-url'),
			data : {act:'del',cat_id:$(obj).attr('data-id')},
			dataType : 'json',
			success : function(data){
				if(data.stat=='ok'){
					$(obj).parent().parent().remove();
				}else{
					layer.alert(data, {icon: 2});  //alert(data);
				}
			}
		})
	}
	return false;
}

function go_class_info(o){
    var url = $(o).attr('data-url');
    layer.open({
        type: 2,
        title: '编辑分类',
        shadeClose: true,
        shade: 0.2,
        area: ['30%', '50%'],
        content: url, 
    });
}

//回调函数
function call_back(msg){
	if(msg>0){
		layer.msg('操作成功', {icon: 1});
		layer.closeAll('iframe');
		window.location.reload();
	}else{
		layer.msg('操作失败', {icon: 3});
		layer.closeAll('iframe');
	}
}
</script>
</body>
</html>