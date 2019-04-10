<?php if (!defined('THINK_PATH')) exit(); if(is_array($store_list)): $i = 0; $__LIST__ = $store_list;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$store): $mod = ($i % 2 );++$i;?><section class="rzs_info">
		<dl>
			<dt><a href="<?php echo U('Store/index',array('store_id'=>$store[store_id]));?>" class="flow-datu" title="<?php echo ($store['store_name']); ?>"
				   style="background-image:url(<?php if($store['store_logo'] == ''): ?>/Template/mobile/new/Static/images/dianpu2.png<?php else: echo ($store['store_logo']); endif; ?>)"> </a></dt>
			<dd>
				<strong>
					<a href="javascript:;" style="color: #0abfde; float:right;" name="navigation">导航
						<input hidden="hidden" value="<?php echo ($store['lat']); ?>" name="lat" >
						<input hidden="hidden" value="<?php echo ($store['lng']); ?>" name="lng" >
						<input hidden="hidden" value="<?php echo ($store['store_name']); ?>" name="shop" >
						<!--<input hidden="hidden" value="<?php echo ($store['province_name']); ?>,<?php echo ($store['city_name']); ?>,<?php echo ($store['district_name']); ?>" name="address" >-->
						<input hidden="hidden" value="<?php echo ($store['store_address']); ?>" name="address" >
						<input hidden="hidden" value="<?php echo ($store['store_logo']); ?>" name="logo">
						<input hidden="hidden" value="<?php echo ($store['juli']); ?>" name="distance">
					</a>
					<span id="span_distance" style="float:right"><?php echo ($store["juli"]); ?>km</span>
					<a href="<?php echo U('Store/index',array('store_id'=>$store[store_id]));?>" style="float: left;max-width: 73%;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?php echo ($store['store_name']); ?></a>

				</strong>
              	<p>所在地：<?php echo ($store['store_address']); ?></p>

			</dd>
		</dl>
		<ul>
			<li><span>宝贝描述</span><strong>:<?php if($store['store_desccredit'] == 0): ?>5.0<?php else: echo (number_format($store['store_desccredit'],1)); endif; ?></span></strong>
				<em>
					<?php $_RANGE_VAR_=explode(',',"0,1.99");if($store["store_desccredit"]>= $_RANGE_VAR_[0] && $store["store_desccredit"]<= $_RANGE_VAR_[1]):?>低<?php endif; ?>
					<?php $_RANGE_VAR_=explode(',',"2,3.99");if($store["store_desccredit"]>= $_RANGE_VAR_[0] && $store["store_desccredit"]<= $_RANGE_VAR_[1]):?>中<?php endif; ?>
					<?php $_RANGE_VAR_=explode(',',"4,5");if($store["store_desccredit"]>= $_RANGE_VAR_[0] && $store["store_desccredit"]<= $_RANGE_VAR_[1]):?>高<?php endif; ?>
				</em>
			</li>
			<li><span>卖家服务</span><strong>:<?php if($store['store_servicecredit'] == 0): ?>5.0<?php else: echo (number_format($store['store_servicecredit'],1)); endif; ?></strong>
				<em><?php $_RANGE_VAR_=explode(',',"0,1.99");if($store["store_desccredit"]>= $_RANGE_VAR_[0] && $store["store_desccredit"]<= $_RANGE_VAR_[1]):?>低<?php endif; ?>
					<?php $_RANGE_VAR_=explode(',',"2,3.99");if($store["store_desccredit"]>= $_RANGE_VAR_[0] && $store["store_desccredit"]<= $_RANGE_VAR_[1]):?>中<?php endif; ?>
					<?php $_RANGE_VAR_=explode(',',"4,5");if($store["store_desccredit"]>= $_RANGE_VAR_[0] && $store["store_desccredit"]<= $_RANGE_VAR_[1]):?>高<?php endif; ?></em>
			</li>
			<li><span>物流服务</span><strong>:<?php if($store['store_deliverycredit'] == 0): ?>5.0<?php else: echo (number_format($store['store_deliverycredit'],1)); endif; ?></strong>
				<em><?php $_RANGE_VAR_=explode(',',"0,1.99");if($store["store_desccredit"]>= $_RANGE_VAR_[0] && $store["store_desccredit"]<= $_RANGE_VAR_[1]):?>低<?php endif; ?>
					<?php $_RANGE_VAR_=explode(',',"2,3.99");if($store["store_desccredit"]>= $_RANGE_VAR_[0] && $store["store_desccredit"]<= $_RANGE_VAR_[1]):?>中<?php endif; ?>
					<?php $_RANGE_VAR_=explode(',',"4,5");if($store["store_desccredit"]>= $_RANGE_VAR_[0] && $store["store_desccredit"]<= $_RANGE_VAR_[1]):?>高<?php endif; ?></em>
			</li>
		</ul>
	</section><?php endforeach; endif; else: echo "$empty" ;endif; ?>
<script>
	//window.onload=function(){
		var list=document.getElementsByName('navigation');
		//console.log(list);
		list.forEach(function (e) {
			e.onclick=function(e){
				//console.log(e);
				var lat=e.target.children[0].value?e.target.children[0].value:30.1847340429;
				var lng=e.target.children[1].value?e.target.children[1].value:120.1199515112;
				var shopName=e.target.children[2].value;
				var shopAddress=e.target.children[3].value;
				var shopLogo=e.target.children[4].value;
				var shopDistance=e.target.children[5].value;
				/*var shopName=document.getElementById('shop');
				var shopAddress=document.getElementById('address');
				shopName.innerHTML=shop;
				shopAddress.innerHTML=address;
				var nav=document.getElementById('pop_up');
				var frame=document.getElementById('frame');
				frame.src="mobile/index/navigation/lat/"+lat+'/lng/'+lng;
				nav.style.display="block";*/
				localStorage.setItem('shopName',shopName);
				localStorage.setItem('shopAddress',shopAddress);
				localStorage.setItem('shopLogo',shopLogo==''?'/Template/mobile/new/Static/images/dianpu2.png':shopLogo);
				localStorage.setItem('shopDistance',shopDistance);
				window.location.replace("mobile/index/navigation/lat/"+lat+"/lng/"+lng);
			};
		})
	//};

	/*navigation.onclick=function(e){
		//console.log(e);
		localStorage.setItem('shop',"<?php echo ($store['store_name']); ?>");
		localStorage.setItem('address',"<?php echo ($store['province_name']); ?>,<?php echo ($store['city_name']); ?>,<?php echo ($store['district_name']); ?>");
		var lat=e.target.children[0].value;
		var lng=e.target.children[1].value;
		console.log(lat+'---'+lng);
		var nav=document.getElementById('pop_up');
		var frame=document.getElementById('frame');
		frame.src="mobile/index/navigation/lat/"+lat+'/lng/'+lng;
		nav.style.display="block";
		/!*window.location.replace("navigation/lat/"+lat+"/lng/"+lng);*!/
	};*/


</script>