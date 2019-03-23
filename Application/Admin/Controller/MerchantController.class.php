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
 * Date: 2016-05-27
 */
namespace Admin\Controller;
use Admin\Logic\StoreLogic;

class MerchantController extends BaseController{
	
	
	/*编辑自营店铺*/
	public function merchant_edit(){
		if(IS_POST){
			$data = I('post.');
			if(M('merchant')->where("id=".$data['store_id'])->save($data)){
				$this->success('编辑店铺成功',U('Store/store_own_list'));
				exit;
			}else{
				$this->error('编辑失败');
			}
		}
		$store_id = I('merchant_id',0);
		$store = M('merchant')->where("id=$store_id")->find();
		$this->assign('store',$store);
		$this->display();
	}
	
	
	/*删除店铺*/
	public function merchant_del(){
		$store_id = I('del_id');
		$info = M('merchant')->where("id=$store_id")->find();
		M('merchant')->where("id=$store_id")->delete();
		adminLog("删除店铺".$info['title']);
		respose(1);
	}
	
	//店铺信息
	public function store_info(){
		$store_id = I('store_id');
		$store = M('store')->where("store_id=".$store_id)->find();
		$this->assign('store',$store);
		$apply = M('store_apply')->where("user_id=".$store['user_id'])->find();
		$this->assign('apply',$apply);
		$bind_class_list = M('store_bind_class')->where("store_id=".$store_id)->select();
		$goods_class = M('goods_category')->getField('id,name');
		for($i = 0, $j = count($bind_class_list); $i < $j; $i++) {
			$bind_class_list[$i]['class_1_name'] = $goods_class[$bind_class_list[$i]['class_1']];
			$bind_class_list[$i]['class_2_name'] = $goods_class[$bind_class_list[$i]['class_2']];
			$bind_class_list[$i]['class_3_name'] = $goods_class[$bind_class_list[$i]['class_3']];
		}
		$this->assign('bind_class_list',$bind_class_list);
		$this->display();
	}
	
	//线下店铺列表
	public function merchant_list(){
		$model =  M('merchant');
        $map['id'] = array('neq',"0");	
		$merchant_name = I('merchant_name');
		if($merchant_name){
		   $map['title'] = array('like',"%$merchant_name%");
		   if(is_numeric($merchant_name)){
			$map['id'] =$merchant_name;	
			$map['user_id'] =$merchant_name;	  
			$map['_logic'] ='or';
		   }
		}
		$count = $model->where($map)->count();
		//echo $count;//->fetchSql()$model->getLastSql();
		$Page = new \Think\Page($count,15);
		$list = $model->where($map)->order('addtime DESC')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);	
		$show = $Page->show();
		$this->assign('page',$show);

		$this->display();
	}

}