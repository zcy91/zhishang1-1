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
        <!-- Main content -->
        <div class="container-fluid">
            <div class="pull-right">
                <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回"><i class="fa fa-reply"></i></a>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-list"></i> 拆分订单</h3>
                </div>
                <div class="panel-body">
                    <!--表单数据-->
                    <form method="post" action="<?php echo U('Order/split_order');?>" id="split_order">
                        <div class="tab-pane">
                            <table class="table table-bordered">
                                <tbody>
                                <tr><td>费用信息:</td>
                                	<td>
                                		<div class="col-xs-9">
                                		<input type="hidden" name="order_id" value="<?php echo ($order["order_id"]); ?>">
                                		 商品总价：<?php echo ($order["goods_price"]); ?>+运费:<?php echo ($order["shipping_price"]); ?>-<?php echo tpCache('distribut.jifeng_name');?>：<?php echo ($order["integral"]); ?>-优惠:<?php echo ($order["discount"]); ?>                                        
                                		</div>
                                	</td>
                                </tr>
                                <tr>
                                    <td>收货人:</td>
                                    <td>
                                    <div class="form-group">
	                                    <div class="col-xs-2"> <?php echo ($order["consignee"]); ?></div>
                                        <div class="col-xs-1">手机：</div>
                                        <div class="col-xs-2"><?php echo ($order["mobile"]); ?></div>
                                        <div class="col-xs-3"><p class="text-warning">温馨提示：原单商品不可全部移除</p></div>
                                        <div class="col-xs-2 pull-right">
                                        	<button type="button" class="btn btn-default pull-left" onclick="window.location.reload();">重置</button>
                                        	<button type="button" class="btn btn-primary pull-right" onclick="add_split()">添加拆单</button>
                                        </div>
                                    </div>    
                                    </td>
                                </tr>                                                                                      
                                <tr>
                                    <td>原单商品列表:</td>
                                    <td id="origin" style="border:2px orange solid;"> 
                                       <div class="form-group">
                                       		<div class="col-xs-10">
	                                       		<table class="table table-bordered">
	                                       			<thead>
	                                       			<tr>
										                <td class="text-left">商品名称</td>
										                <td class="text-left">规格</td>
										                <td class="text-left">价格</td>
										                <td class="text-left">原购数</td>								                
										                <td class="text-left">数量</td>
										                <td class="text-left">操作</td>
										            </tr>
										            </thead>
										            <tbody>
										            <?php if(is_array($orderGoods)): foreach($orderGoods as $key=>$vo): ?><tr>
										                <td class="text-left"><?php echo ($vo["goods_name"]); ?></td>            
										                <td class="text-left"><?php echo ($vo["spec_key_name"]); ?></td>
										                <td class="text-left"><?php echo ($vo["goods_price"]); ?></td>
										                <td class="text-left"><?php echo ($vo["goods_num"]); ?></td>
										                <td class="text-left">
										                	<input type="text" name="old_goods[<?php echo ($vo["rec_id"]); ?>]" rel="<?php echo ($vo["rec_id"]); ?>" class="input-sm" style="width:40px;" value="<?php echo ($vo["goods_num"]); ?>">
										               	</td>
										                <td class="text-left">
										                	<a href="javascript:void(0)" onclick="javascript:$(this).parent().parent().remove()">移除</a>
										                </td>
										           		</tr><?php endforeach; endif; ?>
										           </tbody>
	                                       		</table>
                                       	   </div>
                                       </div>                                       
                                    </td>
                                </tr>                               
                                <tr id="last_tr">
                                    <td>管理员备注:</td>
                                    <td>
                                    <div class="form-group ">
	                                    <div class="col-xs-4">
                                        	<textarea style="width:450px; height:100px;" name="admin_note"><?php echo (htmlspecialchars_decode($order["admin_note"])); ?></textarea>
                                        </div>
                                    </div>    
                                    </td>
                                </tr>                                  
                             </tbody>
                          </table>
                          <div class="col-xs-12">
                          	<div class="pull-left">
                          		<p class="text-danger" id="error_log"></p>
                          	</div>
	                        <div class="pull-right">
		                        <button class="btn btn-info" type="button" onclick="checkSubmit()">
		                            <i class="ace-icon fa fa-check bigger-110"></i>保存
		                        </button>
	                        </div>
                        </div>
                      </div>
                    </form> 
                </div>
            </div>
        </div> 
    </section>
</div>
<script>
var no = 1;
$(function(){
	add_split();
});

function add_split(){
	var new_order = '';
	new_order += '<tr id="new_'+no+'" class="new_split"><td>新单商品列表:</td><td>'                      
	new_order += $('#origin').html();
	new_order += '<div class="col-xs-1 pull-right"><button type="button" class="btn btn-danger pull-right" onclick="$(this).parent().parent().parent().remove();">删除</button></div>'
	new_order += '</td></tr>';
	$('#last_tr').before(new_order);
	$('#new_'+no+' .input-sm').each(function(i,o){
		var name = $(this).attr('name');
		$(this).attr('name',no+'_'+name);
	});
	no++;
}

var b = <?php echo ($goods_num_arr); ?>;

function checkSubmit(){
	var a = [],g = [];
	$('input[name*=old_goods]').each(function(i,o){
		var rec_id = $(o).attr('rel');
		if(!a[rec_id]){
			a[rec_id] = 0;
		}
		a[rec_id] = a[rec_id] + parseInt($(o).val());
	});
	
	$('#origin .input-sm').each(function(){
		g.push($(this).val());
	});
	if($('.new_split').length == 0){
		$('#error_log').empty().html('请至少拆分一单');
		return false;
	}
	if(g.length == 0){
		$('#error_log').empty().html('原单商品不可全部移除');
		return false;
	}
	
	for(var k in b){
		if(a[k] > parseInt(b[k]['goods_num'])){
			var lt = a[k] - parseInt(b[k]['goods_num']);
			$('#error_log').empty().html(b[k]['goods_name']+',数量大于原商单购买数'+lt+'件');
			return false;
		}
		if(a[k] < parseInt(b[k]['goods_num'])){
			var lt = parseInt(b[k]['goods_num']) - a[k];
			$('#error_log').empty().html(b[k]['goods_name']+',数量少于原商单购买数'+lt+'件');
			return false;
		}else{
			$('#error_log').empty();
		}
	}
	
	$('#split_order').submit();
}
</script>
</body>
</html>