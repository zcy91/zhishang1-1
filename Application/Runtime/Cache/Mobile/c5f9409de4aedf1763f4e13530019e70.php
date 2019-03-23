<?php if (!defined('THINK_PATH')) exit(); if(is_array($goods_list)): foreach($goods_list as $key=>$vo): ?><li>
        <a href="<?php echo U('Goods/goodsInfo',array('id'=>$vo[goods_id]));?>">
            <img src="<?php echo (goods_thum_images($vo["goods_id"],200,200)); ?>" alt="<?php echo (getSubstr($vo["goods_name"],0,16)); ?>" srcset="<?php echo (goods_thum_images($vo["goods_id"],200,200)); ?>"
                 srcd="<?php echo (goods_thum_images($vo["goods_id"],200,200)); ?>">

            <p> <?php echo (getSubstr($vo["goods_name"],0,20)); ?> </p>
            <span>￥<?php echo ($vo["shop_price"]); ?>元</span>
        </a>
    </li><?php endforeach; endif; ?>