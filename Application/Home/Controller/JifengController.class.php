<?php
namespace Home\Controller;
class JifengController extends BaseController {//wei_end
    public function jifeng(){
		$wl_info=M('member','dream_','DB_NEW')->where("id=".I('post.userid'))->field("username")->find();//新增帐号同步
		$u_info = M('users')->where("wl_id=".$wl_info['username'])->field("user_id")->find();//原id同步方式 "wl_id=".I('post.userid')
		if($u_info and I('post.jf')!=0){//处理事件
          accountLog($u_info["user_id"],0,I('post.jf'),I('post.zb'),0,0,0,I('post.add_date'));
		}
    }
}