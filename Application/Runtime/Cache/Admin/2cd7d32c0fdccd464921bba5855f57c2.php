<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>商城管理后台</title>
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
//   						layer.closeAll();
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
				          <form class="navbar-form form-inline" action="<?php echo U('wapnavigationList');?>" method="post">
				            <div class="form-group">
				              	<input type="text" name="keywords" class="form-control" placeholder="搜索">
				            </div>
				            <div class="form-group">
				              	<select name="lei" class="form-control" style="width:200px;">
				              	<option value=""  <?php if($lei == ''): ?>selected<?php endif; ?>>查看所有</option>

                                <?php if(is_array($wap_lei_show)): $i = 0; $__LIST__ = $wap_lei_show;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><option value="<?php echo ($i-1); ?>" <?php if($lei == $i-1): ?>selected<?php endif; ?>><?php echo ($list); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>   
                                   
				              	</select>
				            </div>
				            <button type="submit" class="btn btn-default">提交</button>
				            <div class="form-group pull-right">
					            <button type="button" onclick="location.href='<?php echo U('wapaddEditNav');?>'"  class="btn btn-primary pull-right"><i class="fa fa-plus"></i>新增导航</button>
				            </div>		          
				          </form>		
				      	</div>
	    			</nav>               
	             </div>	    
	             <!-- /.box-header -->
	             <div class="box-body">	             
	           		<div class="row">
	            	<div class="col-sm-12">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="sorting text-center">图标</th>
                                <th class="sorting text-center">导航名称</th>
                                <th class="sorting text-center">链接地址</th>   
                                <th class="sorting text-center">所属位置</th>                                 
                                <th class="sorting text-center">是否显示</th>
                                <th class="sorting text-center">是否新窗口</th>
                                <th class="sorting text-center">排序</th>                                
                                <th class="sorting text-center">操作</th>                                
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(is_array($navigationList)): $i = 0; $__LIST__ = $navigationList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                                    <td class="text-left"><img width="30" height="30" src="<?php echo ($list["img"]); ?>"  onerror="this.src='/Public/images/bg-upload.png'"/></td> 
                                    <td class="text-left"><?php echo ($list["name"]); ?></td> 
                                    <td class="text-left"><?php echo ($list["url"]); ?></td>    
                                    <td class="text-left"><?php echo ($wap_lei_show[$list["lei"]]); ?></td>                            
                                    <td class="text-center">
                                        <img width="20" height="20" src="/Public/images/<?php if($list[is_show] == 1): ?>yes.png<?php else: ?>cancel.png<?php endif; ?>" onclick="changeTableVal('wapnavigation','id','<?php echo ($list["id"]); ?>','is_show',this)"/>
                                    </td>
                                    <td class="text-center">                                    
                                        <img width="20" height="20" src="/Public/images/<?php if($list[is_new] == 1): ?>yes.png<?php else: ?>cancel.png<?php endif; ?>" onclick="changeTableVal('wapnavigation','id','<?php echo ($list["id"]); ?>','is_new',this)"/>                                                      
                                    </td>
                                    <td class="sorting text-center">
                                    <input type="text" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" onpaste="this.value=this.value.replace(/[^\d]/g,'')" onchange="updateSort('wapnavigation','id','<?php echo ($list["id"]); ?>','sort',this)"  size="4"  value="<?php echo ($list["sort"]); ?>" />
                                    </td>                                    
                                    <td class="text-right">
                                        <a href="<?php echo U('System/wapaddEditNav',array('id'=>$list['id'],'lei'=>$lei,'p'=>$p));?>" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="编辑"><i class="fa fa-pencil"></i></a>
                                        <a href="javascript:del_fun('<?php echo U('System/wapdelNav',array('id'=>$list['id'],'lei'=>$lei,'p'=>$p));?>');" id="button-delete6" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="删除"><i class="fa fa-trash-o"></i></a>
                                    </td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>	               </div>
	          </div>
              <div class="row">
              	    <div class="col-sm-6 text-left"></div>
                    <div class="col-sm-6 text-right"><?php echo ($page); ?></div>		
              </div>
	          </div><!-- /.box-body -->
	        </div><!-- /.box -->
       	</div>
       </div>
   </section>
</div>