<?php if (!defined('THINK_PATH')) exit();?>                    <form method="post" enctype="multipart/form-data" target="_blank" id="form-order">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);"></td>
                                    <td class="text-left">
                                        <a href="javascript:sort('user_id');">ID</a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('username');">会员昵称</a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('level');">会员等级</a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('mobile');">手机号码</a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:void(0);">直推</a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:void(0);">间推</a>
                                    </td>
                              
                                    <td class="text-left">
                                        <a href="javascript:void(0);"><?php echo tpCache('distribut.equity_name');?></a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('user_money');">余额</a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('pay_points');"><?php echo tpCache('distribut.hot_jifeng_name');?></a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('cold_points');"><?php echo tpCache('distribut.cold_jifeng_name');?></a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('dai_points');">待释放</a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('total_amount');">累计消费</a>
                                    </td>
                                    <td class="text-left">
                                        <a href="javascript:sort('reg_time');">注册日期</a>
                                    </td>
                                    <td class="text-left">返佣</td>
                                    <td class="text-left">锁定</td>
                                    <td class="text-left">债务</td>
                                    <td class="text-left">商家</td>
                                    <td class="text-right">操作</td>
                                    
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(is_array($userList)): $i = 0; $__LIST__ = $userList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$list): $mod = ($i % 2 );++$i;?><tr>
                                        <td class="text-center">
                                            <input type="checkbox" name="selected[]" value="<?php echo ($list['user_id']); ?>">
                                            <input type="hidden" name="shipping_code[]" value="flat.flat">
                                        </td>
                                        <td align="left" valign="middle" class="text-left"><?php echo ($list["user_id"]); ?></td>
                                      <td class="text-left"><?php if($list[nickname] == null): ?>未填<?php else: echo ($list["nickname"]); endif; ?></td>
                                        <td class="text-left"><?php echo ($level[$list[level]]); ?></td>
                                        <td class="text-left"><?php echo ($list["mobile"]); ?></td>
                                        <td class="text-left"><?php echo ((isset($first_leader[$list[user_id]]['count']) && ($first_leader[$list[user_id]]['count'] !== ""))?($first_leader[$list[user_id]]['count']):"0"); ?>人</td>
                                        <td class="text-left"><?php echo ((isset($second_leader[$list[user_id]]['count']) && ($second_leader[$list[user_id]]['count'] !== ""))?($second_leader[$list[user_id]]['count']):"0"); ?>人</td>
                                        <td class="text-left"><?php echo ($list["equity"]); ?></td>
                                      <td class="text-left"><?php echo ($list["user_money"]); ?></td>
                                        <td class="text-left"><?php echo ($list["pay_points"]); ?></td>
                                        <td class="text-left"><?php echo ($list["cold_points"]); ?></td>
                                        <td class="text-left"><?php echo ($list["dai_points"]); ?></td>
                                        <td class="text-left"><?php echo ($list["total_amount"]); ?></td>
                                        <td class="text-left"><?php echo (date('Y-m-d H:i',$list["reg_time"])); ?></td>
                                        <td class="text-left"><img width="20" height="20" src="/Public/images/<?php if($list[is_fanying] == 1): ?>yes.png<?php else: ?>cancel.png<?php endif; ?>" onclick="changeTableVal('users','user_id','<?php echo ($list["user_id"]); ?>','is_fanying',this)"/></td>
                                        <td class="text-left"><img width="20" height="20" src="/Public/images/<?php if($list[is_lock] == 1): ?>yes.png<?php else: ?>cancel.png<?php endif; ?>" onclick="changeTableVal('users','user_id','<?php echo ($list["user_id"]); ?>','is_lock',this)"/></td>
                                        <td class="text-left"><img width="20" height="20" src="/Public/images/<?php if($list[is_sq] == 1): ?>yes.png<?php else: ?>cancel.png<?php endif; ?>" onclick="changeTableVal('users','user_id','<?php echo ($list["user_id"]); ?>','is_sq',this)"/></td>
                                        <td class="text-left"><img width="20" height="20" src="/Public/images/<?php if($list[is_distribut] == 1): ?>yes.png<?php else: ?>cancel.png<?php endif; ?>"/></td>
                                        
                                      <td class="text-right">
                                            <a href="<?php echo U('Admin/user/detail',array('id'=>$list['user_id']));?>" data-toggle="tooltip" title="查看详情" class="btn btn-info" data-original-title="查看详情"><i class="fa fa-pencil"></i></a>
                                            <a href="<?php echo U('Admin/user/address',array('id'=>$list['user_id']));?>" data-toggle="tooltip" title="收货地址" class="btn btn-info" data-original-title="收货地址"><i class="fa fa-home"></i></a>
                                            <a href="<?php echo U('Admin/order/index',array('user_id'=>$list['user_id']));?>" data-toggle="tooltip" title="会员订单" class="btn btn-info" data-original-title="订单查看"><i class="fa fa-shopping-cart"></i></a>
                                            <a href="<?php echo U('Admin/user/account_log',array('id'=>$list['user_id']));?>" data-toggle="tooltip" title="账户明细" class="btn btn-info" data-original-title="账户"><i class="glyphicon glyphicon-yen"></i></a>
                                            <a href="<?php echo U('Admin/user/delete',array('id'=>$list['user_id']));?>" id="button-delete6" data-toggle="tooltip" title="删除" class="btn btn-danger" data-original-title="删除"><i class="fa fa-trash-o"></i></a>
                                      </td>
                                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-sm-3 text-left">
                        </div>
                        <div class="col-sm-6 text-right"><?php echo ($page); ?></div>
                    </div>
<script>
    $(".pagination  a").click(function(){
        var page = $(this).data('p');
        ajax_get_table('search-form2',page);
    });
</script>