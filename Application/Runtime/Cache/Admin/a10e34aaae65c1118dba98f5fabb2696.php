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
          <h3 class="panel-title"><i class="fa fa-list"></i>&nbsp;债务债权</h3>
        </div>
        <div class="panel-body">    

		<div class="navbar navbar-default">

            <div class="row navbar-form" style="float:left; width:auto;line-height:35px; color:#f00; width:100%">
              总申请：<?php echo ($count_sum); ?>元&nbsp;&nbsp;
              <span style="color: #090">总通过：<?php echo ($tg_sum); ?>元</span>&nbsp;&nbsp;
              <span style="color: #00f">总批放：<?php echo ($shifang); ?>元</span>
                            <a href="<?php echo U('zwzq_list');?>" class="btn btn-info pull-right" style="margin-right:15px; float:right">查看全部</a>
              <a href="<?php echo U('zwzq_list',Array('order'=>'title_t asc'));?>" class="btn btn-info pull-right" style="margin-right:15px; float:right">按字母排序</a>
              <a href="<?php echo U('zwzq_list',Array('leixing'=>'债务类'));?>" class="btn btn-info pull-right" style="margin-right:15px; float:right">债务类</a>
              <a href="<?php echo U('zwzq_list',Array('leixing'=>'债权类'));?>" class="btn btn-info pull-right" style="margin-right:15px; float:right">债权类</a>
              <a href="<?php echo U('zwzq_list',Array('leixing'=>'投资类'));?>" class="btn btn-info pull-right" style="margin-right:15px; float:right">投资类</a>
              <a href="<?php echo U('zwzq_list',Array('leixing'=>'互联网'));?>" class="btn btn-info pull-right" style="margin-right:15px; float:right">互联网</a>
            </div>
          </div>   
              
          <div id="ajax_return"> 
                 
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="sorting text-center">编号</th>
                                <th class="sorting text-center">所属</th>
                                <th class="sorting text-center">平台/关联人</th> 
                                <th class="sorting text-center">网址</th>  
                                <th class="sorting text-center">法人</th>
                                <th class="sorting text-center">帐号</th>                               
                                <th class="sorting text-center">借款</th>
                                <th class="sorting text-center">申请</th>
                                <th class="sorting text-center">备注</th>
                                <th class="sorting text-center">状态</th>
                                <th class="sorting text-center">操作</th>                              
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(is_array($List)): $i = 0; $__LIST__ = $List;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                                    <td class="text-left"><?php echo ($list["id"]); ?></td> 
                                     <td class="text-left"><?php echo ($list["leixing"]); ?></td> 
                                    <td class="text-left"><?php echo ($list["title_t"]); echo ($list["title"]); ?></td> 
                                    <td class="text-left"><?php echo ($list["site"]); ?></td> 
                                    <td class="text-left"><?php echo ($list["name"]); ?></td> 
                                    <td class="text-left"><?php echo ($list["account"]); ?></td> 
                                    <td class="text-left"><?php echo ($list["money"]); ?>元</td>  
                                    <td class="text-left"><?php echo (date("Y-m-d h:i:s",$list["add_time"])); ?></td>  
                                    <td class="text-left"><?php echo ($list["bz"]); ?></td>                               
                                    <td class="text-center"><img width="20" height="20" src="/Public/images/<?php echo ($list["zt"]); ?>.png" /></td>
                                    <td class="text-center">
                                    <a class="btn btn-info cz"  data-id="<?php echo ($list["id"]); ?>" title="查看信息"><i class="fa fa-eye"></i></a>
<!--                                    <?php if($list["zt"] == 0): ?><a href="<?php echo U('User/index');?>" style="margin-right:15px; padding:5px 15px; color:#FFF; background:#060; border-radius:5px; font-size:12px; cursor:pointer">成功</a>
                                     <a href="<?php echo U('User/index');?>" style="padding:5px 15px; color:#FFF; background:#f00; border-radius:5px; font-size:12px; cursor:pointer">失败</a>
                                      <?php else: ?>
                                     不可操作<?php endif; ?>-->
                                    </td>
                                    </td>
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
<script>
$(".cz").click(function(){
	 var id=$(this).attr("data-id");
layer.open({
  title:'审核操作',
  type: 2,
  area: ['700px', '450px'],
  fixed: false, //不固定
  maxmin: true,
  content: '<?php echo U("zwzq_show");?>/id/'+id,
  end:function(){location.reload();}
});
// console.log();
});
</script>
<!-- /.content-wrapper -->
</body>
</html>