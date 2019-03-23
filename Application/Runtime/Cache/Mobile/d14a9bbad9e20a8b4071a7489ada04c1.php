<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html >
<html>
<head>
<meta name="Generator" content="tpshop" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width">
<title>添加地址-<?php echo ($tpshop_config['shop_info_store_title']); ?></title>
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
          <div class="h-mid">地址管理</div>
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
  <form action="<?php echo U('Mobile/User/add_address');?>" method="post" onSubmit="return checkForm()">
	<ul>
       <li>
    	<span>收货人姓名</span>  
        <input name="consignee" id="consignee" type="text" value="<?php echo ($address["consignee"]); ?>" maxlength="12" placeholder="收货人姓名"/>
		</li>          
       <li>
          <span>地区</span>       
          <input name='country' value='1' type="hidden">
	             <select class="province_select"  name="province" id="province" onChange="get_city(this)">
                      <option value="0">请选择</option>
                        <?php if(is_array($province)): $i = 0; $__LIST__ = $province;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><option <?php if($address['province'] == $p['id']): ?>selected<?php endif; ?>  value="<?php echo ($p["id"]); ?>"><?php echo ($p["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                 </select>
                <select name="city" id="city" onChange="get_area(this)">
                    <option  value="0">请选择</option>
                    <?php if(is_array($city)): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><option <?php if($address['city'] == $p['id']): ?>selected<?php endif; ?>  value="<?php echo ($p["id"]); ?>"><?php echo ($p["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
                <select name="district" id="district" onChange="get_twon(this)">
                    <option  value="0">请选择</option>
                    <?php if(is_array($district)): $i = 0; $__LIST__ = $district;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><option <?php if($address['district'] == $p['id']): ?>selected<?php endif; ?>  value="<?php echo ($p["id"]); ?>"><?php echo ($p["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>                 
                <select class="di-bl fl seauii" name="twon" id="twon" <?php if($address['twon'] > 0 ): ?>style="display:block;"<?php else: ?>style="display:none;"<?php endif; ?>>
                    <?php if(is_array($twon)): $i = 0; $__LIST__ = $twon;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$p): $mod = ($i % 2 );++$i;?><option <?php if($address['twon'] == $p['id']): ?>selected<?php endif; ?>  value="<?php echo ($p["id"]); ?>"><?php echo ($p["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>          
        	</li>
           <li>
    		 <span>详细地址</span> <input type="text"  name="address" id="address" placeholder="详细地址" maxlength="100" value="<?php echo ($address["address"]); ?>"/>
	       </li>
           <li>
			<span>手机</span> 
            <input type="text" name="mobile" value="<?php echo ($address["mobile"]); ?>" onpaste="this.value=this.value.replace(/[^\d-]/g,'')" onKeyUp="this.value=this.value.replace(/[^\d-]/g,'')" maxlength="15" placeholder="手机号码"/>
	        </li>
            <li>
	    		<span>邮政编码</span> 
                <input type="text" name="zipcode" value="<?php echo ($address["zipcode"]); ?>" onpaste="this.value=this.value.replace(/[^\d]/g,'')" onKeyUp="this.value=this.value.replace(/[^\d]/g,'')" maxlength="10"  placeholder="邮政编码"/>
	        </li>
    	</ul>
            <div style=" height:50px"></div>
				<div class="dotm_btn">
                
                <?php if($_GET['source'] == 'cart2'): ?><!--如果是下订单时提交过了的页面-->
                     <input type="submit" value="保存并使用该地址" class="dotm_btn1 beett" />
	                 <input type="hidden" name="source" value="<?php echo ($_GET[source]); ?>" />
                <?php else: ?>
                     <input type="submit" value="保存" class="dotm_btn1" /><?php endif; ?>
                 
                </div>		 
    </form>
</div>        </div>
<script>
    function checkForm(){
        var consignee = $('input[name="consignee"]').val();
        var province = $('select[name="province"]').find('option:selected').val();
        var city = $('select[name="city"]').find('option:selected').val();
        var district = $('select[name="district"]').find('option:selected').val();
        var address = $('input[name="address"]').val();
        var mobile = $('input[name="mobile"]').val();
        var error = '';
        if(consignee == ''){
            error += '收货人不能为空 <br/>';
        }
        if(province==0){
            error += '请选择省份 <br/>';
        }
        if(city==0){
            error += '请选择城市 <br/>';
        }
        if(district==0){
            error += '请选择区域 <br/>';
        }
        if(address == ''){
            error += '请填写地址 <br/>';
        }
        if(!checkMobile(mobile)){
            error += '手机号码格式有误 <br/>';
		}
        if(error){
		    layer.open({content:error,time:2});		
            return false;
        }
			 
        return true;
    }
</script> 
</body>
</html>