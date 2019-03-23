<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=no">
		<meta name="format-detection" content="telephone=no,email=no,adress=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-touch-fullscreen" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
		<title>申请已提交</title>
		<link rel="stylesheet" href="/Template/mobile/new/Static/zs/css/base.css">
		<link rel="stylesheet" type="text/css" href="/Template/mobile/new/Static/zs/css/shop_enter_comm.css" />
		<link rel="stylesheet" href="/Template/mobile/new/Static/css/public.css">
		<style>
			.input_content > .input_content_waitconform_tip{
				text-align: center;
				margin-top: 0.5rem;
				color: rgb(102,102,102);
			}
		</style>
	</head>
	<body>
		<div class="head" style="width: 100%;height: 45px;border-bottom: 1px solid #ccc;">
			<div class="tab_nav">
				<div class="header">
					<div class="h-left">
						<!--<a class="sb-back" href="javascript:history.back(-1)" title="返回"></a>-->
					</div>
					<div class="h-mid">公司信息</div>
					<div class="h-right">
						<!--<aside class="top_bar">-->
						<!--<div onClick="show_menu();$('#close_btn').addClass('hid');" id="show_more"><a href="javascript:;"></a> </div>-->
						<!--</aside>-->
					</div>
				</div>
			</div>

		</div>
		<div class="container">
			<div class="join_step">
				<div class="join_step_content">
					<div class="join_step_content_ico">
						<i class="j_i_n j_i_on b_radius_50">1</i>
						<i class="j_i_h j_i_on"></i>
						<i class="j_i_n j_i_on b_radius_50">2</i>
						<i class="j_i_h j_i_on"></i>
						<i class="j_i_n j_i_on b_radius_50">3</i>
					</div>
					<div class="join_step_content_instr clear">
						<p class="p_on">入驻须知</p>
						<p class="p_on">店铺信息</p>
						<p class="p_on">等待审核</p>
					</div>
				</div>
			</div>
			<div class="other_content">
				<div class="user_tip">
					<h3></h3>
				</div>
				<div class="input_content">
					<p class="input_content_waitconform_tip">入驻申请已提交，请等待管理员审核</p>
				</div>
				<div class="input_next_step">
					<a href="/index.php?s=/Mobile/Index/index.html">返回首页</a>
				</div>
			</div>
		</div>
		<input type="hidden" id="ajax_submit" interface="" submit-type="post">

		<script type="text/javascript" src="/Template/mobile/new/Static/zs/js/zepto/zepto.js"></script>
		<script type="text/javascript" src="/Template/mobile/new/Static/zs/js/zepto/event.js"></script>
		<script type="text/javascript" src="/Template/mobile/new/Static/zs/js/zepto/selector.js"></script>
		<script type="text/javascript" src="/Template/mobile/new/Static/zs/js/zepto/touch.js"></script>
		<script type="text/javascript" src="/Template/mobile/new/Static/zs/js/zepto/ajax.js"></script>
		<script type="text/javascript" src="/Template/mobile/new/Static/zs/js/shop_enter_comm.js"></script>
		<script type="text/javascript">
			$(function() {
				

			});
		</script>
	</body>
</html>