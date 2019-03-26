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
          <div class="h-mid">店铺信息</div>
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
<div class="liuyan" style="margin:0px; padding:0px">
    <div class="liuyan_list">
      <div id="list_0_0" style="font-size:14px; text-align:left; line-height:25px; padding:10px; background:#eee; margin:0px">
       <span style="color:#f00; font-size:16px">请如实填写以下信息！</span><br>
      &nbsp;&nbsp;1.请保持帐户<?php echo tpCache('distribut.hot_jifeng_name');?>充足<br/>
      &nbsp;&nbsp;2.如不使用赠送或抵扣<?php echo tpCache('distribut.jifeng_name');?>，请设置为0</br>
      &nbsp;&nbsp;3.联系信息需如实填写<br/>
      &nbsp;&nbsp;4.店铺地址需详细填写，以便平台定位设置<br/>
      &nbsp;&nbsp;5.上传产品与管理请使用电脑访问下方链接<br>
      &nbsp;&nbsp;<span id="keydiv">http://www.yjy141319.com/Seller.html</span><span onclick="copyText()" style="padding:3px 10px; background:#36F; border-radius:5px; color:#FFF; font-size:12px; cursor:pointer; margin-left:15px">复制</span> 
      </div>
    </div>
    <div class="liuyandom"> 
      <section class="innercontent1">
        <form action="" method="post" name="formMsg" onSubmit="return submitMsg()">
          <div class="field_else">
          <span>店铺名称：</span><input type="text" name="store_name" id="store_name" placeholder="&nbsp;例：***超市" style="width:70%" value="<?php echo ($m_info["store_name"]); ?>"/ >
          </div>
          <div class="field_else">
          <span>&nbsp;联&nbsp;系&nbsp;人：</span><input type="text" name="store_user_name" id="store_user_name" placeholder="&nbsp;例：李四" style="width:70%" value="<?php echo ($m_info["store_user_name"]); ?>" readonly/>
          </div>
          <div class="field_else">
          <span>联系电话：</span><input type="text" name="store_phone" id="store_phone" placeholder="&nbsp;电话或手机" style="width:70%" value="<?php echo ($m_info["store_phone"]); ?>" readonly/>
          </div>
          <div class="field_else">
          <span>店铺地址：</span><input type="text" name="store_address" id="store_address" placeholder="&nbsp;店铺地址" style="width:70%" value="<?php echo ($m_info["store_address"]); ?>" readonly/>
          </div>
          <div class="field_else">
             <textarea name="seo_description" id="seo_description" style="height:80px;width:92%" placeholder="店铺描述..."><?php echo ($m_info["seo_description"]); ?></textarea>
          </div>
          
          <div class="field_else">
          <span>充值赠送：</span><input type="text" name="gift_jifeng" id="gift_jifeng" placeholder="&nbsp;例:兖100送1<?php echo tpCache('distribut.jifeng_name');?>,直接填入1" value="<?php echo ($m_info["gift_jifeng"]); ?>" style="width:45%" onKeyUp="value=this.value.replace(/\D+/g,'')"/>%&nbsp;<?php echo tpCache('distribut.jifeng_name');?>
          </div>
          <div class="field_else">
          <span>充值抵扣：</span><input type="text" name="arrive_jifeng" id="arrive_jifeng" placeholder="&nbsp;例:兖100送1<?php echo tpCache('distribut.jifeng_name');?>,直接填入1" value="<?php echo ($m_info["arrive_jifeng"]); ?>" style="width:45%" onKeyUp="value=this.value.replace(/\D+/g,'')"/>%&nbsp;<?php echo tpCache('distribut.jifeng_name');?>
          </div>  

          <div class="field_else">
          <span>&nbsp;验&nbsp;证&nbsp;码：</span><input  type="text" name="verify_code" id="verify_code" placeholder="验证码" style="width:25%"/>
<img class="po-ab to0" id="verify_code_img" width="120" height="35" src="<?php echo U('Home/User/verify',array('type'=>'merchant'));?>"  onclick="verify(this)" />                
          </div>          
          <div style=" padding-bottom:10px;">
            <input type="submit" value="提交保存" class="btn_big1"/>
          </div>
        </form>
      </section>
    </div>
</div>

<script>

function copyText() {
var Url2 = document.getElementById("keydiv").innerText;
var oInput = document.createElement('input');
oInput.value = Url2;
document.body.appendChild(oInput);
oInput.select();
document.execCommand("Copy"); 
oInput.className = 'oInput';
oInput.style.display = 'none';
layer.open({content:'复制成功',time:1});
}

function verify(){
   $('#verify_code_img').attr('src','/index.php?m=Mobile&c=User&a=verify&type=merchant&r='+Math.random());
}

function submitMsg() {
	if ($.trim($('#store_name').val()).length == 0) {
		layer.open({content:'店铺名称不能为空',time:2});
		$(" input[ name='store_name' ] ").focus();
		return false
	}
	if ($.trim($('#store_user_name').val()).length == 0) {
		layer.open({content:'联系人不能为空',time:2});
		$(" input[ name='store_user_name' ] ").focus();
		return false
	}
	if ($.trim($('#store_phone').val()).length == 0) {
		layer.open({content:'联系电话不能为空',time:2});
		$(" input[ name='store_phone' ] ").focus();
		return false
	}
	if ($.trim($('#store_address').val()).length == 0) {
		layer.open({content:'店铺地址不能为空',time:2});
		$(" input[ name='store_address' ] ").focus();
		return false
	}
	if ($.trim($('#verify_code').val()).length == 0) {
		layer.open({content:'验证码不能为空',time:2});
		$(" input[ name='验证码不能为空' ] ").focus();
		return false
	}
	return true;
}
</script>

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
</html>