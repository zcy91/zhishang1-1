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
    <!-- Content Header (Page header) -->
   <div class="breadcrumbs" id="breadcrumbs">
	<ol class="breadcrumb">
	<?php if(is_array($navigate_admin)): foreach($navigate_admin as $k=>$v): if($k == '后台首页'): ?><li><a href="<?php echo ($v); ?>"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo ($k); ?></a></li>
	    <?php else: ?>    
	        <li><a href="<?php echo ($v); ?>"><?php echo ($k); ?></a></li><?php endif; endforeach; endif; ?>          
	</ol>
</div>

    <section class="content">
    <!-- Main content -->
    <!--<div class="container-fluid">-->
    <div class="row">
      <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-list"></i> 用户信息</h3>
            </div>
            <div class="panel-body">
                <form action="" method="post" onsubmit="return checkUserUpdate(this);">
                    <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td class="col-sm-2">会员昵称:</td>
                        <td ><input type="text" class="form-control" name="nickname" value="<?php echo ($user["nickname"]); ?>"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="col-sm-2">真实姓名:</td>
                        <td ><input type="text" class="form-control" name="name" value="<?php echo ($user["name"]); ?>"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="col-sm-2">身份证号码:</td>
                        <td ><input type="text" class="form-control" name="sfz" value="<?php echo ($user["sfz"]); ?>"></td>
                        <td></td>
                    </tr>
                    
                    <tr>
                        <td>用户帐户:</td>
                        <td>
                        <span style="margin-right:15px; border:1px solid #ccc; font-size:12px; background:#eee; padding:5px 15px; border-radius:5px">余额：<?php echo ($user["user_money"]); ?></span>
                        <span style="margin-right:15px; border:1px solid #ccc; font-size:12px; background:#eee; padding:5px 15px; border-radius:5px"><?php echo tpCache('distribut.hot_jifeng_name');?>：<?php echo ($user["pay_points"]); ?></span>
                        <span style="margin-right:15px; border:1px solid #ccc; font-size:12px; background:#eee; padding:5px 15px; border-radius:5px"><?php echo tpCache('distribut.cold_jifeng_name');?>：<?php echo ($user["cold_points"]); ?></span>
                        <span style="margin-right:15px; border:1px solid #ccc; font-size:12px; background:#eee; padding:5px 15px; border-radius:5px">待激活：<?php echo ($user["dai_points"]); ?></span>
                        <span style="margin-right:15px; border:1px solid #ccc; font-size:12px; background:#eee; padding:5px 15px; border-radius:5px">冻结余额：<?php echo ($user["frozen_money"]); ?></span>
                        <span style="margin-right:15px; border:1px solid #ccc; font-size:12px; background:#eee; padding:5px 15px; border-radius:5px">总分佣：<?php echo ($user["distribut_money"]); ?></span>
                        <span style="margin-right:15px; border:1px solid #ccc; font-size:12px; background:#eee; padding:5px 15px; border-radius:5px"><?php echo tpCache('distribut.equity_name');?>：<?php echo ($user["equity"]); ?></span>
                        
                        </td>
                        
                        <td></td>
                    </tr>

                    <tr>
                        <td>邮件地址:</td>
                        <td><input type="text" class="form-control" name="email" value="<?php echo ($user["email"]); ?>"></td>
                        <td>电子邮箱</td>
                    </tr>
                    <tr>
                        <td>新密码:</td>
                        <td><input type="password" class="form-control" name="password"></td>
                        <td>留空表示不修改密码</td>
                    </tr>
                    <tr>
                        <td>确认密码:</td>
                        <td><input type="password" class="form-control" name="password2" ></td>
                        <td>留空表示不修改密码</td>
                    </tr>
                    <tr>
                        <td>会员等级:</td>
                        <td><?php echo ($user["user_rank"]); ?>
				              	<select name="level" class="form-control" style="width:200px;">
                                <?php if(is_array($user_class)): $i = 0; $__LIST__ = $user_class;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><option value="<?php echo ($list["level_id"]); ?>" <?php if($list["level_id"] == $user['level']): ?>selected<?php endif; ?>><?php echo ($list["level_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>    
				              	</select>
                        </td>
                    </tr>
                    <tr>
                        <td>性别:</td>
                        <td id="order-status">
                            <input name="sex" type="radio" value="0" <?php if($user['sex'] == 0): ?>checked<?php endif; ?> >保密
                            <input name="sex" type="radio" value="1" <?php if($user['sex'] == 1): ?>checked<?php endif; ?> >男
                            <input name="sex" type="radio" value="2" <?php if($user['sex'] == 2): ?>checked<?php endif; ?> >女
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>QQ:</td>
                        <td>
                            <input class="form-control" type="text" name="qq" value="<?php echo ($user["qq"]); ?>">
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>手机:</td>
                        <td>
                            <input type="text" class="form-control" name="mobile" value="<?php echo ($user["mobile"]); ?>">
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>冻结用户:</td>
                        <td>
                            <input name="is_lock" type="radio" value="1" <?php if($user['is_lock'] == 1): ?>checked<?php endif; ?> >是
                            <input name="is_lock" type="radio" value="0" <?php if($user['is_lock'] == 0): ?>checked<?php endif; ?> >否
                        </td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>注册时间:</td>
                        <td>
                            <?php echo (date('Y-m-d H:i',$user["reg_time"])); ?>
                        </td>
                        <td></td>
                    </tr>
                        
                    <tr>
                        <td>是否商家:</td>
                        <td id="order-status">                            
                            <input name="is_distribut" type="radio" value="1" <?php if($user['is_distribut'] == 1): ?>checked<?php endif; ?> >是
                            <input name="is_distribut" type="radio" value="0" <?php if($user['is_distribut'] == 0): ?>checked<?php endif; ?> >否
                        </td>
                        <td></td>
                    </tr>                    
                    <tr>
                        <table  class="table table-bordered">
                            
                            <tr>
                                    <td>用户余额:</td>
                                    <td><?php echo ($user["user_money"]); ?></td>                                
                                    <td>累积<?php echo tpCache('distribut.jifeng_name');?>金额:</td>
                                    <td><?php echo ($user["distribut_money"]); ?></td>    
                                </tr>                            
                            
                             <tr>
                                <td>上一级编号</td>
                                    <td>                            
                                        <?php if($user[first_leader] > 0): ?><a href="<?php echo U(detail,array('id'=>$user[first_leader]));?>"><?php echo ($user["first_leader"]); ?></a>
                                        <?php else: ?>
                                                <?php echo ($user["first_leader"]); endif; ?>                           
                                    </td>                                
                                    <td>一级下线数</td>
                                    <td><?php echo ($user["first_count"]); ?></td>    
                                </tr>
                                
                                <tr>
                                    <td>上二级编号</td>
                                    <td>                            
                                        <?php if($user[second_leader] > 0): ?><a href="<?php echo U(detail,array('id'=>$user[second_leader]));?>"><?php echo ($user["second_leader"]); ?></a>
                                        <?php else: ?>
                                                <?php echo ($user["second_leader"]); endif; ?>                           
                                    </td>
                                    <td>二级下线数</td>
                                    <td><?php echo ($user["second_count"]); ?></td>                                
                                </tr>
                  
                        </table>
                    </tr>  
                    
                    <tr>
                        <table  class="table table-bordered">
                            
                            <tr>
                              <td style="width:100px">债务债权:</td>
                              <td>
                              <?php $all_img=unserialize($user['all_img']);?>
                              <?php if(is_array($all_img)): $i = 0; $__LIST__ = $all_img;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><a href="<?php echo ($list); ?>" target="_blank" style="margin-right:25px; padding:5px; border-radius:5px; border:#CCC solid 1px; float:left; width:70px; height:70px" title="点击查看大图"><img width="60" height="60" src="<?php echo ($list); ?>" onerror="this.src='/Public/images/bg-upload.png'"></a><?php endforeach; endif; else: echo "" ;endif; ?>
                              </td>
                             </tr>                            

                  
                        </table>
                    </tr> 
                               
                    <tr>
                        <td></td>
                        <td>
                            <button type="submit" class="btn btn-info">
                                <i class="ace-icon fa fa-check bigger-110"></i> 保存
                            </button>
                            <a href="javascript:history.go(-1)" data-toggle="tooltip" title="" class="btn btn-default pull-right" data-original-title="返回"><i class="fa fa-reply"></i></a>
                        </td>
                    </tr>
                    </tbody>
                </table>
                </form>

            </div>
        </div>
 	  </div> 
    </div>    <!-- /.content -->
   </section>
</div>
<script>
    function checkUserUpdate(){
        var email = $('input[name="email"]').val();
        var mobile = $('input[name="mobile"]').val();
        var password = $('input[name="password"]').val();
        var password2 = $('input[name="password2"]').val();

        var error ='';
        if(password != password2){
            error += "两次密码不一样\n";
        }

        if(!checkEmail(email)){
            error += "邮箱地址有误\n";
        }
        if(!checkMobile(mobile)){
            error += "手机号码填写有误\n";
        }
        if(error){
            layer.alert(error, {icon: 2});  //alert(error);
            return false;
        }
        return true;

    }
</script>

</body>
</html>