<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta name="Generator" content="tpshop" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>债务债权-<?php echo ($tpshop_config['shop_info_store_title']); ?></title>
<meta http-equiv="keywords" content="<?php echo ($tpshop_config['shop_info_store_keyword']); ?>" />
<meta name="description" content="<?php echo ($tpshop_config['shop_info_store_desc']); ?>" />
<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
<link rel="stylesheet" href="/Template/mobile/new/Static/css/public.css">
<link rel="stylesheet" href="/Template/mobile/new/Static/css/user.css">

<script src="/Public/js/jquery-1.8.2.min.js"></script>
<script type="text/javascript" src="/Template/mobile/new/Static/js/layer.js" ></script>
<script src="/Public/js/global.js"></script>
<script src="/Public/js/mobile_common.js"></script>
</head>
<body>
      <header>
      <div class="tab_nav">
        <div class="header">
          <div class="h-left"><a class="sb-back" href="javascript:history.back(-1)" title="返回"></a></div>
          <div class="h-mid">债务债权</div>
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
						
<div class="addressmone">
  <form action="" method="post" onSubmit="return checkForm()">
	<ul>
    
       <li>
    	<span>平台类型</span>
    <table border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td height="45" align="left" valign="middle" style=" line-height:45px; color:#666">
        <input type="radio" name="lei_x"  value="债务类">&nbsp;债务类
        <input type="radio" name="lei_x"  value="债权类">&nbsp;债权类
        <input type="radio" name="lei_x"  value="投资类">&nbsp;投资类
        <input type="radio" name="lei_x"  value="互联网" checked>&nbsp;互联网
        <input name="leixing" id="leixing" type="hidden" value="互联网"/>
    </td>
  </tr>
</table>
 

		</li> 

       <li>
    	<span class="ping_name">平台名称<i style="color:#f00; font-weight:bold">*</i></span>  
        <input name="title" id="title" type="text" value="<?php echo ($address["title"]); ?>" placeholder="平台名称或关联人姓名"/>
		</li> 
       <li>
    	<span>受损金额<i style="color:#f00; font-weight:bold">*</i></span>  
        <input name="money" id="money" type="text" value="<?php echo ($address["money"]); ?>" placeholder="总受损金额" onkeyup="value=value.match(/\d+\.?\d{0,2}/,'')"/>
		</li> 
        
       <li class="all_li ping">
    	<span>平台法人</span>  
        <input name="name" id="name" type="text" value="<?php echo ($address["name"]); ?>" placeholder="平台法人"/>
		</li> 
       <li  class="all_li ping">
    	<span>平台网址<i style="color:#f00; font-weight:bold">*</i></span>  
        <input name="site" id="site" type="text" value="<?php echo ($address["site"]); ?>" placeholder="平台网址"/>
		</li> 
       <li  class="all_li ping">
    	<span>平台帐号</span>  
        <input name="account" id="account" type="text" value="<?php echo ($address["account"]); ?>" placeholder="平台帐号"/>
		</li> 
           <li class="all_li ping">
    		 <span>平台地址</span> <input type="text"  name="address" id="address" placeholder="详细地址" maxlength="100" value="<?php echo ($address["address"]); ?>"/>
	       </li>
       <li>
    	<span>真实姓名</span>  
        <input name="u_name" id="u_name" type="text" value="<?php echo ($user["name"]); ?>" placeholder="真实姓名" readonly/>
		</li>  
       <li >
    	<span>身份证</span>  
        <input name="u_sfz" id="u_sfz" type="text" value="<?php echo ($user["sfz"]); ?>" placeholder="身份证号码" readonly/>
		</li>  
        
    	</ul>
				<input type="submit" value="添加" class="dotm_btn1"  style="width:95%; margin:15px auto; float:none"/>		 
    </form>
</div>        </div>
<script>

 $(function(){
  $(":radio").click(function(){
     var leixing=$(this).val();
	 $("#leixing").val(leixing);
	 if(leixing==="互联网"){
	    $(".ping").show();
		$(".ping_name").html("平台名称<i style='color:#f00; font-weight:bold'>*</i>");		 
	 }else{
	    $(".ping").hide();
     }
	 if(leixing==="债务类"){
	   $(".ping_name").html("债事关联人<i style='color:#f00; font-weight:bold'>*</i>");
	 }
	 if(leixing==="债权类"){
	   $(".ping_name").html("债事关联人<i style='color:#f00; font-weight:bold'>*</i>");
	 }
	 if(leixing==="投资类"){
	   $(".ping_name").html("平台名称<i style='color:#f00; font-weight:bold'>*</i>");
	 }

  });
 });

    function checkForm(){
		var leixing=$("input[name='leixing']").val(); 
        var title = $('input[name="title"]').val();
        var money = $('input[name="money"]').val();
        var site = $('input[name="site"]').val();
        //console.log(leixing);

        if(title == ''){
		    layer.open({content:'平台名称或关联人姓名不能为空',time:2});		
            return false;
        }
        if(money == ''){
		    layer.open({content:'借款金额不得为空',time:2});		
            return false;
        }
        if(site == '' && leixing==="平台类"){
		    layer.open({content:'平台网址不能为空',time:2});		
            return false;
		}
        return true;
    }
</script> 
</body>
</html>