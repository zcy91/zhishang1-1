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
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-list"></i> 品牌列表</h3>
        </div>
        <div class="panel-body">    
		<div class="navbar navbar-default">                    
                <form id="search-form2" class="navbar-form form-inline"  method="post" action="<?php echo U('Goods/brandList');?>">
                <div class="form-group">
                  <label for="input-order-id" class="control-label">名称:</label>
                  <div class="input-group">
                    <input type="text" class="form-control" id="input-order-id" placeholder="搜索词" value="<?php echo ($_POST['keyword']); ?>" name="keyword">                    
                  </div>
                </div>
                <div class="form-group">    
                    <button class="btn btn-primary" id="button-filter search-order" type="submit"><i class="fa fa-search"></i> 筛选</button>    
                </div>                
                <button type="button" class="btn btn-primary pull-right"  onclick="location.href='<?php echo U('Goods/addEditBrand');?>'">
                 <i class="fa fa-plus"></i> 添加品牌
                </button>                
                </form>    
          </div>
                        
          <div id="ajax_return"> 
                 
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="sorting text-left">ID</th>
                                <th class="sorting text-left">品牌名称</th>
                                <th class="sorting text-left">Logo</th>
                                <th class="sorting text-left">品牌分类</th>
                                <th valign="middle">状态</th>                                
                                <th class="sorting text-right">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(is_array($brandList)): $i = 0; $__LIST__ = $brandList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                                    <td class="text-right"><?php echo ($list["id"]); ?></td>
                                    <td class="text-left"><?php echo ($list["name"]); ?></td>                                 
                                    <td class="text-left">
                                        <a href="<?php echo ($list["logo"]); ?>" target="_blank"><img onmouseover="$(this).attr('width','80').attr('height','45');" onmouseout="$(this).attr('width','40').attr('height','30');" width="40" height="30" src="<?php echo ($list["logo"]); ?>"/></a>                                    
                                    </td>
                                    <td class="text-left"><?php echo ($cat_list[$list[cat_id1]]); ?> <?php echo ($cat_list[$list[cat_id2]]); ?></td>
                                    <td class="text-left">
                                      <?php if($list[status] == 0): ?>正常<?php endif; ?>
                                      <?php if($list[status] == 1): ?>审核中<?php endif; ?>
                                      <?php if($list[status] == 2): ?>审核失败<?php endif; ?>                                                                            
                                    </td>                                    
                                    <td class="text-right">
                                    	<?php if($list[status] != 0): ?><a href="<?php echo U('goods/addEditBrand',array('id'=>$list['id'],'p'=>$_GET[p]));?>" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="编辑"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:void(0);" onclick="del('<?php echo ($list[id]); ?>')" id="button-delete6" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="删除"><i class="fa fa-trash-o"></i></a><?php endif; ?>
                                    </td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                    </div>
                
                <div class="row">
                    <div class="col-sm-6 text-left"></div>
                    <div class="col-sm-6 text-right"><?php echo ($show); ?></div>
                </div>
          
          </div>
        </div>
      </div>
    </div>
    <!-- /.row --> 
  </section>
  <!-- /.content --> 
</div>
<!-- /.content-wrapper --> 
 <script>
 // 删除操作
function del(id)
{
	if(!confirm('确定要删除吗?'))
		return false;		
		$.ajax({
			url:"/index.php?m=Seller&c=goods&a=delBrand&id="+id,
			success: function(v){	
                            var v =  eval('('+v+')');                                 
                            if(v.hasOwnProperty('status') && (v.status == 1))
                               location.href=location.href;
                            else                                
								layer.msg(v.msg, {icon: 2,time: 1000}); //alert(v.msg);
			}
		}); 
	 return false;
}
 

//修改指定表的指定字段值
function changeBrandField(field,id,obj)
{
 
     var isshow = $(obj).data('isshow');
     if(isshow == 1)
     {
         $(obj).data('isshow','0');    
         var value = 0;
         $(obj).attr('src','/Public/images/cancel.png');
         
     }else{
         $(obj).data('isshow','1');
         var value = 1;
         $(obj).attr('src','/Public/images/yes.png');
     }    
     
     $.ajax({
             url:'/index.php?m=Seller&c=goods&a=changeBrandField&field='+field+'&id='+id+'&value='+value,			
             success: function(data){					                                                                      
                     //  
             }
     });		
     
}
 </script>
</body>
</html>