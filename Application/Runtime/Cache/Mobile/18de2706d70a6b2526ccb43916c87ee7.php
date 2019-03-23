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
    <div class="h-mid">我的海报</div>
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
<div class="user_tuiguang">
<ol style="display:none">
<li class="on" data-id="1">推荐会员</li>
<li data-id="2">推荐商家</li>
</ol>
   <ul class="show_hide show1">
      <li>
      <img src="/Public/haibao/<?php echo ($user["user_id"]); ?>.png" >
    <!--  onerror="this.src='<?php echo U('Mobile/Index/user_qrcode',array('t_id'=>$user[user_id]));?>'" <img src="http://www.liantu.com/api.php?text=http://<?php echo $_SERVER ['HTTP_HOST']; ?>/Mobile/User/reg/t_id/<?php echo ($user["user_id"]); ?>.html&bg=ffffff&fg=000000"/>--></li>
      <li>（您可以长按图片保存到手机&nbsp;<a href="<?php echo U('user/tuiguang',array('tuiguang'=>1));?>" style="color:#f00">重新生成</a>)</li>
      <li style="display:none"><input type="text" value="http://<?php echo $_SERVER ['HTTP_HOST']; ?>/Mobile/User/reg/t_id/<?php echo ($user["user_id"]); ?>.html"></li>
   </ul>
   <ul class="show_hide show2"  style="display:none">
   <?php if($user["level"] == 3): ?><li><!--<img src="http://www.liantu.com/api.php?text=http://<?php echo $_SERVER ['HTTP_HOST']; ?>/Mobile/User/reg/t_id/<?php echo ($user["user_id"]); ?>/shang/jia.html&bg=ffffff&fg=000000"/>--></li>
      <li>（您可以使用上方二维或下方链接进行商家推广)</li>
      <li><input type="text" style="background:#f00" value="http://<?php echo $_SERVER ['HTTP_HOST']; ?>/Mobile/User/reg/t_id/<?php echo ($user["user_id"]); ?>/shang/jia.html"></li>
   <?php else: ?> 
      <li style=" color:#f00">（您没有权限推荐商家)</li><?php endif; ?>
   </ul>
</div>
</div>
<script>
        $('.user_tuiguang ol li').click(function () {
            $('.user_tuiguang ol li').removeClass("on");
            $(this).addClass("on");
			$('.show_hide').hide();
			$('.show'+$(this).data('id')).show();
			
        })
</script>
</body>
</html>