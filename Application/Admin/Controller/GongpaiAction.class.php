<?php
namespace Wsadmin\Action;
use Think\Action;
class GongpaiAction extends CommonAction {
	public function index(){
        $db=M('gongpai');
        $p = I('get.p') ? I('get.p') : '1';
  
        //搜索
        $key = I('get.key');
        $type = I('get.type');
        $time=I('get.time');
        $where=an_time($time,"add_time");
		if($key){
            if($type=='0'){
                $where['dingdanhao']=array('like','%'.$key.'%');
                //$where['_logic']='or';
            }else{
                $where[$type]=$key;
            }
        }

		$count=$db->where($where)->count();
		//echo $db->getLastSql();
		$Page=new \Think\Page($count,18);
		$show=$Page->show();
		$list=$db->where($where)->order('id asc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);
        $this->assign("page",$show);
        $this->assign("z_trade_no",$db->where($where)->count());
        
        $where['sh'] =1;
        $this->assign("f_price",$db->where($where)->count());
        $where['sh'] =0;
        $this->assign("w_price",$db->where($where)->count());
        
        $this->assign("count",$count);
        $this->assign("p",$p);
        $this->display();
	}
	
//队列形式

	public function index_pic(){
   
        $db=M('user');
        $p = I('get.p') ? I('get.p') : '1';
        //搜索
        $key = I('get.key');
		$ceng= I('get.ceng') ? I('get.ceng') : '3';
	    $Gongpai = D('Gongpai');
	    $this->assign("ceng",$ceng);
	    $this->assign("moue_list",$Gongpai->moue_list($ceng,$key));
        $this->display();
	}

//会员审核相关操作
	public function daili_sh(){
		$db=M('gongpai');
		$where['id']=I('get.id');
		$data['sh'] =I('get.sh');
		$put=$db->where($where)->save($data); 
	    	if($put){
	    		$this->success('操作成功');
	    	}else{
	    		$this->error('操作失败');
	    	}
	}
	
//会员删除相关操作
    public function daili_del(){
        $db=M('gongpai');
        $where_id=I('post.del_id');
        $del=$db->where(array('id'=>array('in',$where_id)))->delete();
        if($del){
            $this->success("成功清理{$del}条信息");
        }else{
            $this->error("清理失败");
        }
	}	
//修改会员相关操作

    public function update(){
        $db=M('gongpai');	
        $where['id']=I('get.id');
		$list=$db->where($where)->find();
		$this->assign('list',$list);
        $this->display();
	}
	
//修改会员保存相关操作

    public function update_sava(){
        $where['id']=I('get.id');
        $db=M('gongpai');	
		if (I('post.user_id')==""){
		echo "<script>alert('请输入会员编号');history.back();</script>" ;
		exit;
		}
		
		$list=M('user')->where('id='.I('post.user_id'))->select();
		if (empty($list)){
		echo "<script>alert('你输入的会员编号不存在,返回后重新录入');history.back();</script>" ;
		exit;
		}
		
		$data['user_id']=I('post.user_id');
	
		    if(I('post.type')==1){
			$data['dingdanhao']= "0";	
			}else{
			$data['dingdanhao']= I('post.dingdanhao');		
			}

		$data['add_time']=strtotime(date("Y-m-d H:i:s"));
		
		$data['sh']=I('post.sh');
		$data['type']=I('post.type');
		$data['content']=I('post.content');
		$up_date=$db->where($where)->save($data); // 根据条件更新记录
        if($up_date){
            $this->success("修改成功",U('index'));
        }else{
            $this->error("操作不当");
        }
   }	
   
//添加会员相关操作
    public function add(){
        $this->display();
	}
//添加会员保存相关操作

    public function add_sava(){

      $user_id=I('post.user_id');
	  $dingdanhao=(I('post.dingdanhao'))?I('post.dingdanhao'):'后台添加';
	  $up_date_lidt=gongpai_add($user_id,I('post.type'),$dingdanhao,I('post.content'));
       
	   if($up_date_lidt){
			
			//是否返点
			if(I('post.fandian')==1){
	         jiangli_add($up_date_lidt);//新订单排点见点分红	
			}
			//是否加权分红
			if(I('post.jiaquan')==1){
		
		$list=M('user')->where('id='.$user_id)->find();		
		$data['user_id']=$user_id;	
		$data['name']=$list["name"];
		$data['xingming']=$list["user_name"];
		$data['dan_id']=0;
		$data['dianha']=$list["dianha"];
		$data['money']= 0;
		$data['add_time']=strtotime(date("Y-m-d H:i:s"));
        $data['zb']="后台增加";
		M("jiaquan")->add($data); // 根据条件更新记录

			}
			$this->success("添加成功",U('index'));
        }else{
			$this->error("操作不当");
        } 
   }	
   
}