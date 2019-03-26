<?php
namespace Mobile\Controller;
use Home\Logic\StoreLogic;
use Home\Logic\UsersLogic;
use Mobile\Logic\OrderGoodsLogic;
use Think\Page;
use Think\Verify;
class UserController extends MobileBaseController{
    public $user_id = 0;
    public $user = array();
    /*
    * 初始化操作
    */
    public function _initialize(){
//      $order_settlement = settlement_order(435); // 调用全局结算方法
//	    print_r($order_settlement);
//     	exit;
//		feng_ying(M('order')->where("order_id =452")->find());
//		exit;
        parent::_initialize();
        if (session('?user') || $_COOKIE['user_id']) {
            $user = session('user')?session('user'):array('user_id'=>$_COOKIE['user_id']);
            $user = M('users')->where("user_id = {$user['user_id']}")->find();
            session('user', $user);  //覆盖session 中的 user
            $this->user = $user;
            $this->user_id = $user['user_id'];
            $this->assign('user', $user); //存储用户信息

        }
        $nologin = array(
            'login', 'pop_login', 'do_login', 'logout', 'verify', 'set_pwd', 'finished',
            'verifyHandle', 'reg', 'send_sms_reg_code', 'find_pwd', 'check_validate_code',
            'forget_pwd', 'check_captcha', 'check_username', 'send_validate_code', 'express',);
        if (!$this->user_id && !in_array(ACTION_NAME, $nologin)){
            header("location:" . U('Mobile/User/login'));
            exit;
        }
        $order_status_coment = array(
            'WAITPAY' => '待付款 ', //订单查询状态 待支付
            'WAITSEND' => '待发货', //订单查询状态 待发货
            'WAITRECEIVE' => '待收货', //订单查询状态 待收货
            'WAITCCOMMENT' => '待评价', //订单查询状态 待评价
        );
        $this->assign('order_status_coment', $order_status_coment);
    }
    /*用户中心首页*/
    public function index(){
        $order_count = M('order')->where("user_id = {$this->user_id}")->count(); // 我的订单数
        $goods_collect_count = M('goods_collect')->where("user_id = {$this->user_id}")->count(); // 我的商品收藏
        $comment_count = M('comment')->where("user_id = {$this->user_id}")->count();//  我的评论数
        $coupon_count = M('coupon_list')->where("uid = {$this->user_id}")->count(); // 我的优惠券数量
        $level_name = M('user_level')->where("level_id = '{$this->user['level']}'")->getField('level_name'); // 等级名称
        $this->assign('level_name', $level_name);
        $this->assign('order_count', $order_count);
        $this->assign('goods_collect_count', $goods_collect_count);
        $this->assign('comment_count', $comment_count);
        $this->assign('coupon_count', $coupon_count);
		$merchant_info = M('store_apply')->where("user_id = {$this->user_id}")->order("id desc")->find();//查询是否开通线下店铺
//        var_dump($this->user_id);die;
//        var_dump($merchant_info);die;
		$this->assign('merchant',$merchant_info);
        $this->display();
    }
    public function logout(){
        session_unset();
        session_destroy();
        setcookie('cn', '', time() - 3600, '/');
        setcookie('user_id', '', time() - 3600, '/');
        //$this->success("退出成功",U('Mobile/Index/index'));
        header("Location:" . U('Mobile/Index/index'));
    }

    /** 账户资金*/
    public function account(){
        $user = session('user');
        //获取账户资金记录
        $logic = new UsersLogic();
        $data = $logic->get_account_log($this->user_id, I('get.type'));
        $account_log = $data['result'];

        $this->assign('user', $user);
        $this->assign('account_log', $account_log);
        $this->assign('page', $data['show']);

        if ($_GET['is_ajax']) {
            $this->display('ajax_account_list');
            exit;
        }
        $this->display();
    }

    public function coupon(){
        $logic = new UsersLogic();
        $data = $logic->get_coupon($this->user_id, $_REQUEST['type']);
        $coupon_list = $data['result'];
        $this->assign('coupon_list', $coupon_list);
        $this->assign('page', $data['show']);
        if ($_GET['is_ajax']){
            $this->display('ajax_coupon_list');
            exit;
        }
        $this->display();
    }

    /**
     *  登录
     */
	 
    public function login()
    {
        if ($this->user_id > 0) {
            header("Location: " . U('Mobile/User/index'));
        }
        $referurl = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : U("Mobile/User/index");
        $this->assign('referurl', $referurl);
        $this->display();
    }
	
    public function do_login()
    {
        $username = I('post.username');
        $password = I('post.password');
        $username = trim($username);
        $password = trim($password);
        $logic = new UsersLogic();
        $res = $logic->login($username, $password);
        if ($res['status'] == 1) {
            $res['url'] = urldecode(I('post.referurl'));
	
            session('user', $res['result']);
            setcookie('user_id', $res['result']['user_id'], time()+3600*24*7, '/');
            setcookie('is_distribut', $res['result']['is_distribut'], time()+3600*24*7, '/');
            $nickname = empty($res['result']['nickname']) ? $username : $res['result']['nickname'];
            setcookie('uname', $nickname, time()+3600*24*7, '/');
            setcookie('cn',0,time()-3600,'/');
            $cartLogic = new \Home\Logic\CartLogic();
            $cartLogic->login_cart_handle($this->session_id, $res['result']['user_id']);  //用户登录后 需要对购物车 一些操作
        }
        exit(json_encode($res));
    }
    function getallheaders() {
        $headers = [];
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }

    /**
     *  注册
     */
    public function reg(){
    	if($this->user_id > 0) header("Location: " . U('Mobile/User/index'));
		if(I('get.t_id')){
			setcookie('t_id', I('get.t_id'), time()+3600*24*7, '/');
			if(I('get.shang')=='jia'){
			  $u_info=M('users')->where("user_id=".I('get.t_id')." and level=3")->getField('user_id');	
			  if($u_info){setcookie('shang','jia', time()+3600*24*7, '/');}
			}
		 }
        if (IS_POST){
            $logic = new UsersLogic();
            //验证码检验
            //$this->verifyHandle('user_reg');
            $username = I('post.username', '');
            $password = I('post.password', '');
            $password2 = I('post.password2', '');
            //var_dump(I('post.vension'));die;
            //是否开启注册验证码机制
            if (check_mobile($username) && tpCache('sms.regis_sms_enable')) {
                $code = I('post.mobile_code', '');

//                if (!$code)
//                    $this->error('请输入验证码');
//                $check_code = $logic->sms_code_verify($username, $code, $this->session_id);
//                if ($check_code['status'] != 1)
//                    $this->error($check_code['msg']);
//
            }

            $data = $logic->reg($username, $password, $password2);

            if ($data['status'] != 1)
                $this->error($data['msg']);
            session('user', $data['result']);
            setcookie('user_id', $data['result']['user_id'], null, '/');
            setcookie('is_distribut', $data['result']['is_distribut'], null, '/');
            $cartLogic = new \Home\Logic\CartLogic();
            $cartLogic->login_cart_handle($this->session_id, $data['result']['user_id']);  //用户登录后 需要对购物车 一些操作

            if(I('post.vension') == 'ios_web' || I('post.vension') == 'android_web'){
                $this->success($data['msg'],'https://www.pgyer.com/F8pY');
            }else
            $this->success($data['msg'],'/');
            exit;
        }
        $this->assign('regis_sms_enable', tpCache('sms.regis_sms_enable')); // 注册启用短信：
        $this->assign('sms_time_out', tpCache('sms.sms_time_out')); // 手机短信超时时间
        $this->display();
    }

    public function code(){
        $this->display();
    }
    /*
     * 订单列表
     */
    public function order_list()
    {
        $where = ' user_id=' . $this->user_id;
        //条件搜索 
        if (in_array(strtoupper(I('type')), array('WAITCCOMMENT', 'COMMENTED'))) {
            $where .= " AND order_status in(1,4) "; //代评价 和 已评价
        } elseif (I('type')) {
            $where .= C(strtoupper(I('type')));
        }
        $count = M('order')->where($where)->count();
        $Page = new Page($count, 10);

        $show = $Page->show();
        $order_str = "order_id DESC";
        $order_list = M('order')->order($order_str)->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->select();

        //获取订单商品
        $model = new UsersLogic();
        foreach ($order_list as $k => $v) {
            $order_list[$k] = set_btn_order_status($v);  // 添加属性  包括按钮显示属性 和 订单状态显示属性
            //$order_list[$k]['total_fee'] = $v['goods_amount'] + $v['shipping_fee'] - $v['integral_money'] -$v['bonus'] - $v['discount']; //订单总额
            $data = $model->get_order_goods($v['order_id']);
            $order_list[$k]['goods_list'] = $data['result'];
        }
        $storeList = M('store')->getField('store_id,store_name,store_qq,store_phone'); // 找出所有商品对应的店铺id	
        $this->assign('storeList', $storeList); // 店铺列表
        $this->assign('order_status', C('ORDER_STATUS'));
        $this->assign('shipping_status', C('SHIPPING_STATUS'));
        $this->assign('pay_status', C('PAY_STATUS'));
        $this->assign('page', $show);
        $this->assign('lists', $order_list);
        $this->assign('active', 'order_list');
        $this->assign('active_status', I('get.type'));
        if ($_GET['is_ajax']) {
            $this->display('ajax_order_list');
            exit;
        }
        $this->display();
    }


    /*
     * 订单列表
     */
    public function ajax_order_list(){

    }

    /*
     * 订单详情
     */
    public function order_detail(){
        $id = I('get.id');
        if (empty($id)) {
            $this->error('参数错误');
        }
        $map['order_id'] = $id;
        $map['user_id'] = $this->user_id;
        $order_info = M('order')->where($map)->find();
        $order_info = set_btn_order_status($order_info);  // 添加属性  包括按钮显示属性 和 订单状态显示属性
        if (!$order_info) {
            $this->error('没有获取到订单信息');
            exit;
        }
        //获取订单商品
        $model = new UsersLogic();
        $data = $model->get_order_goods($order_info['order_id']);
        $order_info['goods_list'] = $data['result'];
        $order_info['total_fee'] = $order_info['goods_price'] + $order_info['shipping_price'] - $order_info['integral_money'] - $order_info['coupon_price'] - $order_info['discount'];
        //$region_list = get_region_list();
        $store = M('store')->where("store_id = {$order_info['store_id']}")->find(); // 找出这个商家
        // 店铺地址id
        $ids[] = $store['province_id'];
        $ids[] = $store['city_id'];
        $ids[] = $store['district'];

        $ids[] = $order_info['province'];
        $ids[] = $order_info['city'];
        $ids[] = $order_info['district'];
        if (!empty($ids))
            $regionLits = M('region')->where("id in (" . implode(',', $ids) . ")")->getField("id,name");

        $region_list = get_region_list();
        $invoice_no = M('DeliveryDoc')->where("order_id = $id")->getField('invoice_no', true);
        $order_info[invoice_no] = implode(' , ', $invoice_no);
        //获取订单操作记录
        $order_action = M('order_action')->where(array('order_id' => $id))->select();
        $this->assign('store', $store);
        $this->assign('order_status', C('ORDER_STATUS'));
        $this->assign('shipping_status', C('SHIPPING_STATUS'));
        $this->assign('pay_status', C('PAY_STATUS'));
        //$this->assign('region_list',$region_list);
        $this->assign('regionLits', $regionLits);
        $this->assign('order_info', $order_info);
        $this->assign('order_action', $order_action);
        $this->display();
    }

    public function express()
    {
        $order_id = I('get.order_id', 195);
        $result = $order_goods = $delivery = array();
        $order_goods = M('order_goods')->where("order_id=$order_id")->select();
        $delivery = M('delivery_doc')->where("order_id=$order_id")->limit(1)->find();
        if ($delivery['shipping_code'] && $delivery['invoice_no']) {
            $result = queryExpress($delivery['shipping_code'], $delivery['invoice_no']);
            $this->assign('result', $result);
            $this->assign('order_goods', $order_goods);
            $this->assign('delivery', $delivery);
        }
        $this->display();
    }

    /*
     * 取消订单
     */
    public function cancel_order()
    {
        $id = I('get.id');
        //检查是否有积分，余额支付
        $logic = new UsersLogic();
        $data = $logic->cancel_order($this->user_id, $id);
        if ($data['status'] < 0)
            $this->error($data['msg']);
        $this->success($data['msg']);
    }

    /*
     * 用户地址列表
     */
    public function address_list()
    {
        $address_lists = get_user_address_list($this->user_id);
        $region_list = get_region_list();
        $this->assign('region_list', $region_list);
        $this->assign('lists', $address_lists);
        $this->display();
    }

    /*
     * 添加地址
     */
    public function add_address()
    {
        if (IS_POST) {
            $logic = new UsersLogic();
            $data = $logic->add_address($this->user_id, 0, I('post.'));
            if ($data['status'] != 1)
                $this->error($data['msg']);
            elseif ($_POST['source'] == 'cart2') {
                header('Location:' . U('/Mobile/Cart/cart2', array('address_id' => $data['result'])));
                exit;
            }

            $this->success($data['msg'], U('/Mobile/User/address_list'));
            exit();
        }
        $p = M('region')->where(array('parent_id' => 0, 'level' => 1))->select();
        $this->assign('province', $p);
        //$this->display('edit_address');
        $this->display();

    }

    /*
     * 地址编辑
     */
    public function edit_address()
    {
        $id = I('id');
        $address = M('user_address')->where(array('address_id' => $id, 'user_id' => $this->user_id))->find();
        if (IS_POST) {
            $logic = new UsersLogic();
            $data = $logic->add_address($this->user_id, $id, I('post.'));
            if ($_POST['source'] == 'cart2') {
                header('Location:' . U('/Mobile/Cart/cart2', array('address_id' => $id)));
                exit;
            } else
                $this->success($data['msg'], U('/Mobile/User/address_list'));
            exit();
        }
        //获取省份
        $p = M('region')->where(array('parent_id' => 0, 'level' => 1))->select();
        $c = M('region')->where(array('parent_id' => $address['province'], 'level' => 2))->select();
        $d = M('region')->where(array('parent_id' => $address['city'], 'level' => 3))->select();
        if ($address['twon']) {
            $e = M('region')->where(array('parent_id' => $address['district'], 'level' => 4))->select();
            $this->assign('twon', $e);
        }

        $this->assign('province', $p);
        $this->assign('city', $c);
        $this->assign('district', $d);

        $this->assign('address', $address);
        $this->display();
    }

    /*
     * 设置默认收货地址
     */
    public function set_default()
    {
        $id = I('get.id');
        $source = I('get.source');
        M('user_address')->where(array('user_id' => $this->user_id))->save(array('is_default' => 0));
        $row = M('user_address')->where(array('user_id' => $this->user_id, 'address_id' => $id))->save(array('is_default' => 1));
        if ($source == 'cart2') {
            header("Location:" . U('Mobile/Cart/cart2'));
            exit;
        } else {
            header("Location:" . U('Mobile/User/address_list'));
        }
    }

    /*
     * 地址删除
     */
    public function del_address(){
        $id = I('get.id');
        
        $address = M('user_address')->where("address_id = $id")->find();
        $row = M('user_address')->where(array('user_id'=>$this->user_id,'address_id'=>$id))->delete();                
        // 如果删除的是默认收货地址 则要把第一个地址设置为默认收货地址
        if($address['is_default'] == 1)
        {
            $address2 = M('user_address')->where("user_id = {$this->user_id}")->find();            
            $address2 && M('user_address')->where("address_id = {$address2['address_id']}")->save(array('is_default'=>1));
        }        
        if(!$row)
            $this->error('操作失败',U('User/address_list'));
        else
            $this->success("操作成功",U('User/address_list'));
    } 

    /*
     * 评论晒单
     */
    public function comment()
    {
        $user_id = $this->user_id;
        $status = I('get.status');
        $logic = new UsersLogic();
        $result = $logic->get_comment($user_id, $status); //获取评论列表
        $this->assign('comment_list', $result['result']);
        if ($_GET['is_ajax']) {
            $this->display('ajax_comment_list');
            exit;
        }
        $this->display();
    }

    /*
     *添加评论
     */
    public function add_comment()
    {
        if (IS_POST) {
            // 晒图片
            if ($_FILES[comment_img_file][tmp_name][0]) {
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = $map['author'] = (1024 * 1024 * 3);// 设置附件上传大小 管理员10M  否则 3M
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->rootPath = './Public/upload/comment/'; // 设置附件上传根目录
                $upload->replace = true; // 存在同名文件是否是覆盖，默认为false
                //$upload->saveName  =  'file_'.$id; // 存在同名文件是否是覆盖，默认为false
                // 上传文件
                $upinfo = $upload->upload();
                if (!$upinfo) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                } else {
                    foreach ($upinfo as $key => $val) {
                        $comment_img[] = '/Public/upload/comment/' . $val['savepath'] . $val['savename'];
                    }
                    $add['img'] = serialize($comment_img); // 上传的图片文件
                }
            }

            $user_info = session('user');
            $logic = new UsersLogic();
            $add['goods_id'] = I('goods_id');
            $add['email'] = $user_info['email'];
            $hide_username = I('hide_username');
            if (empty($hide_username)) {
                $add['username'] = $user_info['nickname'];
            }
            $add['order_id'] = I('order_id');
            $add['service_rank'] = I('service_rank');
            $add['deliver_rank'] = I('deliver_rank');
            $add['goods_rank'] = I('goods_rank');
            //$add['content'] = htmlspecialchars(I('post.content'));
            $add['content'] = I('content');
            $add['add_time'] = time();
            $add['ip_address'] = getIP();
            $add['user_id'] = $this->user_id;

            //添加评论
            $row = $logic->add_comment($add);
            if ($row[status] == 1) {
                $this->success('评论成功', U('/Mobile/Goods/goodsInfo', array('id' => $add['goods_id'])));
                exit();
            } else {
                $this->error($row[msg]);
            }
        }
        $rec_id = I('rec_id', 0);
        $order_goods = M('order_goods')->where("rec_id = $rec_id")->find();
        $this->assign('order_goods', $order_goods);
        $this->display();
    }


    /**
     * @time 2016/8/5
     * @author dyr
     * 订单评价列表
     */
    public function comment_list()
    {
        $order_id = I('get.order_id');
        $store_id = I('get.store_id');
        $goods_id = I('get.goods_id');
        $part_finish = I('get.part_finish', 0);
        if (empty($order_id) || empty($store_id)) {
            $this->error("参数错误");
        } else {
            //查找店铺信息
            $store_where['store_id'] = $store_id;
            $store_info = M('store')->field('store_id,store_name,store_phone,store_address,store_logo')->where($store_where)->find();
            if (empty($store_info)) {
                $this->error("该商家不存在");
            }
            //查找订单是否已经被用户评价
            $order_comment_where['order_id'] = $order_id;
            $order_comment_where['deleted'] = 0;
            $order_info = M('order')->field('order_id,order_sn,is_comment,add_time')->where($order_comment_where)->find();
            //查找订单下的所有未评价的商品
            $order_goods_logic = new OrderGoodsLogic();
            $no_comment_goods = $order_goods_logic->get_no_comment_goods($order_id, $goods_id);
            $this->assign('store_info', $store_info);
            $this->assign('order_info', $order_info);
            $this->assign('no_comment_goods', $no_comment_goods);
            $this->assign('part_finish', $part_finish);
            $this->display();
        }
    }

    /**
     * @time 2016/8/5
     * @author dyr
     *  添加评论
     */
    public function conmment_add()
    {
        $anonymous = I('post.anonymous');
        $store_score['describe_score'] = I('post.store_packge_hidden');
        $store_score['seller_score'] = I('post.store_speed_hidden');
        $store_score['logistics_score'] = I('post.store_sever_hidden');
        $order_id = $store_score['order_id'] = $store_score_where['order_id'] = I('post.order_id');
        $goods_id = I('post.goods_id');
        $content = I('post.content');
        $spec_key_name = I('post.spec_key_name');
        $rank = I('post.rank');
        $tag = I('post.tag');
        $store_score['user_id'] = $store_score_where['user_id'] = $this->user_id;
        $store_score_where['deleted'] = 0;
        $store_id = M('order')->where(array('order_id' => $store_score_where['order_id']))->getField('store_id');
        $store_score['store_id'] = $store_id;
        //处理订单评价
        if (!empty($store_score['describe_score']) && !empty($store_score['seller_score']) && !empty($store_score['logistics_score'])) {
            $order_comment = M('order_comment')->where($store_score_where)->find();
            if ($order_comment) {
                M('order_comment')->where($store_score_where)->save($store_score);
                M('order')->where(array('order_id' => $order_id))->save(array('is_comment' => 1));
            } else {
                M('order_comment')->add($store_score);//订单打分
                M('order')->where(array('order_id' => $order_id))->save(array('is_comment' => 1));
            }
            //订单打分后更新店铺评分
            $store_logic = new StoreLogic();
            $store_logic->updateStoreScore($store_id);
        }
        //处理商品评价
        $comment['goods_id'] = $goods_id;
        $comment['order_id'] = $order_id;
        $comment['store_id'] = $store_id;
        $comment['user_id'] = $this->user_id;
        $comment['content'] = $content;
        $comment['ip_address'] = get_client_ip();
        $comment['spec_key_name'] = $spec_key_name;
        $comment['goods_rank'] = $rank;
        $comment['img'] = (empty($value['commment_img'][0])) ? '' : serialize($value['commment_img']);
        $comment['impression'] = (empty($tag[0])) ? '' : implode(',', $tag);
        $comment['is_anonymous'] = empty($anonymous) ? 1 : 0;
        $comment['add_time'] = time();
        M('comment')->add($comment);//想评论表插入数据
        M('order_goods')->where(array('order_id' => $store_score['order_id'], 'goods_id' => $goods_id))->save(array('is_comment' => 1));
        M('goods')->where(array('goods_id' => $goods_id))->setInc('comment_count', 1);
        unset($comment);
        $this->success("评论成功", U('User/comment'));
    }

    /*
     * 个人信息
     */
    public function userinfo()
    {
        $userLogic = new UsersLogic();
        $user_info = $userLogic->get_info($this->user_id); // 获取用户信息
        $user_info = $user_info['result'];
        if (IS_POST) {
            I('post.nickname') ? $post['nickname'] = I('post.nickname') : false; //昵称
            I('post.qq') ? $post['qq'] = I('post.qq') : false;  //QQ号码
			
            if ($_FILES[comment_img_file][tmp_name][0]) {
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = $map['author'] = (1024 * 1024 * 3);// 设置附件上传大小 管理员10M  否则 3M
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->rootPath = './Public/upload/comment/'; // 设置附件上传根目录
                $upload->replace = true; // 存在同名文件是否是覆盖，默认为false
                //$upload->saveName  =  'file_'.$id; // 存在同名文件是否是覆盖，默认为false
                // 上传文件
                $upinfo = $upload->upload();
                if (!$upinfo) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                } else {
                    foreach ($upinfo as $key => $val) {
                        $comment_img[] = '/Public/upload/comment/' . $val['savepath'] . $val['savename'];
                    }
                    $post['head_pic'] = $comment_img[0]; // 上传的图片文件
                }
            }

            I('post.sex') ? $post['sex'] = I('post.sex') : false;  // 性别
            I('post.birthday') ? $post['birthday'] = strtotime(I('post.birthday')) : false;  // 生日
            I('post.province') ? $post['province'] = I('post.province') : false;  //省份
            I('post.city') ? $post['city'] = I('post.city') : false;  // 城市
            I('post.district') ? $post['district'] = I('post.district') : false;  //地区
            I('post.email') ? $post['email'] = I('post.email') : false; //邮箱
            I('post.mobile') ? $post['mobile'] = I('post.mobile') : false; //手机
            $email = I('post.email');
            $mobile = I('post.mobile');
            $code = I('post.mobile_code', '');
			//print_r($post);
			//exit;

            if (!empty($email)) {
                $c = M('users')->where("email = '{$post['email']}' and user_id != {$this->user_id}")->count();
                $c && $this->error("邮箱已被使用");
            }
            if (!empty($mobile)) {
                $c = M('users')->where("mobile = '{$post['mobile']}' and user_id != {$this->user_id}")->count();
                $c && $this->error("手机已被使用");
//                if (!$code)
//                    $this->error('请输入验证码');
//                $check_code = $userLogic->sms_code_verify($mobile, $code, $this->session_id);
//                if ($check_code['status'] != 1)
//                    $this->error($check_code['msg']);
            }

            if (!$userLogic->update_info($this->user_id, $post))
                $this->error("保存失败");
            $this->success("操作成功");
            exit;
        }
        //  获取省份
        $province = M('region')->where(array('parent_id' => 0, 'level' => 1))->select();
        //  获取订单城市
        $city = M('region')->where(array('parent_id' => $user_info['province'], 'level' => 2))->select();
        //  获取订单地区
        $area = M('region')->where(array('parent_id' => $user_info['city'], 'level' => 3))->select();
        $this->assign('province', $province);
        $this->assign('city', $city);
        $this->assign('area', $area);
        $this->assign('user', $user_info);
        $this->assign('sex', C('SEX'));
        $this->display();
    }

    /*
     * 邮箱验证
     */
    public function email_validate()
    {
        $userLogic = new UsersLogic();
        $user_info = $userLogic->get_info($this->user_id); // 获取用户信息
        $user_info = $user_info['result'];
        $step = I('get.step', 1);
        //验证是否未绑定过
        if ($user_info['email_validated'] == 0)
            $step = 2;
        //原邮箱验证是否通过
        if ($user_info['email_validated'] == 1 && session('email_step1') == 1)
            $step = 2;
        if ($user_info['email_validated'] == 1 && session('email_step1') != 1)
            $step = 1;
        if (IS_POST) {
            $email = I('post.email');
            $code = I('post.code');
            $info = session('email_code');
            if (!$info)
                $this->error('非法操作');
            if ($info['email'] == $email || $info['code'] == $code) {
                if ($user_info['email_validated'] == 0 || session('email_step1') == 1) {
                    session('email_code', null);
                    session('email_step1', null);
                    if (!$userLogic->update_email_mobile($email, $this->user_id))
                        $this->error('邮箱已存在');
                    $this->success('绑定成功', U('Home/User/index'));
                } else {
                    session('email_code', null);
                    session('email_step1', 1);
                    redirect(U('Home/User/email_validate', array('step' => 2)));
                }
                exit;
            }
            $this->error('验证码邮箱不匹配');
        }
        $this->assign('step', $step);
        $this->display();
    }

    /*
    * 手机验证
    */
    public function mobile_validate()
    {
        $userLogic = new UsersLogic();
        $user_info = $userLogic->get_info($this->user_id); // 获取用户信息
        $user_info = $user_info['result'];
        $step = I('get.step', 1);
        //验证是否未绑定过
        if ($user_info['mobile_validated'] == 0)
            $step = 2;
        //原手机验证是否通过
        if ($user_info['mobile_validated'] == 1 && session('mobile_step1') == 1)
            $step = 2;
        if ($user_info['mobile_validated'] == 1 && session('mobile_step1') != 1)
            $step = 1;
        if (IS_POST) {
            $mobile = I('post.mobile');
            $code = I('post.code');
            $info = session('mobile_code');
            if (!$info)
                $this->error('非法操作');
            if ($info['email'] == $mobile || $info['code'] == $code) {
                if ($user_info['email_validated'] == 0 || session('email_step1') == 1) {
                    session('mobile_code', null);
                    session('mobile_step1', null);
                    if (!$userLogic->update_email_mobile($mobile, $this->user_id, 2))
                        $this->error('手机已存在');
                    $this->success('绑定成功', U('Home/User/index'));
                } else {
                    session('mobile_code', null);
                    session('email_step1', 1);
                    redirect(U('Home/User/mobile_validate', array('step' => 2)));
                }
                exit;
            }
            $this->error('验证码手机不匹配');
        }
        $this->assign('step', $step);
        $this->display();
    }

    public function collect_list()
    {   
	
        $type = I('get.type', 1);
        if ($type == 1) {
            //商品收藏
        $userLogic = new UsersLogic();
        $data = $userLogic->get_goods_collect($this->user_id);
        $this->assign('page', $data['show']);// 赋值分页输出
        $this->assign('goods_list', $data['result']);
        if ($_GET['is_ajax']) {
            $this->display('ajax_collect_list');
            exit;
        }

        } else {
            //店铺收藏
            $sc_id = I('get.sc_id');
            //$store_class = M('store_class')->field('sc_id,sc_name')->where('')->select();
            $storeLogic = new StoreLogic();
            $store_collect_list = $storeLogic->getCollectStore($this->user_id, $sc_id);			
            $this->assign('page', $store_collect_list['show']);// 赋值分页输出
            $this->assign('store_list', $store_collect_list['result']);
            if ($_GET['is_ajax']) {
               $this->display('ajax_collect_list');
               exit;
            }
            //$this->assign('store_class', $store_class);//店铺分类

        }
			$this->assign('type',$type);// 赋值分页输出
            $this->display();
    }

    /*
     *取消收藏
     */
    public function cancel_collect()
    {
        $collect_id = I('collect_id');
        $user_id = $this->user_id;
        if (M('goods_collect')->where("collect_id = $collect_id and user_id = $user_id")->delete()) {
            $this->success("取消收藏成功", U('User/collect_list'));
        } else {
            $this->error("取消收藏失败", U('User/collect_list'));
        }
    }


    /**
     *  删除一个收藏店铺
     */
    public function del_store_collect(){
        $id = I('get.log_id');
        if(!$id)
            $this->error("缺少ID参数");
        $store_id = M('store_collect')->where(array('log_id'=>$id,'user_id'=>$this->user_id))->getField('store_id');
        $row = M('store_collect')->where(array('log_id'=>$id,'user_id'=>$this->user_id))->delete();
        M('store')->where(array('store_id' => $store_id))->setDec('store_collect');
        if(!$row)
            $this->error("取消收藏失败");
        $this->success('取消收藏成功');
    }


    public function message_list()
    {
        C('TOKEN_ON', true);
        if (IS_POST) {
            $this->verifyHandle('message');

            $data = I('post.');
            $data['user_id'] = $this->user_id;
            $user = session('user');
            $data['user_name'] = $user['nickname'];
            $data['msg_time'] = time();
            if (M('feedback')->add($data)) {
                $this->success("留言成功", U('User/message_list'));
                exit;
            } else {
                $this->error('留言失败', U('User/message_list'));
                exit;
            }
        }
        $msg_type = array(0 => '留言', 1 => '投诉', 2 => '询问', 3 => '售后', 4 => '求购');
        $count = M('feedback')->where("user_id=" . $this->user_id)->count();
        $Page = new Page($count, 100);
        $Page->rollPage = 2;
        $message = M('feedback')->where("user_id=" . $this->user_id)->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $showpage = $Page->show();
        header("Content-type:text/html;charset=utf-8");
        $this->assign('page', $showpage);
        $this->assign('message', $message);
        $this->assign('msg_type', $msg_type);
        $this->display();
    }

    public function points()
    {
    	$type = I('type','all');
    	$this->assign('type',$type);
            $where['user_id']=$this->user_id;
			if($type!='all'){
			$where['types']=$type;	
			}
    		$count = M('account_log')->where($where)->count();
    		$Page = new Page($count, 16);
    		$account_log = M('account_log')->where($where)->order('log_id desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
    
		$showpage = $Page->show();
        $this->assign('account_log', $account_log);
        $this->assign('page', $showpage);
        if ($_GET['is_ajax']) {
            $this->display('ajax_points');
            exit;
        }
        $this->display();
    }

    /*
     * 密码修改
     */
    public function password()
    {
        //检查是否第三方登录用户
        $logic = new UsersLogic();
        $data = $logic->get_info($this->user_id);
        $user = $data['result'];
        if ($user['mobile'] == '' && $user['email'] == '')
            $this->error('请先到电脑端绑定手机', U('/Mobile/User/index'));
        if (IS_POST) {
            $userLogic = new UsersLogic();
            $data = $userLogic->password($this->user_id, I('post.old_password'), I('post.new_password'), I('post.confirm_password')); // 获取用户信息
            if ($data['status'] == -1)
                $this->error($data['msg']);
            $this->success($data['msg']);
            exit;
        }
        $this->display();
    }

    function forget_pwd()
    {
        if ($this->user_id > 0) {
            header("Location: " . U('User/Index'));
        }
        $username = I('username');
        if (IS_POST) {
            if (!empty($username)) {
                $this->verifyHandle('forget');
                $field = 'mobile';
                if (check_email($username)) {
                    $field = 'email';
                }
                $user = M('users')->where("email='$username' or mobile='$username'")->find();
                if ($user) {
                    session('find_password', array('user_id' => $user['user_id'], 'username' => $username,
                        'email' => $user['email'], 'mobile' => $user['mobile'], 'type' => $field));
                    header("Location: " . U('User/find_pwd'));
                    exit;
                } else {
                    $this->error("用户名不存在，请检查");
                }
            }
        }
        $this->display();
    }

    function find_pwd()
    {
        if ($this->user_id > 0) {
            header("Location: " . U('User/Index'));
        }
        $user = session('find_password');
        if (empty($user)) {
            $this->error("请先验证用户名", U('User/forget_pwd'));
        }
        $this->assign('user', $user);
        $this->display();
    }


    public function set_pwd()
    {
        if ($this->user_id > 0) {
            header("Location: " . U('User/Index'));
        }
        $check = session('validate_code');
        if (empty($check)) {
            header("Location:" . U('User/forget_pwd'));
        } elseif ($check['is_check'] == 0) {
            $this->error('验证码还未验证通过', U('User/forget_pwd'));
        }
        if (IS_POST) {
            $password = I('post.password');
            $password2 = I('post.password2');
            if ($password2 != $password) {
                $this->error('两次密码不一致', U('User/forget_pwd'));
            }
            if ($check['is_check'] == 1) {
                //$user = get_user_info($check['sender'],1);
                $user = M('users')->where("mobile = '{$check['sender']}' or email = '{$check['sender']}'")->find();
                M('users')->where("user_id=" . $user['user_id'])->save(array('password' => encrypt($password)));
                session('validate_code', null);
                //header("Location:".U('User/set_pwd',array('is_set'=>1)));
                $this->success('新密码已设置,牢记新密码', U('User/index'));
                exit;
            } else {
                $this->error('验证码还未验证通过', U('User/forget_pwd'));
            }
        }
        $is_set = I('is_set', 0);
        $this->assign('is_set', $is_set);
        $this->display();
    }

    //发送验证码
    public function send_validate_code()
    {
		if($_SERVER["HTTP_HOST"]!="www.yjy141319.com"){//www.yjy141319.com
		  exit(json_encode(array('status'=>-1,'msg'=>'提示:验证码发送失败')));	
		}
        $type = I('type');
        $send = I('send');
        $logic = new UsersLogic();
        exit(json_encode($logic->send_validate_code($send, $type,$this->session_id)));
    }

    public function check_validate_code()
    {
        $code = I('post.code');
        $send = I('send');
        $logic = new UsersLogic();
        $logic->check_validate_code($code, $send);
    }

    /**
     * 验证码验证
     * $id 验证码标示
     */
    private function verifyHandle($id)
    {
        $verify = new Verify();
        if (!$verify->check(I('post.verify_code'), $id ? $id : 'user_login')) {
            $this->error("验证码错误");
        }
    }

    /**
     * 验证码获取
     */
    public function verify()
    {
        //验证码类型
        $type = I('get.type') ? I('get.type') : 'user_login';
        $config = array(
            'fontSize' => 40,
            'length' => 4,
            'useCurve' => true,
            'useNoise' => false,
        );
        $Verify = new Verify($config);
        $Verify->entry($type);
    }

    /**
     * 账户管理
     */
    public function accountManage()
    {
        $this->display();
    }

    public function order_confirm()
    {
        $id = I('get.id', 0);
        $data = confirm_order($id,$this->user_id);
        if (!$data['status'])
            $this->error($data['msg']);
        else
            $this->success($data['msg']);
    }

    /**
     * 申请退货
     */
    public function return_goods()
    {
        $order_id = I('order_id', 0);
        $order_sn = I('order_sn', 0);
        $goods_id = I('goods_id', 0);
        $spec_key = I('spec_key');
        
        $c = M('order')->where("order_id = $order_id and user_id = {$this->user_id}")->count();
        if($c == 0)
        {
            $this->error('非法操作');
            exit;
        }          
        
        $return_goods = M('return_goods')->where("order_id = $order_id and goods_id = $goods_id and spec_key = '$spec_key'")->find();
        if (!empty($return_goods)) {
            $this->success('已经提交过退货申请!', U('Mobile/User/return_goods_info', array('id' => $return_goods['id'])));
            exit;
        }
        if (IS_POST) {

            // 晒图片
            if ($_FILES[return_imgs][tmp_name][0]) {
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = $map['author'] = (1024 * 1024 * 3);// 设置附件上传大小 管理员10M  否则 3M
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->rootPath = './Public/upload/return_goods/'; // 设置附件上传根目录
                $upload->replace = true; // 存在同名文件是否是覆盖，默认为false
                //$upload->saveName  =  'file_'.$id; // 存在同名文件是否是覆盖，默认为false
                // 上传文件
                $upinfo = $upload->upload();
                if (!$upinfo) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                } else {
                    foreach ($upinfo as $key => $val) {
                        $return_imgs[] = '/Public/upload/return_goods/' . $val['savepath'] . $val['savename'];
                    }
                    $data['imgs'] = implode(',', $return_imgs);// 上传的图片文件
                }
            }

            $data['order_id'] = $order_id;
            $data['order_sn'] = $order_sn;
            $data['goods_id'] = $goods_id;
            $data['addtime'] = time();
            $data['user_id'] = $this->user_id;
            $data['type'] = I('type'); // 服务类型  退货 或者 换货
            $data['reason'] = I('reason'); // 问题描述     
            $data['spec_key'] = I('spec_key'); // 商品规格						       
            M('return_goods')->add($data);
            $this->success('申请成功,客服第一时间会帮你处理', U('Mobile/User/order_list'));
            exit;
        }

        $goods = M('goods')->where("goods_id = $goods_id")->find();
        $this->assign('goods', $goods);
        $this->assign('order_id', $order_id);
        $this->assign('order_sn', $order_sn);
        $this->assign('goods_id', $goods_id);
        $this->display();
    }

    /**
     * 退换货列表
     */
    public function return_goods_list()
    {
        $count = M('return_goods')->where("user_id = {$this->user_id}")->count();
        $page = new Page($count, 4);
        $list = M('return_goods')->where("user_id = {$this->user_id}")->order("id desc")->limit("{$page->firstRow},{$page->listRows}")->select();
        $goods_id_arr = get_arr_column($list, 'goods_id');
        if (!empty($goods_id_arr))
            $goodsList = M('goods')->where("goods_id in (" . implode(',', $goods_id_arr) . ")")->getField('goods_id,goods_name');
        $this->assign('goodsList', $goodsList);
        $this->assign('list', $list);
        $this->assign('page', $page->show());// 赋值分页输出                    	    	
        if ($_GET['is_ajax']) {
            $this->display('return_ajax_goods_list');
            exit;
        }
        $this->display();
    }

    /**
     *  退货详情
     */
    public function return_goods_info()
    {
        $id = I('id', 0);
        $return_goods = M('return_goods')->where("id = $id")->find();
        if ($return_goods['imgs'])
            $return_goods['imgs'] = explode(',', $return_goods['imgs']);
        $goods = M('goods')->where("goods_id = {$return_goods['goods_id']} ")->find();
        $this->assign('goods', $goods);
        $this->assign('return_goods', $return_goods);
        $this->display();
    }
    
    public  function recharge(){
       	$order_id = I('order_id');
        $paymentList = M('Plugin')->where("`type`='payment' and code!='cod' and code!='yue' and status = 1 and  scene in(0,1)")->select();   
 
        //微信浏览器
//        if(strstr($_SERVER['HTTP_USER_AGENT'],'MicroMessenger')){
//            $paymentList = M('Plugin')->where("`type`='payment' and status = 1 and code='weixin'")->select();            
//        }        
        $paymentList = convert_arr_key($paymentList, 'code');

        foreach($paymentList as $key => $val)
        {
            $val['config_value'] = unserialize($val['config_value']);
            if($val['config_value']['is_bank'] == 2)
            {
                $bankCodeList[$val['code']] = unserialize($val['bank_code']);
            }
        }
        $bank_img = include 'Application/Home/Conf/bank.php'; // 银行对应图片
        $payment = M('Plugin')->where("`type`='payment' and status = 1")->select();
        $this->assign('paymentList',$paymentList);
        $this->assign('bank_img',$bank_img);
        $this->assign('bankCodeList',$bankCodeList);
        
        if($order_id>0){
        	$order = M('recharge')->where("order_id = $order_id")->find();    
        	$this->assign('order',$order);
        }    
    	$this->display();
    }
    /**
     * 申请提现记录
     */
    public function withdrawals(){

        C('TOKEN_ON',true);
        if(IS_POST)
        {
            $this->verifyHandle('withdrawals');
            $data = I('post.');
            $data['user_id'] = $this->user_id;
            $data['create_time'] = time();
            $distribut_min = tpCache('distribut.sys_user_min_amount'); // 最少提现额度
			$bili = tpCache('distribut.sys_user_fee'); // 最少提现额度
			
            if($data['money'] < $distribut_min)
            {
                $this->error('每次最少提现额度'.$distribut_min);
                exit;
            }
            if($data['money'] > $this->user['user_money'])
            {
                $this->error("你最多可提现{$this->user['user_money']}账户余额.");
                exit;
            }
            $fee=$data['money']*$bili*0.0001;
			if($fee<=2){
			$fee=2;
			}
			$data["fee"]=$data['money']-$fee;
			$data["handling"]=$bili;
			$data["sxf"]=$fee;
            if(M('withdrawals')->add($data)){
                $this->success("已提交申请");
                exit;
            }else{
                $this->error('提交失败,联系客服!');
                exit;
            }
        }

        $where = " user_id = {$this->user_id}";
        $count = M('withdrawals')->where($where)->count();
        $page = new Page($count,16);
        $list = M('withdrawals')->where($where)->order("id desc")->limit("{$page->firstRow},{$page->listRows}")->select();

        $this->assign('page', $page->show());// 赋值分页输出
        $this->assign('list',$list); // 下线
        if($_GET['is_ajax'])
        {
            $this->display('ajaxx_withdrawals_list');
            exit;
        }
        $this->display();
    }

//手机门店信息
    public function merchant_list()
    {
        C('TOKEN_ON', true);
        $m_info = M('store')->where("user_id=" . $this->user_id)->find();
        if (IS_POST) {
            $this->verifyHandle('merchant');
            $data = I('post.');
            $data['store_name'] = $m_info['store_name'];
            $data['store_user_name'] = $m_info['store_user_name'];
            $data['store_phone'] = $m_info['store_phone'];
            $data['store_address'] = $m_info['store_address'];
            $data['user_id'] = $this->user_id;
            $data['addtime'] = time();
			if($m_info){
			  $info=M('store')->where("user_id=" . $this->user_id)->save($data);	
			}
            if($info) {
                $this->success("操作成功", U('User/index'));
                exit;
            } else {
                $this->error('操作失败', U('User/merchant_list'));
                exit;
            }
        }

        $this->assign('m_info', $m_info);
        $this->display();
    }
    /*** 推广中心 */
    public function tuiguang(){
     $u_qrcode = @getimagesize('Public/qrcode/'.$this->user_id.'.png');
    // if (!$u_qrcode) {
        generate_qrcode("http://".$_SERVER ['HTTP_HOST'].U('Mobile/user/reg',array('t_id'=>$this->user_id)),"Public/qrcode/".$this->user_id.'.png');
   // }
     $u_haibao = @getimagesize('Public/haibao/'.$this->user_id.'.png');
     $tuiguang=I('tuiguang',0);
	 if (!$u_haibao || $tuiguang) {//生成海报
		
    header("content-type: image/png");//如果要看报什么错，可以先注释调这个header  
    $nickname = "我是文字";//微信昵称  
    $erweimaurl = 'Public/qrcode/'.$this->user_id.'.png';//二维码  
    $logourl = "Public/haibao/tuo.png";//微信头像      
    $beijing = 'Public/haibao/haibao1.png';//海报最底层得背景
    $beijing = imagecreatefrompng($beijing);  
    $logourl = imagecreatefrompng($logourl);  
    $erweimaurl = imagecreatefrompng($erweimaurl);  
    $image_3 = imageCreatetruecolor(imagesx($beijing),imagesy($beijing));  
    $color = imagecolorallocate($image_3, 255, 255, 255);  
    imagefill($image_3, 0, 0, $color);  
    //imageColorTransparent($image_3, $color); //颜色透明
    imagecopyresampled($image_3,$beijing,0,0,0,0,imagesx($beijing),imagesy($beijing),imagesx($beijing),imagesy($beijing));     
    //字体颜色  
    $white = imagecolorallocate($image_3, 111, 255, 255);  
    $rqys =  imagecolorallocate($image_3, 255, 0, 0);  
    $black = imagecolorallocate($image_3,120,84,26);  
    $font = "Public/haibao/123.otf";  //写的文字用到的字体。字体最好用系统有得，否则会包charmap的错，这是黑体   
    //imagettftext设置生成图片的文本      
    //imagettftext($image_3,32,0,240,50,$rqys,$font,$nickname);  
    //imagecopymerge($image_3,$logourl, 0,0,0,0,200,300,100);//左，上，右，下，宽度，高度，透明度  
  //  imagecopymerge($image_3,$erweimaurl, 203,532,12,12,imagesx($erweimaurl)-24,imagesy($erweimaurl)-24,100);  
     imagecopymerge($image_3,$erweimaurl, 304,165,12,12,160,160,100);  
    //生成图片  
    //imagepng($image_3);//在浏览器上显示  
    imagepng($image_3,"Public/haibao/".$this->user_id.".png");//保存到本地  
    //imagedestroy($im);  
	 }
        $this->display();
    }
	

    /*** 我的团队 */
    public function tuandui()
    {
      $one=M('users a')->field('a.*,b.level_name')->join('left join ty_user_level b ON a.level = b.level_id')->where("zupu like '{$this->user["zupu"]}%' and zuceng=".($this->user['zuceng']+1))->select();
      $two=M('users a')->field('a.*,b.level_name')->join('left join ty_user_level b ON a.level = b.level_id')->where("zupu like '{$this->user["zupu"]}%' and zuceng=".($this->user["zuceng"]+2))->select();
        $this->assign('one', $one);
		$this->assign('two', $two);
        $this->display();
    }
	
	
	
    /*** 热积分转余额 */
	
    public function jifeng_yue()
    {
		if(I('post.')){
		  header('Content-Type:application/json');
		  $pay_points=I('post.pay_points');
		  $point_xianjin=tpCache('distribut.point_xianjin');
		  
		  if(!$point_xianjin){exit(json_encode(array('code'=>0,'msg'=>'平台'.tpCache('distribut.hot_jifeng_name').'转换功能已关闭')));}
		  $m_info = M('users')->where("user_id=" . $this->user_id ." and pay_points>=".$pay_points)->getField('mobile');
		  //M()->getLastSql()
		  if(!$m_info){exit(json_encode(array('code'=>0,'msg'=>'您的'.tpCache('distribut.hot_jifeng_name').'可用余额不足')));}
		  if($pay_points<$point_xianjin){exit(json_encode(array('code'=>0,'msg'=>tpCache('distribut.hot_jifeng_name').'最少'.$point_xianjin.'起转换')));}
		  if(($pay_points % $point_xianjin)){exit(json_encode(array('code'=>0,'msg'=>tpCache('distribut.hot_jifeng_name').'转换必须为'.$point_xianjin.'的倍数')));}
		  //转换价格
		  $money=$pay_points / $point_xianjin;
		  accountLog($this->user_id,$money,'user_money','积分转钱',$pay_points,0,'消耗'.$pay_points.'积分'); // 记录日志流水
		  accountLog($this->user_id,$pay_points*-1,'pay_points','积分转钱',$money,0,'增加'.$money.'余额'); // 记录日志流水
		  exit(json_encode(array('code'=>1,'msg'=>tpCache('distribut.jifeng_name').'转换成功')));
		}
		$this->assign('user_id',$this->user_id);
        $this->display();
    }	
	
    /*** 积分转赠 */
    public function jifeng_zs()
    {
		if(I('post.')){
		  header('Content-Type:application/json');
		  $pay_points=I('post.pay_points');
		  $user=I('post.user');
		  $point_xianjin=tpCache('distribut.sys_jifeng_zs');
		  if(!$point_xianjin){exit(json_encode(array('code'=>0,'msg'=>'平台'.tpCache('distribut.hot_jifeng_name').'转赠功能已关闭')));}
		  $u_info = M('users')->where("mobile=$user")->getField('user_id');
		  if(!$u_info){exit(json_encode(array('code'=>0,'msg'=>'转入帐号不存在','inp'=>'user')));}
		  $m_info = M('users')->where("user_id=" . $this->user_id ." and pay_points>=".$pay_points)->getField('mobile');
		  //echo M()->getLastSql();
		  if(!$m_info){exit(json_encode(array('code'=>0,'msg'=>'您的'.tpCache('distribut.hot_jifeng_name').'可用余额不足','inp'=>'pay_points')));}
		  accountLog($this->user_id,$pay_points*-1,'pay_points' , "积分转赠",0,$u_info,'转入帐号:'.$user); // 扣除
		  accountLog($u_info,$pay_points,'pay_points' , "积分转赠",0,$this->user_id,'转出帐号:'.$this->user['mobile']); // 增加
		  exit(json_encode(array('code'=>1,'msg'=>tpCache('distribut.jifeng_name').'转赠成功')));
		}
        $this->display();
    }
    /*** 完善资料 */
    public function ziliao_ws(){
        if (IS_POST) {
            $userLogic = new UsersLogic();
            if ($_FILES[comment_img_file][tmp_name][0]) {
                $upload = new \Think\Upload();// 实例化上传类
                $upload->maxSize = $map['author'] = (1024 * 1024 * 3);// 设置附件上传大小 管理员10M  否则 3M
                $upload->exts = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
                $upload->rootPath = './Public/upload/comment/'; // 设置附件上传根目录
                $upload->replace = true; // 存在同名文件是否是覆盖，默认为false
                //$upload->saveName  =  'file_'.$id; // 存在同名文件是否是覆盖，默认为false
                // 上传文件
                $upinfo = $upload->upload();
                if (!$upinfo) {// 上传错误提示错误信息
                    $this->error($upload->getError());
                } else {
                    foreach ($upinfo as $key => $val) {
                        $comment_img[] = '/Public/upload/comment/' . $val['savepath'] . $val['savename'];
                    }
                    $data['all_img'] = serialize($comment_img); // 上传的图片文件
                }
            }
            I('post.nickname') ? $data['nickname'] = I('post.nickname') : false; //昵称
			I('post.name') ? $data['name'] = I('post.name') : false; //姓名
			I('post.sfz') ? $data['sfz'] = I('post.sfz') : false; //姓名
            I('post.sex') ? $data['sex'] = I('post.sex') : false;  // 性别
            I('post.email') ? $data['email'] = I('post.email') : false; //邮箱
            I('post.mobile') ? $data['mobile'] = I('post.mobile') : false; //手机
			I('post.is_sq') ? $data['is_sq'] = I('post.is_sq') : false; 
			
		if(tpCache('distribut.debt_switch') && $this->user['level']){//自动处理升级
		   $data['level'] =2;
		}
			
			
            $email = I('post.email');
            //$mobile = I('post.mobile');
            $code = I('post.mobile_code', '');

            if (!empty($email)) {
                $c = M('users')->where("email = '{$post['email']}' and user_id != {$this->user_id}")->count();
                $c && $this->error("邮箱已被使用");
            }
            if (!empty($mobile)) {
                $c = M('users')->where("mobile = '{$post['mobile']}' and user_id != {$this->user_id}")->count();
                $c && $this->error("手机已被使用");
//                if (!$code)
//                    $this->error('请输入验证码');
//                $check_code = $userLogic->sms_code_verify($mobile, $code, $this->session_id);
//                if ($check_code['status'] != 1)
//                    $this->error($check_code['msg']);
            }

            if (!$userLogic->update_info($this->user_id, $data))
                $this->error("保存失败");
            $this->success("操作成功");
            exit;
        }
        $this->display();
    }	
	
	
    /*** 购买积分 */
    public function jifeng_buy(){
		
		$ji_feng["a0"]=(M('account_log')->where("types=2 and user_id=0")->sum('money'));//平台金分池
		$ji_feng["b0"]=(M('users')->sum('pay_points'));//+用户现有
		$ji_feng["b0"]=$ji_feng["b0"]-$ji_feng["a0"];
		$ji_feng["a0"]=$ji_feng["a0"]*2;//购买平台总生成额度
		$jinchi= M('bonus_rule')->where("is_show=1 and is_new=0 and jifeng>=".($ji_feng["a0"]+$ji_feng["b0"]))->order('sort asc')->getfield('jifeng');//平台金分池
		
		$ji_feng["a1"]=$jinchi*tpCache('distribut.point_gongsibili')*0.01;//获取平台积分池达标额度
		$ji_feng["b1"]=$jinchi*tpCache('distribut.point_hehuorbili')*0.01;//获取用户积分池达标额度

		if(I('post.')){
		  header('Content-Type:application/json');
		  $pay_points=I('post.pay_points');
		  $user=I('post.user');
		  $fangshi=I('post.fangshi');
		  $point_shifang_leng=tpCache('distribut.point_shifang_leng');
		  $jifeng=$point_shifang_leng*$pay_points;
		  if(!$point_shifang_leng){exit(json_encode(array('code'=>0,'msg'=>'平台已关闭购买'.tpCache('distribut.jifeng_name').'功能')));}		  
		  if($fangshi){
			 if($ji_feng["b0"]>=$ji_feng["b1"]){exit(json_encode(array('code'=>0,'msg'=>'合伙人'.tpCache('distribut.jifeng_name').'池已达标，请选择平台方式','inp'=>'pay_points')));}
		     $u_info = M('users')->where("mobile=$user and level>1")->Field('user_id,cold_points')->find();
		     if(!$u_info){exit(json_encode(array('code'=>0,'msg'=>'您输入帐号不存在或不是合伙人','inp'=>'user')));}
			 if($u_info["cold_points"]<$jifeng){exit(json_encode(array('code'=>0,'msg'=>'合伙人'.tpCache('distribut.jifeng_name').'不足','inp'=>'user')));}
		  }else{
			 if($ji_feng["a0"]>=$ji_feng["a1"]){exit(json_encode(array('code'=>0,'msg'=>'平台'.tpCache('distribut.jifeng_name').'池已达标，请选择合伙人方式','inp'=>'pay_points')));}
			 $u_info["user_id"]=0;  
		  }
		  $m_info = M('users')->where("user_id=" . $this->user_id ." and user_money>=".$pay_points)->getField('mobile');
		  //M()->getLastSql()
		  if(!$m_info){exit(json_encode(array('code'=>0,'msg'=>'您的可用余额不足','inp'=>'pay_points')));}
		  accountLog($this->user_id,$pay_points*-1,'user_money' , "购买积分",$jifeng,0,'积分增加：'.$jifeng); // 扣除
		  accountLog($this->user_id,$jifeng,'pay_points' , "购买积分",$pay_points,0,'消耗'.$pay_points.'余额'); // 增加热积分
		  accountLog(0,$pay_points,'user_money' , "购买积分",$jifeng,$this->user_id,'编号'.$this->user_id.'购买积分'.$jifeng); //平台增加余额
		  if($u_info["user_id"]){
		     accountLog($u_info["user_id"],$jifeng*-1,'cold_points' , "购买积分",$pay_points,$this->user_id,$this->user['mobile'].'购入,您释放热积分'); // 扣除冷积分
			 accountLog($u_info["user_id"],$jifeng,'pay_points' , "购买积分",$pay_points,$this->user_id,'由冷积分释放到热积分'); // 热积分
		  }else{
		     accountLog($u_info["user_id"],$jifeng,'pay_points' , "购买积分",$pay_points,$this->user_id,$this->user['mobile'].'购入,平台积分池增加'); // 热积分
		  }
		  exit(json_encode(array('code'=>1,'msg'=>tpCache('distribut.jifeng_name').'购买成功')));
		}
		$this->assign('jifeng',$ji_feng);
        $this->display();
    }	
		
    /*** 激活积分 */
    public function jifeng_jihuo()
    {
		if(I('post.')){
		  header('Content-Type:application/json');
		  $point_yue_jifeng=tpCache('distribut.point_yue_jifeng');
		  $point_shifang_gq=tpCache('distribut.point_shifang_gq');
		  if(!$point_yue_jifeng){exit(json_encode(array('code'=>0,'msg'=>'平台激活'.tpCache('distribut.cold_jifeng_name').'功能已关闭')));}
		  $m_info = M('users')->where("user_id=$this->user_id")->Field('user_money,dai_points')->find();
		  if($m_info['user_money']<$point_yue_jifeng){exit(json_encode(array('code'=>0,'msg'=>$m_info['user_money'].'您的帐户可用余额不足')));}
		 
		  $jifeng=$point_yue_jifeng*tpCache('distribut.point_shifang');
		  if($m_info['dai_points']<$jifeng){exit(json_encode(array('code'=>0,'msg'=>'您的帐户待释放'.tpCache('distribut.jifeng_name').'额度不足')));}

		  accountLog($this->user_id,$point_yue_jifeng*-1,'user_money','激活积分',$jifeng,0,'增加'.$jifeng.'冷积分'); // 扣除余额
          accountLog($this->user_id,$point_yue_jifeng*tpCache('distribut.point_shifang_leng'),'pay_points','激活积分',$jifeng,0,'增加'.$point_yue_jifeng*tpCache('distribut.point_shifang_leng').'热元宝'); // 用户增加热元宝
          accountLog(0,$point_yue_jifeng*tpCache('distribut.point_shifang_leng'),'pay_points','激活积分',$jifeng,0,'增加'.$point_yue_jifeng*tpCache('distribut.point_shifang_leng').'热元宝'); // 平台增加热元宝
		  accountLog($this->user_id,$jifeng*-1,'dai_points' , "激活积分",$point_yue_jifeng,0,'消耗'.$point_yue_jifeng.'余额'); // 扣除额度
		  accountLog($this->user_id,$jifeng,'cold_points' , "激活积分",$point_yue_jifeng,0,'消耗'.$jifeng.'待释放额度'); // 扣除额度
		  accountLog(0,$point_yue_jifeng,'user_money' , "激活积分",$jifeng,$this->user_id,'编号'.$this->user_id.'激活积分'.$jifeng); //平台增加余额
		  if($point_shifang_gq){accountLog($this->user_id,$point_shifang_gq,'equity' , "激活积分",$point_yue_jifeng,0,"赠送股权");} // 赠送
		  exit(json_encode(array('code'=>1,'msg'=>'激活成功'.$jifeng.tpCache('distribut.jifeng_name'))));
		}
        $this->display();
    }	
	
    /*
     * 债务债权列表
     */
    public function zwzq_list(){
        $this->assign('lists',M('user_zwzq')->where("user_id =".$this->user_id)->order("id desc")->select());
        $this->display();
    }

    /*
     * 添加债务债权
     */
    public function add_zwzq()
    {
        if (IS_POST) {
            $logic = new UsersLogic();
            $data = $logic->add_zwzq($this->user_id, 0, I('post.'));
            if ($data['status'] != 1)
                $this->error($data['msg']);

            $this->success($data['msg'], U('/Mobile/User/zwzq_list'));
            exit();
        }

        $this->display();

    }

    /*
     * 债务债权编辑
     */
    public function edit_zwzq()
    {
        $id = I('id');
        $address = M('user_zwzq')->where(array('id' => $id, 'user_id' => $this->user_id))->find();
        $this->assign('address', $address);
        $this->display();
    }
	
}