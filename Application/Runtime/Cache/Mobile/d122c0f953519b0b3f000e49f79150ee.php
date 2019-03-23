<?php if (!defined('THINK_PATH')) exit();?>
 <!---晒单end-->
 <script>
 	$(document).ready(function() {
 		$('.comment_littlenav ul li').click(function() {
 			$(this).addClass('com-red').siblings().removeClass('com-red');
 		});
 	});
 </script>
<?php if(count($commentlist) > 0): ?><div class="comment_list" id="commentList"  data-id="0" >
	<ul>
  	<?php if(is_array($commentlist)): foreach($commentlist as $k=>$v): ?><li class="comment_item">
        <div class="content_head" <?php if(($k+1) == count($comment_list)): ?>style="border-bottom:0px solid #dedede;"<?php else: ?>style="border-bottom:1px solid #dedede;"<?php endif; ?>>
	          <div class="info">
	            <div class=" comment_star">
	              <div class="bor_sli">
		              <div class="one"><em><img src="<?php echo ((isset($user['head_pic']) && ($user['head_pic'] !== ""))?($user['head_pic']):" /Template/mobile/new/Static/images/user68.jpg"); ?>"></em></div>
		              <div class="name">
		              		<?php echo ($v['nickname']); ?>
		              </div>
		              <div class="two"><?php echo (date("Y-m-d H:i:s",$v['add_time'])); ?></div>
	              </div>
	              <div class="satr_img"><em><img src="/Template/mobile/new/Static/images/stars<?php echo (ceil($v['goods_rank'])); ?>.png" alt="" /></em></div>
	              <p> <?php echo (htmlspecialchars_decode($v['content'])); ?></p>
					<?php if(strlen($v['pay_time']) > 0): ?><div class="twos">购买日期：<?php echo (date("Y-m-d H:i:s",$v["pay_time"])); ?></div><?php endif; ?>
					<?php if(strlen($v['spec_key_name']) > 0): ?><div class="twos">规格：<?php echo ($v["spec_key_name"]); ?></div><?php endif; ?>
	            </div>
	          </div>
	          
			 <!---晒单-->
			<?php if($v['img'] != ''): ?><div class="sd_img">
					<dl id="gallery">
						<?php if(is_array($v['img'])): foreach($v['img'] as $key=>$v2): ?><dd>
						    	<a href="<?php echo ($v2); ?>"><img src="<?php echo ($v2); ?>" width="100px" heigth="100px"></a>
						    </dd><?php endforeach; endif; ?>
					</dl>
					</div><?php endif; ?>
			<!--管理员回复-->
			<?php if(is_array($replyList)): foreach($replyList as $key=>$val): ?><p style=" color:#F60; border-top:1px dashed #e5e5e5; padding-top:8px; margin-top:10px"><span>管理员<?php echo ($val["username"]); ?>回复：<br></span><?php echo ($val["content"]); ?></p><?php endforeach; endif; ?>
   		</div>
   		<div class="assess-btns">        
   			<a class="assess-like-btn" data-comment-id="<?php echo ($v['comment_id']); ?>" onclick="zan(this);">
   				<i class="assess-btns-icon btn-like-icon like-grey"></i>            
   				<span class="assess-btns-num" id="span_zan_<?php echo ($v['comment_id']); ?>"><?php echo ($v['zan_num']); ?></span>
   			</a>        
   			<a class="assess-reply-btn" <?php if($v['reply_num'] > 0): ?>href="<?php echo U('Mobile/Goods/reply',array('comment_id'=>$v['comment_id']));?>"<?php endif; ?>>
   				<i class="assess-btns-icon btn-reply-icon"></i>            
   				<span class="assess-btns-num"><?php echo ($v['reply_num']); ?></span>
   			</a>
   		</div>
   	  </li><?php endforeach; endif; ?>
	</ul>
<?php else: ?>
	<script>
		ajax_sourch_submit_hide();
	</script>
<div class="comment_list" >
	<div class="score">暂时还没有用户评论</div>
</div><?php endif; ?>
</div>
<?php if(($count > $current_count) AND (count($commentlist) > 5)): ?><div class="getmore" style="font-size:.24rem;text-align: center;color:#888;padding:.25rem .24rem .4rem; clear:both">
		<a href="javascript:void(0)" onClick="ajax_sourch_submit()">点击加载更多</a>
	</div><?php endif; ?>
<script>
	var  page = <?php echo ($p); ?>;
	function ajax_sourch_submit() {
		page += 1;
		$.ajax({
			type: "GET",
			url: "<?php echo U('Mobile/Goods/ajaxComment',array('goods_id'=>$goods_id,'commentType'=>$commentType),'');?>"+"/p/" + page,//+tab,
			success: function (data) {
				if ($.trim(data) == '')
					$('.getmore').hide();
				else
					$("#commentList").append(data);
			}
		});
	}


	$(document).ready(function() {
		 $('.assess-like-btn').click(function() {
		 	$(this).find('.assess-btns-icon').toggleClass('bac-po');
		 });
	})
	/**
	 * 点赞ajax
	 * dyr
	 * @param obj
	 */
	function zan(obj) {
		var comment_id = $(obj).attr('data-comment-id');
		var zan_num = parseInt($("#span_zan_" + comment_id).text());
		$.ajax({
			type: "POST",
			data: {comment_id: comment_id},
			dataType: 'json',
			url: "/index.php?m=Home&c=user&a=ajaxZan",//
			success: function (res) {
				if (res.success) {
					$("#span_zan_" + comment_id).text(zan_num + 1);
				} else {
					alert('只能点赞一次哟~');
				}
			},
			error : function(res) {
				if( res.status == "200"){ // 兼容调试时301/302重定向导致触发error的问题
					alert("请先登录!");
					return;
				}
				alert("请求失败!");
				return;
			}
		});
	}
	function  ajax_sourch_submit_hide(){
		$('.getmore').hide();
	}

</script>