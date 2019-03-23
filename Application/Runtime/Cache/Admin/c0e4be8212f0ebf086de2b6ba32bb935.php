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
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-list"></i> 手机导航</h3>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_tongyong" data-toggle="tab">手机导航</a></li>
                    </ul>
                    <!--表单数据-->
                    <form method="post" id="addEditNavForm"  onsubmit="return checkName();">                    
                        <!--通用信息-->
                    <div class="tab-content">                 	  
                        <div class="tab-pane active" id="tab_tongyong">
                           
                            <table class="table table-bordered">
                                <tbody>                               
                                <tr>
                                    <td>所属位置:</td>                                    
                                    <td>
                                <?php if(is_array($wap_lei_show)): $i = 0; $__LIST__ = $wap_lei_show;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><input type="radio" name="lei"  value="<?php echo ($i-1); ?>" <?php if($navigation["lei"] == $i-1): ?>checked="checked"<?php endif; ?>/>&nbsp;<?php echo ($list); ?>&nbsp;<?php endforeach; endif; else: echo "" ;endif; ?>   
                                    </td>
                                </tr> 
                          
                                <tr>
                                    <td>导航名称:</td>
                                    <td>
                                        <input type="text" value="<?php echo ($navigation["name"]); ?>" id="name" name="name" class="form-control" style="width:550px;"/>
                                        <input type="hidden" id="goods_id" name="goods_id" class="form-control" style="width:250PX" value="<?php echo ($navigation["goods_id"]); ?>">
                             		    <input class="btn btn-primary" type="button" onclick="selectGoods()" value="绑定商品"> <span style="color:#F00;">
                                        <span id="err_name" style="color:#F00; display:none;">导航名称不能为空!!</span>                                        
                                    </td>
                                </tr> 
   
                                <tr>
                                    <td>导航图标:</td>
                                    <td>
                                       <input type="text" id="imagetext" name="img" value="<?php echo ($navigation["img"]); ?>" class="form-control" style="width:550px;">
                                       <input type="button" class="btn btn-primary" onClick="GetUploadify(1,'imagetext','ad','')"  value="上传图片"/>
                                        <span istyle="color:#F00;">建议图标尺寸：宽：100px,高：100px</span>                                        
                                    </td>
                                </tr> 
                                <tr>
                                    <td>链接地址:</td>
                                    <td>
                                        <input type="text" value="<?php echo ($navigation["url"]); ?>" name="url" id="url" class="form-control" />
                                        <span id="err_url" style="color:#F00; display:none;"></span>
                                    </td>
                                </tr>

                                <tr>
                                    <td>排序:</td>
                                    <td>
                                        <input type="text" value="<?php echo ($navigation["sort"]); ?>" name="sort" class="form-control" style="width:200px;" placeholder="50"/>                               
                                    </td>
                                </tr>  
                                
                                <tr>
                                    <td>是否显示:</td>                                    
                                    <td>

                                    <input type="radio" name="is_show"  value="1" <?php if(($navigation["is_show"] == 1) or $navigation["is_show"] == ''): ?>checked="checked"<?php endif; ?>/>&nbsp;显示&nbsp;
                                    <input type="radio" name="is_show"  value="0" <?php if($navigation["is_show"] == '0'): ?>checked="checked"<?php endif; ?>/>&nbsp;隐藏&nbsp;

                                    </td>
                                </tr> 
                                
                                <tr>
                                    <td>是否新窗口:</td>                                    
                                    <td>
                                    <input type="radio" name="is_new"  value="1" <?php if($navigation["is_new"] == 1): ?>checked="checked"<?php endif; ?>/>&nbsp;新窗口&nbsp;
                                    <input type="radio" name="is_new"  value="0" <?php if($navigation["is_new"] == 0): ?>checked="checked"<?php endif; ?>/>&nbsp;原窗口&nbsp;
                                    </td>
                                </tr> 
                                                                                           
                                </tbody>                                
                                </table>
                        </div>                           
                    </div>              
                    <div class="pull-right">
                        <input type="hidden" name="id" value="<?php echo ($navigation["id"]); ?>">
                        <button class="btn btn-primary" title="" data-toggle="tooltip" type="submit" data-original-title="保存">保存</button>
                    </div>
			    </form><!--表单数据-->
                </div>
            </div>
        </div>    <!-- /.content -->
    </section>
</div>
<script>
// 判断输入框是否为空
function checkName(){
	var name = $("#addEditNavForm").find("input[name='name']").val();
    if($.trim(name) == '')
	{
		$("#err_name").show();
		return false;
	}
	return true;
}
// 更改系统内容
$("#system_nav").change(function(){	
	var text = $(this).find("option:selected").text();
	text = text.replace(/-/ig,""); 
	var val  = $(this).find("option:selected").val();	
	$("input[name='name']").val(text);
	$("input[name='url']").val(val);	
});

function selectGoods(){
    var url = "<?php echo U('Promotion/search_goods',array('tpl'=>'select_goods'));?>";
    layer.open({
        type: 2,
        title: '选择商品',
        shadeClose: true,
        shade: 0.2,
        area: ['75%', '75%'],
        content: url, 
    });
}

function call_back(goods_id,goods_name,store_count,original_img){
	$('#goods_id').val(goods_id);
	$('#name').val(goods_name);
	$('#url').val("/index.php?s=/Mobile/Goods/goodsInfo/id/"+ goods_id +".html");
	$('#imagetext').val(original_img);
	$('#group_num').val(store_count);
	layer.closeAll('iframe');
}
</script>

</body>
</html>