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
      <div class="h-mid">资金管理</div>
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
    <div class="pbox">
        <!-- 积分标头 S -->
        <ul class="il_title">
            <li>
                <p class="cf22" id="all_score"><?php echo ($user["pay_points"]); ?></p>
                <p>可用<?php echo tpCache('distribut.jifeng_name');?></p>
            </li>
            <!--
            <li>
                <p class="cf22" id="expire_score">0</p>
                <p>即将过期</p>
            </li>
            -->
            <li>
                <p class="cf22" id="wait_score"><?php echo ($user["user_money"]); ?></p>
                <p>可用余额</p>
            </li>
            <li>
              <div style="height:10px; width:100%"></div>
                <a style="padding: 0 10px;text-align: center;color: #fff;
				border: 1px solid #FE6D0B;display: inline-block;border-radius: 3px;
				box-shadow: 0 1px 2px #E7E7E7;background: #f60;" href="<?php echo U('User/recharge');?>">充值</a>
                <a style="padding: 0 10px;text-align: center;color: #fff;
				border: 1px solid #FE6D0B;display: inline-block;border-radius: 3px;
				box-shadow: 0 1px 2px #E7E7E7;background: #f60;" href="<?php echo U('User/withdrawals');?>">提现</a>
            </li>
        </ul>
        <!-- 积分标头 E -->

        <!-- 积分导航 S -->
        <div class="il_nav" id="J_il_nav">
            <a href="<?php echo U('User/points',array('type'=>'all'));?>" <?php if($type == 'all'): ?>class="active"<?php endif; ?> data-list="0">全部</a>
            <a href="<?php echo U('User/points',array('type'=>'1'));?>" <?php if($type == '1'): ?>class="active"<?php endif; ?>  data-list="1">余额</a>
            <a href="<?php echo U('User/points',array('type'=>'2'));?>" <?php if($type == '2'): ?>class="active"<?php endif; ?>  data-list="2"><?php echo tpCache('distribut.hot_jifeng_name');?></a>
            <a href="<?php echo U('User/points',array('type'=>'3'));?>" <?php if($type == '3'): ?>class="active"<?php endif; ?>  data-list="3"><?php echo tpCache('distribut.cold_jifeng_name');?></a>
            <a href="<?php echo U('User/points',array('type'=>'5'));?>" <?php if($type == '5'): ?>class="active"<?php endif; ?>  data-list="5"><?php echo tpCache('distribut.equity_name');?></a>
            <a href="<?php echo U('User/points',array('type'=>'4'));?>" <?php if($type == '4'): ?>class="active"<?php endif; ?>  data-list="4">待激活</a>
        </div>
        <!-- 积分导航 E -->
        <!-- 列表展示 S  在li上存在2种情况样式(隐藏显示请使用.hide_it样式)
                .list_add 表示增加积分  .list_remove 表示减少积分
        -->
            <ul class="il_list all_score" id="J_il_list_1">
            	<?php if($type == 'recharge'): if(is_array($account_log)): foreach($account_log as $key=>$vo): ?><li class="list_add J_add">
	                    <div class="td_l">
	                        <p>充值金额: <?php echo ($vo["account"]); ?></p>
	                        <p>支付状态:<?php if($vo[pay_status] == 0): ?>待支付&nbsp;&nbsp;<a href="<?php echo U('User/recharge',array('order_id'=>$vo[order_id]));?>" class="">详情</a><?php else: ?>已支付<?php endif; ?></p>
	                    </div>
	                    <div class="td_r">
	                        <p class="il_money"><?php echo ($vo["pay_name"]); ?></p>
	                        <p class="time"><?php echo (date('Y-m-d',$vo["ctime"])); ?></p>
	                    </div>
	                </li><?php endforeach; endif; ?>
               	<?php else: ?>
               <?php if(is_array($account_log)): foreach($account_log as $key=>$vo): ?><li class="<?php if((float)$vo["money"]<0 ){echo "list_remove";}else{echo "list_add";};?> J_add">
                    <div class="td_l">
                        <p><?php echo (function_types($vo["types"])); ?>: <?php echo ($vo["money"]); ?></p>
                        <?php if($vo[desc] == '快捷支付' && $vo[types] == 1): if($vo[money] < 0): $s_info=about_xin('store','user_id='.$vo['order_id'],'store_name,store_id');?>
                            <small style="color:#0C0">商家店铺:<?php echo ($s_info["store_name"]); ?><span style="color:#f00; padding-left:10px"  onClick="location='<?php echo U("Store/fast_info",array('t_no'=>$vo['order_sn'],'store_id'=>$s_info['store_id'],'u_id'=>$vo['user_id']));?>'" >查看</span></small>
                          <?php else: ?>
                            <?php $s_info=about_xin('store','user_id='.$vo['user_id'],'store_name,store_id');?>
                            <small style="color:#0C0">支付单号:<?php echo ($vo["order_sn"]); echo ($vo["order_id"]); ?><span style="color:#f00; padding-left:10px"  onClick="location='<?php echo U("Store/fast_info",array('t_no'=>$vo['order_sn'],'store_id'=>$s_info['store_id'],'u_id'=>$vo['order_id']));?>'">查看</span></small><?php endif; endif; ?>
                    </div>
                    <div class="td_r">
                        <p class="il_money"><?php echo (jifeng_replace($vo["desc"])); ?></p>
                        <p class="time"><?php echo (date('Y-m-d',$vo["change_time"])); ?></p>
                    </div>
                </li><?php endforeach; endif; endif; ?>                  
            </ul>
			<?php if(!empty($account_log)): ?><!-- 下滑加载无更多样式 S-->
	            <div id="getmore" style="font-size:.24rem;text-align: center;color:#888;padding:.25rem .24rem .4rem; clear:both">
	                    <a href="javascript:void(0)" onClick="ajax_sourch_submit()">点击加载更多</a>
	            </div>
	            <!-- 下滑加载无更多样式 E--><?php endif; ?>          
            </div>
<script>
var  page = 1;
 /*** ajax 提交表单 查询订单列表结果*/  
 function ajax_sourch_submit()
 {	 	 	 
        page += 1;
		$.ajax({
			type : "GET",
			url:"/index.php?m=Mobile&c=User&a=points&is_ajax=1&type=<?php echo ($type); ?>&p="+page,//+tab,						
//			url:"<?php echo U('Mobile/User/points',null,'');?>/is_ajax/1/p/"+page,//+tab,
//			data : $('#filter_form').serialize(),// 你的formid 搜索表单 序列化提交
			success: function(data)
			{
				if($.trim(data) == '')
					$('#getmore').hide();
				else
				    $("#J_il_list_1").append(data);
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
</div>
</body>
</html>