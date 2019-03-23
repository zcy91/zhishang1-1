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
    <div class="h-mid">我的团队</div>
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
<ol>
<li class="on" data-id="1">一级下级</li>
<li data-id="2">二级下级</li>
</ol>
</div>

<div class="Personal">
   
<div class="innercontent1 show_hide show1">
 <table width="95%" border="1" cellspacing="0" cellpadding="5" style=" margin:0px auto" bgcolor="#eee" bordercolor="#CCCCCC">
   <tr>
     <td width="50" height="35" align="center">编号</td>
     <td>&nbsp;帐号</td>
     <td>&nbsp;等级</td>
     <td>&nbsp;其他</td>
   </tr>
<?php if(is_array($one)): $i = 0; $__LIST__ = $one;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one): $mod = ($i % 2 );++$i;?><tr style="background:#fff; font-size:12px">
     <td height="50" align="center" valign="middle"><img src="<?php echo ((isset($one['head_pic']) && ($one['head_pic'] !== ""))?($one['head_pic']):" /Template/mobile/new/Static/images/user68.jpg"); ?>" onerror="this.src='/Template/mobile/new/Static/images/user68.jpg'" style="width:45px; height:45px"></td>
     <td>&nbsp;<?php echo ($one["mobile"]); ?></td>
     <td>&nbsp;<i style="color:#00f;"><?php echo ($one["level_name"]); ?></i></td>
     <td>&nbsp;<?php if($one["is_distribut"] == 1): ?><i style="color:#f00;">入驻商家</i><?php endif; ?></td>
   </tr><?php endforeach; endif; else: echo "" ;endif; ?> 
 </table>
</div>

<div class="innercontent1 show_hide show2" style="display:none">
 <table width="95%" border="1" cellspacing="0" cellpadding="5" style=" margin:0px auto" bgcolor="#eee" bordercolor="#CCCCCC">
   <tr>
     <td width="50" height="35" align="center">编号</td>
     <td>&nbsp;帐号</td>
     <td>&nbsp;等级</td>
     <td>&nbsp;其他</td>
   </tr>
<?php if(is_array($two)): $i = 0; $__LIST__ = $two;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$one): $mod = ($i % 2 );++$i;?><tr style="background:#fff; font-size:12px">
     <td height="50" align="center" valign="middle"><img src="<?php echo ((isset($one['head_pic']) && ($one['head_pic'] !== ""))?($one['head_pic']):" /Template/mobile/new/Static/images/user68.jpg"); ?>" onerror="this.src='/Template/mobile/new/Static/images/user68.jpg'" style="width:45px; height:45px"></td>
     <td>&nbsp;<?php echo ($one["mobile"]); ?></td>
     <td>&nbsp;<i style="color:#00f;"><?php echo ($one["level_name"]); ?></i></td>
     <td>&nbsp;<?php if($one["is_distribut"] == 1): ?><i style="color:#f00;">入驻商家</i><?php endif; ?></td>
   </tr><?php endforeach; endif; else: echo "" ;endif; ?> 
 </table>
</div>

</div> 
</div>

<a href="javascript:goTop();" class="gotop"><img src="/Template/mobile/new/Static/images/topup.png"></a> 
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