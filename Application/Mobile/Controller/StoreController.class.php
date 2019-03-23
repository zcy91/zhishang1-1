<?php
/**
 * tpshop
 * ============================================================================
 * 版权所有 2015-2027 深圳搜豹网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.tp-shop.cn
 * ----------------------------------------------------------------------------
 * Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
 * ============================================================================
 * Author: 当燃
 * Date: 2016-05-28
 */
namespace Mobile\Controller;
use Home\Logic\StoreLogic;
use Think\Controller;
use Think\Page;

class StoreController extends Controller {
	public $store = array();
	
	public function _initialize() {
		$store_id = I('store_id');

		if(empty($store_id)){
			$this->error('参数错误,店铺系列号不能为空',U('Index/index'));
		}
		$store = M('store')->where(array('store_id'=>$store_id))->find();

		if(I('get.t_id')){
			setcookie('t_id', I('get.t_id'), time()+3600*24*7, '/');
		}

		if($store){
			if($store['store_state'] == 0){
				$this->error('该店铺不存在或者已关闭', U('Index/index'));
			}
			$store['mb_slide'] = explode(',', $store['mb_slide']);
			$store['mb_slide_url'] = explode(',', $store['mb_slide_url']);
			$this->store = $store;
			$this->assign('store',$store);
		}else{
			$this->error('该店铺不存在或者已关闭',U('Index/index'));
		}
        if (session('?user') || $_COOKIE['user_id']) {
            $user = session('user')?session('user'):array('user_id'=>$_COOKIE['user_id']);
            $user = M('users')->where("user_id = {$user['user_id']}")->find();
			$this->user_id = $user['user_id'];
			$this->assign('user', $user); //存储用户信息
		}
	}
	
	public function index(){
		//热门商品排行
		$hot_goods = M('goods')->field('goods_content',true)->where(array('store_id'=>$this->store['store_id']))->order('sales_sum desc')->limit(9)->select();
		//新品
		$new_goods = M('goods')->field('goods_content',true)->where(array('store_id'=>$this->store['store_id'],'is_new'=>1))->order('goods_id desc')->limit(9)->select();
		//推荐商品
		$recomend_goods = M('goods')->field('goods_content',true)->where(array('store_id'=>$this->store['store_id'],'is_recommend'=>1))->order('goods_id desc')->limit(9)->select();
		//所有商品
		$total_goods = M('goods')->where(array('store_id'=>$this->store['store_id'],'is_on_sale'=>1))->count();
		$scdp = M('store_collect')->where(array('store_id'=>$this->store['store_id'],'user_id'=>cookie('user_id')))->count();//是否收藏
		$this->assign('scdp',$scdp?$scdp:0);
		$this->assign('hot_goods',$hot_goods);
		$this->assign('new_goods',$new_goods);
		$this->assign('recomend_goods',$recomend_goods);
		$this->assign('total_goods',$total_goods);
		$total_goods = M('goods')->where(array('store_id'=>$this->store['store_id'],'is_on_sale'=>1))->count();
		$this->assign('total_goods',$total_goods);
		$this->display();
	}
	
	public function goods_list(){
		$cat_id = I('cat_id', 0);
		$key = I('key', 'is_new');
		$p = I('p', '1');
		$sort = I('sort', 'desc');
		$keywords = I('keywords');
		$map = array('store_id' => $this->store['store_id'], 'is_on_sale' => 1);
		$cat_name = "全部商品";
		if ($cat_id > 0) {
			$map['_string'] = "store_cat_id1=$cat_id OR store_cat_id2=$cat_id";
			$cat_name = M('store_goods_class')->where(array('cat_id' => $cat_id))->getField('cat_name');
		}
		if($keywords){
			$map['goods_name'] = array('like',"%$keywords%");
		}
		$filter_goods_id = M('goods')->where($map)->cache(true)->getField("goods_id", true);
		$count = count($filter_goods_id);
		$page_count = 20;//每页多少个商品
		if ($count > 0) {
			$goods_list = M('goods')->where("goods_id in (" . implode(',', $filter_goods_id) . ")")->order("$key $sort")->page($p,$page_count)->select();
		}

		$sort = ($sort == 'desc') ? 'asc' : 'desc';
		$this->assign('sort', $sort);
		$this->assign('keys', $key);
		$link_arr = array(
				array('key' => 'is_new', 'name' => '最新', 'url' => U('Store/goods_list', array('store_id' => $this->store['store_id'], 'key' => 'is_new', 'sort' => $sort))),
				array('key' => 'sales_sum', 'name' => '销量', 'url' => U('Store/goods_list', array('store_id' => $this->store['store_id'], 'key' => 'sales_sum', 'sort' => $sort))),
				//array('key' => 'collect_sum', 'name' => '收藏', 'url' => U('Store/goods_list', array('store_id' => $this->store['store_id'], 'key' => 'collect_sum', 'sort' => $sort))),
				array('key' => 'is_recommend', 'name' => '人气', 'url' => U('Store/goods_list', array('store_id' => $this->store['store_id'], 'key' => 'is_recommend', 'sort' => $sort))),
				array('key' => 'shop_price', 'name' => '价格', 'url' => U('Store/goods_list', array('store_id' => $this->store['store_id'], 'key' => 'shop_price', 'sort' => $sort)))
		);

		$this->assign('cat_id', $cat_id);
		$this->assign('key', $key);
		$this->assign('sort', $sort);
		$this->assign('keywords', $keywords);

		$this->assign('link_arr', $link_arr);
		$this->assign('goods_list', $goods_list);
		$this->assign('cat_name', $cat_name);
		$this->assign('goods_list_total_count',$count);
		$this->assign('page_count',$page_count);
		if(IS_AJAX){
			$this->display('ajaxGoodsList');
		}else{
			$this->display();
		}
	}

	public function about(){
		$total_goods = M('goods')->where(array('store_id'=>$this->store['store_id'],'is_on_sale'=>1))->count();
		$scdp = M('store_collect')->where(array('store_id'=>$this->store['store_id'],'user_id'=>$this->user_id))->count();//是否收藏
		$this->assign('scdp',$scdp?$scdp:0);
		$this->assign('total_goods',$total_goods);
		$this->display();
	}
	public function fastbuy(){

		if(I('post.')){
		  header('Content-Type:application/json');
		  $money=I('post.money');
		  $fangshi=I('post.fangshi');
		  $store=$this->store;
		  
		  if($money<=0){exit(json_encode(array('status'=>0,'info'=>'请设置支付金额')));}
		  if($fangshi!=1 && $fangshi!=2){
			exit(json_encode(array('status'=>0,'info'=>'请选择充值方式')));  
		  }else{
			$jinfong_s=$store['gift_jifeng']*0.01;//赠送
			$jinfong_k=$store['arrive_jifeng']*0.01;//抵扣
			  if($fangshi==1){
				$money=$money;
				$jifeng=number_format($money*$jinfong_s,2,'.','.');//赠送 
			  }else{
				$jifeng=number_format($money*$jinfong_k,2,'.','.');//赠送  
				$money=$money-$jifeng;
			  }
			   $jifeng=$jifeng*tpCache('distribut.point_rate');//价格转积分
		  }
		  //exit(json_encode(array('status'=>0,'info'=>$money.'--->'.$jifeng)));
          //查询会员帐号余额是否充足
		  if($store['arrive_jifeng']==0 && $fangshi==2){exit(json_encode(array('status'=>0,'info'=>'该商户不允许使用'.tpCache('distribut.jifeng_name').'抵扣')));}
		  $m_info = M('users')->where("user_id=$this->user_id")->Field('user_money,pay_points')->find();
		  if($m_info['user_money']<$money){exit(json_encode(array('status'=>0,'info'=>'您的帐户可用余额不足')));}
		  if($m_info['pay_points']<$jifeng && $fangshi==2){exit(json_encode(array('status'=>0,'info'=>'您的帐户可用抵扣'.tpCache('distribut.jifeng_name').'不足')));}
		  //查询商家帐户积分是否充足
		  if($fangshi==1){
			$sj_info = M('users')->where("user_id=".$store["user_id"])->Field('user_money,pay_points')->find();  
			if($sj_info['pay_points']<$jifeng){exit(json_encode(array('status'=>0,'info'=>'商家可赠送'.tpCache('distribut.jifeng_name').'不足')));}
		  }
		  $out_trade_no="KJ".Date('YmdHis').rand(1000,9999);//生成交易号
		  accountLog($store["user_id"],$money,'user_money','快捷支付',I('post.money'),$this->user_id,$out_trade_no); // 增加余额
		  accountLog($this->user_id,$money*-1,'user_money','快捷支付',I('post.money'),$store["user_id"],$out_trade_no); // 扣除余额
          if($fangshi==1 && $jifeng){
		   //赠送	  
		   accountLog($this->user_id,$jifeng,'pay_points','快捷支付',I('post.money'),$store["user_id"],$out_trade_no.'快捷赠送'); // 增加积分
		   accountLog($store["user_id"],$jifeng*-1,'pay_points','快捷支付',I('post.money'),$this->user_id,$out_trade_no.'扣除快捷赠送'); // 增加积分  
		  }elseif($fangshi==2  && $jifeng){
		   //抵扣
		   accountLog($store["user_id"],$jifeng,'pay_points','快捷支付',I('post.money'),$this->user_id,$out_trade_no.'增加快捷抵扣'); // 增加余额
		   accountLog($this->user_id,$jifeng*-1,'pay_points','快捷支付',I('post.money'),$store["user_id"],$out_trade_no.'快捷抵扣'); // 扣除余额 
		  }
		 
		  exit(json_encode(array('status'=>1,'info'=>'支付成功','url'=>U("fast_info",array('t_no'=>$out_trade_no,'store_id'=>$this->store['store_id'],'u_id'=>$this->user_id)))));
		}

		$total_goods = M('goods')->where(array('store_id'=>$this->store['store_id'],'is_on_sale'=>1))->count();
		$scdp = M('store_collect')->where(array('store_id'=>$this->store['store_id'],'user_id'=>cookie('user_id')))->count();//是否收藏
		$this->assign('scdp',$scdp?$scdp:0);
		$this->assign('total_goods',$total_goods);
		$this->display();
	}
	public function fast_info(){
		$total_goods = M('goods')->where(array('store_id'=>$this->store['store_id'],'is_on_sale'=>1))->count();
		$scdp = M('store_collect')->where(array('store_id'=>$this->store['store_id'],'user_id'=>$this->user_id))->count();//是否收藏
		$log_list = M('account_log')->where(array('user_id'=>I('get.u_id'),'order_sn'=>I('get.t_no'),'types'=>1))->find();
		$zs_jifeng=M('account_log')->where(array('user_id'=>I('get.u_id'),'order_sn'=>I('get.t_no'),'types'=>2))->getfield("money");

		$this->assign('zs_jifeng',$zs_jifeng>0?$zs_jifeng:0);
		$this->assign('dk_jifeng',$zs_jifeng<0?$zs_jifeng*-1:0);
		
		$this->assign('log_list',$log_list);
		$this->assign('scdp',$scdp?$scdp:0);
		$this->assign('total_goods',$total_goods);
		$this->display();
	}
	public function store_goods_class(){
		$store_goods_class_list = M('store_goods_class')->where(array('store_id'=>$this->store['store_id']))->select();
		if($store_goods_class_list){
			$sub_cat = $main_cat = array();
			foreach ($store_goods_class_list as $val){
			    if ($val['parent_id'] == 0) {
                    $main_cat[] = $val;
                } else {
                    $sub_cat[$val['parent_id']][] = $val;
                }
			}
			$this->assign('main_cat',$main_cat);
			$this->assign('sub_cat',$sub_cat);
		}
		$this->display();
	}

}