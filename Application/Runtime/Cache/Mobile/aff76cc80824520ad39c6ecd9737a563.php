<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta name="Generator" content="tpshop" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>购物流程-<?php echo ($tpshop_config['shop_info_store_title']); ?></title>
<meta http-equiv="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>" />
<meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" href="/Template/mobile/new/Static/css/public.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/flow.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/style_jm.css">
<script type="text/javascript" src="/Template/mobile/new/Static/js/jquery.js"></script>
<script src="/Public/js/global.js"></script>
<script src="/Public/js/mobile_common.js"></script>
<script src="/Template/mobile/new/Static/js/common.js"></script>
</head>
<body style="background:#EBECED;position:relative;">
<div class="tab_nav">
  <div class="header">
    <div class="h-left"> <a class="sb-back" href="javascript:history.back(-1)" title="返回"></a> </div>
    <div class="h-mid"> 确认订单 </div>
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
<div class="screen-wrap fullscreen login"> 
<form name="cart2_form" id="cart2_form" method="post">
    <section class="content" style="min-height: 294px;">
    <div class="wrap">
    <div class="active" style="min-height: 294px;">
    <div class="content-buy">
    <div class="wrap order-buy">
    <a href="<?php echo U('User/address_list',array('source'=>'cart2'));?>">
	    <section class="address">
	      <div class="address-info" >收货人:
	        <p class="address-name"><?php echo ($address["consignee"]); ?></p>
	        <p class="address-phone"><?php echo ($address["mobile"]); ?></p>
	      </div>
	      <div class="address-details">收货地址：<?php echo ($address["address"]); ?></div>
          <input type="hidden" value="<?php echo ($address["address_id"]); ?>" name="address_id" />
	    </section>
    </a>
    <section class="order " id="order4">
      <div  class="order-info" style="margin-top:0;">
      <!--
        	<h4 class="seller-name" > <img src="/Template/mobile/new/Static/images/flow/dingdan.png" width="28"> 
        		订单详情 <a class="modify" href="<?php echo U('Cart/cart');?>">修改</a></h4>
      -->          
      </div>
      <section class="order-info" style=" margin-top:0px;">
        <div class="order-list">          
          <ul class="order-list-info">
<!--商品列表-->
<?php if(is_array($storeList)): foreach($storeList as $key=>$v): ?><div class="goods-list-title"> <?php echo ($v[store_name]); ?></div>
           <?php if(is_array($cartList)): foreach($cartList as $k=>$v2): if(($v2[selected] == '1') and ($v2[store_id] == $v[store_id])): ?><li class="item" >
                      <div class="itemPay list-price-nums" id="itemPay17">
                        <p class="price">￥<?php echo ($v2["member_goods_price"]); ?>元</p>
                        <p class="nums">x<?php echo ($v2["goods_num"]); ?></p>
                      </div>
                      <div class="itemInfo list-info" id="itemInfo12">
                        <div class="list-img"> <a href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v2[goods_id]));?>"> <img src="<?php echo (goods_thum_images($v2["goods_id"],200,200)); ?>"></a> </div>
                        <div class="list-cont">
                          <h5 class="goods-title"><?php echo ($v2["goods_name"]); ?> </h5>
                          <p class="godds-specification"><?php echo ($v2["spec_key_name"]); ?></p>
                        </div>
                      </div>
                    </li><?php endif; endforeach; endif; ?>
  <?php if(2 == 1): ?><li class="flow_youhui_no" style="display:none">
              <div class="checkout_other">
                <div class="jmbag" href="javascript:void(0);" onClick="showCheckoutOther(this);"><span class="right_arrow_flow"></span>使用优惠券</div>
                <table class="subbox_other sub_bonus" width="100%">
                  <tr>
                    <td  colspan="2">
                    <input type="radio" class="radio vam ma-ri-10" name="couponTypeSelect[<?php echo ($v[store_id]); ?>]" checked value="1"  onClick="ajax_order_price();" />
                     <select id="coupon_id" name="coupon_id[<?php echo ($v[store_id]); ?>]" class="vam ou-no" onChange="ajax_order_price();">                                                     
                          <option value="0">选择优惠券</option>
                         <?php if(is_array($couponList)): foreach($couponList as $key=>$v3): if(($v3[store_id] == $v[store_id])): ?><option value="<?php echo ($v3['id']); ?>"><?php echo ($v3['name']); ?></option><?php endif; endforeach; endif; ?>
                     </select>                    
                    </td>
                    </tr>
                    <tr>
                    <td>
                    &nbsp;或 &nbsp;
                    <input type="radio" class="radio vam ma-ri-10" name="couponTypeSelect[<?php echo ($v[store_id]); ?>]"  value="2"  onClick="ajax_order_price();javascript:document.getElementById('Bonus_span_0').style.display='block';" />
                    <a href="javascript:void(0);"  class="a_other1_h" id="Bonus_a_0">直接输入优惠券</a>
                    </td>
                    </tr>
                    <tr>
                    <td>
                      <label id="Bonus_span_0" style="display:;">
                        <input name="couponCode[<?php echo ($v[store_id]); ?>]" id="bonus_sn_0" type="text"   value="" placeholder="输入优惠券"  class="txt1" style="width:144px;"/>
                        <input name="validate_bonus" type="button" value="使用" onClick="ajax_order_price();" class="BonusButton" />
                      </label>
                    </td>
                    </tr>
                </table>
              </div>
            </li><?php endif; ?> 
               
			<li class="flow_youhui_no">
       			<label id="Bonus_span_0">
       			   选择物流： 
                         <select onChange="ajax_order_price();" class="vam ou-no" name="shipping_code[<?php echo ($v[store_id]); ?>]">                                                                                                     
                            <?php if(is_array($shippingList)): foreach($shippingList as $k4=>$v4): if($v4['store_id'] == $v['store_id']): ?><option value="<?php echo ($v4["shipping_code"]); ?>"><?php echo ($v4["name"]); ?></option><?php endif; endforeach; endif; ?>
                         </select>                   
                 </label>
            </li>   
			<li class="flow_youhui_no">
       			<label id="Bonus_span_0">
       			   给卖家留言：
                        <input type="text" placeholder="给卖家留言" name="user_note[<?php echo ($v[store_id]); ?>]" style="vertical-align:middle;" class="txt1">            
                 </label>
            </li><?php endforeach; endif; ?>            
  <?php if(2 == 1): ?><li class="flow_youhui_no" style="display:none">
       			<label id="Bonus_span_0">
       			   使用余额：
                   <input id="user_money" name="user_money"  type="text"   placeholder="输入余额" onpaste="this.value=this.value.replace(/[^\d.]/g,'')" onKeyUp="this.value=this.value.replace(/[^\d.]/g,'')" class="txt1" style="width:100px;"/>
                   <input name="validate_bonus" type="button" value="使用" onClick="ajax_order_price();" class="BonusButton" />
                 	可用余额<em><?php echo ($user['user_money']); ?></em>
                 </label>
            </li>
<?php if(($total_price["exchange_integral"] > 0) and ($user["pay_points"] > 0)): ?><li class="flow_youhui_no" style="display:none">
       			<label id="Bonus_span_0">
       			   使用<?php echo tpCache('distribut.jifeng_name');?>：
                   <input id="pay_points" name="pay_points" type="text"   placeholder="输入<?php echo tpCache('distribut.jifeng_name');?>"  onpaste="this.value=this.value.replace(/[^\d]/g,'')" onKeyUp="this.value=this.value.replace(/[^\d]/g,'')" class="txt1" style="width:100px;"/>
                   <input name="validate_bonus" type="button" value="使用" onClick="ajax_order_price();" class="BonusButton" />
                 	可用<?php echo tpCache('distribut.jifeng_name');?><em><?php echo ($user['pay_points']); ?></em>
                 </label>
            </li><?php endif; endif; ?>          </ul>
        </div>
      </section>
    </section>
      
   <section class="order-info" style="display:none">
    <div class="order-list">
      <div class="content ptop0">
        <div class="panel panel-default info-box">
          <div class="orderInfo " >
            <h4 class="seller-name"> <img src="/Template/mobile/new/Static/images/flow/dingdan.png" width="28"> 其他选项 </h4>
          </div>
          <table border=0 cellpadding=0 cellspacing=0 width="100%" class="checkgoods">
            <tr>
              <td colspan=4 class="tdother2" style="border-top:none;"><div class="checkout_other" >
                  <div class="jmbag" href="javascript:void(0);" onClick="showCheckoutOther(this);"><span class="right_arrow_flow"></span>开发票和缺货处理</div>
                  <div class="subbox_other" width="100%">
                    <table id='normal_invoice_tbody' width="100%">
                      <tr>
                        <td align=right style="vertical-align:top" width="84">发票抬头：</td>
                        <td colspan="2">
                          <input class="txt1" style='vertical-align:middle' type="text" name="invoice_title" placeholder="XXX单位 或 XX个人" />
                        </td>
                      </tr>                      
                    </table>                     
                  </div>
                </div>
                </td>
            </tr>                                   
          </table>
        	<div style="height:10px; line-height:10px; clear:both;"></div>
        </div></div></div>
        </section>
        <section class="order-info">
        <div class="order-list">
          <div class="content ptop0">
            <div class="panel panel-default info-box">
              <div class="con-ct fo-con">
                <ul class="ct-list order_total_ul" id="ECS_ORDERTOTAL" >
                  <li class="order_total_li" > 
                  		*该订单完成后，您将获得 <span class="price">相应的</span> <?php echo tpCache('distribut.jifeng_name');?><br/>
                  </li>
                  <li>
                   <div class="subtotal">
                      <span class="total-text">商品总额：</span><em class="price">￥<?php echo ($total_price["total_fee"]); ?>元</em><br/>
                      <span class="total-text">配送费用：</span>￥<em class="price" id="postFee"><?php echo ($total_price["shipping_price"]); ?></em>元<br/>
                      
  <?php if(2 == 1): ?><!--<span class="total-text">使用优惠券：</span>-&nbsp;¥&nbsp;<em class="price" id="couponFee">0</em>元<br/>-->                      
<!--                  <span class="total-text">使用<?php echo tpCache('distribut.jifeng_name');?>：</span>-&nbsp;¥&nbsp;<em class="price" id="pointsFee">0</em>元<br/>
                      <span class="total-text">使用余额：</span>-&nbsp;¥&nbsp;<em class="price" id="balance">0</em>元<br/>-->
                      <!--<span class="total-text">优惠活动：</span>-&nbsp;¥&nbsp;<em class="price" id="order_prom_amount">0</em>元<br/>--><?php endif; ?>                 
                      <span class="total-text">应付金额：</span>￥<strong class="price_total" id="payables">0</strong>元
                      <span class="total-text" style=""></span> 
                   </div>
                  </li>
                </ul>
              </div>
              <div class="panel panel-default info-box">
                <div class="pay-btn">
                  <input onClick="submit_order();" type="button" class="sub-btn btnRadius" value="提交订单"/>
                </div>
              </div>
            </div>
            </div>
            </div>
         </section>
         </div>
        </div>
      </div>
    </div>
 	</section>
  </form>
  </div>
<section class="f_mask" style="display: none;"></section>

<script type="text/javascript">

    $(document).ready(function(){
        ajax_order_price(); // 计算订单价钱
    });

// 获取订单价格
function ajax_order_price(){
var pay_points=$("#pay_points ").val();

if(pay_points!="" && pay_points><?php echo ($total_price['exchange_integral']); ?>){
alert('本单您最多可使用<?php echo ($total_price['exchange_integral']); echo tpCache('distribut.jifeng_name');?>');
return false;	
}
if(pay_points!="" && pay_points><?php echo ($user['pay_points']); ?>){
alert('你的帐户可用<?php echo tpCache('distribut.jifeng_name');?>不足');
return false;	
}
    $.ajax({
        type : "POST",
        url:'/index.php?m=Mobile&c=Cart&a=cart3&act=order_price&t='+Math.random(),
        data : $('#cart2_form').serialize(),
        dataType: "json",
        success: function(data){
            if(data.status != 1)
            {
                alert(data.msg);
                // 登录超时
                if(data.status == -100)
                    location.href ="<?php echo U('Mobile/User/login');?>";

                return false;
            }
            //console.log(data);
            $("#postFee").text(data.result.postFee); // 物流费
            $("#couponFee").text(data.result.couponFee);// 优惠券
            $("#balance").text(data.result.balance);// 余额
            $("#pointsFee").text(data.result.pointsFee);// 积分支付
            $("#payables").text(data.result.payables);// 应付
			$("#order_prom_amount").text(data.result.order_prom_amount);// 订单 优惠活动 									
        }
    });
}

// 提交订单
ajax_return_status = 1; // 标识ajax 请求是否已经回来 可以进行下一次请求
function submit_order()
{
	if(ajax_return_status == 0)
	    return false;
		
	ajax_return_status = 0;
		
    $.ajax({
        type : "POST",
        url:"<?php echo U('Mobile/Cart/cart3');?>",//+tab,
        data : $('#cart2_form').serialize()+"&act=submit_order",// 你的formid
        dataType: "json",
        success: function(data){

            if(data.status != '1')
            {
                alert(data.msg); //执行有误
                // 登录超时
                if(data.status == -100)
                    location.href ="<?php echo U('Mobile/User/login');?>";

				ajax_return_status = 1; // 上一次ajax 已经返回, 可以进行下一次 ajax请求

                return false;
            }

            $("#postFee").text(data.result.postFee); // 物流费
            $("#couponFee").text(data.result.couponFee);// 优惠券
            $("#balance").text(data.result.balance);// 余额
            $("#pointsFee").text(data.result.pointsFee);// 积分支付
            $("#payables").text(data.result.payables);// 应付
			$("#order_prom_amount").text(data.result.order_prom_amount);// 订单 优惠活动 									
            alert('订单提交成功，跳转支付页面!');
		    location.href = "/index.php?m=Mobile&c=Cart&a=cart4&master_order_sn="+data.result; // 跳转到结算页			
        }
    });
}
</script>
</body>
</html>