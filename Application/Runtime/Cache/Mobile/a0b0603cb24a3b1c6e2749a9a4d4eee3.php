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
    <div class="h-mid">购买<?php echo tpCache('distribut.hot_jifeng_name');?></div>
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
    <div class="Personal">
        <div id="tbh5v0">
            <div class="innercontent1">
                <form onSubmit="return checkinfo()">
                    <div class="name"><span>当前帐号</span>
                        <input type="text"  value="<?php echo ($user["mobile"]); ?>" placeholder="*帐号" class="c-f-text" disabled >
                    </div>
                    <div class="name"><span>当前余额</span>
                        <input type="text" value="<?php echo ($user["user_money"]); ?>" placeholder="*帐户余额" class="c-f-text" disabled >
                    </div>
                  <div class="name">
                       <span>拥有<?php echo tpCache('distribut.jifeng_name');?></span>
                            <input  value="<?php echo ($user["pay_points"]); ?>"  placeholder="*帐户拥有<?php echo tpCache('distribut.hot_jifeng_name');?>" class="c-f-text" disabled style="width:15%; margin-right:15px"/>
                  </div>

                    <div class="name1" style="overflow:hidden; height:55px; clear:both;"><span>购买方式</span>
                        <ul>
                            <li class="on" data-id='1'><label for="fangshi0"><input type="radio" name="fangshi" value="0" tabindex="1" class="radio" id="fangshi0" checked=true/>&nbsp;平台</label></li>
                            <li data-id='2'><label for="fangshi1"><input type="radio" name="fangshi" value="1" tabindex="2" class="radio" id="fangshi1"/>&nbsp;合伙人</label></li>
                        </ul>
                    </div>

                    <div class="name dataid id2" style="color:#f00; display:none">
                       <span>合伙人帐号</span>
                            <input name="user"   placeholder="*&nbsp;合伙人手机号码" class="c-f-text"  style=" width:45%;border:#CCC solid 1px; font-size:14px; padding:5px 0px; text-indent:5px" onKeyUp="value=this.value.replace(/\D+/g,'')"  autocomplete="off"/>
                    </div>
                    <div class="name">
                       <span>购买金额</span>
                        <input name="pay_points"   placeholder="*&nbsp;消耗帐户余额" class="c-f-text"  style=" width:35%;border:#CCC solid 1px; font-size:14px; padding:5px 0px; text-indent:5px" onKeyUp="value=this.value.replace(/\D+/g,'')" required autocomplete="off"/> <i style="color:#f00">（1元=<?php echo tpCache('distribut.point_shifang_leng'); echo tpCache('distribut.jifeng_name');?>）</i>
                    </div>

                    <div class="field submit-btn">
                    <?php if($user['user_money'] > 0 ): ?><input type="submit" value="确认购买" class="btn_big1"  style="background: #F90"/>
                    <?php else: ?>
                        <input type="submit" value="帐户余额不足" class="btn_big1" style="background:#ccc;" disabled/><?php endif; ?>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<script>
        $('.name1 ul li').click(function () {
            $(this).find("input").attr("checked", "checked");
            $('.name1 ul li').removeClass("on");
            $(this).addClass("on");
			$('.dataid').hide();
			$('.id'+$(this).data('id')).show();
        })

function checkinfo(){
	$(".btn_big1").attr('disabled',true);
	var pay_points=$(" input[ name='pay_points' ] ").val();
	var user=$(" input[ name='user' ] ").val();
	var fangshi=$('input[name="fangshi"]:checked').val();
	if (<?php echo tpCache('distribut.point_shifang_leng');?><=0){
		layer.open({content:'平台已关闭购买<?php echo tpCache('distribut.jifeng_name');?>功能',time:2});	
		$(".btn_big1").attr('disabled',false);
		return false;
	}
//	console.log(fangshi);
//	return false;
	if (fangshi==0 && <?php echo ($jifeng["a0"]); ?>>=<?php echo ($jifeng["a1"]); ?>){
		layer.open({content:'平台<?php echo tpCache('distribut.jifeng_name');?>池已达标，请选择合伙人方式',time:2});	
		$(" input[ name='pay_points' ] ").focus();
		$(".btn_big1").attr('disabled',false);
		return false;
	}
	if (fangshi==1 && <?php echo ($jifeng["b0"]); ?>>=<?php echo ($jifeng["b1"]); ?>){
		layer.open({content:'合伙人<?php echo tpCache('distribut.jifeng_name');?>池已达标，请选择平台方式',time:2});	
		$(" input[ name='pay_points' ] ").focus();
		$(".btn_big1").attr('disabled',false);
		return false;
	}
	
	if (fangshi==1 && user==''){
		layer.open({content:'请输入你要购买的合伙人帐号',time:2});	
		$(" input[ name='user' ] ").focus();
		$(".btn_big1").attr('disabled',false);
		return false;
	}
	
	if (pay_points=='' || pay_points<=0){
		layer.open({content:'请输入你要购买的金额',time:2});	
		$(" input[ name='pay_points' ] ").focus();
		$(".btn_big1").attr('disabled',false);
		return false;
	}

	if (pay_points><?php echo ($user["user_money"]); ?>){
		layer.open({content:'您最多可使用余额<?php echo ($user["user_money"]); ?>',time:2});	
		$(" input[ name='pay_points' ] ").focus();
		$(".btn_big1").attr('disabled',false);
		return false;
	}
$.post('', {pay_points: pay_points,user:user,fangshi:fangshi},
              function(res) {
			        //console.log(res);
                    if (res.code == 1) {
                        layer.open({content: res.msg, time: 2});
						location.reload();
                    } else {
                        layer.open({content: res.msg, time: 2});
						$(" input[ name='"+ res.inp+"' ] ").focus();
						$(".btn_big1").attr('disabled',false);
                    }
               });
	
	return false;
}

</script></body>
</html>