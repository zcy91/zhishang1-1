<?php
/**
 * tpshop 支付宝插件
 * ============================================================================
 * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * ============================================================================
 * Author: IT宇宙人
 * Date: 2015-09-09
 */

//namespace plugins\payment\alipay;

use Think\Model\RelationModel;
/**
 * 支付 逻辑定义
 * Class AlipayPayment
 * @package Home\Payment
 */

class alipayMobile extends RelationModel
{    
    public $tableName = 'plugin'; // 插件表        
    public $alipay_config = array();// 支付宝支付配置参数
    
    /**
     * 析构流函数
     */
    public function  __construct() {   
        parent::__construct();
        
        $paymentPlugin = M('Plugin')->where("code='alipayMobile' and  type = 'payment' ")->find(); // 找到支付插件的配置
        $config_value = unserialize($paymentPlugin['config_value']); // 配置反序列化        

        $this->alipay_config['partner']       = $config_value['alipay_partner'];//合作身份者id，以2088开头的16位纯数字
        $this->alipay_config['seller_id']     = $config_value['alipay_account'];//收款支付宝账号，一般情况下收款账号就是签约账号
        $this->alipay_config['key']	          = $config_value['alipay_key'];//安全检验码，以数字和字母组成的32位字符
        $this->alipay_config['notify_url']	  = "http://www.yjy141319.com/mobile/payment/notifyurl.html" ; //服务器异步通知页面路径 //必填，不能修改
        $this->alipay_config['return_url']	  = "http://www.yjy141319.com/mobile/payment/returnurl.html";  //页面跳转同步通知页面路径
        //$this->alipay_config['notify_url'] = "http://www.yjy141319.com/plugins/payment/alipayMobile/notify_url.php";
        //$this->alipay_config['return_url'] = "http://www.yjy141319.com/plugins/payment/alipayMobile/return_url.php";
        $this->alipay_config['sign_type']     = strtoupper('MD5');//签名方式 不需修改
        $this->alipay_config['input_charset'] = strtolower('utf-8');//字符编码格式 目前支持 gbk 或 utf-8
        $this->alipay_config['cacert']        = getcwd().'\\plugins\payment\alipayMobile\cacert.pem';; //ca证书路径地址，用于curl中ssl校验 //请保证cacert.pem文件在当前文件夹目录中
        $this->alipay_config['transport']     = 'http';//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        $this->alipay_config['payment_type'] = "1";
        $this->alipay_config['service'] = "alipay.wap.create.direct.pay.by.user";
    }    
    /**
     * 生成支付代码
     * @param   array   $order      订单信息
     * @param   array   $config_value    支付方式信息
     */
    function get_code($order, $config_value)
    {         

            //构造要请求的参数数组，无需改动
            $parameter = array(
                        "service"       => $this->alipay_config['service'],   // // 产品类型，无需修改       
                        "partner"       => $this->alipay_config['partner'], //合作身份者ID，签约账号，以2088开头由16位纯数字组成的字符串，查看地址：https://b.alipay.com/order/pidAndKey.htm
                        'seller_id'     => $this->alipay_config['partner'], //收款支付宝账号，以2088开头由16位纯数字组成的字符串，一般情况下收款账号就是签约账号
						"payment_type"  =>$this->alipay_config['payment_type'], // 支付类型 ，无需修改                                    
                        "notify_url"	=> $this->alipay_config['notify_url'] , //服务器异步通知页面路径 //必填，不能修改
                        "return_url"	=> $this->alipay_config['return_url'],  //页面跳转同步通知页面路径
                        "_input_charset"=> $this->alipay_config['input_charset'], //字符编码格式 目前支持 gbk 或 utf-8
                        "out_trade_no"	=> $order['order_sn'], //商户订单号
                        "subject"       =>"1+1网络科技", //订单名称，必填
                        "total_fee"	    => $order['order_amount'], //付款金额
                        "show_url"	    => "http://www.yjy141319.com", //收银台页面上，商品展示的超链接，必填
						"body"	        => '余额充值',
                    );
					
            //建立请求
            require_once("lib/alipay_submit.class.php");            
            $alipaySubmit = new AlipaySubmit($this->alipay_config);
            $html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");			
            return $html_text;         
    }
    
    /**
     * 服务器点对点响应操作给支付接口方调用
     * 
     */
    function response()
    {                
        require_once("lib/alipay_notify.class.php");  // 请求返回
        //计算得出通知验证结果
        $alipayNotify = new AlipayNotify($this->alipay_config); // 使用支付宝原生自带的累 和方法 这里只是引用了一下 而已
        $verify_result = $alipayNotify->verifyNotify();
        file_put_contents('./log/'.date("Y-m-d").".txt", date("Y-m-d h:i:s")."支付宝支付：".print_r($_POST, true).PHP_EOL); 
            if($verify_result) //验证成功
            {
                    $order_sn = $out_trade_no = $_POST['out_trade_no']; //商户订单号                    
                    $trade_no = $_POST['trade_no']; //支付宝交易号                   
                    $trade_status = $_POST['trade_status']; //交易状态
					$total_fee=$_POST['total_fee'];// 实际支付金额
                  
				    // 支付宝解释: 交易成功且结束，即不可再做任何操作。
					file_put_contents('./log/'.date("Y-m-d").".txt", date("Y-m-d h:i:s")."支付宝支付：".print_r($_POST, true).PHP_EOL, FILE_APPEND); 

                    if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS'){ 
		$order_info=M('order')->field('sum(total_amount) as total,fangshi,sum(integral_money) as money')->where("(order_sn='$order_sn' or master_order_sn = '$order_sn') and pay_status=1")->find();
        $total=($order_info["fangshi"]==1)?$order_info["total"]:$order_info["total"]-$order_info["money"];
		               if($total==$total_fee){
					        update_pay_status($order_sn); // 修改订单支付状
					   }else{
						    file_put_contents('./log/'.date("Y-m-d").".txt",date("Y-m-d h:i:s")."金额不符:".$trade_no.':'.$total_fee.'->'.$order_sn.':'.$total.PHP_EOL,FILE_APPEND);     
					   }
						  
                    }
                    echo "success"; // 告诉支付宝处理成功
            }
            else 
            {                
                echo "fail"; //验证失败                                
            }
    }
    
    /**
     * 页面跳转响应操作给支付接口方调用
     */
    function respond2()
    {
        require_once("lib/alipay_notify.class.php");  // 请求返回
        //计算得出通知验证结果
        $alipayNotify = new AlipayNotify($this->alipay_config);

        $verify_result = $alipayNotify->verifyReturn();


            if($verify_result){ //验证成功
                    $order_sn = $out_trade_no = $_GET['out_trade_no']; //商户订单号
                    $trade_no = $_GET['trade_no']; //支付宝交易号                   
                    $trade_status = $_GET['trade_status']; //交易状态
                    if($_GET['trade_status'] == 'TRADE_FINISHED' || $_GET['trade_status'] == 'TRADE_SUCCESS') 
                    {  
	               	$order_info=M('order')->field('sum(total_amount) as total,fangshi,sum(integral_money) as money')->where("(order_sn='$order_sn' or master_order_sn = '$order_sn') and pay_status=1")->find();
                     $total=($order_info["fangshi"]==1)?$order_info["total"]:$order_info["total"]-$order_info["money"];
		               if($total==$total_fee){
					        update_pay_status($order_sn); // 修改订单支付状
							 return array('status'=>1,'order_sn'=>$order_sn);//跳转至成功页面
					   }else{
						    file_put_contents('./log/'.date("Y-m-d").".txt",date("Y-m-d h:i:s")."金额不符:".$trade_no.':'.$total_fee.'->'.$order_sn.':'.$total.PHP_EOL,FILE_APPEND);     
					   }
					                         
                      
                    }else {                        
                       return array('status'=>0,'order_sn'=>$order_sn); //跳转至失败页面
                    }                       
            }
            else 
            {                     
                return array('status'=>0,'order_sn'=>$_GET['out_trade_no']);//跳转至失败页面
            }
    }
    
}