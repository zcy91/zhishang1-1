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
 

<style type="text/css">
	select.form-control{display: initial;float: left;}	
	 .ajax_bradnlist{height:318px; overflow:auto}	
     .ajax_bradnlist ul{clear:both;padding-top: 10px }
	 .ajax_bradnlist ul li{ float: left; display:inline-flex; display:-moz-inline-flex; display:-webkit-inline-box; width:20%; padding:6px 0; }
	 .table-bordered th:first-child{ width:8%}
	 .table-bordered tbody tr td{ vertical-align:middle}
	 .form-control{ resize:vertical}
</style>
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
                <div class="col-sm-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">增加分类</h3>
                        </div>
                        <!-- /.box-header -->
                        <form action="<?php echo U('Goods/addEditCategory');?>" method="post" class="form-horizontal" id="category_form">
                        <div class="box-body">                         
                                <div class="form-group">
                                     <label class="col-sm-2 control-label">分类名称</label>
                                     <div class="col-sm-6">
                                        <input type="text" placeholder="名称" class="form-control large" name="name" value="<?php echo ($goods_category_info["name"]); ?>">
                                        <span class="help-inline" style="color:#F00; display:none;" id="err_name"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2">手机分类名称</label>
                                    <div class="col-sm-6">
                                        <input type="text" placeholder="手机分类名称" class="form-control large" name="mobile_name" value="<?php echo ($goods_category_info["mobile_name"]); ?>">
                                        <span class="help-inline" style="color:#F00; display:none;" id="err_mobile_name"></span>
                                    </div>
                                </div> 
                                <div class="form-group">
                                    <label0 class="control-label col-sm-2">上级分类</label0>

                                    <div class="col-sm-3">
                                        <select name="parent_id_1" id="parent_id_1" onchange="get_category(this.value,'parent_id_2','0');" class="small form-control">
	                                        <option value="0">顶级分类</option>
                                            <?php if(is_array($cat_list)): foreach($cat_list as $key=>$v): ?><option value="<?php echo ($v[id]); ?>"><?php echo ($v[name]); ?></option><?php endforeach; endif; ?>                                            
										</select>
                                    </div>                                    
                                    <div class="col-sm-3">
                                      <select name="parent_id_2" id="parent_id_2"  class="small form-control">
                                        <option value="0">请选择商品分类</option>
                                      </select>  
                                    </div>                                      
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-2">导航显示</label>
									
                                    <div class="col-sm-10">
                                        <label> 
                                            <?php if(($goods_category_info[is_show] == 1) or ($goods_category_info[is_show] == NULL)): ?><input checked="checked" type="radio" name="is_show" value="1"> 是
                                                <input type="radio" name="is_show" value="0"> 否
                                            <?php else: ?> 
                                                <input type="radio" name="is_show" value="1"> 是
                                                <input checked="checked" type="radio" name="is_show" value="0"> 否<?php endif; ?>                                                                                                                                    
                                        </label>
                                    </div>
                                </div>
				<div class="form-group">
                                    <label class="control-label col-sm-2">分类分组:</label>
									
                                    <div class="col-sm-1">
                                      <select name="cat_group" id="cat_group" class="form-control">
                                        <option value="0">0</option>                                        
                                        <option value='1' <?php if($goods_category_info[cat_group] == 1): ?>selected='selected'<?php endif; ?>>1</option>"
                                        <option value='2' <?php if($goods_category_info[cat_group] == 2): ?>selected='selected'<?php endif; ?>>2</option>"
                                        <option value='3' <?php if($goods_category_info[cat_group] == 3): ?>selected='selected'<?php endif; ?>>3</option>"
                                        <option value='4' <?php if($goods_category_info[cat_group] == 4): ?>selected='selected'<?php endif; ?>>4</option>"
                                        <option value='5' <?php if($goods_category_info[cat_group] == 5): ?>selected='selected'<?php endif; ?>>5</option>"
                                        <option value='6' <?php if($goods_category_info[cat_group] == 6): ?>selected='selected'<?php endif; ?>>6</option>"
                                        <option value='7' <?php if($goods_category_info[cat_group] == 7): ?>selected='selected'<?php endif; ?>>7</option>"
                                        <option value='8' <?php if($goods_category_info[cat_group] == 8): ?>selected='selected'<?php endif; ?>>8</option>"
                                        <option value='9' <?php if($goods_category_info[cat_group] == 9): ?>selected='selected'<?php endif; ?>>9</option>"
                                        <option value='10' <?php if($goods_category_info[cat_group] == 10): ?>selected='selected'<?php endif; ?>>10</option>"
                                        <option value='11' <?php if($goods_category_info[cat_group] == 11): ?>selected='selected'<?php endif; ?>>11</option>"
                                        <option value='12' <?php if($goods_category_info[cat_group] == 12): ?>selected='selected'<?php endif; ?>>12</option>"
                                        <option value='13' <?php if($goods_category_info[cat_group] == 13): ?>selected='selected'<?php endif; ?>>13</option>"
                                        <option value='14' <?php if($goods_category_info[cat_group] == 14): ?>selected='selected'<?php endif; ?>>14</option>"
                                        <option value='15' <?php if($goods_category_info[cat_group] == 15): ?>selected='selected'<?php endif; ?>>15</option>"
                                        <option value='16' <?php if($goods_category_info[cat_group] == 16): ?>selected='selected'<?php endif; ?>>16</option>"
                                        <option value='17' <?php if($goods_category_info[cat_group] == 17): ?>selected='selected'<?php endif; ?>>17</option>"
                                        <option value='18' <?php if($goods_category_info[cat_group] == 18): ?>selected='selected'<?php endif; ?>>18</option>"
                                        <option value='19' <?php if($goods_category_info[cat_group] == 19): ?>selected='selected'<?php endif; ?>>19</option>"
                                        <option value='20' <?php if($goods_category_info[cat_group] == 20): ?>selected='selected'<?php endif; ?>>20</option>"
                                      </select>                                        
                                    </div>                                    
                                </div>   
                             
				  <div class="form-group">
	                                    <label class="control-label col-sm-2">分类展示图片</label>

                                    <div class="col-sm-10">
                                        <input onclick="GetUploadify(1,'image','category');" type="button" value="上传图片"/>
                                        <input type="text" value="<?php echo ($goods_category_info["image"]); ?>" name="image" id="image" class="form-control large" readonly="readonly"  style="width:500px;display:initial;"/>
                                    </div>
                                </div>                                
                               <div class="form-group">
                                    <label class="control-label col-sm-2">显示排序</label>
                                    <div class="col-sm-1">
                                        <input type="text" placeholder="50" class="form-control large" name="sort_order" value="<?php echo ($goods_category_info["sort_order"]); ?>"/>
                                        <span class="help-inline" style="color:#F00; display:none;" id="err_sort_order"></span>
                                    </div>
                                </div>
								<div class="form-group" style="display:none">
                                    <label class="control-label col-sm-2">抽成比例</label>
                                    <div class="col-sm-1">
                                        <input type="text" placeholder="50" class="form-control large" name="commission" id="commission" value="<?php echo ((isset($goods_category_info["commission"]) && ($goods_category_info["commission"] !== ""))?($goods_category_info["commission"]):'0'); ?>" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" onkeyup="this.value=this.value.replace(/[^\d.]/g,'')"/>
                                    </div>
                                    <div class="col-sm-1" style="margin-top: 6px;margin-left: -20px;">
                                        <span>%</span> 
                                    </div>
                                </div>                                								                                                               
								<div class="form-group">
                                    <label class="control-label col-sm-2">关联类型</label>
                                    <div class="col-sm-7">
                                        <select name="cat_id1" id="cat_id1" class="form-control" onchange="get_category(this.value,'cat_id2','0');spec_scroll(this);" style="width:250px;">
                                            <option value="0">所有分类</option>
                                            <?php if(is_array($cat_list)): foreach($cat_list as $key=>$v): ?><option value="<?php echo ($v['id']); ?>"><?php echo ($v['name']); ?></option><?php endforeach; endif; ?>                                            
                                        </select>                    
                                        <select name="cat_id2" id="cat_id2" class="form-control"  onchange="get_category(this.value,'cat_id3','0');"  style="width:250px;">
                                            <option value="0">请选择商品分类</option>
                                        </select>
                                        <select name="cat_id3" id="cat_id3" class="form-control" style="width:250px;">
                                            <option value="0">请选择商品分类</option>
                                        </select>                                      
                                    </div>                                   
                                </div>   
								<div class="form-group">
                                    <label class="control-label col-sm-2"></label>                                    
                                         <div id="ajax_brandList" class="ajax_bradnlist">                                                
                                            <?php if(is_array($goods_category_list)): foreach($goods_category_list as $k=>$v): ?><ul>
                                                        <h5 id="type_id_<?php echo ($v[id]); ?>"><strong><?php echo ($v[name]); ?></strong></h5>
                                                        <?php if(is_array($goods_type_list)): foreach($goods_type_list as $k2=>$v2): if($v2['cat_id1'] == $v[id]): ?><li><input type="radio" name="type_id" value="<?php echo ($v2['id']); ?>" <?php if($goods_category_info[type_id] == $v2['id']): ?>checked="checked"<?php endif; ?> />&nbsp;&nbsp;<?php echo ($v2['name']); ?></li><?php endif; endforeach; endif; ?>
                                                    </ul><?php endforeach; endif; ?>                                         
                                         </div>                                     
                                </div>                                                             
                        </div>
                        <div class="box-footer">                        	
                            <input type="hidden" name="id" value="<?php echo ($goods_category_info["id"]); ?>">                           
                        	<button type="reset" class="btn btn-primary pull-left"><i class="icon-ok"></i>重填  </button>                       	                 
                            <button type="button" onclick="ajax_submit_form('category_form','<?php echo U('Goods/addEditCategory?is_ajax=1');?>');" class="btn btn-primary pull-right"><i class="icon-ok"></i>提交  </button>
                        </div> 
                        </form>
                    </div>
                </div>
            </div>
        </section>
</div>
<script>  
    
/** 以下是编辑时默认选中某个商品分类*/
$(document).ready(function(){
	<?php if($level_cat['2'] > 0): ?>// 如果当前是二级分类就让一级父id默认选中
		 $("#parent_id_1").val('<?php echo ($level_cat[1]); ?>'); 
		 get_category('<?php echo ($level_cat[1]); ?>','parent_id_2','0');<?php endif; ?>	 
	<?php if($level_cat['3'] > 0): ?>// 如果当前是三级分类就一级和二级父id默认 都选中
		 $("#parent_id_1").val('<?php echo ($level_cat[1]); ?>');		 	
		 get_category('<?php echo ($level_cat[1]); ?>','parent_id_2','<?php echo ($level_cat[2]); ?>');<?php endif; ?>	
});
 
// 将品牌滚动条里面的 对应分类移动到 最上面
//javascript:document.getElementById('category_id_3').scrollIntoView();
var typeScroll = 0;
function spec_scroll(o){
	var id = $(o).val();	
	if(!$('#type_id_'+id).is('h5')){
		return false;
	} 	 
	$('#ajax_brandList').scrollTop(-typeScroll);
	var sp_top = $('#type_id_'+id).offset().top; // 标题自身往上的 top
	var div_top = $('#ajax_brandList').offset().top; // div 自身往上的top
	$('#ajax_brandList').scrollTop(sp_top-div_top); // div 移动
	typeScroll = sp_top-div_top;
} 
</script>
   
</body>
</html>