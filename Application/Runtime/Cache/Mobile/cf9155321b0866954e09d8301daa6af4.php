<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<meta name="format-detection" content="telephone=no" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-touch-fullscreen" content="yes" />
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="applicable-device" content="mobile">
<title><?php echo ($tpshop_config['shop_info_store_title']); ?></title>
<meta http-equiv="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>" />
<meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>" />
<link rel="stylesheet" href="/Template/mobile/new/Static/css/public.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/user.css">
<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
<script src="/Public/js/global.js"></script>
<script src="/Public/js/mobile_common.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/modernizr.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/layer.js" ></script>
</head>
<body>
<header>
<div class="tab_nav">
  <div class="header">
    <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
    <div class="h-mid"><?php echo tpCache('distribut.jifeng_name');?>转赠</div>
    <div class="h-right">
      <aside class="top_bar">
        <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
      </aside>
    </div>
  </div>
</div>
</header>
<script type="text/javascript" src="/Template/mobile/new/Static/js/mobile.js" ></script>
<div class="goods_nav hid" id="menu">
      <div class="Triangle">
        <h2></h2>
      </div>
      <ul>
      <?php
 $md5_key = md5("SELECT * FROM `__PREFIX__wapnavigation` where is_show = 1 and lei=0 ORDER BY `sort` asc"); $result_name = $sql_result_v = S("sql_".$md5_key); if(empty($sql_result_v)) { $Model = new \Think\Model(); $result_name = $sql_result_v = $Model->query("SELECT * FROM `__PREFIX__wapnavigation` where is_show = 1 and lei=0 ORDER BY `sort` asc"); S("sql_".$md5_key,$sql_result_v,1); } foreach($sql_result_v as $k=>$v): ?><li>
				<a href="<?php echo ($v[url]); ?>"  <?php if($v["is_new"] == 1): ?>target="_blank"<?php endif; ?>><span class="menu1" style="background:url(<?php echo ($v[img]); ?>) no-repeat 50% 80%; background-size:auto 15px; margin-right:5px"></span><i><?php echo ($v[name]); ?></i></a>
			</li><?php endforeach; ?> 
   </ul>
 </div> 
<div id="tbh5v0">
    <div class="Personal">
        <div id="tbh5v0">
            <div class="innercontent1">
                <form method="post" id="edit_profile" onSubmit="return checkinfo()">
                    <div class="name"><span>当前帐号</span>
                        <input type="text"  value="<?php echo ($user["mobile"]); ?>" placeholder="*帐号" class="c-f-text" disabled >
                    </div>
                    <div class="name">
                       <span>拥有<?php echo tpCache('distribut.jifeng_name');?></span>
                            <input  value="<?php echo ($user["pay_points"]); ?>"  placeholder="*帐户拥有<?php echo tpCache('distribut.hot_jifeng_name');?>" class="c-f-text" disabled style="width:15%; margin-right:15px"/>
                            <i style="color:#f00">(注：一旦操将不可撤销)</i>
                    </div>
                    <div class="name" style="color:#f00">
                       <span>接受帐号</span>
                            <input name="user"   placeholder="*&nbsp;对方手机号码" class="c-f-text"  style=" width:70%;border:#CCC solid 1px; font-size:14px; padding:5px 0px; text-indent:5px" onKeyUp="value=this.value.replace(/\D+/g,'')" required autocomplete="off"/>
                    </div>
                    <div class="name">
                       <span>赠送<?php echo tpCache('distribut.jifeng_name');?></span>
                            <input name="pay_points"   placeholder="*&nbsp;转赠<?php echo tpCache('distribut.hot_jifeng_name');?>数量" class="c-f-text"  style=" width:70%;border:#CCC solid 1px; font-size:14px; padding:5px 0px; text-indent:5px" onKeyUp="value=this.value.replace(/\D+/g,'')" required autocomplete="off"/>
                    </div>
                    
                    
                    <div class="field submit-btn">
                    <?php if($user['pay_points'] > 0 ): ?><input type="submit" value="确认转赠" class="btn_big1"  style="background:#36F"/>
                    <?php else: ?>
                         <input type="submit" value="<?php echo tpCache('distribut.hot_jifeng_name');?>余额不足" class="btn_big1" style="background:#ccc;" disabled/><?php endif; ?>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
function checkinfo(){
	$(".btn_big1").attr('disabled',true);
	var pay_points=$(" input[ name='pay_points' ] ").val();
	var user=$(" input[ name='user' ] ").val();
	if (<?php echo tpCache('distribut.sys_jifeng_zs');?>!=1){
		layer.open({content:'平台已关闭<?php echo tpCache('distribut.hot_jifeng_name');?>转赠功能',time:2});	
		$(" input[ name='pay_points' ] ").focus();
		$(".btn_big1").attr('disabled',false);
		return false;
	}
	
	if (user==''){
		layer.open({content:'请输入你要转赠的帐号',time:2});	
		$(" input[ name='pay_points' ] ").focus();
		$(".btn_big1").attr('disabled',false);
		return false;
	}
	
	if (pay_points=='' || pay_points<=0){
		layer.open({content:'请输入你要转赠的<?php echo tpCache('distribut.hot_jifeng_name');?>',time:2});	
		$(" input[ name='pay_points' ] ").focus();
		$(".btn_big1").attr('disabled',false);
		return false;
	}

	if (pay_points><?php echo ($user["pay_points"]); ?>){
		layer.open({content:'您最多可赠送<?php echo tpCache('distribut.hot_jifeng_name'); echo ($user["pay_points"]); ?>',time:2});	
		$(" input[ name='pay_points' ] ").focus();
		$(".btn_big1").attr('disabled',false);
		return false;
	}
$.post('/index.php?s=/Mobile/User/jifeng_zs.html', {pay_points: pay_points,user:user},
              function(res) {
			        //console.log(res);
                    if (res.code == 1) {
                        layer.open({content: res.msg, time: 2});
						location.reload();
                    } else {
                        layer.open({content: res.msg, time: 2});
						$(" input[ name='pay_points' ] ").focus();
						$(".btn_big1").attr('disabled',false);
                    }
               });
	

	return false;
}

</script></body>
</html>