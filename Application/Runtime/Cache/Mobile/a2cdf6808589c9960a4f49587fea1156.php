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
<header style="display:none">
<div class="tab_nav">
  <div class="header">
    <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
    <div class="h-mid">会员中心</div>
    <div class="h-right">
      <aside class="top_bar">
        <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
      </aside>
    </div>
  </div>
</div>
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
</header>
    <link rel="stylesheet" href="/Template/mobile/new/Static/html/css/weui.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/Template/mobile/new/Static/html/css/font-awesome.min.css">
    <link rel="stylesheet" href="/Template/mobile/new/Static/html/css/main.css">
    <link rel="stylesheet" href="/Template/mobile/new/Static/html/css/home.css">
    <link rel="stylesheet" href="/Template/mobile/new/Static/html/css/theme-color.css">


<footer class="zyw-footer" style="display:none">
    <div class="zyw-container white-bgcolor">
        <div class="weui-tabbar">
            <a href="<?php echo U('Index/index');?>" class="weui-tabbar__item">
                <div class="weui-tabbar__icon">
                    <img src="./../Template/mobile/new/Static/html/img/svg/foot-1.svg" alt="">
                </div>
                <p class="weui-tabbar__label">首页</p>
            </a>

            <a href="<?php echo U('Mobile/index/street');?>" class="weui-tabbar__item weui-bar__item--on">
                <div class="weui-tabbar__icon">
                    <img src="./../Template/mobile/new/Static/html/img/svg/store.png" alt="">
                </div>
                <p class="weui-tabbar__label">店铺</p>
            </a>
            <a href="<?php echo U('User/index');?>" class="weui-tabbar__item">
                <div class="weui-tabbar__icon">
                    <img src="./../Template/mobile/new/Static/html/img/svg/foot-5.svg" alt="">
                </div>
                <p class="weui-tabbar__label">我的</p>
            </a>
        </div>
    </div>
</footer>
<div id="tbh5v0">
<div class="user_com">

<section class="zyw-container">
<!--<div class="com_top">
	<h2><a href="<?php echo U('Mobile/User/userinfo');?>">设置</a></h2>
	<p class="tuij_cas">
	        <?php echo ($user['nickname']); ?>
            <?php if($first_nickname != ''): ?><br />
            	<span>由( <?php echo ($first_nickname); ?> )推荐</span><?php endif; ?>
    </p>
	<dl>
		<dt>
		<img src="<?php echo ((isset($user['head_pic']) && ($user['head_pic'] !== ""))?($user['head_pic']):" /Template/mobile/new/Static/images/user68.jpg"); ?>" onerror="this.src='/Template/mobile/new/Static/images/user68.jpg'">
        
		<dd><?php echo ($level_name); ?></dd>
		</dt>
	</dl>
</div>
<div class="uer_topnav">
	<ul>
		<li class="bain"><a href="<?php echo U('Mobile/User/order_list');?>" ><span><?php echo ($order_count); ?></span>我的订单</a></li>
		<li class="bain"><a href="<?php echo U('Mobile/User/collect_list');?>"><span><?php echo ($goods_collect_count); ?></span>我的收藏</a></li>
		<li><a href="<?php echo U('Mobile/User/comment');?>"><span><?php echo ($comment_count); ?></span>我的评价</a></li>
	</ul>
</div>
-->

    <div class="home-head white-bgcolor clearfix">
        <div class="head-img">
            <div class="head-logo"><a href="<?php echo U('Mobile/User/userinfo');?>"><img src="<?php echo ((isset($user['head_pic']) && ($user['head_pic'] !== ""))?($user['head_pic']):" /Template/mobile/new/Static/images/user68.jpg"); ?>" onerror="this.src='/Template/mobile/new/Static/images/user68.jpg'"></a></div>
            <div class="head-name"><a href="<?php echo U('Mobile/User/userinfo');?>"><?php echo ($user['nickname']); ?></a></div>
            <div class="head-icon"><a>等级:<?php echo ($level_name); ?></a></div>
        </div>
        <div class="head-cont">
            <div class="weui-flex">
                <div class="weui-flex__item"><a href="<?php echo U('Mobile/User/order_list');?>"><p><?php echo ($order_count); ?></p><span>我的订单</span></a></div>
                <div class="weui-flex__item"><a href="<?php echo U('Mobile/User/collect_list');?>"><p><?php echo ($goods_collect_count); ?></p><span>我的收藏</span></a></div>
                <div class="weui-flex__item"><a href="<?php echo U('Mobile/User/comment');?>"><p><?php echo ($comment_count); ?></p><span>我的评价</span></a></div>
            </div>
        </div>
    </div>
    <div class="weui-flex home-order white-bgcolor mb-625">
        <div class="weui-flex__item">
        	<p class="weui-flex__label"><?php echo ($user['dai_points']); ?></p>
          <p class="weui-flex__label"><b>待激活</b></p>
          <?php if(tpCache('distribut.point_yue_jifeng') != 0): ?><p class="weui-flex__label"><a href="<?php echo U('Mobile/User/jifeng_jihuo');?>">激活</a></p><?php endif; ?>
        </div>
        <div class="weui-flex__item">
        	<p class="weui-flex__label"><?php echo ($user['cold_points']); ?></p>
          <p class="weui-flex__label"><b>冷钱包</b></p>
        </div>
        <div class="weui-flex__item">
        	<p class="weui-flex__label"><?php echo ($user['pay_points']); ?></p>
          <p class="weui-flex__label"><b>热钱包</b></p>
          
        <?php if(tpCache('distribut.point_shifang_leng') != 0): ?><p class="weui-flex__label"><a href="<?php echo U('Mobile/User/jifeng_buy');?>" class="on">购买</a></p><?php endif; ?>
        </div>
    </div>


<div class="Wallet" style="display:none">
	<ul>
	<li class="bain1"><strong>￥<?php echo ($user['user_money']); ?>元</strong><span>余额</span></li>
<!--<li class="bain1" s><strong><?php echo ($coupon_count); ?></strong><span>优惠券</span></li>-->
	<li class="bain1"><strong><?php echo ($user['pay_points']); ?></strong><span><?php echo tpCache('distribut.hot_jifeng_name');?></span></li>
    <li ><strong><?php echo ($user['cold_points']); ?></strong><span><?php echo tpCache('distribut.cold_jifeng_name');?></span></li>
	</ul>
    <a href="<?php echo U('Mobile/User/points');?>"><em class="Icon Icon1"></em><dl class="b"><dt>我的钱包</dt><dd style="color:#aaaaaa;">余额:<?php echo ($user['user_money']); ?>元</dd></dl></a>
	<!--<a href="<?php echo U('Mobile/User/account');?>"><em class="Icon Icon1"></em><dl><dt>我的钱包</dt><dd style="color:#aaaaaa;">查看我的钱包</dd></dl></a>-->
	<a><em class="Icon Icon16"></em><dl class="b"><dt>待释放<?php echo tpCache('distribut.cold_jifeng_name');?>额度</dt><dd><?php echo ($user['dai_points']); ?></dd></dl></a>
	<a href="<?php echo U('Mobile/User/jifeng_jihuo');?>"><em class="Icon Icon3"></em><dl class="b"><dt>激活<?php echo tpCache('distribut.cold_jifeng_name');?></dt><dd>激活后增加<?php echo tpCache('distribut.cold_jifeng_name');?>,且赠送<?php echo tpCache('distribut.equity_name');?>&nbsp;</dd></dl></a>
  <a href="<?php echo U('Mobile/User/jifeng_buy');?>"><em class="Icon Icon14"></em><dl class="b"><dt>购买<?php echo tpCache('distribut.hot_jifeng_name');?></dt><dd>交易后增加<?php echo tpCache('distribut.hot_jifeng_name');?>&nbsp;</dd></dl></a>
    <a href="<?php echo U('Mobile/User/jifeng_yue');?>"><em class="Icon Icon18"></em><dl class="b"><dt><?php echo tpCache('distribut.hot_jifeng_name');?>转余额</dt><dd>&nbsp;</dd></dl></a>
    <a href="<?php echo U('Mobile/User/jifeng_zs');?>"><em class="Icon Icon17"></em><dl class="b"><dt><?php echo tpCache('distribut.jifeng_name');?>转赠</dt><dd>&nbsp;</dd></dl></a>
</div>
    <div class="home-cont weui-cells mb-625">
        <a href="<?php echo U('Mobile/User/points');?>" class="weui-cell weui-cell_access">
            <div class="weui-cell__bd">
                <p class="choose-text"><img src="./../Template/mobile/new/Static/html/img/qb.png" alt=""> 我的钱包</p>
            </div>
            <div class="weui-cell__ft choose-des">余额:<?php echo ($user['user_money']); ?></div>
        </a>

        <a class="weui-cell weui-cell_access" href="<?php echo U('Mobile/User/order_list');?>">
            <div class="weui-cell__bd">
                <p class="choose-text"><img src="./../Template/mobile/new/Static/html/img/user_ico1.png" alt=""> 全部订单</p>
            </div>
            <div class="weui-cell__ft choose-des">我的订单</div>
        </a>
        <a class="weui-cell weui-cell_access" href="<?php echo U('Mobile/User/comment');?>">
            <div class="weui-cell__bd">
                <p class="choose-text"><img src="./../Template/mobile/new/Static/html/img/user_ico2.png" alt=""> 我的评价</p>
            </div>
            <div class="weui-cell__ft choose-des">收货后才可评价</div>
        </a>
        <a class="weui-cell weui-cell_access" href="<?php echo U('Mobile/User/collect_list');?>">
            <div class="weui-cell__bd">
                <p class="choose-text"><img src="./../Template/mobile/new/Static/html/img/user_ico3.png" alt=""> 我的收藏</p>
            </div>
            <div class="weui-cell__ft choose-des">商品与店铺</div>
        </a>
        <a class="weui-cell weui-cell_access" href="<?php echo U('User/address_list');?>">
            <div class="weui-cell__bd">
                <p class="choose-text"><img src="./../Template/mobile/new/Static/html/img/user_ico4.png" alt=""> 地址管理</p>
            </div>
            <div class="weui-cell__ft choose-des">收货地址库</div>
        </a>   
    </div>
    <div class="home-cont weui-cells mb-625">
    
<?php if(tpCache('distribut.point_xianjin') != 0): ?><a class="weui-cell weui-cell_access" href="<?php echo U('Mobile/User/jifeng_yue');?>">
            <div class="weui-cell__bd">
                <p class="choose-text"><img src="./../Template/mobile/new/Static/html/img/user_ico5.png" alt=""> <?php echo tpCache('distribut.jifeng_name');?>转余额</p>
            </div>
            <div class="weui-cell__ft choose-des">转换后方可提现</div>
        </a><?php endif; ?>
<?php if(tpCache('distribut.sys_jifeng_zs') == 1): ?><a class="weui-cell weui-cell_access" href="<?php echo U('Mobile/User/jifeng_zs');?>">
            <div class="weui-cell__bd">
                <p class="choose-text"><img src="./../Template/mobile/new/Static/html/img/user_ico6.png" alt=""> <?php echo tpCache('distribut.jifeng_name');?>转赠</p>
            </div>
            <div class="weui-cell__ft choose-des">转给其他会员</div>
        </a><?php endif; ?> 
    </div>

    <div class="home-cont weui-cells mb-625">

   
   
   
<?php if($user[is_sq] == 1): ?><a href="<?php echo U('User/zwzq_list');?>" class="weui-cell weui-cell_access">
       <div class="weui-cell__bd"><p class="choose-text"><img src="./../Template/mobile/new/Static/html/img/zl.png" alt="">&nbsp;债务债权</p></div>
       <div class="weui-cell__ft choose-des">上传债务信息，获得额度</div>
    </a>
       
<?php else: ?>
    <a href="<?php echo U('Mobile/User/ziliao_ws');?>" class="weui-cell weui-cell_access">
       <div class="weui-cell__bd"><p class="choose-text"><img src="./../Template/mobile/new/Static/html/img/zl.png" alt="">&nbsp;<?php if($user[is_sq] == 1): ?>修改资料<?php else: ?>完善资料<?php endif; ?></p></div> 
       <div class="weui-cell__ft choose-des">上传债务信息，获得额度</div>
    </a><?php endif; ?>  

    
    
    <a href="<?php echo U('Mobile/User/userinfo');?>"  class="weui-cell weui-cell_access">
       <div class="weui-cell__bd"><p class="choose-text"><img src="./../Template/mobile/new/Static/html/img/aq.png" alt=""> 帐户安全</p></div>
       <div class="weui-cell__ft choose-des">修改帐户信息</div>
    </a>



 <?php if(empty($merchant)): ?><a href="<?php echo U('Newjoin/agreement');?>" class="weui-cell weui-cell_access">
        <div class="weui-cell__bd"><p class="choose-text"><img src="./../Template/mobile/new/Static/html/img/dp.png" alt=""> 商家入驻</p></div>
        <div class="weui-cell__ft choose-des">申请入驻</div>
      </a>
 <?php else: ?>

<?php switch($merchant[apply_state]): case "0": ?><a href="<?php echo U('Newjoin/apply_info');?>" class="weui-cell weui-cell_access">
       <div class="weui-cell__bd"><p class="choose-text"><img src="./../Template/mobile/new/Static/html/img/dp.png" alt=""> 已申请入驻</p></div>
       <div class="weui-cell__ft choose-des">待审核</div>
   </a><?php break;?>
<?php case "1": ?><a href="<?php echo U('User/merchant_list');?>" class="weui-cell weui-cell_access">
      <div class="weui-cell__bd"><p class="choose-text"><img src="./../Template/mobile/new/Static/html/img/dp.png" alt=""> 店铺信息</p></div>
      <div class="weui-cell__ft choose-des">已审核</div>
   </a><?php break;?>
<?php case "2": ?><a href="<?php echo U('Newjoin/agreement');?>"  class="weui-cell weui-cell_access">
      <div class="weui-cell__bd"><p class="choose-text"><img src="./../Template/mobile/new/Static/html/img/dp.png" alt=""> 申请已审核</p></div>
      <div class="weui-cell__ft choose-des">未通过</div>
   </a><?php break; endswitch; endif; ?>

        
        <a class="weui-cell weui-cell_access" href="<?php echo U('User/tuiguang');?>">
            <div class="weui-cell__bd">
                <p class="choose-text"><img src="./../Template/mobile/new/Static/html/img/user_ico7.png" alt=""> 推广中心</p>
            </div>
            <div class="weui-cell__ft choose-des">推荐您的好友</div>
        </a>
        <a class="weui-cell weui-cell_access" href="<?php echo U('User/tuandui');?>">
            <div class="weui-cell__bd">
                <p class="choose-text"><img src="./../Template/mobile/new/Static/html/img/user_ico8.png" alt=""> 我的团队</p>
            </div>
            <div class="weui-cell__ft choose-des">推广成功的会员</div>
        </a>
    </div>
    
    <div class="home-cont weui-cells mb-625">
        <a class="weui-cell weui-cell_access" href="<?php echo U('User/logout');?>">
            <div class="weui-cell__bd">
                <p class="choose-text"><img src="./../Template/mobile/new/Static/html/img/user_ico9.png" alt=""> 注销登录</p>
            </div>
            <div class="weui-cell__ft choose-des">安全退出会员中心</div>
        </a>
    </div>
</section>
<div class="Wallet" style="display:none">
	<a href="<?php echo U('Mobile/User/order_list');?>" ><em class="Icon Icon2"></em><dl class="b"><dt>全部订单</dt><dd>查看订单</dd></dl></a>
	<a href="<?php echo U('Mobile/User/comment');?>"><em class="Icon Icon4"></em><dl class="b"><dt>我的评价</dt><dd>查看评价</dd></dl></a>
	<a href="<?php echo U('Mobile/User/collect_list');?>"><em class="Icon Icon10"></em><dl class="b"><dt>我的收藏</dt><dd>&nbsp;</dd></dl></a>
	<a href="<?php echo U('User/address_list');?>"><em class="Icon Icon5"></em><dl class="b"><dt>地址管理</dt><dd>&nbsp;</dd></dl></a>
</div>
<div class="Wallet" style="display:none">
    <a href="<?php echo U('Mobile/User/ziliao_ws');?>"><em class="Icon Icon15"></em><dl class="b"><dt>完善资料</dt><dd>&nbsp;</dd></dl></a>   
    <a href="<?php echo U('User/tuiguang');?>"><em class="Icon Icon13"></em><dl class="b"><dt>推广中心</dt><dd>&nbsp;</dd></dl></a>
    <a href="<?php echo U('User/tuandui');?>"><em class="Icon Icon6"></em><dl class="b"><dt>我的团队</dt><dd>&nbsp;</dd></dl></a>
    
    <a href="<?php echo U('User/message_list');?>"  style="display:none"><em class="Icon Icon7"></em><dl class="b"><dt>我的留言</dt><dd>&nbsp;</dd></dl></a>
	<a href="<?php echo U('User/return_goods_list');?>" style="display:none"><em class="Icon Icon11"></em><dl class="b"><dt>售后服务</dt><dd>&nbsp;</dd></dl></a>
 
<?php if($user["is_distribut"] == 1): if(empty($merchant)): ?><a href="<?php echo U('Newjoin/agreement');?>"><em class="Icon Icon12"></em><dl><dt>申请商家入驻</dt><dd>&nbsp;</dd></dl></a>
 <?php else: ?>
	
<?php switch($merchant["apply_state"]): case "0": ?><a href="<?php echo U('Newjoin/agreement');?>"><em class="Icon Icon12"></em><dl><dt>已申请</dt><dd>待审核</dd><?php break;?></case>
<?php case "1": ?><a href="<?php echo U('User/merchant_list');?>"><em class="Icon Icon12"></em><dl><dt style="color:#F00">店铺信息</dt><dd>已审核</dd><?php break;?></case>
<?php case "2": ?><a href="<?php echo U('Newjoin/agreement');?>"><em class="Icon Icon12"></em><dl><dt style="color:#F00">申请已审核</dt><dd>未通过</dd><?php break;?></case><?php endswitch;?>
</dl></a><?php endif; endif; ?>
</div>
<div class="Wallet" style="display:none">
	<a href="<?php echo U('User/logout');?>"><em class="Icon Icon8"></em><dl><dt>注销登录</dt></dl></a>
</div>
</div>

</div>
<style>

.vf_nav>ul>li{ padding:0px; margin-top:-12px}
</style>
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