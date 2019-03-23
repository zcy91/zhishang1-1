<?php if (!defined('THINK_PATH')) exit(); if(is_array($favourite_goods)): foreach($favourite_goods as $k=>$v): ?><li>
     <div class="index_pro">
	       <div class="products_kuang" onClick="location='<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id]));?>'"><img src="<?php echo (goods_thum_images($v["goods_id"],400,400)); ?>"></div>
	       <div class="goods_name"; style="font-size:12px;"><?php echo (mb_substr($v["goods_name"],0,25,'utf-8')); ?></div>
	       <div class="price">
	         <a href="javascript:AjaxAddCart(<?php echo ($v[goods_id]); ?>,1,0);" class="btns"><img src="/Template/mobile/new/Static/images/index_flow.png"></a>
	       <span href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id]));?>" class="price_pro" style="font-size:12px"><?php echo ($v["shop_price"]); ?>元
<!--           <?php if($v["give_integral"] != 0): ?>送<?php echo number_format((tpCache('distribut.point_rate')*$v['give_integral']*$v['shop_price'])*0.01, 2, '.',''); echo tpCache('distribut.jifeng_name'); endif; ?>-->
           </span>
<!--           <?php if($v["exchange_integral"] != 0): ?><span href="<?php echo U('Mobile/Goods/goodsInfo',array('id'=>$v[goods_id]));?>" class="price_proa" ><?php $dik=number_format($v['exchange_integral']*$v['shop_price']*0.01,2,'.','');echo $v['shop_price']-$dik;?>元+<?php echo tpCache('distribut.point_rate')*$dik; echo tpCache('distribut.jifeng_name');?></span><?php endif; ?>-->
	       </div>  
      </div>
</li><?php endforeach; endif; ?>