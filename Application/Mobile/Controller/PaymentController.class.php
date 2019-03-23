<?php
/**
 * tpshop
 * ============================================================================
 * * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * ============================================================================
 * $Author: IT宇宙人 2015-08-10 $
 */ 
namespace Mobile\Controller;
class PaymentController extends MobileBaseController {
    
    public $payment; //  具体的支付类
    public $pay_code; //  具体的支付code
 
    /**
     * 析构流函数
     */
    public function  __construct() {   
        parent::__construct();                                                  
        // tpshop 订单支付提交
        $pay_radio = $_REQUEST['pay_radio'];
        if(!empty($pay_radio)) 
        {                         
            $pay_radio = parse_url_param($pay_radio);
            $this->pay_code = $pay_radio['pay_code']; // 支付 code
        }
        else // 第三方 支付商返回
        {            
            $_GET = I('get.');            
            //file_put_contents('./a.html',$_GET,FILE_APPEND);    
            $this->pay_code = "alipayMobile";
            //unset($_GET['pay_code']); // 用完之后删除, 以免进入签名判断里面去 导致错误
        }                        
        //获取通知的数据
        $xml = $GLOBALS['HTTP_RAW_POST_DATA'];               
        // 导入具体的支付类文件                
        include_once  "plugins/payment/{$this->pay_code}/{$this->pay_code}.class.php"; // D:\wamp\www\svn_tpshop\www\plugins\payment\alipay\alipayPayment.class.php                       
        $code = '\\'.$this->pay_code; // \alipay
        $this->payment = new $code();
    }
   
    /**
     * tpshop 提交支付方式
     */
    public function getCode(){     
        
            C('TOKEN_ON',false); // 关闭 TOKEN_ON
            header("Content-type:text/html;charset=utf-8");    
            // 修改订单的支付方式
            $payment_arr = M('Plugin')->where("`type` = 'payment'")->getField("code,name");            
            $order_id = I('order_id',0); // 订单id                        
            $master_order_sn = I('master_order_sn','');// 多单付款的 主单号

            if(I('post.fangshi')!=1 and  I('post.fangshi')!=2){
				 $this->error('请选择'.tpCache('distribut.jifeng_name').'使用方式...');
			}
			$bili=tpCache('distribut.point_rate');//获取比例
            // 如果是主订单号过来的, 说明可能是合并付款的
            if($master_order_sn)
            {
                M('order')->where("master_order_sn = '$master_order_sn'")->save(array('pay_code'=>$this->pay_code,'pay_name'=>$payment_arr[$this->pay_code]));            
				$jifeng = M('order_goods b')->field('sum((b.integral_money*b.goods_num)) as give_integral,sum(b.gift_jifeng_money*goods_num) as deduction')->where("b.order_id in(SELECT order_id AS tp_sum FROM ty_order WHERE (master_order_sn = ".$master_order_sn."))")->find();
				$give_integral=number_format(($jifeng['give_integral']*$bili),2,'.','');
				$deduction=number_format(($jifeng['deduction']*$bili),2,'.','');
				//这里处理
				$orderAll = M('order a')->Field("a.order_id,a.order_sn,a.master_order_sn,a.store_id,b.store_name")->join('LEFT JOIN ty_store b ON b.store_id = a.store_id')->where("master_order_sn = '$master_order_sn'")->select();
	
				foreach($orderAll as $val){
				   $j_f = M('order_goods b')->field('sum((b.integral_money*b.goods_num)) as a_give,sum(b.gift_jifeng_money*goods_num) as b_dedu')->where("b.order_id =".$val['order_id'])->find(); 
				   $a_give=number_format(($j_f['a_give']*$bili),2,'.','');
				   $b_dedu=number_format(($j_f['b_dedu']*$bili),2,'.','');  
				   M('order')->where("order_id =".$val['order_id'])->save(array('integral'=>$a_give,'integral_money'=>$j_f['a_give'],'gift_jifeng'=>$b_dedu,'gift_jifeng_money'=>$j_f['b_dedu'],'fangshi'=>I('post.fangshi')));
				   if(I('post.fangshi')==1){
				      //赠送积分查询
				     $pay_points=M('users')->where("user_id =(SELECT user_id  FROM ty_store WHERE store_id = ".$val['store_id'].") and pay_points>=".$b_dedu)->getField("pay_points");
				     if(!$pay_points){$this->error('支付失败:店铺-->'.$val['store_name'].'可赠'.tpCache('distribut.jifeng_name').'不足!');}
			       }
				}

                $order = M('order')->where("master_order_sn = '$master_order_sn'")->find();
			    $order['order_sn'] = $master_order_sn; // 临时修改 给支付宝那边去支付
				$order['order_amount'] = M('order')->where("master_order_sn = '$master_order_sn'")->sum('order_amount'); // 临时修改 给支付宝那边去支付
				if(I('post.fangshi')==2){
                  $order['order_amount'] = M('order')->where("master_order_sn = '$master_order_sn'")->sum('order_amount-integral_money'); // 临时修改 给支付宝那边去支付
				}
            }else{		      
                $order = M('order')->where("order_id = $order_id")->find(); 
				//更新积分使用方式
				$jifeng = M('order_goods b')->field('sum((b.integral_money*b.goods_num)) as give_integral,sum(b.gift_jifeng_money*goods_num) as deduction')->where("b.order_id = $order_id")->find(); 
				$give_integral=number_format(($jifeng['give_integral']*$bili),2,'.','');
				$deduction=number_format(($jifeng['deduction']*$bili),2,'.','');
				M('order')->where("order_id = $order_id")->save(array('integral'=>$give_integral,'integral_money'=>$jifeng['give_integral'],'gift_jifeng'=>$deduction,'gift_jifeng_money'=>$jifeng['deduction'],'fangshi'=>I('post.fangshi'),'pay_code'=>$this->pay_code,'pay_name'=>$payment_arr[$this->pay_code]));
			    if(I('post.fangshi')==1){
				   //赠送积分查询
				   $pay_points=M('users')->where("user_id =(SELECT user_id  FROM ty_store WHERE store_id = ".$order['store_id'].") and pay_points>=".$give_integral)->getField("user_id");
				   //print_r(M()->getLastSql());
				   if(!$pay_points){$this->error('支付失败：此店铺可赠'.tpCache('distribut.jifeng_name').'不足!');}
			    }else{
				   $order['order_amount'] = M('order')->where("order_id = $order_id")->sum('order_amount-integral_money'); // 临时修改 给支付宝那边去支付	
				}
            }
            $order['fangshi']=I('post.fangshi');
			if(I('post.fangshi')==2){
				//抵扣积分查询
				$pay_points=M('users')->where("user_id =".$order['user_id']." and pay_points>=".$deduction)->getField("user_id");
				if(!$pay_points){$this->error('支付失败：您的帐户'.tpCache('distribut.jifeng_name').'不足!');}
			}

            if($order['pay_status'] == 1){
            	$this->error('此订单，已完成支付!');
            }

            $code_str = $this->payment->get_code($order,'');
			
           $this->assign('code_str', $code_str); 
           $this->assign('order_id', $order_id);
           $this->assign('master_order_sn', $master_order_sn); // 主订单号
		
           $this->display('payment');  // 分跳转 和不 跳转 
    }
    public function getPay(){
       	//手机端在线充值
        C('TOKEN_ON',false); // 关闭 TOKEN_ON 
        header("Content-type:text/html;charset=utf-8");
        $order_id = I('order_id'); //订单id
        $user = session('user');
        $data['account'] = I('account');
		
		
        if($order_id>0){
        	M('recharge')->where(array('order_id'=>$order_id,'user_id'=>$user['user_id']))->save($data);
        }else{
        	$data['user_id'] = $user['user_id'];
        	$data['nickname'] = $user['nickname'];
        	$data['order_sn'] = 'recharge'.get_rand_str(10,0,1);
        	$data['ctime'] = time();

        	$order_id = M('recharge')->add($data);
        }
        if($order_id){
        	$order = M('recharge')->where("order_id = $order_id")->find();
        	if(is_array($order) && $order['pay_status']==0){
        		$order['order_amount'] = $order['account'];
        		$pay_radio = $_REQUEST['pay_radio'];
        		$config_value = parse_url_param($pay_radio); // 类似于 pay_code=alipay&bank_code=CCB-DEBIT 参数
        		$payment_arr = M('Plugin')->where("`type` = 'payment'")->getField("code,name");
        		M('recharge')->where("order_id = $order_id")->save(array('pay_code'=>$this->pay_code,'pay_name'=>$payment_arr[$this->pay_code]));       		
        		//微信JS支付
        		if($this->pay_code == 'weixin' && $_SESSION['openid'] && strstr($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
        			$code_str = $this->payment->getJSAPI($order);
        			exit($code_str);
        		}else{
        			$code_str = $this->payment->get_code($order,$config_value);
        		}
        	}else{
        		$this->error('此充值订单，已完成支付!');
        	}
        }else{
        	$this->error('提交失败,参数有误!');
        }
        $this->assign('code_str', $code_str); 
        $this->assign('order_id', $order_id); 
    	$this->display('recharge'); //分跳转 和不 跳转
    }

        // 服务器点对点 // http://www.tp-shop.cn/index.php/Home/Payment/notifyUrl        
        public function notifyUrl(){            
            $this->payment->response();            
            exit();
        }

        // 页面跳转 // http://www.tp-shop.cn/index.php/Home/Payment/returnUrl        
        public function returnUrl(){
             $result = $this->payment->respond2(); // $result['order_sn'] = '201512241425288593';    

             if(stripos($result['order_sn'],'recharge') !== false)
             {
             	$order = M('recharge')->where("order_sn = '{$result['order_sn']}'")->find();
				
             	$this->assign('order', $order);
             	if($result['status'] == 1)
             		$this->display('recharge_success');
             	else
             		$this->display('recharge_error');
             	exit();
             }             
            // 先查看一下 是不是 合并支付的主订单号
             $sum_order_amount = M('order')->where("master_order_sn = '{$result['order_sn']}'")->sum('order_amount');
             if($sum_order_amount)
             {
                $this->assign('master_order_sn', $result['order_sn']); // 主订单号
                $this->assign('sum_order_amount', $sum_order_amount); // 所有订单应付金额                        
             }
             else
             {
                $order = M('order')->where("order_sn = '{$result['order_sn']}'")->find();
                $this->assign('order', $order);
             }            
             
            if($result['status'] == 1)
                $this->display('success');   
            else
                $this->display('error');   
        }                
              
}
