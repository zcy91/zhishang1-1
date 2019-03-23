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
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1> <?php echo ($plugin["name"]); ?> <small></small> </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> 后台首页</a></li>
            <li><a href="#" class="active"><?php echo ($plugin["name"]); ?>配送区域配置</a></li>
            <!--<li class="active">Data tables</li>-->
        </ol>
    </section>
    <section class="content">
        <!-- Main content -->
        <div class="container-fluid">
            <div class="pull-right">

                <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回"><i class="fa fa-reply"></i></a>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo ($plugin["name"]); ?>配送区域配置</h3>
                </div>
                <div class="panel-body">

                    <!--表单数据-->
                    <form method="post" id="addEditSpecForm" action="">
                        <input type="hidden" name="id" value="<?php echo ($setting["shipping_area_id"]); ?>">
                        <!--通用信息-->
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_tongyong">

                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>配送区域名称：</td>
                                            <td>
                                                <input type="text" value="<?php echo ($setting["shipping_area_name"]); ?>" name="shipping_area_name"/>
                                            </td>
                                        </tr>
                                        <!--<tr>-->
                                            <!--<td>基本费用：</td>-->
                                            <!--<td>-->
                                                <!--<input type="text" value="<?php echo ($setting["config"]["base_fee"]); ?>" name="config[base_fee]"/>-->
                                            <!--</td>-->
                                        <!--</tr>-->
                                        <tr>
                                            <td>首&nbsp;&nbsp;重
                                            <select name="config[first_weight]">
	                                            <?php $__FOR_START_7556__=500;$__FOR_END_7556__=8000;for($v=$__FOR_START_7556__;$v < $__FOR_END_7556__;$v+=500){ ?><option value="<?php echo ($v); ?>" <?php if($setting[config][first_weight] == $v): ?>selected="selected"<?php endif; ?> ><?php echo ($v); ?></option><?php } ?>
                                            </select>
                                            克以内费用：
                                            </td>
                                            <td>
                                                <input type="text" value="<?php echo ($setting["config"]["money"]); ?>" name="config[money]"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>续重每
                                            <select name="config[second_weight]">
	                                            <?php $__FOR_START_621__=500;$__FOR_END_621__=8000;for($v=$__FOR_START_621__;$v < $__FOR_END_621__;$v+=500){ ?><option value="<?php echo ($v); ?>" <?php if($setting[config][second_weight] == $v): ?>selected="selected"<?php endif; ?> ><?php echo ($v); ?></option><?php } ?>
                                            </select>                                            
                                            克或其零数的费用：</td>
                                            <td>
                                                <input type="text" value="<?php echo ($setting["config"]["add_money"]); ?>" name="config[add_money]"/>
                                            </td>
                                        </tr>
                                        <!--<tr>-->
                                            <!--<td>免费额度：</td>-->
                                            <!--<td>-->
                                                <!--<input type="text" value="<?php echo ($setting["config"]["free"]); ?>" name="config[free]"/>-->
                                            <!--</td>-->
                                        <!--</tr>-->
                                        <tr>
                                            <td>配送区域：</td>
                                            <td id="area_list">
                                                <?php if(is_array($select_area)): $i = 0; $__LIST__ = $select_area;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$area): $mod = ($i % 2 );++$i;?><input class="area_list" type="checkbox" checked name="area_list[]" value="<?php echo ($area["region_id"]); ?>"><?php echo ($area["name"]); endforeach; endif; else: echo "" ;endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="pull-right">
                            <button class="btn btn-primary" title="" data-toggle="tooltip" type="submit"  data-original-title="保存"><i class="fa fa-save"></i></button>
                        </div>
			        </form><!--表单数据-->
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td style="width: 150px">配送区域名称：</td>
                            <td>
                                <select name="province" id="province" size="10"  onChange="get_city(this)">
                                    <option value="0">请选择省份</option>
                                    <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><option value="<?php echo ($p["id"]); ?>"><?php echo ($p["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                                <select name="city" id="city" size="10"  onChange="get_area(this)">
                                    <option value="0">请选择城市</option>
                                </select>
                                <select name="district" id="district" size="10">
                                    <option value="0">请选择</option>
                                </select>
                                <button onclick="addArea()" class="btn btn-info" type="button">
                                    <i class="ace-icon fa fa-plus bigger-110"></i>
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>    <!-- /.content -->
    </section>
</div>
<script>
 
    //  添加配送区域
    function addArea(){
        //        
        var province = $("#province").val(); // 省份
        var city = $("#city").val();        // 城市
        var district = $("#district").val(); // 县镇
        var text = '';  // 中文文本
        var tpl = ''; // 输入框 html
        var is_set = 0; // 是否已经设置了
       
       // 设置 县镇
        if(district > 0){
            text = $("#district").find('option:selected').text();
            tpl = '<input class="area_list" type="checkbox" checked name="area_list[]" value="'+district+'">'+text;
            is_set = district; // 街道设置了不再设置市
        }
        // 如果县镇没设置 就获取城市
        if(is_set == 0 && city > 0){
            text = $("#city").find('option:selected').text();
            tpl = '<input class="area_list" type="checkbox" checked name="area_list[]" value="'+city+'">'+text;
            is_set = city;  // 市区设置了不再设省份

        }
        // 如果城市没设置  就获取省份
        if(is_set == 0 && province > 0){
            text = $("#province").find('option:selected').text();
            tpl = '<input class="area_list" type="checkbox" checked name="area_list[]" value="'+province+'">'+text;
            is_set = province;

        }

        var obj = $("input[class='area_list']"); // 已经设置好的复选框拿出来
        var exist = 0;  // 表示下拉框选择的 是否已经存在于复选框中
        $(obj).each(function(){
            if($(this).val() == is_set){  //当前下拉框的如果已经存在于 复选框 中
                layer.alert('已经存在该区域', {icon: 2});  // alert("已经存在该区域");
                exist = 1; // 标识已经存在
            }
        })
        if(!exist)
            $('#area_list').append(tpl); // 不存在就追加进 去 
    }
</script>
</body>
</html>