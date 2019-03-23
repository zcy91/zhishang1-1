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

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title"><i class="fa fa-list"></i>&nbsp;平台帐户明细</h3>
        </div>
        <div class="panel-body">    
		<div class="navbar navbar-default">

            <div class="row navbar-form" style="float:left; width:auto;line-height:35px; color:#f00">
              平台现存<?php echo tpCache('distribut.jifeng_name');?>：<?php echo ($jifeng_sum); ?>个&nbsp;&nbsp;
              <span style="color: #090">平台余额：<?php echo ($money_sum); ?>元</span>&nbsp;&nbsp;
              <span style="color: #00f">总购平台<?php echo tpCache('distribut.jifeng_name');?>：<?php echo ($money_sum); ?>个</span>
            </div>
				<div class="row navbar-form" style="line-height:35px; float:right;">
                            <style>
                              .desc{ margin-right:10px; padding:5px 8px; border-radius:5px; background:#ccc; font-size:12px; color:#FFF; cursor:pointer}
							  .on{ background:#060; color:#fff}
                            </style>
                                快捷操作：
                                <span onclick="location.href='<?php echo U('jifeng');?>'" class="desc <?php if(I('desc') == ''): ?>on<?php endif; ?>">全部</span> 
                                
                                <?php if(is_array($leixing)): $i = 0; $__LIST__ = $leixing;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><span onclick="location.href='<?php echo U('jifeng',array('desc'=>$list));?>'" class="desc <?php if(I('desc') == $list): ?>on<?php endif; ?>"><?php echo ($list); ?></span><?php endforeach; endif; else: echo "" ;endif; ?>   
                                
				            </div>	
          </div>   
                        
          <div id="ajax_return"> 
                 
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="sorting text-center">项目</th>
                                <th class="sorting text-center">数量</th> 
                                <th class="sorting text-center">时间</th>  
                                <th class="sorting text-center">说明</th>                             
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(is_array($List)): $i = 0; $__LIST__ = $List;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                                    <td class="text-left"><?php echo (jifeng_replace($list["desc"])); ?></td> 
                                    <td class="text-left"><?php echo ($list["money"]); ?></td> 
                                    <td class="text-left"><?php echo (date("Y-m-d h:i:s",$list["change_time"])); ?></td>  
                                    <td class="text-left"><small style="color:#090"><?php echo (jifeng_replace($list["order_sn"])); ?></small></td>   
                                                              
                 
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                    </div>
                
              <div class="row">
              	    <div class="col-sm-6 text-left"></div>
                    <div class="col-sm-6 text-right"><?php echo ($page); ?></div>		
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
</body>
</html>