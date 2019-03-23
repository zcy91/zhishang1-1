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

    <section class="content ">
        <!-- Main content -->
        <div class="container-fluid">
            <div class="pull-right">
                <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回管理员列表"><i class="fa fa-reply"></i></a>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-list"></i>提现申请</h3>
                </div>
                <div class="panel-body ">   
                    <!--表单数据-->
                    <form method="post" id="withdrawals_form">                    
                        <!--通用信息-->
                    <div class="tab-content col-md-10">                 	  
                        <div class="tab-pane active" id="tab_tongyong">                           
                            <table class="table table-bordered">
                                <tbody>     
                                <tr>
                                    <td class="col-sm-2">帐户可提：</td>
                                    <td class="col-sm-6"><?php echo ($withdrawals_max); ?>元</td>
                                    <td class="col-sm-4"></td>
                                </tr>                            
                                <tr>
                                    <td class="col-sm-2">提现金额：</td>
                                    <td class="col-sm-6">
                                        <input type="text" class="form-control"  name="money" id="money" value="<?php echo ($withdrawals["money"]); ?>"  placeholder="最少提现<?php echo tpCache('distribut.sys_store_min_amount');?>起" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" onKeyUp="this.value=this.value.replace(/[^\d.]/g,'')"/>
                                    </td>
                                    <td class="col-sm-4"></td>
                                </tr>   
                                <tr>
                                    <td>银行名称：</td>
                                    <td>
	                                    <input type="text" class="form-control" placeholder="如:支付宝,农业银行,工商银行等..." name="bank_name" id="bank_name" value="<?php echo ($withdrawals["bank_name"]); ?>" />
                                    </td>
                                    <td></td>                                    
                                </tr>                                
                                <tr>
                                    <td>收款账号：</td>
                                    <td>
	                                    <input type="text" class="form-control" placeholder="如:支付宝账号,建设银行账号" name="account_bank" id="account_bank" value="<?php echo ($withdrawals["account_bank"]); ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td>开户名：</td>
                                    <td>
	                                    <input type="text" class="form-control" placeholder="开户人姓名" name="account_name" id="account_name" value="<?php echo ($withdrawals["account_name"]); ?>" />
                                    </td>
                                </tr>   
                                <tr>
                                    <td></td>
                                    <td><p style="font-size:14px; color:#666"  class="name_html">(当前提现手续费:<span style="color:#f00">万分之<?php echo tpCache('distribut.sys_store_fee');?></span>,<span style="color:#00f">不满二元扣2元</span>)</p>
                                    </td>
                                </tr>                                       
                                </tbody> 
                                <tfoot>
                                	<tr>
                                	<td>
                                		<input type="hidden" name="id" value="<?php echo ($withdrawals["id"]); ?>">
                                	</td>
                               	  <td align="center" valign="middle" ><input class="btn btn-primary" type="button" onclick="checkSubmit()" value="保存" style=" width:50%"></td></tr>
                                </tfoot>                               
                                </table>
                        </div>                           
                    </div>              
			    	</form><!--表单数据-->
                </div>
            </div>
        </div>
    </section>
</div>
<script>

 $("#money").on("input",function(e){
     //获取input输入的值
	    var money=e.delegateTarget.value;
		var bili="<?php echo tpCache('distribut.sys_store_fee');?>";
		var fee=money*bili*0.0001;
		//console.log(fee);
	     if (fee>2) {
            $('.name_html').html('本次申请将扣除<span style="color:#f00">'+ fee+ '元</span>手续费');
         }else{
            $('.name_html').html('本次申请将扣除<span style="color:#f00">2元</span>手续费');
         }
});

    var withdrawals_min = <?php echo tpCache('distribut.sys_store_min_amount');?>;
    var withdrawals_max = <?php echo ($withdrawals_max); ?>;

// 表单验证提交
function checkSubmit(){

	var money = $.trim($('#money').val());
	var bank_name = $.trim($('#bank_name').val());
	var account_bank = $.trim($('#account_bank').val());
	var account_name = $.trim($('#account_name').val());
    //console.log(withdrawals_min);
	if(money == '')
	{
		layer.msg('提现金额必填');	
		$('#money').focus();
		return false;
	}
    if(withdrawals_min > withdrawals_max){
		layer.msg('申请提现金额不得小于￥'+withdrawals_min);	
		$('#money').focus();
        return false;
    }
    if(money < withdrawals_min)
    {
		layer.msg('提现金额必须大于'+withdrawals_min);	
		$('#money').focus();
        return false;
    }
    if(money > withdrawals_max){
		layer.msg('您的最多可提现金￥'+withdrawals_max);	
		$('#money').focus();
        return false;
    }
    if(bank_name == '')
	{
		layer.msg('银行名称必填');	
		$('#bank_name').focus();
		return false;
	}
	if(account_bank == '')
	{
		layer.msg('收款账号必填');	
		$('#account_bank').focus();
		return false;
	}
	if(account_name == '')
	{
		layer.msg('开户名必填');	
		$('#account_name').focus();
		return false;
	}

	$('#withdrawals_form').submit();
}
</script>
</body>
</html>