<?php

namespace Mobile\Controller;
use Home\Logic\CartLogic;
use Think\Controller;
use Think\Page;
use Think\Verify;
class ArticleController extends MobileBaseController {
    public function index(){       
        $article_id = I('article_id',19);
    	$article = M('article')->where("article_id=".$article_id)->find();
    	$this->assign('article',$article);
        $this->display();
    }

    /**
     * 文章内列表页
     */
    public function alist(){   
		$this->assign('title',$lid?:"资讯信息");
		$lei = M('article_cat')->where("show_in_nav=1 and parent_id=1")->order('sort_order desc')->select();
    	$this->assign('lei',$lei);

    	$lid = I('lid','all');
    	$this->assign('lid',$lid);
			if($lid!='all'){$where['cat_id']=$lid;	}
    		$count = M('Article')->where($where)->count();
    		$Page = new Page($count, 1);
    		$a_list = M('Article')->where($where)->order('article_id desc')->limit($Page->firstRow . ',' . $Page->listRows)->select();
		$showpage = $Page->show();
        $this->assign('a_list', $a_list);
        $this->assign('page', $showpage);
        if ($_GET['is_ajax']){exit($this->display('ajax_alist'));}
        $this->display();
    }    
    /**
     * 文章内容页
     */
    public function article(){
    	$article_id = I('article_id',1);
    	$article = D('article')->where("article_id=$article_id")->find();
    	$this->assign('article',$article);
        $this->display();
    }     
}