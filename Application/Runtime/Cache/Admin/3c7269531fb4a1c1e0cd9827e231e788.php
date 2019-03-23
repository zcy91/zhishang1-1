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
                    <h3 class="panel-title"><i class="fa fa-list"></i> 用户列表</h3>
                </div>
                
                <div class="panel-body">
                    <div class="navbar navbar-default">
                                <div class="form-group" style="padding:10px">
      <div class="input-group" style="float:left;">
       <select name="ceng" size="1" id="ceng"   class="form-control" style="width:200px;"  onChange="location.href=(this.options[this.selectedIndex].value)">
        <option value="<?php echo U('user/user_pic','ceng=1&key='.$key);?>" <?php if(($ceng) == "1"): ?>selected<?php endif; ?>>查看下一层</option>
        <option value="<?php echo U('user/user_pic','ceng=2&key='.$key);?>" <?php if(($ceng) == "2"): ?>selected<?php endif; ?>>查看下二层</option>
        <option value="<?php echo U('user/user_pic','ceng=3&key='.$key);?>" <?php if(($ceng) == "3"): ?>selected<?php endif; ?>>查看下三层</option>
        <option value="<?php echo U('user/user_pic','ceng=4&key='.$key);?>" <?php if(($ceng) == "4"): ?>selected<?php endif; ?>>查看下四层</option>
        <option value="<?php echo U('user/user_pic','ceng=5&key='.$key);?>" <?php if(($ceng) == "5"): ?>selected<?php endif; ?>>查看下五层</option>
        <option value="<?php echo U('user/user_pic','ceng=10&key='.$key);?>" <?php if(($ceng) == "10"): ?>selected<?php endif; ?>>查看下十层</option>
        <option value="<?php echo U('user/user_pic','ceng=20&key='.$key);?>" <?php if(($ceng) == "20"): ?>selected<?php endif; ?>>查看下二十层</option>
        <option value="<?php echo U('user/user_pic','ceng=30&key='.$key);?>" <?php if(($ceng) == "30"): ?>selected<?php endif; ?>>查看下三十层</option>
       </select>
      </div>
<div class="input-group" style="float:left; margin-left:8px">
  <form action="<?php echo U('user/user_pic');?>"  class="navbar-form form-inline" method="post"   style="padding:0px; margin:0px">
     <input name="ceng" type="hidden" value="<?php echo ($ceng); ?>">
     <input type="text" name="key" value="<?php echo ($key); ?>" placeholder="会员编号或手机号码"  class="form-control">&nbsp; 
     <button type="submit"  class="btn btn-primary pull-right"><i class="fa fa-search"></i> 筛选</button>
  </form>
</div>
<div class="input-group" style="float:right;"><a href="<?php echo U('User/add_user');?>" class="btn btn-info pull-right">添加会员</a></div>
           </div>
</div>
<style>

#content .bloc .content ul {
	list-style: none; padding:0px; margin:0px; padding-top:20px;
}

.tree ul {
	padding-top: 20px; position: relative;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

.tree li {
	float: left; text-align: center;
	list-style-type: none;
	position: relative;
	padding: 20px 5px 0 5px;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s;
}

/*We will use ::before and ::after to draw the connectors*/

.tree li::before, .tree li::after{
	content: '';
	position: absolute; top: 0; right: 50%;
	border-top: 1px solid #ccc;
	width: 50%; height: 20px;
}
.tree li::after{
	right: auto; left: 50%;
	border-left: 1px solid #ccc;
}

/*We need to remove left-right connectors from elements without 
any siblings*/
.tree li:only-child::after, .tree li:only-child::before {
	display: none;
}

/*Remove space from the top of single children*/
.tree li:only-child{ padding-top: 0;}

/*Remove left connector from first child and 
right connector from last child*/
.tree li:first-child::before, .tree li:last-child::after{
	border: 0 none;
}
/*Adding back the vertical connector to the last nodes*/
.tree li:last-child::before{
	border-right: 1px solid #ccc;
	border-radius: 0 5px 0 0;
	-webkit-border-radius: 0 5px 0 0;
	-moz-border-radius: 0 5px 0 0;
}
.tree li:first-child::after{
	border-radius: 5px 0 0 0;
	-webkit-border-radius: 5px 0 0 0;
	-moz-border-radius: 5px 0 0 0;
}

/*Time to add downward connectors from parents*/
.tree ul ul::before{
	content: '';
	position: absolute; top: 0; left: 50%;
	border-left: 1px solid #ccc;
	width: 0; height: 20px;
}

.tree li a{
	display:block; height:90px; line-height:20px;
	border: 1px solid #ccc;
	padding: 5px 5px;
	text-decoration: none;
	color: #666;
	font-family: arial, verdana, tahoma;
	font-size: 12px;
	display: inline-block;
	
	border-radius: 5px;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	
	transition: all 0.5s;
	-webkit-transition: all 0.5s;
	-moz-transition: all 0.5s; cursor:pointer; overflow:hidden}

/*Time for some hover effects*/
/*We will apply the hover effect the the lineage of the element also*/
.tree li a:hover, .tree li a:hover+ul li a {
	background: #c8e4f8; color: #000; border: 1px solid #94a0b4;text-decoration:underline;}
/*Connector styles on hover*/
.tree li a:hover+ul li::after, 
.tree li a:hover+ul li::before, 
.tree li a:hover+ul::before, 
.tree li a:hover+ul ul::before{
	border-color:  #94a0b4;text-decoration:underline}
</style>

<div id="content" class="white">
  <div class="bloc">
    <div class="content" style="min-height:600px;overflow:auto">
    <div class="tree"  style="margin-bottom:15px; width:1000000px;"><?php echo ($moue_list); ?></div> 
  </div>
</div>
</div>
                </div>
            </div>
        </div>        <!-- /.row -->
    </section>
    <!-- /.content -->
</div>

</body>
</html>