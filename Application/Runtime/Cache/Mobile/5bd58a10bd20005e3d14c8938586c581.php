<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta name="Generator" content="tpshop" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title><?php echo ($goods["goods_name"]); ?>_<?php echo ($tpshop_config["shop_info_store_title"]); ?></title>
<meta http-equiv="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>" />
<meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>" />
<!--<meta name="viewport" content=", maximum-scale=1.0, user-scalable=0"/>-->
<link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/public.css"/>
<link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/goods.css"/>
<link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/layer.css"/>
<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.json.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/touchslider.dev.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/layer.js" ></script>
<script src="/Public/js/global.js"></script>
<script src="/Public/js/mobile_common.js"></script>
<script src="/Template/mobile/new/Static/js/common.js?t=<?php echo ($time); ?>"></script>
</head>
<body>
<script type="text/javascript">
var process_request = "正在处理您的请求...";
</script>
<div class="main">
  <div class="tab_nav">
    <div class="header">
      <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
      <div class="h-mid">
        <ul>
          <li><a href="javascript:;" class="tab_head on"   id="goods_ka1" onClick="setGoodsTab('goods_ka',1,3)">商品</a></li>
          <li><a href="javascript:;" class="tab_head" id="goods_ka2" onClick="setGoodsTab('goods_ka',2,3)">详情</a></li>
          <li><a href="javascript:;" class="tab_head" id="goods_ka3" onClick="setGoodsTab('goods_ka',3,3)">评价</a></li>
        </ul>
      </div>
      <div class="h-right">
        <aside class="top_bar">
          <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>
          <a href="<?php echo U('Mobile/Cart/cart');?>" class="show_cart"><em class="global-nav__nav-shop-cart-num" id="tp_cart_info"><?php echo ($cart_total_price[anum]); ?></em></a> 
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
  <div class="main" id="user_goods_ka_1" style="display:block;">
<div class="banner">
  <div id="slider" class="slider" style="overflow: hidden; visibility: visible; list-style: none; position: relative;">
    <ul id="sliderlist" class="sliderlist" style="position: relative; overflow: hidden; transition: left 600ms ease; -webkit-transition: left 600ms ease;">
       <?php if(is_array($goods_images_list)): foreach($goods_images_list as $key=>$pic): ?><li style="float: left; display: block; width: 100%;"><span><a  href="javascript:void(0)">
      	<img title="" width="100%" src="<?php echo ($pic["image_url"]); ?>"></a></span></li><?php endforeach; endif; ?>
    </ul>
    <div id="pagenavi">
    <?php if(is_array($goods_images_list)): foreach($goods_images_list as $k=>$pic): ?><a href="javascript:void(0);" <?php if($k == 0): ?>class="active"<?php endif; ?>></a><?php endforeach; endif; ?>
	</div>
  </div>
</div>
<div class="s_bottom"></div>
<script type="text/javascript">$(function(){
	$("div.module_special .wrap .major ul.list li:last-child").addClass("remove_bottom_line");
});
var active=0,
	as=document.getElementById('pagenavi').getElementsByTagName('a');
	
for(var i=0;i<as.length;i++){
	(function(){
		var j=i;
		as[i].onclick=function(){
			t2.slide(j);
			return false;
		}
	})();
}
var t2=new TouchSlider({id:'sliderlist', speed:600, timeout:6000, before:function(index){
		as[active].className='';
		active=index;
		as[active].className='active';
	}});
</script>
	  <form name="buy_goods_form" method="post" id="buy_goods_form" >
      <div class="product_info">
        <div class="info_dottm">
          <h3 class="name"><?php echo ($goods["goods_name"]); ?></h3>
          <div class="right">

<!-- JiaThis Button BEGIN -->          
<!--          <a href="http://www.jiathis.com/share" class="jiathis jiathis_txt" target="_blank" style="display:none">
            <div id="pro_share" class="share"></div>
          </a>         
<script>
 var jiathis_config = {
						url:"http://<?php echo ($_SERVER[HTTP_HOST]); ?>/index.php?m=Mobile&c=Goods&a=goodsInfo&id=<?php echo ($_GET[id]); ?>",
						pic:"http://<?php echo ($_SERVER[HTTP_HOST]); echo (goods_thum_images($goods[goods_id],400,400)); ?>", 
					}
var is_distribut = getCookie('is_distribut');
var user_id = getCookie('user_id');
// 如果已经登录了, 并且是分销商
if(parseInt(is_distribut) == 1 && parseInt(user_id) > 0)
{									
	jiathis_config.url = jiathis_config.url + "&first_leader="+user_id;									
}										
//alert(jiathis_config.url);
</script>           
<script type="text/javascript" src="http://v3.jiathis.com/code_mini/jia.js" charset="utf-8"></script>-->
<!-- JiaThis Button END -->          
          
          </div>
        </div>
        <dl class="goods_price">
          <script type="text/javascript" src="/Template/mobile/new/Static/js/lefttime.js"></script>
           <dt style="font-size:14px; line-height:30px"><span id="goods_price">￥<?php echo ($goods["shop_price"]); ?>元</span><?php if($goods["give_integral"] != 0): ?><i style="float:right; list-style:none;">赠送<?php echo ((tpCache('distribut.point_rate')*$goods['give_integral']*$goods['shop_price'])*0.01); echo tpCache('distribut.jifeng_name');?></i><?php endif; ?><font>价格：￥<?php echo ($goods["market_price"]); ?>元</font></dt>
           <?php if($goods["exchange_integral"] != 0): ?><dt style="font-size:14px; line-height:30px"><span id="goods_price" style="color:#00f">￥<?php $dik=number_format($goods['exchange_integral']*$goods['shop_price']*0.01,2,'.','');echo $goods['shop_price']-$dik;?>元</span><i style="float:right; list-style:none;">抵扣<?php echo tpCache('distribut.point_rate')*$dik; echo tpCache('distribut.jifeng_name');?></i></dt><?php endif; ?>        
        </dl>
        <ul class="price_dottm">
          <li style=" text-align:left">折扣：<?php echo ($goods["discount"]); ?>折</li>
          <li><?php echo ($commentStatistics["c0"]); ?>人评价</li>
          <li style=" text-align:right"><?php echo ($goods["sale_num"]); ?>人已付款</li>
        </ul>
      </div>
<?php if(($prom_goods != null) OR ($prom_order != null)): ?><section id="search_ka" class="huodong">
	      <div class="subNav">
	        <div class="att_title"> <span>惠</span>
	          <p>促销活动</p>
	        </div>
	      </div>
	      <div class="navContent">
          <?php if($prom_goods != null): ?><ul class="youhui_list1">
                <li>
                <a href="javascript:void(0);" title="<?php echo ($prom_goods[name]); ?>"><img src="/Template/mobile/new/Static/images/hui.png"></a> 
                <a href="javascript:void(0);" ><?php echo ($prom_goods[name]); ?>&nbsp;&nbsp;(活动时间：<?php echo (date("m月d日",$prom_goods[start_time])); ?> - <?php echo (date("m月d日",$prom_goods[end_time])); ?>)</a>
                </li>
              </ul><?php endif; ?>
		<?php
 $md5_key = md5("select * from `__PREFIX__prom_order` order by  id desc limit 5"); $result_name = $sql_result_v = S("sql_".$md5_key); if(empty($sql_result_v)) { $Model = new \Think\Model(); $result_name = $sql_result_v = $Model->query("select * from `__PREFIX__prom_order` order by  id desc limit 5"); S("sql_".$md5_key,$sql_result_v,1); } foreach($sql_result_v as $k=>$v): ?><ul class="youhui_list1" style="margin-top:0px;">
	      	<li><img src="/Template/mobile/new/Static/images/hui.png"><?php echo ($v['name']); ?>&nbsp;&nbsp;(活动时间：<?php echo (date("m月d日",$v[start_time])); ?> - <?php echo (date("m月d日",$v[end_time])); ?>)</li>
	      </ul><?php endforeach; ?>          
	      <div class="blank10"></div>
	      </div>
      </section><?php endif; ?>      
<!-------商品属性-------->
<?php if($filter_spec != ''): ?><section id="search_ka">
<!---属性---->
<div class="ui-sx bian1"> 
<div class="subNavBox"> 
	<div class="subNav"><strong>选择商品属性</strong></div>
    <!--<ul class="navContent"> -->
    <!--<?php if(is_array($filter_spec)): foreach($filter_spec as $key=>$spec): ?>-->
    <!--<li>   -->
          <!--<div class="title"><?php echo ($key); ?></div>-->
          <!--<div class="item">-->
          <!--<?php if(is_array($spec)): foreach($spec as $k2=>$v2): ?>-->
	          <!--<a href="javascript:;" onclick="switch_spec(this);" title="<?php echo ($v2[item]); ?>" <?php if($k2 == 0): ?>class="hover"<?php endif; ?>>-->
	          	<!--<input type="radio" style="display:none;" name="goods_spec[<?php echo ($key); ?>]" value="<?php echo ($v2[item_id]); ?>" <?php if($k2 == 0 ): ?>checked="checked"<?php endif; ?>/>-->
          		<!--<?php echo ($v2[item]); ?>            -->
          	  <!--</a>-->
           <!--<?php endforeach; endif; ?>-->
          <!--</div>                    -->
    <!--</li>-->
    <!--<?php endforeach; endif; ?>-->
       <!--</ul>  -->
    </div>
    </div>    
</section><?php endif; ?>
      <!--<section id="search_ka">-->
        <!--<div class="ui-sx bian1">-->
          <!--<div class="subNavBox">-->
            <!--<div class="subNav on"><strong>购买数量</strong></div>-->
            <!--<ul class="navContent" style="display: block;">-->
              <!--<li style=" border-bottom:1px solid #eeeeee">-->
                <!--<div class="item1" style="display: flex;">-->
                  <!--<span class="ui-number">-->
                  <!--<button type="button" class="decrease" onClick="goods_cut();">-</button>-->
                    <!--<input type="text" class="num" id="number" name="goods_num" value="1" min="1" max="1000"/>-->
                    <!--<input type="hidden" name="goods_id" value="<?php echo ($goods["goods_id"]); ?>"/>-->
                  <!--<button type="button" class="increase" onClick="goods_add();">+</button>-->
                  <!--</span>-->
                    <!--<span style="margin-left: 5px;margin-top: 15px;font-size: 16px;"><?php echo ($goods["unit"]); ?></span>-->
                <!--</div>-->
              <!--</li>-->
            <!--</ul>-->
          <!--</div>-->
        <!--</div>-->
      <!--</section>-->
      <section id="search_ka" style="display:none">
        <div class="ui-sx bian1">
          <div class="subNavBox" >
            <div class="subNav"><strong>会员专享价</strong></a></div>
            <ul class="navContent" >
              <li  class="user_price">
                <p> <span class="key">铜牌会员：</span> <b class="p-price-v">9.8折</b> </p>
                <p> <span class="key">金牌会员：</span> <b class="p-price-v">9.5折</b> </p>
                <p> <span class="key">钻石会员：</span> <b class="p-price-v">9折</b> </p>
              </li>
            </ul>
          </div>
        </div>
      </section>
<script type="text/javascript">
$(function(){
	$(".subNav").click(function(){		
		$(this).next(".navContent").slideToggle(300).siblings(".navContent").slideUp(500);
		$(this).toggleClass("on").siblings(".subNav").removeClass("on");
		if($(".is_scroll").length <= 0)
		{
			$('html,body').animate({'scrollTop':$('body')[0].scrollHeight},600);
		}
	});
	commentType = 1; // 评论类型
    ajaxComment(1,1);// ajax 加载评价列表
})
</script> 
<script type="text/jscript">
function click_search (){
  var search_ka = document.getElementById("search_ka");
  	if (search_ka.className == "s-buy open ui-section-box"){
	  	search_ka.className = "s-buy ui-section-box";
	}else {
		search_ka.className = "s-buy open ui-section-box";
	}
}
 
function changeAtt(t) {
	t.lastChild.checked='checked';
	for (var i = 0; i<t.parentNode.childNodes.length;i++) {
	    if (t.parentNode.childNodes[i].className == 'hover') {
	        t.parentNode.childNodes[i].className = '';
			t.childNodes[0].checked="checked";
		}
	}
	t.className = "hover";
	changePrice();
}

function changeAtt1(t) {
	t.lastChild.checked='checked';
	for (var i = 0; i<t.parentNode.childNodes.length;i++) {
	    if (t.className == 'hover') {
	           t.className = '';
			t.childNodes[0].checked = false;
		}
		else{
			t.className="hover";
			t.childNodes[0].checked = true;
		}
	}
	changePrice();
}

	function goods_cut(){
  		var num_val=document.getElementById('number');  
  		var new_num=num_val.value;  
  		var Num = parseInt(new_num);  
  		if(Num>1)Num=Num-1;  
  		num_val.value=Num;
  	}  
  	function goods_add(){
  		var num_val=document.getElementById('number'); 
  		var new_num=num_val.value;  
  		var Num = parseInt(new_num);  
  		Num=Num+1;  num_val.value=Num;
  	} 
</script>
      <div style=" height:8px; background:#eeeeee; margin-top:-1px;"></div>
      <!--
      <div class="is_scroll">
        <section id="search_ka">
          <div class="ui-sx bian1">
            <div class="subNavBox" >
              <div class="subNav" style=" border:0;"><a href="pocking.php?id=22" style=" border:0px;"><strong>自提点</strong></a></div>
            </div>
          </div>
        </section>
      </div>
      -->
      <?php if($goods[store_id] > 0): ?><div class="is_scroll">
        <input type="hidden" id="chat_supp_id" value="1" />
        <div style=" height:8px; background:#eeeeee; margin-top:-1px;"></div>
        <section class="rzs_info">
          <div class="top_info">
            <dl>
              <dt><a href="<?php echo U('Store/index',array('store_id'=>$store[store_id]));?>">
                <div style="background-image:url('<?php echo ($store["store_logo"]); ?>')"></div>
                </a></dt>
              <dd><strong>卖家: <a href="<?php echo U('Store/index',array('store_id'=>$store[store_id]));?>" style="color:#333; font-size:18px;"><?php echo ($store["store_name"]); ?></a></strong><em>初级店铺</em></dd>
            </dl>
            <ul>
              <li><span>宝贝描述</span><strong>:<?php echo ($store["store_desccredit"]); ?></strong><em>高</em></li>
              <li><span>卖家服务</span><strong>:<?php echo ($store["store_servicecredit"]); ?></strong><em>高</em></li>
              <li><span>物流服务</span><strong>:<?php echo ($store["store_deliverycredit"]); ?></strong><em>高</em></li>
            </ul>
          </div>
          <div class="s_dianpu"> <span><a href="tel:<?php echo ($store["store_phone"]); ?>" style=" margin-left:7%;"><em class="bg1"></em>联系客服</a></span> 
          <span><a href="<?php echo U('Store/index',array('store_id'=>$store[store_id]));?>" style=" margin-left:3%;"><em class="bg2"></em>进入店铺</a></span> </div>
        </section>
      </div><?php endif; ?>
    </form>
  </div>
  <div class="main" id="user_goods_ka_2" style="display:none">
    <div class="product_main" style=" margin-top:40px;"> <!-- 产品图片 -->
         <div class="product_images product_desc" id="product_images"> <?php echo (htmlspecialchars_decode($goods["goods_content"])); ?> </div>
    </div>
    <section class="index_floor">
      <h2 style=" border-bottom:1px solid #ddd "> <span></span> 商品信息 </h2>
        <ul class="xiangq">
           <?php if(is_array($goods_attr_list)): foreach($goods_attr_list as $k=>$v): ?><li><p><?php echo ($goods_attribute[$v[attr_id]]); ?>:</p><span><?php echo ($v[attr_value]); ?></span></li><?php endforeach; endif; ?>
           <li><p>上架时间：</p><span><?php echo (date('Y-m-d H:i',$goods["on_time"])); ?></span></li>
           <li></li>
        </ul>
    </section>
  </div>
  <div class="tab_attrs tab_item hide" id="user_goods_ka_3" style="display:none;"> 

<div id="ECS_COMMENT">
<link href="/Template/mobile/new/Static/css/photoswipe.css" rel="stylesheet" type="text/css">
<script src="/Template/mobile/new/Static/js/klass.min.js"></script> 
<script src="/Template/mobile/new/Static/js/photoswipe.js"></script>
    <div class="comment_littlenav">
        <ul id="fy-comment-list">
            <li class="com-red" data-id="1">全部评论<br/>(<?php echo ($commentStatistics['c0']); ?>)</li>
            <li data-id="2">好评<br/>(<?php echo ($commentStatistics['c1']); ?>)</li>
            <li data-id="3">中评<br/>(<?php echo ($commentStatistics['c2']); ?>)</li>
            <li data-id="4">差评<br/>(<?php echo ($commentStatistics['c3']); ?>)</li>
            <li data-id="5">晒单<br/>(<?php echo ($commentStatistics['c4']); ?>)</li>
        </ul>
    </div>
<div class="my_comment_list" id="ECS_MYCOMMENTS"> </div>

</div>
 	</div>
</div>
<script>
function goTop(){
	$('html,body').animate({'scrollTop':0},600);
}
</script> 
<a href="javascript:goTop();" class="gotop"><img src="/Template/mobile/new/Static/images/topup.png"></a>
<div style=" height:60px;"></div>
<div class="footer_nav">
  <ul>
    <li class="bian"><a href="<?php echo U('Index/index');?>"><em class="goods_nav1"></em><span>首页</span></a> </li>
    <li class="bian"><a href="tel:<?php echo ($tpshop_config['shop_info_phone']); ?>"><em class="goods_nav2"></em><span>客服</span></a> </li>
    <li><a href="javascript:collect_goods(<?php echo ($goods["goods_id"]); ?>)" id="favorite_add"><em class="goods_nav3"></em><span>收藏</span></a></li>
  </ul>
  <dl>
    <dd class="flow"><a class="button active_button" href="javascript:void(0);" onClick="AjaxAddCart(<?php echo ($goods["goods_id"]); ?>,1,0);">加入购物车</a> </dd>
    <dd class="goumai"><a style="display:block;" href="javascript:void(0);"  onclick="AjaxAddCart(<?php echo ($goods["goods_id"]); ?>,1,1);">立即购买</a> </dd>
  </dl>
</div>
<script type="text/javascript">
$(document).ready(function(){	
	// 更新商品价格
	get_goods_price();
});


function switch_spec(spec)
{
    $(spec).siblings().removeClass('hover');
    $(spec).addClass('hover');
	$(spec).siblings().children('input').prop('checked',false);
	$(spec).children('input').prop('checked',true);	
    //更新商品价格
    get_goods_price();
}

function get_goods_price()
{
	var goods_price = <?php echo ($goods["shop_price"]); ?>; // 商品起始价
	var store_count = <?php echo ($goods["store_count"]); ?>; // 商品起始库存	
	var spec_goods_price = <?php echo ($spec_goods_price); ?>;  // 规格 对应 价格 库存表   //alert(spec_goods_price['28_100']['price']);	
	// 如果有属性选择项
	if(spec_goods_price != null)
	{
		goods_spec_arr = new Array();
		// $("input[name^='goods_spec']:checked").each(function(){
		// 	 goods_spec_arr.push($(this).val());
		// });
        $(".spec-item > .spec-item-class > ul > li[class*=active]").each(function(){
            goods_spec_arr.push($(this).attr("value"));
        });
        var spec_key = goods_spec_arr.sort(sortNumber).join('_');  //排序后组合成 key
        console.log(spec_key);
		goods_price = spec_goods_price[spec_key]['price']; // 找到对应规格的价格		
		store_count = spec_goods_price[spec_key]['store_count']; // 找到对应规格的库存
	}
	// var goods_num = parseInt($("#goods_num").val());
    var goods_num = parseInt($("#buy_amount_show").text());
	// 库存不足的情况
	if(goods_num > store_count)
	{
	   goods_num = store_count;
	   alert('库存仅剩 '+store_count+' 件');
	   // $("#goods_num").val(goods_num);
        $("#buy_amount_show").text(goods_num);
	}
    var flash_sale_price = parseFloat("<?php echo ($goods['flash_sale']['price']); ?>");
    (flash_sale_price > 0) && (goods_price = flash_sale_price);
	// $("#goods_price").html('￥'+goods_price+'元'); // 变动价格显示
    $(".spec-goods-price > span").html('￥'+goods_price+'元'); // 变动价格显示

}

function sortNumber(a,b) 
{ 
	return a - b; 
}

// 好评差评 切换
$("#fy-comment-list").children().each(function(i,o){
    $(o).click(function(){
        $(o).siblings().removeClass('com-red');
        $(o).addClass('com-red');
        commentType = $(o).data('id');// 评价类型   好评 中评  差评
        ajaxComment(commentType,1);
    });
});

function ajaxComment(commentType,page){
    $.ajax({
        type : "GET",
        url:"/index.php?m=Mobile&c=goods&a=ajaxComment&goods_id=<?php echo ($goods['goods_id']); ?>&commentType="+commentType+"&p="+page,//+tab,
        success: function(data){
            $(".my_comment_list").empty().append(data);
            var myPhotoSwipe = $("#gallery a").photoSwipe({ 
        		enableMouseWheel: false, 
        		enableKeyboard: false, 
        		allowUserZoom: false, 
        		loop:false
        	});
        }
    });
}

$(document).ready(function(){
	  var cart_cn = getCookie('cn');
	  if(cart_cn == ''){
		$.ajax({
			type : "GET",
			url:"/index.php?m=Home&c=Cart&a=header_cart_list",//+tab,
			success: function(data){								 
				cart_cn = getCookie('cn');						
			}
		});	
	  }
	  $('#tp_cart_info').html(cart_cn);
});
</script>
<script src="/Public/js/jqueryUrlGet.js"></script><!--获取get参数插件-->
<script> set_first_leader(); //设置推荐人 </script>
<!-- 微信浏览器 调用微信 分享js-->
<?php if($signPackage != null): ?><script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
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
<!--微信关注提醒  end--><?php endif; ?>
<!-- 微信浏览器 调用微信 分享js  end-->





<script>
    /**
     *
     * @authors lwd (495986719@qq.com)
     * @date    2018-02-01 16:39:05
     * @version v.1.0.1
     * @params     {
                "btnName" : "imgs_ul",    //包含li->img标签的父元素，可以是id或者class
                "scaleSmall" : 1,        //手机，手动缩放图片的最小缩小倍数,默认1
                "scaleBig" : 4            //手机，手动缩放图片的最大放大倍数,默认4
            }
     */

    var showImagesFn = {
        "init" : function(json){
            this.btnName = json.btnName;
            this.scaleBig = json.scaleBig || 4;//最大放大倍数
            this.scaleSmall = json.scaleSmall || 1;//最小缩小倍数
            this.end = json.end || function(){};
            this.winWidth = $(window).width();
            this.winHeight = $(window).height();
            this.imgWrapWidth = $(window).width() > 640 ? 640 : $(window).width();
            this.index = 0;
            this.scaleArray = [];
            this.touchMethod = 0;
            this.showImagesContainer();
            return this;
        },
        "getUrls" : function(child){
            var lis = $(child).parent().find("li");
            var scope = this;
            lis.each(function(){
                var img = $(this).find("img");
                if (img.parent().hasClass("MIDIV")) {
                    var url = img.parent().attr("data-src");
                }else{
                    var url = $(this).find("img").attr("src");
                }
                scope.urls.push(url);
            });
            this.length = this.urls.length;
        },
        "setHtml" : function(){
            var section = $('<section style="position: fixed; width: 100%; height: 100%;bottom: -100%; z-index: 1001; left: 0;"></section>');
            this.section = section;
            this.cover = $('<div class="showImages_cover" style="position: fixed; width: 100%; height: 100%; z-index: 1000; background-color: #000; top: 0;"></div>');
            this.container = $('<div class="showImagesCotainer" style="position: absolute; top: -100%; height:100%; width: 100%; left: 0; z-index: 1001;"></div>');
            var head = $('<div class="showImagesHead" style="height: 44px; line-height: 44px; text-align: center; font-size: 14px; color: #fff; position: relative; z-index: 3;display: none"></div>');
            this.nowIndex = $('<span class="showImagesNowIndex" style="margin-right: 3px;">1</span>');
            this.totalImgs = $('<span class="showImagesTotalImgs" style="margin-left: 3px;"></span>');
            this.totalImgs.html(this.length);
            head.append(this.nowIndex);
            head.append("/");
            head.append(this.totalImgs);
            this.container.append(head);
            this.body = $('<div class="showImagesBody" style="position: absolute; z-index: 2; top: 0; bottom: 0; width: 100%;overflow:hidden;"></div>');
            var ul = $('<ul class="showImagesUl" style="position:absolute;height:100%;left:0;top:0;"></ul>');
            ul.css({
                "width" : this.winWidth * this.length
            });
            this.ul = ul;
            var prop = this.imgWrapWidth / this.winHeight;
            var scope = this;
            scope.loadImg(0);
            this.body.append(ul);
            this.container.append(this.body);
            section.append(this.cover);
            section.append(this.container);
            this.shutDown = $('<div class="showImagesShutDown"></div>');
            this.shutDown.css({
                "width": "30%",
                "height": "44px",
                "position": "absolute",
                "z-index": "1002",
                "left": "0",
                "top": "-100%",
                "display":"none"
            });
            var span = $('<span></span>')
            span.css({
                "display": "block",
                "width": "14px",
                "height": "14px",
                "border-left": "1px solid #fff",
                "border-top": "1px solid #fff",
                "transform": "rotate(-45deg)",
                "position": "absolute",
                "left": "14px",
                "top": "14px"
            });
            this.shutDown.append(span);
            section.append(this.shutDown);
            $(document.body).append(section);
            var scope = this;
            this.ul.on("touchstart",function(e){
                scope.slideTouchStart(e,scope);
            });
            this.ul.on("touchmove",function(e){
                scope.slideTouchMove(e,scope);
            });
            this.ul.on("touchend",function(e){
                scope.slideTouchEnd(e,scope);
            });
            this.ul.on("mousedown",function(e){
                scope.mouseDown(e,scope);
            });
            this.ul.on("mousemove",function(e){
                scope.mouseMove(e,scope);
            });
            this.ul.on("mouseup",function(e){
                var e = e || window.event;
                scope.mouseUp(e,scope);
                var upX = e.clientX;
                var upY = e.clientY;
                if (Math.abs(upX - scope.mouseX) < 1 && Math.abs(upY - scope.mouseY) < 1) {
                    scope.hideContainer();
                }
            });
        },
        "loadImg" : function(i){
            var scope = this;
            console.log(scope);
            var img = new Image();
            img.src = scope.urls[i];
            img.onerror = function(){
                if (WST) {
                    var bakSrc = WST.ROOT + "/Public/wap/images/loadFail.png";
                }else{
                    var bakSrc = "/Public/wap/images/loadFail.png";
                }
                scope.setLi(this,scope,bakSrc);
                if (i < scope.length - 1) {
                    scope.loadImg(i + 1);
                }
            }
            img.onload = function(){
                scope.setLi(this,scope);
                if (i < scope.length - 1) {
                    scope.loadImg(i + 1);
                }
            }
        },
        "setLi" : function(thisImg,scope,src){
            var width = thisImg.naturalWidth;
            var height = thisImg.naturalHeight;
            var li = $('<li style="float:left;"></li>');
            li.css({
                "width" : scope.winWidth,
                "height" : scope.winHeight,
                "position" : "relative",
                "display" : "-webkit-box",
                "vertical-align" : "middle",
                "-webkit-box-pack" : "center",
                "-webkit-box-align" : "center"
                // ,"-webkit-transform" : "scale(2)"
            });
            var imgElement = $("<img />");
            src = src || thisImg.src;
            imgElement.attr({"src" : src}).css({
                "max-width" : "100%",
                "max-height" : "100%",
                "display" : "block",
                "overflow": "hidden"
            });
            li.append(imgElement);
            scope.ul.append(li);
            scope.scaleArray.push(1);
        },
        "winResize" : function(){
            var scope = this;
            $(window).resize(function(){
                scope.winWidth = $(window).width();
                scope.winHeight = $(window).height();
                scope.imgWrapWidth = $(window).width() > 640 ? 640 : $(window).width();
                scope.ul.css({
                    "width" : scope.winWidth * scope.length,
                    "height" : scope.winHeight,
                    "left" : -scope.winWidth * scope.index
                });
                scope.ul.find("li").css({
                    "width" : scope.winWidth,
                    "height" : scope.winHeight
                });
            });
        },
        "showImagesContainer" : function(){
            var scope = this;
            var btn = $("#" + this.btnName).length > 0 ? "#" + this.btnName : "." + this.btnName;
            console.log(btn);
            var mouseMoveHappen = false;
            $(document).on("mousemove",function(){
                mouseMoveHappen = true;
            });
            $(document).on("mousedown",function(){
                mouseMoveHappen = false;
            });
            $(document).on("click",btn + " p",function(){
                scope.btnBom = $(this).closest(btn);
                if (!mouseMoveHappen) {
                    scope.urls = [];
                    $("#product_images p img").each(function(i,e){
                        scope.urls.push($(e).attr("src"));
                    });
                    scope.getUrls(this);


                    var prevP= $(this).prevAll("p");
                    var delCount=0;
                    prevP.each(function(i,e){
                        if($(e).find("img")[0]==undefined){
                            delCount++;
                        }
                    });
                    scope.index = $(this).index()-delCount;


                    var scrollTop = $(window).scrollTop();
                    var left = ($(window).width() - $(document.body).width()) / 2;
                    //$(document.body).css({"position":"fixed","top":"-" + scrollTop + "px","left" : left});
                    scope.setHtml();
                    scope.hideImagesContainer();
                    scope.ul.css({
                        "left" : -scope.winWidth * scope.index
                    });
                    scope.nowIndex.html(scope.index + 1);
                    scope.winResize();
                }
            });
        },
        "hideImagesContainer" : function(){
            var scope = this;
            this.shutDown.click(function(){
                scope.hideContainer();
            });
        },
        "hideContainer" : function(){
            var top = parseFloat($(document.body).offset().top);
            //$(document.body).css({"position":"initial"});
            //$(window).scrollTop(top);
            for (var i = 0; i < this.length; i++) {
                this.scaleArray[i] = 1;
            }
            this.section.remove();
            this.end && this.end(this.index,this.btnBom);
        },
        "slideTouchStart" : function(e,scope){
            var touch = e.originalEvent.changedTouches[0];
            scope.startX = touch.clientX;
            scope.startY = touch.clientY;
            scope.ulLeft = parseFloat(scope.ul.css("left"));
            scope.ulTop = parseFloat(scope.ul.css("top"));
            scope.touchMethod = 1;
            try {
                scope.dis = [];
            }catch (e) {
                alert('touchSatrtFunc：' + e.message);
            }
        },
        "mouseDown" : function(e,scope){
            var e = e || window.event;
            scope.mouseX = e.clientX;
            scope.mouseY = e.clientY;
            scope.ulLeft = parseFloat(scope.ul.css("left"));
            scope.ulTop = parseFloat(scope.ul.css("top"));
            scope.mouseStart = 1;
        },
        "mouseMove" : function(e,scope){
            var e = e || window.event;
            e.preventDefault();
            if (scope.mouseStart === 1) {
                scope.mX = e.clientX;
                scope.mY = e.clientY;
                var dx = scope.mX - scope.mouseX;
                var dy = scope.mY - scope.mouseY;
                var left;
                //过度距离
                var boundDis = 10;
                //超越距离
                var switchDis = 30;
                left = scope.ulLeft + dx;
                scope.ul.css({
                    "left" : left
                });
            }
        },
        "slideTouchMove" : function(e,scope){
            e.preventDefault();
            var evt = e.originalEvent;
            var touch = evt.touches[0];
            if (evt.touches.length === 1 && scope.touchMethod === 1) {
                scope.dX = touch.clientX;
                scope.dY = touch.clientY;
                var dx = scope.dX - scope.startX;
                var dy = scope.dY - scope.startY;
                var boundLeft = scope.winWidth * (scope.scaleArray[scope.index] - 1) / 2 - scope.winWidth * scope.index;
                var boundRight = -scope.winWidth * (scope.scaleArray[scope.index] - 1) / 2 - scope.winWidth * scope.index;
                var boundTop = scope.winHeight * (scope.scaleArray[scope.index] - 1) / 2;
                var left,top;
                //过度距离
                var boundDis = 10;
                //超越距离
                var switchDis = 30;
                if (scope.scaleArray[scope.index] > 1) {
                    if (scope.ulTop + dy >= boundTop + boundDis ) {
                        top = boundTop + boundDis;
                    }else if(scope.ulTop + dy <= -boundTop - boundDis){
                        top = -boundTop - boundDis;
                    }else{
                        top = scope.ulTop + dy;
                    }
                    if (scope.ulLeft + dx >= boundLeft + boundDis) {
                        //放大时向右滑
                        var bdx = scope.ulLeft + dx - ((boundLeft + boundDis));
                        left = boundLeft + boundDis + bdx / 10;
                        if (left > boundLeft + switchDis) {
                            scope.scaleArray[scope.index] = 1;
                            top = 0;
                            if (scope.index > 0) {
                                scope.ul.find("li").eq(scope.index - 1).css({
                                    "z-index" : 1
                                }).siblings().css({
                                    "webkitTransform" : 'scale(1)',
                                    "z-index" : 0
                                });
                            }
                        }
                    }else if(scope.ulLeft + dx <= boundRight - boundDis){
                        //放大时向左滑
                        var bdx = scope.ulLeft + dx - (boundRight - boundDis);
                        left = boundRight - boundDis + bdx / 10;
                        if (left < boundRight - switchDis) {
                            scope.scaleArray[scope.index] = 1;
                            top = 0;
                            if (scope.index < scope.length - 1) {
                                scope.ul.find("li").eq(scope.index + 1).css({
                                    "z-index" : 1
                                }).siblings().css({
                                    "webkitTransform" : 'scale(1)',
                                    "z-index" : 0
                                });
                            }
                        }
                    }else{
                        left = scope.ulLeft + dx;
                    }
                    scope.ul.css({
                        "top" : top
                    });
                    scope.ul.css({
                        "left" : left
                    });
                }else{
                    left = scope.ulLeft + dx;
                    scope.ul.css({
                        "left" : left
                    });
                }
            }else if(evt.touches.length === 2){
                scope.touchMethod = 2;
                try {
                    var x = Number(touch.clientX); //页面触点X坐标
                    var y = Number(touch.clientY); //页面触点Y坐标
                    if (evt.targetTouches.length == 2) {
                        var touch1 = evt.targetTouches[1]; //获取第2个触点
                        var x1 = Number(touch1.clientX); //页面触点X坐标
                        var y1 = Number(touch1.clientY); //页面触点Y坐标
                        scope.dis.push(Math.sqrt(Math.pow(x - x1, 2) + Math.pow(y - y1, 2)));
                        if (scope.dis.length > 1) {
                            scope.scaleArray[scope.index] -= 0.05 * (scope.dis[scope.dis.length - 2] - scope.dis[scope.dis.length - 1]);
                            if (scope.scaleArray[scope.index] < scope.scaleSmall) {
                                scope.scaleArray[scope.index] = scope.scaleSmall;
                            }
                            if(scope.scaleArray[scope.index] > scope.scaleBig){
                                scope.scaleArray[scope.index] = scope.scaleBig;
                            }
                            scope.ul.find("li").eq(scope.index).css({
                                "webkitTransform" : 'scale(' + scope.scaleArray[scope.index] + ')',
                                "z-index": 1
                            }).siblings().css({
                                "z-index" : 0
                            });
                        }
                    }
                }catch (e) {
                    alert('touchMoveFunc：' + e.message);
                }
            }
        },
        "mouseUp" : function(e,scope){
            var e = e || window.event;
            var evt = e.originalEvent;
            scope.endX = e.clientX;
            var dx = scope.endX - scope.mouseX;
            if (Math.abs(dx) / scope.imgWrapWidth < 0.1) {
                scope.ul.stop().animate({
                    "left" : -scope.winWidth * scope.index
                },200);
            }else{
                if (dx > 0) {
                    if (scope.index === 0) {
                        scope.ul.stop().animate({
                            "left" : -scope.winWidth * scope.index
                        },200,moveEnd);
                    }else{
                        scope.ul.stop().animate({
                            "left" : -scope.winWidth * (scope.index - 1)
                        },200,function(){
                            if (scope.index > 0) {
                                scope.index --;
                                scope.nowIndex.html(scope.index + 1);
                            }
                            moveEnd();
                        });
                    }
                }else{
                    if (scope.index === (scope.length - 1)) {
                        scope.ul.stop().animate({
                            "left" : -scope.winWidth * scope.index
                        },200,moveEnd);
                    }else{
                        scope.ul.stop().animate({
                            "left" : -scope.winWidth * (scope.index + 1)
                        },200,function(){
                            if (scope.index < scope.length - 1) {
                                scope.index ++;
                                scope.nowIndex.html(scope.index + 1);
                                moveEnd();
                            }
                        });
                    }
                }
            }
            scope.mouseStart = 0;
            function moveEnd(){
                scope.ul.find("li").eq(scope.index).css({
                    "z-index" : 1
                }).siblings().css({
                    "z-index" : 0
                });
            }
        },
        "slideTouchEnd" : function(e,scope){
            var evt = e.originalEvent;
            var touch = evt.changedTouches[0];
            if (scope.scaleArray[scope.index] > 1) {
                try {
                    e.preventDefault(); //阻止触摸时浏览器的缩放、滚动条滚动
                }catch (e) {
                    alert('touchEndFunc：' + e.message);
                }
            }else{
                scope.endX = touch.clientX;
                var dx = scope.endX - scope.startX;
                if (Math.abs(dx) / scope.imgWrapWidth < 0.05) {
                    scope.ul.stop().animate({
                        "left" : -scope.winWidth * scope.index,
                        "top" : 0
                    },200);
                }else{
                    if (dx > 0) {
                        if (scope.index === 0) {
                            scope.ul.stop().animate({
                                "left" : -scope.winWidth * scope.index
                            },200,moveEnd);
                        }else{
                            scope.ul.stop().animate({
                                "left" : -scope.winWidth * (scope.index - 1)
                            },200,function(){
                                if (scope.index > 0) {
                                    scope.index --;
                                    scope.nowIndex.html(scope.index + 1);
                                }
                                moveEnd();
                            });
                        }
                    }else{
                        if (scope.index === (scope.length - 1)) {
                            scope.ul.stop().animate({
                                "left" : -scope.winWidth * scope.index
                            },200,moveEnd);
                        }else{
                            scope.ul.stop().animate({
                                "left" : -scope.winWidth * (scope.index + 1)
                            },200,function(){
                                if (scope.index < scope.length - 1) {
                                    scope.index ++;
                                    scope.nowIndex.html(scope.index + 1);
                                    moveEnd();
                                }
                            });
                        }
                    }
                }
            }
            function moveEnd(){
                for (var i = 0; i < scope.length; i++) {
                    if (i !== scope.index) {
                        scope.scaleArray[i] = 1;
                    }
                    scope.ul.find("li").eq(i).css({
                        "webkitTransform" : 'scale(' + scope.scaleArray[i] + ')'
                    });
                }
                scope.ul.find("li").eq(scope.index).css({
                    "z-index" : 1
                }).siblings().css({
                    "z-index" : 0
                });
            }
        }
    };
</script>
<script>

    showImagesFn.init({
        "btnName" : "product_images",
        "end" : function(index,wrapper){
            wrapper.siblings(".img_percent").find("span").eq(0).html(index + 1);
            var width = wrapper.find("li").width();
            wrapper.find("ul").css("margin-left" , - index * width).attr("data-index" , index);
        }
    });
</script>
<!-------------------------------------->
<!-- 新添加规格选择弹出层-样式 -->
<style>
    body{
        position: relative;
    }
    .clear::after {
        content: "";
        display: block;
        width: 0;
        height: 0;
        overflow: hidden;
        clear: both;
    }

    a {
        -webkit-tap-highlight-color: transparent;
    }

    .t_overflow {
        text-overflow: ellipsis;
        white-space: nowrap;
        overflow: hidden;
    }

    .main {
        position: relative;
    }

    .spec-select-content {
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        position: fixed;
        bottom: 51px;
        left: 0;
        z-index: 999;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        min-width: 320px;
        max-width: 640px;
        -webkit-user-select: none;
        -ms-user-select: none;
        -moz-user-select: none;
        user-select: none;
        display: none;
    }

    .spec-select-content>.spec-select-container {
        width: 100%;
        background: #fff;
        height: 75%;
        position: absolute;
        bottom: 0;
        left: 0;
        border-top-left-radius: 10px;
        -webkit-border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        -webkit-border-top-right-radius: 10px;
        padding: 12px;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        overflow: scroll;
    }

    .spec-select-content>.spec-select-container>.spec-info {
        width: 100%;
        height: 125px;
        /* background: red; */
    }

    .spec-select-content>.spec-select-container>.spec-info>.spec-goods-img {
        height: 125px;
        width: 125px;
        /* background: #25C6FC; */
        float: left;
    }

    .spec-select-content>.spec-select-container>.spec-info>.spec-goods-img img {
        width: 100%;
        display: block;
    }

    .spec-select-content>.spec-select-container>.spec-info>.spec-price-stock {
        margin-left: 125px;
        height: 100%;
        position: relative;
        padding-left: 3%;
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        overflow: hidden;
    }

    .spec-select-content>.spec-select-container>.spec-info>.spec-price-stock>.spec-close {
        width: 20px;
        height: 20px;
        position: absolute;
        background: url(/Template/mobile/new/Static/images/spec-close.svg) no-repeat;
        background-size: 100%;
        background-position: 0 0;
        right: 0;
        top: 0;
    }

    .spec-select-content>.spec-select-container>.spec-info>.spec-price-stock p {
        margin-top: 20px;
    }

    .spec-select-content>.spec-select-container>.spec-info>.spec-price-stock>.spec-goods-price {
        color: rgb(254, 78, 0);
        font-weight: 600;
        font-size: 22px;
    }

    .spec-select-content>.spec-select-container>.spec-info>.spec-price-stock>.spec-goods-stock {
        color: rgb(146, 146, 146);
    }

    .spec-select-content>.spec-select-container>.spec-item-box {
        width: 100%;
        margin-top: 10px;
    }

    .spec-select-content>.spec-select-container>.spec-item-box>.spec-item {
        width: 100%;
        margin-top: 10px;
    }

    .spec-select-content>.spec-select-container>.spec-item-box>.spec-item>.spec-item-class {
        width: 100%;
    }

    .spec-select-content>.spec-select-container>.spec-item-box>.spec-item>.spec-item-class ul {
        width: 100%;
    }

    .spec-select-content>.spec-select-container>.spec-item-box>.spec-item>.spec-item-class ul li {
        float: left;
        line-height: 30px;
        height: 30px;
        padding: 0 10px;
        background: rgb(245, 245, 245);
        border-radius: 10px;
        -webkit-border-radius: 10px;
        margin-top: 10px;
        margin-right: 10px;
        border: 1px solid rgb(245, 245, 245);
        color: rgb(80, 80, 80);
    }

    .spec-select-content>.spec-select-container>.spec-item-box>.spec-item>.spec-item-class ul li.active {
        border-color: rgb(222, 91, 29);
        color: rgb(222, 91, 29);
        background: rgb(255, 249, 249);
    }

    .spec-select-content>.spec-select-container>.spce-buy-amount {
        height: 53px;
        width: 100%;
        border-top: 1px solid rgb(245, 245, 245);
        border-bottom: 1px solid rgb(245, 245, 245);
        margin-top: 20px;
    }

    .spec-select-content>.spec-select-container>.spce-buy-amount>.spec-buy-amount-title {
        float: left;
        height: 100%;
        line-height: 53px;
        font-weight: 600;
        padding: 0 5px;
    }

    .spec-select-content>.spec-select-container>.spce-buy-amount>.spec-buy-amount-operate {
        float: right;
        height: 25px;
        line-height: 25px;
        margin-top: 15px;
    }

    .spec-select-content>.spec-select-container>.spce-buy-amount>.spec-buy-amount-operate a {
        color: rgb(144, 144, 144);
        float: left;
        display: block;
        height: 100%;
        padding: 0 10px;
        font-size: 16px;
        background: rgb(245, 245, 245);
        font-size: 16px;
        margin-right: 1px;
    }

    .spec-select-content>.spec-select-container>.spec-item-box>.spec-item.spec-main img {
        height: 50%;
        margin-right: 3px;
        vertical-align: text-top;
    }
</style>
<!-- 新添加规格选择弹出层-脚本 -->
<script>
    $(function() {
        specItemClick();
        buyAmountClick();
        openCloseSpecLayer();
    });
    //分类项点击事件
    function specItemClick() {
        let specItem = $(".spec-select-content > .spec-select-container > .spec-item-box > .spec-item");
        specItem.each((i, e) => {
            let ele = $(e);
            //如果是主类被点击
            if (ele.attr("class").indexOf("spec-main") >= 1) {
                ele.find(".spec-item-class > ul > li").on("click", (e) => {
                    let target = $(e.srcElement);
                    let bigImage = target.attr("big-image");
                    target.parent().find("li").removeClass("active");
                    target.addClass("active");
                    //更换首图片
                    if(bigImage){
                        $("#master_map").attr("src", bigImage);
                    }

                    //更新商品价格
                    get_goods_price();
                });
            } else {
                ele.find(".spec-item-class > ul > li").on("click", (e) => {
                    let target = $(e.srcElement);
                    target.parent().find("li").removeClass("active");
                    target.addClass("active");
                    //更新商品价格
                    get_goods_price();
                });
            }
        });
    }
    //购买数量增减
    function buyAmountClick() {
        let specItem = $(".spec-select-content > .spec-select-container > .spce-buy-amount > .spec-buy-amount-operate");
        let buy_amount_show = specItem.find("#buy_amount_show");
        //减
        specItem.find("#buy_amount_reduce").on("click", (e) => {
            let amount = parseInt(buy_amount_show.text());
            if (amount == 0) {
                return
            }
            buy_amount_show.text((amount - 1));
        });
        //加
        specItem.find("#buy_amount_add").on("click", () => {
            let amount = parseInt(buy_amount_show.text());
            let spec_goods_stock= parseInt($('.spec-goods-stock > span').text());
            //若大于库存则不增加
            if(amount >= spec_goods_stock){
                return
            }
            buy_amount_show.text((amount + 1));
        });
    }
    // 打开-关闭商品分类层
    function openCloseSpecLayer() {
        //关闭
        $("#spec_close").on("click", (e) => {
            $("html,body").css("overflow", "scroll");
            let spec_select_content = $("#spec_select_content");
            spec_select_content.find("#spec_select_container").stop().hide(200, () => {
                spec_select_content.stop().hide();
            });
        });
        //打开
        //,.subNav
        $(".subNav").on("click", (e) => {
            $("html,body").css("overflow", "hidden");
            let spec_select_content = $("#spec_select_content");
            spec_select_content.css("display", "block");
            spec_select_content.stop().find("#spec_select_container").show(200);
        });
    }
</script>
<!-- 新添加规格选择弹出层 -->
<div class="spec-select-content" id="spec_select_content">
    <input type="hidden" id="goods_id" value="<?php echo ($goods["goods_id"]); ?>"/>
    <div class="spec-select-container" id="spec_select_container">
        <div class="spec-info">
            <div class="spec-goods-img">
                <img src="<?php echo ($goods_images_list[0]["image_url"]); ?>" id="master_map" alt="">
            </div>
            <div class="spec-price-stock">
                <p class="spec-goods-price t_overflow"><span><?php echo ($goods["shop_price"]); ?></span></p>
                <p class="spec-goods-stock">库存&nbsp;<span><?php echo ($goods["store_count"]); ?></span>&nbsp;<span>件</span></p>
                <i class="spec-close" id="spec_close"></i>
            </div>
        </div>
        <div class="spec-item-box">

            <?php if(is_array($filter_spec)): foreach($filter_spec as $key=>$spec): ?><div class="spec-item spec-main">
                    <p class="spec-item-title"><?php echo ($key); ?></p>
                    <div class="spec-item-class">
                        <ul class="clear">
                            <?php if(is_array($spec)): foreach($spec as $k2=>$v2): ?><!--img-->
                                <li name="goods_spec[<?php echo ($key); ?>]" <?php if($v2[src]): ?>big-image="<?php echo ($v2[src]); ?>"<?php endif; ?> title="<?php echo ($v2[item]); ?>" value="<?php echo ($v2[item_id]); ?>" <?php if($k2 == 0): ?>class="active"<?php endif; ?>>   <?php if($v2[src]): ?><img src="<?php echo ($v2[src]); ?>" alt=""><?php endif; ?>  <?php echo ($v2[item]); ?></li><?php endforeach; endif; ?>
                        </ul>
                    </div>
                </div><?php endforeach; endif; ?>


            <!--<div class="spec-item spec-main">-->
                <!--<p class="spec-item-title">颜色分类</p>-->
                <!--<div class="spec-item-class">-->
                    <!--<ul class="clear">-->
                        <!--<li class="active" big-image="shead.jpg"><img src="shead.jpg" alt="">红色</li>-->
                        <!--<li big-image="2.jpg"><img src="2.jpg" alt="">红色</li>-->
                    <!--</ul>-->
                <!--</div>-->
            <!--</div>-->
            <!--<div class="spec-item">-->
                <!--<p class="spec-item-title">颜色分类</p>-->
                <!--<div class="spec-item-class">-->
                    <!--<ul class="clear">-->
                        <!--<li class="active">红色</li>-->
                        <!--<li>红色</li>-->
                        <!--<li>红色</li>-->
                        <!--<li>红色</li>-->
                        <!--<li>红色</li>-->
                        <!--<li>红色</li>-->
                        <!--<li>红色</li>-->
                        <!--<li>红色</li>-->
                    <!--</ul>-->
                <!--</div>-->
            <!--</div>-->

        </div>
        <div class="spce-buy-amount">
            <div class="spec-buy-amount-title">购买数量</div>
            <div class="spec-buy-amount-operate">
                <a href="javascript:;" id="buy_amount_reduce">-</a>
                <a href="javascript:;" style="color: #42403F;" id="buy_amount_show">1</a>
                <a href="javascript:;" id="buy_amount_add">+</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>