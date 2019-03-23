<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta charset="UTF-8">
<meta name="Keywords" content="<?php echo ($store["seo_keywords"]); ?>" />
<meta name="Description" content="<?php echo ($store["seo_description"]); ?>" />
<meta name="viewport" content="width=device-width">
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<title><?php echo ($store["store_name"]); ?></title>
<link rel="shortcut icon" href="favicon.ico" />
<link rel="icon" href="animated_favicon.gif" type="image/gif" />
<link rel="alternate" type="application/rss+xml" title="RSS|  " href="" />
<link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/dianpu.css">
<link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/public.css"/>
<script src="/Public/js/global.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/layer.js" ></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
<script src="http://cdn.bootcss.com/jquery/1.12.3/jquery.min.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/layer/layer/layer.js" ></script>
</head>
<body style=" background:#F5F5F5">
<header>
      <div class="tab_nav">
        <div class="header">
          <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
          <div class="h-mid">
         	店铺简介
          </div>
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
<div class="about_top">
	<dl>
		<dt><img src="<?php echo ((isset($store["store_logo"]) && ($store["store_logo"] !== ""))?($store["store_logo"]):'/Template/mobile/new/Static/images/v-shop/logo.png'); ?>"></dt>
		<dd><span><?php echo ($store["store_name"]); ?></span>
		<em>初级店铺</em>
		<em>商品数量：<?php echo ($total_goods); ?></em>
		</dd>
		<p>
        <?php if($scdp == 1): ?><a  data-id="<?php echo ($store['store_id']); ?>"  href="javascript:;" style="background:#090">已收藏</a>
        <?php else: ?>
         <a id="favoriteStore" data-id="<?php echo ($store['store_id']); ?>"  href="javascript:;">收藏</a><?php endif; ?>
        </p>
	</dl>
</div>
<div class="about_main">
	<dl>
	<dt>好评率：</dt>
	<dd class="hei">100%</dd>
	</dl>
	<dl>
	<dt>所在地：</dt>
	<dd class="hei"><?php echo ($store["store_address"]); ?></dd>
	</dl>
	<dl>
	<dt>开店时间：</dt>
	<dd class="hei"><?php echo (date('Y-m-d',$store["store_time"])); ?></dd>
	</dl>
	<dl>
	<dt>详细地址：</dt>
	<dd class="hei"><?php echo ($store["store_address"]); ?></dd>
	</dl>
</div>
<div class="about_main">
	<dl>
	<dt>描述相符：</dt>
	<dd class="red"><?php echo ($store["store_desccredit"]); ?></dd>
	</dl>
	<dl>
	<dt>服务态度：</dt>
	<dd class="red"><?php echo ($store["store_servicecredit"]); ?></dd>
	</dl>
	<dl>
	<dt>物流服务：</dt>
	<dd class="red"><?php echo ($store["store_deliverycredit"]); ?></dd>
	</dl>
</div>
<div class="about_main">
	<h3>二维码</h3>
	<span>
	<img  src="<?php echo U('Home/Index/store_qrcode',array('store_id'=>$store[store_id],'t_id'=>$store[user_id]));?>">
		扫描二维码  关注有惊喜
	</span>
</div>
<a href="tel:<?php echo ($store["store_phone"]); ?>" class="link" style=" color:#FFF;font-size:18px; ">联系卖家</a>
<div style=" height:40px;"></div>
<div class="bottm_nav">
	 <ul>
	 	<li class="bian"><a href="<?php echo U('Store/index',array('store_id'=>$store[store_id]));?>">店铺首页</a></li>
	 	<li class="bian"><a href="<?php echo U('Store/store_goods_class',array('store_id'=>$store[store_id]));?>">店铺分类</a></li>
	 	<li class="bian"><a href="<?php echo U('Store/about',array('store_id'=>$store[store_id]));?>">店铺简介</a></li>
	 	<li><a href="<?php echo U('Store/fastbuy',array('store_id'=>$store[store_id]));?>">快捷支付</a></li>
	 </ul>
</div>
<script>
//收藏店铺
$('#favoriteStore').click(function () {
  if (getCookie('user_id') == '') {
	  if(confirm('请先登录')){
       layer.confirm('您还没有登陆', {btn: ['去登陆','再看看'],title:"提示"}, 
          function(){layer.msg('正在为你跳转',{time:1000,},function(){window.location.href = "<?php echo U('Mobile/User/login');?>";});},
          function(){layer.msg('登陆后：才可以收藏店铺',{time:2000, });});
	  }                     	
  } else {
    $.ajax({
      type: 'post',
      dataType: 'json',
      data: {store_id: $(this).attr('data-id')},
      url: "<?php echo U('Home/Store/collect_store');?>",
      success: function (res) {
        if (res.status == 1) {
		  layer.msg('成功添加至收藏夹',{time:1000,},function(){ window.location.reload()});
        } else {
		  layer.msg(res.msg,{time:2000});
        }
      }
    });
  }
});
</script>

</body>
</html>