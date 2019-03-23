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
<body style="background: rgb(235, 236, 237);position:relative;">

<div class="tab_nav">
    <div class="header">
      <div class="h-left">
        <a class="sb-back" href="javascript:history.back(-1)" title="返回"></a>
      </div>
      <div class="h-mid">购物车   </div>
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
    <div class="page-shopping ">
      <div class="cart_list">
        <form id="cart_form" name="formCart" action="<?php echo U('Mobile/Cart/ajaxCartList');?>" method="post">

        </form>
      </div>
    </div>
<div style="height:72px;"></div>
</div>
<div class="f_block" id="pop" style="position: fixed; bottom: 0px; left: 0px; height: 0px; z-index: 99999999; overflow: hidden; width: 100%; background: rgb(255, 255, 255);">
  <p class="f_title"><span>选择自提点</span><a class="c_close" href="javascript:void(0)" onClick="close_pop()"></a></p>
  <div id="pickcontent"></div>
</div>
<script type="text/javascript">

function showCheckoutOther(obj)
{
  var otherParent = obj.parentNode;
  otherParent.className = (otherParent.className=='checkout_other') ? 'checkout_other2' : 'checkout_other';
  var spanzi = obj.getElementsByTagName('span')[0];
  spanzi.className= spanzi.className == 'right_arrow_flow' ? 'right_arrow_flow2' : 'right_arrow_flow';
}
</script> 
<script type="text/javascript">
$(document).ready(function(){
    ajax_cart_list(); // ajax 请求获取购物车列表
});

// ajax 提交购物车
var before_request = 1; // 上一次请求是否已经有返回来, 有才可以进行下一次请求
function ajax_cart_list(){
	
	if(before_request == 0) // 上一次请求没回来 不进行下一次请求
	    return false;
	before_request = 0;
	
    $.ajax({
        type : "POST",
        url:"<?php echo U('Mobile/Cart/ajaxCartList');?>",//+tab,
        data : $('#cart_form').serialize(),// 你的formid
        success: function(data){
            $("#cart_form").html('');
            $("#cart_form").append(data);
			before_request = 1;			
        }
    });
}

/**
 * 购买商品数量加加减减
 * 购买数量 , 购物车id , 库存数量
 */
function switch_num(num,cart_id,store_count)
{
    var num2 = parseInt($("input[name='goods_num["+cart_id+"]']").val());
    num2 += num;
    if(num2 < 1) num2 = 1; // 保证购买数量不能少于 1
    if(num2 > store_count)
    {   alert("库存只有 "+store_count+" 件, 你只能买 "+store_count+" 件");
        num2 = store_count; // 保证购买数量不能多余库存数量
    }

    $("input[name='goods_num["+cart_id+"]']").val(num2);

    ajax_cart_list(); // ajax 更新商品价格 和数量
}

// ajax 删除购物车的商品
function ajax_del_cart(ids)
{
    $.ajax({
        type : "POST",
        url:"<?php echo U('Mobile/Cart/ajaxDelCart');?>",
        data:{ids:ids},
        dataType:'json',
        success: function(data){
            if(data.status == 1)
        	{
            	ajax_cart_list(); //ajax 请求获取购物车列表	
        	}               
        }
    });
}

// 批量删除购物车的商品
function del_cart_more()
{
    if(!confirm('确定要删除吗?'))
        return false;
    // 循环获取复选框选中的值
    var chk_value = [];
    $('input[name^="cart_select"]:checked').each(function(){
        var s_name = $(this).attr('name');
        var id = s_name.replace('cart_select[','').replace(']','');
        chk_value.push(id);
    });
    // ajax调用删除
    if(chk_value.length > 0)
        ajax_del_cart(chk_value.join(','));
}
</script> 
</body>
</html>