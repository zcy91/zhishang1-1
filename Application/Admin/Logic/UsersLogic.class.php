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
 * Date: 2015-09-09
 */
 
namespace Admin\Logic;

use Think\Model\RelationModel;

class UsersLogic extends RelationModel
{    
    
    /**
     * 获取指定用户信息
     * @param $uid int 用户UID
     * @param bool $relation 是否关联查询
     *
     * @return mixed 找到返回数组
     */
    public function detail($uid, $relation = true)
    {
        $user = M('users')->where(array('user_id' => $uid))->relation($relation)->find();
        return $user;
    }
    
    /**
     * 改变用户信息
     * @param int $uid
     * @param array $data
     * @return array
     */
    public function update($uid = 0, $data = array())
    {
        $db_res = M('users')->where(array("user_id" => $uid))->data($data)->save();
        if ($db_res) {
            return array(1, "用户信息修改成功");
        } else {
            return array(0, "用户信息修改失败");
        }
    }

    /**
     * 添加用户
     * @param $user
     * @return array
     */
    public function addUser($user)
    {
    	if(M('users')->where(" mobile='".$user['mobile']."'")->count()>0){//addUser
    		return array('status'=>-1,'msg'=>'账号已存在');
    	}
    	$user['password'] = encrypt($user['password']);
    	$user['reg_time'] = time();
    	$user_id = M('users')->add($user);
    	if(!$user_id){
    		return array('status'=>-1,'msg'=>'添加失败');
    	}else{
            //更新族谱与族层
			user_zupuceng($user_id);
    		$pay_points =tpCache('distribut.reg_point_rate'); // 会员注册赠送积分
    		if($pay_points > 0)
    			accountLog($user_id,$pay_points,'pay_points' , '会员注册赠送积分'); // 记录日志流水
    		return array('status'=>1,'msg'=>'添加成功');
    	}
    }   

}