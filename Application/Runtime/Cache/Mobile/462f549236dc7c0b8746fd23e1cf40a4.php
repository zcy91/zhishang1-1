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
          <form id="searchForm" name="searchForm" method="get" action="<?php echo U('Store/goods_list');?>">
	 	  <input type='hidden' name='store_id' value='<?php echo ($store["store_id"]); ?>'>
          <input type="text" name="keywords" id="keyword" class="dianp_search" placeholder="搜索本店商品">
          <input type="submit" class="icon_search" id="btsearch" value="" />
        </form>
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
<div class="dianpu_main">
	<dl>
    <p>
        <?php if($scdp == 1): ?><a style="color:#fff">已收藏</a>
        <?php else: ?>
         <a id="favoriteStore" data-id="<?php echo ($store['store_id']); ?>"  href="javascript:;" style="color:#fff">收藏</a><?php endif; ?>
    </p>
	<dt><img src="<?php echo ((isset($store['store_logo']) && ($store['store_logo'] !== ""))?($store['store_logo']):'/Template/mobile/new/Static/images/v-shop/logo.png'); ?>" alt="<?php echo ($store["store_name"]); ?>"></dt>
	<dd><span><?php echo ($store["store_name"]); ?></span>
	</dd>
	</dl>
	<ul>
	<li class="bian"><a href="<?php echo U('Store/goods_list',array('store_id'=>$store[store_id]));?>"><span>全部宝贝</span><strong><?php echo ($total_goods); ?></strong></a></li>
	<li class="bian"><a href="#"><span>商家描述</span><strong><?php echo ($store["store_desccredit"]); ?></strong></a></li>
	<li class="bian"><span>服务态度</span><strong><?php echo ($store["store_servicecredit"]); ?></strong></li>
	<li><span>物流速度</span><strong><?php echo ($store["store_deliverycredit"]); ?></strong></li>
	</ul>
</div>
<div id="scrollimg" class="scrollimg">
	<div class="bd">
		<ul>
		<?php if(is_array($store["mb_slide"])): foreach($store["mb_slide"] as $key=>$vimg): if(!empty($vimg)): ?><!--   <li><a href="<?php echo ($store[mb_slide_url][$key]); ?>"><img src="<?php echo ($vimg); ?>" width="100%" /></a>-->
		  </li><li><img src="<?php echo ($vimg); ?>" width="100%" /></li><?php endif; endforeach; endif; ?>
     	</ul>
	</div>
	<div class="hd">
		<ul></ul>
	</div>
</div>
<script type="text/javascript">
	TouchSlide({ 
		slideCell:"#scrollimg",
		titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
		mainCell:".bd ul", 
		effect:"leftLoop", 
		autoPage:true,//自动分页
		autoPlay:true //自动播放
	});
</script>  
   <div class="product_value">
  		<h2>店长推荐</h2>
  		<ul>
    	      <?php if(is_array($recomend_goods)): foreach($recomend_goods as $key=>$vo): ?><li> 
	        <a href="<?php echo U('Goods/goodsInfo',array('id'=>$vo[goods_id]));?>"> <span> 
				<img src="<?php echo (goods_thum_images($vo["goods_id"],200,200)); ?>" srcset="<?php echo (goods_thum_images($vo["goods_id"],200,200)); ?>" srcd="<?php echo (goods_thum_images($vo["goods_id"],200,200)); ?>" loaded="no"> </span>
	        <span class="p_info"><?php echo (getSubstr($vo["goods_name"],0,16)); ?></span> 
	        <span class="price"> ￥<?php echo ($vo["shop_price"]); ?>元  </span> </a>
	        </li><?php endforeach; endif; ?>
    	</ul>
  </div>

    <div class="product_value">
		<h2>热卖产品</h2>
	      <ul>
	      <?php if(is_array($hot_goods)): foreach($hot_goods as $key=>$vo): ?><li> 
	        <a href="<?php echo U('Goods/goodsInfo',array('id'=>$vo[goods_id]));?>"> <span> 
	        <img src="<?php echo (goods_thum_images($vo["goods_id"],200,200)); ?>" srcset="<?php echo (goods_thum_images($vo["goods_id"],200,200)); ?>" srcd="<?php echo (goods_thum_images($vo["goods_id"],200,200)); ?>" loaded="no"> </span> 
	        <span class="p_info"><?php echo (getSubstr($vo["goods_name"],0,16)); ?></span> 
	        <span class="price"> ￥<?php echo ($vo["shop_price"]); ?>元  </span> </a> 
	        </li><?php endforeach; endif; ?>
		  </ul>
     </div>
    <div class="product_value">
      <h2>新品上市</h2>
      <ul>
	      <?php if(is_array($new_goods)): foreach($new_goods as $key=>$vo): ?><li> 
	        <a href="<?php echo U('Goods/goodsInfo',array('id'=>$vo[goods_id]));?>"> <span> 
	        <img src="<?php echo (goods_thum_images($vo["goods_id"],200,200)); ?>" srcset="<?php echo (goods_thum_images($vo["goods_id"],200,200)); ?>" srcd="<?php echo (goods_thum_images($vo["goods_id"],200,200)); ?>" loaded="no"> </span> 
	        <span class="p_info"><?php echo (getSubstr($vo["goods_name"],0,16)); ?></span> 
	        <span class="price"> ￥<?php echo ($vo["shop_price"]); ?>元  </span> </a> 
	        </li><?php endforeach; endif; ?>
      </ul>
    </div>
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
<script>
function goTop(){
  $('html,body').animate({'scrollTop':0},600);
}
</script>
<a href="javascript:goTop();" class="gotop"><img src="/Template/mobile/new/Static/images/topup.png"></a>
<script>
	window.onload=function () {
	    var img_miss_src = "/Template/mobile/new/Static";
		$(".product_value img").each(function (i,e) {
		    var _this = $(e);
			if(!_this.attr("src")){
                _this.attr("src",img_miss_src+"/images/img-miss.png");
			}
        });
    }
</script>
</body>
</html>