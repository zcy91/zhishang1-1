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
 * Date: 2015-10-09
 */

namespace Admin\Controller;
use Admin\Logic\GoodsLogic;
class SystemController extends BaseController{
	
	/*
	 * 配置入口
	 */
	public function index()
	{          
		/*配置列表*/
		/*$group_list = array('shop_info'=>'网站信息','basic'=>'基本设置','sms'=>'短信设置','shopping'=>'购物流程设置','smtp'=>'邮件设置','water'=>'水印设置');// ,'distribut'=>'分销设置');*/
		$group_list = array('shop_info'=>'网站信息','basic'=>'基本设置','sms'=>'短信设置','shopping'=>'购物流程设置','distribut'=>'核心设置');		
		$this->assign('group_list',$group_list);
		$inc_type =  I('get.inc_type','shop_info');
		$this->assign('inc_type',$inc_type);
		$this->assign('config',tpCache($inc_type));//当前配置项
        C('TOKEN_ON',false);
    	$level_info = M('user_level')->where('1=1')->order('level_id')->select();
    	$this->assign('level_info',$level_info);
		
		
		
		$this->display($inc_type);
	}
	
	/*
	 * 新增修改配置
	 */
	public function handle()
	{
		$param = I('post.');
		$inc_type = $param['inc_type'];
		//unset($param['__hash__']);
		unset($param['inc_type']);
		tpCache($inc_type,$param);
		$this->success("操作成功",U('System/index',array('inc_type'=>$inc_type)));
	}        
        
    public function bonus_ruleList(){
           $model = M("bonus_rule");
           $bonus_ruleList =  $model->order("sort asc")->select();        
           $this->assign('bonus_ruleList',$bonus_ruleList);
           $this->display();          
     }

    public function bonus_ruledelNav(){     
        // 删除导航
        M('bonus_rule')->where("id = {$_GET['id']}")->delete();   
        $this->success("操作成功!!!",U('Admin/System/bonus_ruleList'));
    }
     /**
     * 添加修改编辑 前台导航
     */
    public  function bonusaddEditNav(){                        
            $model = D("bonus_rule");            
            if(IS_POST)
            {
                    $model->create();
                    // $model->url = strstr($model->url, 'http') ? $model->url : "http://".$model->url; // 前面自动加上 http://
                    if($_GET['id'])
                        $model->save();
                    else
                        $model->add();
                    
                    $this->success("操作成功!!!",U('Admin/System/bonus_ruleList'));               
                    exit;
            }                    
           // 点击过来编辑时                 
           $id = $_GET['id'] ? $_GET['id'] : 0;       
           $navigation = $model->find($id);                 
           $this->assign('navigation',$navigation);
           $this->display('_bonus_rule');
    }   

       /**
        * 自定义导航
        */
    public function navigationList(){
           $model = M("Navigation");
           $navigationList =  $model->order("sort asc")->select();        
           $this->assign('navigationList',$navigationList);
           $this->display('navigationList');          
     }

     /**
     * 添加修改编辑 前台导航
     */
    public  function addEditNav(){                        
            $model = D("Navigation");            
            if(IS_POST)
            {
                    $model->create();
                    // $model->url = strstr($model->url, 'http') ? $model->url : "http://".$model->url; // 前面自动加上 http://
                    if($_GET['id'])
                        $model->save();
                    else
                        $model->add();
                    
                    $this->success("操作成功!!!",U('Admin/System/navigationList'));               
                    exit;
            }                    
           // 点击过来编辑时                 
           $id = $_GET['id'] ? $_GET['id'] : 0;       
           $navigation = $model->find($id);      
           
           // 系统菜单
           $GoodsLogic = new GoodsLogic();
           $cat_list = $GoodsLogic->goods_cat_list();
           $select_option = array();                       
            foreach ($cat_list AS $key => $value)
            {
                    $strpad_count = $value['level']*4;
                    $select_val = U("/Home/Goods/goodsList",array('id'=>$key));
                    $select_option[$select_val] = str_pad('',$strpad_count,"-",STR_PAD_LEFT).$value['name'];                                        
            }           
           $system_nav = array(
               '/index.php?m=Home&c=Index&a=promoteList' => '限时抢购',
               '/index.php?m=Home&c=Activity&a=group_list' => '团购',       
               '/index.php?m=Home&c=Index&a=street' => '店铺街',
               '/index.php?m=Home&c=Goods&a=integralMall' => tpCache('distribut.jifeng_name').'商城',
           );           
           $system_nav = array_merge($system_nav,$select_option);
           $this->assign('system_nav',$system_nav);
           
           $this->assign('navigation',$navigation);
           $this->display('_navigation');
    }   
    
    /**
     * 删除前台 自定义 导航
     */
    public function delNav()
    {     
        // 删除导航
        M('Navigation')->where("id = {$_GET['id']}")->delete();   
        $this->success("操作成功!!!",U('Admin/System/navigationList'));
    }
	
	public function refreshMenu(){
		$pmenu = $arr = array();
		$rs = M('system_module')->where('level>1 AND visible=1')->order('mod_id ASC')->select();
		foreach($rs as $row){
			if($row['level'] == 2){
				$pmenu[$row['mod_id']] = $row['title'];//父菜单
			}
		}

		foreach ($rs as $val){
			if($row['level']==2){
				$arr[$val['mod_id']] = $val['title'];
			}
			if($row['level']==3){
				$arr[$val['mod_id']] = $pmenu[$val['parent_id']].'/'.$val['title'];
			}
		}
		return $arr;
	}
	/**
	 * 清空系统缓存
	 */
	public function cleanCache(){

		if(IS_POST)
		{
			in_array('cache',$_POST['clear']) && delFile('./Application/Runtime/Cache');// 模板缓存
			in_array('data',$_POST['clear'])  && delFile('./Application/Runtime/Data');// 项目数据
			in_array('logs',$_POST['clear'])  && delFile('./Application/Runtime/Logs');// logs日志
			in_array('temp',$_POST['clear'])  && delFile('./Application/Runtime/Temp');// 临时数据
			in_array('cacheAll',$_POST['clear'])  && delFile('./Application/Runtime');// 清除所有
			//in_array('goods_thumb',$_POST['clear'])  && delFile('./Public/upload/goods/thumb'); // 删除缩略图

			// 删除静态文件
			$html_arr = glob("./Application/Runtime/Html/*.html");
			foreach ($html_arr as $key => $val)
			{

				in_array('index',$_POST['clear']) && strstr($val,'Home_Index_index.html') && unlink($val); // 首页
				in_array('goodsList',$_POST['clear']) && strstr($val,'Home_Goods_goodsList') && unlink($val); // 列表页
				in_array('channel',$_POST['clear']) && strstr($val,'Home_Channel_index') && unlink($val);  // 频道页

				in_array('articleList',$_POST['clear']) && strstr($val,'Index_Article_articleList') && unlink($val);  // 文章列表页
				in_array('detail',$_POST['clear']) && strstr($val,'Index_Article_detail') && unlink($val);  // 文章详情
				in_array('articleList',$_POST['clear']) && strstr($val,'Doc_Index_index_') && unlink($val);  // 文章列表页
				in_array('detail',$_POST['clear']) && strstr($val,'Doc_Index_article_') && unlink($val);  // 文章详情

				// 详情页
				if(in_array('goodsInfo',$_POST['clear']))
				{
					if(strstr($val,'Home_Goods_goodsInfo') || strstr($val,'Home_Goods_ajaxComment') || strstr($val,'Home_Goods_ajax_consult'))
						unlink($val);
				}
			}
			$this->success("操作完成!!!");
			exit;
		}
		$this->display();
	}

	/**
	 * 清空静态商品页面缓存
	 */
	public function ClearGoodsHtml(){
		$goods_id = I('goods_id');
		if(unlink("./Application/Runtime/Html/Home_Goods_goodsInfo_{$goods_id}.html"))
		{
			// 删除静态文件
			$html_arr = glob("./Application/Runtime/Html/Home_Goods*.html");
			foreach ($html_arr as $key => $val)
			{
				strstr($val,"Home_Goods_ajax_consult_{$goods_id}") && unlink($val); // 商品咨询缓存
				strstr($val,"Home_Goods_ajaxComment_{$goods_id}") && unlink($val); // 商品评论缓存
			}
			$json_arr = array('status'=>1,'msg'=>'清除成功','result'=>'');
		}
		else
		{
			$json_arr = array('status'=>-1,'msg'=>'未能清除缓存','result'=>'' );
		}
		$json_str = json_encode($json_arr);
		exit($json_str);
	}
	/**
	 * 商品静态页面缓存清理
	 */
	public function ClearGoodsThumb(){
		$goods_id = I('goods_id');
		delFile("./Public/upload/goods/thumb/$goods_id"); // 删除缩略图
		$json_arr = array('status'=>1,'msg'=>'清除成功,请清除对应的静态页面','result'=>'');
		$json_str = json_encode($json_arr);
		exit($json_str);
	}
	/**
	 * 清空 文章静态页面缓存
	 */
	public function ClearAritcleHtml(){
		$article_id = I('article_id');
		unlink("./Application/Runtime/Html/Index_Article_detail_{$article_id}.html"); // 清除文章静态缓存
		unlink("./Application/Runtime/Html/Doc_Index_article_{$article_id}_api.html"); // 清除文章静态缓存
		unlink("./Application/Runtime/Html/Doc_Index_article_{$article_id}_phper.html"); // 清除文章静态缓存
		unlink("./Application/Runtime/Html/Doc_Index_article_{$article_id}_android.html"); // 清除文章静态缓存
		unlink("./Application/Runtime/Html/Doc_Index_article_{$article_id}_ios.html"); // 清除文章静态缓存
		$json_arr = array('status'=>1,'msg'=>'操作完成','result'=>'' );
		$json_str = json_encode($json_arr);
		exit($json_str);
	}
        
      //发送测试邮件
      public function send_email(){
        	$param = I('post.');
        	unset($param['inc_type']);
        	tpCache($param['inc_type'],$param);
        	if(send_email($param['test_eamil'],'后台测试','测试发送验证码:'.mt_rand(1000,9999))){
        		exit(json_encode(1));
        	}else{
        		exit(json_encode(0));
        	}
      }
	        
    /**
     *  管理员登录后 处理相关操作          
     */
     public function login_task()
     {
         
        // 随机清空购物车的垃圾数据
        $time = time() - 3600; // 删除购物车数据  1小时以前的
        M("Cart")->where("user_id = 0 and  add_time < $time")->delete();            
        $today_time = time();
        
        // 发货后满多少天自动收货确认
        $auto_confirm_date = tpCache('shopping.auto_confirm_date');
        $auto_confirm_date = $auto_confirm_date * (60 * 60 * 24); // 7天的时间戳        
        $order_id_arr = M('order')->where("order_status = 1 and shipping_status = 1 and ($today_time - shipping_time) >  $auto_confirm_date")->getField('order_id',true);       
        foreach($order_id_arr as $k => $v)
        {
            confirm_order($v);
        }        
     }     
     
     function ajax_get_action()
     {
     	$control = I('controller');
     	$advContrl = get_class_methods("Admin\\Controller\\".$control);
     	//dump($advContrl);
     	$baseContrl = get_class_methods('Admin\Controller\BaseController');
     	$diffArray  = array_diff($advContrl,$baseContrl);
     	$html = '';
     	foreach ($diffArray as $val){
     		$html .= "<option value='".$val."'>".$val."</option>";
     	}
     	exit($html);
     }
     
     function right_list(){
     	$right_list = M('system_menu')->where('is_del=0')->order('paixu asc')->select();
    	foreach ($right_list as $val){
    		$modules[$val['group']][] = $val;
    	}
    	//权限组
    	$group = array('system'=>'系统设置','access'=>'权限管理','member'=>'会员中心','goods'=>'商品中心','order'=>'订单中心','Store'=>'店铺管理','Ad'=>'广告管理','finance'=>'财务统计','count'=>'统计报表','detail'=> tpCache('distribut.jifeng_name').'明细');
       
    	foreach ($group as $k=>$v){
    		$lists[$k]=$modules[$k];
    	}

     	$this->assign('modules',$lists);
     	$this->assign('group',$group);
     	$this->display();
     }
      
     public function edit_right(){
     	if(IS_POST){
     		$data = I('post.');
     		$data['right'] = implode(',',$data['right']);
     		if(!empty($data['id'])){
     			M('system_menu')->where(array('id'=>$data['id']))->save($data);
     		}else{
     			if(M('system_menu')->where(array('name'=>$data['name']))->count()>0){
     				$this->error('该权限名称已添加，请检查',U('System/right_list'));
     			}
     			unset($data['id']);
     			M('system_menu')->add($data);
     		}
     		$this->success('操作成功',U('System/right_list'));
     		exit;
     	}
     	$id = I('id');
     	if($id){
     		$info = M('system_menu')->where(array('id'=>$id))->find();
     		$info['right'] = explode(',', $info['right']);
     		$this->assign('info',$info);
     	}
    	$group = array('system'=>'系统设置','access'=>'权限管理','member'=>'会员中心','goods'=>'商品中心','order'=>'订单中心','Store'=>'店铺管理','Ad'=>'广告管理','finance'=>'财务统计','count'=>'统计报表','detail'=> tpCache('distribut.jifeng_name').'明细');
     	$planPath = APP_PATH.'Admin/Controller';
     	$planList = array();
     	$dirRes   = opendir($planPath);
     	while($dir = readdir($dirRes))
     	{
     		if(!in_array($dir,array('.','..','.svn')))
     		{
     			$planList[] = basename($dir,'.class.php');
     		}
     	}
     	$this->assign('planList',$planList);
     	$this->assign('group',$group);
     	$this->display();
     }
      
     public function right_del(){
     	$id = I('del_id');
     	if(is_array($id)){
     		$id = implode(',', $id);
     	}
     	if(!empty($id)){
     		$r = M('system_menu')->where("id in ($id)")->delete();
     		if($r){
     			respose(1);
     		}else{
     			respose('删除失败');
     		}
     	}else{
     		respose('参数有误');
     	}
     }
	 
	 
	 
       /**
        * 自定义导航
        */
    public function wapnavigationList(){
           $model = M("wapnavigation");
		   $res = $list = array();
           $p = empty($_REQUEST['p']) ? 1 : $_REQUEST['p'];
           $size = empty($_REQUEST['size']) ? 10 : $_REQUEST['size'];
		   
        $where = " 1 = 1 ";
        $keywords = trim(I('keywords'));
        $keywords && $where.=" and name like '%$keywords%' ";
        $lei = I('lei');
		if($lei!=''){$where.=" and lei = $lei ";}
        $navigationList = $model->where($where)->order('sort asc')->page("$p,$size")->select();
        $count = $model->where($where)->count();// 查询满足要求的总记录数
        $pager = new \Think\Page($count,$size,array('lei'=>$lei));// 实例化分页类 传入总记录数和每页显示的记录数
        $page = $pager->show();//分页显示输出
        $this->assign('navigationList',$navigationList);
		$this->assign('lei',$lei?$lei:'');
		$this->assign('p',$p);
		$this->assign('wap_lei_show',C('wap_lei_show'));
		$this->assign('page',$page);// 赋值分页输出
		   
           $this->display();          
     }
    
     /**
     * 添加修改编辑 前台导航
     */
    public  function wapaddEditNav(){                        
            $model = D("wapnavigation");            
            if(IS_POST)
            {
                    $model->create();
                    // $model->url = strstr($model->url, 'http') ? $model->url : "http://".$model->url; // 前面自动加上 http://

                    if($_GET['id'])
                        $model->save();
                    else
                        $model->add();
                    
                    $this->success("操作成功!!!",U('Admin/System/wapnavigationList',array('lei'=>I('get.lei'),'p'=>I('get.p'))));               
                    exit;
            }                    
           // 点击过来编辑时                 
           $id = $_GET['id'] ? $_GET['id'] : 0;       
           $navigation = $model->find($id);      
           
           // 系统菜单
           $GoodsLogic = new GoodsLogic();
           $cat_list = $GoodsLogic->goods_cat_list();
           $select_option = array();                       
            foreach ($cat_list AS $key => $value)
            {
                    $strpad_count = $value['level']*4;
                    $select_val = U("/Mobile/Goods/goodsList",array('id'=>$key));
                    $select_option[$select_val] = str_pad('',$strpad_count,"-",STR_PAD_LEFT).$value['name'];                                        
            }           
           $system_nav = array(
               '/index.php?m=Mobile&c=Index&a=promoteList' => '限时抢购',
               '/index.php?m=Mobile&c=Activity&a=group_list' => '团购',       
               '/index.php?m=Mobile&c=Index&a=street' => '店铺街',
               '/index.php?m=Mobile&c=Goods&a=integralMall' => tpCache('distribut.jifeng_name').'商城',
           );           
           $system_nav = array_merge($system_nav,$select_option);
           $this->assign('system_nav',$system_nav);

           $this->assign('navigation',$navigation);
		   $this->assign('wap_lei_show',C('wap_lei_show'));
           $this->display('_wapnavigation');
    }   
    
    /**
     * 删除前台 自定义 导航
     */
    public function wapdelNav()
    {     
        // 删除导航
        M('wapnavigation')->where("id = {$_GET['id']}")->delete();   
        $this->success("操作成功!!!",U('Admin/System/wapnavigationList',array('lei'=>I('get.lei'),'p'=>I('get.p'))));
    }
	
	 
}