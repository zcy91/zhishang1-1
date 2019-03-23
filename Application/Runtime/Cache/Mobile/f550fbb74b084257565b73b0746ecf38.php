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
<link rel="stylesheet" href="/Template/mobile/new/Static/css/flow.css">
<style>
body, button, input, select, textarea {
    font-size: 14px;font-family: arial,微软雅黑;
}
.g-Total {
    background: #F4F4F4;border-bottom: 1px solid #DCDCDC; line-height: 30px;
    padding: 5px 10px 0; font-size: 14px;
}
a.gray9, .gray9 {color: #999;}
.g-member {background: #F4F4F4;padding: 10px 5px;}
.g-Recharge ul {zoom: 1;}
.g-Recharge li a.z-sel {
    border: 1px solid #F60; color: #666;
}
.g-Recharge li .z-initsel {
    border: 1px solid #F60;
}
.g-Recharge li .z-init {
    width: 90%;padding: 7px 0; text-align: center;border: none;
}
.g-Recharge li .z-initsel input {
    color: #666;
}
.g-Recharge li a.z-sel s, .g-Recharge li .z-initsel s {
    width: 18px;height: 18px;
    position: absolute; right: -1px; bottom: -1px;
    display: inline-block;background-position: 0 0;
}
.g-Recharge li:nth-child(3n-1) {
    width: 34%;text-align: center;
}
.g-Recharge li:nth-child(3n-3) {
    text-align: right;
}
.g-Recharge li {
    width: 33%;float: left;margin-bottom: 10px;
}
.g-pay-ment {
    overflow: hidden;
}
.m-round {
    border: 1px solid #DCDCDC;border-radius: 5px;
    background: #fff;box-shadow: 1px 1px 1px #e7e7e7;
}
.mt10 {
    margin-top: 10px;
}
.g-Recharge li a, .g-Recharge li .z-initsel, .g-Recharge li b {
    color: #959595;width: 90%;
    line-height: 30px;display: inline-block;
    background: #fff;border-radius: 5px;
    text-align: center;border: 1px solid #EAEAEA;
    box-shadow: 1px 1px 1px #EDEDED; position: relative;
}
.z-sel s, .z-initsel s, .z-Btn-Close b, .z-Btn-Rotation b, .z-Btn-del b, .z-Btn-ok b {
    background: url(/Template/mobile/new/Static/images/member-icon.png?v=130825);background-size: 40px auto;
}
.z-bank-Round {
    width: 16px;
    height: 16px;border: 1px solid #bbb;
    background: #fff;border-radius: 16px;
    display: inline-block;margin-right: 8px;
    box-shadow: 0 1px 1px #ccc inset;
}
.z-bank-Roundsel s {
    width: 12px;height: 12px;border-radius: 12px;display: inline-block;
    background-image: -webkit-gradient(linear,left top,left bottom,color-stop(0,#ff8a00),color-stop(1,#f60));
}
.f-Recharge-btn {display: block;}
a.orgBtn {background: #f60;border: 1px solid #ef6000;}
.orgBtn {
    display: block; width: 100%;
    -webkit-box-sizing: border-box;
    height: 43px;line-height: 43px;
    text-align: center; color: #fff!important;
    border-radius: 5px;font-size: 18px;
}
.clearfix { display: block;}
.z-bank-Roundsel {
    width: 16px;height: 16px;line-height: 20px;border: 1px solid #ccc;background: #F6F5F5;
    border-radius: 16px;display: inline-block;text-align: center;margin-right: 8px;
}
.g-pay-ment li {
    line-height: 36px;border-top: 1px dotted #CBCBCB;max-height: 40px;
    padding: 0 10px;overflow: hidden;margin-top: -1px;
}
.clearfix:after {
    content: ".";display: block;height: 0;clear: both;visibility: hidden;
}
.orange {color: #f60;}
</style>
<body>
<header>
  <div class="tab_nav">
    <div class="header">
      <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
      <div class="h-mid">在线充值</div>
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
	<div class="g-Total gray9">您的当前余额：<span class="orange arial"><?php echo ($user["user_money"]); ?></span>元</div>
	<form method="post"  id="recharge_form" action="<?php echo U('Mobile/Payment/getPay');?>">
	<section class="clearfix g-member">
           <div class="g-Recharge">
               <ul id="ulOption">
                   <li money="10"><a href="javascript:;" class="z-sel">10元<s></s></a></li>
                   <li money="50"><a href="javascript:;">50元<s></s></a></li>
                   <li money="100"><a href="javascript:;">100元<s></s></a></li>
                   <li money="500"><a href="javascript:;">500元<s></s></a></li>
                   <li money="1000"><a href="javascript:;">1000元<s></s></a></li>
                   <li><b><input type="text" id="input_val" class="z-init" placeholder="输入金额" maxlength="8" value="<?php echo ($order["account"]); ?>"  onkeyup="value=value.match(/\d+\.?\d{0,2}/,'')"><s></s></b></li>
               </ul>
           </div>
		<div class="clearfix mt10 m-round g-pay-ment g-bank-ct">
               <ul id="ulBankList" class="nav nav-list-sidenav">
                   <li class="gray6">已选择充值<em class="orange">10</em>元</li>
                   <?php if(is_array($paymentList)): foreach($paymentList as $k=>$v): ?><li class="clearfix" name="payment_name">
                      <label>
                          <input type="radio"  value="pay_code=<?php echo ($v['code']); ?>" class="c_checkbox_t" name="pay_radio" checked/>
                          <div class="fl shipping_title">
	                          <img src="/plugins/<?php echo ($v['type']); ?>/<?php echo ($v['code']); ?>/<?php echo ($v['icon']); ?>" onClick="change_pay(this);" height="25" />
                          </div>
                      </label>
                    </li><?php endforeach; endif; ?> 
               </ul>
           </div>
           <div class="mt10 f-Recharge-btn">
               <a id="btnSubmit" href="javascript:;" class="orgBtn" onClick="recharge_submit()">确认充值</a>
           </div>
           <input type="hidden" name="account" id="add_money" value="10">
           <input type="hidden" name="order_id" value="<?php echo ($order["order_id"]); ?>">
      </section>
      </form>
</div>
</body>
<script type="text/javascript">
$(function () {
	//$("input[name='pay_radio']").first().trigger('click');
     $(".g-Recharge ul li").click(function () {
        $(this).find('a').addClass('z-sel')
        $(this).siblings().find('a').removeClass('z-sel');
        $('.gray6').find('em').html($(this).attr('money'));
        $('#add_money').val($(this).attr('money'));
     });
});

 $("#input_val").on("change",function(e){
     //获取input输入的值
	    var money=e.delegateTarget.value;
        $('.gray6').find('em').html(money);
});
function change_pay(obj)
{
    $(obj).parent().siblings('input[name="pay_radio"]').trigger('click');
}

function recharge_submit(){
	var input_val = ($('#input_val').val());//parseInt($('#input_val').val())
	if(input_val>0){
		$('#add_money').val(input_val);
	}
	var account = $('#add_money').val();
	//console.log(account);
	if(account<=0 || account==''){
		//if(isNaN(account) || parseInt(account)<=0 || account==''){
		alert('请输入正确的充值金额');
		return false;
	}

	$('#recharge_form').submit();
}
</script>
</html>