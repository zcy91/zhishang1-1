<?php

//namespace plugins\payment\alipay;
use Think\Model\RelationModel;
/**
 * 支付 逻辑定义
 * Class AlipayPayment
 * @package Home\Payment
 */

class Yue extends RelationModel
{    
    public $tableName = 'plugin'; // 插件表        
    public $alipay_config = array();// 支付宝支付配置参数
    
    /**
     * 析构流函数
     */
    public function  __construct() {   
        parent::__construct();
        
        $paymentPlugin = M('Plugin')->where("code='yue' and  type = 'payment' and scene=1")->find(); // 找到支付插件的配置
        if(!$paymentPlugin){
		  echo "<script>alert('操作不当');history.back();</script>";
		  exit;	
		}
    }    
    /**
     * 生成支付代码
     * @param   array   $order      订单信息
     * @param   array   $config_value    支付方式信息
     */
    function get_code($order, $config_value){

		
	  $user_info=M('users')->where("user_id =".$order['user_id']." and user_money>=".$order['order_amount'])->Field("user_money,pay_points")->find();
	  if(!$user_info){
		  echo "<script>alert('支付失败：您的帐户余额不足');history.back();</script>";
		  exit;	  
	  }
      $orderAll=M('order a')->Field("a.*,(b.user_id) as to_uid")->join('LEFT JOIN ty_store b ON b.store_id=a.store_id')->where("(master_order_sn=".$order["order_sn"]." or order_sn =".$order["order_sn"].")and pay_status!=1")->select();
foreach($orderAll as $val){order_editing($val);}
	  echo "<script>alert('支付成功！');location='".U('Mobile/user/order_list')."';</script>" ;
	  exit;
    }    
}