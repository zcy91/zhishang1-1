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
 

<style>
.picture {
    line-height: 0;
    background-color: #FFF;
    text-align: center;
    vertical-align: middle;
    display: table-cell;
    width: 160px;
    height: 100px;
    margin: 0 auto;
    border: solid 1px #F5F5F5;
    overflow: hidden;
}
.picture img {
    max-width: 160px;
    max-height: 100px;
    margin-top: expression(100-this.height/2);
}
</style>
<div class="wrapper">
    <div class="breadcrumbs" id="breadcrumbs">
	<ol class="breadcrumb">
	<?php if(is_array($navigate_admin)): foreach($navigate_admin as $k=>$v): if($k == '后台首页'): ?><li><a href="<?php echo ($v); ?>"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo ($k); ?></a></li>
	    <?php else: ?>    
	        <li><a href="<?php echo ($v); ?>"><?php echo ($k); ?></a></li><?php endif; endforeach; endif; ?>          
	</ol>
</div>

    <section class="content" style="padding:0px 15px;">
        <!-- Main content -->
        <div class="container-fluid">
            <div class="pull-right">
                <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default" data-original-title="返回"><i class="fa fa-reply"></i></a>
                <a onclick="get_help(this)" data-url="http://www.tp-shop.cn/Doc/Indexbbc/article/id/1064/developer/user.html" class="btn btn-default" href="javascript:;"><i class="fa fa-question-circle"></i> 帮助</a>                
            </div>
            <div class="panel panel-default">           
                <div class="panel-body ">   
                    <ul class="nav nav-tabs">
    <li <?php if(ACTION_NAME == 'store_setting'): ?>class="active"<?php endif; ?>><a href="javascript:void(0)" data-url="<?php echo U('Store/store_setting');?>" onclick="goset(this)" data-toggle="tab">店铺设置</a></li> 
    <li <?php if(ACTION_NAME == 'store_slide'): ?>class="active"<?php endif; ?>><a href="javascript:void(0)" data-url="<?php echo U('Store/store_slide');?>" onclick="goset(this)" data-toggle="tab">幻灯片设置</a></li> 
    <li <?php if(ACTION_NAME == 'theme'): ?>class="active"<?php endif; ?> style=" display:none"><a href="javascript:void(0)" data-url="<?php echo U('Store/theme');?>" onclick="goset(this)" data-toggle="tab">店铺主题</a></li> 
    <li <?php if(ACTION_NAME == 'mobile_slide'): ?>class="active"<?php endif; ?>><a href="javascript:void(0)" data-url="<?php echo U('Store/mobile_slide');?>" onclick="goset(this)" data-toggle="tab">手机店铺设置</a></li>
    <li <?php if(ACTION_NAME == 'distribut'): ?>class="active"<?php endif; ?> style="display:none"><a href="javascript:void(0)" data-url="<?php echo U('Store/distribut');?>" onclick="goset(this)" data-toggle="tab">分销设置</a></li>                        
</ul>
                    <!--表单数据-->
                    <form method="post" id="handlepost">                    
                    <!--通用信息-->
                    <div class="tab-content" style="padding:20px 0px;">                 	  
                        <div class="tab-pane active" id="tab_tongyong"> 
                          	<div class="callout callout-inro">
								<p>1. 可以在此处对手机店铺进行设置，修改后的设置需要点击“保存修改”按钮进行保存</p>
						        <p>2. 可以拖拽“轮播”图片以调整顺序，无图片的不予轮播显示</p>
						        <p>3. 跳转URL必须带有“http://”，商品ID必须为数字且为本店发布的商品，非法数据将被自动过滤掉</p>
						        <p>4. 默认手机店铺页面显示的最多20条推荐商品，可以在“出售中的商品”中进行设置</p>
				            </div>
                        </div> 
                        <p class="text-warning">轮播： 手机店铺页面头部区域下方的轮播图片展示，最多可上传5张图片，推荐图片大小640x240</p> 
					  	<div class="row" style="margin:20px auto;text-align:center;max-width:800px;">
						  	<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
			                    <ol class="carousel-indicators">
			                    <?php if(is_array($store_slide)): foreach($store_slide as $k=>$vo): if($vo != ''): ?><li data-target="#carousel-example-generic" data-slide-to="<?php echo ($k); ?>" class=" <?php if($k == 0): ?>active<?php endif; ?>"></li><?php endif; endforeach; endif; ?>
			                    </ol>
			                    <div class="carousel-inner">
			                    <?php if(is_array($store_slide)): foreach($store_slide as $k=>$vo): if($vo != ''): ?><div class="item <?php if($k == 0): ?>active<?php endif; ?>">
			                        <img height="250" src="<?php echo ($vo); ?>" alt="First slide">
			                        <div class="carousel-caption">
			                        </div>
			                      </div><?php endif; endforeach; endif; ?>
			                    </div>
			                    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
			                      <span class="fa fa-angle-left"></span>
			                    </a>
			                    <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
			                      <span class="fa fa-angle-right"></span>
			                    </a>
		                  	</div>
	                  	</div> 
	                 	 
	                 <div class="row col-md-12">
	                 	<?php $__FOR_START_25804__=0;$__FOR_END_25804__=5;for($i=$__FOR_START_25804__;$i < $__FOR_END_25804__;$i+=1){ ?><div class="col-sm-4 col-md-2">
		                  <div class="thumbnail">
		                    <div class="picture"><img  id="srcpath_<?php echo ($i); ?>"  <?php if(empty($store_slide[$i])): ?>src="/Public/images/not_adv.jpg"<?php else: ?>src="<?php echo ($store_slide[$i]); ?>"<?php endif; ?>>
		                    <input type="hidden" id="imgpath_<?php echo ($i); ?>" name="store_slide[]" value="<?php echo ($store_slide[$i]); ?>">
		                    </div>
		                    <div class="caption">
		                    <p>跳转URL...<br/><input type="text" name="store_slide_url[]" class="form-control" value="<?php if(empty($store_slide_url[$i])): ?>http://<?php else: echo ($store_slide_url[$i]); endif; ?>"></p>
		                    <p><input type="button" class="btn btn-default" onClick="upload_img('<?php echo ($i); ?>')"  value="上传图片"/></p>
		                    </div>
		                  </div>
		                </div><?php } ?>
		              </div> 
		             <div class="row" style="text-align:center;"><a href="javascript:void(0)" onclick="adsubmit()" class="btn btn-info margin">提交设置</a></div>         
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

function goset(obj){
	window.location.href = $(obj).attr('data-url');
}

var turn = 0;
function upload_img(i){
	turn = i;
	GetUploadify(1,'store_logo','seller','callback');
}

function callback(img_str){
	$('#imgpath_'+turn).val(img_str);
	$('#srcpath_'+turn).attr('src',img_str);
}
</script>
</body>
</html>