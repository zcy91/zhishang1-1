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
<style type="text/css">
.Classification{ width:95%; margin:auto; overflow:hidden; padding-bottom:10px; border-bottom:1px solid #eeeeee;margin-bottom:10px; }
.Classification dt{ width:100%; height:40px;}
.Classification dt em{ display:block; float:left; font-size:16px; line-height:40px; color:#333}
.Classification dt span{ display:block; float:right; font-size:12px; line-height:40px; color:#999; padding-right:5px;}
.Classification dd{ width:100%; overflow:hidden; border-top:1px solid #eeeeee; padding-top:10px;}
.Classification dd span{ display:block; float:left; width:50%; height:35px; margin-bottom:5px;}
.Classification dd span a{ display:block; width:95%; height:35px; margin:auto; background:#f5f5f5; font-size:14px; line-height:35px; text-align:center; color:#666}
</style>
</head>
<body>
<header>
    <div class="tab_nav">
      <div class="header">
        <div class="h-left"><a href="javascript:history.back(-1)" title="返回" class="back search_back"></a></div>
        <div class="h-mid">全部分类  </div>
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
<?php if(is_array($main_cat)): foreach($main_cat as $key=>$vo): ?><dl class="Classification">
	<dt><a href="<?php echo U('Store/goods_list',array('store_id'=>$store[store_id],'cat_id'=>$vo[cat_id]));?>"><em style=" font-style:normal"><?php echo ($vo["cat_name"]); ?></em><span>查看全部</span></a></dt>
	<?php if($sub_cat[$vo[cat_id]] != ''): ?><dd>
		<?php if(is_array($sub_cat[$vo[cat_id]])): foreach($sub_cat[$vo[cat_id]] as $key=>$v2): ?><span>
			<a href="<?php echo U('Store/goods_list',array('store_id'=>$store[store_id],'cat_id'=>$v2[cat_id]));?>"><?php echo ($v2["cat_name"]); ?></a>
		</span><?php endforeach; endif; ?>
	 </dd><?php endif; ?>  
</dl><?php endforeach; endif; ?> 
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