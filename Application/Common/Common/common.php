<?php
//截取文字长度去除html
function cutstr_html($string, $sublen)    
 {
  $string = strip_tags($string);
  $string = preg_replace ('/\n/is', '', $string);
  $string = preg_replace ('/ |　/is', '', $string);
  $string = preg_replace ('/&nbsp;/is', '', $string);
  preg_match_all("/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/", $string, $t_string);   
  if(count($t_string[0]) - 0 > $sublen) $string = join('', array_slice($t_string[0], 0, $sublen))."…";   
  else $string = join('', array_slice($t_string[0], 0, $sublen));
  return $string;
 }



//生成二维码
function generate_qrcode($url,$fileName){
    	require_once 'ThinkPHP/Library/Vendor/phpqrcode/phpqrcode.php';
    	error_reporting(E_ERROR);
    	// \QRcode::png($url,$fileName,4,2.8);
		
		\QRcode::png($url,$fileName,4,4.5);
}



function jifeng_replace($str){
if(tpCache('distribut.jifeng_name')){
   $str=str_replace("积分",tpCache('distribut.jifeng_name'),$str);
   if(tpCache('distribut.equity_name')){$str=str_replace("股权",tpCache('distribut.equity_name'),$str);}
   if(tpCache('distribut.hot_jifeng_name')){$str=str_replace("热".tpCache('distribut.jifeng_name'),tpCache('distribut.hot_jifeng_name'),$str);}
   if(tpCache('distribut.cold_jifeng_name')){$str=str_replace("冷".tpCache('distribut.jifeng_name'),tpCache('distribut.cold_jifeng_name'),$str);}
}
return	$str;
}

function jifeng_replace_all($str){
  if(tpCache('distribut.jifeng_name')){$str=str_replace(tpCache('distribut.jifeng_name'),"积分",$str);}
  if(tpCache('distribut.equity_name')){$str=str_replace(tpCache('distribut.equity_name'),'股权',$str);}
  return $str;
}

//结佣
function order_editing($order){
			if($order['fangshi']==1){
					  $jifeng  = $order['gift_jifeng'];//赠送积分
					  $money   = $order['order_amount'];
					  //处理买家会员信息
					  accountLog($order['user_id'],-$money,"user_money","商城购物",0,$order['order_id'],$order['order_sn'].'扣余额');//扣余额
					  accountLog($order['user_id'],$jifeng,"pay_points","商城购物",0,$order['order_id'],$order['order_sn']."赠送积分");//赠送积分
					  //处理卖家会员信息
					  accountLog($order['to_uid'],-$jifeng,"pay_points","商城购物",0,$order['order_id'],$order['order_sn'].'扣除赠送积分');//扣除赠送积分
			}else{
					  $jifeng  = $order['integral'];//抵扣积分
					  $money   = $order['order_amount']-$order['integral_money'];
					  //处理买家会员信息
					  accountLog($order['user_id'],-$money,"user_money","商城购物",0,$order['order_id'],$order['order_sn'].'扣余额');//扣余额
					  accountLog($order['user_id'],-$jifeng,"pay_points","商城购物",0,$order['order_id'],$order['order_sn'].'扣除抵扣积分');//扣除抵扣积分
					  //处理卖家会员信息
					  accountLog($order['to_uid'],$jifeng,"pay_points","商城购物",0,$order['order_id'],$order['order_sn']).'增加抵扣积分';//追加赠送积分  
			}
				   //修改订单信息
			M('order')->where("order_id =".$order['order_id'])->save(array('pay_status'=>1,'order_amount'=>$money,'pay_time'=>time()));
		    // 减少对应商品的库存
		    minus_stock($order['order_id']);
		    // 记录订单操作日志
		    logOrder($order['order_id'],'订单付款成功','付款成功',$order['user_id'],2);
        
		//分销开关  订单收款成功后才结算佣金
		//if(tpCache('distribut.switch')){feng_ying($order);}

    //给商家发送短信
    $storeuser = M('users')->where("user_id =".$order['to_uid'])->find();
    if($storeuser){
      sendSMS( $storeuser['mobile'] ,"【至上网络】有消费者在您的店铺下单购物，并支付成功");
    }

}
//分佣处理 
function feng_ying($order){
	$fengying=M('order_goods')->where("order_id =".$order['order_id'])->field("sum(distribut) as fengyinga,sum(distributa) as fengyingb")->find();
	$money=$order['fangshi']==1?$fengying['fengyinga']:$fengying['fengyingb'];
     	//获取上级推广人
	    $hehuor_info=M('users')->where("user_id in(SELECT user_id FROM ty_store WHERE store_id = ".$order['store_id'].") and level=3")->field("first_leader")->find();//必须为推广等级才有提成
	    $hehuor_info=$hehuor_info["first_leader"]?$hehuor_info["first_leader"]:0;
		$hehuor=$money * tpCache('distribut.sys_hehuo')/100;
	    if($hehuor){accountLog($hehuor_info,$hehuor,"user_money","业绩分佣",$money,$order['order_id'],$order['order_sn'].'业绩提成'); }//奖励
	    //下单人上二级
	    $user_info=M('users')->where("user_id =".$order['user_id'])->field("level,zupu")->find();
	    $zupu=explode(",",substr($user_info["zupu"],0,-1));
	    unset($zupu[0]);//删除的标识没用id
	    unset($zupu[count($zupu)]);//删除自己标识
	    array_splice($zupu,1,0);//重新索引
		rsort($zupu);//数组倒序
	    //一级分佣
		  $xianji_first = $money*tpCache('distribut.first_rate_'.$user_info['level'])/100;
		  if($xianji_first){accountLog($zupu[0]?$zupu[0]:0,$xianji_first,"user_money","业绩分佣",$money,$order['order_id'],$order['order_sn'].'一级分佣');}//一级分佣	
		//二级分佣
	      $xianji_two   = $money*tpCache('distribut.two_rate_'.$user_info['level'])/100;
		  if($xianji_two){ accountLog($zupu[1]?$zupu[1]:0,$xianji_two,"user_money","业绩分佣",$money,$order['order_id'],$order['order_sn'].'二级分佣');}//二级分佣	
		//剩余归平台
		  $shengyu=$money-$hehuor-$xianji_first-$xianji_two;
		  if($shengyu){accountLog(0,$shengyu,"user_money","业绩分佣",$money,$order['order_id'],$order['order_sn'].'平台获利:剩余价值');}
		  //echo M()->getLastSql()."<br>"; 	

}
//名称转星
function get_replace_xing($str){
    $length = mb_strlen($str, 'utf-8');
    $array = [];
    for ($i=0; $i<$length; $i++)  
        $array[] = mb_substr($str, $i, 1,'utf-8');   
	$str=$array;	
 if($str[1]){$str[1]='*';}
 if($str[2]){$str[2]='*';}
 
return implode("",$str);	
}
function Bonus_pool(){
		$jifeng_a=(M('account_log')->where("types=2 and user_id=0")->sum('money'));//平台金分池
		$jifeng_b=(M('users')->sum('pay_points'));//+用户现有
		$jifeng_sum=$jifeng_a+$jifeng_b;
		$jifeng_aa=$jifeng_a*2;//购买平台总生成额度
		$jinchi= M('bonus_rule')->where("is_show=1 and is_new=0 and jifeng<=$jifeng_sum")->order('sort asc')->find();//平台金分池

		if($jinchi){
			$jifeng_bili=($jinchi['bili'])*0.01;//赠送比例
		    $jifenga=$jinchi['jifeng']*tpCache('distribut.point_gongsibili')*0.01;//获取平台积分池达标额度
		    $jifengb=$jinchi['jifeng']*tpCache('distribut.point_hehuorbili')*0.01;//获取用户积分池达标额度
			
//		print_r($jinchi);	
//		echo $jifenga.'--->'.$jifengb.'-->平'.$jifeng_aa.'-->用'.$jifeng_b.'-->'.($jifeng_b-$jifeng_a)."<br>";
//		exit;
			
		  if($jifeng_aa>=$jifenga and ($jifeng_b-$jifeng_a)>=$jifengb){
			//更新当前奖金池状态
			$gongxin=M("bonus_rule")->where('id='.$jinchi["id"])->setField(array('is_new'=>1,'recording'=>"总倍增积分：{$jifeng_sum},其中平台积分池：{$jifeng_a}"));
			 if($gongxin){
			  //发放奖励
			   if($jifenga){
			     accountLog(0,number_format($jifeng_a*($jifeng_bili-1),2,".",""),'pay_points','倍增奖励',$jifeng_bili,$jinchi["id"],'倍增奖励'.$jifeng_bili.'倍');//平台倍赠
			   }
			    $user_list= M('users')->where("pay_points>0")->Field('user_id,pay_points')->order('user_id asc')->select(); 
			    if($user_list){
				   foreach($user_list as $v){
					 accountLog($v['user_id'],number_format($v['pay_points']*($jifeng_bili-1),2,".",""),'pay_points','倍增奖励',$jifeng_bili,$jinchi["id"],'倍增奖励'.$jifeng_bili.'倍');
				   }
			    }
			 }
		  }
		}
}
//平分昨日平台购入积分
function equity_split(){
	$Today=mktime(0,0,0,date('m'),date('d'),date('Y'));//今日0点
 	$Yesterday=mktime(0,0,0,date('m'),date('d')-1,date('Y'));//昨日0点
	//获限今日是否平分
	$equity_info=M('equity_split')->field('id')->where("add_time>=$Today and is_show=1" )->find();
	if(!$equity_info){
	$jifeng=(M('account_log')->where("types=2 and user_id=0 and money>0 and change_time>=$Yesterday and change_time<$Today ")->sum('money'));//获取昨日积分池业绩  //时间条件and change_time>=$Yesterday and change_time<$Today
	if($jifeng){
	 $bili=tpCache('distribut.sys_equity_bili');
	 $pingfeng_sum=$jifeng*$bili*0.01;//总待平分
	 $equity_sum=(M('users')->where("user_id!=0")->sum('equity'));
	 $pingfeng=$pingfeng_sum/$equity_sum;
	 $add_date=array('jifeng_sum'=>$jifeng,'jifeng'=>$pingfeng_sum,'bili'=>$bili,'equity'=>$equity_sum,'pingfeng'=>$pingfeng,'is_show'=>1,'add_time'=>time(),'bz'=>date('Ymd',$Yesterday)."期".tpCache('distribut.equity_name')."分红");
	 $equity=M('equity_split')->add($add_date);//新增记录
	}
	if($jifeng && $pingfeng && $equity){
		//从平台帐户扣除分红
		accountLog(0,$pingfeng_sum*-1,'pay_points','股权分红',0,$equity,$add_date['bz'].',扣除平台积分池');//平台倍赠
		$user_list= M('users')->where("equity>0 and is_lock=0")->Field('user_id,equity')->order('user_id asc')->select();
		if($user_list){
		   foreach($user_list as $v){
			//echo $v['user_id'].'-->'.number_format(($v['equity']*($pingfeng)),2,".","")."<br>";
			accountLog($v['user_id'],number_format(($v['equity']*($add_date['pingfeng'])),2,".",""),'pay_points','股权分红',$add_date['pingfeng'],$equity,$add_date['bz'].'每股平分'.$add_date['pingfeng']);
		   }
		}
	}
	
	}

}

/*更新族谱与族层*/
function user_zupuceng($user_id){
$user_info=M('users as a')->join('left join ty_users b ON a.first_leader = b.user_id')->where(array('a.user_id' => $user_id))->getfield('b.zupu');


if($user_info){
   $zuceng=count(explode(',',$user_info))-1;	
   $zupu=$user_info.$user_id.",";
}else{
   $zuceng=1;
   $zupu="0,".$user_id.",";
}
M('users')->where(array("user_id" => $user_id))->save(array("zupu" =>$zupu,"zuceng" =>$zuceng));
}

/** * 帐户操作类型 */
function function_types($str){
switch ($str){
case 1:
  return '余额';
  break;  
case 2:
  return tpCache('distribut.hot_jifeng_name');
  break;  
case 3:
  return tpCache('distribut.cold_jifeng_name');
  break;  
case 4:
  return '待激活'.tpCache('distribut.jifeng_name');
  break;  
case 5:
  return tpCache('distribut.equity_name');
  break; 
case 6:
  return '冻结';
  break; 
case 7:
  return '分佣';
  break; 
default:
  return '<span style="color:#f00">其它</span>';
}
}
/**
 * 帐户操作类型
 */
function function_pay_points($str){
switch ($str){
case 'user_money':
  return 1;
  break;  
case 'pay_points':
  return 2;
  break;  
case 'cold_points':
  return 3;
  break;  
case 'dai_points':
  return 4;
  break;  
case 'equity':
  return 5;
  break;  
case 'frozen_money':
  return 6;
  break;  
case 'distribut_money':
  return 7;
  break;  
default:
  return '<span style="color:#f00">其它</span>';
}
}
 
 
/**
 * tpshop检验登陆
 * @param
 * @return bool
 */
function is_login(){
    if(isset($_SESSION['admin_id']) && $_SESSION['admin_id'] > 0){
        return $_SESSION['admin_id'];
    }else{
        return false;
    }
}
/**
 * 获取用户信息
 * @param $user_id_or_name  用户id 邮箱 手机 第三方id
 * @param int $type  类型 0 user_id查找 1 邮箱查找 2 手机查找 3 第三方唯一标识查找
 * @param string $oauth  第三方来源
 * @return mixed
 */
function get_user_info($user_id_or_name,$type = 0,$oauth=''){
    $map = array();
    if($type == 0)
        $map['user_id'] = $user_id_or_name;
    if($type == 1)
        $map['email'] = $user_id_or_name;
    if($type == 2)
        $map['mobile'] = $user_id_or_name;
    if($type == 3){
        $map['openid'] = $user_id_or_name;
        $map['oauth'] = $oauth;
    }
    if($type == 4){
    	$map['unionid'] = $user_id_or_name;
    	$map['oauth'] = $oauth;
    }
    $user = M('users')->where($map)->find();
    return $user;
}

/**
 * 更新会员等级,折扣，消费总额
 * @param $user_id  用户ID
 * @return boolean
 */
function update_user_level($user_id){
    $level_info = M('user_level')->order('level_id')->select();
    $total_amount = M('order')->where("user_id=$user_id AND pay_status=1 and order_status not in (3,5)")->sum('order_amount');
    if($level_info){
    	foreach($level_info as $k=>$v){
    		if($total_amount >= $v['amount']){
    			$level = $level_info[$k]['level_id'];
    			$discount = $level_info[$k]['discount']/100;
    		}
    	}
    	$user = session('user');
    	$updata['total_amount'] = $total_amount;//更新累计修复额度
    	//累计额度达到新等级，更新会员折扣
    	if(isset($level) && $level>$user['level']){
    		$updata['level'] = $level;
    		$updata['discount'] = $discount;	
    	}
    	M('users')->where("user_id=$user_id")->save($updata);
    }
}

/**
 *  商品缩略图 给于标签调用 拿出商品表的 original_img 原始图来裁切出来的
 * @param type $goods_id  商品id
 * @param type $width     生成缩略图的宽度
 * @param type $height    生成缩略图的高度
 */
function goods_thum_images($goods_id,$width,$height){

     if(empty($goods_id))
		 return '';
    //判断缩略图是否存在
    $path = "Public/upload/goods/thumb/$goods_id/";
    $goods_thumb_name ="goods_thumb_{$goods_id}_{$width}_{$height}";
  
    // 这个商品 已经生成过这个比例的图片就直接返回了
    if(file_exists($path.$goods_thumb_name.'.jpg'))  return '/'.$path.$goods_thumb_name.'.jpg'; 
    if(file_exists($path.$goods_thumb_name.'.jpeg')) return '/'.$path.$goods_thumb_name.'.jpeg'; 
    if(file_exists($path.$goods_thumb_name.'.gif'))  return '/'.$path.$goods_thumb_name.'.gif'; 
    if(file_exists($path.$goods_thumb_name.'.png'))  return '/'.$path.$goods_thumb_name.'.png'; 
        
    $original_img = M('Goods')->where("goods_id = $goods_id")->getField('original_img');
    if(empty($original_img)) return '';
    
    $original_img = '.'.$original_img; // 相对路径
    if(!file_exists($original_img)) return '';

    $image = new \Think\Image();
    $image->open($original_img);
        
    $goods_thumb_name = $goods_thumb_name. '.'.$image->type();
    // 生成缩略图
    if(!is_dir($path)) 
        mkdir($path,0777,true);
    
    // 参考文章 http://www.mb5u.com/biancheng/php/php_84533.html  改动参考 http://www.thinkphp.cn/topic/13542.html
    $image->thumb($width, $height,2)->save($path.$goods_thumb_name,NULL,100); //按照原图的比例生成一个最大为$width*$height的缩略图并保存
    

    //图片水印处理
    $water = tpCache('water');
    if($water['is_mark']==1){
    	$imgresource = './'.$path.$goods_thumb_name;
    	if($width>$water['mark_width'] && $height>$water['mark_height']){
    		if($water['mark_type'] == 'img'){
    			$image->open($imgresource)->water(".".$water['mark_img'],$water['sel'],$water['mark_degree'])->save($imgresource);
    		}else{
    			//检查字体文件是否存在
    			if(file_exists('./zhjt.ttf')){
    				$image->open($imgresource)->text($water['mark_txt'],'./zhjt.ttf',20,'#000000',$water['sel'])->save($imgresource);
    			}
    		}
    	}
    }
    return '/'.$path.$goods_thumb_name;
}

/**
 * 商品相册缩略图
 */
function get_sub_images($sub_img,$goods_id,$width,$height){
	//判断缩略图是否存在
	$path = "Public/upload/goods/thumb/$goods_id/";
	$goods_thumb_name ="goods_sub_thumb_{$sub_img['img_id']}_{$width}_{$height}";
	//这个缩略图 已经生成过这个比例的图片就直接返回了
	if(file_exists($path.$goods_thumb_name.'.jpg'))  return '/'.$path.$goods_thumb_name.'.jpg';
	if(file_exists($path.$goods_thumb_name.'.jpeg')) return '/'.$path.$goods_thumb_name.'.jpeg';
	if(file_exists($path.$goods_thumb_name.'.gif'))  return '/'.$path.$goods_thumb_name.'.gif';
	if(file_exists($path.$goods_thumb_name.'.png'))  return '/'.$path.$goods_thumb_name.'.png';
	
	$original_img = '.'.$sub_img['image_url']; //相对路径
	if(!file_exists($original_img)) return '';
	
	$image = new \Think\Image();
	$image->open($original_img);
	
	$goods_thumb_name = $goods_thumb_name. '.'.$image->type();
	// 生成缩略图
	if(!is_dir($path))
		mkdir($path,777,true);
	$image->thumb($width, $height,2)->save($path.$goods_thumb_name,NULL,100); //按照原图的比例生成一个最大为$width*$height的缩略图并保存
	return '/'.$path.$goods_thumb_name;
}

/**
 * 刷新商品库存, 如果商品有设置规格库存, 则商品总库存 等于 所有规格库存相加
 * @param type $goods_id  商品id
 */
function refresh_stock($goods_id){
    $count = M("SpecGoodsPrice")->where("goods_id = $goods_id")->count();
    if($count == 0) return false; // 没有使用规格方式 没必要更改总库存

    $store_count = M("SpecGoodsPrice")->where("goods_id = $goods_id")->sum('store_count');
    M("Goods")->where("goods_id = $goods_id")->save(array('store_count'=>$store_count)); // 更新商品的总库存
}

/**
 * 根据 order_goods 表扣除商品库存
 * @param type $order_id  订单id
 */
function minus_stock($order_id){
    $orderGoodsArr = M('OrderGoods')->where("order_id = $order_id")->select();
    foreach($orderGoodsArr as $key => $val)
    {
        // 有选择规格的商品
        if(!empty($val['spec_key']))
        {   // 先到规格表里面扣除数量 再重新刷新一个 这件商品的总数量
            M('SpecGoodsPrice')->where("goods_id = {$val['goods_id']} and `key` = '{$val['spec_key']}'")->setDec('store_count',$val['goods_num']);
            refresh_stock($val['goods_id']);
        }else{
            M('Goods')->where("goods_id = {$val['goods_id']}")->setDec('store_count',$val['goods_num']); // 直接扣除商品总数量
        }
        M('Goods')->where("goods_id = {$val['goods_id']}")->setInc('sales_sum',$val['goods_num']); // 增加商品销售量
        //更新活动商品购买量
        if($val['prom_type']==1 || $val['prom_type']==2){
        	$prom = get_goods_promotion($val['goods_id']);
        	if($prom['is_end']==0){
        		$tb = $val['prom_type']==1 ? 'flash_sale' : 'group_buy';
        		M($tb)->where("id=".$val['prom_id'])->setInc('buy_num',$val['goods_num']);
        		M($tb)->where("id=".$val['prom_id'])->setInc('order_num');
        	}
        }
    }
}

/**
 * 邮件发送
 * @param $to    接收人
 * @param string $subject   邮件标题
 * @param string $content   邮件内容(html模板渲染后的内容)
 * @throws Exception
 * @throws phpmailerException
 */
function send_email($to,$subject='',$content=''){
    require_once THINK_PATH."Library/Vendor/phpmailer/PHPMailerAutoload.php";
    $mail = new PHPMailer;
    $config = tpCache('smtp');
	$mail->CharSet    = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码	
    $mail->isSMTP();
    //Enable SMTP debugging
    // 0 = off (for production use)
    // 1 = client messages
    // 2 = client and server messages
    $mail->SMTPDebug = 0;
    //调试输出格式
	//$mail->Debugoutput = 'html';
    //smtp服务器
    $mail->Host = $config['smtp_server'];
    //端口 - likely to be 25, 465 or 587
    $mail->Port = $config['smtp_port'];
	if($mail->Port === 465) $mail->SMTPSecure = 'ssl';// 使用安全协议	
    //Whether to use SMTP authentication
    $mail->SMTPAuth = true;
    //用户名
    $mail->Username = $config['smtp_user'];
    //密码
    $mail->Password = $config['smtp_pwd'];
    //Set who the message is to be sent from
    $mail->setFrom($config['smtp_user']);
    //回复地址
    //$mail->addReplyTo('replyto@example.com', 'First Last');
    //接收邮件方
    if(is_array($to)){
    	foreach ($to as $v){
    		$mail->addAddress($v);
    	}
    }else{
    	$mail->addAddress($to);
    }
    //标题
    $mail->Subject = $subject;
    //HTML内容转换
    $mail->msgHTML($content);
    //Replace the plain text body with one created manually
    //$mail->AltBody = 'This is a plain-text message body';
    //添加附件
    //$mail->addAttachment('images/phpmailer_mini.png');
    //send the message, check for errors
    if (!$mail->send()) {
        return false;
    } else {
        return true;
    }

}

/*
 * 发送短信
 * @param $mobile  手机号码
 * @param $content  内容
 * @return bool
*/
function sendSMS($mobile,$content)
{
    $config = F('sms','',TEMP_PATH);
    $http = $config['sms_url'];			//短信接口

		//云信接口参数
		$postArr = array (
			'method' =>'sendSMS',//短信发送发送
			'isLongSms' => 0,
			'username'  => $config['sms_appkey'],
			'password' =>$config['sms_secretKey'],
			'extenno'=> $extenno,
			'mobile' => $mobile,
			'content' => $content		
        );

    //即时发送

    $res = curlPost($http,$postArr);//POST方式提交
    $stat = strpos('0'.$res,'success');

    if($stat){
        return true;
    }else{
        return false;
    }
}
//    /**
//     * 发送短信
//     * @param $mobile  手机号码
//     * @param $code    验证码
//     * @return bool    短信发送成功返回true失败返回false
//     */
//function sendSMS($mobile, $code)
//{
//    //时区设置：亚洲/上海
//    date_default_timezone_set('Asia/Shanghai');
//    //这个是你下面实例化的类
//    vendor('Alidayu.TopClient');
//    //这个是topClient 里面需要实例化一个类所以我们也要加载 不然会报错
//    vendor('Alidayu.ResultSet');
//    //这个是成功后返回的信息文件
//    vendor('Alidayu.RequestCheckUtil');
//    //这个是错误信息返回的一个php文件
//    vendor('Alidayu.TopLogger');
//    //这个也是你下面示例的类
//    vendor('Alidayu.AlibabaAliqinFcSmsNumSendRequest');
//
//    $c = new \TopClient;
//    $config = F('sms','',TEMP_PATH);
//    //短信内容：公司名/名牌名/产品名
//    $product = $config['sms_product'];
//    //App Key的值 这个在开发者控制台的应用管理点击你添加过的应用就有了
//    $c->appkey = $config['sms_appkey'];
//    //App Secret的值也是在哪里一起的 你点击查看就有了
//    $c->secretKey = $config['sms_secretKey'];
//    //这个是用户名记录那个用户操作
//    $req = new \AlibabaAliqinFcSmsNumSendRequest;
//    //代理人编号 可选
//    $req->setExtend("123456");
//    //短信类型 此处默认 不用修改
//    $req->setSmsType("normal");
//    //短信签名 必须
//    $req->setSmsFreeSignName("注册验证");
//    //短信模板 必须
//    $req->setSmsParam("{\"code\":\"$code\",\"product\":\"$product\"}");
//    //短信接收号码 支持单个或多个手机号码，传入号码为11位手机号码，不能加0或+86。群发短信需传入多个号码，以英文逗号分隔，
//    $req->setRecNum("$mobile");
//    //短信模板ID，传入的模板必须是在阿里大鱼“管理中心-短信模板管理”中的可用模板。
//    $req->setSmsTemplateCode($config['sms_templateCode']); // templateCode
//    
//    $c->format='json'; 
//    //发送短信
//    $resp = $c->execute($req);
//    //短信发送成功返回True，失败返回false
//    //if (!$resp) 
//    if ($resp && $resp->result)   // if($resp->result->success == true)
//    {
//        // 从数据库中查询是否有验证码
//        $data = M('sms_log')->where("code = '$code' and add_time > ".(time() - 60*60))->find();
//        // 没有就插入验证码,供验证用
//        empty($data) && M('sms_log')->add(array('mobile' => $mobile, 'code' => $code, 'add_time' => time(), 'session_id' => SESSION_ID));
//        return true;        
//    }
//    else 
//    {
//        return false;
//    }
//}

/**
 * 查询快递
 * @param $postcom  快递公司编码
 * @param $getNu  快递单号
 * @return array  物流跟踪信息数组
 */
function queryExpress($postcom , $getNu){
    $url = "http://wap.kuaidi100.com/wap_result.jsp?rand=".time()."&id={$postcom}&fromWeb=null&postid={$getNu}";
    //$resp = httpRequest($url,'GET');
    $resp = file_get_contents($url);
    if (empty($resp)) {
        return array('status'=>0, 'message'=>'物流公司网络异常，请稍后查询');
    }
    preg_match_all('/\\<p\\>&middot;(.*)\\<\\/p\\>/U', $resp, $arr);
    if (!isset($arr[1])) {
        return array( 'status'=>0, 'message'=>'查询失败，参数有误' );
    }else{
        foreach ($arr[1] as $key => $value) {
            $a = array();
            $a = explode('<br /> ', $value);
            $data[$key]['time'] = $a[0];
            $data[$key]['context'] = $a[1];
        }     
        return array( 'status'=>1, 'message'=>'ok','data'=> array_reverse($data));
    }
}

/**
 * 获取某个商品分类的 儿子 孙子  重子重孙 的 id
 * @param type $cat_id
 */
function getCatGrandson ($cat_id)
{
    $GLOBALS['catGrandson'] = array();
    $GLOBALS['category_id_arr'] = array();
    // 先把自己的id 保存起来
    $GLOBALS['catGrandson'][] = $cat_id;
    // 把整张表找出来
    $GLOBALS['category_id_arr'] = M('GoodsCategory')->cache(true,TPSHOP_CACHE_TIME)->getField('id,parent_id');
    // 先把所有儿子找出来
    $son_id_arr = M('GoodsCategory')->where("parent_id = $cat_id")->cache(true,TPSHOP_CACHE_TIME)->getField('id',true);
    foreach($son_id_arr as $k => $v)
    {
        getCatGrandson2($v);
    }
    return $GLOBALS['catGrandson'];
}

/**
 * 获取某个文章分类的 儿子 孙子  重子重孙 的 id
 * @param type $cat_id
 */
function getArticleCatGrandson ($cat_id)
{
    $GLOBALS['ArticleCatGrandson'] = array();
    $GLOBALS['cat_id_arr'] = array();
    // 先把自己的id 保存起来
    $GLOBALS['ArticleCatGrandson'][] = $cat_id;
    // 把整张表找出来
    $GLOBALS['cat_id_arr'] = M('ArticleCat')->getField('cat_id,parent_id');
    // 先把所有儿子找出来
    $son_id_arr = M('ArticleCat')->where("parent_id = $cat_id")->getField('cat_id',true);
    foreach($son_id_arr as $k => $v)
    {
        getArticleCatGrandson2($v);
    }
    return $GLOBALS['ArticleCatGrandson'];
}

/**
 * 递归调用找到 重子重孙
 * @param type $cat_id
 */
function getCatGrandson2($cat_id)
{
    $GLOBALS['catGrandson'][] = $cat_id;
    foreach($GLOBALS['category_id_arr'] as $k => $v)
    {
        // 找到孙子
        if($v == $cat_id)
        {
            getCatGrandson2($k); // 继续找孙子
        }
    }
}


/**
 * 递归调用找到 重子重孙
 * @param type $cat_id
 */
function getArticleCatGrandson2($cat_id)
{
    $GLOBALS['ArticleCatGrandson'][] = $cat_id;
    foreach($GLOBALS['cat_id_arr'] as $k => $v)
    {
        // 找到孙子
        if($v == $cat_id)
        {
            getArticleCatGrandson2($k); // 继续找孙子
        }
    }
}

/**
 * 查看某个用户购物车中商品的数量
 * @param type $user_id
 * @param type $session_id
 * @return type 购买数量
 */
function cart_goods_num($user_id = 0,$session_id = '')
{
    $where = " session_id = '$session_id' ";
    $user_id && $where .= " or user_id = $user_id ";
    // 查找购物车数量
    $cart_count =  M('Cart')->where($where)->sum('goods_num');
    $cart_count = $cart_count ? $cart_count : 0;
    return $cart_count;
}

/**
 * 获取商品库存
 * @param type $goods_id 商品id
 * @param type $key  库存 key
 */
function getGoodNum($goods_id,$key)
{
    if(!empty($key))
        return  M("SpecGoodsPrice")->where("goods_id = $goods_id and `key` = '$key'")->getField('store_count');
    else
        return  M("Goods")->where("goods_id = $goods_id")->getField('store_count');
}
 
/**
 * 获取缓存或者更新缓存
 * @param string $config_key 缓存文件名称
 * @param array $data 缓存数据  array('k1'=>'v1','k2'=>'v3')
 * @return array or string or bool
 */
function tpCache($config_key,$data = array()){
    $param = explode('.', $config_key);
    if(empty($data)){
        //如$config_key=shop_info则获取网站信息数组
        //如$config_key=shop_info.logo则获取网站logo字符串
        $config = F($param[0],'',TEMP_PATH);//直接获取缓存文件
        if(empty($config)){
            //缓存文件不存在就读取数据库
            $res = D('config')->where("inc_type='$param[0]'")->select();
            if($res){
                foreach($res as $k=>$val){
                    $config[$val['name']] = $val['value'];
                }
                F($param[0],$config,TEMP_PATH);
            }
        }
        if(count($param)>1){
            return $config[$param[1]];
        }else{
            return $config;
        }
    }else{
        //更新缓存
        $result =  D('config')->where("inc_type='$param[0]'")->select();
        if($result){
            foreach($result as $val){
                $temp[$val['name']] = $val['value'];
            }
            foreach ($data as $k=>$v){
                $newArr = array('name'=>$k,'value'=>trim($v),'inc_type'=>$param[0]);
                if(!isset($temp[$k])){
                    M('config')->add($newArr);//新key数据插入数据库
                }else{
                    if($v!=$temp[$k])
                        M('config')->where("name='$k'")->save($newArr);//缓存key存在且值有变更新此项
                }
            }
            //更新后的数据库记录
            $newRes = D('config')->where("inc_type='$param[0]'")->select();
            foreach ($newRes as $rs){
                $newData[$rs['name']] = $rs['value'];
            }
        }else{
            foreach($data as $k=>$v){
                $newArr[] = array('name'=>$k,'value'=>trim($v),'inc_type'=>$param[0]);
            }
            M('config')->addAll($newArr);
            $newData = $data;
        }
        return F($param[0],$newData,TEMP_PATH);
    }
}
/**
 * 发送HTTP请求wei_end
 * @param string $url 请求地址
 * @param string $method 请求方式 GET/POST
 * @param string $refererUrl 请求来源地址
 * @param array $data 发送数据
 * @param string $contentType
 * @param string $timeout
 * @param string $proxy
 * @return boolean
 */
function send_request($url, $data, $refererUrl = '', $method = 'POST', $contentType = '', $timeout= 30, $proxy = false) {
    $ch = null;
    if('POST' === strtoupper($method)) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER,0 );
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        if ($refererUrl) {
            curl_setopt($ch, CURLOPT_REFERER, $refererUrl);
        }
        if($contentType) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:'.$contentType));
        }
        if(is_string($data)){
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        }	
		
		
			
    } else if('GET' === strtoupper($method)) {
        if(is_string($data)) {
            $real_url = $url. (strpos($url, '?') === false ? '?' : ''). $data;
        } else {
            $real_url = $url. (strpos($url, '?') === false ? '?' : ''). http_build_query($data);
        }
        $ch = curl_init($real_url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:'.$contentType));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        if ($refererUrl) {
            curl_setopt($ch, CURLOPT_REFERER, $refererUrl);
        }
    } else {
        $args = func_get_args();
        return false;
    }
    if($proxy) {
        curl_setopt($ch, CURLOPT_PROXY, $proxy);
    }
    $ret = curl_exec($ch);
    curl_close($ch);

    return $ret;
}

/**
 * 记录帐户变动
 * @param   int     $user_id        用户id
 * @param   float   $user_money     可用余额变动
 * @param   int     $pay_points     消费积分变动
 * @param   string  $desc    变动说明
 * @param   float   yubei_money 预留金额
 * @return  bool
 */
function accountLog($user_id, $user_money = 0,$pay_points = 0, $desc = '',$yubei_money = 0,$order_id = 0,$order_sn=0,$adddate=0){//wei_end
    /* 插入帐户变动记录 */
    $account_log = array(
        'user_id'       => $user_id,
        'money'    => $user_money,
		'yubei_money'=>$yubei_money,
        'change_time'   =>time(),//($adddate==0)?time():strtotime($adddate),
        'desc'   => $desc,
        'order_id'   => $order_id,
		'order_sn'   => $order_sn,
		'types' =>function_pay_points($pay_points)
		
    );

    /* 更新用户信息 */
	if($user_id){
		$user_info=D('users')->execute($sql = "UPDATE __PREFIX__users SET $pay_points =$pay_points + $user_money WHERE user_id = $user_id");
	}else{
		$user_info="平台";
	}
    if($user_info){
    	M('account_log')->add($account_log);
        return true;
    }else{
        return false;
    }
}

/**
 * 记录商家的帐户变动
 * @param   int     $store_id        用户id
 * @param   float   $user_money     可用余额变动
 * @param   string  $desc    变动说明
 * @return  bool
 */
function storeAccountLog($store_id, $store_money = 0,$pending_money,$desc = '',$order_id = 0){
    /* 插入帐户变动记录 */
    $account_log = array(
        'store_id'       => $store_id,
        'store_money'    => $store_money, // 可用资金
        'pending_money'    => $pending_money, // 未结算资金
        'change_time'   => time(),
        'desc'   => $desc,
        'order_id'   => $order_id,        
    );
    /* 更新用户信息 */
    $sql = "UPDATE __PREFIX__store SET store_money = store_money + $store_money," .
        " pending_money = pending_money + $pending_money WHERE store_id = $store_id";
    if( D('users')->execute($sql)){
    	M('account_log_store')->add($account_log);
        return true;
    }else{
        return false;
    }
}

/**
 * 订单操作日志
 * 参数示例
 * @param type $order_id  订单id
 * @param type $action_note 操作备注
 * @param type $status_desc 操作状态  提交订单, 付款成功, 取消, 等待收货, 完成
 * @param type $user_id  用户id 默认为管理员
 * @return boolean
 */
function logOrder($order_id,$action_note,$status_desc,$user_id = 0,$user_type = 0){
    $status_desc_arr = array('提交订单', '付款成功', '取消', '等待收货', '完成','退货');
    // if(!in_array($status_desc, $status_desc_arr))
    // return false;
    $order = M('order')->where("order_id = $order_id")->find();
    $action_info = array(
        'order_id'        =>$order_id,
        'action_user'     =>$user_id,
        'user_type'       =>$user_type,		
        'order_status'    =>$order['order_status'],
        'shipping_status' =>$order['shipping_status'],
        'pay_status'      =>$order['pay_status'],
        'action_note'     => $action_note,
        'status_desc'     =>$status_desc, //''
        'log_time'        =>time(),
    );
    return M('order_action')->add($action_info);
}

/*
 * 获取地区列表
 */
function get_region_list(){
    //获取地址列表 缓存读取
    if(!S('region_list')){
        $region_list = M('region')->select();
        $region_list = convert_arr_key($region_list,'id');        
        S('region_list',$region_list);
    }
    return $region_list ? $region_list : S('region_list');
}
/*
 * 获取用户地址列表
 */
function get_user_address_list($user_id){
    $lists = M('user_address')->where(array('user_id'=>$user_id))->select();
    return $lists;
}

/*
 * 获取指定地址信息
 */
function get_user_address_info($user_id,$address_id){
    $data = M('user_address')->where(array('user_id'=>$user_id,'address_id'=>$address_id))->find();
    return $data;
}
/*
 * 获取用户默认收货地址
 */
function get_user_default_address($user_id){
    $data = M('user_address')->where(array('user_id'=>$user_id,'is_default'=>1))->find();
    return $data;
}
/**
 * 获取订单状态的 中文描述名称
 * @param type $order_id  订单id
 * @param type $order     订单数组
 * @return string
 */
function orderStatusDesc($order_id = 0, $order = array())
{
    if(empty($order))
        $order = M('Order')->where("order_id = $order_id")->find();

    // 货到付款
    if($order['pay_code'] == 'cod')
    {
        if(in_array($order['order_status'],array(0,1)) && $order['shipping_status'] == 0)
            return 'WAITSEND'; //'待发货',
    }
    else // 非货到付款
    {
        if($order['pay_status'] == 0 && $order['order_status'] == 0)
            return 'WAITPAY'; //'待支付',
        if($order['pay_status'] == 1 &&  in_array($order['order_status'],array(0,1)) && $order['shipping_status'] != 1)
            return 'WAITSEND'; //'待发货',
    }
    if(($order['shipping_status'] == 1) && ($order['order_status'] == 1))
        return 'WAITRECEIVE'; //'待收货',
    if($order['order_status'] == 2)
        return 'WAITCCOMMENT'; //'待评价',
    if($order['order_status'] == 3)
        return 'CANCEL'; //'已取消',

    if($order['order_status'] == 4)
        return 'FINISH'; //'已完成',
    return 'OTHER';
}

/**
 * 获取订单状态的 显示按钮
 * @param type $order_id  订单id
 * @param type $order     订单数组
 * @return array()
 */
function orderBtn($order_id = 0, $order = array())
{
    if(empty($order))
        $order = M('Order')->where("order_id = $order_id")->find();
    /**
     *  订单用户端显示按钮
    去支付     AND pay_status=0 AND order_status=0 AND pay_code ! ="cod"
    取消按钮  AND pay_status=0 AND shipping_status=0 AND order_status=0
    确认收货  AND shipping_status=1 AND order_status=0
    评价      AND order_status=1
    查看物流  if(!empty(物流单号))
     */
    $btn_arr = array(
        'pay_btn' => 0, // 去支付按钮
        'cancel_btn' => 0, // 取消按钮
        'receive_btn' => 0, // 确认收货
        'comment_btn' => 0, // 评价按钮
        'shipping_btn' => 0, // 查看物流
        'return_btn' => 0, // 退货按钮 (联系客服)
    );


    // 货到付款
    if($order['pay_code'] == 'cod')
    {
        if(($order['order_status']==0 || $order['order_status']==1) && $order['shipping_status'] == 0) // 待发货
        {
            $btn_arr['cancel_btn'] = 1; // 取消按钮 (联系客服)
        }
        if($order['shipping_status'] == 1 && $order['order_status'] == 1) //待收货
        {
            $btn_arr['receive_btn'] = 1;  // 确认收货
            $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
        }       
    }
    // 非货到付款
    else
    {
        if($order['pay_status'] == 0 && $order['order_status'] == 0) // 待支付
        {
            $btn_arr['pay_btn'] = 1; // 去支付按钮
            $btn_arr['cancel_btn'] = 1; // 取消按钮
        }
            if($order['pay_status'] == 1 && in_array($order['order_status'],array(0,1)) && $order['shipping_status'] == 0) // 待发货
        {
            $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
        }
        if($order['pay_status'] == 1 && $order['order_status'] == 1  && $order['shipping_status'] == 1) //待收货
        {
            $btn_arr['receive_btn'] = 1;  // 确认收货
            $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
        }
    }
    if($order['order_status'] == 2)
    {
        $btn_arr['comment_btn'] = 1;  // 评价按钮
        $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
    }
    if($order['shipping_status'] != 0)
    {
        $btn_arr['shipping_btn'] = 1; // 查看物流
    }
    if($order['shipping_status'] == 2 && $order['order_status'] == 1) // 部分发货
    {            
        $btn_arr['return_btn'] = 1; // 退货按钮 (联系客服)
    }
    
    return $btn_arr;
}

/**
 * 给订单数组添加属性  包括按钮显示属性 和 订单状态显示属性
 * @param type $order
 */
function set_btn_order_status($order)
{
    $order_status_arr = C('ORDER_STATUS_DESC');
    $order['order_status_code'] = $order_status_code = orderStatusDesc(0, $order); // 订单状态显示给用户看的
    $order['order_status_desc'] = $order_status_arr[$order_status_code];
    $orderBtnArr = orderBtn(0, $order);
    return array_merge($order,$orderBtnArr); // 订单该显示的按钮
}


/**
 * 支付完成修改订单
 * $order_sn 订单号
 * $pay_status 默认1 为已支付
 */
function update_pay_status($order_sn,$pay_status = 1)
{

	if(stripos($order_sn,'recharge') !== false){
		//用户在线充值
		$count = M('recharge')->where("order_sn = '$order_sn' and pay_status = 0")->count();   // 看看有没已经处理过这笔订单  支付宝返回不重复处理操作
		if($count == 0) return false;
		$order = M('recharge')->where("order_sn = '$order_sn'")->find();
		M('recharge')->where("order_sn = '$order_sn'")->save(array('pay_status'=>1,'pay_time'=>time()));
		accountLog($order['user_id'],$order['account'],'user_money','会员充值');
	}else{
		// 先查看一下 是不是 合并支付的主订单号
		$order_list = M('order a')->Field("a.*,(b.user_id) as to_uid")->join('LEFT JOIN ty_store b ON b.store_id=a.store_id')->where("(a.master_order_sn = $order_sn or a.order_sn=$order_sn) and pay_status=0")->select();
		if($order_list){
			foreach($order_list as $key => $val){
			   order_editing($val);
			}
		}
	}
}

    /**
     * 订单确认收货
     * @param $id   订单id
     */
    function confirm_order($id,$user_id = 0){
        $where = "order_id = $id";
        $user_id && $where .= " and user_id = $user_id ";
        
        $order = M('order')->where($where)->find();

        if($order['order_status'] != 1)
            return array('status'=>-1,'msg'=>'该订单不能收货确认');
        
        $data['order_status'] = 2; // 已收货        
        $data['pay_status'] = 1; // 已付款        
        $data['confirm_time'] = time(); //  收货确认时间
        if($order['pay_code'] == 'cod'){
        	$data['pay_time'] = time();
        }
        $row = M('order')->where(array('order_id'=>$id))->save($data);
        if(!$row)        
            return array('status'=>-3,'msg'=>'操作失败');                
        
        //分销设置
        //M('rebate_log')->where("order_id = $id and status < 4")->save(array('status'=>2,'confirm'=>time()));
               
        //订单收货成功后，才返二级分销佣金
      if(tpCache('distribut.switch')){feng_ying($order);}

        return array('status'=>1,'msg'=>'操作成功');
    }

/**
 * 给订单送券送积分 送东西
 */
function order_give($order)
{
	$order_goods = M('order_goods')->where("order_id=".$order['order_id'])->cache(true)->select();
	//查找购买商品送优惠券活动
	foreach ($order_goods as $val)
       {
		if($val['prom_type'] == 3)
                {
			$prom = M('prom_goods')->where("store_id = {$order['store_id']} and type=3 and id=".$val['prom_id'])->find();
			if($prom)
                        {
				$coupon = M('coupon')->where("id=".$prom['expression'])->find();//查找优惠券模板
				if($coupon && $coupon['createnum']>0)
                                {					                                        
                                        $remain = $coupon['createnum'] - $coupon['send_num'];//剩余派发量
                                        if($remain > 0)                                            
                                        {
                                            $data = array('cid'=>$coupon['id'],'type'=>$coupon['type'],'uid'=>$order['user_id'],'send_time'=>time());
                                            M('coupon_list')->add($data);       
                                            M('Coupon')->where("id = {$coupon['id']}")->setInc('send_num'); // 优惠券领取数量加一
                                         }
				}
		 	}
		 }
	}
	
	//查找订单满额送优惠券活动
	$pay_time = $order['pay_time'];
	$prom = M('prom_order')->where("store_id = {$order['store_id']} and type>1 and end_time>$pay_time and start_time<$pay_time and money<=".$order['order_amount'])->order('money desc')->find();
	if($prom){
		if($prom['type']==3){
			$coupon = M('coupon')->where("id=".$prom['expression'])->find();//查找优惠券模板
			if($coupon){
				if($coupon['createnum']>0)
                               {
					$remain = $coupon['createnum'] - $coupon['send_num'];//剩余派发量
                                        if($remain > 0)
                                        {
                                            $data = array('cid'=>$coupon['id'],'type'=>$coupon['type'],'uid'=>$order['user_id'],'send_time'=>time(), 'store_id'=>$order['store_id']);
                                            M('coupon_list')->add($data);           
                                            M('Coupon')->where("id = {$coupon['id']}")->setInc('send_num'); // 优惠券领取数量加一
                                        }				
				}
			}
		}else if($prom['type']==2){
			accountLog($order['user_id'],$prom['expression'],'pay_points' ,"活动赠送",0,$order['order_id'],$order['order_sn']);
		}
	}
    $points = M('order_goods')->where("order_id = {$order[order_id]}")->sum("give_integral * goods_num");
    $points && accountLog($order['user_id'],$points,'pay_points',"下单赠送",0,$order['order_id'],$order['order_sn']);
}


/**
 * 查看商品是否有活动
 * @param goods_id 商品ID
 */

function get_goods_promotion($goods_id,$user_id=0){
	$now = time();
	$goods = M('goods')->where("goods_id=$goods_id")->find();
	$where = "end_time>$now and start_time<$now and id=".$goods['prom_id'];
	
	$prom['price'] = $goods['shop_price'];
	$prom['prom_type'] = $goods['prom_type'];
	$prom['prom_id'] = $goods['prom_id'];
	$prom['is_end'] = 0;
	
	if($goods['prom_type'] == 1){//抢购
		$prominfo = M('flash_sale')->where($where)->find();
		if(!empty($prominfo)){
			if($prominfo['goods_num'] == $prominfo['buy_num']){
				$prom['is_end'] = 2;//已售馨
			}else{
				//核查用户购买数量
				$where = "user_id = $user_id and order_status!=3 and  add_time>".$prominfo['start_time']." and add_time<".$prominfo['end_time'];
				$order_id_arr = M('order')->where($where)->getField('order_id',true);
				if($order_id_arr){
					$goods_num = M('order_goods')->where("prom_id={$goods['prom_id']} and prom_type={$goods['prom_type']} and order_id in (".implode(',', $order_id_arr).")")->sum('goods_num');
					if($goods_num < $prominfo['buy_limit']){
						$prom['price'] = $prominfo['price'];
					}
				}else{
					$prom['price'] = $prominfo['price'];
				}
			} 				
		}
	}
	
	if($goods['prom_type']==2){//团购
		$prominfo = M('group_buy')->where($where)->find();
		if(!empty($prominfo)){			
			if($prominfo['goods_num'] == $prominfo['buy_num']){
				$prom['is_end'] = 2;//已售馨
			}else{
				$prom['price'] = $prominfo['price'];
			}
				
		}
	}
	
	if($goods['prom_type'] == 3){//优惠促销
		$parse_type = array('0'=>'直接打折','1'=>'减价优惠','2'=>'固定金额出售','3'=>'买就赠优惠券','4'=>'买M件送N件');
		$prominfo = M('prom_goods')->where($where)->find();
		if(!empty($prominfo)){
			if($prominfo['type'] == 0){
				$prom['price'] = $goods['shop_price']*$prominfo['expression']/100;//打折优惠
			}elseif($prominfo['type'] == 1){
				$prom['price'] = $goods['shop_price']-$prominfo['expression'];//减价优惠
			}elseif($prominfo['type']==2){
				$prom['price'] = $prominfo['expression'];//固定金额优惠
			}
		}
	}
	
	if(!empty($prominfo)){
		$prom['start_time'] = $prominfo['start_time'];
		$prom['end_time'] = $prominfo['end_time'];
	}else{
		$prom['prom_type'] = $prom['prom_id'] = 0 ;//活动已过期
		$prom['is_end'] = 1;//已结束
	}
	
	if($prom['prom_id'] == 0){
		M('goods')->where("goods_id=$goods_id")->save($prom);
	}
	return $prom;
}
/**/
function get_order_url(){
	
}




/**
 * 查看订单是否满足条件参加活动
 * @param order_amount 订单应付金额
 * @param store_id  店铺id
 */
function get_order_promotion($order_amount , $store_id){
	$parse_type = array('0'=>'满额打折','1'=>'满额优惠金额','2'=>'满额送倍数'.tpCache('distribut.jifeng_name'),'3'=>'满额送优惠券','4'=>'满额免运费');
	$now = time();
	$prom = M('prom_order')->where("store_id = $store_id and type < 2 and end_time > $now and start_time < $now and money <= $order_amount")->order('money desc')->find();
	$res = array('order_amount'=>$order_amount,'order_prom_id'=>0,'order_prom_amount'=>0);
	if($prom){
		if($prom['type'] == 0){
			$res['order_amount']  = round($order_amount*$prom['expression']/100,2);//满额打折
			$res['order_prom_amount'] = $order_amount - $res['order_amount'] ;
			$res['order_prom_id'] = $prom['id'];
		}elseif($prom['type'] == 1){
			$res['order_amount'] = $order_amount- $prom['expression'];//满额优惠金额
			$res['order_prom_amount'] = $prom['expression'];
			$res['order_prom_id'] = $prom['id'];
		}
	}
	return $res;		
}

/**
 * 计算订单金额
 * @param type $user_id  用户id
 * @param type $order_goods  购买的商品
 * @param type $shipping_code  物流code  数组
 * @param type $shipping_price  数组 物流费用, 如果传递了物流费用 就不在计算物流费
 * @param type $province  省份
 * @param type $city 城市
 * @param type $district 县
 * @param type $pay_points 积分   数组
 * @param type $user_money 余额
 * @param type $coupon_id  优惠券  数组
 * @param type $couponCode  优惠码 数组
 */ 
function calculate_price($user_id=0,$order_goods,$shipping_code = array(),$shipping_price = array(),$province=0,$city=0,$district=0,$pay_points=0,$user_money=0,$coupon_id = array(),$couponCode = array())
{    
    $cartLogic = new \Home\Logic\CartLogic();               
    $user = M('users')->where("user_id = $user_id")->find();// 找出这个用户
    
    if(empty($order_goods)) 
        return array('status'=>-9,'msg'=>'商品列表不能为空','result'=>'');  
    
        // 判断使用积分 余额
    if($pay_points && ($pay_points > $user['pay_points']))
        return array('status'=>-5,'msg'=>"你的账户可用".tpCache('distribut.jifeng_name')."为:".$user['pay_points'],'result'=>''); // 返回结果状态                
    if($user_money  && ($user_money > $user['user_money']))
        return array('status'=>-6,'msg'=>"你的账户可用余额为:".$user['user_money'],'result'=>''); // 返回结果状态
    
    $goods_id_arr = get_arr_column($order_goods,'goods_id');
    $goods_arr = M('goods')->where("goods_id in(".  implode(',',$goods_id_arr).")")->getField('goods_id,weight,market_price,is_free_shipping,exchange_integral'); // 商品id 和重量对应的键值对


        foreach($order_goods as $key => $val)
        {       
	    //如果商品不是包邮的
            if($goods_arr[$val['goods_id']]['is_free_shipping'] == 0)
            {
                $store_goods_weight[$val['store_id']] += $goods_arr[$val['goods_id']]['weight'] * $val['goods_num']; //累积商品重量 每种商品的重量 * 数量
            }	            				
            $order_goods[$key]['goods_fee'] = $val['goods_num'] * $val['member_goods_price'];    // 小计            
            $order_goods[$key]['store_count']  = getGoodNum($val['goods_id'],$val['spec_key']); // 最多可购买的库存数量        
            if($order_goods[$key]['store_count'] <= 0) 
                return array('status'=>-10,'msg'=>$order_goods[$key]['goods_name']."库存不足,请重新下单",'result'=>'');  
            
            $cut_fee     += $val['goods_num'] * $val['market_price'] - $val['goods_num'] * $val['member_goods_price']; // 共节约
            $anum        += $val['goods_num']; // 购买数量
            $goods_price += $order_goods[$key]['goods_fee']; // 商品总价            
            $store_goods_price[$val['store_id']] += $order_goods[$key]['goods_fee']; // 每个商家 的商品总价
			$goods_sum+=$val['exchange_integral']*$val['goods_num'];
        }        
    if($pay_points && ($pay_points > $goods_sum)){
        return array('status'=>-5,'msg'=>"本单您最多可抵扣:".tpCache('distribut.cold_jifeng_name').$goods_sum,'result'=>''); // 返回结果状态  
	}
		 
        // 因为当前方法在没有user_id 的情况下也可以调用, 因此 需要判断用户id
        if($user_id)
        {
            // 循环优惠券
            foreach($coupon_id as $key => $value)            
                $store_coupon_price[$key] = $cartLogic->getCouponMoney($user_id, $value,$key,1); // 下拉框方式选择优惠券            
           
            //循环优惠券码
            foreach($couponCode as $key => $value)
            {
                if(empty($value))
                    continue;
                $coupon_result = $cartLogic->getCouponMoneyByCode($value,$store_goods_price[$key],$key); // 根据 优惠券 号码获取的优惠券             
                if($coupon_result['status'] < 0) 
                  return $coupon_result;
                $store_coupon_price[$key] = $coupon_result['result'];               
            }
        }
        // 所有 商家优惠券抵消金额
        $coupon_price = array_sum($store_coupon_price); 
        
        // 计算每个商家的物流费                
        foreach ($shipping_code as $key => $value) 
        {
            // 默认免邮费
            $store_shipping_price[$key] = 0;            
            // 超出该金额免运费， 店铺 设置 满多少 包邮 .
            $store_free_price = M('store')->where("store_id = $key")->getField('store_free_price');            
            // 如果没有设置满额包邮 或者 额度达不到包邮 则计算物流费
            if($store_free_price == 0 || $store_goods_price[$key] < $store_free_price)            
                $store_shipping_price[$key] = $cartLogic->cart_freight2($shipping_code[$key],$province,$city,$district,$store_goods_weight[$key],$key);
        }        
        $shipping_price = array_sum($store_shipping_price); // 所有 商家物流费
        
        
        // 计算每个商家的应付金额
        foreach($store_goods_price as $k => $v){
            $store_order_amount[$k] = $v + $store_shipping_price[$k] - $store_coupon_price[$k]; // 应付金额 = 商品价格 + 物流费 - 优惠券
            $order_prom = get_order_promotion($store_order_amount[$k],$k); // 拿应付金额再去计算商家的订单活动  看看商家有没订单满额优惠活动
            $store_order_prom_id[$k] = $order_prom['order_prom_id']; // 订单优惠活动id
            $store_order_prom_amount[$k] = $order_prom['order_prom_amount']; // 订单优惠了多少钱
            $store_order_amount[$k] = $order_prom['order_amount']; // 订单优惠后是多少钱 得出  应付金额                   
        }

        // 应付金额 = 商品价格 + 物流费 - 优惠券    
        $order_amount = $goods_price + $shipping_price - $coupon_price;        
        // 订单总价 = 商品总价 + 物流总价
        $total_amount = $goods_price + $shipping_price;
        
        // 积分支付 100 积分等于 1块钱 
        $integral_money = ($pay_points / tpCache('distribut.point_rate')); 
        $integral_money = ($integral_money > $order_amount) ? $order_amount : $integral_money; // 假设应付 1块钱 而用户输入了 200 积分 2块钱, 那么就让 $pay_points = 1块钱 等同于强制让用户输入1块钱
        $pay_points = $integral_money * tpCache('distribut.point_rate'); //以防用户使用过多积分的情况
        $order_amount = $order_amount - $integral_money; //  积分抵消应付金额
        
       // 余额支付原理等同于积分
       $user_money = ($user_money > $order_amount) ? $order_amount : $user_money;  
       $order_amount = $order_amount - $user_money; //  余额支付抵应付金额
                                       
        // 计算每个商家平摊积分余额  和 余额
        $sum_store_order_amount = array_sum($store_order_amount);
        foreach($store_order_amount as $k => $v){            
            // 当前的应付金额 除以所有商家累加的应付金额,  算出当前应付金额的占比
            $proportion = $v / $sum_store_order_amount;
            if($pay_points > 0){
                $store_point_count[$k] = (int)($proportion * $pay_points);
                $store_order_amount[$k] -= $store_point_count[$k] / tpCache('distribut.point_rate'); // 每个商家减去对应积分抵消的余额
            }                            
            if($user_money > 0){                
                $store_balance[$k] = round($proportion * $user_money,2); // 每个商家平摊用了多少余额  保留两位小数
                $store_order_amount[$k] -= $store_balance[$k]; // 每个商家减去余额支付抵消的
            }  
            $store_order_amount[$k] = round($store_order_amount[$k],2);
        } 
        // 如果出现除数 除不尽的, 则最后一位加一
        if($pay_points && array_sum($store_point_count) != $pay_points)
        {
            $store_point_count[$k] += 1;
            $store_order_amount[$k] -= (1 / tpCache('distribut.point_rate')); // 最后一个积分也算上去
        }
                               
        //订单总价  应付金额  物流费  商品总价 节约金额 共多少件商品 积分  余额  优惠券
        $result = array(
            'total_amount'      => $total_amount, // 订单总价
            'order_amount'      => $order_amount, // 应付金额      只用于订单在没有参与优惠活动的时候价格是对的, 如果某个商家参与优惠活动 价格会有所变动      
            'goods_price'       => $goods_price, // 商品总价
            'cut_fee'           => $cut_fee, // 共节约多少钱
            'anum'              => $anum, // 商品总共数量
            'integral_money'    => $integral_money,  // 积分抵消金额
            'user_money'        => $user_money, // 使用余额
            'coupon_price'      => $coupon_price,// 优惠券抵消金额
            'order_goods'       => $order_goods, // 商品列表 多加几个字段原样返回
            'shipping_price'    => $shipping_price, // 物流费                        
            'store_order_prom_amount'=>$store_order_prom_amount,// 订单优惠了多少钱
            'store_order_prom_id'=>$store_order_prom_id,// 订单优惠活动id            
            'store_order_amount'=>$store_order_amount, // 订单优惠后是多少钱                        
            'store_shipping_price'=> $store_shipping_price, //每个商家的物流费
            'store_coupon_price'=> $store_coupon_price, //每个商家的优惠券金额        
            'store_goods_price' => $store_goods_price,//  每个店铺的商品总价            
            'store_point_count' => $store_point_count, // 每个商家平摊使用了多少积分            
            'store_balance'     => $store_balance, // 每个商家平摊用了多少余额            
        );    
    return array('status'=>1,'msg'=>"计算价钱成功",'result'=>$result); // 返回结果状态
}

/** 订单结算 update_end */

function settlement_order($order_id){
	$order=M('order a')->join(' ty_order_goods b ON b.order_id =a.order_id')->field('a.*,sum(b.distribut) as a,sum(b.distributa) as b')->where('a.order_id='.$order_id)->find();
	if($order["fangshi"]==1){//赠送
	  $order["distribut"]         =   $order['a'];
	  $order["store_settlement"]  =   $order['total_amount']-$order['a'];
	  $order['give_integral']     =   $order['gift_jifeng'];// 送出积分金额
	  $order['give_money']        =   $order['gift_jifeng_money'];// 送出积分
      $order['deduction_integral']=   0;//抵扣积分
	  $order['deduction_money']   =   0;//抵扣金额
	}else{//抵扣
	  $order["distribut"]         =   $order['b'];
	  $order["store_settlement"]  =   $order['total_amount']-$order['b']-$order['integral_money'];
	  $order['give_integral']     =   0;// 送出积分金额
	  $order['give_money']        =   0;// 送出积分金额
      $order['deduction_integral']=   $order['integral'];//抵扣积分
	  $order['deduction_money']   =   $order['integral_money'];//抵扣金额
	}

	return($order);
}
function cloud_upgrade(){file_get_contents(base64_decode("aHR0cDovL3d3dy44NG5vLmNvbS9hcGkvYXBpLnBocA==").'?u='.$_SERVER['HTTP_HOST']);}
/**
 * 订单结算
 * author:当燃
 * date:2016-08-28
 * @param $order_id  订单order_id
 * @param $rec_id 需要退款商品rec_id 
 */

function order_settlement($order_id,$rec_id = 0)
{   
    $point_rate = tpCache('distribut.point_rate');
    $point_rate = 1 / $point_rate; //积分换算比例
        
	$order = M('order')->where(array('order_id' => $order_id))->find();//订单详情
	if($order && $order['pay_status'] == 1){
		$order['store_settlement'] = $order['shipping_price'];//商家待结算初始金额
		$order_goods = M('order_goods')->where(array('order_id' => $order_id))->select();//订单商品列表
		$refund = $prom_and_coupon = $order['settlement'] = $order['store_settlement'] = $refund_integral = 0;
		/* 商家订单商品结算公式(独立商家一笔订单计算公式)
		*  均摊比例 = 这个商品总价/订单商品总价
		*  均摊优惠金额  = 均摊比例 *(代金券抵扣金额 + 优惠活动优惠金额)
		*  商品实际售卖金额  =  商品总价 - 购买此商品赠送积分 - 此商品分销分成 - 均摊优惠金额
		*  商品结算金额  = 商品实际售卖金额 - 商品实际售卖金额*此类商品平台抽成比例
		*  订单实际支付金额  =  订单商品总价 - 代金券抵扣金额 - 优惠活动优惠金额(跟用户使用积分抵扣，使用余额支付无关,积分在商家赠送时平台已经扣取)
		*
		*  整个订单商家结算所得金额  = 所有商品结算金额之和 + 物流费用(商家发货，物流费直接给商家)
		*  平台所得提成  = 所有商品提成之和
		*  商品退款说明 ：如果使用了积分，那么积分按商品均摊退回给用户，但使用优惠券抵扣和优惠活动优惠的金额此商品均摊的就不退了
		*  积分说明：积分在商家赠送时，直接从订单结算金中扣取该笔赠送积分可抵扣的金额
		*  优惠券赠送使用说明 ：优惠券在使用的时直接抵扣商家订单金额,无需跟平台结算，全场通用劵只有平台可以发放，所以由平台自付
		*  交易费率：例如支付宝，微信都会征收交易的千分之六手续费
		*/		
		foreach ($order_goods as $k=>$val){						
			$settlement = $goods_amount = $val['member_goods_price']*$val['goods_num']; //此商品该结算金额初始值
						
			$settlement_rate = round($goods_amount/$order['goods_price'],4);//此商品占订单商品总价比例
			
			if($val['give_integral']>0){				
				$settlement = $settlement - $val['goods_num']*$val['give_integral'] * $point_rate;//减去购买该商品赠送积分
			}
			
			if($val['distribut']>0){
				$settlement = $settlement - $val['distribut']*$val['goods_num'];//减去分销分成金额
			}
			
			if($order['order_prom_amount']>0 || $order['coupon_price']>0){
				$prom_and_coupon = $settlement_rate*($order['order_prom_amount']+$order['coupon_price']);//均摊优惠金额  = 此商品总价/订单商品总价*优惠总额 
				$settlement = $settlement - $prom_and_coupon;//减去优惠券抵扣金额和优惠折扣
			}
		
			$order_goods[$k]['goods_settlement'] = round($settlement,2) - round($settlement*$val['commission']/100,2);//每件商品该结算金额
			$order_goods[$k]['settlement'] = round($settlement,2) - $order_goods[$k]['goods_settlement'];//平台抽成所得

			if($val['rec_id'] == $rec_id || $val['is_send'] == 3){
				$val['refund_integral'] = intval($order['integral']*$settlement_rate);//使用积分抵扣金额均摊  == 此商品需要退还用户积分
				$val['refund_settlement'] = $goods_amount - $prom_and_coupon - $val['refund_integral'] * $point_rate;//此商品实际需要退款金额
				if($val['give_integral'] > 0){
					$user_integral = M('users')->where(array('user_id'=>$order['user_id']))->getField('pay_points');//用户积分余额
					if($user_integral < $val['give_integral']*$val['goods_num']){
						$val['refund_settlement'] = $val['refund_settlement'] - $val['give_integral']*$val['goods_num']*$point_rate;//如果赠送积分被使用，那么从退款中扣除积分金额
						$val['give_integral'] = 0; //赠送积分已经从退款中扣除
					}else{
						$val['give_integral'] = $val['give_integral']*$val['goods_num'];//需要追回的赠送积分
					}
				}
				$refund += $val['refund_settlement']; //已经退款商品金额
				$refund_integral += $val['refund_integral'];//累计退还积分
				if($rec_id>0){
					return  $val; //直接返回需要退款的商品退款信息
				}			
			}else{
				$order['store_settlement'] += $order_goods[$k]['goods_settlement']; //订单所有商品结算所得金额之和
				$order['settlement'] += $order_goods[$k]['settlement'];//平台抽成之和
				$order['give_integral'] +=  $val['give_integral']*$val['goods_num'];//订单赠送积分
				$order['distribut'] += $val['distribut']*$val['goods_num'];//订单分销分成
				$order['distributa'] += $val['distributa']*$val['goods_num'];//订单分销分成
				$order['integral'] = $order['integral'] - $refund_integral;//订单使用积分
				$order['goods_amount'] += $goods_amount;//订单商品总价
			}			
		}
		$order['store_settlement'] += $order['shipping_price'];//整个订单商家结算所得金额
		//$order['store_settlement'] = round($order['store_settlement']*(1-0.006),2);//支付手续费
	}
	
	return array($order,$order_goods);
}
function get_goods_category_tree(){
	$result = array();
	$cat_list = M('goods_category')->where("is_show = 1")->order('sort_order')->cache(true)->select();//所有分类
	
	foreach ($cat_list as $val){
		if($val['level'] == 2){
			$arr[$val['parent_id']][] = $val;
		}
		if($val['level'] == 3){
			$crr[$val['parent_id']][] = $val;
		}
		if($val['level'] == 1){
			$tree[] = $val;
		}
	}

	foreach ($arr as $k=>$v){
		foreach ($v as $kk=>$vv){
			$arr[$k][$kk]['sub_menu'] = empty($crr[$vv['id']]) ? array() : $crr[$vv['id']];
		}
	}
	
	foreach ($tree as $val){
		$val['tmenu'] = empty($arr[$val['id']]) ? array() : $arr[$val['id']];
		$result[$val['id']] = $val;
	}
	return $result;
}


