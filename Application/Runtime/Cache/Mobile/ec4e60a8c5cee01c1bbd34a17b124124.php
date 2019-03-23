<?php if (!defined('THINK_PATH')) exit(); if(is_array($account_log)): foreach($account_log as $key=>$vo): ?><li class="<?php if((float)$vo["money"]<0 ){echo "list_remove";}else{echo "list_add";};?> J_add">
    <div class="td_l">
        <p><?php echo (function_types($vo["types"])); ?>: <?php echo ($vo["money"]); ?></p>
                        <?php if($vo[desc] == '快捷支付' && $vo[types] == 1): if($vo[money] < 0): ?><small style="color:#0C0">商家店铺:<?php echo (about_xin('store','store_id='.$vo["order_id"],'store_name','store_name')); ?><span style="color:#f00; padding-left:10px"  onClick="location='<?php echo U("Store/fast_info",array('t_no'=>$vo['order_sn'],'store_id'=>$vo['order_id'],'u_id'=>$vo['user_id']));?>'" >查看</span></small>
                          <?php else: ?>
                            <small style="color:#0C0">支付单号:<?php echo ($vo["order_sn"]); echo ($vo["order_id"]); ?><span style="color:#f00; padding-left:10px"  onClick="location='<?php echo U("Store/fast_info",array('t_no'=>$vo['order_sn'],'store_id'=>$vo['user_id'],'u_id'=>$vo['order_id']));?>'">查看</span></small><?php endif; endif; ?>
    </div>
    <div class="td_r">
        <p class="il_money"><?php echo (jifeng_replace($vo["desc"])); ?></p>
        <p class="time"><?php echo (date('Y-m-d',$vo["change_time"])); ?></p>
    </div>
</li><?php endforeach; endif; ?>