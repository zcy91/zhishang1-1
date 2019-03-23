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
 

<link href="/Public/plugins/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
<script src="/Public/plugins/daterangepicker/moment.min.js" type="text/javascript"></script>
<script src="/Public/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
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
          <h3 class="panel-title"><i class="fa fa-list"></i>已结算订单</h3>
        </div>
        <div class="panel-body">    
		<div class="navbar navbar-default">                    
                <form id="search-form2" class="navbar-form form-inline"  method="post" action="<?php echo U('order_statis_detail');?>">
                <div class="form-group">                  
                   <div class="input-group margin">                    
                    <div class="input-group-addon">
                        	下单时间<i class="fa fa-calendar"></i>
                    </div>
                       <input type="text" id="create_date" value="<?php echo ($create_date); ?>" name="create_date" class="form-control pull-right" style="width: 200px">
                  </div>
                </div>
                <div class="form-group">    
                    <button class="btn btn-primary" id="button-filter search-order" type="submit"><i class="fa fa-search"></i> 筛选</button>    
                </div>                                 
                </form>    
          </div>                        
          <div id="ajax_return">                  
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="sorting text-left">订单ID</th>
                                <th class="sorting text-left">订单SN</th>
                                <th class="sorting text-left">发货时间</th>
                                <th class="sorting text-left">下单时间</th>
                                <th class="sorting text-left">订单总价</th>
                                <th class="sorting text-left">付款金额</th>
                                <th class="sorting text-left">使用<?php echo tpCache('distribut.jifeng_name');?></th>                               
                               
                                <th class="sorting text-left">分佣金额</th>
                                 <th class="sorting text-left" style="display:none">优惠金额</th>
                                <th class="sorting text-left">余额抵扣</th>
                                <th class="sorting text-left">商品总价</th>
                                <th class="sorting text-left">订单状态</th>
                                <th class="sorting text-left">发货状态</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                                    <td class="text-left"><?php echo ($v["order_id"]); ?></td>
                                    <td class="text-left"><?php echo ($v["order_sn"]); ?></td>
                                    <td class="text-left"><?php if($v['shipping_time'] == 0): ?>未发货<?php else: echo (date("Y-m-d H:i",$v["shipping_time"])); endif; ?></td>
                                    <td class="text-left"><?php echo (date("Y-m-d H:i",$v["add_time"])); ?></td>
                                    <td class="text-left"><?php echo ($v["total_amount"]); ?></td>
                                    <td class="text-left"><?php echo ($v["order_amount"]); ?></td>
<?php if($v["fangshi"] == 2): ?><td class="text-left"><span style="color:#F00">抵：</span><?php echo ($v["integral"]); ?>=<?php echo ($v["integral_money"]); ?>元</td>
                                    <td class="text-left" ><?php echo (about_xin("order_goods",'order_id='.$v["order_id"],'sum(distributa) as money','money')); ?></td>
<?php else: ?>
                                    <td class="text-left"><span style="color:#090">赠：</span><?php echo ($v["gift_jifeng"]); ?>=<?php echo ($v["gift_jifeng_money"]); ?>元</td>
                                    <td class="text-left" ><?php echo (about_xin("order_goods",'order_id='.$v["order_id"],'sum(distribut) as money','money')); ?></td><?php endif; ?> 
                                    <td class="text-left" style="display:none"><?php echo ($v["coupon_price"]); ?></td>
                                    <td class="text-left"><?php echo ($v["user_money"]); ?></td>
                                    <td class="text-left"><?php echo ($v["goods_price"]); ?></td>
                                    <td class="text-left"><?php echo ($shipping_status[$v['shipping_status']]); ?></td>
                                    <td class="text-left"><?php echo ($order_status[$v['order_status']]); ?></td>
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
 
$(document).ready(function() {
	$('#create_date').daterangepicker({
		format:"YYYY-MM-DD",
		singleDatePicker: false,
		showDropdowns: true,
		minDate:'2018-12-01',
		maxDate:'2030-01-01',
		startDate:'2018-12-01',
        showWeekNumbers: true,
        timePicker: false,
        timePickerIncrement: 1,
        timePicker12Hour: true,
        ranges: {
           '今天': [moment(), moment()],
           '昨天': [moment().subtract('days', 1), moment().subtract('days', 1)],
           '最近7天': [moment().subtract('days', 6), moment()],
           '最近30天': [moment().subtract('days', 29), moment()],
           '上一个月': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
        },
        opens: 'right',
        buttonClasses: ['btn btn-default'],
        applyClass: 'btn-small btn-primary',
        cancelClass: 'btn-small',
	    locale : {
            applyLabel : '确定',
            cancelLabel : '取消',
            fromLabel : '起始时间',
            toLabel : '结束时间',
            customRangeLabel : '自定义',
            daysOfWeek : [ '日', '一', '二', '三', '四', '五', '六' ],
            monthNames : [ '一月', '二月', '三月', '四月', '五月', '六月','七月', '八月', '九月', '十月', '十一月', '十二月' ],
            firstDay : 1
        }
	});
});
</script>
</body>
</html>