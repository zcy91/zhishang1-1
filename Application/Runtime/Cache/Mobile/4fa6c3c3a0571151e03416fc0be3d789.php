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
      <div class="h-mid">我的收藏</div>
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
 
<div class="sc_nav">
    <ul>
      <li><a href="<?php echo U('User/collect_list',array('type'=>1));?>" class="tab_head <?php if($type == 1): ?>on<?php endif; ?>" id="goods_ka1" >收藏的宝贝</a></li>
      <li><a href="<?php echo U('User/collect_list',array('type'=>2));?>" class="tab_head <?php if($type == 2): ?>on<?php endif; ?>" id="goods_ka2" >收藏的店铺</a></li>
     </ul>
 </div>
<?php if($type == 1): ?><div class="main" id="user_goods_ka_1" >
<?php if(empty($goods_list)): ?><div id="list_0_0" class="font12">您没有任何收藏哦！</div>
<?php else: ?>
<form name="theForm" method="post" action="">
<div id="store_list">
 <div class="shouchang">
 <ul>
  <?php if(is_array($goods_list)): foreach($goods_list as $key=>$goods): ?><li>
              <div class="imgurl">
              	<a href="<?php echo U('Goods/goodsInfo',array('id'=>$goods[goods_id]));?>" >
              	<img src="<?php echo (goods_thum_images($goods["goods_id"],200,200)); ?>" width="100" height="100"></a>
              </div>
              <a href="<?php echo U('Goods/goodsInfo',array('id'=>$goods[goods_id]));?>">
              <div class="order_info">
                <dl>
                  <dt><?php echo (getSubstr($goods["goods_name"],0,14)); ?></dt>
                  <dd><strong><?php echo ($goods["shop_price"]); ?></strong></dd>
                </dl>
              </div>
              </a>
              <div class="dingdancaozuo" >
              <a href="javascript:AjaxAddCart(<?php echo ($goods["goods_id"]); ?>,1)" class="s_flow" style=" color:#fff">加入购物车</a>
              <a href="<?php echo U('User/cancel_collect',array('collect_id'=>$goods[collect_id]));?>" class="s_out" style=" color:#fff" >删除</a></div>
        </li><?php endforeach; endif; ?>
 </ul>
 </div>
</form>
<?php if(!empty($goods_list)): ?><div id="getmore" style="font-size:.24rem;text-align: center;color:#888;padding:.25rem .24rem .4rem; clear:both">
  		<a href="javascript:void(0)" onClick="ajax_sourch_submit()">点击加载更多</a>
  </div><?php endif; endif; ?>
</div>
<?php else: ?>
<div class="main" id="user_goods_ka_2">
<?php if(empty($store_list)): ?><div id="list_0_0" class="font12">您没有收藏任何店铺哦！</div>
<?php else: ?>
    <link rel="stylesheet" href="/Template/mobile/new/Static/css/stores.css">
<form name="theForm" method="post" action="">
<?php if(is_array($store_list)): $i = 0; $__LIST__ = $store_list;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$store): $mod = ($i % 2 );++$i;?><section class="rzs_info">
		<dl>
			<dt><a href="<?php echo U('Store/index',array('store_id'=>$store[store_id]));?>" class="flow-datu" title="<?php echo ($store['store_name']); ?>"
				   style="background-image:url(<?php if($store['store_logo'] == ''): ?>/Template/mobile/new/Static/images/dianpu2.png<?php else: echo ($store['store_logo']); endif; ?>)"> </a></dt>
			<dd>
            <strong>
              <span class="guanzhu" style=" display:block;background:#E31939;padding:0px 5px;color:#fff;border-radius:3px;font-size: 12px;cursor: pointer; float:right; height:25px; line-height:25px; margin:0px; text-indent:0px;" onClick="location='<?php echo U('user/del_store_collect',array('log_id'=>$store['log_id']));?>'">取消收藏</span>

              <a href="<?php echo U('Store/index',array('store_id'=>$store[store_id]));?>"> 店铺：<?php echo ($store['store_name']); ?></a>
            </strong>

				<p>所在地：<?php echo ($store['province_name']); ?>,<?php echo ($store['city_name']); ?>,<?php echo ($store['district_name']); ?></p>
			</dd>
		</dl>
		<ul>
			<li><span>宝贝描述</span><strong>:<?php if($store['store_desccredit'] == 0): ?>5.0<?php else: echo (number_format($store['store_desccredit'],1)); endif; ?></span></strong>
				<em><?php $_RANGE_VAR_=explode(',',"0,1.99");if($store["store_desccredit"]>= $_RANGE_VAR_[0] && $store["store_desccredit"]<= $_RANGE_VAR_[1]):?>低<?php endif; ?>
					<?php $_RANGE_VAR_=explode(',',"2,3.99");if($store["store_desccredit"]>= $_RANGE_VAR_[0] && $store["store_desccredit"]<= $_RANGE_VAR_[1]):?>中<?php endif; ?>
					<?php $_RANGE_VAR_=explode(',',"4,5");if($store["store_desccredit"]>= $_RANGE_VAR_[0] && $store["store_desccredit"]<= $_RANGE_VAR_[1]):?>高<?php endif; ?>
				</em>
			</li>
			<li><span>卖家服务</span><strong>:<?php if($store['store_servicecredit'] == 0): ?>5.0<?php else: echo (number_format($store['store_servicecredit'],1)); endif; ?></strong>
				<em><?php $_RANGE_VAR_=explode(',',"0,1.99");if($store["store_desccredit"]>= $_RANGE_VAR_[0] && $store["store_desccredit"]<= $_RANGE_VAR_[1]):?>低<?php endif; ?>
					<?php $_RANGE_VAR_=explode(',',"2,3.99");if($store["store_desccredit"]>= $_RANGE_VAR_[0] && $store["store_desccredit"]<= $_RANGE_VAR_[1]):?>中<?php endif; ?>
					<?php $_RANGE_VAR_=explode(',',"4,5");if($store["store_desccredit"]>= $_RANGE_VAR_[0] && $store["store_desccredit"]<= $_RANGE_VAR_[1]):?>高<?php endif; ?></em>
			</li>
			<li><span>物流服务</span><strong>:<?php if($store['store_deliverycredit'] == 0): ?>5.0<?php else: echo (number_format($store['store_deliverycredit'],1)); endif; ?></strong>
				<em><?php $_RANGE_VAR_=explode(',',"0,1.99");if($store["store_desccredit"]>= $_RANGE_VAR_[0] && $store["store_desccredit"]<= $_RANGE_VAR_[1]):?>低<?php endif; ?>
					<?php $_RANGE_VAR_=explode(',',"2,3.99");if($store["store_desccredit"]>= $_RANGE_VAR_[0] && $store["store_desccredit"]<= $_RANGE_VAR_[1]):?>中<?php endif; ?>
					<?php $_RANGE_VAR_=explode(',',"4,5");if($store["store_desccredit"]>= $_RANGE_VAR_[0] && $store["store_desccredit"]<= $_RANGE_VAR_[1]):?>高<?php endif; ?></em>
			</li>
		</ul>
		<div class="index_taocan">
			<h2>共<?php echo ($store['goods_array']['goods_count']); ?>件宝贝</h2>
			<?php if(is_array($store['goods_array']['goods_list'])): $i = 0; $__LIST__ = $store['goods_array']['goods_list'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$goods['goods_id']));?>">
					<dl>
						<dt><img src="<?php echo (goods_thum_images($goods['goods_id'],137,137)); ?>" class="B_eee" onerror="this.src='/Public/images/bg-upload.png'"><em>￥<?php echo ($goods['shop_price']); ?></em>
						</dt>
						<dd><?php echo ($goods['goods_name']); ?></dd>
					</dl>
				</a><?php endforeach; endif; else: echo "$empty" ;endif; ?>
		</div>
		<div class="s_dianpu">
			<span><a href="tel:<?php echo ($store['store_phone']); ?>" style=" margin-left:7%"><em class="bg1"></em>联系客服</a></span>
			<span><a href="<?php echo U('Mobile/Store/index',array('store_id'=>$store['store_id']));?>" style=" margin-left:3%"><em class="bg2"></em>进入店铺</a></span>
		</div>
	</section><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
</form>
<?php if(!empty($store_list)): ?><div id="getmore" style="font-size:.24rem;text-align: center;color:#888;padding:.25rem .24rem .4rem; clear:both">
  		<a href="javascript:void(0)" onClick="ajax_sourch_submit()">点击加载更多</a>
  </div><?php endif; endif; ?>
</div><?php endif; ?>
</div>
<script>
var  page = 1;
 /*** ajax 提交表单 查询订单列表结果*/  
 function ajax_sourch_submit()
 {	 	 	 
        page += 1;
		$.ajax({
			type : "GET",
			url:"<?php echo U('Mobile/User/collect_list',null,'');?>/is_ajax/1/type/<?php echo ($type); ?>/p/"+page,//+tab,
			data : $('#filter_form').serialize(),// 你的formid 搜索表单 序列化提交
			success: function(data)
			{
				if($.trim(data) == '')
					$('#getmore').hide();
				else
				    $(".shouchang > ul").append(data);
			}
		}); 
 } 
</script>
<div style="height:50px; line-height:50px; clear:both;"></div>
<div class="v_nav">
	<div class="vf_nav">
		<ul>
			<li> <a href="<?php echo U('Index/index');?>">
			    <i class="vf_1"></i>
			    <span>首页</span></a></li>
			<li><a href="<?php echo U('Mobile/index/street');?>">
			    <i class="vf_2"></i>
			    <span style="color:#956BFF">店铺</span></a></li>
			<li style="display:none"><a href="<?php echo U('Goods/categoryList');?>">
			    <i class="vf_3"></i>
			    <span>分类</span></a></li>
			<li  style="display:none">
			<a href="<?php echo U('Cart/cart');?>">
			   <em class="global-nav__nav-shop-cart-num" id="cart_quantity" style="right:9px;"></em>
			   <i class="vf_4"></i>
			   <span>购物车</span>
			   </a>
			</li>
			<li><a href="<?php echo U('User/index');?>">
			    <i class="vf_5"></i>
			    <span>我的</span></a>
			</li>
		</ul>
	</div>
</div> 
<script type="application/javascript">
$(document).ready(function(){
	  var cart_cn = getCookie('cn');
	  //console.log(cart_cn);
	  if(cart_cn == ''){
		$.ajax({
			type : "GET",
			url:"/index.php?m=Home&c=Cart&a=header_cart_list",//+tab,
			success: function(data){								 
				cart_cn = getCookie('cn');
				$('#cart_quantity').html(cart_cn);						
			}
		});	
	  }
	  $('#cart_quantity').html(cart_cn);
});
</script>
<!-- 微信浏览器 调用微信 分享js-->
<!--<?php if($signPackage != null): ?><script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
<script src="/Public/js/global.js"></script>
<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script type="text/javascript">

<?php if(ACTION_NAME == 'goodsInfo'): ?>var ShareLink = "http://<?php echo ($_SERVER[HTTP_HOST]); ?>/index.php?m=Mobile&c=Goods&a=goodsInfo&id=<?php echo ($goods[goods_id]); ?>"; //默认分享链接
   var ShareImgUrl = "http://<?php echo ($_SERVER[HTTP_HOST]); echo (goods_thum_images($goods[goods_id],400,400)); ?>"; // 分享图标
<?php else: ?>
   var ShareLink = "http://<?php echo ($_SERVER[HTTP_HOST]); ?>/index.php?m=Mobile&c=Index&a=index"; //默认分享链接
   var ShareImgUrl = "http://<?php echo ($_SERVER[HTTP_HOST]); echo ($tpshop_config['shop_info_store_logo']); ?>"; // 分享图标<?php endif; ?>

var is_distribut = getCookie('is_distribut'); // 是否分销代理
var user_id = getCookie('user_id'); // 当前用户id
//alert(is_distribut+'=='+user_id);

// 如果已经登录了, 并且是分销商
if(parseInt(is_distribut) == 1 && parseInt(user_id) > 0)
{									
	ShareLink = ShareLink + "&first_leader="+user_id;									
}										


// 微信配置
wx.config({
    debug: false, 
    appId: "<?php echo ($signPackage['appId']); ?>", 
    timestamp: '<?php echo ($signPackage["timestamp"]); ?>', 
    nonceStr: '<?php echo ($signPackage["nonceStr"]); ?>', 
    signature: '<?php echo ($signPackage["signature"]); ?>',
    jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage','onMenuShareQQ','onMenuShareQZone','hideOptionMenu'] // 功能列表，我们要使用JS-SDK的什么功能
});

// config信息验证后会执行ready方法，所有接口调用都必须在config接口获得结果之后，config是一个客户端的异步操作，所以如果需要在 页面加载时就调用相关接口，则须把相关接口放在ready函数中调用来确保正确执行。对于用户触发时才调用的接口，则可以直接调用，不需要放在ready 函数中。
wx.ready(function(){
    // 获取"分享到朋友圈"按钮点击状态及自定义分享内容接口
    wx.onMenuShareTimeline({
        title: "<?php echo ($tpshop_config['shop_info_store_title']); ?>", // 分享标题
        link:ShareLink,
        imgUrl:ShareImgUrl // 分享图标
    });

    // 获取"分享给朋友"按钮点击状态及自定义分享内容接口
    wx.onMenuShareAppMessage({
        title: "<?php echo ($tpshop_config['shop_info_store_title']); ?>", // 分享标题
        desc: "<?php echo ($tpshop_config['shop_info_store_desc']); ?>", // 分享描述
        link:ShareLink,
        imgUrl:ShareImgUrl // 分享图标
    });
	// 分享到QQ
	wx.onMenuShareQQ({
        title: "<?php echo ($tpshop_config['shop_info_store_title']); ?>", // 分享标题
        desc: "<?php echo ($tpshop_config['shop_info_store_desc']); ?>", // 分享描述
        link:ShareLink,
        imgUrl:ShareImgUrl // 分享图标
	});	
	// 分享到QQ空间
	wx.onMenuShareQZone({
        title: "<?php echo ($tpshop_config['shop_info_store_title']); ?>", // 分享标题
        desc: "<?php echo ($tpshop_config['shop_info_store_desc']); ?>", // 分享描述
        link:ShareLink,
        imgUrl:ShareImgUrl // 分享图标
	});

   <?php if(CONTROLLER_NAME == 'User'): ?>wx.hideOptionMenu();  // 用户中心 隐藏微信菜单<?php endif; ?>
	
});
</script>


<!--微信关注提醒 start-->
<?php if($_SESSION['subscribe']== 0): ?><button class="guide" onclick="follow_wx()">关注公众号</button>
<style type="text/css">
.guide{width:20px;height:100px;text-align: center;border-radius: 8px ;font-size:12px;padding:8px 0;border:1px solid #adadab;color:#000000;background-color: #fff;position: fixed;right: 6px;bottom: 200px;}
#cover{display:none;position:absolute;left:0;top:0;z-index:18888;background-color:#000000;opacity:0.7;}
#guide{display:none;position:absolute;top:5px;z-index:19999;}
#guide img{width: 70%;height: auto;display: block;margin: 0 auto;margin-top: 10px;}
</style>
<script type="text/javascript" src="/Template/mobile/new/Static/js/layer.js" ></script>
<script type="text/javascript">

  // 关注微信公众号二维码	 
function follow_wx()
{
	layer.open({
		type : 1,  
		title: '关注公众号',
		content: '<img src="<?php echo ($wechat_config['qr']); ?>" width="200">',
		style: ''
	});
}
 
</script><?php endif; ?>
<!--微信关注提醒  end--><?php endif; ?>-->
<!-- 微信浏览器 调用微信 分享js  end-->
</body>
</html>