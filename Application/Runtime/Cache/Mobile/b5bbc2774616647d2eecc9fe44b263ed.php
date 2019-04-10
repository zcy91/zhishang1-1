<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>首页-<?php echo ($tpshop_config['shop_info_store_title']); ?></title>
<meta http-equiv="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>" />
<meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/public.css"/>
<link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/css/index.css"/>
<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/TouchSlide.1.1.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.json.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/touchslider.dev.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/layer.js" ></script>
<script src="/Public/js/global.js"></script>
<script src="/Public/js/mobile_common.js"></script>
</head>
<body>
<div id="page" class="showpage"><div>
<header id="header"> 
<a href="<?php echo U('Cart/cart');?>" class='user_btn' style="left:0px"></a>
<div class="h-right" style="position:absolute; right:0px">
      <aside class="top_bar">
        <div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more" style="background-position:0px -35px;background-size:auto 280px; height:30px"><a href="javascript:;"></a> </div>
      </aside>
</div> 
<span href="javascript:void(0)" class="logo"><?php echo ($tpshop_config['shop_info_store_name']); ?></span> 
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

<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.SuperSlide.2.1.1.js"></script>
  <!--公告start-->
     <div class="notice">
		<div class="m_cell_hd"><b>公告</b></div>
		<div class="m_cell_hd"><i></i></div>
		<div class="m_cell_ft m_cell_primary">
		  <div class="notice_list">
		    <div class="bd">
			    <div class="tempWrap" style="overflow:hidden; position:relative; height:44px">
                   <ul style="top: -44px; position: relative; padding: 0px; margin: 0px;">
                  <?php
 $md5_key = md5("SELECT * FROM `__PREFIX__article` where cat_id =4 and is_open=1 ORDER BY article_id asc"); $result_name = $sql_result_v = S("sql_".$md5_key); if(empty($sql_result_v)) { $Model = new \Think\Model(); $result_name = $sql_result_v = $Model->query("SELECT * FROM `__PREFIX__article` where cat_id =4 and is_open=1 ORDER BY article_id asc"); S("sql_".$md5_key,$sql_result_v,1); } foreach($sql_result_v as $k=>$v): ?><li><a href="<?php echo U('Article/index',array('article_id'=>$v["article_id"]));?>" title="<?php echo ($v[title]); ?>"><?php echo ($v[title]); ?><em>[查看详情]</em></a></li><?php endforeach; ?> 
			       </ul>
                </div>
		    </div>
			</div>
		</div>
	</div>
  <!--公告end-->
<div id="scrollimg" class="scrollimg">
  <div class="bd">
	 <ul>
        <li>
           <img src="/Template/mobile/new/Static/images/storebg.jpg" id="img" style="width:100%"/>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="index_dl">
  <tr>
    <td height="25%" align="left" valign="middle" style="text-indent:15px; font-size:1.1em"><span style="float:right; font-size:2.em; margin-right:15px">增长位数：<i style=" color:#FD0303; font-size:25px" class="ziti"><?php echo ($jinchi["bili"]/100); ?></i>倍</span>热钱包奖金池：</td>
  </tr>
  <tr>
    <td height="32.5%"  align="center" valign="middle" ><small style="font-size:3.2em; color:#FD0303;text-shadow:0 0 0.2em #474313,-0 -0 0.2em #474313;" class="ziti"><?php echo ($jifeng_sum); ?></small><span style="font-size:.3em; color:#fff; padding-left:8px">(<?php echo tpCache('distribut.jifeng_name');?>)</span></td>
  </tr>
  <tr>
    <td height="32.5%" align="center" valign="middle">下一目标：<small style="font-size:2em; color:#FD0303;text-shadow:0 0 0.2em #474313,-0 -0 0.2em #474313;" class="ziti"><?php echo ($jinchi["jifeng"]); ?></small></td>
  </tr>
  <tr>
    <td height="10%" valign="middle" style="text-indent:15px; font-size:0.6em"></td>
  </tr>
</table>
        </li>
	 	<?php $pid =2;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->getField("position_id,position_name,ad_width,ad_height");$result = D("ad")->where("pid=$pid  and enabled = 1 and start_time < 1554861600 and end_time > 1554861600 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("5")->select(); $c = 5- count($result); if($c > 0 && $_GET[edit_ad]) { for($i = 0; $i < $c; $i++) { $result[] = array( "ad_code" => "/Public/images/not_adv.jpg", "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid", "title" =>"暂无广告图片", "not_adv" => 1, "target" => 0, ); } } foreach($result as $key=>$v): $v[position] = $ad_position[$v[pid]]; if($_GET[edit_ad] && $v[not_adv] == 0 ) { $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]"; $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name]; $v[target] = 0; } ?><li><a href="<?php echo ($v["ad_link"]); ?>" <?php if($v['target'] == 1): ?>target="_blank"<?php endif; ?> ><img src="<?php echo ($v[ad_code]); ?>" title="<?php echo ($v[title]); ?>" width="100%" style="<?php echo ($v[style]); ?>;"/></a></li><?php endforeach; ?>                        
     </ul>
  </div>
  <div class="hd">
	<ul></ul>
  </div>
</div>
<script type="text/javascript" src="/Template/mobile/new/Static/js/up/scroll.js"></script>
<script type="text/javascript">
var tab_height=$('#img').height();
$('.index_dl').height(tab_height-10);
	TouchSlide({ 
		slideCell:"#scrollimg",
		titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
		mainCell:".bd ul", 
		effect:"leftLoop", 
		autoPage:true,//自动分页
		autoPlay:true, //自动播放
		interTime:5000
	});

$(document).ready(function(){
    jQuery(".notice_list").slide({titCell:".hd ul",mainCell:".bd ul",autoPage:true,effect:"top",autoPlay:true});		
	$('.list_lh li:even').addClass('lieven');
	$(".list_lh").myScroll({
		speed:40, //数值越大，速度越慢
		rowHeight:35 //li的高度
	});
});
</script>
		<div class="list_lh">
			<ul>
             <?php if(is_array($a_list)): foreach($a_list as $key=>$vo): ?><li>
					<a><?php echo (jifeng_replace(trim($vo["desc"]))); ?></a><?php echo (mb_substr(get_replace_xing($vo["nickname"]),0,4,"utf-8")); ?><span><?php echo (date('H:i:s',$vo["change_time"])); ?></span><em><?php echo ($vo["money"]); ?></em>
				</li><?php endforeach; endif; ?>
			</ul>
		</div>
<div id="fake-search" class="index_search">
  <div class="index_search_mid">
  <span><img src="/Template/mobile/new/Static/images/xin/icosousuo.png"></span>
    <input  type="text" id="search_text" class="search_text" value="请输入您所搜索的商品或店铺"/>
  </div>
</div>
<div class="entry-list clearfix">
	<nav>
		<ul>
      <?php
 $md5_key = md5("SELECT * FROM `__PREFIX__wapnavigation` where is_show = 1 and lei=1 ORDER BY sort asc"); $result_name = $sql_result_v = S("sql_".$md5_key); if(empty($sql_result_v)) { $Model = new \Think\Model(); $result_name = $sql_result_v = $Model->query("SELECT * FROM `__PREFIX__wapnavigation` where is_show = 1 and lei=1 ORDER BY sort asc"); S("sql_".$md5_key,$sql_result_v,1); } foreach($sql_result_v as $k=>$v): ?><li class="nav-item">
				<a href="<?php echo ($v[url]); ?>" style="width:<?php if(count($sql_result_v) > 8): ?>20%<?php else: ?>25%<?php endif; ?>" <?php if($v["is_new"] == 1): ?>target="_blank"<?php endif; ?>>
					<img alt="<?php echo ($v[name]); ?>" src="<?php echo ($v[img]); ?>"  onerror="this.src='/Public/images/bg-upload.png'"/>
					<span><?php echo ($v[name]); ?></span>
				</a>
			</li><?php endforeach; ?>        
        </ul>
	</nav>
</div>

<div class="floor_images">
	<strong>
            <?php $pid =1;$ad_position = M("ad_position")->cache(true,TPSHOP_CACHE_TIME)->getField("position_id,position_name,ad_width,ad_height");$result = D("ad")->where("pid=$pid  and enabled = 1 and start_time < 1554861600 and end_time > 1554861600 ")->order("orderby desc")->cache(true,TPSHOP_CACHE_TIME)->limit("4")->select(); $c = 4- count($result); if($c > 0 && $_GET[edit_ad]) { for($i = 0; $i < $c; $i++) { $result[] = array( "ad_code" => "/Public/images/not_adv.jpg", "ad_link" => "/index.php?m=Admin&c=Ad&a=ad&pid=$pid", "title" =>"暂无广告图片", "not_adv" => 1, "target" => 0, ); } } foreach($result as $key=>$v): $v[position] = $ad_position[$v[pid]]; if($_GET[edit_ad] && $v[not_adv] == 0 ) { $v[style] = "filter:alpha(opacity=50); -moz-opacity:0.5; -khtml-opacity: 0.5; opacity: 0.5"; $v[ad_link] = "/index.php?m=Admin&c=Ad&a=ad&act=edit&ad_id=$v[ad_id]"; $v[title] = $ad_position[$v[pid]][position_name]."===".$v[ad_name]; $v[target] = 0; } ?><a href="<?php echo ($v["ad_link"]); ?>"  style="margin:0px; display:inline-block;" <?php if($v['target'] == 1): ?>target="_blank"<?php endif; ?> >
                <img src="<?php echo ($v[ad_code]); ?>" title="<?php echo ($v[title]); ?>" style="<?php echo ($v[style]); ?>" border="0"  onerror="this.src='/Public/images/bg-upload.png'">
              </a><?php endforeach; ?>
    </strong>
</div>
 
<section class="index_floor">
  <div class="floor_body1">
    <h2><em></em>精品推荐
        <!--<div class="geng"> <a href="<?php echo U('Goods/search',array('q'=>'精品'));?>">更多</a> <span></span></div>-->
    </h2>
    <div id="scroll_best" class="scroll_hot">
      <div class="bd">
        <ul>
        <?php $fl = '1'; ?>
         <?php
 $md5_key = md5("select a.*,b.is_new as display from __PREFIX__wapnavigation as b,__PREFIX__goods as a where  b.lei=4 and b.is_show=1 and b.goods_id=a.goods_id  and  a.is_on_sale = 1 and a.goods_state = 1 order by b.sort asc limit 9"); $result_name = $sql_result_v = S("sql_".$md5_key); if(empty($sql_result_v)) { $Model = new \Think\Model(); $result_name = $sql_result_v = $Model->query("select a.*,b.is_new as display from __PREFIX__wapnavigation as b,__PREFIX__goods as a where  b.lei=4 and b.is_show=1 and b.goods_id=a.goods_id  and  a.is_on_sale = 1 and a.goods_state = 1 order by b.sort asc limit 9"); S("sql_".$md5_key,$sql_result_v,1); } foreach($sql_result_v as $k=>$v): ?><li>
            <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id]));?>" title="<?php echo ($v["goods_name"]); ?>" <?php if($v['display'] == 1): ?>target="_blank"<?php endif; ?>>
             <div class="index_pro"> 
	              <div class="products_kuang"><img src="<?php echo (goods_thum_images($v["goods_id"],400,400)); ?>"  onerror="this.src='/Public/images/bg-upload.png'"></div>
	              <div class="goods_name"><?php echo (mb_substr($v["goods_name"],0,20,'utf-8')); ?></div>
	              <div class="price">
	                 <a href="javascript:AjaxAddCart(<?php echo ($v[goods_id]); ?>,1,0);" class="btns"><img src="/Template/mobile/new/Static/images/index_flow.png" ></a>
	                 <span href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id]));?>" class="price_pro">￥<?php echo ($v["shop_price"]); ?>元</span>
	              </div>
             </div>
            </a>
           </li>
           <?php if(($fl++%3 == 0) && ($fl < 9)): ?></ul><ul><?php endif; endforeach; ?>
           </ul>
       </div>
       <div class="hd">
          <ul></ul>
       </div>
      </div>
    </div>
  </section>
  <script type="text/javascript">
    TouchSlide({ 
      slideCell:"#scroll_best",
      titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
      effect:"leftLoop", 
      autoPage:true, //自动分页
      //switchLoad:"_src" //切换加载，真实图片路径为"_src" 
    });
  </script>
<section class="index_floor">
  <div class="floor_body1" >
    <h2>
      <em></em>
      新品上市
        <!--<div class="geng"><a href="<?php echo U('Goods/search',array('q'=>'新品'));?>" >更多</a> <span></span></div>-->
    </h2>
    <div id="scroll_new" class="scroll_hot">
      <div class="bd">
        <ul>
        <?php $fl = '1'; ?>
         <?php
 $md5_key = md5("select a.*,b.is_new as display from __PREFIX__wapnavigation as b,__PREFIX__goods as a where  b.lei=5 and b.is_show=1 and b.goods_id=a.goods_id  and  a.is_on_sale = 1 and a.goods_state = 1 order by b.sort asc limit 9"); $result_name = $sql_result_v = S("sql_".$md5_key); if(empty($sql_result_v)) { $Model = new \Think\Model(); $result_name = $sql_result_v = $Model->query("select a.*,b.is_new as display from __PREFIX__wapnavigation as b,__PREFIX__goods as a where  b.lei=5 and b.is_show=1 and b.goods_id=a.goods_id  and  a.is_on_sale = 1 and a.goods_state = 1 order by b.sort asc limit 9"); S("sql_".$md5_key,$sql_result_v,1); } foreach($sql_result_v as $k=>$v): ?><li>
            <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id]));?>" title="<?php echo ($v["goods_name"]); ?>" <?php if($v['display'] == 1): ?>target="_blank"<?php endif; ?>>
             <div class="index_pro"> 
	              <div class="products_kuang"><img src="<?php echo (goods_thum_images($v["goods_id"],400,400)); ?>"  onerror="this.src='/Public/images/bg-upload.png'"></div>
	              <div class="goods_name"><?php echo (mb_substr($v["goods_name"],0,20,'utf-8')); ?></div>
	              <div class="price">
	                 <a href="javascript:AjaxAddCart(<?php echo ($v[goods_id]); ?>,1,0);" class="btns"><img src="/Template/mobile/new/Static/images/index_flow.png"></a>
	                 <span href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id]));?>" class="price_pro">￥<?php echo ($v["shop_price"]); ?>元</span>
	              </div>
             </div>
            </a>
           </li>
           <?php if(($fl++%3 == 0) && ($fl < 9)): ?></ul><ul><?php endif; endforeach; ?></ul>
        </div>
        <div class="hd">
          <ul></ul>
        </div>
      </div>
    </div>
  </section>
  <script type="text/javascript">
    TouchSlide({ 
      slideCell:"#scroll_new",
      titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
      effect:"leftLoop", 
      autoPage:true, //自动分页
      //switchLoad:"_src" //切换加载，真实图片路径为"_src" 
    });
  </script>
<section class="index_floor">
  <div class="floor_body1" >
    <h2><em></em>热销商品
        <!--<div class="geng"><a href="<?php echo U('Goods/search',array('q'=>'热销'));?>" >更多</a> <span></span></div>-->
    </h2>
    <div id="scroll_hot" class="scroll_hot">
      <div class="bd">
        <ul>
        <?php $fl = '1'; ?>
         <?php
 $md5_key = md5("select a.*,b.is_new as display from __PREFIX__wapnavigation as b,__PREFIX__goods as a where  b.lei=6 and b.is_show=1 and b.goods_id=a.goods_id  and  a.is_on_sale = 1 and a.goods_state = 1 order by b.sort asc limit 9"); $result_name = $sql_result_v = S("sql_".$md5_key); if(empty($sql_result_v)) { $Model = new \Think\Model(); $result_name = $sql_result_v = $Model->query("select a.*,b.is_new as display from __PREFIX__wapnavigation as b,__PREFIX__goods as a where  b.lei=6 and b.is_show=1 and b.goods_id=a.goods_id  and  a.is_on_sale = 1 and a.goods_state = 1 order by b.sort asc limit 9"); S("sql_".$md5_key,$sql_result_v,1); } foreach($sql_result_v as $k=>$v): ?><li>
            <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id]));?>" title="<?php echo ($v["goods_name"]); ?>" <?php if($v['display'] == 1): ?>target="_blank"<?php endif; ?>>
             <div class="index_pro"> 
	              <div class="products_kuang"><img src="<?php echo (goods_thum_images($v["goods_id"],400,400)); ?>"  onerror="this.src='/Public/images/bg-upload.png'"></div>
	              <div class="goods_name"><?php echo (mb_substr($v["goods_name"],0,20,'utf-8')); ?></div>
	              <div class="price">
	                 <a href="javascript:AjaxAddCart(<?php echo ($v[goods_id]); ?>,1,0);" class="btns"><img src="/Template/mobile/new/Static/images/index_flow.png"></a>
	                 <span href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id]));?>" class="price_pro">￥<?php echo ($v["shop_price"]); ?>元</span>
	              </div>
              </div>
            </a>
           </li>
           <?php if(($fl++%3 == 0) && ($fl < 9)): ?></ul><ul><?php endif; endforeach; ?></ul>
          </div>
        <div class="hd">
          <ul></ul>
        </div>
      </div>
    </div>
  </section>
  <script type="text/javascript">
    TouchSlide({ 
      slideCell:"#scroll_hot",
      titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
      effect:"leftLoop", 
      autoPage:true, //自动分页
      //switchLoad:"_src" //切换加载，真实图片路径为"_src" 
    });
  </script>
<script type="text/javascript">
	TouchSlide({ 
		slideCell:"#index_banner",
		titCell:".hd ul", //开启自动分页 autoPage:true ，此时设置 titCell 为导航元素包裹层
		mainCell:".bd ul", 
		effect:"leftLoop", 
		autoPage:true,//自动分页
		autoPlay:true //自动播放
	});
</script>
   
<script type="text/javascript">
var url = "index.php?m=Mobile&c=Index&a=ajaxGetMore";
$(function(){
	//$('#J_ItemList').more({'address': url});
	getGoodsList();

});
var page = 1;
function getGoodsList(){
	$('.get_more').show();
	$.ajax({
		type : "get",
		url:"/index.php?m=Mobile&c=Index&a=ajaxGetMore&p="+page,
		dataType:'html',
		success: function(data)
		{
			if(data){
				$("#J_ItemList>ul").append(data);
                var img_miss_src = "/Template/mobile/new/Static";
                $(".products_kuang img").each(function (i,e) {
                    var _this = $(e);
                    if(!_this.attr("src")){
                        _this.attr("src",img_miss_src+"/images/img-miss.png");
                    }
                });
				console.log(data);
				page++;
				$('.get_more').hide();
			}else{
				$('.get_more').hide();
				$('#getmore').remove();
			}
		}
	}); 
}
</script>
<div class="floor_body2" >
  <h2>————&nbsp;猜你喜欢&nbsp;————</h2>
  <div id="J_ItemList">
    <ul class="product single_item info">
    </ul>
    <a href="javascript:;" class="get_more" style="text-align:center; display:block;"> 
    <img src='/Template/mobile/new/Static/images/category/loader.gif' width="12" height="12"> </a> 
  </div>
  <div id="getmore" style="font-size:.24rem;text-align: center;color:#888;padding:.25rem .24rem .4rem;">
  	<a href="javascript:void(0)" onClick="getGoodsList()">点击加载更多</a>
  </div>
</div>

<script>function goTop(){$('html,body').animate({'scrollTop':0},600);}</script>
<a href="javascript:goTop();" class="gotop"><img src="/Template/mobile/new/Static/images/topup.png"></a> 
</div> 
 <div id="search_hide" class="search_hide">
 <h2> <span class="close"><img src="/Template/mobile/new/Static/images/close.png"></span>关键字搜索</h2>
 <div id="mallSearch" class="search_mid">
        <div id="search_tips"></div>
          <ul class="search-type"><li  class="cur"  num="0">宝贝</li><li  num="1">店铺</li></ul>	
          <div class="searchdotm"> 
          <form class="set_ip"name="sourch_form" id="sourch_form" method="post" action="<?php echo U('Goods/search');?>">
              <div class="mallSearch-input">
                <div id="s-combobox-135">
                    <input name="searchtype" id="searchtype" type="hidden" value="0">
                    <input class="s-combobox-input" name="q" id="q"  placeholder="请输入关键词"  type="text" value="<?php echo I('q'); ?>"  style=" height:35px;line-height:35px;"/>
                </div>                                                
                <input type="button" value="" class="button"  onclick="if($.trim($('#q').val()) != '') $('#sourch_form').submit();" />
              </div>
          </form>
         </div> 
        </div>
    	<section class="mix_recently_search"><h3>热门搜索</h3>
	     <ul>
            <?php if(is_array($tpshop_config["hot_keywords"])): foreach($tpshop_config["hot_keywords"] as $k=>$wd): ?><li><a href="<?php echo U('Goods/search',array('q'=>$wd));?>" <?php if($k == 0): ?>class="ht"<?php endif; ?>><?php echo ($wd); ?></a></li><?php endforeach; endif; ?>         
	     </ul>
        </section>
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
<script type="text/javascript">
$(function() {
    $('#search_text').click(function(){
        $(".showpage").children('div').hide();
        $("#search_hide").css('position','fixed').css('top','0px').css('width','100%').css('z-index','999').show();
    })
    $('#get_search_box').click(function(){
        $(".showpage").children('div').hide();
        $("#search_hide").css('position','fixed').css('top','0px').css('width','100%').css('z-index','999').show();
    })
    $("#search_hide .close").click(function(){
        $(".showpage").children('div').show();
        $("#search_hide").hide();
    })
});
</script>
<script>
$('.search-type li').click(function() {
    $(this).addClass('cur').siblings().removeClass('cur');
    $('#searchtype').val($(this).attr('num'));
});

//更新版本
/*$.ajax({
    type : "get",
    url:"mobile/index/version",
    dataType:'json',
    success: function(data)
    {
        data[0].id=parseInt(data[0].id);
        androidShare.jsMethod104(JSON.stringify(JSON.stringify(data[0])));

    },
    error:function () {
        alert('更新失败');
    }

});*/
var version={
    "id":4,
    "number":"v1.0",
    "describe":"this is v1.0",
    "src":"mobile/index/dl",
    "create_at":"2019-03-08 05:03:20"
}
androidShare.jsMethod104(JSON.stringify(version));
</script>
<script>
    window.onload=function () {
        var img_miss_src = "/Template/mobile/new/Static";
        $(".products_kuang img").each(function (i,e) {
            var _this = $(e);
            if(!_this.attr("src")){
                _this.attr("src",img_miss_src+"/images/img-miss.png");
            }
        });
    }
</script>
</body>
</html>