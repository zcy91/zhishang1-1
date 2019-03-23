<?php

namespace Mobile\Controller;
use Mobile\Model\StoreModel;
use Admin\Logic\StoreLogic;
class IndexController extends MobileBaseController {
    public function index(){  
        /*
            //获取微信配置
            $wechat_list = M('wx_user')->select();
            $wechat_config = $wechat_list[0];
            $this->weixin_config = $wechat_config;        
            // 微信Jssdk 操作类 用分享朋友圈 JS            
            $jssdk = new \Mobile\Logic\Jssdk($this->weixin_config['appid'], $this->weixin_config['appsecret']);
            $signPackage = $jssdk->GetSignPackage();              
            print_r($signPackage);
        */
        $hot_goods = M('goods')->where("is_hot=1 and is_on_sale=1")->order('goods_id DESC')->limit(20)->cache(true,TPSHOP_CACHE_TIME)->select();//首页热卖商品
        $thems = M('goods_category')->where('level=1')->order('sort_order')->limit(9)->cache(true,TPSHOP_CACHE_TIME)->select();
        $this->assign('thems',$thems);
        $this->assign('hot_goods',$hot_goods);
        $favourite_goods = M('goods')->where("is_recommend=1 and is_on_sale=1")->order('goods_id DESC')->limit(20)->cache(true,TPSHOP_CACHE_TIME)->select();//首页推荐商品
        $this->assign('favourite_goods',$favourite_goods);
		//获取当前奖金池总金额
		if(tpCache('distribut.point_gongsibili')<>0){
		    $jifeng_sum= M('account_log')->where("types=2 and user_id=0")->sum('money');//平台金分池
		}else{
		    $jifeng_sum=0;
		}
		$jifeng_sum_user= M('users')->sum('pay_points');//用户现有
		$this->assign('jifeng_sum',$jifeng_sum+$jifeng_sum_user);
		$jinchi= M('bonus_rule')->where("is_show=1 and is_new=0")->order('sort asc')->field("name,bili,jifeng")->find();//平台金分池
		$this->assign('jinchi',$jinchi);
		$a_list= M('account_log as a')->join('left join ty_users b ON a.user_id = b.user_id')->where("a.types=2 and a.user_id not in(0)")->field('a.*,b.nickname')->order('a.log_id desc')->limit(10)->select();
		$this->assign('a_list',$a_list);

        $this->display();
    }
    /**
     * 分类列表显示
     */
    public function categoryList(){
        $this->display();
    }
    /**
     * 模板列表
     */
    public function mobanlist(){
        $arr = glob("");
        foreach($arr as $key => $val)
        {
            $html = end(explode('/', $val));
            echo "<a href=''>{$html}</a> <br/>";            
        }        
    }
    
    /**
     * 商品列表页
     */
    public function goodsList(){
        $goodsLogic = new \Home\Logic\GoodsLogic(); // 前台商品操作逻辑类
        $id = I('get.id',0); // 当前分类id
        $lists = getCatGrandson($id);
        $this->assign('lists',$lists);
        $this->display();
    }    
    public function ajaxGetMore(){
    	$p = I('p',1);
    	$favourite_goods = M('goods')->where("is_recommend=1 and is_on_sale=1  and goods_state = 1 ")->order('sort DESC')->page($p,10)->cache(true,TPSHOP_CACHE_TIME)->select();//首页推荐商品
    	$this->assign('favourite_goods',$favourite_goods);
    	$this->display();
    }
    /**
     * 店铺街
     * @author dyr
     * @time 2016/08/15
     */
    public function street(){
        $store_class = M('store_class')->where('')->order('sc_sort desc')->select();
        $this->assign('store_class', $store_class);//店铺分类
		$this->assign('store_key', I("get.key"));//店铺分类
        $this->display();
    }
    /**
     * ajax 获取店铺街
     */
    public function ajaxStreetList(){
        $p = I('p',1);
		$sc_id = I('get.sc_id','');
        $store_list = D('store')->getStreetList($sc_id,$p,10,I('get.key'));		

        foreach($store_list as $key=>$value){
            $store_list[$key]['goods_array'] = D('store')->getStoreGoods($value['store_id'],4);
        }
        $empty=I('get.key')?"按关键字：<span style='color:#f00'>".I('get.key')."</span>,未找到相关店铺":"未找到相关店铺";
		
		//print_r($store_list);
		
        $this->assign('store_list',$store_list);
		$this->assign('empty',"<h1 style='height:35vw; line-height:35vw; text-align:center; font-weight:100; font-size:16px'>".$empty."</h1>");
        $this->display();
    }
    /**
     * 品牌街
     * @author dyr
     * @time 2016/08/15
     */
    public function brand(){
        $brand_model = M('brand');
        $brand_where['status'] = 0;
        $brand_class = $brand_model->field('cat_name')->group('cat_name')->order(array('sort'=>'desc','id'=>'asc'))->where($brand_where)->select();
        $brand_list = $brand_model->field('id,name,logo,url')->order(array('sort'=>'desc','id'=>'asc'))->where($brand_where)->select();
        $brand_count = count($brand_list);
        for ($i = 0; $i < $brand_count; $i++) {
            if (($i + 1) % 4 == 0) {
                $brand_list[$i]['brandLink'] = 'brandRightLink';
            } else {
                $brand_list[$i]['brandLink'] = 'brandLink';
            }
        }
        $this->assign('brand_list', $brand_list);//品牌列表
        $this->assign('brand_class', $brand_class);//品牌分类
        $this->display();
    }

    public function dingwei(){	
	    $lng_lat=I('lng_lat',session('lng_lat'));
		if(!$lng_lat){
        $this->display();
		}else{
		session('lng_lat',$lng_lat);
		header("location:".U('index/nearby_store'));
		//$this->nearby_store();
		}
    }
    /**
     * 店铺街
     * @author dyr
     * @time 2016/08/15
     */
    public function nearby_store(){	
        $this->display();
    }
	
    /** ajax 获取店铺街*/
    public function ajaxstoreList(){
        $p = I('p',1);
		$lng_lat=I('lng_lat');
		if($lng_lat){
		 session('lng_lat',$lng_lat);
		}
        $store_list = D('store')->getStoreList($sc_id,$p,10);		
        foreach($store_list as $key=>$value){
            $store_list[$key]['goods_array'] = D('store')->getStoreGoods($value['store_id'],4);
        }
        $this->assign('store_list',$store_list);
		$this->assign('empty',"<h1 style='height:35vw; line-height:35vw; text-align:center; font-weight:100; font-size:16px; color:#f00'>未找到更多店铺</h1>");
        $this->display();
    }
	
    /**
     * 友情链接
     * @author dyr
     * @time 2016/08/15
     */
    public function menuList(){   
	    $lei=I('get.lei');
		if(!$lei){
		   $this->error('操作不当...');	
		}
		$info_list = M('wapnavigation')->where('lei='.$lei.' and  is_show = 1')->order("sort asc")->select();
        $this->assign('list',$info_list);
		$this->assign('lei',$lei);
        $this->display();
    } 
	
    /*定时任务*/
    public function aotu_timing(){   
		// 商家结算 
        $storeLogic = new StoreLogic();
		$info_list = M('store')->field('store_id')->select();//自动结算
        if($info_list){
              foreach($info_list as $val) {
				$storeLogic->auto_transfer($val['store_id']);
              }
		}
	  equity_split();// 自动分红
      Bonus_pool();//奖金池倍赠奖项规则设置  
     //echo "处理成功...";
	 exit;
    }  
	
    /*手动补单*/
    public function Manual_replenishment(){   
	  update_pay_status('201812201042182667'); //可为主单号或子单号
	}
	
	/*生成二维码*/
    public function user_qrcode(){
		generate_qrcode("http://".$_SERVER ['HTTP_HOST'].U('Mobile/user/reg',array('t_id'=>I('t_id',1))),"Public/qrcode/".I('t_id',1).'.png');
		generate_qrcode("http://".$_SERVER ['HTTP_HOST'].U('Mobile/user/reg',array('t_id'=>I('t_id',1))));
    }
}