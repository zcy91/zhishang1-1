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
      <div class="h-mid">申请提现</div>
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
<div class="user_com">
<div class="com_top">
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


<div class="Wallet">
	<div class="cash_num bb1">
        <form action="" method="post" enctype="multipart/form-data" name="distribut_form" id="distribut_form">
            <p class="tx_cash"><span>提现金额：</span><input type="text" id="money" name="money" placeholder="最少提现<?php echo tpCache('distribut.sys_user_min_amount');?>起" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" onKeyUp="this.value=this.value.replace(/[^\d.]/g,'')"/></p>
            <p class="tx_cash"><span>银行名称：</span><input type="text" id="bank_name" name="bank_name" placeholder="如:支付宝,农业银行,工商银行等..."/></p>
            <p class="tx_cash"><span>收款账号：</span><input type="text" id="account_bank" name="account_bank" placeholder="如:支付宝账号,建设银行账号"/></p>
            <p class="tx_cash"><span>开户名：</span><input type="text" id="account_name" name="account_name" placeholder="开户人姓名"/></p>            
            <p class="tx_cash"><span>验证码：</span>
            <input type="text" name="verify_code" id="verify_code" placeholder="请输入验证码" style="width:100px;" />
            <img class="po-ab to0" id="verify_code_img" width="100" height="30" src="<?php echo U('User/verify',array('type'=>'withdrawals'));?>"  onclick="verify(this)" />
            </p> 
            <p style="font-size:14px; color:#666"  class="name_html">(当前提现手续费:<span style="color:#f00">万分之<?php echo tpCache('distribut.sys_user_fee');?></span>,<span style="color:#00f">不满二元扣2元</span>)</p> 
            <p><a id="cash_submit" href="javascript:void(0);" onClick="checkSubmit();" style=" display:block; margin:0px auto;width:65%; height:30px; line-height:30px; background:#ececec">确定提交</a></p>
		</form>        
	</div>
	<div class="cash_num">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" id="ajax_return">
			<tr>
				<th>申请日期</th>                
				<th>申请金额</th>
                <th>手续费</th>
				<th>状态</th>
			</tr> 
           <?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
                <td><?php echo (date("Y-m-d",$v['create_time'])); ?></td>
                <td><?php echo ($v['money']); ?></td>
                <td><?php echo ($v['sxf']); ?></td>
                <td>
                    <?php if($v[status] == 0): ?>申请中<?php endif; ?>
                    <?php if($v[status] == 1): ?>申请成功<?php endif; ?>
                    <?php if($v[status] == 2): ?>申请失败<?php endif; ?>                   
                </td>
            </tr><?php endforeach; endif; ?>                                      
		</table>
	    <?php if(!empty($list)): ?><p style="text-align: center;" id="getmore"><a href="javascript:void(0)" onClick="ajax_sourch_submit()">点击加载更多</a></p><?php endif; ?>            
	</div>
</div>


</div>

</div>
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
<script>

 $("#money").on("input",function(e){
     //获取input输入的值
	    var money=e.delegateTarget.value;
		var bili="<?php echo tpCache('distribut.sys_user_fee');?>";
		var fee=money*bili*0.0001;
		//console.log(fee);
	     if (fee>2) {
            $('.name_html').html('本次申请将扣除<span style="color:#f00">'+ fee+ '元</span>手续费');
         }else{
            $('.name_html').html('本次申请将扣除<span style="color:#f00">2元</span>手续费');
         }
});


// 表单验证提交
function checkSubmit(){
	
	var money = $.trim($('#money').val());
	var bank_name = $.trim($('#bank_name').val());
	var account_bank = $.trim($('#account_bank').val());
	var account_name = $.trim($('#account_name').val());
	var verify_code = $.trim($('#verify_code').val());
	
	if(money == '')
	{
		layer.open({content:'提现金额必填',time:2});	
		$('#money').focus();
		return false;
	}
	if(money < <?php echo tpCache('distribut.sys_user_min_amount');?> || money > <?php echo ($user['user_money']); ?>)
	{
		layer.open({content:'每次最少提现额度<?php echo tpCache('distribut.sys_user_min_amount');?>,你的账户余额<?php echo ($user['user_money']); ?>',time:2});	
		$('#money').focus();
		return false;
	}
			
	if(bank_name == '')
	{
		layer.open({content:'银行名称必填',time:2});	
		$('#bank_name').focus();
		return false;
	}
	if(account_bank == '')
	{
		layer.open({content:'收款账号必填',time:2});	
		$('#account_bank').focus();
		return false;
	}
	if(account_name == '')
	{
		layer.open({content:'开户名必填',time:2});
		$('#account_name').focus();
		return false;
	}
	if(verify_code == '')
	{
		layer.open({content:'验证码必填',time:2});
		$('#verify_code').focus();
		return false;
	}
	$('#distribut_form').submit();
}

// 验证码切换
function verify(){
   $('#verify_code_img').attr('src','/index.php?m=Mobile&c=User&a=verify&type=withdrawals&r='+Math.random());
}

var  page = 1;
 /*** ajax 提交表单 查询订单列表结果*/  
 function ajax_sourch_submit()
 {	 	 	 
        page += 1;
		$.ajax({
			type : "GET",			
			url:"/index.php?m=Mobile&c=User&a=withdrawals&is_ajax=1&p="+page,//+tab,
//			data : $('#filter_form').serialize(),// 你的formid 搜索表单 序列化提交
			success: function(data)
			{
				if($.trim(data) == '')
					$('#getmore').hide();
				else{
				    $("#ajax_return").append(data);
				}
			}
		}); 
 } 
 
</script>	
</html>