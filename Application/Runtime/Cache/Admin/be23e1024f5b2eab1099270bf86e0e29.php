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
  <section class="content">
    <div class="container-fluid">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="navbar navbar-default">
              <form action="<?php echo U('Promotion/search_goods',array('tpl'=>'select_goods'));?>" id="search-form2" class="navbar-form form-inline" method="post">
                <div class="form-group">
                  <select name="cat_id" id="cat_id" class="form-control">
                    <option value="">所有分类</option>
                        <?php if(is_array($categoryList)): foreach($categoryList as $k=>$v): ?><option value="<?php echo ($v['id']); ?>" <?php if($v[id] == $cat_id): ?>selected<?php endif; ?>><?php echo ($v['name']); ?></option><?php endforeach; endif; ?>
                  </select>
                </div>
                <div class="form-group">
                  <select name="brand_id" id="brand_id" class="form-control">
                    <option value="">所有品牌</option>
                        <?php if(is_array($brandList)): foreach($brandList as $k=>$v): ?><option value="<?php echo ($v['id']); ?>" <?php if($v[id] == $brand_id): ?>selected<?php endif; ?>><?php echo ($v['name']); ?></option><?php endforeach; endif; ?>
                  </select>
                </div>                         
                <div class="form-group">
                    <select name="intro" class="form-control">
                        <option value="0">全部</option>
                        <option value="is_new">新品</option>
                        <option value="is_recommend">推荐</option>
                    </select>                
                </div>                  

                <div class="form-group">
                  <label class="control-label" for="input-order-id">关键词</label>
                  <div class="input-group">
                    <input type="text" name="keywords" value="<?php echo ($keywords); ?>" placeholder="搜索词" id="input-order-id" class="form-control">
                  </div>
                </div>
                <button type="submit" id="button-filter search-order" class="btn btn-primary"><i class="fa fa-search"></i>查找</button>
              </form>
          </div>
          <div id="ajax_return"> 
			    <div class="table-responsive">
			        <table class="table table-bordered table-hover">
			            <thead>
			                <td class="text-left">选择</td>
			                <td class="text-left">商品名称</td>            
			                <td class="text-left">价格</td>
			                <td class="text-left">库存</td>
			                <td class="text-left">操作</td>
			            </tr>
			            </thead>
			            <tbody id="goos_table">
			                <?php if(is_array($goodsList)): $i = 0; $__LIST__ = $goodsList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                               	<td class="text-left">                
                                    <input type="radio" name="goods_id" data-id="<?php echo ($list["goods_id"]); ?>" data-name="<?php echo ($list["goods_name"]); ?>" data-count="<?php echo ($list["store_count"]); ?>" data-img="<?php echo ($list["original_img"]); ?>" onclick="changeGoods(this)"/>
                                </td>
                                <td class="text-left"><?php echo ($list["goods_name"]); ?></td>
                                <td class="text-left"><?php echo ($list["shop_price"]); ?></td>
                                <td class="text-left"><?php echo ($list["store_count"]); ?></td>
                                <td><a href="javascript:void(0)" onclick="javascript:$(this).parent().parent().remove();">删除</a></td>
                               </tr><?php endforeach; endif; else: echo "" ;endif; ?>   
			            </tbody>
			        </table>
			    </div>
			    <div class="row">
	              	<div class="text-left col-sm-10">
	            		<?php echo ($page); ?>
	            	</div>
	                <div class="text-right col-sm-2">
	                    <a href="javascript:void(0)" style="margin:20px 0;" onclick="select_goods();" class="btn btn-info">确定</a>			                       
					</div>
			    </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script>
  var goods_id = 0 , goods_name = '' , store_count = '';
  function changeGoods(obj){
	  goods_id = $(obj).attr('data-id');
	  goods_name = $(obj).attr('data-name');
	  store_count = $(obj).attr('data-count');
	  original_img = $(obj).attr('data-img');
  }
  
  function select_goods()
  {	  
	   if($("input[type='radio']:checked").length == 0)
	   {
		   layer.alert('请选择商品', {icon: 2}); //alert('请选择商品');
		   return false;
	   }
       window.parent.call_back(goods_id,goods_name,store_count,original_img);
  }    
  </script>
</div>
</body>
</html>