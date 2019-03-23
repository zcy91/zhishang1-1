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
    <div class="h-mid">激活<?php echo tpCache('distribut.cold_jifeng_name');?></div>
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
                <form method="post" id="edit_profile" >
                    <div class="name"><span>当前帐号:</span>
                        <?php echo ($user["mobile"]); ?>
                    </div>
                    <div class="name"><span>当前余额:</span>
                        <?php echo ($user["user_money"]); ?>
                    </div>
                    <div class="name">
                       <span>拥有<?php echo tpCache('distribut.cold_jifeng_name');?>:</span>
                            <?php echo ($user["cold_points"]); ?>
                    </div>
                    <div class="name" style="color:#060">
                       释放可交易额度:
                           <?php echo ($user["dai_points"]); ?>&nbsp;<i style="color:#f00">(当前拥有)</i>
                    </div>

                   <div class="name dataid id2" style="color:#999; text-align:center; font-size:13px">
                       <?php echo tpCache('distribut.cold_jifeng_name');?>可交易额度增加：<i style="color:#f00"><?php echo tpCache('distribut.point_yue_jifeng')*tpCache('distribut.point_shifang');?></i>赠送<?php echo tpCache('distribut.equity_name');?>：<i style="color:#f00"><?php echo tpCache('distribut.point_shifang_gq');?></i>股
                   </div>
                    <div class="name">
                       激活交易额度费:<?php echo tpCache('distribut.point_yue_jifeng');?>元&nbsp;<i style="color:#f00">(注：本次交易将要扣除余额)</i>
                    </div>
                    <div class="field submit-btn">
                    <?php if($user['user_money'] >= tpCache('distribut.point_yue_jifeng') AND $user['dai_points'] >= tpCache('distribut.point_yue_jifeng')*tpCache('distribut.point_shifang')): ?><input type="submit" value="确认激活" class="btn_big1"  style="background: #060"/>
                    <?php else: ?>
                         <input type="submit" value="帐户余额或待释放<?php echo tpCache('distribut.jifeng_name');?>额度不足" class="btn_big1" style="background:#999;" disabled/><?php endif; ?>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script type="text/javascript" src="/Template/mobile/new/Static/js/layer/layer/layer.js" ></script>

<script>

$('.btn_big1').click(function () {
    layer.confirm('一旦交易成功将不可撤销', {btn: ['立即激活','再想想'],title:"<?php echo tpCache('distribut.jifeng_name');?>激活"}, 
      function(){checkinfo()},
      function(){layer.msg('已为您取消<?php echo tpCache('distribut.jifeng_name');?>激活');});
	  return false;
})




function checkinfo(){
	$(".btn_big1").attr('disabled',true);
	if (<?php echo tpCache('distribut.point_yue_jifeng');?>==0){
		layer.msg('平台已关闭激活<?php echo tpCache('distribut.cold_jifeng_name');?>功能');	
		return false;
	}
	
	if (<?php echo ($user["dai_points"]); ?><=0){
		layer.msg('可用待释放<?php echo tpCache('distribut.cold_jifeng_name');?>额度不足');	
		return false;
	}
	
	if (<?php echo ($user["user_money"]); ?><<?php echo tpCache('distribut.point_yue_jifeng');?>){
		layer.msg('您的现金帐户余额不足');
		return false;
	}
	

$.post('', {ac:1},
              function(res) {
			        //console.log(res);
                    if (res.code == 1) {
                        layer.msg(res.msg);	
						location.reload();
                    } else {
                        layer.msg(res.msg);	
                    }
					$(".btn_big1").attr('disabled',false);
               });
	

	return false;
}

</script></body>
</html>