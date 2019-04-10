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
        <!-- Main content -->
        <div class="container-fluid">
            <div class="pull-right">
                <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回"><i class="fa fa-reply"></i></a>
            </div>
            <div class="panel panel-default">           
                <div class="panel-body ">   
                   	<ul class="nav nav-tabs">
                        <?php if(is_array($group_list)): foreach($group_list as $k=>$vo): ?><li <?php if($k == 'distribut'): ?>class="active"<?php endif; ?>><a href="javascript:void(0)" data-url="<?php echo U('System/index',array('inc_type'=>$k));?>" data-toggle="tab" onclick="goset(this)"><?php echo ($vo); ?></a></li><?php endforeach; endif; ?>                        
                    </ul>
                    <!--表单数据-->
                    <form method="post" id="handlepost" action="<?php echo U('System/handle');?>">                    
                        <!--通用信息-->
                    <div class="tab-content" style="padding:20px 0px;">                 	  
                        <div class="tab-pane active" id="tab_smtp">                           
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td colspan="3" style="background:#ccc">积分设置</td>
                                  </tr> 

                                <tr>
                                    <td class="col-sm-2">积分统称</td>
                                    <td class="col-sm-6">                    		
                                     <input type="text" style="width:150px" class="form-control" name="jifeng_name" value="<?php echo ($config["jifeng_name"]); ?>" />
                                    </td>
                                     <td class="col-sm-7" style=" color:#00F">积分统称名称</td>           
                                </tr>  

                                <tr>
                                    <td class="col-sm-2">热积分统称</td>
                                    <td class="col-sm-6">                    		
                                     <input type="text" style="width:150px" class="form-control" name="hot_jifeng_name" value="<?php echo ($config["hot_jifeng_name"]); ?>" />
                                    </td>
                                     <td class="col-sm-7" style=" color:#00F">热积分统称名称</td>           
                                </tr>  
                                <tr>
                                    <td class="col-sm-2">冷积分统称</td>
                                    <td class="col-sm-6">                    		
                                     <input type="text" style="width:150px" class="form-control" name="cold_jifeng_name" value="<?php echo ($config["cold_jifeng_name"]); ?>" />
                                    </td>
                                     <td class="col-sm-7" style=" color:#00F">冷积分统称名称</td>           
                                </tr>
 
                                 <tr>
                                    <td class="col-sm-2">股权统称</td>
                                    <td class="col-sm-6">                    		
                                     <input type="text" style="width:150px" class="form-control" name="equity_name" value="<?php echo ($config["equity_name"]); ?>" />
                                    </td>
                                     <td class="col-sm-7" style=" color:#00F">股权统称名称</td>           
                                </tr>
                                <tr>
                                    <td class="col-sm-2">注册赠送<?php echo ($config["hot_jifeng_name"]); ?></td>
                                    <td class="col-sm-6">                    		
                                     <input type="text" style="width:150px" class="form-control" name="reg_point_rate" value="<?php echo ($config["reg_point_rate"]); ?>" onkeyup="value=value.match(/\d+\.?\d{0,2}/,'')"/>&nbsp;<?php echo ($config["jifeng_name"]); ?>  &nbsp;
                                    </td>
                                     <td class="col-sm-7" style=" color:#F00">新会员注册赠送<?php echo ($config["hot_jifeng_name"]); ?>，不赠送请填0</td>           
                                </tr>  
                                  
                                  
                                <tr>
                                    <td class="col-sm-2"><?php echo ($config["hot_jifeng_name"]); ?>使用比例：</td>
                                    <td class="col-sm-6">                    		
                                       1元 =<input type="text" style="width:150px" class="form-control" name="point_rate" value="<?php echo ($config["point_rate"]); ?>" onkeyup="value=value.match(/\d+\.?\d{0,2}/,'')"/>&nbsp;<?php echo ($config["jifeng_name"]); ?>  &nbsp;
                                    </td>
                                     <td class="col-sm-7" style=" color:#F00">平台购物比例</td>           
                                </tr>  

                                <tr>
                                    <td class="col-sm-2">购买激活<?php echo ($config["hot_jifeng_name"]); ?>比例：</td>
                                    <td class="col-sm-6">                    		
                                       1元 =<input type="text" style="width:150px" class="form-control" name="point_shifang_leng" value="<?php echo ($config["point_shifang_leng"]); ?>" onkeyup="value=value.match(/\d+\.?\d{0,2}/,'')"/>&nbsp;<?php echo ($config["jifeng_name"]); ?>  &nbsp;
                                    </td>
                                     <td class="col-sm-7">不允许购买设置为0</td>           
                                </tr>  
                                
                                <tr>
                                    <td class="col-sm-2"><?php echo ($config["hot_jifeng_name"]); ?>转现金换算比例：</td>
                                    <td class="col-sm-6">                    		
                                       1元 =<input type="text" style="width:150px" class="form-control" name="point_xianjin" value="<?php echo ($config["point_xianjin"]); ?>" onkeyup="value=value.match(/\d+\.?\d{0,2}/,'')"/>&nbsp;<?php echo ($config["jifeng_name"]); ?>  &nbsp;
                                    </td>
                                     <td class="col-sm-7"><?php echo ($config["hot_jifeng_name"]); ?>转换到现金余额帐户,关闭此功能请填0</td>           
                                </tr>  
                                
                                <tr>
                                    <td class="col-sm-2"><?php echo ($config["hot_jifeng_name"]); ?>转赠：</td>
                                    <td class="col-sm-6">                    		
                         				开启:&nbsp;<input type="radio"  name="sys_jifeng_zs" value="1" <?php if($config['sys_jifeng_zs'] == 1): ?>checked="checked"<?php endif; ?> />
                         				关闭:&nbsp;<input type="radio"  name="sys_jifeng_zs" value="0" <?php if($config['sys_jifeng_zs'] == 0): ?>checked="checked"<?php endif; ?> />   
                                    </td>
                                     <td class="col-sm-7"></td>           
                                </tr> 
                                

                                <tr>
                                    <td class="col-sm-2">激活<?php echo ($config["cold_jifeng_name"]); ?>交易权：</td>
                                    <td class="col-sm-6">                    		
                                      <input type="text" style="width:150px" class="form-control" name="point_yue_jifeng" value="<?php echo ($config["point_yue_jifeng"]); ?>" onkeyup="value=value.match(/\d+\.?\d{0,2}/,'')"/>&nbsp;元
                                    </td>
                                     <td class="col-sm-7">激活<?php echo ($config["cold_jifeng_name"]); ?>，固定金额设置，为0关闭激活功能</td>           
                                </tr>  
                                
                                <tr>
                                    <td class="col-sm-2">激活<?php echo ($config["cold_jifeng_name"]); ?>交易权待释额度：</td>
                                    <td class="col-sm-6">                    		
                                       1元 =<input type="text" style="width:150px" class="form-control" name="point_shifang" value="<?php echo ($config["point_shifang"]); ?>" onkeyup="value=value.match(/\d+\.?\d{0,2}/,'')"/>&nbsp;<?php echo tpCache('distribut.jifeng_name');?>  &nbsp;
                                    </td>
                                     <td class="col-sm-7">例：充值10RMB便从待激活<?php echo ($config["cold_jifeng_name"]); ?>释放100W<?php echo ($config["jifeng_name"]); ?>到<?php echo ($config["cold_jifeng_name"]); ?></td>           
                                </tr>    


                                <tr>
                                    <td class="col-sm-2">激活<?php echo ($config["cold_jifeng_name"]); ?>交易权赠送<?php echo ($config["equity_name"]); ?>：</td>
                                    <td class="col-sm-6">                    		
                                      <input name="point_shifang_gq" type="text" class="form-control" style="width:150px" onkeyup="value=this.value.replace(/\D+/g,'')" value="<?php echo ($config["point_shifang_gq"]); ?>" maxlength="2"/>&nbsp;股 &nbsp;
                                    </td>
                                     <td class="col-sm-7">为0不赠送<?php echo ($config["equity_name"]); ?></td>           
                                </tr>  

                               <tr>
                                    <td colspan="3" style="background:#ccc">奖金池设置</td>
                               </tr>     
                                
                                <tr>
                                    <td class="col-sm-2">奖金池分配：</td>
                                    <td class="col-sm-6">                    		
                                      购买平台：<input name="point_gongsibili" type="text"  class="form-control" style="width:80px" onkeyup="value=this.value.replace(/\D+/g,'')" value="<?php echo ($config["point_gongsibili"]); ?>" maxlength="2"/>&nbsp;%
                                      购买合伙人：<input name="point_hehuorbili" type="text" class="form-control" style="width:80px" onkeyup="value=this.value.replace(/\D+/g,'')" value="<?php echo ($config["point_hehuorbili"]); ?>" maxlength="2"/>&nbsp;%
                                    </td>
                                     <td class="col-sm-7">奖金池分配比例，当任意一项满额后，将不可再次购买</td>           
                                </tr>  
                                
                                
                                  <tr>
                                    <td colspan="3" style="background:#ccc"><?php echo tpCache('distribut.equity_name');?>设置</td>
                                  </tr> 

                                <tr>
                                    <td class="col-sm-2">分红比例：</td>
                                    <td class="col-sm-6">                    		
                                      <input name="sys_equity_bili" type="text" class="form-control" style="width:150px" onkeyup="value=this.value.replace(/\D+/g,'')" value="<?php echo ($config["sys_equity_bili"]); ?>" maxlength="2"/>&nbsp;%
                                    </td>
                                     <td class="col-sm-7">每日公司部分奖金池部分，为0则关闭此功能。开启后每日01--02点自动分红</td>           
                                </tr> 
                                                       
                          <tr>
                                    <td colspan="3" style="background:#ccc">返佣设置</td>
                                  </tr> 
                                <tr>
                                    <td class="col-sm-2">分销开关：</td>
                                    <td class="col-sm-6">
                         				开:<input type="radio"  name="switch" value="1" <?php if($config['switch'] == 1): ?>checked="checked"<?php endif; ?> />
                         				关:<input type="radio"  name="switch" value="0" <?php if($config['switch'] == 0): ?>checked="checked"<?php endif; ?> />   
                                    </td>
                                    <td class="col-sm-7"></td>                                    
                                </tr>  

                                <tr>
                                    <td class="col-sm-2">分销模式：</td>
                                    <td class="col-sm-6">
                                        <select class="form-control" name="pattern" id="distribut_pattern">
	                                      <!-- <option value="0" <?php if($config['pattern'] == 0): ?>selected="selected"<?php endif; ?>>按商品设置的分成金额</option>-->
	                                       <option value="1" <?php if($config['pattern'] == 1): ?>selected="selected"<?php endif; ?>>按订单设置的分成比例</option>
                                        </select>
                                    </td>
                                    <td class="col-sm-7"></td>  
                                </tr>
                                <tr id="distribut_order_rate" >
                                    <td class="col-sm-2" style="color:#F00">扣除商家佣金比例：</td>
                                    <td class="col-sm-6">
                         				<input name="order_rate" type="text" class="form-control" onblur="checkInt(this.value,100);" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" value="<?php echo ($config["order_rate"]); ?>" maxlength="3" onpaste="this.value=this.value.replace(/[^\d]/g,'')"/>                                        
                                    </td>
                                    <td class="col-sm-7">% 订单的现金百分之多少拿出来分成。不可大于100%</td>
                                </tr> 
                                
                                
                                <tr>
                                    <td class="col-sm-2">推广合伙人业绩分红：</td>
                                    <td class="col-sm-6">
                         				<input name="sys_hehuo" type="text" class="form-control"  onkeyup="value=this.value.replace(/\D+/g,'')" value="<?php echo ($config["sys_hehuo"]); ?>" maxlength="2"/>
                                    </td>
                                    <td class="col-sm-7" style=" color:#f00">%&nbsp;合伙人加下方任意等级的一级与二级分佣总额不得大于100</td>                                    
                                </tr> 
                                                               
  <?php if(is_array($level_info)): foreach($level_info as $k=>$vo): ?><tr>
                                    <td><?php echo ($vo["level_name"]); ?>：一级分销商比例：</td>
                                    <td >
                         				<input name="first_rate_<?php echo ($vo["level_id"]); ?>" type="text" class="form-control" id="distribut_first_rate" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" value="<?php echo ($config["first_rate_".$vo["level_id"]]); ?>" maxlength="2"onpaste="this.value=this.value.replace(/[^\d]/g,'')" >
                                    </td>
                                    <td class="col-sm-7">%</td>                              
                                </tr>                                  
 
                                <tr>
                                    <td><?php echo ($vo["level_name"]); ?>：二级分销商比例：</td>
                                    <td >
                         				<input name="two_rate_<?php echo ($vo["level_id"]); ?>" type="text" class="form-control" id="distribut_second_rate" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" value="<?php echo ($config["two_rate_".$vo["level_id"]]); ?>" maxlength="2"onpaste="this.value=this.value.replace(/[^\d]/g,'')" >
                                    </td>
                                    <td class="col-sm-7">%</td>                                    
                                </tr><?php endforeach; endif; ?>

                            	<tr style="color:#00F; background:#FED">
                                    <td>等级计算方式</td>
                                    <td colspan="2" style="color:#666"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                      <tr>
                                        <td style="background:#eee; padding:2px"><span style="color:#f00"><?php echo ($level_info[0]['level_name']); ?>等级</span><br><span style=" color:#06F">-->举例:支付现金100元</span><br />
                                          1.扣除商家总分佣:100X<?php echo tpCache('distribut.order_rate');?>%=<span style="color:#f00"><?php echo tpCache('distribut.order_rate')*0.01*100?></span>元<br />
                                          2.推广合伙人业绩分红:<span style="color:#f00"><?php echo tpCache('distribut.order_rate')*0.01*100?></span>X<?php echo tpCache('distribut.sys_hehuo');?>%=<span style="color:#00f"><?php echo tpCache('distribut.order_rate')*0.01*100*tpCache('distribut.sys_hehuo')*0.01?></span>元<br />
                                          3.债务债权一级分销商分佣: <span style="color:#f00"><?php echo tpCache('distribut.order_rate')*0.01*100?></span>X<?php echo tpCache('distribut.first_rate_1');?>%=<span style="color:#FF7F00"><?php echo tpCache('distribut.order_rate')*0.01*100*tpCache('distribut.first_rate_1')*0.01?></span>元<br />
                                          4.债务债权二级分销商分佣：<span style="color:#f00"><?php echo tpCache('distribut.order_rate')*0.01*100?></span>X<?php echo tpCache('distribut.two_rate_1');?>%=<span style="color:#F0F"><?php echo tpCache('distribut.order_rate')*0.01*100*tpCache('distribut.two_rate_1')*0.01?></span>元<br />
                                          5.平台获得佣金：<span style="color:#f00"><?php echo tpCache('distribut.order_rate')*0.01*100?></span>-<span style="color:#00f"><?php echo tpCache('distribut.order_rate')*0.01*100*tpCache('distribut.sys_hehuo')*0.01?></span>-<span style="color:#FF7F00"><?php echo tpCache('distribut.order_rate')*0.01*100*tpCache('distribut.first_rate_1')*0.01?></span>-<span style="color:#F0F"><?php echo tpCache('distribut.order_rate')*0.01*100*tpCache('distribut.two_rate_1')*0.01?></span>=<span style="color:#00f"><?php echo (tpCache('distribut.order_rate')*0.01*100)-(tpCache('distribut.order_rate')*0.01*100*(tpCache('distribut.sys_hehuo')+(tpCache('distribut.first_rate_1'))+(tpCache('distribut.two_rate_1')))*0.01)?></span>元<br />
                                          
                                        </td>
                                        <td style="background:#FEE9F7; padding:2px"><span style="color:#f00"><?php echo ($level_info[1]['level_name']); ?>等级</span><br><span style=" color:#06F">-->举例:支付现金100元</span><br />
                                          1.扣除商家总分佣:100X<?php echo tpCache('distribut.order_rate');?>%=<span style="color:#f00"><?php echo tpCache('distribut.order_rate')*0.01*100?></span>元<br />
                                          2.推广合伙人业绩分红:<span style="color:#f00"><?php echo tpCache('distribut.order_rate')*0.01*100?></span>X<?php echo tpCache('distribut.sys_hehuo');?>%=<span style="color:#00f"><?php echo tpCache('distribut.order_rate')*0.01*100*tpCache('distribut.sys_hehuo')*0.01?></span>元<br />
                                          3.债务债权一级分销商分佣: <span style="color:#f00"><?php echo tpCache('distribut.order_rate')*0.01*100?></span>X<?php echo tpCache('distribut.first_rate_2');?>%=<span style="color:#FF7F00"><?php echo tpCache('distribut.order_rate')*0.01*100*tpCache('distribut.first_rate_2')*0.01?></span>元<br />
                                          4.债务债权二级分销商分佣：<span style="color:#f00"><?php echo tpCache('distribut.order_rate')*0.01*100?></span>X<?php echo tpCache('distribut.two_rate_2');?>%=<span style="color:#F0F"><?php echo tpCache('distribut.order_rate')*0.01*100*tpCache('distribut.two_rate_2')*0.01?></span>元<br />
                                          5.平台获得佣金：<span style="color:#f00"><?php echo tpCache('distribut.order_rate')*0.01*100?></span>-<span style="color:#00f"><?php echo tpCache('distribut.order_rate')*0.01*100*tpCache('distribut.sys_hehuo')*0.01?></span>-<span style="color:#FF7F00"><?php echo tpCache('distribut.order_rate')*0.01*100*tpCache('distribut.first_rate_2')*0.01?></span>-<span style="color:#F0F"><?php echo tpCache('distribut.order_rate')*0.01*100*tpCache('distribut.two_rate_2')*0.01?></span>=<span style="color:#00f"><?php echo (tpCache('distribut.order_rate')*0.01*100)-(tpCache('distribut.order_rate')*0.01*100*(tpCache('distribut.sys_hehuo')+(tpCache('distribut.first_rate_2'))+(tpCache('distribut.two_rate_2')))*0.01)?></span>元<br />
                                        </td>
                                        <td style="background:#D7FFEB; padding:2px"><span style="color:#f00"><?php echo ($level_info[2]['level_name']); ?>等级</span><br><span style=" color:#06F">-->举例:支付现金100元</span><br />
                                          1.扣除商家总分佣:100X<?php echo tpCache('distribut.order_rate');?>%=<span style="color:#f00"><?php echo tpCache('distribut.order_rate')*0.01*100?></span>元<br />
                                          2.推广合伙人业绩分红:<span style="color:#f00"><?php echo tpCache('distribut.order_rate')*0.01*100?></span>X<?php echo tpCache('distribut.sys_hehuo');?>%=<span style="color:#00f"><?php echo tpCache('distribut.order_rate')*0.01*100*tpCache('distribut.sys_hehuo')*0.01?></span>元<br />
                                          3.债务债权一级分销商分佣: <span style="color:#f00"><?php echo tpCache('distribut.order_rate')*0.01*100?></span>X<?php echo tpCache('distribut.first_rate_3');?>%=<span style="color:#FF7F00"><?php echo tpCache('distribut.order_rate')*0.01*100*tpCache('distribut.first_rate_3')*0.01?></span>元<br />
                                          4.债务债权二级分销商分佣：<span style="color:#f00"><?php echo tpCache('distribut.order_rate')*0.01*100?></span>X<?php echo tpCache('distribut.two_rate_3');?>%=<span style="color:#F0F"><?php echo tpCache('distribut.order_rate')*0.01*100*tpCache('distribut.two_rate_3')*0.01?></span>元<br />
                                          5.平台获得佣金：<span style="color:#f00"><?php echo tpCache('distribut.order_rate')*0.01*100?></span>-<span style="color:#00f"><?php echo tpCache('distribut.order_rate')*0.01*100*tpCache('distribut.sys_hehuo')*0.01?></span>-<span style="color:#FF7F00"><?php echo tpCache('distribut.order_rate')*0.01*100*tpCache('distribut.first_rate_3')*0.01?></span>-<span style="color:#F0F"><?php echo tpCache('distribut.order_rate')*0.01*100*tpCache('distribut.two_rate_3')*0.01?></span>=<span style="color:#00f"><?php echo (tpCache('distribut.order_rate')*0.01*100)-(tpCache('distribut.order_rate')*0.01*100*(tpCache('distribut.sys_hehuo')+(tpCache('distribut.first_rate_3'))+(tpCache('distribut.two_rate_3')))*0.01)?></span>元<br />
                                          
                                        </td>
                                      </tr>
  </table>
                                      
                                      
</td>
                                  </tr> 

  

                            	<tr style="color:#F00">
                                    <td>分成时间：</td>
                                    <td >下单后，支付成功即返
                                        <select class="form-control" name="date" id="distribut_date"  style="display:none">
                                                <?php $__FOR_START_12447__=1;$__FOR_END_12447__=31;for($i=$__FOR_START_12447__;$i < $__FOR_END_12447__;$i+=1){ ?><option value="<?php echo ($i); ?>" <?php if($config[date] == $i): ?>selected="selected"<?php endif; ?>><?php echo ($i); ?>天</option><?php } ?>
                                        </select>
                                    </td>
                                    <td class="col-sm-7"><!--订单收货确认后多少天可以分成--></td>                                    
                                </tr> 
                                
                          <tr>
                                    <td colspan="3" style="background:#ccc">会员提现设置</td>
                                  </tr>   

                            	<tr>
                                    <td>最少提现额度：</td>
                                    <td >
                         		<input type="text" class="form-control" name="sys_user_min_amount" id="distribut_sys_user_min_amount" value="<?php echo ($config["sys_user_min_amount"]); ?>"onpaste="this.value=this.value.replace(/[^\d]/g,'')" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" >
                                    </td>
                                    <td class="col-sm-7"></td>                                    
                                </tr> 
                                
                            	<tr>
                                    <td>提现手续费：</td>
                                    <td >
                         		<input type="text" class="form-control" name="sys_user_fee" id="distribut_sys_user_fee" value="<?php echo ($config["sys_user_fee"]); ?>" onpaste="this.value=this.value.replace(/[^\d]/g,'')" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" >
                                    </td>
                                    <td class="col-sm-7">‱提现手续费万分之几</td>                                    
                                </tr>   

                          <tr>
                                    <td colspan="3" style="background:#ccc">商家提现设置</td>
                                  </tr>   

                            	<tr>
                                    <td>最少提现额度：</td>
                                    <td >
                         		<input type="text" class="form-control" name="sys_store_min_amount" id="distribut_sys_store_min_amount" value="<?php echo ($config["sys_store_min_amount"]); ?>"onpaste="this.value=this.value.replace(/[^\d]/g,'')" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" >
                                    </td>
                                    <td class="col-sm-7"></td>                                    
                                </tr> 
                                
                            	<tr>
                                    <td>提现手续费：</td>
                                    <td >
                         		<input type="text" class="form-control" name="sys_store_fee" id="distribut_sys_store_fee" value="<?php echo ($config["sys_store_fee"]); ?>" onpaste="this.value=this.value.replace(/[^\d]/g,'')" onkeyup="this.value=this.value.replace(/[^\d]/g,'')" >
                                    </td>
                                    <td class="col-sm-7">‱提现手续费万分之几</td>                                    
                                </tr>  
                   
                   
                          <tr>
                                    <td colspan="3" style="background:#ccc">债务债权设置</td>
                                  </tr> 
                                <tr>
                                    <td class="col-sm-2">升级开关：</td>
                                    <td class="col-sm-6">
                         				<input type="radio"  name="debt_switch" value="0" <?php if($config['debt_switch'] == 0): ?>checked="checked"<?php endif; ?> /> 审核
                         				<input type="radio"  name="debt_switch" value="1" <?php if($config['debt_switch'] == 1): ?>checked="checked"<?php endif; ?> /> 不审核
                                    </td>
                                    <td class="col-sm-7">会员申请为债务债权等级，是否后台审核</td>                                    
                                </tr>  
                                <tr>
                                    <td class="col-sm-2">债务债务：</td>
                                    <td class="col-sm-6">
                         				<input type="radio"  name="right_switch" value="0" <?php if($config['right_switch'] == 0): ?>checked="checked"<?php endif; ?> />&nbsp;审核
                         				<input type="radio"  name="right_switch" value="1" <?php if($config['right_switch'] == 1): ?>checked="checked"<?php endif; ?> />&nbsp;不审核
                                    </td>
                                    <td class="col-sm-7">会员提交债务债务信息后，是否后台审核 </td>                                    
                                </tr>  
                                <tr>
                                    <td class="col-sm-2">债务债务比例：</td>
                                    <td class="col-sm-6">
                         				1元=<input type="text" style="width:150px" class="form-control" name="debt_amount" value="<?php echo ($config["debt_amount"]); ?>" onkeyup="value=value.match(/\d+\.?\d{0,2}/,'')"/> 待激活额度
                                    </td>
                                    <td class="col-sm-7">自动换算比例</td>                                    
                                </tr>  
                                
                                
                                </tbody> 
                                <tfoot>
                                	<tr>
                                	<td><input type="hidden" name="inc_type" value="<?php echo ($inc_type); ?>"></td>
                                	<td class="text-right"><input class="btn btn-primary" type="button" onclick="adsubmit()" value="保存" style="width:25%"></td></tr>
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



    function adsubmit(){
        $('#handlepost').submit();
    }

$('#distribut_pattern').change(function(){
	 if($(this).val() == 1)
	    $('#distribut_order_rate').show();
	 else	
	    $('#distribut_order_rate').hide();	 
});

$(document).ready(function(){
	get_province();
});

function goset(obj){
	window.location.href = $(obj).attr('data-url');
}
</script>
</body>
</html>