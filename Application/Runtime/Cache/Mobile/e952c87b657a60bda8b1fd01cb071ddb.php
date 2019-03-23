<?php if (!defined('THINK_PATH')) exit();?><html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>首页-<?php echo ($tpshop_config['shop_info_store_title']); ?></title>
<meta http-equiv="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>" />
<meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/public.css"/>
<link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/index.css"/>
    <link rel="stylesheet" href="/Template/mobile/new/Static/css/stores.css">
    <link rel="stylesheet" href="/Template/mobile/new/Static/css/public.css">
<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/TouchSlide.1.1.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.json.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/touchslider.dev.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/layer.js" ></script>
<script src="/Public/js/global.js"></script>
<script src="/Public/js/mobile_common.js"></script>
</head>
<body style=" background:#F5F5F5;">


<header>
    <div class="tab_nav">
        <div class="header">
            <div class="h-left"><a class="sb-back" href="/Mobile/index/index" title="返回"></a></div>
            <div class="h-mid">附近商家</div>
            <div style="display: inline-block; position: absolute; right: 4rem;top: 1rem; "><a href="/mobile/index/againLocation" style="color: #fff;font-size: 14px">重新定位</a></div>
            <div class="h-right">
                <aside class="top_bar">
                    <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a
                            href="javascript:;"></a></div>
                </aside>
            </div>
        </div>
    </div>

 <!-- <div id="pop_up" style="display: none;">
    <div  style=" position: fixed;background: rgba(0,0,0,0.6);  height:100%; width: 100%;;z-index: 2;color: #fff;display: flex;flex-direction:column;">

        <div style="height: 10%; text-align: right;margin-top: 15px;margin-right: 20px;" id="nav_tc">
            <span><img src="/Template/mobile/new/Static/images/tuichu/tuichu1.png" style="width: 40px;"/></span>
        </div>
        <div>
            <iframe  width="100%" height="350"  style="border:none; background: #fff; " src="" id="frame">

            </iframe>
        </div>
        <div style="padding-left: 20px;margin-top: 20px;padding-top: 10px;opacity: 0.5; line-height: 30px;text-align: left;background: rgba(0,0,0,0.7);color: #fff;">
            <p><span style="font-size: 16px;font-weight:bold;">店  铺 ：</span> <span id="shop"></span></p>
            <p><span style="font-size: 16px;font-weight:bold;">所在地 ：</span> <span id="address"></span></p>
        </div>
    </div>
  </div>-->
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


<div id="store_list">

</div>


<!--<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=hWvZskNqtgscOPrf4T4AhKhkVVuuRC7v"></script>-->
<script type="text/javascript">
    window.addEventListener("scroll",function(e){
        localStorage.setItem("shopListAjaxScroll",window.pageYOffset);
    });

    $(function () {



        recoverstate();
       //getStreetList();

       $("#nav_tc").click(function(){
          $("#pop_up").css('display','none');
          $("#frame").html("");
       });
        

    });

    var page = 1;//页数
    var cat_id = '';//店铺分类id
    var store_key='<?php echo ($store_key); ?>';
	var lng_lat="<?php echo session('lng_lat');?>";

    function getStreetList() {
		if(lng_lat){
         $('.get_more').show();
        $.ajax({
            type: "get",
            url: "/index.php?m=Mobile&c=Index&a=ajaxstoreList&p=" + page + "&sc_id=" + cat_id + "&key=" + store_key ,
            dataType: 'html',
            success: function (data) {
            //console.log(data);
                if (data) {
				   var Cts = data; 
                   if(Cts.indexOf("未找到更多店铺") >= 0 ) { 
				    $("#store_list").append(data);
                    $('.get_more').hide();
                    $('#getmore').remove();
                   }else{

                       localStorage.setItem("shopListAjax",(localStorage.getItem("shopListAjax") || "") +data);


                    $("#store_list").append(data);
                    page++;
                       localStorage.setItem("shopListAjaxPage",page);
                    $('.get_more').hide();
				   }
                } else {
                    $('.get_more').hide();
                    $('#getmore').remove();
                }
            }
        });
	   }else{
		layer.open({content:'请先允许系统获取定位信息',time:2,
		          //end:function(){window.location.replace("Mobile/index/dingwei/lng_lat/"+lng_lat);}
		          end:function(){window.location.replace("mobile/index/dingwei/lng_lat/"+lng_lat);}
		});
	  }
		
    }

    function recoverstate() {
        //其它页面进来的
        if(localStorage.getItem("isNavBack")==null){
            localStorage.removeItem("shopListAjax");
            localStorage.removeItem("shopListAjaxPage");
            localStorage.removeItem("shopListAjaxScroll");
            getStreetList();


        }
        //导航页面回退
        else {
            var recdata=localStorage.getItem("shopListAjax");
            var pagec=localStorage.getItem("shopListAjaxPage");
            var shopListAjaxScroll= localStorage.getItem("shopListAjaxScroll");
            page=pagec;
            $("#store_list").append(recdata);
            $('.get_more').hide();
            $('html,body').animate({scrollTop:shopListAjaxScroll},'slow');
            localStorage.removeItem("isNavBack")
        }
    }

</script>
<script>
    var state = {
        title: "title",
        url: "#"
    };
    window.history.pushState(state, "title", "#");
    window.addEventListener("popstate", function(e) {
        window.location.href="/Mobile/index/index";
    }, false);
</script>
<div class="floor_body2">
    <div id="J_ItemList">
        <ul class="product single_item info">
        </ul>
        <a href="javascript:;" class="get_more" style="text-align:center; display:block;">
            <img src='/Template/mobile/new/Static/images/category/loader.gif' width="12" height="12"> </a>
    </div>
    <div id="getmore" style="font-size:.24rem;text-align: center;color:#888;padding:.25rem .24rem .4rem;">
        <a href="javascript:void(0)" onClick="getStreetList()">点击加载更多</a>
    </div>
</div>
<div style="height:100px; line-height:50px; clear:both;"></div>

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