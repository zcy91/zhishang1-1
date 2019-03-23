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
           <nav class="navbar navbar-default">	     
		      <div class="collapse navbar-collapse">
	   				<div class="navbar-form form-inline">
			            <div class="form-group">
			            	<p class="text-success margin blod">店铺:</p>
			            </div>
			             <div class="form-group">
	                           <a class="btn btn-default" href="<?php echo U('Store/store_list');?>">管理</a>&nbsp;&nbsp;&nbsp;&nbsp;                                            
	                           <a class="btn btn-default" href="<?php echo U('Store/apply_list');?>" >开店申请</a>&nbsp;&nbsp;&nbsp;&nbsp;                                            
	                           <a class="btn btn-default" href="<?php echo U('Store/reopen_list');?>" >签约申请</a>&nbsp;&nbsp;&nbsp;&nbsp;
	                           <a class="btn btn-default" href="<?php echo U('Store/apply_class_list');?>">经营类目申请</a>&nbsp;&nbsp;&nbsp;&nbsp;
			            </div>
			            <div class="form-group pull-right">
			            	 <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回"><i class="fa fa-reply"></i></a>
			            </div>			          
			          </div>
			       </div>
           </nav>
        <!--新订单列表 基本信息-->
       	<form action="<?php echo U('Store/review');?>"  method="post" id="review">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">公司及联系人信息</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td>公司名称</td>
                        <td><input type="text" name="company_name" value="<?php echo ($apply["company_name"]); ?>"></td>
                        <td>公司性质:</td><td></td>
                        <td>公司网址:</td>
                        <td><input type="text" name="company_website" value="<?php echo ($apply["company_website"]); ?>"></td>
                    </tr>
                    <tr><td>公司所在地:</td><td></td>
                        <td>公司详细地址:</td>
                        <td><?php echo ($apply["company_address"]); ?></td>
                        <td>固定电话</td><td><?php echo ($apply["company_telephone"]); ?></td>
                    </tr>
                    <tr><td>邮政编码:</td><td><?php echo ($apply["company_zipcode"]); ?></td>
                        <td>电子邮箱:</td><td><?php echo ($apply["company_email"]); ?></td>
                        <td>传真:</td><td><?php echo ($apply["company_fax"]); ?></td>
                    </tr>
                    <tr>
                        <td>联系人姓名:</td><td><input type="text" name="contacts_name" value="<?php echo ($apply["contacts_name"]); ?>"></td>
                        <td>联系人电话:</td><td><input type="text" name="contacts_mobile" value="<?php echo ($apply["contacts_mobile"]); ?>"></td>
                        <td>联系人邮箱:</td><td><input type="text" name="contacts_email" value="<?php echo ($apply["contacts_email"]); ?>"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--新订单列表 收货人信息-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">营业执照信息（副本）</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
					<td>营业执照号:</td><td><?php echo ($apply["business_licence_number"]); ?></td>
					<td>营业执照有效期:</td><td><?php echo ($apply["business_date_start"]); ?>=><?php echo ($apply["business_date_end"]); ?></td>
					<td>法定经营范围:</td><td><?php echo ($apply["business_scope"]); ?></td>
                    </tr>
                    <tr>
   					<td>注册资本:</td><td><?php echo ($apply["reg_capital"]); ?></td>
					<td>组织机构代码:</td><td><?php echo ($apply["orgnization_code"]); ?></td>
			 		<td>一般纳税人证明:</td><td><?php echo ($apply["reg_capital"]); ?></td>
                    </tr>
                    <tr>
   					<td>法人代表姓名:</td><td><?php echo ($apply["legal_person"]); ?></td>
					<td>纳税类型码:</td><td><?php echo ($apply["tax_rate"]); ?></td>
			 		<td>税务登记号码:</td><td><?php echo ($apply["attached_tax_number"]); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--新订单列表 商品信息-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">结算账号信息 </h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td class="text-left">银行开户名</td>
                        <td class="text-left">公司银行账号：</td>
                        <td class="text-right">开户银行支行名称：</td>
                        <td class="text-right">支行联行号：</td>
                        <td class="text-right">开户银行所在地：</td>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-left"><?php echo ($apply["bank_account_name"]); ?></td>
                            <td class="text-left"><?php echo ($apply["bank_account_number"]); ?></td>
                            <td class="text-right"><?php echo ($apply["bank_branch_name"]); ?></td>
                            <td class="text-right"><?php echo ($apply["bank_province"]); ?></td>
                            <td class="text-right"><?php echo ($apply["bank_city"]); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--新订单列表 费用信息-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">店铺经营信息</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td class="text-right">卖家账号:</td><td><?php echo ($apply["seller_name"]); ?></td>
                        <td class="text-right">店铺名称:</td><td><?php echo ($apply["store_name"]); ?></td>
                        <td class="text-right">店铺分类:</td><td><?php echo ($apply["sc_name"]); ?></td>
                        </tr>  
         				<tr>
                        <td class="text-right">店铺负责人:</td><td><?php echo ($apply["store_person_name"]); ?></td>
                         <td class="text-right">负责人手机号码:</td><td><?php echo ($apply["store_person_mobile"]); ?></td>
                         <td class="text-right">负责人QQ号码:</td><td><?php echo ($apply["store_person_qq"]); ?></td>
                        </tr>
                        <tr>
	                        <td class="text-right">店铺等级:</td>
	                        <td>
	                        	<select name="sg_id" id="sg_id" onchange="changepay()">
	                        		<?php if(is_array($store_grade)): foreach($store_grade as $key=>$vo): ?><option value="<?php echo ($vo["sg_id"]); ?>" <?php if($vo[sg_id] == $apply[sg_id]): ?>selected<?php endif; ?> rel="<?php echo ($vo["sg_price"]); ?>"><?php echo ($vo["sg_name"]); ?></option><?php endforeach; endif; ?>	
	                        	</select>
	                        	<input name="sg_name"  id="sg_name" type="hidden" value="<?php echo ($apply["sg_name"]); ?>">
	                        </td>
	                        <td>开店年限：</td><td><input type="text" name="store_end_time"></td>
	                        <td>店铺性质：</td><td><select name="store_type">
                        		<option value="1" <?php if($apply[store_type] == 1): ?>selected<?php endif; ?>>旗舰店</option>
                        		<option value="2" <?php if($apply[store_type] == 2): ?>selected<?php endif; ?>>专卖店</option>
                        		<option value="3" <?php if($apply[store_type] == 3): ?>selected<?php endif; ?>>专营店</option>
	                        </select></td>
                        </tr>
                        <tr>
                        <td class="text-right">付款金额:</td><td><input type="text" id="paying_amount" name="paying_amount" value="<?php echo ($apply["paying_amount"]); ?>"></td>
                        <td class="text-right">付款凭证:</td><td>
                        <?php if(!empty($apply["paying_amount_cert"])): ?><div style="width: 200px;height: 80px;">
	                        	<img height="80" src="<?php echo ($apply["paying_amount_cert"]); ?>" nc_type="store_label">
	         				</div><?php endif; ?>
         				<input type="hidden" name="paying_amount_cert" id="paying_amount_cert" value="<?php echo ($apply["paying_amount_cert"]); ?>">
                        <input type="button" class="button" onClick="GetUploadify(1,'paying_amount_cert','seller','')"  value="上传 付款凭证"/>
                        </td>
                  		</tr>
                  		<tr>
	                        <td class="text-right">经营类目:</td>
	                        <td colspan="5">
	                        	<table class="table table-bordered">
	                        		<tr><th>一级类目</th><th>二级类目</th><th>三级类目</th></tr>
		                			<?php if(is_array($bind_class_list)): foreach($bind_class_list as $key=>$vo): ?><tr>
				            			<td><?php echo ($vo["class_1"]); ?></td>
				            			<td><?php echo ($vo["class_2"]); ?></td>
				            			<td><?php echo ($vo["class_3"]); ?></td>
			            			</tr><?php endforeach; endif; ?>
	                        	</table>
	                        </td>
         				</tr>
                    <tr style="cursor: pointer;" class="td-shop-lnglat">
                        <td  class="text-right">店铺经度:</td>
                        <td colspan="5"><?php echo ($lng); ?></td>
                    </tr>
                    <tr style="cursor: pointer;" class="td-shop-lnglat">
                        <td  class="text-right">店铺纬度:</td>
                        <td colspan="5"><?php echo ($lat); ?></td>
                    </tr>
                    </tbody>
                </table>

            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">证件信息</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <td class="text-left">企业营业执照副本：</td>
                        <td class="text-left">税务登记证复印件：</td>
                        <td class="text-right">织机构代码证复印件：</td>
                        <td class="text-right">法人身份证：</td>
                        <td class="text-right">店铺负责人身份证：</td>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-left"><a href="<?php echo ($apply["business_licence_cert"]); ?>" target="_blank"><img src="<?php echo ($apply["business_licence_cert"]); ?>" height="60"></a></td>
                            <td class="text-left"><a href="<?php echo ($apply["taxpayer_cert"]); ?>" target="_blank"><img src="<?php echo ($apply["taxpayer_cert"]); ?>" height="60"></a></td>
                            <td class="text-right"><a href="<?php echo ($apply["orgnization_cert"]); ?>" target="_blank"><img src="<?php echo ($apply["orgnization_cert"]); ?>" height="60"></a></td>
                            <td class="text-right"><a href="<?php echo ($apply["legal_identity_cert"]); ?>" target="_blank"><img src="<?php echo ($apply["legal_identity_cert"]); ?>" height="60"></a></td>
                            <td class="text-right"><a href="<?php echo ($apply["store_person_cert"]); ?>" target="_blank"><img src="<?php echo ($apply["store_person_cert"]); ?>" height="60"></a></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--新订单列表 操作信息-->
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title text-center">操作信息</h3>
            </div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <div class="row">
                            <td class="text-right col-sm-2"><p class="margin">备注说明：</p></td>
                            <td colspan="3">
                               <textarea name="review_msg" placeholder="请输入操作备注" rows="3" class="form-control"></textarea>
                            </td>
                        </div>
                    </tr>
                    <tr>
                            <td class="text-right col-sm-2"><p class="margin">商家信息审核：</p></td>
                            <td colspan="2">
                                <div class="input-group margin">
                                  <input type="radio" name="apply_state" value="0">未审核
                                  <input type="radio" name="apply_state" value="1">通过
                                  <input type="radio" name="apply_state" value="2">未通过
                                </div>
                            </td>
                            <td>
                               <div class="input-group">
                                	<input type="submit" class="btn btn-info" value="确定">
                                	&nbsp;&nbsp;&nbsp;&nbsp;
                                	<input type="hidden" name="id" value="<?php echo ($apply["id"]); ?>">
                                	<input type="reset" class="btn btn-default" value="重置">
                                </div>
                            </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        </form>
       </div>
	  </div>
    </div> 
   </section>
</div>



<!--店铺经纬度展示-样式-->
<style>
    body,html{
        position: relative;
    }
    .shop-lnglat-container{
        position: fixed;
        position: -ms-device-fixed;
        width: 70%;
        height: 70%;
        box-sizing: border-box;
        box-sizing: -webkit-border-box;
        box-sizing: -moz-border-box;
        padding: 10px;
        border-radius: 5px;
        background: #fff;
        border: 1px solid #ccc;
        left: 15%;
        top: 15%;
        display: none;
    }
    .shop-lnglat-container > .shop-lnglag-close{
        display: block;
        position: absolute;
        right: 0;
        top: 0;
        width: 40px;
        height: 40px;
        border-radius: 5px;
        cursor: pointer;
        background: rgb(0,0,0) url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAADoklEQVRoQ82Zz2vTUBzAv9+0iLftJqzgwb/C/agbu3gTBAeCIPUgTJTm7TbwYDzILo5ujbQoKENFlKEHUcSLDA/Di7CL6HAMlYmTCanipWXJV15pSpqlfS95r429tUlePp/vrzxShNDHNM0jiPgUEQulUmkrfDyN74VC4fDQ0NCq53k3bNt+F2TA4JcW/DoAHCOiXcMw8mlLcPjh4eGXADBNRH+JaKpcLr/3udsCQXj/YNoSlmUdqtVqrzh8INC/AWB0aWnpI/+tKTA3N5cjorc88uES4RKIyC/4Msjy4fCO4zxHxJMRTHtENF4ulz8jh/c8bx0Rj3YDJKIdRMwPSqIXfIDxx/7+/jgWi8VZwzCqougOSsKyrKzjOC+iIh/BuNYsoWKxOG8YxkLaEi14PgFPSbB8MwxjrN3EaUskgS+VSt87xmgcCc/zRm3b3hFFSub4zMxMZmRk5FmcyHP49hQK3oQxZgHANYkbf3Vdd0JVgsPncrnHAHBGdE8iapaNDx8pwH80TXMBEedFCwKAkoRlWUatVnuSFL6rwCAkWvD3AeCcKFBRkT/wJI5aJE4mGo3G8UqlsiuC4cd1wffMgA8SQ2Kr0WjkJSSQMfZANfJSGfBPYoyVAIBJRFckgaZp3kXEC6K1epVN8NqOMdprUQ0S2uGlSig0YhNnwjTNezojH6uEkkq4rjtm2/YeY6wCAJd0lU2iEkoiQUSfAGANEWf7AR+7hEISUlEVgfPjsg0btZZ0E0ddLFsavSRU4JUyEBixKpnYRsQTwb2NTMaUeyB8k4SZ2CaiseXl5Z9xobUL8AVjSmiB11JCgS3HHUS8KBlN5dJJ/ByIAORP2Nsx4JtLqDavLgEOv4KI5yUj33GaDgmVMaoE75uoSiQV0AKvQyKJQBz4bQB43a99UJIpJA1PRJsAMMnnvGmaNiJeEfVJknKKk4FY8NlsdmJxcfFXYMz2RUJWgMM/QsSzElHcDMP3U0JGQAt8vyREAlrh+yHRS6Av8LoluglIwwPAh0wmMxVsWFGf6JQ4INB60fpQpmE5fL1ez1erVUcWOnye6ojtEGjBryLiaQkgZXgdmWgLpAWvKtEUSBteRQL/F/ikEvxF62UAuCVR8xv1en1apWEl7tE8RbaxAeCNbAY2XNedtG37jyyE6nkiCX/jJ9MDA4cXlVNw1yqaQqnBd5MIb7mjngP+Qyx1+LCE7J98vLGvu657c5A1L+oZxthVRFwJv8X7B4Iz+Rrpa9/BAAAAAElFTkSuQmCC") no-repeat;
        background-size: 70%;
        background-position: center center;
        z-index: 999;
    }
    .shop-lnglat-container > .shop-lnglat-map{
        width: 100%;
        height: 100%;
    }
</style>
<!--店铺经纬度展示-脚本-->
<script type="text/javascript" src="https://api.map.baidu.com/api?v=3.0&ak=hWvZskNqtgscOPrf4T4AhKhkVVuuRC7v"></script>
<script>
    $(function () {
        $("#shop_lnglag_close").on("click",function (e) {
            var _this = $(this);
            _this.parent().hide();
        });
        $(".td-shop-lnglat").on("click",function (e) {
            $("#shop_lnglat_container").show();
            //初始化百度地图
            var map = new BMap.Map("allmap");
            var point = new BMap.Point(<?php echo ($lng); ?>, <?php echo ($lat); ?>);
            map.centerAndZoom(point, 18);
            map.enableScrollWheelZoom();
            var marker = new BMap.Marker(point);        // 创建标注
            map.addOverlay(marker);
        });
    });
</script>
<!--店铺经纬度展示-->
<div class="shop-lnglat-container" id="shop_lnglat_container">
    <i class="shop-lnglag-close" title="关闭" id="shop_lnglag_close"></i>
    <div class="shop-lnglat-map" id="allmap"></div>
</div>
</body>
<script>
function changepay(){
	$('#sg_name').val($('#sg_id option:selected').text());
	$('#paying_amount').val($('#sg_id option:selected').attr('rel'));
}
</script>
</html>