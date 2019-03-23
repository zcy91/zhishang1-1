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
class DetailController extends BaseController{
	/*
	 * 配置入口
	 */
	public function index(){
           $model = M("account_log");
           $p = empty($_REQUEST['p']) ? 1 : $_REQUEST['p'];
           $size = empty($_REQUEST['size']) ? 13 : $_REQUEST['size'];
		   $where['user_id']=array('neq',0);
		   if(I('types'))$where['types']=I('types');
		   if(I('key')){
			   if(is_numeric(I('key'))){ 
			   $where['user_id']=I('key');
			   }else{
			   $where['order_sn']=array('like',"%".(I('key'))."%");  
			   }
		   }
		   if(I('desc'))$where['desc']=jifeng_replace_all(I('desc'));
           $List = $model->where($where)->order('log_id desc')->page("$p,$size")->select();
           $pager = new \Think\Page($model->where($where)->count(),$size);// 实例化分页类 传入总记录数和每页显示的记录数
		   $date['types']=I('types');
		   $date['key']=I('key');
		   $date['desc']=I('desc');
		   $pager->parameter = array_map('urldecode',$date);
           $page = $pager->show();//分页显示输出
           $this->assign('jifeng_sum',$model->where($where)->sum('money'));
		   $this->assign('List',$List);
		   $this->assign('leixing',array(tpCache('distribut.equity_name').'分红','激活'.tpCache('distribut.jifeng_name'),'购买'.tpCache('distribut.jifeng_name'),tpCache('distribut.jifeng_name').'转赠','快捷支付','倍增奖励','商城购物',tpCache('distribut.jifeng_name').'转钱','会员提现','业绩分佣','发放额度'));
		   $this->assign('p',$p);
		   $this->assign('page',$page);// 赋值分页输出
           $this->display();          
	}
	
	/*
	 * 新增修改配置
	 */
	public function handle()
	{
		$param = I('post.');
		$inc_type = $param['inc_type'];
		unset($param['__hash__']);
		unset($param['inc_type']);
		tpCache($inc_type,$param);
		$this->success("操作成功",U('Detail/index',array('inc_type'=>$inc_type)));
	}        

    public function bonus_ruleList(){
           $model = M("bonus_rule");
           $bonus_ruleList =  $model->order("sort asc")->select();        
           $this->assign('bonus_ruleList',$bonus_ruleList);
           $this->display();          
     }

    public function bonus_ruledelNav()
    {     
        // 删除导航
        M('bonus_rule')->where("id = {$_GET['id']}")->delete();   
        $this->success("操作成功!!!",U('Admin/Detail/bonus_ruleList'));
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
                    
                    $this->success("操作成功!!!",U('Admin/Detail/bonus_ruleList'));               
                    exit;
            }                    
           // 点击过来编辑时                 
           $id = $_GET['id'] ? $_GET['id'] : 0;       
           $navigation = $model->find($id);                 
           $this->assign('navigation',$navigation);
           $this->display('_bonus_rule');
    }   



    public function equity_split(){
           $model = M("equity_split");
           $p = empty($_REQUEST['p']) ? 1 : $_REQUEST['p'];
           $size = empty($_REQUEST['size']) ? 10 : $_REQUEST['size'];
           $List = $model->where($where)->order('id desc')->page("$p,$size")->select();
           $pager = new \Think\Page($model->where($where)->count(),$size);// 实例化分页类 传入总记录数和每页显示的记录数
           $page = $pager->show();//分页显示输出
           $this->assign('List',$List);
		   $this->assign('p',$p);
		   $this->assign('page',$page);// 赋值分页输出
           $this->display();          
     }


    public function jifeng(){
           $model = M("account_log");
           $p = empty($_REQUEST['p']) ? 1 : $_REQUEST['p'];
           $size = empty($_REQUEST['size']) ? 15 : $_REQUEST['size'];
		   $where['user_id']=0;
		   if(I('desc'))$where['desc']=jifeng_replace_all(I('desc'));
           $List = $model->where($where)->order('log_id desc')->page("$p,$size")->select();
           $pager = new \Think\Page($model->where($where)->count(),$size);// 实例化分页类 传入总记录数和每页显示的记录数
           $page = $pager->show();//分页显示输出
           $this->assign('jifeng_sum',$model->where("user_id=0 and types=2")->sum('money'));
		   $this->assign('money_sum',$model->where("user_id=0 and types=1")->sum('money'));
		   $this->assign('List',$List);
		   $this->assign('leixing',array(tpCache('distribut.equity_name').'分红','激活'.tpCache('distribut.jifeng_name'),'购买'.tpCache('distribut.jifeng_name'),'倍增奖励','会员提现','商家提现','业绩分佣'));
		   $this->assign('p',$p);
		   $this->assign('page',$page);// 赋值分页输出
           $this->display();          
     }


    public function zwzq_list(){
           $model = M("user_zwzq");
           $p = empty($_REQUEST['p']) ? 1 : $_REQUEST['p'];
           $size = empty($_REQUEST['size']) ? 10 : $_REQUEST['size'];
		   $order=I('order','id desc');
		   $leixing=I('leixing',0);
           $where="1=1";
		   if($leixing){ $where.= " and leixing='".$leixing."'";}
           $List = $model->where($where)->order($order)->page("$p,$size")->select();
           $pager = new \Think\Page($model->where($where)->count(),$size);// 实例化分页类 传入总记录数和每页显示的记录数
           $page = $pager->show();//分页显示输出
           $this->assign('List',$List);
		   $count_sum=$model->where($where)->sum('money');
           $this->assign('count_sum',$count_sum?$count_sum:0);
		   $tg_sum=$model->where($where." and zt=1")->sum('money');
		   $this->assign('tg_sum',$tg_sum?$tg_sum:0);
		   $shifang=$model->where($where)->sum('amount');
		   $this->assign('shifang',$shifang?$shifang:0);
		   $this->assign('p',$p);
		   $this->assign('page',$page);// 赋值分页输出
           $this->display();          
     }
  public function zwzq_show(){
        $zwzq = M('user_zwzq')->where(array('id' =>I('id')))->find();
		if(I('post.')){
		  header('Content-Type:application/json');
		  $id=I('post.id');
		  $zt=I('post.zt');
		  $amount=I('post.amount');
		  $bz=I('post.bz');
		  if(!zt){exit(json_encode(array('code'=>0,'msg'=>'审核状态不正确')));}		  
		   M("user_zwzq")->where(array('id' =>I('id')))->setField(array('zt'=>$zt,'amount'=>$amount,'bz'=>$bz,'end_time'=>time()));
		  if($zt==1){//发放额度
             accountLog($zwzq['user_id'],$amount,'dai_points' , "发放额度",$zwzq['money'],0,'债权'.$zwzq['money'].'元,发放'.$amount.'额度'); // 增加额度
		  }
		  exit(json_encode(array('code'=>1,'msg'=>'操作成功')));
		}
        $this->assign('zwzq', $zwzq); 
		$this->display();    
  }
}