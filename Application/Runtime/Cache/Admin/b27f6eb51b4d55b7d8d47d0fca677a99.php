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
          <h3 class="panel-title"><i class="fa fa-list"></i>&nbsp;会员明细</h3>
        </div>
        <div class="panel-body">    
<div class="box-header">
	                <nav class="navbar navbar-default">	     
				        <div class="collapse navbar-collapse">
				          <form class="navbar-form form-inline" action="<?php echo U('index');?>" method="post">
				            <div class="form-group">
				              	<input type="text" name="key" class="form-control" placeholder="请输入会员编号或订单号" value="<?php echo I('key');?>">
				            </div>
				            <div class="form-group">
				              <select name="types" class="form-control" style="width:200px;">
				              	<option value=""   <?php if(I('types') == ''): ?>selected<?php endif; ?>>所有帐户</option>
                                <option value="1"  <?php if(I('types') == '1'): ?>selected<?php endif; ?>>余额</option>
                                <option value="2"  <?php if(I('types') == '2'): ?>selected<?php endif; ?>><?php echo tpCache('distribut.hot_jifeng_name');?></option>
                                <option value="3"  <?php if(I('types') == '3'): ?>selected<?php endif; ?>><?php echo tpCache('distribut.cold_jifeng_name');?></option>
                                <option value="4"  <?php if(I('types') == '4'): ?>selected<?php endif; ?>>待激活</option>
                                <option value="5"  <?php if(I('types') == '5'): ?>selected<?php endif; ?>><?php echo tpCache('distribut.equity_name');?></option>
				              </select>
				            </div>

				            <button type="submit" class="btn btn-default">搜索</button>
				            <div class="form-group pull-right" style="line-height:35px">
                            <style>
                              .desc{ margin-right:10px; padding:5px 8px; border-radius:5px; background:#ccc; font-size:12px; color:#FFF; cursor:pointer}
							  .on{ background:#060; color:#fff}
                            </style>
                                快捷操作：
                                <span onclick="location.href='<?php echo U('index',array('types'=>I('types'),'key'=>I('key')));?>'" class="desc <?php if(I('desc') == ''): ?>on<?php endif; ?>">全部</span> 
                                
                                <?php if(is_array($leixing)): $i = 0; $__LIST__ = $leixing;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><span onclick="location.href='<?php echo U('index',array('types'=>I('types'),'key'=>I('key'),'desc'=>$list));?>'" class="desc <?php if(I('desc') == $list): ?>on<?php endif; ?>"><?php echo ($list); ?></span><?php endforeach; endif; else: echo "" ;endif; ?>   
                                
				            </div>		          
				          </form>		
				      	</div>
	    			</nav>               
	             </div>
                        
          <div id="ajax_return">                  
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="sorting text-center">编号</th>
                                <th class="sorting text-center">用户</th>
                                <th class="sorting text-center">数量</th> 
                                <th class="sorting text-center">时间</th>  
                                <th class="sorting text-center">项目</th>   
                                <th class="sorting text-center">所属</th>    
                                <th class="sorting text-center">备注</th>                           
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(is_array($List)): $i = 0; $__LIST__ = $List;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                                    <td class="text-left"><?php echo ($list["log_id"]); ?></td> 
                                    <td class="text-left"><?php if($list["user_id"] != 0): echo (about_xin('users','user_id='.$list["user_id"],'nickname','nickname')); ?>|<?php echo (about_xin('users','user_id='.$list["user_id"],'mobile','mobile')); else: ?><span style="color:#F00">平台</span><?php endif; ?></td> 
                                    <td class="text-left"><?php echo ($list["money"]); ?></td> 
                                    <td class="text-left"><?php echo (date("Y-m-d h:i:s",$list["change_time"])); ?></td>  
                                    <td class="text-left"><?php echo (jifeng_replace($list["desc"])); ?></td> 
                                    <td class="text-left"><?php echo (function_types($list["types"])); ?></td>   
                                    <td class="text-left"><small><?php echo (jifeng_replace($list["order_sn"])); ?></small>
                          <?php if($list[money] < 0 && $list['desc'] == '快捷支付'): $store_info=about_xin('store','user_id='.$list['order_id'],'store_name,store_id')?>
                            <small style="color:#0C0">商家店铺:<?php echo ($store_info["store_name"]); ?><a style="color:#f00; padding-left:10px"  target="_blank" href="<?php echo U("Mobile/Store/fast_info",array('t_no'=>$list['order_sn'],'store_id'=>$store_info['store_id'],'u_id'=>$list['user_id']));?>" >查看</a></small><?php endif; ?>
                          <?php if($list[money] > 0 && $list['desc'] == '快捷支付'): $store_info=about_xin('store','user_id='.$list['user_id'],'store_name,store_id')?>
                            <small style="color:#0C0">支付会员:<?php echo (about_xin('users','user_id='.$list["order_id"],'mobile','mobile')); ?><a style="color:#f00; padding-left:10px"  target="_blank" href="<?php echo U("Mobile/Store/fast_info",array('t_no'=>$list['order_sn'],'store_id'=>$store_info['store_id'],'u_id'=>$list['order_id']));?>">查看</a></small><?php endif; ?>
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
<!-- /.content-wrapper -->
</body>
</html>